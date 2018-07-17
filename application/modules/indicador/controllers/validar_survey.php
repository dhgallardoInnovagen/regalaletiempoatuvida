<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Validar_survey extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('validar_survey_model', 'modelo');
        $this->load->helper('utilidades');
    }

    public function index() {
        $datos['page_title'] = $this->lang->line('lbl_titulo_pagina_inconsistencia');
        $datos['contenido_title'] = "Index";
        $datos['contenido'] = "validar_survey_view";
        $this->load->view('plantillas/plantilla', $datos);
    }

    public function validarEncuestas1() {
        echo "validad encuestas 1";
        $user = 'ges.informacion@fundacioninnovagen.org';
        $pass = 'KgctGQOrAvT,';
        $surveyEpidemiologica = '2310600'; //Epidemiologica
        $surveyCCU = '2053288'; //encuesta CCU
        $surveyEstadoCuello = '2310627';
        $surveyResultadoCitologia = '2124091';
        $cedula = $_POST['cedula'];

        $status = "&filter[field][0]=[question(9)]&filter[operator][0]==&filter[value][0]={$cedula}";

        $url = "https://restapi.surveygizmo.com/v1/survey/{$surveyCCU}/surveyresponse?user:pass={$user}:{$pass}{$status}";
        echo $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, FALSE);
        $output = curl_exec($ch);
        if ($output === FALSE) {
            die(curl_error($ch));
        }
        $output = json_decode($output);
        // $output = (object) $output;

        if (count($output) < 1) {
            $url = "https://restapi.surveygizmo.com/v1/survey/{$surveyCCU}/surveyresponse?user:pass={$user}:{$pass}{$status}";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            $output = json_decode($output);
        }

        foreach ($output['data'] as $response) {
            $count++;
            unset($row);
            foreach ($response as $key => $value) {
                if ($count == 1) {
                    $header .= "<th>{$key}</th>";
                }
                $row .= "<td>{$value}</td>";
            }
            $trows[] = "<tr>{$row}</tr>";
        }



        echo "<table border='1'>";
        echo "<tr>{$header}</tr>";
        echo join($trows);
        echo "</table>";
    }

    public function validarEncuestas() {
        $cadenaBusqueda = $this->input->post('cedula');
        $tipo_busqueda = $this->input->post('tipoBusqueda');
        $fecha_encuesta = $this->input->post('fecha');
        if ($tipo_busqueda === 'cedula') {
            $this->validarCedula($cadenaBusqueda);
        } else {
            if ($tipo_busqueda == 'telefono') {
                $this->validarTelefono($cadenaBusqueda);
            } else {
                $this->validarFecha($fecha_encuesta);
            }
        }
    }

    public function validarCedula($cedula) {
        $apiToken = '25e8599eb16be8a758df871be969f39958c86507e01a12d8f8';
        $apiTokenSecret = 'A9Cy1AF/t3f0g';
        $surveyEpidemiologica = '2310600'; //Epidemiologica
        $surveyCCU = '2053288'; //encuesta CCU
        $surveyEstadoCuello = '2310627';
        $surveyResultadoCitologia = '2124091';
        $status = "&filter[field][0]=[question(9)]&filter[operator][0]==&filter[value][0]={$cedula}";
        $url = "https://restapi.surveygizmo.com/v1/survey/{$surveyEpidemiologica}/surveyresponse?api_token={$apiToken}&api_token_secret={$apiTokenSecret}{$status}";        
        $output = $this->getSurvey($url);       
        if ($output->total_count < 1) {
            $status = "&filter[field][0]=[question(3)]&filter[operator][0]==&filter[value][0]={$cedula}";
            $url = "https://restapi.surveygizmo.com/v1/survey/{$surveyCCU}/surveyresponse?api_token={$apiToken}&api_token_secret={$apiTokenSecret}{$status}";
            $output = $this->getSurvey($url);
            $arrayData = $output->data;
            $rows["epidemiologica"] = "NO";
            if (count($arrayData) > 0) {// se encuentra en la ENCUESTA  CCU--------------------------
                for ($i = 0; $i < count($arrayData); $i++) {
                    if ($arrayData[$i]->status == 'Complete') {
                        $rows["epidemiologica"] = "SI";
                        $datosEncuesta = $this->converToArray($arrayData[$i]);
                        $rows["numero_documento"] = trim($datosEncuesta[9]);
                        $rows["Nombre"] = $datosEncuesta[10] . " " . $datosEncuesta[11] . " " . $datosEncuesta[12] . " " . $datosEncuesta[13];
                        $rows["municipio"] = $datosEncuesta[21];
                        $rows["ips"] = $datosEncuesta[15];
                        $rows["eps"] = $datosEncuesta[16];
                        $rows["contacto"] = $datosEncuesta[25];
                        $rows["diligencia"] = $datosEncuesta[134];
                        $rows["fecha_encuesta"] = $datosEncuesta[4];
                    }
                }
            }
        } else {
            $arrayData = $output->data; //se encuentra en encuesta EPIDEMIOLOGICA-----------------------
            $rows["epidemiologica"] = "NO";
            if (count($arrayData) > 0) {
                for ($i = 0; $i < count($arrayData); $i++) {
                    if ($arrayData[$i]->status == 'Complete') {
                        $rows["epidemiologica"] = "SI";
                        $datosEncuesta = $this->converToArray($arrayData[$i]);
                        $rows["numero_documento"] = trim($datosEncuesta[14]);
                        $rows["Nombre"] = $datosEncuesta[10] . " " . $datosEncuesta[11] . " " . $datosEncuesta[12] . " " . $datosEncuesta[13];
                        $rows["municipio"] = $datosEncuesta[22];
                        $rows["ips"] = $datosEncuesta[27];
                        $rows["eps"] = $datosEncuesta[28];
                        $rows["contacto"] = $datosEncuesta[20];
                        $rows["diligencia"] = $datosEncuesta[8];
                        $rows["fecha_encuesta"] = $datosEncuesta[4];
                    }
                }
            }
        }
        $statusResultadoCuello = "&filter[field][0]=[question(4)]&filter[operator][0]==&filter[value][0]={$cedula}";
        $url = "https://restapi.surveygizmo.com/v1/survey/{$surveyEstadoCuello}/surveyresponse?api_token={$apiToken}&api_token_secret={$apiTokenSecret}{$statusResultadoCuello}";
        $outputEstadoCuello = $this->getSurvey($url);
        $rows["estadoCuello"] = "NO";
        if ($outputEstadoCuello->total_count < 1) {
            $statusResultadoCuello = "&filter[field][0]=[question(2)]&filter[operator][0]==&filter[value][0]={$cedula}";
            $url = "https://restapi.surveygizmo.com/v1/survey/{$surveyResultadoCitologia}/surveyresponse?api_token={$apiToken}&api_token_secret={$apiTokenSecret}{$statusResultadoCuello}";
            $outputEstadoCuello = $this->getSurvey($url);
            $arrayData = $outputEstadoCuello->data;
            if (count($arrayData) > 0) {
                for ($i = 0; $i < count($arrayData); $i++) {
                    if ($arrayData[$i]->status == 'Complete') {
                        $datosEncuesta = $this->converToArray($arrayData[$i]);
                        $rows["estadoCuello"] = "SI";
                        $rows["fecha_toma"] = $datosEncuesta[29];
                    }
                }
            }
        } else {
            $arrayData = $outputEstadoCuello->data;
            if (count($arrayData) > 0) {
                for ($i = 0; $i < count($arrayData); $i++) {
                    if ($arrayData[0]->status == 'Complete') {
                        $datosEncuesta = $this->converToArray($arrayData[$i]);
                        $rows["estadoCuello"] = "SI";
                        $rows["fecha_toma"] = $datosEncuesta[27];
                    }
                }
            }
        }
        $resultadoValidacion[] = $rows;
        $result['success'] = TRUE;
        $result['title'] = 'Info';
        $result["rows"] = $resultadoValidacion;
        echo json_encode($result);
    }

    public function validarTelefono($telefono) {
        $apiToken = '25e8599eb16be8a758df871be969f39958c86507e01a12d8f8';
        $apiTokenSecret = 'A9Cy1AF/t3f0g';
        $surveyEpidemiologica = '2310600'; //Epidemiologica
        $surveyCCU = '2053288'; //encuesta CCU
        $surveyEstadoCuello = '2310627';
        $surveyResultadoCitologia = '2124091';
        $cedula = -1;
        $status = "&filter[field][0]=[question(15)]&filter[operator][0]==&filter[value][0]={$telefono}";
        $url = "https://restapi.surveygizmo.com/v1/survey/{$surveyEpidemiologica}/surveyresponse?api_token={$apiToken}&api_token_secret={$apiTokenSecret}{$status}";
        $output = $this->getSurvey($url);        
        if ($output->total_count < 1) {
            $status = "&filter[field][0]=[question(19)]&filter[operator][0]==&filter[value][0]={$telefono}";
            $url = "https://restapi.surveygizmo.com/v1/survey/{$surveyCCU}/surveyresponse?api_token={$apiToken}&api_token_secret={$apiTokenSecret}{$status}";
            $output = $this->getSurvey($url);
            $arrayData = $output->data;
            $rows["epidemiologica"] = "NO";
            if (count($arrayData) > 0) {// se encuentra en la ENCUESTA  CCU--------------------------
                for ($i = 0; $i < count($arrayData); $i++) {
                    if ($arrayData[$i]->status == 'Complete') {
                        $rows["epidemiologica"] = "SI";
                        $datosEncuesta = $this->converToArray($arrayData[$i]);
                        $rows["numero_documento"] = $datosEncuesta[9];
                        $cedula = $rows["numero_documento"];
                        $rows["Nombre"] = $datosEncuesta[10] . " " . $datosEncuesta[11] . " " . $datosEncuesta[12] . " " . $datosEncuesta[13];
                        $rows["municipio"] = $datosEncuesta[21];
                        $rows["ips"] = $datosEncuesta[15];
                        $rows["eps"] = $datosEncuesta[16];
                        $rows["contacto"] = $datosEncuesta[25];
                        $rows["diligencia"] = $datosEncuesta[134];
                        $rows["fecha_encuesta"] = $datosEncuesta[4];
                    }
                }
            }
        } else {
            $arrayData = $output->data; //se encuentra en encuesta EPIDEMIOLOGICA-----------------------
//              echo  'validando epidemiologica';
            $rows["epidemiologica"] = "NO";
            if (count($arrayData) > 0) {
                for ($i = 0; $i < count($arrayData); $i++) {
                    if ($arrayData[$i]->status == 'Complete') {
                        $rows["epidemiologica"] = "SI";
                        $datosEncuesta = $this->converToArray($arrayData[$i]);
                        $rows["numero_documento"] = $datosEncuesta[14];
                        $cedula = $rows["numero_documento"];
                        $rows["Nombre"] = $datosEncuesta[10] . " " . $datosEncuesta[11] . " " . $datosEncuesta[12] . " " . $datosEncuesta[13];
                        $rows["municipio"] = $datosEncuesta[22];
                        $rows["ips"] = $datosEncuesta[27];
                        $rows["eps"] = $datosEncuesta[28];
                        $rows["contacto"] = $datosEncuesta[20];
                        $rows["diligencia"] = $datosEncuesta[8];
                        $rows["fecha_encuesta"] = $datosEncuesta[4];
                    }
                }
            }
        }
        if ($cedula != -1) {
            $statusResultadoCuello = "&filter[field][0]=[question(4)]&filter[operator][0]==&filter[value][0]={$cedula}";
            $url = "https://restapi.surveygizmo.com/v1/survey/{$surveyEstadoCuello}/surveyresponse?api_token={$apiToken}&api_token_secret={$apiTokenSecret}{$statusResultadoCuello}";
            $outputEstadoCuello = $this->getSurvey($url);
            $rows["estadoCuello"] = "NO";
            if ($outputEstadoCuello->total_count < 1) {
                $statusResultadoCuello = "&filter[field][0]=[question(2)]&filter[operator][0]==&filter[value][0]={$cedula}";
                $url = "https://restapi.surveygizmo.com/v1/survey/{$surveyResultadoCitologia}/surveyresponse?api_token={$apiToken}&api_token_secret={$apiTokenSecret}{$statusResultadoCuello}";
                $outputEstadoCuello = $this->getSurvey($url);
                $arrayData = $outputEstadoCuello->data;
                if (count($arrayData) > 0) {
                    for ($i = 0; $i < count($arrayData); $i++) {
                        if ($arrayData[$i]->status == 'Complete') {
                            $datosEncuesta = $this->converToArray($arrayData[$i]);
                            $rows["estadoCuello"] = "SI";
                            $rows["fecha_toma"] = $datosEncuesta[29];
                        }
                    }
                }
            } else {
                $arrayData = $outputEstadoCuello->data;
                if (count($arrayData) > 0) {
                    for ($i = 0; $i < count($arrayData); $i++) {
                        if ($arrayData[0]->status == 'Complete') {
                            $datosEncuesta = $this->converToArray($arrayData[$i]);
                            $rows["estadoCuello"] = "SI";
                            $rows["fecha_toma"] = $datosEncuesta[27];
                        }
                    }
                }
            }
        }

        $resultadoValidacion[] = $rows;
        $result['success'] = TRUE;
        $result['title'] = 'Info';
        $result["rows"] = $resultadoValidacion;
        echo json_encode($result);
    }

    public function validarFecha($fechaEnvio) {
        $apiToken = '25e8599eb16be8a758df871be969f39958c86507e01a12d8f8';
        $apiTokenSecret = 'A9Cy1AF/t3f0g';
        $surveyEpidemiologica = '2310600'; //Epidemiologica
        $surveyCCU = '2053288'; //encuesta CCU
        $surveyEstadoCuello = '2310627';
        $surveyResultadoCitologia = '2124091';
        $datesubmmitted = "&filter[field][0]=datesubmitted&filter[operator][0]=>=&filter[value][0]={$fechaEnvio}"; //Submit date greater than 2/23/2011 at 1:23:28 PM
        $url = "https://restapi.surveygizmo.com/v1/survey/{$surveyEpidemiologica}/surveyresponse?resultsperpage=500&api_token={$apiToken}&api_token_secret={$apiTokenSecret}{$datesubmmitted}";
        $outputEpidemiologica = $this->getSurvey($url);
        $url = "https://restapi.surveygizmo.com/v1/survey/{$surveyCCU}/surveyresponse?resultsperpage=500&api_token={$apiToken}&api_token_secret={$apiTokenSecret}{$datesubmmitted}";
        $outputCCU = $this->getSurvey($url);
        $url = "https://restapi.surveygizmo.com/v1/survey/{$surveyEstadoCuello}/surveyresponse?resultsperpage=500&api_token={$apiToken}&api_token_secret={$apiTokenSecret}{$datesubmmitted}";
        $outputEstadoCuello = $this->getSurvey($url);
        $url = "https://restapi.surveygizmo.com/v1/survey/{$surveyResultadoCitologia}/surveyresponse?resultsperpage=500&api_token={$apiToken}&api_token_secret={$apiTokenSecret}{$datesubmmitted}";
        $outputResultadoCitologia = $this->getSurvey($url);
        $arrayEpidemiologica = $this->mergeArrayEpidemiologica($outputEpidemiologica, $outputCCU);
        $arrayEstadoCuello = $this->mergeArrayEstadoCuello($outputEstadoCuello, $outputResultadoCitologia);
        $arrayConsolidado = $this->mergeArrays($arrayEpidemiologica, $arrayEstadoCuello);
        $result['success'] = TRUE;
        $result['title'] = 'Info';
        $result["rows"] = $arrayConsolidado;
        echo json_encode($result);
    }

    public function mergeArrays($arrayEpidemiologica, $arrayEstadoCuello) {
        $arrayConsolidado = array();
        for ($i = 0; $i < count($arrayEpidemiologica); $i++) {
            $cambio = false;
            for ($j = 0; $j < count($arrayEstadoCuello); $j++) {
                if (trim($arrayEpidemiologica[$i]["numero_documento"]) === trim($arrayEstadoCuello[$j]["numero_documento"])) {
                    $elemento = array(
                        "epidemiologica" => "SI",
                        "numero_documento" => $arrayEpidemiologica[$i]["numero_documento"],
                        "Nombre" => $arrayEpidemiologica[$i]["Nombre"],
                        "municipio" => $arrayEpidemiologica[$i]["municipio"],
                        "ips" => $arrayEpidemiologica[$i]["ips"],
                        "eps" => $arrayEpidemiologica[$i]["eps"],
                        "contacto" => $arrayEpidemiologica[$i]["contacto"],
                        "diligencia" => $arrayEpidemiologica[$i]["diligencia"],
                        "fecha_encuesta" => $arrayEpidemiologica[$i]["fecha_encuesta"],
                        "estadoCuello" => "SI",
                        "fecha_toma" => $arrayEstadoCuello[$j]["fecha_toma"]
                    );
                    $cambio = true;
                    $arrayConsolidado[] = $elemento;
                }
            }
            if ($cambio === false) {
                $arrayConsolidado[] = $arrayEpidemiologica[$i];
            }
        }
        for ($j = 0; $j < count($arrayEstadoCuello); $j++) {
            $registrada = false;
            for ($i = 0; $i < count($arrayEpidemiologica); $i++) {
                if (trim($arrayEpidemiologica[$i]["numero_documento"]) === trim($arrayEstadoCuello[$j]["numero_documento"])) {
                    $registrada = true;
                }
            }
            if ($registrada === false) {
                $elemento = array(
                    "epidemiologica" => "NO",
                    "numero_documento" => $arrayEstadoCuello[$j]["numero_documento"],
                    "estadoCuello" => "SI",
                    "fecha_toma" => $arrayEstadoCuello[$j]["fecha_toma"]
                );
                $arrayConsolidado[] = $elemento;
            }
        }
        return $arrayConsolidado;
    }

    public function converToArray($response) {
//        foreach ($output as $response) {
//            unset($row);
        $count = 0;
        foreach ($response as $key => $value) {
            $trows[$count] = trim($value);
            $count++;
        }
        // }
        return $trows;
    }

    public function mergeArrayEpidemiologica($outputEpidemiologica, $outputCCU) {
        $arrayData = $outputEpidemiologica->data;
        $resultadoEncuesta = array();
        if (count($arrayData) > 0) {
            for ($i = 0; $i < count($arrayData); $i++) {
                if ($arrayData[$i]->status == 'Complete') {
                    $datosEncuesta = $this->converToArray($arrayData[$i]);
                    $elemento = array(
                        "epidemiologica" => "SI",
                        "numero_documento" => trim($datosEncuesta[14]),
                        "Nombre" => $datosEncuesta[10] . " " . $datosEncuesta[11] . " " . $datosEncuesta[12] . " " . $datosEncuesta[13],
                        "municipio" => $datosEncuesta[22],
                        "ips" => $datosEncuesta[27],
                        "eps" => $datosEncuesta[28],
                        "contacto" => $datosEncuesta[20],
                        "diligencia" => $datosEncuesta[8],
                        "fecha_encuesta" => $datosEncuesta[4]
                    );
                    $resultadoEncuesta[] = $elemento;
                }
            }
        }

        $arrayData = $outputCCU->data;
        if (count($arrayData) > 0) {
            for ($i = 0; $i < count($arrayData); $i++) {
                if ($arrayData[$i]->status == 'Complete') {
                    $datosEncuesta = $this->converToArray($arrayData[$i]);
                    $elemento = array(
                        "epidemiologica" => "SI",
                        "numero_documento" => trim($datosEncuesta[9]),
                        "Nombre" => $datosEncuesta[10] . " " . $datosEncuesta[11] . " " . $datosEncuesta[12] . " " . $datosEncuesta[13],
                        "municipio" => $datosEncuesta[21],
                        "ips" => $datosEncuesta[15],
                        "eps" => $datosEncuesta[16],
                        "contacto" => $datosEncuesta[25],
                        "diligencia" => $datosEncuesta[134],
                        "fecha_encuesta" => $datosEncuesta[4],
                    );
                    $resultadoEncuesta[] = $elemento;
                }
            }
        }
        return $resultadoEncuesta;
    }

    public function mergeArrayEstadoCuello($outputEstadoCuello, $outputResultadoCitologia) {
//        echo "estado cuello --------------------<br>";
//        print_r($outputEstadoCuello);
//        echo "resultado citologia --------------------<br>";
//        print_r($outputResultadoCitologia);
        $arrayData = $outputEstadoCuello->data;
//        echo "estado cuello --------------------<br>";
//        print_r($arrayData);

        $resultadoEncuesta = array();
        if (count($arrayData) > 0) {
            for ($i = 0; $i < count($arrayData); $i++) {
                if ($arrayData[$i]->status == 'Complete') {
                    $datosEncuesta = $this->converToArray($arrayData[$i]);
                    $elemento = array(
                        "epidemiologica" => "SI",
                        "fecha_toma" => $datosEncuesta[27],
                        "numero_documento" => trim($datosEncuesta[8])
                    );
                    $resultadoEncuesta[] = $elemento;
                }
            }
        }

        $arrayData = $outputResultadoCitologia->data;
//        echo "resultado citologia --------------------<br>";
//        print_r($arrayData);
        if (count($arrayData) > 0) {
            for ($i = 0; $i < count($arrayData); $i++) {
                if ($arrayData[$i]->status == 'Complete') {
                    $datosEncuesta = $this->converToArray($arrayData[$i]);
                    $elemento = array(
                        "epidemiologica" => "SI",
                        "fecha_toma" => $datosEncuesta[29],
                        "numero_documento" => trim($datosEncuesta[8])
                    );
                    $resultadoEncuesta[] = $elemento;
                }
            }
        }
        return $resultadoEncuesta;
    }

    public function getSurvey($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $output = curl_exec($ch);
        if (!$output) {
            print curl_errno($ch) . ': ' . curl_error($ch);
        }
        $output = json_decode($output);
        curl_close($ch);
        return $output;
    }

}
