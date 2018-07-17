<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reporte_resultado extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('reporte_resultado_model', 'modelo');
        //$this->load->helper(array('form', 'url'));
        $this->load->helper('utilidades');
    }

    public function index() {
        $datos['page_title'] = $this->lang->line('lbl_titulo_pagina');
        $datos['contenido_title'] = "Index";
        $datos['contenido'] = "reporte_resultado_view";
        $this->load->view('plantillas/plantilla', $datos);
    }

    public function reporteResultado() {
        $datos['page_title'] = $this->lang->line('lbl_titulo_pagina');
        $datos['contenido_title'] = "Index";
        $datos['contenido'] = "reporte_resultado_view";
        $this->load->view('plantillas/plantilla', $datos);
    }

    public function getReporteResultado() {
        $datos = new stdClass();
        $datos->current = $this->input->post('current');
        $datos->rowCount = $this->input->post('rowCount');
        $datos->sort = $this->input->post('sort');
        $datos->searchPhrase = $this->input->post('searchPhrase');
        echo ($this->modelo->getReporteResultado($datos));
    }

    public function getReporteResultadoPorId() {
        $datos = new stdClass();
        $datos = new stdClass();
        $datos->current = $this->input->post('current');
        $datos->rowCount = $this->input->post('rowCount');
        $datos->sort = $this->input->post('sort');
        $datos->searchPhrase = $this->input->post('searchPhrase');
        $datos->idIndicador = $this->input->post('idIndicador');
        echo ($this->modelo->getReporteResultadoPorId($datos));
    }
    
    public function exportarReporteResultado(){
        $table = $this->modelo->getReporteResultadoExportar();
        $this->load->library('excel_pdf_manager');
        $this->excel_pdf_manager->export($table,"Reporte_medicion ".date("d/m/Y"),".xls");
    }

}