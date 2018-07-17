<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuracion extends CI_Controller {

    public function __construct() {
    	parent::__construct();
        $this->load->model('configuracion_model','modelo');
        $this->load->helper('utilidades'); 
        $this->load->helper('form','file','');
        $this->lang->load('form_validation', 'english');
    }

    public function index() {
        $datos['page_title'] = "configuracion pagina";
        $datos['contenido_title'] = "Index";
        $datos['contenido'] = "configuracion_view";        
        $this->load->view('plantillas/plantilla', $datos);

     //$datos['ips']=$this->modele->lista_ips();

    }
    public function traerUsuarioFoto() {
        echo ($this->modelo->traerUsuarioFoto());
        
    }
    public function getUsuariosPorId() {
        echo ($this->modelo->getUsuariosPorId());
        
    }
    public function guardarContrasena() {   
       $contrasena = md5($this->input->post('contrasena'));
       echo ($this->modelo->guardarContrasena($contrasena));

   }

   public function getGuardarDatos() {
    $numero_documento= $this->input->post('numero_identificaion');
    $id_usuario = $this->input->post('idUsario');
    $datos = new stdClass();
    $datos->nombres = $this->input->post('nombres');
    $datos->apellidos = $this->input->post('apellidos'); 
    $datos->telefono = $this->input->post('telefono');
    $datos->correo = $this->input->post('correo');
    $datos->numero_documento = $this->input->post('numero_identificacion');
    $nombre = $_FILES['inputImagen']['name'];
    $tmp = $_FILES['inputImagen']['tmp_name'];
        //Extraigo los bytes del archivo
    if ($nombre == "" && $tmp == "" ) {  
    }else {
    $bytesArchivo = file_get_contents($tmp,$nombre);
    $image = pg_escape_bytea($bytesArchivo);
    print_r($image);
    $datos->foto_usuario=$image;  
    }
 echo ($this->modelo->getGuardarDatos($datos, $id_usuario));

}
}