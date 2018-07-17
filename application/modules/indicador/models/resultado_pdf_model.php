<?php

/*
 * Autor: Jamith Bolaños Vidal
 * Fecha: 25/05/2016
 * Modelo para acceso a datos de los resultados en pdf
 */

class Resultado_pdf_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /* Funcionalidad para verificar si un cogido de muestra (nombre del archivo) se encuentra cargado en el sistema. Se verifica en la tabla
     * en donde se ingresan los nombres de los archivos cada que se carga un nuevo pdf, tabla pin_resultados_pdf
     */

    function verificarResultado($nombreArchivo) {
        $this->db->from('pin_resultados_pdf');
        $nombreArchivo = str_replace(".pdf", "", $nombreArchivo);
        $this->db->where('cod_mx', $nombreArchivo);
        $result = $this->db->get();
        if ($result->num_rows() == 0) {
            return true; //el registro no esta en el sistema, se puede ingresar
        }
        return false; //El registro ya se ha cargado previamente al sistema
    }

    function getDatosResultado($nombreArchivo) {
        if ($nombreArchivo != null) {
            $this->db->select('cedula,municipio, cod_mx, fecha_toma, par_eps_homologa.id_eps, par_ips_homologa.id_ips, campania', false);
            $this->db->from('pin_muestras');
            $this->db->join('resultado_epidemiologica', 'cedula = cast(numero_documento as varchar)');
            $this->db->join('par_eps_homologa', ' eps = nombre_eps_homologa');
            $this->db->join('par_ips_homologa', 'ips = nombre_ips_homologa');
            $nombreArchivo = str_replace(".pdf", "", $nombreArchivo);
            $this->db->where('cod_mx', trim($nombreArchivo));
            if ($this->session->userdata('id_ips') != '') { //si no es administrador
                $this->db->where('id_ips', $this->session->userdata('id_ips'));
            }
            if ($this->session->userdata('id_eps') != '') { //si no es administrador
                $this->db->where('id_eps', $this->session->userdata('id_eps'));
            }
            $result = $this->db->get();
            if ($result->num_rows() > 0) {
                $row = $result->first_row();
                $elemento['cedula'] = $row->cedula;
                $elemento['cod_mx'] = $row->cod_mx;
                $elemento['fecha_cargue'] = date("Y-m-d H:i:s");
                $elemento['fecha_toma'] = formato_fecha($row->fecha_toma);
                $elemento['ips'] = $row->id_ips;
                $elemento['eps'] = $row->id_eps;
                $elemento['campania'] = $row->campania;
                $elemento['municipio'] = $row->municipio;
                $elemento['id_usuario'] = $this->session->userdata('id_usuario');
                $elemento['observacion'] = $this->input->post('observacion');
                return $elemento;
            }
        }
        return null;
    }

    //Inserta la información de codigo de muestra, cedula, fecha de cargue y fecha de toam de los resultados cargados al sistema
    function actualizarResultadosCargados($archivosAdicionados) {
        if ($this->db->insert_batch("pin_resultados_pdf", $archivosAdicionados)) {
            return true;
        } else {
            return false;
        }
    }

    //Se obetienen todos los resultados que hayan sido cargados al sistema, de acuerdo a un numero de cedula o numero de orden
    function getResultados($datos) {
        if ($datos->filename != null) {
            $inferior = (($datos->current - 1) * $datos->rowCount);
            $superior = $datos->rowCount;
            $this->db->start_cache();
            $this->db->select('cedula, cod_mx, fecha_toma,fecha_cargue, campania');
            $this->db->from('pin_resultados_pdf');
            if ($this->session->userdata('id_ips') != '') { //si no es administrador
                $this->db->where('ips', $this->session->userdata('id_ips'));
            }
            if ($this->session->userdata('id_eps') != '') { //si no es administrador
                $this->db->where('eps', $this->session->userdata('id_eps'));
            }
            if ($datos->filename != '') {
                $this->db->where($datos->criterio_busqueda, $datos->filename);
            }
            $this->db->stop_cache();
            $rows["total"] = $this->db->count_all_results();
            $this->db->order_by('fecha_toma desc');
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
    }

    function insertarBitacora($datos) {
        $this->db->set($datos);
        if ($this->db->insert('seg_bitacora')) {
            return true;
        }
        return false;
    }

    function getResultadosPDF($datos) {
        $inferior = (($datos->current - 1) * $datos->rowCount);
        $superior = $datos->rowCount;
        $this->db->start_cache();
        $this->db->from('pin_resultados_pdf');
        if ($datos->searchPhrase !== '') {
            $this->db->or_where("cast(cod_mx as varchar) like '%" . $datos->searchPhrase . "%'");
            $this->db->or_where("cast(cedula as varchar) like '%" . $datos->searchPhrase . "%'");
            $this->db->or_where("cast(fecha_cargue as varchar) like '%" . $datos->searchPhrase . "%'");
            $this->db->or_where("cast(fecha_toma as varchar) like '%" . $datos->searchPhrase . "%'");
            $this->db->or_where("cast(campania as varchar) like '%" . $datos->searchPhrase . "%'");
            $this->db->or_where("upper(municipio) like '%" .strtoupper($datos->searchPhrase) . "%'");
        }
        $this->db->stop_cache();
        $rows["total"] = $this->db->count_all_results();
        $this->db->order_by('fecha_cargue', 'desc');
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

    public function descargar_campania($num_campania) {
        $this->db->select('cod_mx');
        $this->db->from('pin_resultados_pdf');
        $this->db->where('campania', $num_campania);
        $result = $this->db->get();
        return $result->result_array();
    }
    
    public function getCorreosNotificacion($campania){
        $this->db->select('correo');
        $this->db->from('pin_resultados_pdf');
        $this->db->join('pin_notificacion_resultados','pin_resultados_pdf.municipio = pin_notificacion_resultados.municipio');
        $this->db->where('campania', $campania);
        $this->db->distinct();
        $result = $this->db->get();
        return $result->result_array();        
    }

    public function getObservacion($cod_mx){
        $this->db->select('observacion');
        $this->db->from('pin_resultados_pdf');        
        $this->db->where('cod_mx', $cod_mx);
        $this->db->limit(1);
        $consulta = $this->db->get();
        $obs = $consulta->result_array();       
        $rows["obs"] = $obs[0]['observacion'];
        $rows["success"] = TRUE;
        return json_encode($rows);
    }
}
