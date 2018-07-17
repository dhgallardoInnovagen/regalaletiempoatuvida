<?php

class Usuarios_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function verificaruser($user) {
        $consulta = $this->db->get_where('grl_persona', array('nombre_usuario' => $user));
        if ($consulta->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function crearUsuario($numero_identificacion, $nombres, $apellidos, $correo, $fecha_nacimiento, $nombre_usuario, $contrasena) {
        $data = array(
            'numero_identificacion' => $numero_identificacion,
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'correo' => $correo,
            'fecha_nacimiento' => $fecha_nacimiento,
            'nombre_usuario' => $nombre_usuario,
            'contrasena' => md5($contrasena)
        );
        $this->db->insert('grl_persona', $data);
    }

}
?>
        




