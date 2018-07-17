<?php

/*
 * Autor: Jamith Bolaños Vidal
 * Fecha: 27/05/2015
 * Modelo que realiza el acceso a los datos relacionado con la información de indicadores
 */

class Sincronizar_datos_model extends CI_Model {

    private $menu;

    function __construct() {
        parent::__construct();
    }

    function getDatosTamizadas($datos) {
        $inferior = (($datos->current - 1) * $datos->rowCount);
        $superior = $datos->rowCount;
        $this->db->start_cache();
        $this->db->from('pin_tamizadasf4');
        $consulta = $this->db->get();
        if ($datos->searchPhrase !== '') {
            $this->db->or_where("UPPER(prim_nombre) like UPPER('%" . $datos->searchPhrase . "%')");
            $this->db->or_where("UPPER(seg_nombre) like UPPER('%" . $datos->searchPhrase . "%')");
            $this->db->or_where("UPPER(prim_apellido) like UPPER('%" . $datos->searchPhrase . "%')");
            $this->db->or_where("UPPER(seg_apellido) like UPPER('%" . $datos->searchPhrase . "%')");
            $this->db->or_where("cast(cedula as varchar) like UPPER('%" . $datos->searchPhrase . "%')");
            $this->db->or_where("UPPER(municipio) like UPPER('%" . $datos->searchPhrase . "%')");
            $this->db->or_where("UPPER(responsable_toma) like UPPER('%" . $datos->searchPhrase . "%')");
        }

        if ($datos->verTodo === 'false') {
            // $this->db->where("estado != 'ELIMINADO' AND estado != 'SOLUCIONADO'");
        }
        $this->db->stop_cache();
        $rows["total"] = $this->db->count_all_results();
        $this->db->order_by('fecha_tamizacion', 'desc');
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

    function actualizarDatos() {
        $this->db->select('prim_nombre, seg_nombre, prim_apellido, seg_apellido, tipo_ident, no_ident, fec_nac, est_civil, celular, ips, eps, proced, dir, vereda, munic, fecha_toma, nombre_responsable');
        $this->db->from('svstable_encuesta602');
        $this->db->join('svstable_encuesta603', 'cedula = no_ident');
        $this->db->where('svstable_encuesta603.sincronizado is null');
        $consulta = $this->db->get();
        return $consulta->result_array();
    }

    function sinSincronizar($cedula) {
        $this->db->from('pin_tamizadasf4');
        $this->db->where('cedula', $cedula);
        $consulta = $this->db->get();
        $data = $consulta->result_array();
        if (count($data) > 0) {
            return false;
        } else {
            return true;
        }
    }

    function insertPaciente($data) {
        $this->db->set($data);
        if ($this->db->insert('pin_tamizadasf4')) {
            return true;
        } else {
            return false;
        }
    }
    
    function cambiarEstadoSincronizacion($cedula){
        $this->db->where('no_ident', $cedula);
        $datos["sincronizado"] = 'true';
        $this->db->set($datos);
        $this->db->update('svstable_encuesta602');//cambia el estado en la tabla de encuesta epidemiologica
        $this->db->where('cedula', $cedula);
        $this->db->set($datos);
        $this->db->update('svstable_encuesta603');//cambia estado en la tabla de encuesta de cuello  uterino
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
        if ($todos_datos === false) {
            $this->db->where('estado', 'CREADO');
        }

        $query = $this->db->get('view_inconsistencias');
        if ($query->num_rows > 0) {
            $table[] = $headers;
            foreach ($query->result() as $row) {
                if ($row->encuesta_epidemiologica === 't') {
                    $row->encuesta_epidemiologica = 'SI';
                } else {
                    $row->encuesta_epidemiologica = 'NO';
                }
                if ($row->encuesta_estado_cuello === 't') {
                    $row->encuesta_estado_cuello = 'SI';
                } else {
                    $row->encuesta_estado_cuello = 'NO';
                }
                if ($row->fecha_nacimiento === 't') {
                    $row->fecha_nacimiento = 'SI';
                } else {
                    $row->fecha_nacimiento = 'NO';
                }
                if ($row->fecha_toma_citologia === 't') {
                    $row->fecha_toma_citologia = 'SI';
                } else {
                    $row->fecha_toma_citologia = 'NO';
                }

                $table [] = $row;
            }
            return $table;
        } else
            return null;
    }

}
