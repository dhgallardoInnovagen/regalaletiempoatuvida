<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gestionar_Usuario extends CI_Controller {

    public function __construct() {
    	parent::__construct();
        $this->load->model('gestionar_usuario_model','modelo');
        $this->load->helper('utilidades'); 
        $this->load->helper('form');
        $this->lang->load('form_validation', 'english');
    }

    public function index() {
        $datos['page_title'] = $this->lang->line('lbl_titulo_pagina');
        $datos['contenido_title'] = "Index";
        $datos['contenido'] = "gestionar_usuario_view";
        $this->load->view('plantillas/plantilla', $datos);

     //$datos['ips']=$this->modele->lista_ips();

    }
    public function getUsuariosPorId() {
        $datos = new stdClass();
        $datos->idUsuario = $this->input->get('idUsuario');
        echo ($this->modelo->getUsuariosPorId($datos));
    }
    public function getGestionarUsuarios() {
        $datos = new stdClass();
        $datos->current = $this->input->post('current');
        $datos->rowCount = $this->input->post('rowCount');
        $datos->sort = $this->input->post('sort');
        $datos->searchPhrase = $this->input->post('searchPhrase');
        echo ($this->modelo->getGestionarUsuarios($datos));
    }
     public function eliminarUsuarios() {
        $datos = new stdClass();
        $id_usuario= $this->input->post('idUsuario');
        $numero_documento = $this->input->post('numeroCedula');  

        $datosBitacora = new stdClass();
        $datosBitacora->id_usuario = $this->session->userdata('id_usuario');
        $datosBitacora->fecha_actividad = date("Y-m-d H:i:s");
        $datosBitacora->actividad = 'Eliminar usuario ';
        $datosBitacora->id_registro = $numero_documento;
        $this->modelo->insertarBitacora($datosBitacora);
        echo ($this->modelo->eliminarUsuario($id_usuario));
        
    }
    public function registro() {
        $this->load->view('registro_view');
    }
    public function getUser() {
        echo ($this->modelo->getUser());
    }
    public function getIps() {
        echo ($this->modelo->getIps());
    }
    public function getEps() {
        echo ($this->modelo->getEps());
    }
    
    public function genId($secuencia) {
        $sql = 'select nextval(\'' . $secuencia . '\')';
        $query = $this->db->query($sql);
        $row = $query->row();
        return $row->nextval;
    }

    public function traerImagen (){
     
    }


    public function crear() {

        $id_user = $this->input->post('usuario');
        $datos = new stdClass();
        $id = $this->modelo->genId('par_usuario_id_usuario_seq');
        $datos->id_usuario = $id;
        $nombre_usuario = $this->input->post('user');
        //Funcion insert id_rol y el id_usuario
        $dato = new stdClass();
        $dato->id_usuario = $id;
        $dato->id_rol = $id_user;
        $this->modelo->crearUsuarioT($dato);
        //Fin funcion Insert
        if ($this->input->post('idIps') >0 ) {
            $datos->id_eps = $this->input->post('idIps');
        } 
        if ($this->input->post('idEps') >0 ) {
            $datos->id_eps = $this->input->post('idEps');
        } 
        $datos->nombres = $this->input->post('nombre');
        $datos->apellidos = $this->input->post('apellido');
        $datos->contrasenia = md5($this->input->post('contrasena'));
        $datos->telefono = $this->input->post('telefono');
        $datos->correo = $this->input->post('correo');
        $datos->numero_documento = $this->input->post('identificacion');
        $datos->sistema = $this->input->post('sistema');
        $datos->area_unidad = $this->input->post('area_unidad');
        //Extraigo los bytes del archivo
        $image = file_get_contents('public/images/user.png');
        $imagen_convertida = pg_escape_bytea($image);
        $datos->foto_usuario = $imagen_convertida;  
        echo ($this->modelo->crearUsuario($datos,$nombre_usuario));
       


    }


    public function getGuardarDatos() {
        $numero_documento= $this->input->post('numero_documento');
        $id_usuario= $this->input->post('id_usuario');
        $datos = new stdClass();
        if ($this->input->post('id_ips') >0 ) {
        $datos->id_ips = $this->input->post('id_ips');
        }
        if ($this->input->post('id_eps') >0 ) {
            $datos->id_eps = $this->input->post('id_eps');
        }
        $datos->id_usuario = $this->input->post('id_usuario');
        $datos->nombres = $this->input->post('nombres');
        $datos->apellidos = $this->input->post('apellidos');
        $datos->nombre_usuario = $this->input->post('user');
        $datos->contrasenia = md5($this->input->post('contrasena'));
        $datos->telefono = $this->input->post('telefono');
        $datos->correo = $this->input->post('correo');
        $datos->numero_documento = $this->input->post('numero_documento');
        $datos->area_unidad = $this->input->post('area');
        $datos->sistema = $this->input->post('sistema');
        $datosBitacora = new stdClass();
        $datosBitacora->id_usuario = $this->session->userdata('id_usuario');
        $datosBitacora->fecha_actividad = date("Y-m-d H:i:s");
        $datosBitacora->actividad = 'modificar usuario';
        $datosBitacora->id_registro = $numero_documento;
        $this->modelo->insertarBitacora($datosBitacora);
        echo ($this->modelo->getGuardarDatos($datos, $id_usuario));
        
    }
}

?>