<?php

/*
 * Autor: Jamith Bolaños Vidal
 * Fecha: 08/07/2015
 * Modelo que realiza el acceso a los datos relacionado con la información del reporte de resultados
 */

class Reporte_tamizacion_model extends CI_Model {

    private $menu;

    function __construct() {
        parent::__construct();
    }

    function getReporteTamizacion($datos) {
        $inferior = (($datos->current - 1) * $datos->rowCount);
        $superior = $datos->rowCount;
        $this->db->start_cache();
        $this->db->distinct();
        $this->db->select('
            id_resultado,
            cedula,
            primer_nombre,
            primer_apellido,
            resultado_epidemiologica.telefono,
            resultado_epidemiologica.celular,
            resultado_epidemiologica.numero_documento,
            resultado_epidemiologica.vereda_direccion,
            pin_resultado_laboratorio.plan_atencion, 
            pin_resultado_laboratorio.fecha_toma, 
            pin_resultado_laboratorio.municipio,
            pin_resultado_laboratorio.eps, 
            pin_resultado_laboratorio.ips,
            calidad_muestra,
            fecha_nacimiento, 
            numero_documento,
            categorizacion_general, 
            hallazgos_no_neoplaticos, 
            anor_cel_escamosas, 
            anor_cel_glandulares,
            microorganismos, 
            obs_citologia, 
            validez_prueba_vph, 
            vph_genotipo_16, 
            vph_genotipo_18, 
            vph_otros, 
            obs_vph, 
            nombre_eps, 
            nombre_ips,
            \'\' as res_citologia,
            \'\' as resultado_vph', false);
        $this->db->from('pin_resultado_laboratorio');
        $this->db->join('resultado_epidemiologica', 'resultado_epidemiologica.numero_documento = pin_resultado_laboratorio.cedula  ','left');
        $this->db->join('pin_toma_citologia', 'pin_toma_citologia.numero_cedula = resultado_epidemiologica.numero_documento ','left');
        $this->db->join('par_eps', 'par_eps.id_eps = pin_resultado_laboratorio.eps ::int');
        $this->db->join('par_ips', 'par_ips.id_ips = pin_resultado_laboratorio.ips ::int');
        if ($datos->searchPhrase !== '') {
            $this->db->or_where("cast(numero_documento as varchar) like ('%" . $datos->searchPhrase . "%')");
            $this->db->or_where("UPPER(nombre_eps) like UPPER('%" . $datos->searchPhrase . "%')");
            $this->db->or_where("UPPER(nombre_ips) like UPPER('%" . $datos->searchPhrase . "%')");
            $this->db->or_where("UPPER(primer_nombre) like UPPER('%" . $datos->searchPhrase . "%')");
            $this->db->or_where("UPPER(primer_apellido) like UPPER('%" . $datos->searchPhrase . "%')");
        } //$this->db->order_by('id_indicador');d
        if ($this->session->userdata('id_ips') != '') { //si no es administrador
            $this->db->where('pin_resultado_laboratorio.ips', $this->session->userdata('id_ips'));
        }
        if ($this->session->userdata('id_eps') != '') { //si no es administrador
            $this->db->where('pin_resultado_laboratorio.eps', $this->session->userdata('id_eps'));
        }

        $this->db->stop_cache();
        $rows["total"] = $this->db->count_all_results();
        if (isset($datos->sort) && is_array($datos->sort)) {
            $order_by = '';
            foreach ($datos->sort as $key => $value)
                $order_by = $order_by . $key . ' ' . $value;
            $datos->order_by = $order_by;
        }
        if (isset($datos->order_by)) {
            $this->db->order_by($datos->order_by);
        }
        if ($datos->rowCount > 0) {
            $this->db->limit($superior, $inferior);
        }
        $consulta = $this->db->get();
        //inicio de consulta
        //$arrayResultadoInicial = $consulta->result();       
       
        $arrayResultado = array();
         $arrayResultado = $consulta->result();
        //inicio de consulta$consulta->result();
        if ($consulta->num_rows > 0) {//inicio IF 
            //Eliminar Datos  Repetidos
            $indice = 0;           
//            if (count($arrayResultadoInicial) === 1) {
//                $arrayResultado = $arrayResultadoInicial;
//            } else {
//                for ($i = 0; $i < count($arrayResultadoInicial) - 1; $i++) {
//                    if ($arrayResultadoInicial[$i]->cedula === $arrayResultadoInicial[$i + 1]->cedula && $arrayResultadoInicial[$i]->fecha_toma === $arrayResultadoInicial[$i + 1]->fecha_toma) {
//                    } else {
//                        $arrayResultado[$indice] = $arrayResultadoInicial[$i];
//                        $indice++;
//                    }
//                }
//                $ultimo = count($arrayResultadoInicial) - 1;
//              //  echo "cedulad el ultimo:".$arrayResultadoInicial[$ultimo]->cedula;
//                if (($arrayResultadoInicial[$ultimo]->cedula != $arrayResultadoInicial[$ultimo- 1]->cedula) || ($arrayResultadoInicial[$ultimo]->fecha_toma != $arrayResultadoInicial[$ultimo - 1]->fecha_toma)) {
//                   $arrayResultado[$indice] = $arrayResultadoInicial[$ultimo]; 
//                }
//            }
            for ($i = 0; $i < count($arrayResultado); $i++) {//if principal 
                $row = $arrayResultado[$i];
                $vph = "";


                if ($row->vph_genotipo_16 == 'Positivo') {
                    $vph = " VPH-16";
                }
                if ($row->vph_genotipo_18 == 'Positivo') {
                    $vph = $vph . " VPH-18";
                }
                if ($row->vph_otros == 'Positivo') {
                    $vph = $vph . " VPH-Otros";
                }
                if ($vph == "") {
                    $vph = "Negativo";
                }
                $row->resultado_vph = trim($vph);

                if ($row->telefono == 0) {
                    $row->telefono = $row->celular;
                }
                if ($row->calidad_muestra == 'Satisfactoria con endocervicales/zona de transformación' || $row->calidad_muestra == 'Satisfactoria sin endocervicales/zona de transformación') {//2
                    if ($row->categorizacion_general == 'Anormalidades en células epiteliales') {//Inicio if Categorizacion general
                        if ($row->anor_cel_escamosas == 'Células escamosas atípicas de significado ind. (ASC-US)') {
                            $row->res_citologia = 'ASC-US';
                        }
                        if ($row->anor_cel_escamosas == 'Células escamosas atípicas que no puede excluir HSIL (ASC-H)') {
                            $row->res_citologia = 'HSIL (ASC H)';
                        }
                        if ($row->anor_cel_escamosas == 'Lesión Intraepitelial escamosa de bajo grado (LSIL) - Cambios citopáticos por VPH') {
                            $row->res_citologia = 'LSIL-CAMBIOS CITOPÁTICOS POR VPH';
                        }
                        if ($row->anor_cel_escamosas == 'Lesión Intraepitelial escamosa de bajo grado (LSIL) - Displasia leve (NICI)') {
                            $row->res_citologia = 'LSIL-NIC I';
                        }
                        if ($row->anor_cel_escamosas == 'Lesión Escamosa intraepitelial de alto grado (HSIL) - NIC II') {
                            $row->res_citologia = 'HSIL - NIC II';
                        }
                        if ($row->anor_cel_escamosas == 'Lesión Escamosa intraepitelial de alto grado (HSIL) - NIC III') {
                            $row->res_citologia = 'HSIL-NIC-III';
                        }
                        if ($row->anor_cel_escamosas == 'Lesión Escamosa intraepitelial de alto grado (HSIL) - Ca In Situ') {
                            $row->res_citologia = 'HSIL-Ca In Situ';
                        }
                        if ($row->anor_cel_escamosas == 'HSIL sospechosa de invasión') {
                            $row->res_citologia = 'HSIL SOSPECHA DE INVASIÓN';
                        }
                        if ($row->anor_cel_escamosas == 'Carcinoma de células escamosas') {
                            $row->res_citologia = 'CARCINOMA CÉLULAS ESCAMOSAS';
                        } else {// inicio del Else anor_cel_escamosas si esta vacio
                            if ($row->anor_cel_escamosas == '') {//inicio del if anor_cel-escamosas si esta vacio
                                if ($row->anor_cel_glandulares == 'Células endocervicales atípicas (NOS)') {
                                    $row->res_citologia = 'ENDOCERV ATIPICAS - NOS';
                                }
                                if ($row->anor_cel_glandulares == 'Células endometriales atípicas (NOS)') {
                                    $row->res_citologia = 'ENDOMETRIALES ATIPICAS - NOS';
                                }
                                if ($row->anor_cel_glandulares == 'Células glandulares (NOS)') {
                                    $row->res_citologia = 'CEL GLANDULARES NOS';
                                }
                                if ($row->anor_cel_glandulares == 'Células endocervicales atípicas que favorecen neoplasia') {
                                    $row->res_citologia = 'ENDOCERV ATIPICAS FAVORECEN NEOPLASIA';
                                }
                                if ($row->anor_cel_glandulares == 'Células glandulares atípicas que favorecen neoplasia') {
                                    $row->res_citologia = 'GLANDULARES ATIPICAS FAVORECEN NEOPLACIA';
                                }
                                if ($row->anor_cel_glandulares == 'Adenocarcinoma endocervical in situ') {
                                    $row->res_citologia = 'ADENOCARCINOMA ENDOCERVICAL In Situ';
                                }
                                if ($row->anor_cel_glandulares == 'Adenocarcinoma endocervical') {
                                    $row->res_citologia = 'ADENOCARCINOMA ENDOCERVICAL';
                                }
                                if ($row->anor_cel_glandulares == 'Adenocarcinoma endometrial') {
                                    $row->res_citologia = 'ADENOCARCINOMA ENDOMETRIAL';
                                }
                                if ($row->anor_cel_glandulares == 'Adenocarcinoma extrauterino') {
                                    $row->res_citologia = 'ADENOCARCINOMA EXTRAUTERINO';
                                }
                                if ($row->anor_cel_glandulares == 'Adenocarcinoma (NOS)') {
                                    $row->res_citologia = 'ADENOCARCINOMA - NOS';
                                }
                                if ($row->anor_cel_glandulares == 'Otras neoplasias') {
                                    $row->res_citologia = 'OTRAS NEOPLASIAS';
                                }
                            }//fin del if anor_cel-escamosas si esta vacio
                        }//Fin else anor_cel_escamosas si esta vacio
                    }//Inicio if Categorizacion general 
                    else {
                        if ($row->categorizacion_general == 'Negativa para lesión intraepitelial o malignidad') {
                            $row->res_citologia = 'Negativo';
                        }
                    }
                }//Inicio  if General
                else{
                    $row->res_citologia = 'Insatisfactoria';
                    $row->resultado_vph = "Insatisfactoria";
                }
                unset($row->categorizacion_general);
                unset($row->calidad_muestra);
                unset($row->anor_cel_escamosas);
                unset($row->anor_cel_glandulares);
            }
        }
        $rows["current"] = $datos->current;
        $rows["rowCount"] = $datos->rowCount;
        $rows["rows"] = $arrayResultado;
        return json_encode($rows);
    }

//Fin function

