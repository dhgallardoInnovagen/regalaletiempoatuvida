<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Listas_embalaje extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('listas_embalaje_model', 'modelo');
        $this->load->helper('utilidades');
    }

    public function index() {
        $datos['contenido_title'] = "Index";
        $datos['contenido'] = "listas_embalaje_view";
        $this->load->view('plantillas/plantilla', $datos);
    }

    public function getDescargarlistas() {

        $datos = new stdClass();
        $tipoArchivo = $this->input->post('tipoArchivo');
        $datos->fechaToma = $this->input->post('fechatoma');
        $datos->municipio = $this->input->post('municipio');
        $datos->ips = $this->input->post('ips');
        $datos->nombre_ips = $this->input->post('nombre_ips');
        $datos->current = 1;
        $datos->rowCount = -1;
        $datos->searchPhrase = "";
        $consulta = json_decode($this->modelo->getEncuestasExportar($datos, false));
        $arreglo = $consulta->rows;
        //generate word
        $this->load->library('Phpword');
        $this->load->helper('download');

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        //$phpWord->getCompatibility()->setOoxmlVersion(14);
        //$phpWord->getCompatibility()->setOoxmlVersion(15);

        $totalReg = count($arreglo);      
        switch ($totalReg) {
            case ($totalReg >= 1 && $totalReg <= 15 ):
                $url2 = APPPATH . 'third_party/'.$tipoArchivo.'2.docx';
                $t = 15;
                break;
            case ($totalReg >= 16 && $totalReg <= 30 ):
                $url2 = APPPATH . 'third_party/'.$tipoArchivo.'3.docx';
                $t = 30;
                break;
            case ($totalReg >= 31 && $totalReg <= 45 ):
                $url2 = APPPATH . 'third_party/'.$tipoArchivo.'4.docx';
                $t = 45;
                break;
            case ($totalReg >= 46 && $totalReg <= 60 ):
                $url2 = APPPATH . 'third_party/'.$tipoArchivo.'5.docx';
                $t = 60;
                break;
            case ($totalReg >= 61 && $totalReg <= 75 ):
                $url2 = APPPATH . 'third_party/'.$tipoArchivo.'6.docx';
                $t = 75;
                break;
            case ($totalReg >= 76 && $totalReg <= 90 ):
                $url2 = APPPATH . 'third_party/'.$tipoArchivo.'7.docx';
                $t = 90;
                break;

            case $totalReg;
                echo false;
        }


        $template = $phpWord->loadTemplate($url2);
        $i = 1;
        $ips = $this->modelo->getIpsbyId($this->input->post('ips'));
        $ips = $ips[0]['nombre_ips'];


        $template->setValue('institucion', $datos->nombre_ips);
        $template->setValue('lugar', $this->input->post('municipio'));
        $template->setValue('fecha', date("Y-m-d"));
        foreach ($arreglo as $dato) {

            $template->setValue('f' . $i, $dato->fecha_toma);
            $template->setValue('n' . $i, $i);
            $template->setValue('i' . $i, $dato->numero_documento);
            $template->setValue('c' . $i, "");
            $template->setValue('e' . $i, "Co-Test");
            $template->setValue('o' . $i, "");

            $i++;
        }

        for ($i; $i <= $t; $i++) {
            $template->setValue('f' . $i, '');
            $template->setValue('n' . $i, '');
            $template->setValue('i' . $i, '');
            $template->setValue('c' . $i, '');
            $template->setValue('e' . $i, '');
            $template->setValue('o' . $i, '');
        }
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $temp_filename = APPPATH . 'third_party/listas.docx';
        $template->saveAs($temp_filename);
        echo $temp_filename;
    }

    public function getExportarEncuestas() {
        $datos = new stdClass();
        $datos->current = $this->input->post('current');
        $datos->rowCount = $this->input->post('rowCount');
        $datos->sort = $this->input->post('sort');
        $datos->searchPhrase = $this->input->post('searchPhrase');
        $datos->verTodo = $this->input->post('verTodo');
        echo ($this->modelo->getInconsistencias($datos));
    }

    public function getEncuestas() {
        $datos = new stdClass();
        $datos->current = $this->input->post('current');
        $datos->fechaToma = $this->input->post('fechaToma');
        $datos->municipio = $this->input->post('municipio');
        $datos->ips = $this->input->post('ips');
        $datos->rowCount = $this->input->post('rowCount');
        $datos->sort = $this->input->post('sort');
        $datos->searchPhrase = $this->input->post('searchPhrase');
        echo ($this->modelo->getEncuestasExportar($datos, false)); // false significa que no desea ocultar el campo fase
    }

    public function getContarDatos() {
        $datos = new stdClass();
        $datos->current = $this->input->post('current');
        $datos->fechaInicial = $this->input->post('fechaInicial');
        $datos->fechaFinal = $this->input->post('fechaFinal');
        $datos->fase = $this->input->post('fase');
        $datos->cedulasIncluir = $this->input->post('cedulasIncluir');
        $datos->cedulasExcluir = $this->input->post('cedulasExcluir');
        $datos->rowCount = $this->input->post('rowCount');
        $datos->sort = $this->input->post('sort');
        $datos->searchPhrase = $this->input->post('searchPhrase');
        echo ($this->modelo->contarDatos($datos));
    }

    public function getIps() {
        echo ($this->modelo->getIps());
    }

    public function getEps() {
        echo ($this->modelo->getEps());
    }

    public function getMunicipios() {
        echo ($this->modelo->getMunicipios());
    }

    public function getGuardarDatos() {
        $datos = new stdClass();
        $id_epidemiologica = $this->input->post('id_epidemiologica');
        $id_toma = $this->input->post('id_toma');
        $fase = $this->input->post('fase');
        $fecha_toma = $this->input->post('fechaToma');
        if ($fecha_toma !== '') {
            $this->modelo->editarFechaToma($id_toma, $fecha_toma, $fase);
        }
        $datos->fecha_envio = $this->input->post('fecha_envio');
        $datos->fecha_reporte = $this->input->post('fecha_reporte');
        $datos->primer_nombre = $this->input->post('primer_nombre');
        $datos->segundo_nombre = $this->input->post('segundo_nombre');
        $datos->primer_apellido = $this->input->post('primer_apellido');
        $datos->segundo_apellido = $this->input->post('segundo_apellido');
        $datos->fecha_nacimiento = $this->input->post('fecha_nacimiento');
        $datos->celular = $this->input->post('celular');
        $datos->telefono = $this->input->post('telefono');
        $datos->municipio = $this->input->post('municipio');
        $datos->ips = $this->input->post('ips');
        $datos->eps = $this->input->post('eps');
        $datos->plan_atencion = $this->input->post('fase');

        $datosBitacora = new stdClass();
        $datosBitacora->id_usuario = $this->session->userdata('id_usuario');
        $datosBitacora->fecha_actividad = date("Y-m-d H:i:s");
        $datosBitacora->actividad = 'Editar Datos Exportar Encuesta';
        $datosBitacora->id_registro = $id_epidemiologica;
        $this->modelo->insertarBitacora($datosBitacora);
        echo ($this->modelo->getGuardarDatos($datos, $id_epidemiologica));
    }

    public function getExportarEncuestasPorId() {
        $datos = new stdClass();
        $datos->idEpidemiologica = $this->input->get('idEpidemiologica');
        echo ($this->modelo->getExportarEncuestasPorId($datos));
    }

    public function eliminarExportarEncuesta() {
        $datos = new stdClass();
        $id_epidemiologica = $this->input->post('idEpidemiologica');
        $numero_documento = $this->input->post('numeroCedula');
        $datosBitacora = new stdClass();
        $datosBitacora->id_usuario = $this->session->userdata('id_usuario');
        $datosBitacora->fecha_actividad = date("Y-m-d H:i:s");
        $datosBitacora->actividad = 'Eliminar Datos Exportar encuesta';
        $datosBitacora->id_registro = $numero_documento;
        $this->modelo->insertarBitacora($datosBitacora);
        echo ($this->modelo->eliminarExportarEncuesta($id_epidemiologica));
    }

    function convert_to_csv($input_array, $output_file_name, $delimiter) {
        /** open raw memory as file, no need for temp files, be careful not to run out of memory thought */
        $f = fopen('php://memory', 'w');
        /** loop through array  */
        foreach ($input_array as $line) {
            /** default php csv handler * */
            $line = (array) $line;
            fputcsv($f, $line, $delimiter);
        }
        /** rewrind the "file" with the csv lines * */
        fseek($f, 0);
        /** modify header to be downloadable csv file * */
        header('Content-Type: application/csv');
        header('Content-Disposition: attachement; filename="' . $output_file_name . '";');
        /** Send file to browser for download */
        fpassthru($f);
    }

    public function exportarEncuestas($fase, $fechaInicial, $fechaFinal, $cedulasIncluir = NULL, $cedulasExcluir = NULL, $cedulasExcluirBoton = NULL) {
        ini_set('default_charset', 'UTF-8');


        $datos = new stdClass();
        $datos->current = "";
        $datos->rowCount = -1;
        $datos->searchPhrase = "";
        $datos->fechaInicial = $fechaInicial;
        $datos->fechaFinal = $fechaFinal;
        $datos->cedulasExcluir = $cedulasExcluir;
        $datos->cedulasIncluir = $cedulasIncluir;
        $datos->cedulasExcluirBoton = $cedulasExcluirBoton;
        $datos->fase = $fase;

        $table = json_decode($this->modelo->getEncuestasExportar($datos, true)); //true parametro para ocultar campo fase 

        $result = $table->rows;
        //print_r($result);
        $this->load->dbutil();
        $this->load->helper('download');
        //$data = $this->dbutil->csv_from_result($result);
        $this->convert_to_csv($result, 'Exportar Encuesta.csv', ',');
        //  force_download("Encuesta" . date("d/m/Y") . ".csv", $result);
        //$this->load->library('excel_pdf_manager');
        //$this->excel_pdf_manager->export($result,"Exportar_encuesta".date("d/m/Y"),".csv");
    }

}
