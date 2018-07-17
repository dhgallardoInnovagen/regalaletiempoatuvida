<?php

class Gestionar_usuario_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    
    function getGestionarUsuarios($datos) {
        $inferior = (($datos->current - 1) * $datos->rowCount);
        $superior = $datos->rowCount;
        $this->db->start_cache();
        $this->db->select('par_usuario.id_usuario,
            par_usuario.id_ips,
            par_usuario.id_eps,
            par_ips.nombre_ips,
            par_eps.nombre_eps,
            nombres,
            apellidos,
            nombre_usuario,
            contrasenia,
            par_usuario.telefono
            correo,
            numero_documento,
            area_unidad,
            sistema,
            foto_usuario,
           
            ',FAlSE);
        $this->db->from('par_usuario');
        $this->db->join('par_ips', 'par_usuario.id_ips = par_ips.id_ips', 'left');
        $this->db->join('par_eps', 'par_usuario.id_eps = par_eps.id_eps', 'left');
        

        if ($datos->searchPhrase !== '') {
            $this->db->or_where("cast(numero_documento as varchar) like ('%" . $datos->searchPhrase . "%')");
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
    
    function eliminarUsuario($id_usuario) {
       
       $this->db->where('id_usuario', $id_usuario);
       if ($this->db->delete('par_usuario')){
        $respuesta['success'] = TRUE;
        $respuesta['title'] = 'El usuario se eliminó con éxito';
        $respuesta['msg'] = 'Registro eliminado con éxito';
    } else {
        $respuesta['success'] = FALSE;
        $respuesta['title'] = 'Advertencia';
        $respuesta['msg'] = 'Ocurrió un error en la eliminación del usuario';
    }
    return json_encode($respuesta);
}
public function crearUsuario($datos,$nombre_usuario) {
 $this->db->select('nombre_usuario');
 $this->db->from('par_usuario');
 $this->db->where('nombre_usuario',$nombre_usuario);
 $consulta = $this->db->get();

if ( $consulta->num_rows > 0)  {
    $respuesta['success'] = false;
    $respuesta['msg'] = 'Nombre de Usuario Ya Existe';
 
}else {
 $this->db->set('nombre_usuario', $nombre_usuario);
 $this->db->set($datos);
   if ($this->db->insert('par_usuario')) {
    $respuesta['success'] = TRUE;
    $respuesta['title'] = 'Operación exitosa';
    $respuesta['msg'] = 'Registro creado con éxito';
    } else {
    $respuesta['success'] = FALSE;
    $respuesta['title'] = 'Error';
    $respuesta['msg'] = 'Error al  crear usuario';
}
}
return json_encode($respuesta);

}


   /*public function crearUserId($datos){
    $this->db->select('id_usuario,id_rol');
    $this->db->from('par_usuario');
    $this->db->join('seg_rol','par_usuario')

}*/
function insertarBitacora($datos){
   $this->db->set($datos);
   if ($this->db->insert('seg_bitacora')) {
     return true;
 }
 return false;
}
function getUsuariosPorId($datos) {
    $this->db->from('par_usuario');
    $this->db->join('seg_rol_usuario', 'par_usuario.id_usuario = seg_rol_usuario.id_usuario', 'left');
    $this->db->join('seg_rol', 'seg_rol_usuario.id_rol = seg_rol.id_rol', 'left');
    $this->db->where('par_usuario.id_usuario', $datos->idUsuario);

    $consulta = $this->db->get();
    $rows["data"] = $consulta->result_array();
    $rows["success"] = true;
    return json_encode($rows);
}


function getUser() {
    $this->db->select('id_rol, nombre_rol');
    $this->db->from('seg_rol');
    $consulta = $this->db->get();
    if ($consulta) {
        $rows["sedes"] = $consulta->result_array();
        $rows["success"] = TRUE;
    }
    return json_encode($rows);
}
function getIps() {
    $this->db->select('id_ips, nombre_ips');
    $this->db->from('par_ips');
    $this->db->order_by('nombre_ips');
    $consulta = $this->db->get();
    if ($consulta) {
        $rows["sedes"] = $consulta->result_array();
        $rows["success"] = TRUE;
    }
    return json_encode($rows);
}
function getEps() {
    $this->db->select('id_eps, nombre_eps');
    $this->db->from('par_eps');
    $this->db->order_by('nombre_eps');
    $consulta = $this->db->get();
    if ($consulta) {
        $rows["sedes"] = $consulta->result_array();
        $rows["success"] = TRUE;
    }
    return json_encode($rows);
}
function crearUsuarioT($dato){
    $this->db->set($dato);
    if ($this->db->insert('seg_rol_usuario')) {
     return true;
 }
 return false;


}
function genId($secuencia) {
    $sql = 'select nextval(\'' . $secuencia . '\')';
    $query = $this->db->query($sql);
    $row = $query->row();
    return $row->nextval;
}
function getGuardarDatos($datos, $id_usuario) {

    $this->db->where('id_usuario', $id_usuario);
    $this->db->set($datos);
    if ($this->db->update('par_usuario')) {
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


}
?>