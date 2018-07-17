<?php

class Menu_model extends CI_Model {

    private $menu;

    function __construct() {
        parent::__construct();

        $this->menu = "";
    }

    function get_menu() {
        $this->get_menu_hijos(0);

        return str_replace(",]", "]", $this->menu);
    }

    private function get_menu_hijos($id_parent) {        
        $this->db->select('SEG_MENU.ID_MENU,SEG_MENU.NOMBRE,SEG_MENU.RUTA');
        $this->db->from('SEG_MENU');
        $this->db->join('SEG_ROL', 'SEG_ROL.ID_ROL = SEG_MENU.ID_ROL');
//        $this->db->join('SEG_ROL_USUARIO', 'SEG_PERSONA_ROL.ID_ROL = SEG_ROL.ID_ROL');
//        $this->db->join('PAR_MODULO','SEG_ROL.MODULO_ROL = PAR_MODULO.ID_MODULO');
//        $this->db->where('SEG_MENU.ID_PARENT', $id_parent);
        //$this->db->where('SEG_PERSONA_ROL.ID_PERSONA', $this->session->userdata('id_persona'));
//        $this->db->where('PAR_MODULO.ID_MODULO',$this->session->userdata('id_modulo'));
        $this->db->order_by('SEG_MENU.NIVEL', 'ASC');
        $consulta = $this->db->get();
        $this->menu .= '[';
        foreach ($consulta->result() as $menu) {
            $count = $this->get_menu_hijos_count($menu->ID_MENU);
            if ($count > 0) {
                $this->menu .= '{"id":"' . $menu->ID_MENU . '","text":"' . $menu->NOMBRE_MENU . '","children":';
                $this->get_menu_hijos($menu->ID_MENU);
                $this->menu .= '},';
            } else {
                $this->menu .= '{"id":"' . $menu->ID_MENU . '","text":"' . $menu->NOMBRE_MENU . '","attributes":{"path":"' . $menu->PATH . '"}},';
            }
        }
        $this->menu .= ']';
    }

    private function get_menu_hijos_count($id_parent) {
        $this->db->from('SEG_MENU');
        $this->db->join('SEG_ROL', 'SEG_ROL.ID_ROL = SEG_MENU.ID_ROL');
//        $this->db->join('SEG_PERSONA_ROL', 'SEG_PERSONA_ROL.ID_ROL = SEG_ROL.ID_ROL');
//        $this->db->join('PAR_EMPLEADO', 'PAR_EMPLEADO.ID_PERSONA = SEG_PERSONA_ROL.ID_PERSONA');

//        $this->db->where('SEG_MENU.ID_PARENT', $id_parent);

        return $this->db->count_all_results();
    }
    
    function get_usuario_menu($nombre_menu) {
        $this->db->select('SEG_MENU.ID_MENU');
        $this->db->from('SEG_MENU');
        $this->db->join('SEG_ROL', 'SEG_ROL.ID_ROL = SEG_MENU.ID_ROL');
//        $this->db->join('SEG_PERSONA_ROL', 'SEG_PERSONA_ROL.ID_ROL = SEG_ROL.ID_ROL');

        $this->db->where('SEG_MENU.NOMBRE', $nombre_menu);
//        $this->db->where('SEG_PERSONA_ROL.ID_PERSONA', $this->session->userdata('id_persona'));

        $consulta = $this->db->get();

        return ($consulta->num_rows() > 0) ? TRUE : FALSE;
    }

}
