<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Validar_encuesta extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('validar_encuesta_model', 'modelo');
        $this->load->helper('utilidades');
    }

    public function index() {
        $datos['page_title'] = $this->lang->line('lbl_titulo_pagina_inconsistencia');
        $datos['contenido_title'] = "Index";
        $datos['contenido'] = "validar_encuesta_view";
        
        $this->load->view('plantillas/plantilla', $datos);
    }

    public function gestionarInconsitencia() {
        $datos['page_title'] = $this->lang->line('lbl_titulo_pagina_inconsistencia');
        $datos['contenido_title'] = "Index";
        $datos['contenido'] = "inconsistencia_view";
        $this->load->view('plantillas/plantilla', $datos);
    }

    public function validarCedulas() {
        $cedulas = $this->input->POST('cedulas');
        $this->validarErroresEncuestas($cedulas);
    }

    public function validarMunicfecha(){
        $fechacargue = $this->input->POST('fechacargue');
        $searchPhrase = NULL;
        if($this->input->POST('searchPhrase')){

            $searchPhrase = $this->input->POST('searchPhrase');
        }

       // $municipio = $this->input->POST('municipio');

        $resultado = $this->modelo->getEpidemiologicaYCuello($fechacargue, $searchPhrase);
       // $resultado = $this->modelo->getCedulasPorFechaMunic($fechacargue, 1);
       // $resultado2 = $this->modelo->getCedulasPorFechaMunic($fechacargue, 2);
       $rows['success'] = TRUE;
        $rows['title'] = 'Info';
      $rows["current"] = 1;
      $rows["rowCount"] = 1;
       $rows["total"] = count($resultado);
        $rows['msg'] = 'Se encontró ' . count($resultado) . ' resultados ';
        $rows["rows"] = $resultado;
        echo json_encode($rows);
       



    }

    public function validarErroresEncuestas($cedulas) {
        $FALTA_EPIDEMIOLOGICA = 1;
        $FALTA_ESTADO_CUELLO = 2;
        $SIN_ENCUESTAS = 3;
        $ERROR_FECHA_NACIMIENTO = 4;
        $ERROR_FECHA_TOMA = 5;

        if(is_array($cedulas)){
            $cedula = array_unique($cedulas);
        }
        else{
            $cedula = explode(",", $cedulas);
        }
       
        $cedula = array_unique($cedula);

       
        $resultadoValidacion = array();
        foreach ($cedula as $ced) {
            $epidemiologica = TRUE;
            $estadoCuello = TRUE;
            $fechaTomaCitología = TRUE;
            $fechaNacimiento = TRUE;
            $fechFechaNacimiento = '';
            $fechFechaToma = '';
            $nombreUsuaria = '';
            $municipio = '';
            $nombreEncuestador = '';
            $fechaReporte = NULL;
            $id_categoria = '';
            $fechaCargue602 = '';
            $usuarioCargue602 = '';
            $fechaCargue603 = '';
            $usuarioCargue603 = '';

           
            if ($ced != '' && strlen($ced) < 12) {
                $resultado = $this->modelo->validarEpidemiologica($ced);
                if (!$resultado) {
                    $epidemiologica = FALSE;
                    $fechaNacimiento = FALSE;
                } else {
                    $resultadoFechaNacimiento = $this->modelo->validarFechaNacimiento($ced);
                    $nombreUsuaria = $resultado->prim_nombre . ' ' . $resultado->seg_nombre . ' ' . $resultado->prim_apellido . ' ' . $resultado->seg_apellido;
                    $municipio = $resultado->munic;
                    // $nombreEncuestador = $resultado->nombre_encuestador;
                    $fechaReporte = $resultado->fecha_cargue;
                    $fechaCargue602 = $resultado->fecha_cargue;
                    $fechFechaNacimiento = $resultado->fec_nac;
                    $usuarioCargue602 = $resultado->usuario_carga;
                    if (!$resultadoFechaNacimiento) {
                        $fechaNacimiento = FALSE;
                    }
                }
                $resultadoEstadoCuello = $this->modelo->validarEstadoCuello($ced);
                if (!$resultadoEstadoCuello) {
                    $estadoCuello = FALSE;
                    $fechaTomaCitología = FALSE;
                } else {
                    $nombreEncuestador = $resultadoEstadoCuello->nombre_responsable;
                    $fechaReporte = $resultadoEstadoCuello->fecha_toma;
                    
                    $fechaCargue603 = $resultadoEstadoCuello->fecha_cargue;
                    $usuarioCargue603 = $resultadoEstadoCuello->usuario_carga;
                    $fechFechaToma = $resultadoEstadoCuello->fecha_toma;
                    $resultadoFechaToma = $this->modelo->validarFechaTomaCitologia($ced);
                    if (!$resultadoFechaToma) {
                        $fechaTomaCitología = FALSE;
                    }
                }
            }
            if (!$epidemiologica || !$estadoCuello || !$fechaNacimiento || !$fechaTomaCitología) {
                if (!$epidemiologica && !$estadoCuello) {
                    $id_categoria = $SIN_ENCUESTAS;
                } else {
                    if (!$epidemiologica && $estadoCuello) {
                        $id_categoria = $FALTA_EPIDEMIOLOGICA;
                    } else {
                        if ($epidemiologica && !$estadoCuello) {
                            $id_categoria = $FALTA_ESTADO_CUELLO;
                        } else {
                            if (!$fechaNacimiento) {
                                $id_categoria = $ERROR_FECHA_NACIMIENTO;
                            } else {
                                if (!$fechaTomaCitología) {
                                    $id_categoria = $ERROR_FECHA_TOMA;
                                }
                            }
                        }
                    }
                }

                // case para municipios 


                if($municipio != ''){
                    switch ($municipio) {
                        case '0':
                            $municipio = 'Buenos Aires';
                        break;
                        case '1':
                            $municipio = 'Corinto';
                        break;
                        case '2':
                            $municipio = 'El Tambo';
                        break;
                        case '3':
                        $municipio = 'Florencia';
                        break;
                        case '4':
                            $municipio = 'Guachené';
                        break;
                        case '5':
                            $municipio = 'Páez';
                        break;
                        case '6':
                            $municipio = 'Patía';
                        break;
                        case '7':
                            $municipio = 'Piendamó';
                        break;
                        case '8':
                            $municipio = 'Puerto Tejada';
                        break;
                        case '9':
                        $municipio = 'San Sebastián';
                        break;
                        case '10':
                            $municipio = 'Santander de Quilichao';
                        break;
                        case '11':
                            $municipio = 'Totoró';
                        break;
                        
                     }

                   
           


                }


                $elemento = array(
                    'numero_documento' => $ced,
                    'encuesta_epidemiologica' => ($epidemiologica) ? 'SI' : 'NO',
                    'encuesta_estado_cuello' => ($estadoCuello) ? 'SI' : 'NO',
                    'fecha_nacimiento' => ($fechaNacimiento) ? 'SI' : 'NO',
                    'fecha_toma_citologia' => ($fechaTomaCitología) ? 'SI' : 'NO',
                    'nombre_usuaria' => $nombreUsuaria,
                    'procedencia' => $municipio,
                    'diligencia' => $nombreEncuestador,
                    'fecha_encuesta' => ($fechaReporte == '') ? NULL : $fechaReporte,
                    'id_categoria' => $id_categoria,
                    'fechFechaNacimiento' => $fechFechaNacimiento,
                    'fechFechaToma' => $fechFechaToma,
                    'fechaCargue602' => $fechaCargue602,
                    'fechaCargue603' => $fechaCargue603,
                    'usuarioCargue602' => $usuarioCargue602,
                    'usuarioCargue603' => $usuarioCargue603
                );
                $resultadoValidacion[] = $elemento;
            }
        }
        $rows['success'] = TRUE;
        $rows['title'] = 'Info';
//        $rows["current"] = 1;
//        $rows["rowCount"] = 1;
//        $rows["total"] = count($resultadoValidacion);
        $rows['msg'] = '';
        $rows["rows"] = $resultadoValidacion;
        echo json_encode($rows);
    }

    public function reportarInconsistencias() {
        $inconsistencias = $this->input->post('inconsitencias');
        $arrayInconsistencias = array();
        $estadoInconsistenca = array();
        $banderaValidarModificacion = false;
        for ($index = 0; $index < count($inconsistencias); $index++) {
            if ($this->modelo->validarInconsistencia($inconsistencias[$index]['numero_documento']) == false) {
                $idInconsistencia = $this->modelo->nextValIdInconsistencia();
                $inc = array(
                    'id_inconsistencia' => $idInconsistencia,
                    'encuesta_epidemiologica' => ($inconsistencias[$index]['encuesta_epidemiologica'] == 'SI') ? 't' : 'f',
                    'encuesta_estado_cuello' => ($inconsistencias[$index]['encuesta_estado_cuello'] == 'SI') ? 't' : 'f',
                    'fecha_nacimiento' => ($inconsistencias[$index]['fecha_nacimiento'] == 'SI') ? 't' : 'f',
                    'fecha_toma_citologia' => ($inconsistencias[$index]['fecha_toma_citologia'] == 'SI') ? 't' : 'f',
                    'fecha_encuesta' => ($inconsistencias[$index]['fecha_encuesta'] == '') ? NULL : $inconsistencias[$index]['fecha_encuesta'],
                    'numero_documento' => $inconsistencias[$index]['numero_documento'],
                    'nombre_usuaria' => $inconsistencias[$index]['nombre_usuaria'],
                    'procedencia' => $inconsistencias[$index]['procedencia'],
                    'diligencia' => $inconsistencias[$index]['diligencia'],
                    'id_categoria' => $inconsistencias[$index]['id_categoria']
                );
//                echo '<'.$inconsistencias[$index]['fecha_encuesta'].'>';
                $elemento = array(
                    'id_inconsistencia' => $idInconsistencia,
                    'id_usuario' => $this->session->userdata('id_usuario'),
                    'estado' => 'CREADO',
                    'fecha' => date("Y-m-d")
                );
                $estadoInconsistenca[] = $elemento;
                $arrayInconsistencias[] = $inc;
                $banderaValidarModificacion = true;
            }
        }
        if ($banderaValidarModificacion) {
            echo ($this->modelo->reportarInconsistencias($arrayInconsistencias, $estadoInconsistenca));
        } else {
            $respuesta['success'] = FALSE;
            $respuesta['title'] = 'Error';
            $respuesta['msg'] = 'No se encontraron inconsistencias nuevas para reportar';
            echo json_encode($respuesta);
        }
    }

    public function getCedulasConArchivo() {
        $localFile = $_FILES['inputCedulas']['tmp_name'];
        $handle = fopen($localFile, 'r');
        $cedulas = '';
        while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
            for ($index = 0; $index < count($data); $index++) {
                $cedulas = $cedulas . ',' . $data[$index];
            }
        }
        $respuesta['success'] = TRUE;
        $respuesta['rows'] = $cedulas;
        echo json_encode($respuesta);
    }

}
