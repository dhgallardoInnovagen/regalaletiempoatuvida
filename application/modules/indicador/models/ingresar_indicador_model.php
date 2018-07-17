<?php

/*
 * Autor: Jamith Bolaños Vidal
 * Fecha: 27/05/2015
 * Modelo que realiza el acceso a los datos relacionado con la información de indicadores
 */

class Ingresar_Indicador_model extends CI_Model {

    private $menu;

    function __construct() {
        parent::__construct();
    }
    function consultarElemento($elemento, $nombreTabla) {
        $this->db->where($elemento);
        $result = $this->db->get($nombreTabla);
        if ($result->num_rows() == 0) {
            return true;
        }
        return false;
    }

    function getIndicadores($datos) {
        $inferior = (($datos->current - 1) * $datos->rowCount);
        $superior = $datos->rowCount;
        $this->db->from('pin_indicador');
        $this->db->join('pin_clasificacion_indicador', 'pin_indicador.id_clasificacion = pin_clasificacion_indicador.id_clasificacion');
        if ($datos->searchPhrase !== '') {
            $this->db->or_where("UPPER(nombre_indicador) like UPPER('%" . $datos->searchPhrase . "%')");
            $this->db->or_where("UPPER(clasificacion) like UPPER('%" . $datos->searchPhrase . "%')");
        }
        if (isset($datos->sort) && is_array($datos->sort)) {
            $order_by = '';
            foreach ($datos->sort as $key => $value)
                $order_by = $order_by . $key . ' ' . $value;
            $datos->order_by = $order_by;
        }
        if (isset($datos->order_by)) {
            $this->db->order_by($datos->order_by);
        }
        if ($datos->rowCount > 0) {
            $this->db->limit($superior, $inferior);
        }
        $consulta = $this->db->get();
        $rows["current"] = $datos->current;
        $rows["rowCount"] = $datos->rowCount;
        $rows["total"] = $consulta->num_rows();
        $rows["rows"] = $consulta->result_array();
        return json_encode($rows);
    }

    function getIndicadorPorId($datos) {
        $this->db->from('pin_indicador');
        $this->db->where('id_indicador', $datos->idIndicador);
        $consulta = $this->db->get();
        $rows["data"] = $consulta->result_array();
        $rows["success"] = true;
        return json_encode($rows);
    }

    function getRegistroIndicador($datos) {
        $inferior = (($datos->current - 1) * $datos->rowCount);
        $superior = $datos->rowCount;
        $this->db->start_cache();
        $this->db->from('view_resultado_indicadores');        
        if ($datos->searchPhrase !== '') {
            $this->db->or_where("UPPER(nombre_indicador) like UPPER('%" . $datos->searchPhrase . "%')");
            $this->db->or_where("UPPER(nombre_municipio) like UPPER('%" . $datos->searchPhrase . "%')");
        }
        if ($this->session->userdata('rol') != 1) { //si no es administrador
            $this->db->where('id_usuario',$this->session->userdata('id_usuario'));
        }
        $this->db->stop_cache();        
        $rows["total"] = $this->db->count_all_results();
        if (isset($datos->sort) && is_array($datos->sort)) {
            $order_by = '';
            foreach ($datos->sort as $key => $value)
                $order_by = $order_by . $key . ' ' . $value;
            $datos->order_by = $order_by;
        }
        if (isset($datos->order_by)) {
            $this->db->order_by($datos->order_by);
        }
        if ($datos->rowCount > 0) {
            $this->db->limit($superior, $inferior);
        }
        $consulta = $this->db->get();
        $rows["current"] = $datos->current;
        $rows["rowCount"] = $datos->rowCount;      
        $rows["rows"] = $consulta->result_array();
        return json_encode($rows);
    }

    function getRegistroIndicadorPorId($datos) {
        $this->db->from('view_resultado_indicadores');
        $this->db->where('id_registro_indicador', $datos->idRegistroIndicador);
        $this->db->order_by('fecha_inicial', 'asc');
        $consulta = $this->db->get();
        $rows["rows"] = $consulta->result_array();
        $rows["success"] = TRUE;
        return json_encode($rows);
    }

    function setRegistroIndicador($datos, $id_registro_indicador) {
        $this->db->where('id_registro_indicador', $id_registro_indicador);
        $this->db->set($datos);
        if ($this->db->update('pin_registro_indicador')) {
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

    function getMunicipios() {
        $this->db->select('id_municipio, codigo_municipio, nombre_municipio');
        $this->db->from('par_municipio');
        $consulta = $this->db->get();
        if ($consulta) {
            $rows["municipios"] = $consulta->result_array();
            $rows["success"] = TRUE;
        }
        return json_encode($rows);
    }

    function crearPeriodos($registrosIndicadores) {
        // $this->db->set($registrosIndicadores);
        $registros = count($registrosIndicadores);
        if ($this->db->insert_batch('pin_registro_indicador', $registrosIndicadores)) {
            $respuesta['success'] = TRUE;
            $respuesta['title'] = 'Operación exitosa';
            $respuesta['msg'] = 'Se ingresaron ' . $registros . " registro(s) nuevo(s)";
        } else {
            $respuesta['success'] = FALSE;
            $respuesta['title'] = 'Error';
            $respuesta['msg'] = 'Ocurrio un error al crear el indicador';
        }
        return json_encode($respuesta);
    }

}
