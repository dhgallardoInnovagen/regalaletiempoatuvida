<?php

/*
 * Autor: Jamith Bolaños Vidal
 * Fecha: 27/05/2015
 * Modelo que realiza el acceso a los datos relacionado con la información de indicadores
 */

class Indicador_model extends CI_Model {

    private $menu;

    function __construct() {
        parent::__construct();
    }

    function importarDatos($resultadoEncuesta, $nombreTabla) {
        if (count($resultadoEncuesta) > 0) {
            if ($this->db->insert_batch($nombreTabla, $resultadoEncuesta)) {
                $respuesta['success'] = TRUE;
                $respuesta['title'] = 'Operación Exitosa';
                $respuesta['msg'] = "Operación exitosa, se almacenaron " . count($resultadoEncuesta) . " elementos nuevos";
            } else {
                $respuesta['success'] = FALSE;
                $respuesta['title'] = 'Error';
                $respuesta['msg'] = 'Ocurrio Un Error Al Crear El Registro';
            }
        } else {
            $respuesta['success'] = FALSE;
            $respuesta['title'] = 'Información';
            $respuesta['msg'] = 'Los datos a ingresar ya están en el sistema o el archivo está vacío';
        }
        return json_encode($respuesta);
    }

    function consultarElemento($elemento, $nombreTabla) {
        if ($elemento != null) {
            $this->db->where($elemento);
            $result = $this->db->get($nombreTabla);           
            if ($result->num_rows() === 0) {             
                return true; //el registro no esta en el sistema, se puede ingresar
            }
        }
        return false;//El registro ya se encuentra almacenado en la BD
    }

