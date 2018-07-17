<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sincronizar_datos extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('sincronizar_datos_model', 'modelo');
        $this->load->model('validar_encuesta_model', 'modeloEncuesta');
        $this->load->helper('utilidades');
    }

    public function index() {
        $datos['page_title'] = $this->lang->line('lbl_titulo_pagina_inconsistencia');
        $datos['contenido_title'] = "Index";
        $datos['contenido'] = "sincronizar_datos_view";
        $this->load->view('plantillas/plantilla', $datos);
    }

    public function getDatosTamizadas() {
        $datos = new stdClass();
        $datos->current = $this->input->post('current');
        $datos->rowCount = $this->input->post('rowCount');
        $datos->sort = $this->input->post('sort');
        $datos->searchPhrase = $this->input->post('searchPhrase');
        $datos->verTodo = $this->input->post('verTodo');
        echo ($this->modelo->getDatosTamizadas($datos));
    }

    public function actualizarDatos() {
        $contador = 0;
        $data = $this->modelo->actualizarDatos();
        foreach ($data as $paciente) {
            if ($this->modelo->sinSincronizar($paciente["no_ident"])) {
                $pacienteSinc = $this->getPacienteSincronizar($paciente);
                if ($this->modelo->insertPaciente($pacienteSinc)) {
                    $contador++;
                    $this->modelo->cambiarEstadoSincronizacion($pacienteSinc["cedula"]);
                }
            }
        }
        $respuesta['success'] = true;
        $respuesta['title'] = 'Datos Sincronizados';
        $respuesta['msg'] = 'Se han sincronizado '. $contador.' datos nuevos.';
        echo(json_encode($respuesta));
    }

    public function getPacienteSincronizar($paciente) {
        $tamizada["prim_nombre"] = $paciente["prim_nombre"];
        $tamizada["seg_nombre"] = $paciente["seg_nombre"];
        $tamizada["prim_apellido"] = $paciente["prim_apellido"];
        $tamizada["seg_apellido"] = $paciente["seg_apellido"];
        $tamizada["cedula"] = $paciente["no_ident"];
        $tamizada["tipo_ident"] = $paciente["tipo_ident"];
        $tamizada["estado_civil"] = $paciente["est_civil"];
        //la fecha de nacimiento en la base de datos viene como mm-dd-aaaa hay que cambiarla a aaaa-mm-dd
        $tamizada["fec_nacimiento"] = $this->castDate($paciente['fec_nac'], 'mm-dd-aaaa');
        $tamizada["celular"] = $paciente["celular"];
        $tamizada["procedencia"] = $paciente["proced"];
        if ($paciente["proced"] == "0") { //Cero procedencia urbana
            $tamizada["direccion"] = $paciente["dir"];
        } else { //si no procedencia = 1 rural
            $tamizada["direccion"] = $paciente["vereda"];
        }
        $tamizada["municipio"] = $this->getMunicipioConCodigo($paciente["munic"]);
        $tamizada["ips"] = $paciente["ips"];
        $tamizada["eps"] = $paciente["eps"];
        //la fecha de tamización viene en la bd con fecha dd-mm-aaaa hay que cambiarla a formato aaaa-mm-dd
        $tamizada["fecha_tamizacion"] = $this->castDate($paciente['fecha_toma'], 'dd-mm-aaaa');
        $tamizada["responsable_toma"] = $paciente["nombre_responsable"];
        return $tamizada;
    }

    public function castDate($date, $formato) {
        $fec = explode('-', $date);

        if ($fec[2] > 31) { //si la ultima posición es mayor a 31 (es el año) 
            if ($formato == 'mm-dd-aaaa') {
                $cadenaFecha = $fec[2] . '-' . $fec[0] . '-' . $fec[1];  // se organiza en formtato a-m-d
            } else {//es formato d-m-a
                $cadenaFecha = $fec[2] . '-' . $fec[1] . '-' . $fec[0];  //se organiza en formato a-m-d
            }
            $nuevaFecha = $cadenaFecha;
        } else {
            $nuevaFecha = $date;
        }
        return $nuevaFecha;
    }

    public function getMunicipios() {
        echo ($this->modelo->getMunicipios());
    }

    public function getCategoriaInconsistencia() {
        echo ($this->modelo->getCategoriaInconsistencia());
    }
    
    public function getMunicipioConCodigo($id){
        $municipio = "";
        switch ($id){
            case "0" : $municipio = "Buenos Aires";
                break;
            case "1" : $municipio = "Corinto";
                break;
            case "2" : $municipio = "El Tambo";
                break;
            case "3" : $municipio = "Florencia";
                break;
            case "4" : $municipio = "Guachené";
                break;
            case "5" : $municipio = "Páez";
                break;
            case "6" : $municipio = "Patía";
                break;
            case "7" : $municipio = "Piendamó";
                break;
            case "8" : $municipio = "Puerto Tejada";
                break;
            case "9" : $municipio = "San Sebastián";
                break;
            case "10" : $municipio = "Santander de Quilichao";
                break;
            case "11" : $municipio = "Totoró";
                break;
        }
        return $municipio;
    }

    public function nuevaInconsistencia() {
        $datos = new stdClass();
        $idInconsistencia = $this->modeloEncuesta->nextValIdInconsistencia();
        $datos->id_inconsistencia = $idInconsistencia;
        $datos->numero_documento = $this->input->post('numeroDocumento');
        $datos->nombre_usuaria = $this->input->post('nombreUsuaria');
        $datos->id_categoria = $this->input->post('id_categoria');
        $datos->fecha_encuesta = $this->input->post('fechaEncuesta');
        $datos->procedencia = $this->input->post('municipio');
        $datos->id_municipio = $this->input->post('id_municipio');
        $datos->diligencia = $this->input->post('diligencia');
        $datos->encuesta_epidemiologica = $this->input->post('epidemiologica');
        $datos->encuesta_estado_cuello = $this->input->post('estadoCuello');
        $datos->fecha_nacimiento = $this->input->post('fechaNacimiento');
        $datos->fecha_toma_citologia = $this->input->post('fechaToma');
        $datos->observacion = $this->input->post('observacion');

        $estadoInconsistencia = new stdClass();
        $estadoInconsistencia->id_inconsistencia = $idInconsistencia;
        $estadoInconsistencia->id_usuario = $this->session->userdata('id_usuario');
        $estadoInconsistencia->estado = 'CREADO';
        $estadoInconsistencia->fecha = date("Y-m-d");
        echo ($this->modelo->nuevaInconsistencia($datos, $estadoInconsistencia));
    }

    public function editarInconsistencia() {
        $datos = new stdClass();
        $id_inconsistencia = $this->input->post('id_inconsistencia');
        $datos->numero_documento = $this->input->post('numeroDocumento');
        $datos->nombre_usuaria = $this->input->post('nombreUsuaria');
        $datos->id_categoria = $this->input->post('id_categoria');
        $datos->fecha_encuesta = $this->input->post('fechaEncuesta');
        $datos->procedencia = $this->input->post('municipio');
        $datos->id_municipio = $this->input->post('id_municipio');
        $datos->diligencia = $this->input->post('diligencia');
        $datos->encuesta_epidemiologica = $this->input->post('epidemiologica');
        $datos->encuesta_estado_cuello = $this->input->post('estadoCuello');
        $datos->fecha_nacimiento = $this->input->post('fechaNacimiento');
        $datos->fecha_toma_citologia = $this->input->post('fechaToma');
        $datos->observacion = $this->input->post('observacion');
        echo ($this->modelo->editarInconsistencia($datos, $id_inconsistencia));
    }

    public function getInconsistenciaPorId() {
        $datos = new stdClass();
        $datos->idInconsistencia = $this->input->get('idInconsistencia');
        echo ($this->modelo->getInconsistenciaPorId($datos));
    }

    public function eliminarInconsistencia() {
        $datos = new stdClass();
        $datos->id_inconsistencia = $this->input->post('idInconsistencia');
        $datos->id_usuario = $this->session->userdata('id_usuario');
        $datos->estado = 'ELIMINADO';
        $datos->fecha = date("Y-m-d");

        echo ($this->modelo->eliminarInconsistencia($datos));
    }

    public function solucionarInconsistencia() {
        $fecha_nacimiento = $this->input->post('fechaNacimiento');
        $fecha_toma = $this->input->post('fechaToma');
        $numero_documento = $this->input->post('numeroCedula');
        $idInconsistencia = $this->input->post('idInconsistencia');
        $cambios = false;
        if ($fecha_nacimiento !== '' && $fecha_toma !== '') {
            if ($this->modelo->editarFechaNacimiento($fecha_nacimiento, $numero_documento)) {
                if ($this->modelo->editarFechaToma($fecha_toma, $numero_documento)) {
                    $estadoInconsistencia = new stdClass();
                    $estadoInconsistencia->id_inconsistencia = $idInconsistencia;
                    $estadoInconsistencia->id_usuario = $this->session->userdata('id_usuario');
                    $estadoInconsistencia->estado = 'SOLUCIONADO';
                    $estadoInconsistencia->fecha = date("Y-m-d");
                    $this->modelo->asignarEstadoInconsistencia($estadoInconsistencia);
                    $cambios = true;
                }
            }
        }
        if ($cambios) {
            $rows['success'] = TRUE;
            $rows['title'] = 'Info';
            $rows['msg'] = 'Se realizó la actualización de las encuestas';
        } else {
            $rows['success'] = FALSE;
            $rows['title'] = 'Info';
            $rows['msg'] = 'Ocurrió un error, contacte al administrador del sistema';
        }
        echo json_encode($rows);
    }

    function export_data_all() {   //en el controlador
        $table = $this->modelo->getInconsistenciasExport(true);
        $this->load->library('excel_pdf_manager');
        $this->excel_pdf_manager->export($table, "Datos", "xls");
    }

    function export_data() {   //en el controlador
        $table = $this->modelo->getInconsistenciasExport(false);
        $this->load->library('excel_pdf_manager');
        $this->excel_pdf_manager->export($table, "ReporteInconsistencias", "xls");
    }

}
