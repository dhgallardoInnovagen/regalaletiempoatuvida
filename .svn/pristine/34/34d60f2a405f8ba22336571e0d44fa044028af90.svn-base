<?php

class Configuracion_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getIps() {
        $this->db->select('id_ips, nombre_ips');
        $this->db->from('par_ips');
        $this->db->order_by('nombre_ips');
        $consulta = $this->db->get();
        if ($consulta) {
            $rows["sedes"] = $consulta->result_array();
            $rows["success"] = TRUE;
        }
        return json_encode($rows);
    }

    function getEps() {
        $this->db->select('id_eps, nombre_eps');
        $this->db->from('par_eps');
        $this->db->order_by('nombre_eps');
        $consulta = $this->db->get();
        if ($consulta) {
            $rows["sedes"] = $consulta->result_array();
            $rows["success"] = TRUE;
        }
        return json_encode($rows);
    }

    function getUser() {
        $this->db->select('id_rol, nombre_rol');
        $this->db->from('seg_rol');
        $consulta = $this->db->get();
        if ($consulta) {
            $rows["sedes"] = $consulta->result_array();
            $rows["success"] = TRUE;
        }
        return json_encode($rows);
    }

    function traerUsuarioFoto() {
        $id = $this->session->userdata('id_usuario');
        $res = pg_query("SELECT foto_usuario FROM par_usuario WHERE id_usuario = $id  ");
        $raw = pg_fetch_result($res, 'foto_usuario');
        // Convert to binary and send to the browser
        header('Content-type: image/jpeg');
        //$dataUri = pg_unescape_bytea($raw);
        print pg_unescape_bytea($raw);
        $file = pg_unescape_bytea($raw);
        header("Content-Disposition: attachment");
        print $file;
    }
    function getUsuariosPorId() {
       $this->db->select('nombres,
        numero_documento,
        correo,
        apellidos,
        telefono');
        $this->db->from('par_usuario');
        $this->db->join('seg_rol_usuario', 'par_usuario.id_usuario = seg_rol_usuario.id_usuario', 'left');
        $this->db->join('seg_rol', 'seg_rol_usuario.id_rol = seg_rol.id_rol', 'left');
        $this->db->where('par_usuario.id_usuario', $this->session->userdata('id_usuario'));
        $consulta = $this->db->get();
        $rows["data"] = $consulta->result_array();
        $rows["success"] = true;
        return json_encode($rows);
    }

    function getGuardarDatos($datos, $id_usuario) {

        $this->db->where('id_usuario', $this->session->userdata('id_usuario'));
        $this->db->set($datos);
        if ($this->db->update('par_usuario')) {
            $respuesta['success'] = TRUE;
            $respuesta['title'] = 'Operación Exitosa';
            $respuesta['msg'] = 'Registro Editado Con Éxito';
        } else {
            $respuesta['success'] = FALSE;
            $respuesta['title'] = 'Error';
            $respuesta['msg'] = 'Ocurrio Un Error Al Editar El Registro';
        }
        return json_encode($respuesta);
    }

    function guardarContrasena($contrasena) {
        $this->db->where('id_usuario', $this->session->userdata('id_usuario'));
        $this->db->set('contrasenia', $contrasena);
        if ($this->db->update('par_usuario')) {
            $respuesta['success'] = TRUE;
            $respuesta['title'] = 'Operación Exitosa';
            $respuesta['msg'] = 'Registro Editado Con Éxito';
        } else {
            $respuesta['success'] = FALSE;
            $respuesta['title'] = 'Error';
            $respuesta['msg'] = 'Ocurrio Un Error Al Editar El Registro';
        }
        return json_encode($respuesta);
    }

}

?>