<?php

/*
 * Autor: Jamith Bolaños Vidal
 * Fecha: 08/07/2015
 * Modelo que realiza el acceso a los datos relacionado con la información del reporte de resultados
 */

class Gestion_positivas_model extends CI_Model {

    private $menu;

    function __construct() {
        parent::__construct();
    }

    function getPositivas($datos) {
        $inferior = (($datos->current - 1) * $datos->rowCount);
        $superior = $datos->rowCount;
        $this->db->start_cache();
        $this->db->select('distinct id_positivas,nombre, cedula, DATE_PART(\'YEAR\',AGE(FECHA_NACIMIENTO)) as edad, pin_positivas.telefono,pin_positivas.direccion, municipio, id_eps,resul_cito, resul_vph, fecha_toma, id_ips,conducta, pin_positivas.eps, pin_positivas.ips, estado, fecha_noti_eps, no_oficio, fecha_control_cotest, resultado_control, fecha_visita_domiciliaria, visita_domiciliaria, observaciones_eps, observaciones_pto, observaciones_sds', false);
        $this->db->distinct();
        $this->db->from('pin_positivas');
        $this->db->join('par_eps_homologa', 'par_eps_homologa.nombre_eps_homologa = pin_positivas.eps');
        $this->db->join('par_ips_homologa', 'par_ips_homologa.nombre_ips_homologa = pin_positivas.ips');
        if ($datos->searchPhrase !== '') {
            $this->db->or_where("UPPER(cedula) like UPPER('%" . $datos->searchPhrase . "%')");
            $this->db->or_where("UPPER(nombre) like UPPER('%" . $datos->searchPhrase . "%')");
            $this->db->or_where("UPPER(telefono) like UPPER('%" . $datos->searchPhrase . "%')");
            $this->db->or_where("UPPER(municipio) like UPPER('%" . $datos->searchPhrase . "%')");
            $this->db->or_where("UPPER(direccion) like UPPER('%" . $datos->searchPhrase . "%')");
            $this->db->or_where("UPPER(eps) like UPPER('%" . $datos->searchPhrase . "%')");
            $this->db->or_where("UPPER(ips) like UPPER('%" . $datos->searchPhrase . "%')");
            $this->db->or_where("UPPER(resul_cito) like UPPER('%" . $datos->searchPhrase . "%')");
            $this->db->or_where("UPPER(resul_vph) like UPPER('%" . $datos->searchPhrase . "%')");
        } //$this->db->order_by('id_indicador');
        if ($this->session->userdata('id_ips') != '') { //si no es administrador
            $this->db->where('id_ips', $this->session->userdata('id_ips'));
        }
        if ($this->session->userdata('id_eps') != '') { //si no es administrador
            $this->db->where('id_eps', $this->session->userdata('id_eps'));
        }
        $this->db->stop_cache();
        $rows["total"] = $this->db->count_all_results();
        if ($datos->seguimiento == true) {
            $this->db->order_by("estado", "asc");
        }
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
        $arrayResultado = $consulta->result_array();
        $rows["current"] = $datos->current;
        $rows["rowCount"] = $datos->rowCount;
        $rows["rows"] = $arrayResultado;
        return json_encode($rows);
    }

