<?php

class Menu extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->model('Menu_model', 'modelo');
    }

    public function get_menu() {
        echo ($this->modelo->get_menu());
    }

}

