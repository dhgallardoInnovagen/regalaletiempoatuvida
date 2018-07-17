<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reporte_tamizacion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('reporte_tamizacion_model', 'modelo');
        $this->load->helper('utilidades');
        $this->load->helper('form','file','');
        $this->lang->load('form_validation', 'english');
    }

    public function index() {
        $datos['page_title'] = "Reporte tamización";
        $datos['contenido_title'] = "Index";
        $datos['contenido'] = "reporte_tamizacion";
        $this->load->view('plantillas/plantilla', $datos);
    }

    public function getReporteTamizacion() {
        $datos = new stdClass();
        $datos->current = $this->input->post('current');
        $datos->rowCount = $this->input->post('rowCount');
        $datos->sort = $this->input->post('sort');
        $datos->searchPhrase = $this->input->post('searchPhrase');
        echo ($this->modelo->getReporteTamizacion($datos));
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

}