    function getReporteTamizacionExportar() {
        $headers = array('Cédula', 'Nombre', 'Apellido', 'Telefono', 'Direccion', 'Fecha de toma','Clasificación', 'Fecha Nacimiento', 'Municipio', 'EPS', 'IPS', 'Fase','Resultado Citología', 'Resultado VPH');
        //$this->db->distinct();
        $this->db->select('cedula,
                    primer_nombre,
                    primer_apellido,
                    resultado_epidemiologica.celular,
                    resultado_epidemiologica.vereda_direccion,
                    pin_resultado_laboratorio.fecha_toma,
                    \'Primera vez\' as clasificacion,
                    fecha_nacimiento, 
                    pin_resultado_laboratorio.municipio,
                    nombre_eps,
                    nombre_ips,
                    pin_resultado_laboratorio.eps, 
                    pin_resultado_laboratorio.ips, 
                    pin_resultado_laboratorio.plan_atencion, 
                    \'\' as res_citologia,
                    \'\' as resultado_vph,
                    calidad_muestra,
                    categorizacion_general, 
                    hallazgos_no_neoplaticos, 
                    anor_cel_escamosas, 
                    anor_cel_glandulares,
                    microorganismos, 
                    obs_citologia, 
                    validez_prueba_vph, 
                    vph_genotipo_16, 
                    vph_genotipo_18, 
                    vph_otros', false);
        $this->db->from('pin_resultado_laboratorio');
        $this->db->join('resultado_epidemiologica', 'resultado_epidemiologica.numero_documento = pin_resultado_laboratorio.cedula','left');
        $this->db->join('pin_toma_citologia', 'pin_toma_citologia.numero_cedula = resultado_epidemiologica.numero_documento ','left');
        $this->db->join('par_eps', 'par_eps.id_eps = pin_resultado_laboratorio.eps ::int');
        $this->db->join('par_ips', 'par_ips.id_ips = pin_resultado_laboratorio.ips ::int');
        if ($this->session->userdata('id_ips') != '') { //si no es administrador
            $this->db->where('pin_resultado_laboratorio.ips', $this->session->userdata('id_ips'));
            if ($this->session->userdata('id_eps') != '') { //si no es administrador
                $this->db->where('pin_resultado_laboratorio.eps', $this->session->userdata('id_eps'));
            }
        }
        $this->db->order_by('cedula', 'fecha_toma');
        $consulta = $this->db->get();
        if ($consulta->num_rows > 0) {
            $tableResult[] = $headers;
            $banderaInicial = true;
            $cedulaAnterior = 0;
            foreach ($consulta->result() as $row) {
                $vph = "";
                if($banderaInicial){
                    $cedulaAnterior = $row->cedula;
                    $banderaInicial = false;
                }else{
                    if($cedulaAnterior === $row->cedula){
                        $row->clasificacion = 'Repetida';
                    }
                    $cedulaAnterior = $row->cedula;
                }
                if ($row->vph_genotipo_16 == 'Positivo') {
                    $vph = " VPH-16";
                }

                if ($row->vph_genotipo_18 == 'Positivo') {
                    $vph = $vph . " VPH-18";
                }
                if ($row->vph_otros == 'Positivo') {
                    $vph = $vph . " VPH-Otros";
                }

                if ($vph === "") {
                    $vph = "Negativo";
                }
                $row->resultado_vph = trim($vph);


                if ($row->calidad_muestra == 'Satisfactoria con endocervicales/zona de transformación' || $row->calidad_muestra == 'Satisfactoria sin endocervicales/zona de transformación') {//2
                    if ($row->categorizacion_general == 'Anormalidades en células epiteliales') {//Inicio if Categorizacion general
                        if ($row->anor_cel_escamosas == 'Células escamosas atípicas de significado ind. (ASC-US)') {
                            $row->res_citologia = 'ASC-US';
                        }
                        if ($row->anor_cel_escamosas == 'Células escamosas atípicas que no puede excluir HSIL (ASC-H)') {
                            $row->res_citologia = 'HSIL (ASC H)';
                        }
                        if ($row->anor_cel_escamosas == 'Lesión Intraepitelial escamosa de bajo grado (LSIL) - Cambios citopáticos por VPH') {
                            $row->res_citologia = 'LSIL-CAMBIOS CITOPÁTICOS POR VPH';
                        }
                        if ($row->anor_cel_escamosas == 'Lesión Intraepitelial escamosa de bajo grado (LSIL) - Displasia leve (NICI)') {
                            $row->res_citologia = 'LSIL-NIC I';
                        }
                        if ($row->anor_cel_escamosas == 'Lesión Escamosa intraepitelial de alto grado (HSIL) - NIC II') {
                            $row->res_citologia = 'HSIL - NIC II';
                        }
                        if ($row->anor_cel_escamosas == 'Lesión Escamosa intraepitelial de alto grado (HSIL) - NIC III') {
                            $row->res_citologia = 'HSIL-NIC-III';
                        }
                        if ($row->anor_cel_escamosas == 'Lesión Escamosa intraepitelial de alto grado (HSIL) - Ca In Situ') {
                            $row->res_citologia = 'HSIL-Ca In Situ';
                        }
                        if ($row->anor_cel_escamosas == 'HSIL sospechosa de invasión') {
                            $row->res_citologia = 'HSIL SOSPECHA DE INVASIÓN';
                        }
                        if ($row->anor_cel_escamosas == 'Carcinoma de células escamosas') {
                            $row->res_citologia = 'CARCINOMA CÉLULAS ESCAMOSAS';
                        } else {// inicio del Else anor_cel_escamosas si esta vacio
                            if ($row->anor_cel_escamosas == '') {//inicio del if anor_cel-escamosas si esta vacio
                                if ($row->anor_cel_glandulares == 'Células endocervicales atípicas (NOS)') {
                                    $row->res_citologia = 'ENDOCERV ATIPICAS - NOS';
                                }
                                if ($row->anor_cel_glandulares == 'Células endometriales atípicas (NOS)') {
                                    $row->res_citologia = 'ENDOMETRIALES ATIPICAS - NOS';
                                }
                                if ($row->anor_cel_glandulares == 'Células glandulares (NOS)') {
                                    $row->res_citologia = 'CEL GLANDULARES NOS';
                                }
                                if ($row->anor_cel_glandulares == 'Células endocervicales atípicas que favorecen neoplasia') {
                                    $row->res_citologia = 'ENDOCERV ATIPICAS FAVORECEN NEOPLASIA';
                                }
                                if ($row->anor_cel_glandulares == 'Células glandulares atípicas que favorecen neoplasia') {
                                    $row->res_citologia = 'GLANDULARES ATIPICAS FAVORECEN NEOPLACIA';
                                }
                                if ($row->anor_cel_glandulares == 'Adenocarcinoma endocervical in situ') {
                                    $row->res_citologia = 'ADENOCARCINOMA ENDOCERVICAL In Situ';
                                }
                                if ($row->anor_cel_glandulares == 'Adenocarcinoma endocervical') {
                                    $row->res_citologia = 'ADENOCARCINOMA ENDOCERVICAL';
                                }
                                if ($row->anor_cel_glandulares == 'Adenocarcinoma endometrial') {
                                    $row->res_citologia = 'ADENOCARCINOMA ENDOMETRIAL';
                                }
                                if ($row->anor_cel_glandulares == 'Adenocarcinoma extrauterino') {
                                    $row->res_citologia = 'ADENOCARCINOMA EXTRAUTERINO';
                                }
                                if ($row->anor_cel_glandulares == 'Adenocarcinoma (NOS)') {
                                    $row->res_citologia = 'ADENOCARCINOMA - NOS';
                                }
                                if ($row->anor_cel_glandulares == 'Otras neoplasias') {
                                    $row->res_citologia = 'OTRAS NEOPLASIAS';
                                }
                            }//fin del if anor_cel-escamosas si esta vacio
                        }//Fin else anor_cel_escamosas si esta vacio
                    }//Inicio if Categorizacion general 
                    else {
                        if ($row->categorizacion_general == 'Negativa para lesión intraepitelial o malignidad') {
                            $row->res_citologia = 'Negativo';
                        }
                    }
                }else{
                    $row->res_citologia = 'Insatisfactoria';
                    $row->resultado_vph = 'Insatisfactoria';
                }
                unset($row->ips);
                unset($row->eps);
                unset($row->microorganismos);
                //unset($row->plan_atencion);
                unset($row->obs_citologia);
                unset($row->hallazgos_no_neoplaticos);
                unset($row->categorizacion_general);
                unset($row->calidad_muestra);
                unset($row->anor_cel_escamosas);
                unset($row->anor_cel_glandulares);
                unset($row->vph_genotipo_16);
                unset($row->vph_genotipo_18);
                unset($row->validez_prueba_vph);
                unset($row->vph_otros);


                $tableResult[] = $row;
            }
            return $tableResult;
        } else {
            return null;
        }
    }

    function exportarRecomendacionesTamizadas() {
        $headers = array('CEDULA', 'FECHA/TOMA', 'ZONA', 'MUNICIPIO', 'EDAD', 'CALIDAD', 'CATEGORIZACION', 'CITOLOGÍA', 'VPH', 'KI67P16', 'RECOMENDACIÓN');
        $sql = "
        select distinct
        cedula, 
        fecha_toma, 
        case prl.municipio 
        when 'Buenos Aires' then 'Norte' 
        when 'Santander de Quilichao' then 'Norte' 
        when 'Guachene' then 'Norte'
        when 'Corinto' then 'Norte'
        when 'Puerto Tejada' then 'Norte'   
        when 'El Tambo' then 'Centro'
        when 'Piendamó' then 'Centro'
        when 'Totoró' then 'Centro'
        when 'Páez' then 'Centro'
        when 'Patía' then 'Sur'
        when 'San Sebastián' then 'Sur'
        when 'Florencia' then 'Sur'
        end as zona,
        prl.municipio, 
        fecha_nacimiento,	
        calidad_muestra,
        categorizacion_general,
        anor_cel_escamosas,
        anor_cel_glandulares,
        vph_genotipo_16, 
        vph_genotipo_18, 
        vph_otros,
        reactividad
        from 
        pin_resultado_laboratorio prl
        left join resultado_epidemiologica on (cedula = numero_documento)";
        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            $tableResult[] = $headers;
            foreach ($query->result() as $row) {
                $vph = "";
                if ($row->vph_genotipo_16 == 'Positivo') {
                    $vph = " VPH-16";
                }

                if ($row->vph_genotipo_18 == 'Positivo') {
                    $vph = $vph . " VPH-18";
                }
                if ($row->vph_otros == 'Positivo') {
                    $vph = $vph . " VPH-Otros";
                }

                if ($vph === "") {
                    $vph = "Negativo";
                }
                $table ['cedula'] = $row->cedula;
                $table ['fecha_toma'] = $row->fecha_toma;
                $table ['zona'] = $row->zona;
                $table ['municipio'] = $row->municipio;
                $table ['edad'] = $this->calcular_edad($row->fecha_nacimiento);
                $table ['calidad_muestra'] = $row->calidad_muestra;
                $table ['categorizacion'] = $row->categorizacion_general;
                $table ['citologia'] = $row->anor_cel_escamosas;
                $table ['vph'] = trim($vph);
                $table ['KI67p16'] = $row->reactividad;
                $table ['recomendacion'] = '';

                if (trim($row->categorizacion_general) === trim('Negativa para lesión intraepitelial o malignidad')) {
                    if ($row->vph_genotipo_16 == 'Negativo' && $row->vph_genotipo_18 == 'Negativo' && $row->vph_otros == 'Negativo') {
                        $table ['recomendacion'] = '1. Considerar la aplicación de la vacuna tetravalente contra el VPH (VPH-16,-18,-6,-11), dado que es elegible para el esquema de vacunación [NO ESTÁ CUBIERTA POR EL POS].2. Repetir co-test (Citología en base líquida + prueba de ADN para VPH) en cinco (5) años, a menos que su actividad sexual sea modificada o su médico considere que está en riesgo de haber adquirido la infección.';
                    } else {
                        if ($row->vph_otros == 'Positivo') {
                            $table ['recomendacion'] = 'Repetir co-test en doce (12) meses para establecer si la infección por VPH-Otros ha desaparecido (aclaramiento) ó aún persiste y ha generado una lesión preneoplásica del cuello uterino para su respectivo manejo, según criterio del médico tratante.';
                        } else {
                            if ($row->vph_genotipo_16 == 'Positivo' || $row->vph_genotipo_18 == 'Positivo') {
                                $table ['recomendacion'] = 'Remitir a colposcopia y biopsia para manejo según criterio del médico tratante.';
                            }
                        }
                    }
                } else {
                    if (trim($row->categorizacion_general) === trim('Anormalidades en células epiteliales') || trim($row->anor_cel_escamosas) === trim('Células escamosas atípicas de significado ind. (ASC-US)') || trim($row->anor_cel_escamosas) === trim('Lesión Intraepitelial escamosa de bajo grado (LSIL) - Displasia leve (NICI)') || trim($row->anor_cel_escamosas) === trim('Lesión Intraepitelial escamosa de bajo grado (LSIL) - Cambios citopáticos por VPH') || trim($row->anor_cel_glandulares) === trim('Células endocervicales atípicas (NOS)')) {
                        if ($row->vph_genotipo_16 == 'Negativo' && $row->vph_genotipo_18 == 'Negativo' && $row->vph_otros == 'Negativo') {
                            $table ['recomendacion'] = 'Repetir citología en base liquida en doce (12) meses para establecer si ha progresado o desaparecido la lesión preneoplásica del cuello uterino para su respectivo manejo, según criterio del médico tratante.';
                        } else {
                            if ($row->vph_otros == 'Positivo') {
                                $table ['recomendacion'] = 'Realizar prueba para marcadores pronóstico Ki67-p16 (marcaje dual) por inmunocitoquímica para la identificación temprana de lesiones pre-neoplásicas dada la presencia de la infección por VPH. Considerar la aplicación de la vacuna tetravalente contra el VPH (VPH-16,-18,-6,-11), dado que es elegible para el esquema de vacunación [NO ESTÁ CUBIERTA POR EL POS].';
                            } else {
                                if ($row->vph_genotipo_16 == 'Positivo' || $row->vph_genotipo_18 == 'Positivo') {
                                    $table ['recomendacion'] = 'Remitir a colposcopia y biopsia para manejo según criterio del médico tratante.';
                                }
                            }
                        }
                    } else {
                        if (trim($row->categorizacion_general) === trim('Anormalidades en células epiteliales') || trim($row->anor_cel_escamosas) === trim('Lesión Escamosa intraepitelial de alto grado (HSIL) - NIC II') || trim($row->anor_cel_escamosas) === trim('Lesión Escamosa intraepitelial de alto grado (HSIL) - NIC II') || trim($row->anor_cel_escamosas) === trim('Lesión Escamosa intraepitelial de alto grado (HSIL) - Ca In Situ') || trim($row->anor_cel_escamosas) === trim('HSIL sospechosa de invasión')) {
                            $table ['recomendacion'] = 'Remitir a colposcopia y biopsia para manejo según criterio del médico tratante.';
                        }
                    }
                }
                $tableResult[] = $table;
            }
            return $tableResult;
        } else {
            return null;
        }
    }

    function calcular_edad($fechanacimiento) {
        $date2 = date('Y-m-d'); //
        $diff = abs(strtotime($date2) - strtotime($fechanacimiento));
        $years = floor($diff / (365 * 60 * 60 * 24));
        return $years;
    }

}