    function getIndicadores($datos) {
        $inferior = (($datos->current - 1) * $datos->rowCount);
        $superior = $datos->rowCount;
        $this->db->start_cache();
        $this->db->from('pin_indicador');
        $this->db->join('pin_clasificacion_indicador', 'pin_indicador.id_clasificacion = pin_clasificacion_indicador.id_clasificacion');
        if ($datos->searchPhrase !== '') {
            $this->db->or_where("UPPER(nombre_indicador) like UPPER('%" . $datos->searchPhrase . "%')");
            $this->db->or_where("UPPER(clasificacion) like UPPER('%" . $datos->searchPhrase . "%')");
        }
        $this->db->stop_cache();
        $rows["total"] = $this->db->count_all_results();
        $this->db->order_by('pin_indicador.id_indicador');
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
        $this->db->select("fecha_inicial, fecha_final, numerador, denominador, meta,((numerador/denominador)*coeficiente) as  resultado");
        $this->db->from('pin_registro_indicador');
        $this->db->where('id_indicador', $datos->idIndicador);
        $this->db->order_by('fecha_inicial', 'asc');
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

    function editarIndicador($datos, $idIndicador) {
        $this->db->where('id_indicador', $idIndicador);
        $this->db->set($datos);
        if ($this->db->update('pin_indicador')) {
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

    function nuevoIndicador($datos) {
        $this->db->set($datos);
        if ($this->db->insert('pin_indicador')) {
            $respuesta['success'] = TRUE;
            $respuesta['title'] = 'Operación exitosa';
            $respuesta['msg'] = 'Registro creado con éxito';
        } else {
            $respuesta['success'] = FALSE;
            $respuesta['title'] = 'Error';
            $respuesta['msg'] = 'Ocurrio un error al crear el indicador';
        }
        return json_encode($respuesta);
    }

    function eliminarIndicador($idIndicador) {
        $this->db->where('id_indicador', $idIndicador);
        $this->db->from('pin_registro_indicador');
        if ($this->db->count_all_results() == 0) {
            $this->db->where('id_indicador', $idIndicador);
            $result = $this->db->delete('pin_indicador');
            if ($result) {
                $respuesta['success'] = TRUE;
                $respuesta['title'] = 'El indicador se eliminó con éxito';
                $respuesta['msg'] = 'Registro eliminado con éxito';
            } else {
                $respuesta['success'] = FALSE;
                $respuesta['title'] = 'Advertencia';
                $respuesta['msg'] = 'Ocurrió un error en la eliminación del indicador';
            }
        } else {
            $respuesta['success'] = FALSE;
            $respuesta['title'] = 'Error';
            $respuesta['msg'] = 'El indicador no se puede eliminar, debido a que existen mediciones';
        }
        return json_encode($respuesta);
    }

    function getClasificacionIndicador() {
        $this->db->select('id_clasificacion, clasificacion');
        $this->db->from('pin_clasificacion_indicador');
        $consulta = $this->db->get();
        if ($consulta) {
            $rows["clasificacionIndicador"] = $consulta->result_array();
            $rows["success"] = TRUE;
        }
        return json_encode($rows);
    }

    function getUnidadOperacional() {
        $this->db->select('id_unidad_operacional, unidad_operacional');
        $this->db->from('pin_unidad_operacional');
        $consulta = $this->db->get();
        if ($consulta) {
            $rows["unidad_operacional"] = $consulta->result_array();
            $rows["success"] = TRUE;
        }
        return json_encode($rows);
    }

    function getUsuarios() {
        $this->db->select('id_usuario, nombre_usuario');
        $this->db->from('par_usuario');
        $consulta = $this->db->get();
        if ($consulta) {
            $rows["responsables"] = $consulta->result_array();
            $rows["success"] = TRUE;
        }
        return json_encode($rows);
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

    function getIPSHomologa() {
        $this->db->from('par_ips_homologa');
        $consulta = $this->db->get();
        return $consulta->result_array();
    }

    function getEPSHomologa() {
        $this->db->from('par_eps_homologa');
        $consulta = $this->db->get();
        return $consulta->result_array();
    }

    function getIPS() {
        $this->db->from('par_ips');
        $consulta = $this->db->get();
        if ($consulta) {
            $rows["ips"] = $consulta->result_array();
            $rows["success"] = TRUE;
        } else {
            $rows["success"] = FALSE;
            $rows["msg"] = "Ocurrió un error al recuperar la consulta";
        }
        return json_encode($rows);
    }

    function getEPS() {
        $this->db->from('par_eps');
        $consulta = $this->db->get();
        if ($consulta) {
            $rows["eps"] = $consulta->result_array();
            $rows["success"] = TRUE;
        } else {
            $rows["success"] = FALSE;
            $rows["msg"] = "Ocurrió un error al recuperar la consulta";
        }
        return json_encode($rows);
    }

    function crearHomologos($registrosIPSHomologo, $registrosEPSHomologo) {
        $registrosIPS = count($registrosIPSHomologo);
        $registrosEPS = count($registrosEPSHomologo);
        $respuestaBool = FALSE;
        $titulo = "";
        $cadenaRespuesta = "";
        if (count($registrosIPSHomologo) > 0) {
            if ($this->db->insert_batch('par_ips_homologa', $registrosIPSHomologo)) {
                $respuestaBool = TRUE;
                $respuesta['title'] = 'Operación exitosa';
               $cadenaRespuesta = 'Se ingresaron ' . $registrosIPS . " IPS homologas.";
            } else {
                $respuestaBool = FALSE;
                $respuesta['title'] = 'Error';
                $cadenaRespuesta = 'Ocurrio un error al homologar las IPS';
            }
        }
        if (count($registrosEPSHomologo) > 0) {
            if ($this->db->insert_batch('par_eps_homologa', $registrosEPSHomologo)) {
                $respuestaBool = TRUE;
                $respuesta['title'] = 'Operación exitosa';
                $cadenaRespuesta = $cadenaRespuesta . 'Se ingresaron ' . $registrosEPS . " EPS homologas";
            } else {
                $respuestaBool = FALSE;
                $respuesta['title'] = 'Error';
                $cadenaRespuesta = $cadenaRespuesta. 'Ocurrio un error al homologar las EPS';
            }
        }

        $respuesta['success'] = $respuestaBool;      
        $respuesta['msg'] = $cadenaRespuesta. ", por favor reinicie el cargue de datos.";
        return json_encode($respuesta);
    }
    //Actualiza la vista materializada view_reporte_consolidad, con el fin d eactualizar los datos del reporte, este proceso
    //se realiza siempre después de importar datos de resultados de tamizaciones.
    function actualizar_view_rep_consolidado(){
        $this->db->query("REFRESH MATERIALIZED VIEW VIEW_REPORTE_CONSOLIDADO");        
    }

}
