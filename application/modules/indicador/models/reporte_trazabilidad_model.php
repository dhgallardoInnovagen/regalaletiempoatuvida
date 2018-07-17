<?php

/*
 * Autor: Jamith Bolaños Vidal
 * Fecha: 08/07/2015
 * Modelo que realiza el acceso a los datos relacionado con la información del reporte de resultados
 */

class Reporte_trazabilidad_model extends CI_Model {

    private $menu;

    function __construct() {
        parent::__construct();
    }

    function getReporteResultado($datos) {
        $inferior = (($datos->current - 1) * $datos->rowCount);
        $superior = $datos->rowCount;
        $this->db->start_cache();
        $this->db->from('view_reporte_consolidado');
        if ($datos->searchPhrase !== '') {
            $this->db->or_where("UPPER(nombre_indicador) like UPPER('%" . $datos->searchPhrase . "%')");
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

    function getIndicadoresDiligenciados($datos) {
        $inferior = (($datos->current - 1) * $datos->rowCount);
        $superior = $datos->rowCount;
        $this->db->distinct();
        $this->db->select("id_indicador, nombre_indicador, meta");
        $this->db->from('view_reporte_consolidado');

        if ($datos->searchPhrase !== '') {
            $this->db->or_where("UPPER(nombre_indicador) like UPPER('%" . $datos->searchPhrase . "%')");
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

}