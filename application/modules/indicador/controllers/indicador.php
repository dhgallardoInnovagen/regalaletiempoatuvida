<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Indicador extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('indicador_model', 'modelo');
        $this->load->helper('utilidades');
    }

    public function index() {
        $datos['page_title'] = $this->lang->line('lbl_titulo_pagina');
        $datos['contenido_title'] = "Index";
        $datos['contenido'] = "principal_view";
        $this->load->view('plantillas/plantilla', $datos);
    }

    public function gestionarIndicador() {
        $datos['page_title'] = $this->lang->line('lbl_titulo_pagina');
        $datos['contenido_title'] = "Index";
        $datos['contenido'] = "indicador_view";
        $this->load->view('plantillas/plantilla', $datos);
    }

    public function importarDatosView() {
        $datos['page_title'] = $this->lang->line('lbl_titulo_pagina');
        $datos['contenido_title'] = "Index";
        $datos['contenido'] = "importar_datos";
        $this->load->view('plantillas/plantilla', $datos);
    }

    public function importarDatos() {
        $fase = $this->input->post('fase');
        $tipoArchivo = $this->input->post('tipoArchivo');
        switch ($tipoArchivo) {
            case 'encuestaEpidemiologica':
                $this->importarResultadoEpidemiolologica($fase);
                break;
            case 'tomaCitologia':
                $this->importarTomaCitologia($fase);
                break;
            case 'resultadoLaboratorio':
                $this->importarResultadoLaboratorio();
                break;
        }
    }

    public function importarResultadoLaboratorio() {
        //$resultadoEncuesta = array();       
        ini_set('memory_limit', '-1');
        $localFile = $_FILES['inputData']['tmp_name'];
        $resultadoEncuesta = $this->getRegistrosAInsertar($localFile);
        $resultado = $this->modelo->importarDatos($resultadoEncuesta, 'pin_resultado_laboratorio');
        $this->modelo->actualizar_view_rep_consolidado();
        echo ($resultado);
    }

    public function getRegistrosAInsertar($localFile) {
        $handle = fopen($localFile, 'r');
        $arrayIPS = array();
        $arrayEPS = array();
        $resultadoEncuesta = array();
        $nombre_campos = fgetcsv($handle, 10000, ",");
        $cabeceraResultadoLaboratorio = array("Orden", "Cedula", "Plan de atencion", "Fecha de toma de muestra", "Municipio", "IPS", "EPS", "Calidad de la muestra", "Categorizacion general", "Microorganismos", "Hallazgos no neoplasticos", "Anormalidades en celulas escamosas", "Anormalidades en celulas glandulares", "OBSERVACIONES", "Validez de la prueba", "VPH Genotipo 16", "VPH Genotipo 18", "OTROS VPH Alto Riesgo", "Reactividad", "OBSERVACIONES");
        $archivoValido = $this->verificarCabeceraArchivo($nombre_campos, $cabeceraResultadoLaboratorio);
        $indice = 1;
        $ips = $this->modelo->getIPSHomologa();
        $eps = $this->modelo->getEPSHomologa();
        while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
            if (count($cabeceraResultadoLaboratorio) <= count($data)) {
//                echo 'consultando cedula y fecha toma'.$data[1].' '.$data[3];               
                if ($this->consultarRegistroExistente(floatval($data[1]), $data[3]) === true) {//se envía a consultar la cedula y fecha de toma, para verificar que no se tenga registro de la misma usuaria                  
                    $id_ips = $this->validarIPS($this->quitar_tildes($data[5]), $ips);
                    $id_eps = $this->ValidarEPS($this->quitar_tildes($data[6]), $eps);
                    if ($id_ips === -1) {//si la ips no se encuentra dentro de el listado, para realizar la homologación de ips
                        if (in_array($data[5], $arrayIPS) === false && $data[5] !== '') {
                            $arrayIPS[] = $data[5];
                        }
                    } else {
                        if ($id_eps === -1) {//Si la ips no está dentro del listado, para realizar la homologación de EPS
                            if (in_array($data[6], $arrayEPS) === false && $data[6] !== '') {
                                $arrayEPS[] = $data[6];
                            }
                        } else {
                            $elemento = array(
                                'cod_mx' => floatval($data[0]),
                                'cedula' => floatval($data[1]),
                                'plan_atencion' => $data[2],
                                'fecha_toma' => !empty($data[3]) ? formato_fecha($data[3]) : NULL,
                                'municipio' => ($data[4]),
                                'ips' => $id_ips,
                                'eps' => $id_eps,
                                'calidad_muestra' => $this->getCalidadMuestra($data[7]),
                                'categorizacion_general' => $this->getCategorizacionGeneral($data[8]),
                                'microorganismos' => $this->getMicroorganismos($data[9]),
                                'hallazgos_no_neoplaticos' => $this->getHallazgosNoNeoplasticos($data[10]),
                                'anor_cel_escamosas' => $this->getAnormalidadesCelulasEscamosas($data[11]),
                                'anor_cel_glandulares' => $this->getAnormalidadesCelulasGlandulares($data[12]),
                                'obs_citologia' => $data[13],
                                'validez_prueba_vph' => $this->validezPruebaVPH($data[14]),
                                'vph_genotipo_16' => $this->resultadoVPH($data[15]),
                                'vph_genotipo_18' => $this->resultadoVPH($data[16]),
                                'vph_otros' => $this->resultadoVPH($data[17]),
                                'reactividad' => $data[18],
                                'obs_vph' => $data[19]
                            );
                            $resultadoEncuesta[] = $elemento;
                        }
                    }
                }
            } else {
                $respuesta['success'] = FALSE;
                $respuesta['title'] = 'Dato faltante';
                $respuesta['msg'] = 'Error en la cantidad de columnas: Faltan datos en la fila: ' . ++$indice;
                die(json_encode($respuesta));
            }
            $indice++;
        }
        fclose($handle);
        if (count($arrayIPS) === 0 && count($arrayEPS) === 0) {
            return $resultadoEncuesta;
        } else {
            $respuesta['success'] = FALSE;
            $respuesta['title'] = 'IPS no se encuentra parametrizada';
            $respuesta['msg'] = 'Contactese con el administrador del sistema para que parametrice las siguientes ips: ';
            $respuesta['ips'] = $arrayIPS;
            $respuesta['eps'] = $arrayEPS;
            die(json_encode($respuesta));
        }
    }

    public function consultarRegistroExistente($cedula, $fecha_toma) {
        $elemento = array(
            'cedula' => $cedula,
            'fecha_toma' => $fecha_toma
        );
        if ($this->modelo->consultarElemento($elemento, 'pin_resultado_laboratorio') === true) {
            //echo "returnando true";
            return true;//retorna true, el registro no esta en el sistema, se puede ingresar
        }
       // echo "retornando false";
        return false;//retorna false, el registro YA esta en el sistema, NO se puede ingresar
    }

    public function getCalidadMuestra($valor) {
        switch ($valor) {
            case 1: return "Satisfactoria con endocervicales/zona de transformación";
            case 2: return "Satisfactoria sin endocervicales/zona de transformación";
            case 3: return "Insatisfactoria";
            case 4: return "Rechazada";
        }
        return utf8_encode($valor);
    }

    public function getCategorizacionGeneral($valor) {
        switch ($valor) {
            case 1: return "Negativa para lesión intraepitelial o malignidad";
            case 2: return "Anormalidades en células epiteliales";
        }
        return utf8_encode($valor);
    }

    public function getMicroorganismos($valor) {
        $vectorValores = explode(",", $valor);
        $cadenaRetorno = "";
        foreach ($vectorValores as $val) {
            switch ($val) {
                case 1: $cadenaRetorno = $cadenaRetorno . "Tricomonas vaginalis;";
                    break;
                case 2: $cadenaRetorno = $cadenaRetorno . "Hongos consistentes con Cándida spp;";
                    break;
                case 3: $cadenaRetorno = $cadenaRetorno . "Cambio de la flora vaginal sugestivo de vaginosis bacteriana;";
                    break;
                case 4: $cadenaRetorno = $cadenaRetorno . "Bacterias consistentes con Actinomices spp;";
                    break;
                case 5: $cadenaRetorno = $cadenaRetorno . "Cambios celulares consistentes con virus del Herpes simple;";
                    break;
                case 6: $cadenaRetorno = $cadenaRetorno . "Cambios consistentes con citomegalovirus;";
                    break;
                case 7: $cadenaRetorno = $cadenaRetorno . "Otros;";
                    break;
            }
        }
        if (strlen($cadenaRetorno) > 0) {
            $cadenaRetorno = substr($cadenaRetorno, 0, strlen($cadenaRetorno) - 1);
        }
        return $cadenaRetorno;
    }

    public function getHallazgosNoNeoplasticos($valor) {
        $vectorValores = explode(",", $valor);
        $cadenaRetorno = "";
        foreach ($vectorValores as $val) {
            switch ($val) {
                case 1: $cadenaRetorno = $cadenaRetorno . "Cambios celulares reactivos asociados a la Inflamación;";
                    break;
                case 2: $cadenaRetorno = $cadenaRetorno . "Cambios celulares reactivos asociados a Radiación;";
                    break;
                case 3: $cadenaRetorno = $cadenaRetorno . "Cambios celulares reactivos asociados a DIU;";
                    break;
                case 4: $cadenaRetorno = $cadenaRetorno . "Células glandulares post-histerectormía;";
                    break;
                case 5: $cadenaRetorno = $cadenaRetorno . "Atrofia;";
                    break;
                case 6: $cadenaRetorno = $cadenaRetorno . "Células endometriales (en mayores de los 40 años);";
                    break;
                case 7: $cadenaRetorno = $cadenaRetorno . "Metaplasia escamosa;";
                    break;
                case 8: $cadenaRetorno = $cadenaRetorno . "Cambios queratósicos;";
                    break;
                case 9: $cadenaRetorno = $cadenaRetorno . "Metaplasia tubarica;";
                    break;
                case 10: $cadenaRetorno = $cadenaRetorno . "Cambios asociados al embarazo;";
                    break;
            }
        }
        if (strlen($cadenaRetorno) > 0) {
            $cadenaRetorno = substr($cadenaRetorno, 0, strlen($cadenaRetorno) - 1);
        }
        return $cadenaRetorno;
    }

    public function getAnormalidadesCelulasEscamosas($valor) {
        switch ($valor) {
            case 1: return "Células escamosas atípicas de significado ind. (ASC-US)";
            case 2: return "Células escamosas atípicas que no puede excluir HSIL (ASC-H)";
            case 3: return "Lesión Intraepitelial escamosa de bajo grado (LSIL) - Cambios citopáticos por VPH";
            case 4: return "Lesión Intraepitelial escamosa de bajo grado (LSIL) - Displasia leve (NICI)";
            case 5: return "Lesión Escamosa intraepitelial de alto grado (HSIL) - NIC II";
            case 6: return "Lesión Escamosa intraepitelial de alto grado (HSIL) - NIC III";
            case 7: return "Lesión Escamosa intraepitelial de alto grado (HSIL) - Ca In Situ";
            case 8: return "HSIL sospechosa de invasión";
            case 9: return "Carcinoma de células escamosas";
        }
        return utf8_encode($valor);
    }

    public function getAnormalidadesCelulasGlandulares($valor) {
        switch ($valor) {
            case 1: return "Células endocervicales atípicas (NOS)";
            case 2: return "Células endometriales atípicas (NOS)";
            case 3: return "Células glandulares (NOS)";
            case 4: return "Células endocervicales atípicas que favorecen neoplasia";
            case 5: return "Células glandulares atípicas que favorecen neoplasia";
            case 6: return "Adenocarcinoma endocervical in situ";
            case 7: return "Adenocarcinoma endocervical";
            case 8: return "Adenocarcinoma endometrial";
            case 9: return "Adenocarcinoma extrauterino";
            case 10: return "Adenocarcinoma (NOS)";
            case 11: return "Otras neoplasias";
        }
        return utf8_encode($valor);
    }

    public function validezPruebaVPH($valor) {
        switch ($valor) {
            case 1: return "Inválido";
            case 2: return "Válido en células epiteliales";
        }
        return utf8_encode($valor);
    }

    public function resultadoVPH($valor) {
        switch ($valor) {
            case 1: return "Positivo";
            case 2: return "Negativo";
        }
        return utf8_encode($valor);
    }

    public function importarTomaCitologia($fase) {
        ini_set('memory_limit', '-1');
        $resultadoEncuesta = array();
        $localFile = $_FILES['inputData']['tmp_name'];
        $handle = fopen($localFile, 'r');
        $nombre_campos = fgetcsv($handle, 10000, ",", '"');
        $cabeceraResultadoLaboratorio = array("Date Submitted", "Fase del Proyecto", "Municipio", "Número de cédula (Sin puntos, comas o espacios Ej: 1061743853)", "¿Atiende por demanda inducida?", "Fecha de demanda inducida (DD/MM/AAAA)", "Al observar el cuello uterino, se encuentran los siguientes hallazgos:", "Si su respuesta anterior fue Otro, indique cual:", "Observaciones", "Responsable de la toma de la citología", "Nombre completo del responsable de la toma de la citología", "Fecha de la toma de la citología (DD/MM/AAAA)");
        $archivoValido = $this->verificarCabeceraArchivo($nombre_campos, $cabeceraResultadoLaboratorio);
        if ($archivoValido) {
            $indice = 1;
            while (($data = fgetcsv($handle, 100000, ",", '"')) !== FALSE) {
                if (count($cabeceraResultadoLaboratorio) <= count($data)) {
                    $elementoConsulta = array(
                        'fecha_envio' => date("Y-m-d", strtotime($data[0])),
                        'numero_cedula' => floatval($data[3])
                    );
                    $elemento = array(
                        'fecha_envio' => date("Y-m-d", strtotime($data[0])),
                        'plan_atencion' => $data[1],
                        'municipio' => $data[2],
                        'numero_cedula' => floatval($data[3]),
                        'demanda_inducida' => $data[4],
                        'fecha_demanda_inducida' => !empty($data[5]) ? formato_fecha($data[5]) : NULL,
                        'estado_cuello' => str_replace(";", "|", $data[6]),
                        'otro_cual' => $data[7],
                        'observaciones' => $data[8],
                        'responsable_toma' => $data[9],
                        'nombre_responsable' => strtoupper($data[10]),
                        'fecha_toma' => !empty($data[11]) ? formato_fecha($data[11]) : NULL
                    );
                    if ($this->modelo->consultarElemento($elementoConsulta, 'pin_toma_citologia')) {
                        $resultadoEncuesta[] = $elemento;
                    }
                } else {
                    $respuesta['success'] = FALSE;
                    $respuesta['title'] = 'Dato faltante';
                    $respuesta['msg'] = 'Error en la cantidad de columnas: Faltan datos en la fila: ' . ++$indice;
                    die(json_encode($respuesta));
                }
                $indice++;
            }
        }
        fclose($handle);
        echo ($this->modelo->importarDatos($resultadoEncuesta, 'pin_toma_citologia'));
    }

    public function importarResultadoEpidemiolologica($fase) {
        ini_set('memory_limit', '-1');
        $resultadoEncuesta = array();
        $localFile = $_FILES['inputData']['tmp_name'];
        $handle = fopen($localFile, 'r');
        $nombre_campos = fgetcsv($handle, 10000, ",", '"');
        $cabeceraResultado = array("Date Submitted", "Fase del Proyecto", "Nombre de encuestador", "Fecha de reporte (DD/MM/AAAA)", "Primer nombre", "Segundo nombre", "Primer apellido", "Segundo apellido", "Número de documento (Solo números, sin letras, sin puntos, comas o espacios Ej: 1061743853)", "Tipo id", "Genero", "Estado civil", "Fecha de nacimiento (DD/MM/AAAA)", "Teléfono", "Celular", "Departamento", "Municipio", "Zona", "Vereda/Direcicón", "Barrio", "Correo electrónico", "IPS", "EPS", "¿Visita por demanda inducida?", "Pertenencia étnica", "Nivel educativo", "¿A qué se dedica usted actualmente?", "Estrato socioeconómico", "Descripción del servicio", "¿Cuándo fue la fecha de su última citología? (DD/MM/AAAA)", "¿Cuál fue el resultado de la citología?", "Si su citologìa fue anormal, ¿Cuál fue el resultado?", "¿Qué tipo de procedimiento le realizarón?", "¿Hace cuánto le realizaron el procedimiento (meses)?", "¿Su médico le ha comunicado que alguna vez ha tenido infección por VPH?", "¿Cuál ha sido la frecuencia con la que se ha tomado la citología?", "Si usted no se ha realizado la citología periódicamente, ¿Cuál ha sido la razón para no hacerlo?", "¿Tiene vida sexual activa?", "¿Edad de la primera relación sexual (Años)?", "¿Número de acompañantes sexuales hasta el momento?", "¿Sabe usted si alguno de sus compañeros sexuales ha tenido (o tiene) relaciones con trabajadoras sexuales?", "¿Qué método de planificación emplea usted actualmente?", "¿Hace cuánto tiempo que emplea el método de planificación (meses)?", "¿Ha presentado alguna enfermedad de transmisión sexual?", "¿Cuál de las siguientes enfermedades de transmisión sexual ha presentado?", "Si su respuesta es otro, indique cual:", "¿Sabe usted si alguno de sus compañeros sexuales ha tenido ETS?", "¿Alguna de sus familiares ha sufrido de cáncer de cuello uterino?", "¿Quienes?", "¿Sabe en que consiste el exámen de citología/Papanicolaou?", "¿Sabe para qué sirve la citología?", "¿Sabe qué es el VPH?", "¿Conoce sobre las pruebas de detección del VPH?", "¿Cuál prueba se ha realizado?", "¿Conoce sobre la vacuna contra el VPH?", "¿Se ha aplicado la vacuna contra el VPH?", "¿Cuál vacuna se ha aplicado?", "¿Cuántas dosis se ha aplicado?", "Con respecto la habito de fumar, usted:", "¿Si es/fue fumador, cuántos cigarrillos fuma, fumaba por día?", "Si es/fue fumador ocasional, cuántos cigarrillos consume/consumía al mes?", "¿Por cuántos años ha fumado, o fumo?", "¿Cocina usted con leña?", "¿Cuántas horas al día?", "¿Hace cuántos años?", "¿Consume alimentos ricos en vitamina C (verduras, hortalizas y frutas)?", "¿Consume alimentos ricos en beta-carotenos (zanahoria, espinaca, acelga, tomate)?", "¿Consume alimentos ricos en vitamina A (productos lácteos, huevos)?", "¿Cuál es su peso (kg)?", "¿Cuál es su talla (cm)?", "¿Fecha de la toma? (DD/MM/AAAA)", "Gravidez", "Partos", "Abortos", "Cesáreas", "Mortinatos", "¿Edad del primer embarazo?", "¿Está usted embarazada actualmente?", "¿Cuántos meses de embarazo tiene?", "¿Fecha del último parto? (DD/MM/AAAA)", "¿Edad de la primera menstruación?", "¿Fecha de la última menstruación? (DD/MM/AAAA)", "¿Edad de la menopausia?");
        $archivoValido = $this->verificarCabeceraArchivo($nombre_campos, $cabeceraResultado);
        if ($archivoValido) {
            $indice = 1;
            while (($data = fgetcsv($handle, 100000, ",", '"')) !== FALSE) {
                if (count($cabeceraResultado) <= count($data)) {
                    $elementoConsulta = array(
                        'fecha_envio' => date("Y-m-d", strtotime($data[0])),
                        'numero_documento' => floatval($data[8]),
                        'fecha_reporte' => !empty($data[3]) ? formato_fecha($data[3]) : NULL,
                        'fecha_nacimiento' => !empty($data[12]) ? formato_fecha($data[12]) : NULL
                    );

                    $elemento = array(
                        'fecha_envio' => date("Y-m-d", strtotime($data[0])),
                        'plan_atencion' => $data[1],
                        'nombre_encuestador' => strtoupper($data[2]),
                        'fecha_reporte' => !empty($data[3]) ? formato_fecha($data[3]) : NULL,
                        'primer_nombre' => strtoupper($data[4]),
                        'segundo_nombre' => strtoupper($data[5]),
                        'primer_apellido' => strtoupper($data[6]),
                        'segundo_apellido' => strtoupper($data[7]),
                        'numero_documento' => floatval($data[8]),
                        'tipo_id' => $data[9],
                        'genero' => $data[10],
                        'estado_civil' => $data[11],
                        'fecha_nacimiento' => !empty($data[12]) ? formato_fecha($data[12]) : NULL,
                        'telefono' => floatval($data[13]),
                        'celular' => $data[14],
                        'departamento' => $data[15],
                        'municipio' => $data[16],
                        'zona' => $data[17],
                        'vereda_direccion' => $data[18],
                        'barrio' => $data[19],
                        'correo_electronico' => $data[20],
                        'ips' => $data[21],
                        'eps' => $data[22],
                        'visita_demanda_inducida' => $data[23],
                        'pertenencia_etnica' => $data[24],
                        'nivel_educativo' => $data[25],
                        'ocupacion' => $data[26],
                        'estrato_socioeconomico' => intval($data[27]),
                        'descripcion_servicio' => str_replace(";", "|", $data[28]),
                        'fecha_ultima_citologia' => !empty($data[29]) ? formato_fecha($data[29]) : NULL,
                        'resultado_citologia' => $data[30],
                        'resultado_anormal' => $data[31],
                        'procedimiento_realizado' => $data[32],
                        'tiempo_procedimiento' => intval($data[33]),
                        'padecido_vph' => $data[34],
                        'frecuencia_toma' => $data[35],
                        'razon_frecuencia' => $data[36],
                        'vida_sexual_activa' => $data[37],
                        'edad_primera_relacion_sexual' => intval($data[38]),
                        'num_comp_sexuales' => intval($data[39]),
                        'comp_trab_sexuales' => $data[40],
                        'metodo_planificacion' => $data[41],
                        'tiempo_metodo' => intval($data[42]),
                        'presentado_ets' => $data[43],
                        'cual_ets' => $data[44],
                        'otra_ets' => $data[45],
                        'companero_ets' => $data[46],
                        'familiar_ccu' => $data[47],
                        'quienes' => str_replace(";", "|", $data[48]),
                        'que_es_papanicolaou' => $data[49],
                        'para_que_sirve_citologia' => $data[50],
                        'que_es_vph' => $data[51],
                        'conoce_pruebas_vph' => $data[52],
                        'que_pruebas_ha_realizado' => $data[53],
                        'conoce_vacuna_vph' => $data[54],
                        'aplicado_vacuna' => $data[55],
                        'que_vacuna' => $data[56],
                        'cuantas_dosis' => intval($data[57]),
                        'es_fumador' => $data[58],
                        'cigarrillos_dia' => intval($data[59]),
                        'cigarrillos_mes' => intval($data[60]),
                        'hace_cuantos_anos_fuma' => intval($data[61]),
                        'cocina_lena' => $data[62],
                        'horas_dia' => intval($data[63]),
                        'hace_cuantos_anos_cocina' => intval($data[64]),
                        'consume_vitamina_c' => $data[65],
                        'consume_beta_caroteno' => $data[66],
                        'consume_vitamina_a' => $data[67],
                        'peso' => floatval($data[68]),
                        'talla' => floatval($data[69]),
                        'fecha_toma_peso' => !empty($data[70]) ? formato_fecha($data[70]) : NULL,
                        'gravidez' => intval($data[71]),
                        'partos' => intval($data[72]),
                        'abortos' => intval($data[73]),
                        'cesareas' => intval($data[74]),
                        'mortinatos' => intval($data[75]),
                        'edad_primer_embarazo' => intval($data[76]),
                        'esta_embarazada' => $data[77],
                        'meses_embarazo' => intval($data[78]),
                        'fecha_ultimo_parto' => !empty($data[79]) ? formato_fecha($data[79]) : NULL,
                        'edad_primera_menstruacion' => intval($data[80]),
                        'fecha_ultima_menstruacion' => !empty($data[81]) ? formato_fecha($data[81]) : NULL,
                        'edad_menopausia' => intval($data[82])
                    );
                    if ($this->modelo->consultarElemento($elementoConsulta, 'resultado_epidemiologica')) {
                        $resultadoEncuesta[] = $elemento;
                    }
                } else {
                    $respuesta['success'] = FALSE;
                    $respuesta['title'] = 'Dato faltante';
                    $respuesta['msg'] = 'Error en la cantidad de columnas: Faltan datos en la fila: ' . ++$indice;
                    die(json_encode($respuesta));
                }
                $indice++;
            }
        }
        fclose($handle);
        echo ($this->modelo->importarDatos($resultadoEncuesta, 'resultado_epidemiologica'));
    }

    public function verificarCabeceraArchivo($cabeceraEntrada, $cabeceraSolicitada) {
        if (count($cabeceraEntrada) == count($cabeceraSolicitada)) {
            for ($icampo = 0; $icampo < count($cabeceraEntrada); $icampo++) {
                if (strcasecmp(utf8_encode($cabeceraEntrada[$icampo]), utf8_encode($cabeceraSolicitada[$icampo])) !== 0) {
                    $respuesta['success'] = FALSE;
                    $respuesta['title'] = 'Error estructura archivo';
                    $respuesta['msg'] = 'Error en la cabecera del archivo: el campo "' . $cabeceraEntrada[$icampo] . '" no corresponde a  "' . $cabeceraSolicitada[$icampo] . '"';
                    die(json_encode($respuesta));
                }
            }
        } else {
            $respuesta['success'] = FALSE;
            $respuesta['title'] = 'Error numero de campos archivo';
            $respuesta['msg'] = 'El archivo de entrada contiene: ' . count($cabeceraEntrada) . " columnas, debe contener " . count($cabeceraSolicitada);
            die(json_encode($respuesta));
        }
        return TRUE;
    }

    public function getIndicadores() {
        $datos = new stdClass();
        $datos->current = $this->input->post('current');
        $datos->rowCount = $this->input->post('rowCount');
        $datos->sort = $this->input->post('sort');
        $datos->searchPhrase = $this->input->post('searchPhrase');
        echo ($this->modelo->getIndicadores($datos));
    }

    public function getIndicadorPorId() {
        $datos = new stdClass();
        $datos->idIndicador = $this->input->get('idIndicador');
        echo ($this->modelo->getIndicadorPorId($datos));
    }

    public function getRegistroIndicador() {
        $datos = new stdClass();
        $datos->current = $this->input->post('current');
        $datos->rowCount = $this->input->post('rowCount');
        $datos->sort = $this->input->post('sort');
        $datos->searchPhrase = $this->input->post('searchPhrase');
        $datos->idIndicador = $this->input->post('id_Indicador');
        echo ($this->modelo->getRegistroIndicador($datos));
    }

    public function editarIndicador() {
        $datos = new stdClass();
        $idIndicador = $this->input->post('idIndicador');
        $datos->nombre_indicador = $this->input->post('nombreIndicador');
//        $datos->interpretacion = $this->input->post('interpretacionIndicador');
        $datos->definicion_operacional = $this->input->post('definicionOperacional');
        $datos->coeficiente = $this->input->post('coeficienteIndicador');
        $datos->fuente = $this->input->post('fuenteIndicador');
        $datos->meta = $this->input->post('metaIndicador');
        $datos->id_clasificacion = $this->input->post('clasificacionIndicador');
        $datos->id_unidad_operacional = 2; //SUMATORIA DE NUMERADORES / SUMATORIA DE DENOMINADORES
        $datos->id_usuario = $this->input->post('idUsuario');
        if ($this->input->post('mideTodosMunicipios') == 'Municipal') {
            $datos->mide_todos_municipios = 't';
        } else {
            $datos->mide_todos_municipios = 'f';
        }
        $datos->tipo_meta = $this->input->post('tipoMeta');
        $datos->condicion_numerador = $this->input->post('condicionNumerador');
        $datos->condicion_denominador = $this->input->post('condicionDenominador');
        $datos->limite_inferior = $this->input->post('limiteInferior');
        $datos->limite_superior = $this->input->post('limiteSuperior');
        $datos->forma_calculo = $this->input->post('formaCalculo');
        echo ($this->modelo->editarIndicador($datos, $idIndicador));
    }

    public function nuevoIndicador() {
        $datos = new stdClass();
        $datos->nombre_indicador = $this->input->post('nombreIndicador');
        $datos->forma_calculo = $this->input->post('formaCalculo');
        $datos->definicion_operacional = $this->input->post('definicionOperacional');
        $datos->coeficiente = $this->input->post('coeficienteIndicador');
        $datos->fuente = $this->input->post('fuenteIndicador');
        $datos->limite_inferior = $this->input->post('limiteInferior');
        $datos->limite_superior = $this->input->post('limiteSuperior');
        $datos->id_clasificacion = $this->input->post('clasificacionIndicador');
        $datos->id_unidad_operacional = 2; //SUMATORIA DE NUMERADORES / SUMATORIA DE DENOMINADORES
        $datos->id_usuario = $this->input->post('idUsuario');
        if ($this->input->post('mideTodosMunicipios') == 'Municipal')
            $datos->mide_todos_municipios = 't';
        else
            $datos->mide_todos_municipios = 'f';
        $datos->tipo_meta = $this->input->post('tipoMeta');
        $datos->condicion_numerador = $this->input->post('condicionNumerador');
        $datos->condicion_denominador = $this->input->post('condicionDenominador');
        echo ($this->modelo->nuevoIndicador($datos));
    }

    public function eliminarIndicador() {
        $idIndicador = $this->input->post('idIndicador');
        echo ($this->modelo->eliminarIndicador($idIndicador));
    }

    public function getClasificacionIndicador() {
        echo ($this->modelo->getClasificacionIndicador());
    }

    public function getUnidadOperacional() {
        echo ($this->modelo->getUnidadOperacional());
    }

    public function getUsuarios() {
        echo ($this->modelo->getUsuarios());
    }

    public function crearPeriodos() {
        $idsIndicadores = $this->input->post('idIndicadores');
        $fechaInicial = $this->input->post('fechaInicial');
        $fechaFinal = $this->input->post('fechaFinal');
        $registrosIndicadores = array();
        foreach ($this->input->post('idIndicadores') as $fila) {
            $indicador = array();
            $respuesta = array();
            $datos = new stdClass();
            $datos->idIndicador = $fila;
            $indicador = json_decode($this->modelo->getIndicadorPorId($datos));
            if ($indicador->data[0]->mide_todos_municipios == 't') {
                $respuesta = json_decode($this->modelo->getMunicipios());
                for ($i = 0; $i < count($respuesta->municipios); $i++) {
                    if ($respuesta->municipios[$i]->codigo_municipio != 99999) {
                        $elemento = array(
                            'id_indicador' => $indicador->data[0]->id_indicador,
                            'id_municipio' => $respuesta->municipios[$i]->id_municipio,
                            'id_usuario' => $indicador->data[0]->id_usuario,
                            'coeficiente' => $indicador->data[0]->coeficiente,
                            'meta' => $indicador->data[0]->meta,
                            'limite_inferior' => $indicador->data[0]->limite_inferior,
                            'limite_superior' => $indicador->data[0]->limite_superior,
                            'tipo_meta' => $indicador->data[0]->tipo_meta,
                            'fecha_inicial' => $fechaInicial,
                            'fecha_final' => $fechaFinal
                        );
                        $registrosIndicadores[] = $elemento;
                    }
                }
            } else {
                $elemento = array(
                    'id_indicador' => $indicador->data[0]->id_indicador,
                    'id_municipio' => 1, //este valor indica que es para el consolidado general OJOOOO
                    'id_usuario' => $indicador->data[0]->id_usuario,
                    'coeficiente' => $indicador->data[0]->coeficiente,
                    'meta' => $indicador->data[0]->meta,
                    'limite_inferior' => $indicador->data[0]->limite_inferior,
                    'limite_superior' => $indicador->data[0]->limite_superior,
                    'tipo_meta' => $indicador->data[0]->tipo_meta,
                    'fecha_inicial' => $fechaInicial,
                    'fecha_final' => $fechaFinal
                );
                $registrosIndicadores[] = $elemento;
            }
        }
        echo ($this->modelo->crearPeriodos($registrosIndicadores));
    }

    public function validarIPS($valor, $vector) {
        foreach ($vector as $registro) {
            if ($this->quitar_tildes($registro['nombre_ips_homologa']) === $valor) {
                return $registro['id_ips'];
            }
        }
        return -1;
    }

    public function validarEPS($valor, $vector) {
        foreach ($vector as $registro) {
            if ($this->quitar_tildes($registro['nombre_eps_homologa']) === $valor) {
                return $registro['id_eps'];
            }
        }
        return -1;
    }

    public function quitar_tildes($cadena) {//FUncion para cambiar tildes y eliminar mas de un espacio en blanco
//        $cade = utf8_decode($cadena);     
        $cade = $cadena;
        $no_permitidas = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "À", "Ã", "Ì", "Ò", "Ù", "Ã™", "Ã", "Ã¨", "Ã¬", "Ã²", "Ã¹", "ç", "Ç", "Ã¢", "ê", "Ã®", "Ã´", "Ã»", "Ã‚", "ÃŠ", "ÃŽ", "Ã", "Ã›", "ü", "Ã¶", "Ã–", "Ã¯", "Ã¤", "«", "Ò", "Ã", "Ã„", "Ã‹", "Ñ", "à", "è", "ì", "ò", "ù");
        $permitidas = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "n", "N", "A", "E", "I", "O", "U", "a", "e", "i", "o", "u", "c", "C", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "u", "o", "O", "i", "a", "e", "U", "I", "A", "E", "N", "a", "e", "i", "o", "u");
        $texto = str_replace($no_permitidas, $permitidas, $cade);
        return preg_replace('/\s\s+/', ' ', $texto);
    }

    public function getIPS() {
        echo ($this->modelo->getIPS());
    }

    public function getEPS() {
        echo ($this->modelo->getEPS());
    }

    public function setIPS_EPSHomologas() {
        $ips = $this->input->post('arrayIPS');
        $eps = $this->input->post('arrayEPS');
        $data = $this->input->post('data');
        $ips = explode(",", $ips);
        $eps = explode(",", $eps);
        $data = explode(",", $data);
        $registrosIPSHomologo = array();
        $registrosEPSHomologo = array();
        $indexData = 0;
        for ($i = 0; $i < count($ips); $i++) {
            if ($ips[$i] !== "") {
                $elemento = array(
                    'id_ips' => $data[$indexData],
                    'nombre_ips_homologa' => $ips[$i]
                );
                $registrosIPSHomologo[] = $elemento;
                $indexData++;
            }
        }

        for ($i = 0; $i < count($eps); $i++) {
            if ($eps[$i] !== "") {
                $elemento = array(
                    'id_eps' => $data[$indexData],
                    'nombre_eps_homologa' => $eps[$i]
                );
                $registrosEPSHomologo[] = $elemento;
                $indexData++;
            }
        }
        echo ($this->modelo->crearHomologos($registrosIPSHomologo, $registrosEPSHomologo));
    }

}
