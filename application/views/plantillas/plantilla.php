<?php
if ($this->session->userdata('logged_in') == TRUE) {
$this->load->view('plantillas/header');
$this->load->view('plantillas/west');
$this->load->view($contenido);
$this->load->view('plantillas/footer');
}else{
    redirect('login');
}