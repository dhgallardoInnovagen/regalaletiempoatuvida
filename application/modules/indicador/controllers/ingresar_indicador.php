<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ingresar_indicador extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ingresar_indicador_model', 'modelo');
        $this->load->helper('utilidades');
    }

    public function index() {
        $datos['page_title'] = $this->lang->line('lbl_titulo_pagina');
        $datos['contenido_title'] = "Index";
        $datos['contenido'] = "ingresar_indicador_view";
        $this->load->view('plantillas/plantilla', $datos);
    }

    public function getRegistroIndicador() {
        $datos = new stdClass();
        $datos->current = $this->input->post('current');
        $datos->rowCount = $this->input->post('rowCount');
        $datos->sort = $this->input->post('sort');
        $datos->searchPhrase = $this->input->post('searchPhrase');
        echo ($this->modelo->getRegistroIndicador($datos));
    }
    
     public function getRegistroIndicadorPorId() {
        $datos = new stdClass();
        $datos->idRegistroIndicador = $this->input->get('idRegistroIndicador');
        echo ($this->modelo->getRegistroIndicadorPorId($datos));
    }
    
    public function getIndicadorPorId() {
        $datos = new stdClass();
        $datos->idIndicador = $this->input->get('idIndicador');
        echo ($this->modelo->getIndicadorPorId($datos));
    }

    public function editarIndicador() {
        $datos = new stdClass();
        $idIndicador = $this->input->post('idIndicador');
        $datos->nombre_indicador = $this->input->post('nombreIndicador');
        $datos->interpretacion = $this->input->post('interpretacionIndicador');
        $datos->definicion_operacional = $this->input->post('definicionOperacional');
        $datos->coeficiente = $this->input->post('coeficienteIndicador');
        $datos->fuente = $this->input->post('fuenteIndicador');
        $datos->meta = $this->input->post('metaIndicador');
        $datos->id_clasificacion = $this->input->post('clasificacionIndicador');
        $datos->id_unidad_operacional = $this->input->post('unidadOperacional');
        $datos->id_usuario = $this->input->post('idUsuario');
        $datos->mide_todos_municipios = $this->input->post('miteTodosMunicipios');
        $datos->tipo_meta = $this->input->post('tipoMeta');

        echo ($this->modelo->editarIndicador($datos, $idIndicador));
    }

    public function setRegistroIndicador() {
        $datos = new stdClass();
        $id_registro_indicador = $this->input->post('idRegistroIndicador');
        $datos->numerador = $this->input->post('numerador');
        $datos->denominador = $this->input->post('denominador'); 
        $datos->coeficiente = $this->input->post('coeficiente');
        echo ($this->modelo->setRegistroIndicador($datos, $id_registro_indicador));
    }

    public function eliminarIndicador() {
        $idIndicador = $this->input->post('idIndicador');
        echo ($this->modelo->eliminarIndicador($idIndicador));
    }

    public function getClasificacionIndicador() {
        echo ($this->modelo->getClasificacionIndicador());
    }

    public function getUnidadOperacional() {
        echo ($this->modelo->getUnidadOperacional());
    }

    public function getUsuarios() {
        echo ($this->modelo->getUsuarios());
    }

    public function crearPeriodos() {
        $idsIndicadores = $this->input->post('idIndicadores');
        $fechaInicial = $this->input->post('fechaInicial');
        $fechaFinal = $this->input->post('fechaFinal');
        $registrosIndicadores = array();
        foreach ($this->input->post('idIndicadores') as $fila) {
            $indicador = array();
            $respuesta = array();
            $datos = new stdClass();
            $datos->idIndicador = $fila;
            $indicador = json_decode($this->modelo->getIndicadorPorId($datos));
            if ($indicador->data[0]->mide_todos_municipios == 't') {
                $respuesta = json_decode($this->modelo->getMunicipios());
                for ($i = 0; $i < count($respuesta->municipios); $i++) {              
                    if ($respuesta->municipios[$i]->codigo_municipio != 99999) {
                        $elemento = array(
                            'id_indicador' => $indicador->data[0]->id_indicador,
                            'id_municipio' => $respuesta->municipios[$i]->id_municipio,
                            'id_usuario' => $indicador->data[0]->id_usuario,
                            'coeficiente' => $indicador->data[0]->coeficiente,
                            'meta' => $indicador->data[0]->meta,
                            'fecha_inicial' => $fechaInicial,
                            'fecha_final' => $fechaFinal
                        );
                        $registrosIndicadores[] = $elemento;
                    }
                }
            } else {
                $elemento = array(
                    'id_indicador' => $indicador->data[0]->id_indicador,
                    'id_municipio' => 1, //este valor indica que es para el consolidado general OJOOOO
                    'id_usuario' => $indicador->data[0]->id_usuario,
                    'coeficiente' => $indicador->data[0]->coeficiente,
                    'meta' => $indicador->data[0]->meta,
                    'fecha_inicial' => $fechaInicial,
                    'fecha_final' => $fechaFinal
                );
                $registrosIndicadores[] = $elemento;
            }
        }
        echo ($this->modelo->crearPeriodos($registrosIndicadores));  
    }

}