<?php

/*
 * Autor: Jamith Bolaños Vidal
 * Fecha: 27/05/2015
 * Modelo que realiza el acceso a los datos relacionado con la información de indicadores
 */

class Validar_encuesta_model extends CI_Model {

    private $menu;

    function __construct() {
        parent::__construct();
    }

    function validarEpidemiologica($ced) {
        //$this->db->select('numero_documento, primer_nombre,segundo_nombre, primer_apellido, segundo_apellido, municipio, nombre_encuestador, fecha_reporte, fecha_nacimiento');
        $this->db->select('no_ident, prim_nombre,seg_nombre, prim_apellido, seg_apellido, munic, fecha_cargue, fec_nac, usuario_carga');

        $this->db->from('svstable_encuesta602');
        $this->db->where('no_ident', $ced);
        $consulta = $this->db->get();
        $row = array();
        if ($consulta->num_rows() > 0) {
            $row = $consulta->first_row();
            return $row;
        } else {
            return $row;
        }
    }

    function getEpidemiologicaYCuello($fechacargue, $searchPhrase = NULL) {
        $date = date_create($fechacargue);
        date_modify($date, '+1 day');
        $dia2 = date_format($date, 'Y-m-d');
        // $consulta = $this->db->query("SELECT  svstable_encuesta602.no_ident, svstable_encuesta603.cedula, svstable_encuesta602.fecha_cargue AS fechaepidemiologica, svstable_encuesta602.usuario_carga as usuarioepidemiologica, svstable_encuesta603.fecha_cargue as fechacuello, svstable_encuesta603.usuario_carga AS usuariocuello FROM svstable_encuesta603 FULL OUTER JOIN svstable_encuesta602 ON svstable_encuesta603.cedula = svstable_encuesta602.no_ident WHERE svstable_encuesta603.fecha_cargue >= '".$fechacargue."' AND svstable_encuesta603.fecha_cargue < '".$dia2."'");
        $query = " SELECT *
         FROM (SELECT  svstable_encuesta602.no_ident,
         svstable_encuesta603.cedula, 
         svstable_encuesta602.fecha_cargue AS fechaepidemiologica,
         svstable_encuesta602.usuario_carga as usuarioepidemiologica, 
         svstable_encuesta603.fecha_cargue as fechacuello,
         svstable_encuesta603.usuario_carga AS usuariocuello , 
         svstable_encuesta603.fecha_toma AS fechatoma,
         CASE 
             WHEN  munic = '0'THEN  'Buenos Aires'
             WHEN munic = '1' THEN 'Corinto'
             WHEN munic = '2' THEN 'El Tambo'
             WHEN munic = '3' THEN 'Florencia'
             WHEN munic = '4' THEN 'Guachené'
             WHEN munic = '5' THEN 'Páez'
             WHEN munic = '6' THEN 'Patía'
             WHEN munic = '7' THEN 'Piendamó'
             WHEN munic = '8' THEN 'Puerto Tejada'
             WHEN munic = '9' THEN 'San Sebastián'
             WHEN munic = '10'THEN  'Santander de Quilichao'
             WHEN munic = '11'THEN  'Totoró'
         END AS municipio
     FROM svstable_encuesta602 FULL OUTER JOIN svstable_encuesta603 
     ON  svstable_encuesta603.cedula = svstable_encuesta602.no_ident 
     WHERE svstable_encuesta603.fecha_cargue >= '" . $fechacargue . "' AND svstable_encuesta603.fecha_cargue < '" . $dia2 . "')
        AS Q1 ";

        if ($searchPhrase) {

            $query = $query . "WHERE Q1.municipio like '%" . ucwords(strtolower($searchPhrase)) . "%'";
        }

        $consulta = $this->db->query($query);
        $row = array();
        if ($consulta->num_rows() > 0) {
            $row = $consulta->result_array();
            return $row;
        } else {
            return $row;
        }
    }

    function getCedulasPorFechaMunic($fechacargue, $opt) {

        $date = date_create($fechacargue);
        date_modify($date, '+1 day');


        $dia2 = date_format($date, 'Y-m-d');

        if ($opt == 1) {
            //si la opcion es 1 consulte la tabla encuesta602
            $this->db->select('no_ident');
            $this->db->from('svstable_encuesta602');
            $this->db->where('fecha_cargue >=', $fechacargue);
            $this->db->where('fecha_cargue <', $dia2);

            $consulta = $this->db->get();

            $row = array();
            if ($consulta->num_rows() > 0) {
                $row = $consulta->result_array();
                return $row;
            } else {
                return $row;
            }
        } else {
            //si la opcion es 2 consulte la tabla encuesta603
            $this->db->select('cedula');
            $this->db->from('svstable_encuesta603');
            $this->db->where('fecha_cargue >=', $fechacargue);
            $this->db->where('fecha_cargue <', $dia2);

            $consulta = $this->db->get();

            $row = array();
            if ($consulta->num_rows() > 0) {
                $row = $consulta->result_array();
                return $row;
            } else {
                return $row;
            }
        }
    }

    function validarEstadoCuello($ced) {
        $this->db->select('cedula, nombre_responsable, fecha_toma, fecha_cargue, usuario_carga');
        $this->db->from('svstable_encuesta603');
        $this->db->where('cedula', $ced);
        $consulta = $this->db->get();
        $row = array();
        if ($consulta->num_rows() > 0) {
            $row = $consulta->first_row();
            return $row;
        } else {
            return $row;
        }
    }

    function validarFechaNacimiento($ced) {
        $this->db->select('fec_nac');
        $this->db->from('svstable_encuesta602');
        $this->db->where('no_ident', $ced);
        $consulta = $this->db->get();
        if ($consulta->num_rows() > 0) {
            foreach ($consulta->result() as $row) {
                if (isset($row->fecha_nacimiento)) {
                    if ($row->fecha_nacimiento != null) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    function validarFechaTomaCitologia($ced) {
        $this->db->select('fecha_toma');
        $this->db->from('svstable_encuesta603');
        $this->db->where('cedula', $ced);
        $consulta = $this->db->get();
        if ($consulta->num_rows() > 0) {
            foreach ($consulta->result() as $row) {
                if ($row->fecha_toma != null) {
                    return true;
                }
            }
        }
        return false;
    }

    function reportarInconsistencias($inconsistencias, $estadoInconsistenca) {
        $registros = count($inconsistencias);
        if ($this->db->insert_batch('pin_inconsistencia', $inconsistencias)) {
            $respuesta['success'] = TRUE;
            $respuesta['title'] = 'Operación exitosa';
            $respuesta['msg'] = 'Se ingresaron ' . $registros . " registro(s) nuevo(s)";
        } else {
            $respuesta['success'] = FALSE;
            $respuesta['title'] = 'Error';
            $respuesta['msg'] = 'Ocurrio un error al crear el indicador';
        }
        if ($this->db->insert_batch('pin_estado_inconsistencia', $estadoInconsistenca)) {
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

    function nextValIdInconsistencia() {
        $query = $this->db->query("select nextval('pin_inconsistencia_id_inconsistencia_seq')");
        $array = $query->result();
        return($array[0]->nextval);
    }

    function validarInconsistencia($numeroDocumento) {
        $this->db->select('pin_inconsistencia.id_inconsistencia');
        $this->db->from('pin_inconsistencia');
        $this->db->join('pin_estado_inconsistencia', 'pin_inconsistencia.id_inconsistencia = pin_estado_inconsistencia.id_inconsistencia');
        $this->db->where('estado', 'CREADO');
        $this->db->where('numero_documento', $numeroDocumento);
        $consulta = $this->db->get();
        if ($consulta->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

}
