<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login_model extends CI_Model {

    public function __construct() {

        parent::__construct();
    }

    public function validarAutenticacionUsuario($nombreUsuario, $password) {
        $this->db->from('par_usuario');
        $this->db->where('nombre_usuario', $nombreUsuario);
        $this->db->where('contrasenia', md5($password)); 
        $query = $this->db->get();     
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function get_usuario_rol($username) {
        $this->db->select('seg_rol.id_rol,seg_rol.nombre_rol, par_usuario.id_usuario, par_usuario.id_ips, par_usuario.id_eps, par_usuario.nombres, par_usuario.apellidos, par_usuario.nombre_usuario, par_usuario.contrasenia, par_usuario.telefono, par_usuario.correo, par_usuario.numero_documento, par_usuario.area_unidad, par_usuario.sistema, par_usuario.foto_usuario');
        $this->db->from('par_usuario');
        $this->db->join('seg_rol_usuario', 'par_usuario.id_usuario = seg_rol_usuario.id_usuario', 'left');
        $this->db->join('seg_rol', 'seg_rol_usuario.id_rol = seg_rol.id_rol', 'left');
        $this->db->where('par_usuario.nombre_usuario', $username);
        $this->db->limit(1);

        $consulta = $this->db->get();       
        return $consulta->first_row();
    }

}
