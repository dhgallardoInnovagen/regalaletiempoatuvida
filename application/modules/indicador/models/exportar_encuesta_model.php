<?php

/*
 * Autor: Jamith Bolaños Vidal
 * Fecha: 31/03/2016
 * Modelo que realiza el acceso a los datos relacionado con la información de indicadores
 */

class Exportar_encuesta_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getEncuestasExportar($datos, $ocultarCampos) {
      $inferior = (($datos->current - 1) * $datos->rowCount);
      $superior = $datos->rowCount;
      $fase = $datos->fase;
      $cedulasIncluir = $datos->cedulasIncluir;
      $cedulasExcluir = $datos->cedulasExcluir;
      $cedulasExcluirBoton = $datos->cedulasExcluirBoton;
      $fechaInicial = $datos->fechaInicial;
      $fechaFinal = $datos->fechaFinal;
      $headers = array("Date Submitted","Nombre de encuestador","Fecha de encuesta","Primer nombre","Segundo nombre","Primer apellido","Segundo apellido","Número de identificación","Tipo de identificación","Género / Sexo","Estado civil","Fecha de nacimiento","Teléfono","Celular","Departamento","Ciudad","Tipo de zona","Dirección","Barrio","Correo electrónico","IPS","EPS","¿Visita por demanda inducida?","Pertenencia étnica","Nivel educativo","¿A qué se dedica usted actualmente?","Estrato socioeconómico","Descripción del servicio","¿Cuándo fue la fecha de su última citología?","¿Cuál fue el resultado de la citología?","Si su citologìa fue anormal, ¿Cuál fue el resultado?","¿Qué tipo de procedimiento le realizarón?","¿Hace cuánto le realizaron el procedimiento (meses)?","¿Su médico le ha comunicado que alguna vez ha tenido infección por VPH?","¿Cuál ha sido la frecuencia con la que se ha tomado la citología?","Si usted no se ha realizado la citología periódicamente, ¿Cuál ha sido la razón para no hacerlo?","¿Tiene vida sexual activa?","¿Edad de la primera relación sexual (Años)?","¿Número de acompañantes sexuales hasta el momento?","¿Sabe usted si alguno de sus compañeros sexuales ha tenido (o tiene) relaciones con trabajadoras sexuales?","¿Qué método de planificación emplea usted actualmente?","¿Hace cuánto tiempo que emplea el método de planificación (meses)?","¿Ha presentado alguna enfermedad de transmisión sexual?","Si la respuesta es POSITIVA, indique ¿Cuál de las siguientes enfermedades de transmisión sexual ha presentado?","Si su respuesta es otro, indique cual:","¿Sabe usted si alguno de sus compañeros sexuales ha tenido ETS?","¿Alguna de sus familiares ha sufrido de cáncer de cuello uterino?","¿Quienes?","¿Sabe en que consiste el exámen de citología/Papanicolaou?","¿Sabe para qué sirve la citología?","¿Sabe qué es el VPH?","¿Conoce sobre las pruebas de detección del VPH?","¿Cuál prueba se ha realizado?","¿Conoce sobre la vacuna contra el VPH?","¿Se ha aplicado la vacuna contra el VPH?","¿Cuál vacuna se ha aplicado?","¿Cuántas dosis se ha aplicado?","Con respecto la habito de fumar, usted:","¿Si es/fue fumador, cuántos cigarrillos fuma, fumaba por día?","Si es/fue fumador ocasional, cuántos cigarrillos consume/consumía al mes?","¿Por cuántos años ha fumado, o fumo?","¿Cocina usted con leña?","¿Cuántas horas al día?","Hace cuantos años?","¿Consume alimentos ricos en vitamina C (verduras, hortalizas y frutas)?","¿Consume alimentos ricos en beta-carotenos (zanahoria, espinaca, acelga, tomate)?","¿Consume alimentos ricos en vitamina A (productos lácteos, huevos)?","¿Cuál es su peso (kg)?","¿Cuál es su talla (cm)?","¿Fecha de la toma?","Gravidez","Partos","Abortos","Cesáreas","Mortinatos","¿Edad del primer embarazo?","¿Está usted embarazada actualmente?","¿Cuántos meses de embarazo tiene?","¿Fecha del último parto?","¿Edad de la primera menstruación?","¿Fecha de la última menstruación?","¿Edad de la menopausia?","Date Submitted","Número de cédula","¿Atiende por demanda inducida?","Fecha de demanda inducida","Aspectos del cuello uterino","Si su respuesta anterior fue Otro, indique cual:","Observaciones","Responsable de la toma de la citología:","Nombre completo del responsable de la toma de la citología","Fecha de la toma de la citología");
      $sql = 'select * from (
      select distinct
      resultado_epidemiologica.id_epidemiologica,
      resultado_epidemiologica.fecha_envio,
      CASE resultado_epidemiologica.plan_atencion
      when \'REG-CCU FASE 3\' then \'REG-CCUFASE3\'
      when \'Fase III\' THEN \'REG-CCUFASE3\'
      when \'REG-CCU FASE 2\' THEN \'REG-CCUFASE2\'
      when \'Fase II\' THEN \'REG-CCUFASE2\'              
      else resultado_epidemiologica.plan_atencion
      end as fasecon,
    resultado_epidemiologica.nombre_encuestador,
    resultado_epidemiologica.fecha_reporte,
    resultado_epidemiologica.primer_nombre,
    resultado_epidemiologica.segundo_nombre,
    resultado_epidemiologica.primer_apellido,
    resultado_epidemiologica.segundo_apellido,
    resultado_epidemiologica.numero_documento,
    \'CC\' as tipo_cedula,
    \'F\' as genero,
    resultado_epidemiologica.estado_civil,
    resultado_epidemiologica.fecha_nacimiento,
    case resultado_epidemiologica.telefono when \'0\' then resultado_epidemiologica.celular::text else resultado_epidemiologica.telefono::text end as telefono,
    resultado_epidemiologica.celular,
    \'CAUCA\' as departamento,
    resultado_epidemiologica.municipio,
    resultado_epidemiologica.zona,
    resultado_epidemiologica.vereda_direccion,
    resultado_epidemiologica.barrio,
    resultado_epidemiologica.correo_electronico,
    resultado_epidemiologica.ips,
    resultado_epidemiologica.eps,
    resultado_epidemiologica.visita_demanda_inducida,
    resultado_epidemiologica.pertenencia_etnica,
    resultado_epidemiologica.nivel_educativo,
    resultado_epidemiologica.ocupacion,
    resultado_epidemiologica.estrato_socioeconomico,
    resultado_epidemiologica.descripcion_servicio,
    resultado_epidemiologica.fecha_ultima_citologia,
    resultado_epidemiologica.resultado_citologia,
    resultado_epidemiologica.resultado_anormal,
    resultado_epidemiologica.procedimiento_realizado,
    resultado_epidemiologica.tiempo_procedimiento,
    resultado_epidemiologica.padecido_vph,
    resultado_epidemiologica.frecuencia_toma,
    resultado_epidemiologica.razon_frecuencia,
    resultado_epidemiologica.vida_sexual_activa,
    resultado_epidemiologica.edad_primera_relacion_sexual,
    resultado_epidemiologica.num_comp_sexuales,
    resultado_epidemiologica.comp_trab_sexuales,
    resultado_epidemiologica.metodo_planificacion,
    resultado_epidemiologica.tiempo_metodo,
    resultado_epidemiologica.presentado_ets,
    resultado_epidemiologica.cual_ets,
    resultado_epidemiologica.otra_ets,
    resultado_epidemiologica.companero_ets,
    resultado_epidemiologica.familiar_ccu,
    resultado_epidemiologica.quienes,
    resultado_epidemiologica.que_es_papanicolaou,
    resultado_epidemiologica.para_que_sirve_citologia,
    resultado_epidemiologica.que_es_vph,
    resultado_epidemiologica.conoce_pruebas_vph,
    resultado_epidemiologica.que_pruebas_ha_realizado,
    resultado_epidemiologica.conoce_vacuna_vph,
    resultado_epidemiologica.aplicado_vacuna,
    resultado_epidemiologica.que_vacuna,
    resultado_epidemiologica.cuantas_dosis,
    resultado_epidemiologica.es_fumador,
    resultado_epidemiologica.cigarrillos_dia,
    resultado_epidemiologica.cigarrillos_mes,
    resultado_epidemiologica.hace_cuantos_anos_fuma,
    resultado_epidemiologica.cocina_lena,
    resultado_epidemiologica.horas_dia,
    resultado_epidemiologica.hace_cuantos_anos_cocina,
    resultado_epidemiologica.consume_vitamina_c,
    resultado_epidemiologica.consume_beta_caroteno,
    resultado_epidemiologica.consume_vitamina_a,
    resultado_epidemiologica.peso,
    resultado_epidemiologica.talla,
    resultado_epidemiologica.fecha_toma_peso,
    resultado_epidemiologica.gravidez,
    resultado_epidemiologica.partos,
    resultado_epidemiologica.abortos,
    resultado_epidemiologica.cesareas,
    resultado_epidemiologica.mortinatos,
    resultado_epidemiologica.edad_primer_embarazo,
    resultado_epidemiologica.esta_embarazada,
    resultado_epidemiologica.meses_embarazo,
    resultado_epidemiologica.fecha_ultimo_parto,
    resultado_epidemiologica.edad_primera_menstruacion,
    resultado_epidemiologica.fecha_ultima_menstruacion,
    resultado_epidemiologica.edad_menopausia,
    pin_toma_citologia.fecha_envio as fecha_envio_toma,
    pin_toma_citologia.id_toma,
    pin_toma_citologia.numero_cedula,
    pin_toma_citologia.demanda_inducida,
    pin_toma_citologia.fecha_demanda_inducida,
    pin_toma_citologia.estado_cuello,
    pin_toma_citologia.otro_cual,
    pin_toma_citologia.observaciones,
    pin_toma_citologia.responsable_toma,
    pin_toma_citologia.nombre_responsable,
    pin_toma_citologia.fecha_toma
    from pin_toma_citologia  
    inner join resultado_epidemiologica 
    on (pin_toma_citologia.numero_cedula = resultado_epidemiologica.numero_documento)
    where (pin_toma_citologia.fecha_envio >= \'' . $fechaInicial . '\'
    or resultado_epidemiologica.fecha_envio >= \'' . $fechaInicial . '\') and
    (pin_toma_citologia.fecha_envio <= \'' . $fechaFinal . '\'
    or resultado_epidemiologica.fecha_envio <= \'' . $fechaFinal . '\') ';
    if ($datos->searchPhrase !== '') { 
     $sql = $sql.' and cast(numero_documento as varchar) ilike(\'%' .$datos->searchPhrase. '%\')';
     $sql = $sql.' OR (primer_nombre) ilike(\'%' .$datos->searchPhrase. '%\')';
     $sql = $sql.' OR (primer_apellido) ilike(\'%' .$datos->searchPhrase. '%\')';
     $sql = $sql.' OR (nombre_encuestador) ilike(\'%' .$datos->searchPhrase. '%\')';
     $sql = $sql.' OR (segundo_nombre) ilike(\'%' .$datos->searchPhrase. '%\')';
     $sql = $sql.' OR (resultado_epidemiologica.municipio) ilike(\'%' .$datos->searchPhrase. '%\')';
     $sql = $sql.' OR (ips) ilike(\'%' .$datos->searchPhrase. '%\')';
     $sql = $sql.' or (eps) ilike (\'%' .$datos->searchPhrase. '%\')';
 }
 if ($cedulasIncluir !== -999 ) {

    $cedulasIncluir = trim($cedulasIncluir, ",");
    $cedulasIncluir = $this->eliminarComasRepetidas($cedulasIncluir);
    $sql = $sql . ' or pin_toma_citologia.numero_cedula  in (' . $cedulasIncluir . ')';
} 

$sql = $sql. '  )as consulta ';

$sql = $sql . 'where consulta.fasecon  = \'' . $fase . '\' ';



if ($cedulasExcluir !== -999) {
    $cedulasExcluir = trim($cedulasExcluir, ",");
    $cedulasExcluir = $this->eliminarComasRepetidas($cedulasExcluir);
    $sql = $sql . 'and consulta.numero_documento not in (' . $cedulasExcluir . ') ';
}

if ($cedulasExcluirBoton !== -999) {
    $cedulasExcluirBoton = trim($cedulasExcluirBoton, ",");
    $cedulasExcluirBoton = $this->eliminarComasRepetidas($cedulasExcluirBoton);
    $sql = $sql . 'and consulta.id_toma not in (' . $cedulasExcluirBoton . ') ';
}
$sql = $sql. '  order by consulta.municipio, consulta.numero_documento';

if ($datos->rowCount > 0) {
    $sql = $sql . ' limit '.$superior. ' offset  '.$inferior ;
            //$this->db->limit($superior, $inferior);
} 

$query = $this->db->query($sql);

        //Incluir Datos

if (isset($datos->sort) && is_array($datos->sort)) {
    $order_by = '';
    foreach ($datos->sort as $key => $value)
        $order_by = $order_by . $key . ' ' . $value;
    $datos->order_by = $order_by;
}
if (isset($datos->order_by)) {
    $this->db->order_by($datos->order_by);
}
        //Fin
$tableResult = array();
$query = $this->db->query($sql);
 if ($query->num_rows > 0) {//inicio IF 
            $arrayResultado = $query->result();
          if($ocultarCampos === true){
            $tableResult[] = $headers;
          }
            foreach ($arrayResultado as $row) {//inicio foreach
                 $coherenciaIpsMunicipio = true;
                if ($row->municipio == 'Buenos Aires' && ($row->ips != 'BUENOS AIRES' &&  $row->ips != 'ESE NORTE 1 BUENOS AIRES' && $row->ips != 'EMPRESA SOCIAL DEL ESTADO NORTE 1 E.S.E')) {    
                    $coherenciaIpsMunicipio = false;
                }
                if ($row->municipio == 'Corinto' && ($row->ips != 'IPSI ACIN CORINTO' &&  $row->ips != 'ESE NORTE 2 PUNTO DE ATENCIÓN CORINTO' && $row->ips != 'IPS I ACIN CORINTO')){
                  $coherenciaIpsMunicipio = false;
                }
                if ($row->municipio == 'Florencia' && ($row->ips != 'ESE SUROCCIDENTE PUNTO DE ATENCIÓN FLORENCIA' && $row->ips != 'E.S.E SUROCCIDENTE PUNTO DE ATENCIÓN FLORENCIA' )){
                  $coherenciaIpsMunicipio = false;
                }
                if ($row->municipio == 'El Tambo' && ($row->ips != 'E.S.E HOSPITAL EL TAMBO' && $row->ips != 'ESE HOSPITAL EL TAMBO' )){
                  $coherenciaIpsMunicipio = false;
                }
                if ($row->municipio == 'Guachene' && $row->ips != 'ESE NORTE 2 PUNTO DE ATENCIÓN GUACHENÉ' ){
                  $coherenciaIpsMunicipio = false;
                }
                if ($row->municipio == 'Páez' && ($row->ips != 'E.S.E TIERRADENTRO PUNTO DE ATENCIÓN PÁEZ' && $row->ips != 'ESE TIERRADENTRO PUNTO DE ATENCIÓN PÁEZ' && $row->ips != 'E.S.E TIERRADENTRO PUNTO DE ATENCIÓN  PÁEZ' && $row->ips != 'IPS I NASA CXHA CXHA')){
                  $coherenciaIpsMunicipio = false;
                }
                if ($row->municipio == 'Patía' && ($row->ips != 'ESE HOSPITAL NIVEL I EL BORDO' && $row->ips != 'E.S.E HOSPITAL NIVEL I EL BORDO')){
                  $coherenciaIpsMunicipio = false;
                }
                if ($row->municipio == 'Piendamó' && ($row->ips != 'ESE CENTRO I PUNTO DE ATENCIÓN PIENDAMÓ' && $row->ips != 'E.S.E CENTRO I PUNTO DE ATENCIÓN PIENDAMÓ' && $row->ips != 'IPS I TOTOGUAMPA')){
                  $coherenciaIpsMunicipio = false;
                }
                if ($row->municipio == 'Puerto Tejada' && $row->ips != 'ESE NORTE 3 PUNTO DE ATENCIÓN PUERTO TEJADA'){
                  $coherenciaIpsMunicipio = false;
                }
                if ($row->municipio == 'San Sebastián' && ($row->ips != 'ESE SURORIENTE PUNTO DE ATENCIÓN SAN SEBASTIÁN' && $row->ips != 'ESE SURORIENTE PUNTO DE ATENCIÓN SAN SEBASTIAN' && $row->ips != 'E.S.E SURORIENTE  PUNTO DE ATENCIÓN SAN SEBASTIÁN')){
                  $coherenciaIpsMunicipio = false;
                }
                if ($row->municipio == 'Santander de Quilichao' && ($row->ips != 'EMPRESA SOCIAL DEL ESTADO NORTE 1 E.S.E' && $row->ips != 'ESE QUILISALUD' && $row->ips != 'IPSI ACIN SANTANDER DE QUILICHAO' && $row->ips != 'IPS I ACIN SANTANDER DE QUILICHAO' && $row->ips != 'QUILISALUD ESE')){
                  $coherenciaIpsMunicipio = false;
                }
                 if ($row->municipio == 'Totoró' && ($row->ips != 'IPS I NASA CXHA CXHA' && $row->ips != 'ESE QUILISALUD' && $row->ips != 'IPS I NAMOI WASR' && $row->ips != 'ESE POPAYÁN PUNTO DE ATENCIÓN TOTORÓ' && $row->ips != 'IPS I NAMOI WARS' && $row->ips != 'E.S.E POPAYÁN PUNTO DE ATENCIÓN TOTORÓ' && $row->ips != 'IPS I TOTOGUAMPA')){
                  $coherenciaIpsMunicipio = false;
                }
                if($ocultarCampos === true){
                  unset ($row->id_epidemiologica);
                  unset ($row->fasecon);
                  unset ($row->id_toma);

                  
                }else{
                  $row->coherenciaIpsMunicipio = $coherenciaIpsMunicipio; 
                }
                  

                  $tableResult[] = $row;
                }
        }//inicio IF
               else {
              $rows["current"] = $datos->current;
              $rows["rowCount"] = $datos->rowCount;
              $rows["rows"] = $tableResult;
              $rows["total"] = 0;
              return json_encode($rows);             
        }
$rows["current"] = $datos->current;
$rows["rowCount"] = $datos->rowCount;
  $rows["rows"] =  $tableResult;  
$rows["total"] = $this->contarDatos($datos);
return json_encode($rows);

}

function contarDatos($datos)
{  
  $fase = $datos->fase;
  $cedulasIncluir = $datos->cedulasIncluir;
  $cedulasExcluir = $datos->cedulasExcluir;
  $fechaInicial = $datos->fechaInicial;
  $fechaFinal = $datos->fechaFinal;
  $sql = 'select * from (
      select distinct
      resultado_epidemiologica.id_epidemiologica,
      resultado_epidemiologica.fecha_envio,
      CASE resultado_epidemiologica.plan_atencion
      when \'REG-CCU FASE 3\' then \'REG-CCUFASE3\'
      when \'Fase III\' THEN \'REG-CCUFASE3\'
      when \'REG-CCU FASE 2\' THEN \'REG-CCUFASE2\'
      when \'Fase II\' THEN \'REG-CCUFASE2\'              
      else resultado_epidemiologica.plan_atencion
      end as fasecon,
    resultado_epidemiologica.nombre_encuestador,
    resultado_epidemiologica.fecha_reporte,
    resultado_epidemiologica.primer_nombre,
    resultado_epidemiologica.segundo_nombre,
    resultado_epidemiologica.primer_apellido,
    resultado_epidemiologica.segundo_apellido,
    resultado_epidemiologica.numero_documento,
    \'CC\' as tipo_cedula,
    \'F\' as genero,
    resultado_epidemiologica.estado_civil,
    resultado_epidemiologica.fecha_nacimiento,
    case resultado_epidemiologica.telefono when \'0\' then resultado_epidemiologica.celular::text else resultado_epidemiologica.telefono::text end as telefono,
    resultado_epidemiologica.celular,
    \'CAUCA\' as departamento,
    resultado_epidemiologica.municipio,
    resultado_epidemiologica.zona,
    resultado_epidemiologica.vereda_direccion,
    resultado_epidemiologica.barrio,
    resultado_epidemiologica.correo_electronico,
    resultado_epidemiologica.ips,
    resultado_epidemiologica.eps,
    resultado_epidemiologica.visita_demanda_inducida,
    resultado_epidemiologica.pertenencia_etnica,
    resultado_epidemiologica.nivel_educativo,
    resultado_epidemiologica.ocupacion,
    resultado_epidemiologica.estrato_socioeconomico,
    resultado_epidemiologica.descripcion_servicio,
    resultado_epidemiologica.fecha_ultima_citologia,
    resultado_epidemiologica.resultado_citologia,
    resultado_epidemiologica.resultado_anormal,
    resultado_epidemiologica.procedimiento_realizado,
    resultado_epidemiologica.tiempo_procedimiento,
    resultado_epidemiologica.padecido_vph,
    resultado_epidemiologica.frecuencia_toma,
    resultado_epidemiologica.razon_frecuencia,
    resultado_epidemiologica.vida_sexual_activa,
    resultado_epidemiologica.edad_primera_relacion_sexual,
    resultado_epidemiologica.num_comp_sexuales,
    resultado_epidemiologica.comp_trab_sexuales,
    resultado_epidemiologica.metodo_planificacion,
    resultado_epidemiologica.tiempo_metodo,
    resultado_epidemiologica.presentado_ets,
    resultado_epidemiologica.cual_ets,
    resultado_epidemiologica.otra_ets,
    resultado_epidemiologica.companero_ets,
    resultado_epidemiologica.familiar_ccu,
    resultado_epidemiologica.quienes,
    resultado_epidemiologica.que_es_papanicolaou,
    resultado_epidemiologica.para_que_sirve_citologia,
    resultado_epidemiologica.que_es_vph,
    resultado_epidemiologica.conoce_pruebas_vph,
    resultado_epidemiologica.que_pruebas_ha_realizado,
    resultado_epidemiologica.conoce_vacuna_vph,
    resultado_epidemiologica.aplicado_vacuna,
    resultado_epidemiologica.que_vacuna,
    resultado_epidemiologica.cuantas_dosis,
    resultado_epidemiologica.es_fumador,
    resultado_epidemiologica.cigarrillos_dia,
    resultado_epidemiologica.cigarrillos_mes,
    resultado_epidemiologica.hace_cuantos_anos_fuma,
    resultado_epidemiologica.cocina_lena,
    resultado_epidemiologica.horas_dia,
    resultado_epidemiologica.hace_cuantos_anos_cocina,
    resultado_epidemiologica.consume_vitamina_c,
    resultado_epidemiologica.consume_beta_caroteno,
    resultado_epidemiologica.consume_vitamina_a,
    resultado_epidemiologica.peso,
    resultado_epidemiologica.talla,
    resultado_epidemiologica.fecha_toma_peso,
    resultado_epidemiologica.gravidez,
    resultado_epidemiologica.partos,
    resultado_epidemiologica.abortos,
    resultado_epidemiologica.cesareas,
    resultado_epidemiologica.mortinatos,
    resultado_epidemiologica.edad_primer_embarazo,
    resultado_epidemiologica.esta_embarazada,
    resultado_epidemiologica.meses_embarazo,
    resultado_epidemiologica.fecha_ultimo_parto,
    resultado_epidemiologica.edad_primera_menstruacion,
    resultado_epidemiologica.fecha_ultima_menstruacion,
    resultado_epidemiologica.edad_menopausia,
    pin_toma_citologia.fecha_envio,
    pin_toma_citologia.id_toma,
    pin_toma_citologia.numero_cedula,
    pin_toma_citologia.demanda_inducida,
    pin_toma_citologia.fecha_demanda_inducida,
    pin_toma_citologia.estado_cuello,
    pin_toma_citologia.otro_cual,
    pin_toma_citologia.observaciones,
    pin_toma_citologia.responsable_toma,
    pin_toma_citologia.nombre_responsable,
    pin_toma_citologia.fecha_toma
    from pin_toma_citologia  
    inner join resultado_epidemiologica 
    on (pin_toma_citologia.numero_cedula = resultado_epidemiologica.numero_documento)
    where (pin_toma_citologia.fecha_envio >= \'' . $fechaInicial . '\'
    or resultado_epidemiologica.fecha_envio >= \'' . $fechaInicial . '\') and
    (pin_toma_citologia.fecha_envio <= \'' . $fechaFinal . '\'
    or resultado_epidemiologica.fecha_envio <= \'' . $fechaFinal . '\') ';
if ($cedulasIncluir !== '' ) {

    $cedulasIncluir = trim($cedulasIncluir, ",");
    $cedulasIncluir = $this->eliminarComasRepetidas($cedulasIncluir);
    $sql = $sql . ' or pin_toma_citologia.numero_cedula  in (' . $cedulasIncluir . ')';
} 
$sql = $sql . ' order by  resultado_epidemiologica.numero_documento';

$sql = $sql. '  )as consulta  ';

$sql = $sql . 'where consulta.fasecon  = \'' . $fase . '\' ';


if ($cedulasExcluir !== '') {
    $cedulasExcluir = trim($cedulasExcluir, ",");
    $cedulasExcluir = $this->eliminarComasRepetidas($cedulasExcluir);
    $sql = $sql . 'and consulta.numero_documento not in (' . $cedulasExcluir . ') ';
}

$query = $this->db->query($sql);

return $query->num_rows();


}

function getGuardarDatos($datos, $id_epidemiologica) {

    $this->db->where('id_epidemiologica', $id_epidemiologica);
    $this->db->set($datos);
    if ($this->db->update('resultado_epidemiologica')) {
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

function editarFechaToma($id_toma, $fecha_toma, $fase ) {
    $this->db->where('id_toma', $id_toma);
    $this->db->set('fecha_toma', $fecha_toma);
    $this->db->set('plan_atencion', $fase);
    if ($this->db->update('pin_toma_citologia')) {
        return TRUE;
    }
    return FALSE;
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


function eliminarExportarEncuesta($id_epidemiologica) {
 $this->db->where('id_epidemiologica', $id_epidemiologica);
 if ($this->db->delete('resultado_epidemiologica')){
    $respuesta['success'] = TRUE;
    $respuesta['title'] = 'El indicador se eliminó con éxito';
    $respuesta['msg'] = 'Registro eliminado con éxito';
} else {
    $respuesta['success'] = FALSE;
    $respuesta['title'] = 'Advertencia';
    $respuesta['msg'] = 'Ocurrió un error en la eliminación de la Encuesta';
}
return json_encode($respuesta);
}
        /*$this->load->dbutil();
        $this->load->helper('download');
        $data = $this->dbutil->csv_from_result($query);
        force_download("Encuesta" . date("d/m/Y") . ".csv", $data);*/


        function eliminarComasRepetidas($cadena) {
            $tamañoInicial = strlen($cadena);
            $cadena = str_replace(',,', ',', $cadena);
            $tamañoFinal = strlen($cadena);
            while ($tamañoInicial != $tamañoFinal) {
                $tamañoInicial = strlen($cadena);
                $cadena = str_replace(',,', ',', $cadena);
                $tamañoFinal = strlen($cadena);
            }
            return $cadena;
        }
        function insertarBitacora($datos){
         $this->db->set($datos);
         if ($this->db->insert('seg_bitacora')) {
           return true;
       }
       return false;
   }

function getExportarEncuestasPorId($datos) {
    $this->db->select('id_epidemiologica,
        resultado_epidemiologica.fecha_envio,
        resultado_epidemiologica.fecha_reporte,
        pin_toma_citologia.fecha_toma,
        resultado_epidemiologica.primer_nombre,
        resultado_epidemiologica.segundo_nombre,
        resultado_epidemiologica.primer_apellido,
        resultado_epidemiologica.segundo_apellido,                         
        resultado_epidemiologica.numero_documento,            
        resultado_epidemiologica.nombre_encuestador,     
        resultado_epidemiologica.segundo_nombre,
        resultado_epidemiologica.segundo_apellido,
        resultado_epidemiologica.fecha_nacimiento,
        resultado_epidemiologica.telefono,
        resultado_epidemiologica.celular,
        resultado_epidemiologica.municipio,
        resultado_epidemiologica.ips,
        resultado_epidemiologica.eps,
        par_eps_homologa.id_eps,
        par_ips_homologa.id_ips,
        par_eps_homologa.nombre_eps_homologa,
        par_ips_homologa.nombre_ips_homologa,
        pin_toma_citologia.id_toma,
        CASE resultado_epidemiologica.plan_atencion
        when \'REG-CCU FASE 3\' then \'REG-CCUFASE3\'
        when \'Fase III\' THEN \'REG-CCUFASE3\'
        when \'REG-CCU FASE 2\' THEN \'REG-CCUFASE2\'
        when \'Fase II\' THEN \'REG-CCUFASE2\'              
        else resultado_epidemiologica.plan_atencion
            end as fasecon',False);
    $this->db->from('resultado_epidemiologica');
    $this->db->join('pin_toma_citologia', 'pin_toma_citologia.numero_cedula = resultado_epidemiologica.numero_documento ','left');
    $this->db->join('par_eps_homologa', 'resultado_epidemiologica.eps = par_eps_homologa.nombre_eps_homologa');
    $this->db->join('par_ips_homologa','resultado_epidemiologica.ips = par_ips_homologa.nombre_ips_homologa','left');
    $this->db->where('id_epidemiologica', $datos->idEpidemiologica);
    $consulta = $this->db->get();
    $rows["data"] = $consulta->result_array();
    if($consulta->num_rows() > 0 ){
      $rows["success"] = true;
    } else{
      $rows["success"] = false;
    } 
    return json_encode($rows);
}


}
