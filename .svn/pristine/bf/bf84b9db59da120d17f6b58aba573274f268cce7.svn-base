<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inconsistencia extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('inconsistencia_model', 'modelo');
        $this->load->model('validar_encuesta_model', 'modeloEncuesta');
        $this->load->helper('utilidades');
    }

    public function index() {
        $datos['page_title'] = $this->lang->line('lbl_titulo_pagina_inconsistencia');
        $datos['contenido_title'] = "Index";
        $datos['contenido'] = "inconsistencia_view";
        $this->load->view('plantillas/plantilla', $datos);
    }

    public function getInconsistencias() {
        $datos = new stdClass();
        $datos->current = $this->input->post('current');
        $datos->rowCount = $this->input->post('rowCount');
        $datos->sort = $this->input->post('sort');
        $datos->searchPhrase = $this->input->post('searchPhrase');
        $datos->verTodo = $this->input->post('verTodo');
        echo ($this->modelo->getInconsistencias($datos));
    }

    public function getMunicipios() {
        echo ($this->modelo->getMunicipios());
    }

    public function getCategoriaInconsistencia() {
        echo ($this->modelo->getCategoriaInconsistencia());
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
        $this->excel_pdf_manager->export($table,"Datos","xls");
    }

    function export_data() {   //en el controlador
        $table = $this->modelo->getInconsistenciasExport(false);
        $this->load->library('excel_pdf_manager');
        $this->excel_pdf_manager->export($table,"ReporteInconsistencias","xls");
    }
}