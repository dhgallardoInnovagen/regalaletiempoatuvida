<?php

class Menu extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
//        $this->load->model('Menu_model', 'modelo');
    }

    public function get_menu() {
        echo ($this->modelo->get_menu());
    }
     public function index() {
        $datos['page_title'] = $this->lang->line('lbl_titulo_pagina_inconsistencia');
        $datos['contenido_title'] = "Index";
//        $datos['contenido'] = "validarEncuestas";
        $this->load->view('validarEncuestas', $datos);
    }

}

