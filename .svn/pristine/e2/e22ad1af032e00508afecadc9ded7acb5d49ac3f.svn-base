<?php

/*
 * Autor: Jamith Bolaños Vidal
 * Fecha: 27/05/2015
 * Modelo que realiza el acceso a los datos relacionado con la información de indicadores
 */

class Inconsistencia_model extends CI_Model {

    private $menu;

    function __construct() {
        parent::__construct();
    }

    function getInconsistencias($datos) {
        $inferior = (($datos->current - 1) * $datos->rowCount);
        $superior = $datos->rowCount;
        $this->db->start_cache();
        $this->db->from('view_inconsistencias');
        $consulta = $this->db->get();
        if ($datos->searchPhrase !== '') {
            $this->db->or_where("UPPER(nombre_usuaria) like UPPER('%" . $datos->searchPhrase . "%')");
            $this->db->or_where("UPPER(procedencia) like UPPER('%" . $datos->searchPhrase . "%')");
            $this->db->or_where("UPPER(categoria) like UPPER('%" . $datos->searchPhrase . "%')");
            $this->db->or_where("UPPER(diligencia) like UPPER('%" . $datos->searchPhrase . "%')");
            $this->db->or_where("UPPER(numero_documento) like UPPER('%" . $datos->searchPhrase . "%')");
            $this->db->or_where("UPPER(estado) like UPPER('%" . $datos->searchPhrase . "%')");
        }

        if ($datos->verTodo === 'false') {
            $this->db->where("estado != 'ELIMINADO' AND estado != 'SOLUCIONADO'");
        }
        $this->db->stop_cache();
        $rows["total"] = $this->db->count_all_results();
        $this->db->order_by('fecha_solucion');
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
        $rows["rows"] = $consulta->result_array();
        return json_encode($rows);
    }

    function getMunicipios() {
        $this->db->select('id_municipio, nombre_municipio');
        $this->db->from('par_municipio');
        $this->db->where('UPPER(nombre_municipio) !=', 'CONSOLIDADO');
        $this->db->order_by('nombre_municipio');
        $consulta = $this->db->get();
        if ($consulta) {
            $rows["sedes"] = $consulta->result_array();
            $rows["success"] = TRUE;
        }
        return json_encode($rows);
    }

    function getCategoriaInconsistencia() {
        $this->db->select('id_categoria, categoria');
        $this->db->from('pin_categoria_inconsistencia');
        $this->db->order_by('categoria');
        $consulta = $this->db->get();
        if ($consulta) {
            $rows["categorias"] = $consulta->result_array();
            $rows["success"] = TRUE;
        }
        return json_encode($rows);
    }

    function nuevaInconsistencia($datos, $estadoInconsistencia) {
        $this->db->set($datos);
        if ($this->db->insert('pin_inconsistencia')) {
            $this->db->set($estadoInconsistencia);
            if ($this->db->insert('pin_estado_inconsistencia')) {
                $respuesta['success'] = TRUE;
                $respuesta['title'] = 'Operación exitosa';
                $respuesta['msg'] = 'Registro creado con éxito';
            }
        } else {
            $respuesta['success'] = FALSE;
            $respuesta['title'] = 'Error';
            $respuesta['msg'] = 'Ocurrio un error al crear el indicador';
        }
        return json_encode($respuesta);
    }

    function editarInconsistencia($datos, $id_inconsistencia) {
        $this->db->where('id_inconsistencia', $id_inconsistencia);
        $this->db->set($datos);
        if ($this->db->update('pin_inconsistencia')) {
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

    function getInconsistenciaPorId($datos) {
        $this->db->from('pin_inconsistencia');
        $this->db->where('id_inconsistencia', $datos->idInconsistencia);
        $consulta = $this->db->get();
        $rows["data"] = $consulta->result_array();
        $rows["success"] = true;
        return json_encode($rows);
    }

    function eliminarInconsistencia($datos) {
        $this->db->set($datos);
        if ($this->db->insert('pin_estado_inconsistencia')) {
            $respuesta['success'] = TRUE;
            $respuesta['title'] = 'Operación exitosa';
            $respuesta['msg'] = 'Se cambió el estado de la inconsistencia correctamente';
        } else {
            $respuesta['success'] = FALSE;
            $respuesta['title'] = 'Error';
            $respuesta['msg'] = 'Ocurrio un error al canbiar el estado de la inconsistencia';
        }
        return json_encode($respuesta);
    }

    function editarFechaNacimiento($fecha_nacimiento, $numero_documento) {
        $this->db->where('numero_documento', $numero_documento);
        $this->db->set('fecha_nacimiento', $fecha_nacimiento);
        if ($this->db->update('resultado_epidemiologica')) {
            return TRUE;
        }
        return FALSE;
    }

    function editarFechaToma($fecha_toma, $numero_documento) {
        $this->db->where('numero_cedula', $numero_documento);
        $this->db->set('fecha_toma', $fecha_toma);
        if ($this->db->update('pin_toma_citologia')) {
            return TRUE;
        }
        return FALSE;
    }

    function asignarEstadoInconsistencia($estadoInconsistencia) {
        $this->db->set($estadoInconsistencia);
        if ($this->db->insert('pin_estado_inconsistencia')) {
            $respuesta['success'] = TRUE;
            $respuesta['title'] = 'Operación exitosa';
            $respuesta['msg'] = 'Registro creado con éxito';
        } else {
            $respuesta['success'] = FALSE;
            $respuesta['title'] = 'Ocurrió un error, comuniquese con el administrador del sistema';
            $respuesta['msg'] = 'Registro creado con éxito';
        }
    }

    function getInconsistenciasExport($todos_datos) {        
        $headers = array('Cédula', 'Usuaria', 'Procedencia', 'Encuestador', 'Fecha encuesta', 'Encuesta epidemiológica', 'Encuesta estado del cuello', 'Fecha nacimiento', 'Fecha toma de citologia', 'Categoria', 'Estado', 'Fecha de estado');
        $this->db->select('numero_documento, nombre_usuaria, procedencia, diligencia, fecha_encuesta, encuesta_epidemiologica, encuesta_estado_cuello, fecha_nacimiento, fecha_toma_citologia, categoria, estado, fecha');
        if($todos_datos === false){
            $this->db->where('estado','CREADO');
        }
        
        $query = $this->db->get('view_inconsistencias');
        if ($query->num_rows > 0) {
            $table[] = $headers;
            foreach ($query->result() as $row) {
                if($row->encuesta_epidemiologica === 't'){
                    $row->encuesta_epidemiologica = 'SI';
                }else{
                    $row->encuesta_epidemiologica = 'NO';
                }
                if($row->encuesta_estado_cuello === 't'){
                    $row->encuesta_estado_cuello = 'SI';
                }else{
                    $row->encuesta_estado_cuello = 'NO';
                }
                if($row->fecha_nacimiento === 't'){
                    $row->fecha_nacimiento = 'SI';
                }else{
                    $row->fecha_nacimiento = 'NO';
                }
                if($row->fecha_toma_citologia === 't'){
                    $row->fecha_toma_citologia = 'SI';
                }else{
                    $row->fecha_toma_citologia = 'NO';
                }
                
                $table [] = $row;
            }
            return $table;
        } else
            return null;
    }
}