    function getReporteTamizacionExportar() {
        $headers = array('Cédula', 'Fecha de toma', 'Municipio', 'EPS', 'IPS', 'Calidad de la muestra', 'Categorizacion general', 'Hallazgos no neoplásticos', 'Anormalidades en células escamosas', 'anormalidades en células glandulares', 'Observación citología', 'Validez prueba VPH', 'VPH genotipo 16', 'VPH genotipo 18', 'VPH otros', 'Observaciones prueba VPH');
        $this->db->select('cedula, fecha_toma, municipio, nombre_eps, nombre_ips, calidad_muestra, categorizacion_general, hallazgos_no_neoplaticos, anor_cel_escamosas, anor_cel_glandulares, obs_citologia, validez_prueba_vph, vph_genotipo_16, vph_genotipo_18, vph_otros, obs_vph');
        $this->db->from('pin_resultado_laboratorio');
        $this->db->join('par_eps', 'par_eps.id_eps = pin_resultado_laboratorio.eps ::int');
        $this->db->join('par_ips', 'par_ips.id_ips = pin_resultado_laboratorio.ips ::int');
        if ($this->session->userdata('id_ips') != '') { //si no es administrador
            $this->db->where('ips', $this->session->userdata('id_ips'));
        }
        if ($this->session->userdata('id_eps') != '') { //si no es administrador
            $this->db->where('eps', $this->session->userdata('id_eps'));
        }
        $query = $this->db->get();
        if ($query->num_rows > 0) {
            $table[] = $headers;
            foreach ($query->result() as $row) {
                $table [] = $row;
            }
            return $table;
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

    function getAtenciones($id_positiva) {
        $this->db->from('pin_atencion');
        $this->db->where('id_positiva', $id_positiva);
        $consulta = $this->db->get();
        $rows["rows"] = $consulta->result_array();
        return json_encode($rows);
    }

    function getTratamientos($id_positiva) {
        $this->db->from('pin_tratamiento');
        $this->db->where('id_positiva', $id_positiva);
        $consulta = $this->db->get();
        $rows["rows"] = $consulta->result_array();
        return json_encode($rows);
    }

    function calcular_edad($fechanacimiento) {
        $date2 = date('Y-m-d'); //
        $diff = abs(strtotime($date2) - strtotime($fechanacimiento));
        $years = floor($diff / (365 * 60 * 60 * 24));
        return $years;
    }

    function asignarAtencion($datos) {
        $this->db->set($datos);
        if ($this->db->insert('pin_atencion')) {
            $respuesta['success'] = TRUE;
            $respuesta['title'] = 'Operación exitosa';
            $respuesta['msg'] = 'Registro creado con éxito';
        } else {
            $respuesta['success'] = FALSE;
            $respuesta['title'] = 'Error';
            $respuesta['msg'] = 'Ocurrio un error al crear el indicador';
        }
        return json_encode($respuesta);
    }

    function asignarTratamiento($datos) {
        $this->db->set($datos);
        if ($this->db->insert('pin_tratamiento')) {
            $respuesta['success'] = TRUE;
            $respuesta['title'] = 'Operación exitosa';
            $respuesta['msg'] = 'Registro creado con éxito';
        } else {
            $respuesta['success'] = FALSE;
            $respuesta['title'] = 'Error';
            $respuesta['msg'] = 'Ocurrio un error al crear el indicador';
        }
        return json_encode($respuesta);
    }

    function genId($secuencia) {
        $sql = 'select nextval(\'' . $secuencia . '\')';
        $query = $this->db->query($sql);
        $row = $query->row();
        return $row->nextval;
    }

    function insertarBitacora($datos) {
        $this->db->set($datos);
        if ($this->db->insert('seg_bitacora')) {
            return true;
        }
        return false;
    }

    function cambiarEstado($idPositiva) {
        $sql = "update pin_positivas set estado = 'SEGUIMIENTO' where id_positivas = " . $idPositiva;
        $query = $this->db->query($sql);
    }

    function getEPS() {
        $this->db->select('id_eps, nombre_eps');
        $this->db->from('par_eps');
        $this->db->order_by('nombre_eps');
        $consulta = $this->db->get();

        if ($consulta) {
            $rows["eps"] = $consulta->result_array();
            $rows["success"] = TRUE;
        }
        return json_encode($rows);
    }

    function asignarSeguimiento($datos, $idPositiva) {
        $this->db->where('id_positivas', $idPositiva);
        $this->db->set($datos);
        if ($this->db->update('pin_positivas')) {
            $respuesta['success'] = TRUE;
            $respuesta['title'] = 'Operación Exitosa';
            $respuesta['msg'] = 'Registro Editado Con Éxito';
        } else {
            $respuesta['success'] = FALSE;
            $respuesta['title'] = 'Error';
            $respuesta['msg'] = 'Ocurrio Un Error Al Editar El Registro';
        }
        return json_encode($respuesta);
    }

    function actualizarPositivas() {
        $this->db->select("cedula, 
			PRIMER_NOMBRE || ' '||SEGUNDO_NOMBRE||' '||PRIMER_APELLIDO||' '||SEGUNDO_APELLIDO AS nombre,
			DATE_PART('YEAR',AGE(FECHA_NACIMIENTO)) as edad,
			fecha_nacimiento,
			REPLACE(CELULAR||' ' || TELEFONO, ' 0', '') AS telefono,
			UPPER(VEREDA_DIRECCION) as direccion,
			resultado_epidemiologica.municipio as municipio,
			resultado_epidemiologica.ips as ips,
			resultado_epidemiologica.eps as eps, '' as resul_vph , '' as resul_cito , '' as conducta,
			calidad_muestra, categorizacion_general, anor_cel_escamosas, anor_cel_glandulares, 
			vph_genotipo_16, vph_genotipo_18, vph_otros, pin_resultado_laboratorio.fecha_toma as fecha_toma, pin_resultado_laboratorio.cod_mx as cod_mx", false);
        $this->db->from('pin_resultado_laboratorio');
        $this->db->join('resultado_epidemiologica', 'cedula = numero_documento');
        $this->db->where('categorizacion_general', 'Anormalidades en células epiteliales');
        $this->db->or_where('vph_genotipo_16', 'Positivo');
        $this->db->or_where('vph_genotipo_18', 'Positivo');
        $this->db->or_where('vph_otros', 'Positivo');
        $this->db->order_by('cedula');
        $this->db->order_by('fecha_toma');
        $query = $this->db->get();
        return $resultados_positivos = $query->result_array();
    }

    function consultarElemento($elemento, $nombreTabla) {
        if ($elemento != null) {
            $this->db->where($elemento);
            $result = $this->db->get($nombreTabla);
            if ($result->num_rows() === 0) {
                return true; //el registro no esta en el sistema, se puede ingresar
            }
        }
        return false; //El registro ya se encuentra almacenado en la BD
    }

    function insertarDatos($datos, $tabla) {
        $this->db->set($datos);
        if ($this->db->insert($tabla)) {
            return 1;
        } else {
            return 0;
        }
        return 0;
    }
    
    function editarDatos($datos, $idPositiva) {
        $this->db->where('id_positivas', $idPositiva);
        $this->db->set($datos);
        if ($this->db->update('pin_positivas')) {
           return 1;
        } else {
           return 0;
        }
        return 0;
    }

    function getIdPositiva($cedula) {
        $this->db->select('id_positivas');
        $this->db->from('pin_positivas');
        $this->db->where('cedula', $cedula);
        $query = $this->db->get();
        $ret = $query->row();
        return $ret->id_positivas;
    }
}
