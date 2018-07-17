<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
ruta: modules/controllers
<body>
</body>
</html>-->
<?php

class Usuarios extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('usuarios_model');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function index() {


        $this->load->view('registro_view');
    }

    public function registro() {
        $this->load->view('registro_view');
    }

    public function crear() {

        $this->form_validation->set_rules('nombres', 'Nombres', 'required');
        $this->form_validation->set_rules('apellidos', 'Apellidos', 'required');
        $this->form_validation->set_rules('numero_identificacion', 'Numero identificacion', 'required');
        $this->form_validation->set_rules('correo', 'Correo', 'required');
        $this->form_validation->set_rules('fecha_nacimiento', 'Fecha de nacimiento', 'required');
        $this->form_validation->set_rules('username', 'Nombre de usuario', 'required');
        $this->form_validation->set_rules('contrasena', 'Contraseña', 'required');


        if ($this->input->post('submit_reg')) {
            $this->form_validation->set_message('required', 'El campo %s Es Obligatorio');

            if ($this->form_validation->run() == FALSE) {

                $this->load->view('registro_view');
            } else {
                $numero_identificacion = $this->input->post('numero_identificacion');
                $nombres = $this->input->post('nombres');
                $apellidos = $this->input->post('apellidos');
                $correo = $this->input->post('correo');
                $fecha_nacimiento = $this->input->post('fecha_nacimiento');
                $nombre_usuario = $this->input->post('username');
                $contrasena = $this->input->post('contrasena');

                $this->usuarios_model->crearUsuario($numero_identificacion, $nombres, $apellidos, $correo, $fecha_nacimiento, $nombre_usuario, $contrasena);
                echo 'Registro insertado';
            }
        }
    }

}

//$data = array('mensaje'=>'El usuario se registro correctamente');
//this->form_validation->set_rules('institucion_educativa','Institucion_educativa','required');
//this->form_validation->set_rules('grado_semestre','Grado_semestre','required');
//$this->form_validation->set_rules('cargo','Cargo','required');
//$this->load->model('usuarios_model');
?>


<!-- function verificaruser($user)
 {
     $variable= $this->usuarios_model->verificaruser($user);
     if($variable==true)
     {
         return false;
     }
     else
     {
         return true;
     }
 }-->








