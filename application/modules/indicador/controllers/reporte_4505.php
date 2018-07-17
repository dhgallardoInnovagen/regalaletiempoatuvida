<?php

if (!defined('BASEPATH'))exit('No direct script access allowed');

class Reporte_4505 extends CI_Controller {

   function __construct() {
    parent::__construct();
    $this->load->model('Reporte_4505_model','modele');
    $this->load->helper('utilidades'); 
}



public function index() {
    $datos['page_title'] = $this->lang->line('lbl_titulo_pagina');
    $datos['contenido_title'] = "Index";
    $datos['contenido'] = "reporte_4505_view";
    $this->load->view('plantillas/plantilla', $datos);
     //$datos['ips']=$this->modele->lista_ips();

}
public function getReporte4505(){
    $datos = new stdClass();
    $datos->current = $this->input->post('current');
    $datos->fechaInicial = $this->input->post('fechaInicial');
    $datos->fechaFinal = $this->input->post('fechaFinal');
    $datos->rowCount = $this->input->post('rowCount');
    $datos->sort = $this->input->post('sort');
    $datos->searchPhrase = $this->input->post('searchPhrase');  
    echo ($this->modele->getReporte4505($datos));  

}
public function exportarReporte4505($fechaInicial, $fechaFinal){
    ini_set('default_charset','UTF-8');
    $datos = new stdClass();
    $datos->current = "";
    $datos->rowCount = -1;
    $datos->searchPhrase = "";  
    $datos->fechaInicial = $fechaInicial;
    $datos->fechaFinal = $fechaFinal;    
    $table = json_decode($this->modele->getReporte4505($datos));   
    $result = $table->rows;
    $this->load->library('excel_pdf_manager');
    $this->excel_pdf_manager->export($result,"Reporte_4505 ".date("d/m/Y"),".csv");
    
}
}
?>