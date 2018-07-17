<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gestion_positivas extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Gestion_positivas_model', 'modelo');
        $this->load->helper('utilidades');
    }

    public function index() {
        $datos['page_title'] = $this->lang->line('lbl_titulo_pagina');
        $datos['contenido_title'] = "Index";
        $datos['contenido'] = "gestion_positivas_view";
        $this->load->view('plantillas/plantilla', $datos);
    }

    public function getPositivas() {
        $datos = new stdClass();
        $datos->current = $this->input->post('current');
        $datos->rowCount = $this->input->post('rowCount');
        $datos->sort = $this->input->post('sort');
        $datos->searchPhrase = $this->input->post('searchPhrase');
        $datos->seguimiento = $this->input->post('seguimiento');
        echo ($this->modelo->getPositivas($datos));
    }

    public function exportarReporteTamizacion() {
        $table = $this->modelo->getReporteTamizacionExportar();
        $this->load->library('excel_pdf_manager');
        $this->excel_pdf_manager->export($table, "Reporte_tamizacion " . date("d/m/Y"), ".xls");
    }

    public function exportarRecomendacionesTamizadas() {
        $table = $this->modelo->exportarRecomendacionesTamizadas();
        $this->load->library('excel_pdf_manager');
        $this->excel_pdf_manager->export($table, "UsuariasTamizadas " . date("d/m/Y"), ".xls");
    }

    public function getAtenciones() {
        $id_positiva = $this->input->post('idPositiva');
        echo ($this->modelo->getAtenciones($id_positiva));
    }

    public function getTratamientos() {
        $id_positiva = $this->input->post('idPositiva');
        echo ($this->modelo->getTratamientos($id_positiva));
    }

    public function asignarAtencion() {
        $datos = new stdClass();
        $id = $this->modelo->genId('pin_atencion_id_atencion_seq');
        $datos->id_atencion = $id;
        $datos->id_positiva = $this->input->post('idPositiva');
        $datos->tipo_atencion = $this->input->post('tipoAtencion');
        $datos->fecha_atencion = $this->input->post('fechaAtencion');
        $datos->conducta = $this->input->post('conducta');
        $datos->diagnostico = $this->input->post('diagnostico');
        //Insertando datos en la bitácora        
        $datosBitacora = new stdClass();
        $datosBitacora->id_usuario = $this->session->userdata('id_usuario');
        $datosBitacora->fecha_actividad = date("Y-m-d H:i:s");
        $datosBitacora->actividad = 'Crear atención positivas';
        $datosBitacora->id_registro = $id;
        $this->modelo->insertarBitacora($datosBitacora);
        //Cambiando estado a positiva
        $this->modelo->cambiarEstado($datos->id_positiva);
        echo ($this->modelo->asignarAtencion($datos));
    }

    public function asignarTratamiento() {
        $datos = new stdClass();
        $id = $this->modelo->genId('pin_tratamiento_id_tratamiento_seq');
        $datos->id_tratamiento = $id;
        $datos->id_positiva = $this->input->post('idPositiva');
        $datos->tratamiento = $this->input->post('tratamiento');
        $datos->fecha_tratamiento = $this->input->post('fechaTratamiento');
        $datos->resultado = $this->input->post('resultado');
        //Insertando datos en la bitácora        
        $datosBitacora = new stdClass();
        $datosBitacora->id_usuario = $this->session->userdata('id_usuario');
        $datosBitacora->fecha_actividad = date("Y-m-d H:i:s");
        $datosBitacora->actividad = 'Crear tratamiento positivas';
        $datosBitacora->id_registro = $id;
        $this->modelo->insertarBitacora($datosBitacora);
        //Cambiando estado a positiva
        $this->modelo->cambiarEstado($datos->id_positiva);
        echo ($this->modelo->asignarTratamiento($datos));
    }

    public function asignarSeguimiento() {
        $datos = new stdClass();
        $idPositiva = $this->input->post('idPositiva');
        $datos->conducta = $this->input->post('conducta');
        if ($this->input->post('fechaNotificacion') != '') {
            $datos->fecha_noti_eps = $this->input->post('fechaNotificacion');
        }
        $datos->no_oficio = $this->input->post('numeroNotificacion');
        if ($this->input->post('fechaControl') != '') {
            $datos->fecha_control_cotest = $this->input->post('fechaControl');
        }
        $datos->resultado_control = $this->input->post('resultadoControl');
        if ($this->input->post('fechaVisita') != '') {
            $datos->fecha_visita_domiciliaria = $this->input->post('fechaVisita');
        }
        $datos->visita_domiciliaria = $this->input->post('obs_visita');
        $datos->observaciones_eps = $this->input->post('obs_eps');
        $datos->observaciones_pto = $this->input->post('obs_pto_atencion');
        $datos->observaciones_sds = $this->input->post('obs_sdsc');

        $datosBitacora = new stdClass();
        $datosBitacora->id_usuario = $this->session->userdata('id_usuario');
        $datosBitacora->fecha_actividad = date("Y-m-d H:i:s");
        $datosBitacora->actividad = 'Editar Seguimiento positivas';
        $datosBitacora->id_registro = $idPositiva;
        $this->modelo->insertarBitacora($datosBitacora);
        //Cambiando estado a positiva
        $this->modelo->cambiarEstado($idPositiva);
        echo ($this->modelo->asignarSeguimiento($datos, $idPositiva));
    }

    public function getEPS() {
        echo ($this->modelo->getEPS());
    }

    public function actualizarPositivas() {
        $resultados_positivos = $this->modelo->actualizarPositivas();
        $bandera = 0;
        $contadorPositivas = 0;
        $contadorSeguimiento = 0;
        $seg_ultimo_trimestre = 0;
        for ($index = 0; $index < count($resultados_positivos) - 1; $index++) {
            if ($resultados_positivos[$index]['cedula'] == $resultados_positivos[$index + 1]['cedula']) {
                if ($bandera == 0) {
                    $contadorPositivas = $contadorPositivas + $this->ingresarPositiva($resultados_positivos[$index]);
                    $bandera++;
                    if ($resultados_positivos[$index]['fecha_toma'] !== $resultados_positivos[$index + 1]['fecha_toma']) {
                        //echo "-->ingresar seguimiento: " . $resultados_positivos[$index + 1]['cedula'] . " Fecha toma: " . $resultados_positivos[$index + 1]['fecha_toma'] . "</br>";
                        if($resultados_positivos[$index + 1]['fecha_toma'] > '2016-12-01'){
                           // echo "--fecha toma ".$resultados_positivos[$index + 1]['fecha_toma'];
                            $seg_ultimo_trimestre = $seg_ultimo_trimestre +1;
                        }
                        $contadorSeguimiento = $contadorSeguimiento + $this->ingresarSeguimiento($resultados_positivos[$index + 1]);
                    }
                } else {
                    if ($resultados_positivos[$index]['fecha_toma'] !== $resultados_positivos[$index + 1]['fecha_toma']) {
                        
                        if($resultados_positivos[$index + 1]['fecha_toma'] > '2016-12-01'){
                           // echo "--fecha toma ".$resultados_positivos[$index + 1]['fecha_toma'];
                            $seg_ultimo_trimestre = $seg_ultimo_trimestre +1;
                        }
                        $contadorSeguimiento = $contadorSeguimiento + $this->ingresarSeguimiento($resultados_positivos[$index + 1]);
                        //echo "-->ingresar seguimiento: " . $resultados_positivos[$index + 1]['cedula'] . " Fecha toma: " . $resultados_positivos[$index + 1]['fecha_toma'] . "</br>";
                    }
                    $bandera++;
                }
            } else {
                if ($bandera == 0) {
                    $contadorPositivas = $contadorPositivas + $this->ingresarPositiva($resultados_positivos[$index]);
                    $bandera = 0;
                } else {
                    $bandera = 0;
                }
            }
        }
        if ($bandera == 0) {
            $contadorPositivas = $contadorPositivas + $this->ingresarPositiva($resultados_positivos[$index]);
        }       
        $respuesta['success'] = TRUE;
        $respuesta['contadoPositivas'] = $contadorPositivas;
        $respuesta['contadorSeguimientos'] = $contadorSeguimiento;
        $respuesta['ultimo_semestre'] = $seg_ultimo_trimestre;
        echo json_encode($respuesta);
    }

    public function ingresarPositiva($resultado) {
        $elemento = array(
            'cedula' => $resultado['cedula'],
            'fecha_toma' => $resultado['fecha_toma']
        );
        if ($this->modelo->consultarElemento($elemento, 'pin_positivas') == true) {//si retorna true el registro no está en el sistema, se puede ingresar la positiva           
            //echo "ingresar nuevo: " . $elemento['cedula'] . " Fecha toma: " . $elemento['fecha_toma'] . "</br>";
            $citología = "";
            $resultado['resul_vph'] = $this->asignarResultadoVPH($resultado);
            $resultado['resul_cito'] = $this->asignarResultadoCL($resultado);
            unset($resultado['categorizacion_general']);
            unset($resultado['calidad_muestra']);
            unset($resultado['anor_cel_escamosas']);
            unset($resultado['anor_cel_glandulares']);
            unset($resultado['vph_genotipo_16']);
            unset($resultado['vph_genotipo_18']);
            unset($resultado['vph_otros']);
            return $this->modelo->insertarDatos($resultado, 'pin_positivas');
        }
        return 0;
    }

    public function ingresarSeguimiento($resultado) {
        //echo "-->ingresar seguimiento: " . $resultado['cedula'] . " Fecha toma: " . $resultado['fecha_toma'] . "</br>";        
        $id_positiva = $this->modelo->getIdPositiva($resultado['cedula']);
        if ($id_positiva != null) {
            $resultado['resul_vph'] = $this->asignarResultadoVPH($resultado);
            $resultado['resul_cito'] = $this->asignarResultadoCL($resultado);
            $resultadoCoTest = "CL: " . $resultado['resul_cito'] . "/VPH: " . $resultado['resul_vph'];
            $elemento = array(
                'fecha_control_cotest' => $resultado['fecha_toma'],
                'resultado_control' => $resultadoCoTest,
                'conducta' => $this->asignarConducta($resultado),
                'estado' => 'SEGUIMIENTO'
            );
            return $this->modelo->editarDatos($elemento,$id_positiva);
            
          //  print_r($elemento);
            //echo "nuevo seguimiento </br>";
        } else {
            echo "-****************** No esta la positiva-********" . $id_positiva . "-cedula: " . $resultado['cedula'] . "<br>";
        }
    }

    public function asignarConducta($resultado) {
        $conducta = "";
        if ($resultado['resul_cito'] === 'Negativa') {
            if ($resultado['vph_otros'] === 'Positivo') {
                $conducta = "Co-Test en un años";
            } else {
                if ($resultado['vph_genotipo_16'] === 'Positivo' || $resultado['vph_genotipo_18'] === 'Positivo') {
                    $conducta = "Colposcopia Biopsia";
                }
            }
        } else {
            if ($resultado['resul_cito'] == 'ASC-US' || $resultado['resul_cito'] == 'HSIL (ASC H)' ||
                    $resultado['resul_cito'] == 'LSIL-CAMBIOS CITOPÁTICOS POR VPH' || $resultado['resul_cito'] == 'LSIL-NIC I' ||
                    $resultado['resul_cito'] == 'ENDOMETRIALES ATIPICAS - NOS' || $resultado['resul_cito'] == 'ENDOCERV ATIPICAS - NOS' ||
                    $resultado['resul_cito'] == 'CEL GLANDULARES NOS' || $resultado['resul_cito'] == 'ADENOCARCINOMA - NOS') {
                if ($resultado['vph_otros'] === 'Positivo') {
                    $conducta = "Marcadores pronóstico Ki67-p16";
                } else {
                    if ($resultado['vph_genotipo_16'] === 'Positivo' || $resultado['vph_genotipo_18'] === 'Positivo') {
                        $conducta = "Colposcopia Biopsia";
                    }else{
                         $conducta = "Citología en un año";
                    }                    
                }
            }{
                if($resultado['resul_cito'] == 'HSIL - NIC II' || $resultado['resul_cito'] == 'HSIL-NIC-III' || $resultado['resul_cito'] == 'HSIL-Ca In Situ' ||
                   $resultado['resul_cito'] == 'HSIL SOSPECHA DE INVASIÓN' || $resultado['resul_cito'] == 'CARCINOMA CÉLULAS ESCAMOSAS'
                   ){
                    $conducta = "Colposcopia Biopsia";
                }
            }
        }
        if($conducta == ""){
            echo "revisar resultados no categorizados: ";
            print_r($resultado);
            echo "<br>";
        } 
        return $conducta;
    }

    public function asignarResultadoVPH($resultado) {
        $vph = "";
        if ($resultado['vph_genotipo_16'] == 'Positivo') {
            $vph = " VPH-16";
        }
        if ($resultado['vph_genotipo_18'] == 'Positivo') {
            $vph = $vph . " VPH-18";
        }
        if ($resultado['vph_otros'] == 'Positivo') {
            $vph = $vph . " VPH-Otros";
        }
        if ($vph == "") {
            $vph = "Negativo";
        }
        return trim($vph);
    }

    public function asignarResultadoCL($resultado) {
        $resul_cito = "";
        if ($resultado['calidad_muestra'] == 'Satisfactoria con endocervicales/zona de transformación' || $resultado['calidad_muestra'] == 'Satisfactoria sin endocervicales/zona de transformación') {//2
            if ($resultado['categorizacion_general'] == 'Anormalidades en células epiteliales') {//Inicio if Categorizacion general
                if ($resultado['anor_cel_escamosas'] == 'Células escamosas atípicas de significado ind. (ASC-US)') {
                    $resul_cito = 'ASC-US';
                }
                if ($resultado['anor_cel_escamosas'] == 'Células escamosas atípicas que no puede excluir HSIL (ASC-H)') {
                    $resul_cito = 'HSIL (ASC H)';
                }
                if ($resultado['anor_cel_escamosas'] == 'Lesión Intraepitelial escamosa de bajo grado (LSIL) - Cambios citopáticos por VPH') {
                    $resul_cito = 'LSIL-CAMBIOS CITOPÁTICOS POR VPH';
                }
                if ($resultado['anor_cel_escamosas'] == 'Lesión Intraepitelial escamosa de bajo grado (LSIL) - Displasia leve (NICI)') {
                    $resul_cito = 'LSIL-NIC I';
                }
                if ($resultado['anor_cel_escamosas'] == 'Lesión Escamosa intraepitelial de alto grado (HSIL) - NIC II') {
                    $resul_cito = 'HSIL - NIC II';
                }
                if ($resultado['anor_cel_escamosas'] == 'Lesión Escamosa intraepitelial de alto grado (HSIL) - NIC III') {
                    $resul_cito = 'HSIL-NIC-III';
                }
                if ($resultado['anor_cel_escamosas'] == 'Lesión Escamosa intraepitelial de alto grado (HSIL) - Ca In Situ') {
                    $resul_cito = 'HSIL-Ca In Situ';
                }
                if ($resultado['anor_cel_escamosas'] == 'HSIL sospechosa de invasión') {
                    $resul_cito = 'HSIL SOSPECHA DE INVASIÓN';
                }
                if ($resultado['anor_cel_escamosas'] == 'Carcinoma de células escamosas') {
                    $resul_cito = 'CARCINOMA CÉLULAS ESCAMOSAS';
                } else {// inicio del Else anor_cel_escamosas si esta vacio
                    if ($resultado['anor_cel_escamosas'] == '') {//inicio del if anor_cel-escamosas si esta vacio
                        if ($resultado['anor_cel_glandulares'] == 'Células endocervicales atípicas (NOS)') {
                            $resul_cito = 'ENDOCERV ATIPICAS - NOS';
                        }
                        if ($resultado['anor_cel_glandulares'] == 'Células endometriales atípicas (NOS)') {
                            $resul_cito = 'ENDOMETRIALES ATIPICAS - NOS';
                        }
                        if ($resultado['anor_cel_glandulares'] == 'Células glandulares (NOS)') {
                            $resul_cito = 'CEL GLANDULARES NOS';
                        }
                        if ($resultado['anor_cel_glandulares'] == 'Células endocervicales atípicas que favorecen neoplasia') {
                            $resul_cito = 'ENDOCERV ATIPICAS FAVORECEN NEOPLASIA';
                        }
                        if ($resultado['anor_cel_glandulares'] == 'Células glandulares atípicas que favorecen neoplasia') {
                            $resul_cito = 'GLANDULARES ATIPICAS FAVORECEN NEOPLACIA';
                        }
                        if ($resultado['anor_cel_glandulares'] == 'Adenocarcinoma endocervical in situ') {
                            $resul_cito = 'ADENOCARCINOMA ENDOCERVICAL In Situ';
                        }
                        if ($resultado['anor_cel_glandulares'] == 'Adenocarcinoma endocervical') {
                            $resul_cito = 'ADENOCARCINOMA ENDOCERVICAL';
                        }
                        if ($resultado['anor_cel_glandulares'] == 'Adenocarcinoma endometrial') {
                            $resul_cito = 'ADENOCARCINOMA ENDOMETRIAL';
                        }
                        if ($resultado['anor_cel_glandulares'] == 'Adenocarcinoma extrauterino') {
                            $resul_cito = 'ADENOCARCINOMA EXTRAUTERINO';
                        }
                        if ($resultado['anor_cel_glandulares'] == 'Adenocarcinoma (NOS)') {
                            $resul_cito = 'ADENOCARCINOMA - NOS';
                        }
                        if ($resultado['anor_cel_glandulares'] == 'Otras neoplasias') {
                            $resul_cito = 'OTRAS NEOPLASIAS';
                        }
                    }//fin del if anor_cel-escamosas si esta vacio
                }//Fin else anor_cel_escamosas si esta vacio
            }//Inicio if Categorizacion general 
            else {
                if ($resultado['categorizacion_general'] == 'Negativa para lesión intraepitelial o malignidad') {
                    $resul_cito = 'Negativa';
                }
            }
        }//Inicio  if General
        else {
            $resul_cito = 'Insatisfactoria';
        }
        return $resul_cito;
    }

}
