<?php

/*
 * Autor: Jamith Bolaños Vidal
 * Fecha: 08/07/2015
 * Modelo que realiza el acceso a los datos relacionado con la información del reporte de resultados
 */

class Reporte_resultado_model extends CI_Model {

    private $menu;

    function __construct() {
        parent::__construct();
    }

    function getReporteResultado($datos) {
        $inferior = (($datos->current - 1) * $datos->rowCount);
        $superior = $datos->rowCount;
        $this->db->start_cache();
        $this->db->from('view_reporte_consolidado');
        $this->db->where('consolidado is not null');
        if ($datos->searchPhrase !== '') {
            $this->db->where("UPPER(nombre_indicador) like UPPER('%" . $datos->searchPhrase . "%')");
        }
        $this->db->stop_cache();
        $rows["total"] = $this->db->count_all_results();
        $this->db->order_by('id_indicador');
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

    function getReporteResultadoPorId($datos) {
        $inferior = (($datos->current - 1) * $datos->rowCount);
        $superior = $datos->rowCount;
        $this->db->start_cache();
        $this->db->from('view_reporte_consolidado');
        $this->db->where('id_indicador', $datos->idIndicador);
        $this->db->stop_cache();
        $rows["total"] = $this->db->count_all_results();
        $this->db->order_by('fecha_final');
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
        $rows["rows"] = $consulta->result_array();
        $rows["success"] = true;
        return json_encode($rows);
    }
    
    function getReporteResultadoExportar(){
        $headers = array('Indicador', 'Fecha Inicial', 'Fecha Final', 'Buenos Aires', 'Corinto','El Tambo', 'Florencia', 'Guachene', 'Páez', 'Patía', 'Piendamó', 'Puerto Tejada', 'San Sebastián', 'Santander de Quilichao', 'Totoró','Consolidado');
        $this->db->select('nombre_indicador, fecha_inicial, fecha_final, sede_2,sede_3, sede_4, sede_5, sede_6, sede_7, sede_8, sede_9, sede_10, sede_11, sede_12, sede_13, consolidado');
        $this->db->from('view_reporte_consolidado');
        $this->db->where('consolidado is not null');            
        $query = $this->db->get();
        if ($query->num_rows > 0) {
            $table[] = $headers;
            foreach ($query->result() as $row) {
                $table [] = $row;
            }
            return $table;
        } else {
            return null;
        }
    }

}
