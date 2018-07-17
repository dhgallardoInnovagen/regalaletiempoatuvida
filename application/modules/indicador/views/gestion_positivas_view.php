<!--/*
 * Autor: Jamith Bolaños Vidal
 * Fecha: 08/07/2015
 * Modelo que realiza el acceso a los datos relacionado con la información del reporte de resultados
 */-->
<link href="<?php echo base_url() ?>public/css/jquery.bootgrid.css" rel="stylesheet">
<script src="<?php echo base_url() ?>public/js/jquery.bootgrid.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/js/funcionesReporteGestionPositivas.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/js/highcharts.js"></script>
<script type="text/javascript">
    var rol = '<?= $this->session->userdata('rol') ?>'; //Se asigna el rol del usuario
</script>
<div class="form-group">
    <div class="col-md-10">
        <div class="alert alert-danger" id="error" hidden="true">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <output id="msgError"></output>             
        </div>  

        <div class="alert alert-success" id="success" hidden="true">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <output id="msgSuccess"></output>
        </div> 
        <br>
        <div class="row">
            <div class="form-group" align="center">              
                <img hidden="true" id="loading" src="<?php echo base_url() ?>public/img/progressbar.gif" />        
            </div>
        </div>
        <div class="container">
            <div class="bootstrap-table">
                <div class="table-responsive">
                    <table id="grid-data" class="table table-hover table-striped " data-toggle="bootgrid" data-ajax="true" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th data-column-id="id_positivas" data-visible="false">Id</th>
                                <th data-column-id="cedula" data-formatter="seguimiento">Identificación</th>
                                <th data-column-id="nombre">Nombres</th>
                                <th data-column-id="edad">Edad</th>
                                <th data-column-id="telefono">Teléfono</th>
                                <th data-column-id="direccion">Dirección</th>
                                <th data-column-id="municipio">Municipio</th>
                                <th data-column-id="eps">EPS</th>
                                <th data-column-id="resul_cito">Resultado citología</th>
                                <th data-column-id="resul_vph">Resultado VPH</th>
                                <th data-column-id="fecha_toma">Fecha toma</th>
                                <th data-column-id="ips">IPS</th>
                                <th data-column-id="conducta" data-visible="false">Conducta</th>
                                <th data-column-id="estado" data-visible="false">Estado</th>                                
                                <th data-column-id="no_oficio" data-visible="false">no_oficio</th>
                                <th data-column-id="fecha_control_cotest" data-visible="false">fecha_control_cotest</th>
                                <th data-column-id="resultado_control" data-visible="false">resultado_control</th>
                                <th data-column-id="fecha_visita_domiciliaria" data-visible="false">fecha_visita_domiciliaria</th>
                                <th data-column-id="visita_domiciliaria" data-visible="false">visita_domiciliaria</th>
                                <th data-column-id="observaciones_eps" data-visible="false">observaciones_eps</th>
                                <th data-column-id="observaciones_pto" data-visible="false">observaciones_pto</th>
                                <th data-column-id="observaciones_sds" data-visible="false">observaciones_sds</th>
                                <th data-column-id="commands" data-formatter="commands" data-sortable="false">Gestionar</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!--modal para crear y editar un nuevo indicador-->

<div id="modalGestionPositivas" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="buttonCerrar" onclick="actualizarDaaGrid()" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Gestión Positivas</h4>
            </div>
            <div class="modal-body" >
               
                   <div class="row" align = "left">
                        <div class="col-md-2"><b>Identificación:</b></div>
                        <div class="col-md-3"><input type="text" class="input" id="cedula" size="55" readonly style="background-color:transparent; border:0px" ></div>
                        <div class="col-md-2"><b>Nombre:</b></div>
                        <div class="col-md-3">
                            <input type="text" class="input" id="nombre" size="55" style="background-color:transparent; border:0px" >
                        </div>
                    </div>
                    <div class="row" align = "left">
                        <div class="col-md-2"><b>Dirección:</b></div>
                        <div class="col-md-3">
                            <input type="text" class="input" id="direccion" size="55" style="background-color:transparent; border:0px" >
                        </div>
                        <div class="col-md-2"><b>Municipio:</b></div>
                        <div class="col-md-3"><input type="text" class="input" id="municipio" size="55" style="background-color:transparent; border:0px" ></div>
                    </div>
                    <div class="row" align = "left">
                        <div class="col-md-2"><b>Edad:</b></div>
                        <div class="col-md-3">
                            <input type="text" class="input" id="edad" size="55" style="background-color:transparent; border:0px" >
                        </div>
                        <div class="col-md-2"><b>Teléfono:</b></div>
                        <div class="col-md-3"><input type="text" class="input" id="telefono" size="55" style="background-color:transparent; border:0px" ></div>
                    </div>
                   <div class="row" align = "left">
                        <div class="col-md-2"><b>EPS:</b></div>
                        <div class="col-md-3">
                            <input type="text" class="input" id="eps" size="55" style="background-color:transparent; border:0px" >
                        </div>
                        <div class="col-md-2"><b>IPS:</b></div>
                        <div class="col-md-3"><input type="text" class="input" id="ips" size="55" style="background-color:transparent; border:0px" ></div>
                   </div>
                    <div class="row" align = "left">
                        <div class="col-md-2"><b>Citología:</b></div>
                        <div class="col-md-3">
                            <input type="text" class="input" id="citologia" size="55" style="background-color:transparent; border:0px" >
                        </div>
                        <div class="col-md-2"><b>Fecha Toma:</b></div>
                        <div class="col-md-3">
                            <input type="text" class="input" id="fecha_toma" size="55" style="background-color:transparent; border:0px" >
                        </div>                        
                    </div>
                   <div class="row" align = "left">
                        <div class="col-md-2"><b>VPH:</b></div>
                        <div class="col-md-3"><input type="text" class="input" id="vph" size="55" style="background-color:transparent; border:0px" ></div>
                        <div class="col-md-2"><b>Conducta:</b></div>
                        <div class="col-md-3">
                            <input type="text" class="input" id="conducta" size="55" style="background-color:transparent; border:0px" >
                        </div>    
                   </div>
               
                <br>
                <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" href="#pestaniaAtenciones">Atenciones</a></li>
                    <li><a data-toggle="tab" href="#pestaniaTratamiento">Tratamientos</a></li>
                    <li><a data-toggle="tab" href="#pestaniaSeguimiento">Seguimiento</a></li>
                </ul>
                <!--                Contenido de las atenciones de la usuaria-->
                <div class="tab-content">
                    <div id="pestaniaAtenciones" class="tab-pane fade">
                        <br>
                        <div class="active" id="botton">
                            <button type="button" class="btn btn-primary" onclick="mostarDivAtencion()" >Adicionar atención</button>

                            <div id="atenciones" style="display: none;">
                                <!--Formulario para el cargue de nuevas atenciones para la usuaria-->
                                <form id="formAtenciones">
                                    <div class="row">
                                        <div class='col-sm-6'>
                                            <div class="form-group">
                                                <div><b><p name="nom" id="nom" >Tipo Atención: </p></b> </div>
                                                <select class="form-control" id="tipoAtencion" required>
                                                    <option value="Médico general nivel I">Médico general nivel I</option>
                                                    <option value="Ginecólogo nivel I">Ginecólogo nivel I</option>
                                                    <option value="Colposcopia y biopsia">Colposcopia y biopsia</option>
                                                    <option value="Marcadores pronostico">Marcadores pronóstico</option>
                                                </select>
                                                <input  type="text" class="form-control" name="id_positiva" id="id_positiva" readonly="true" hidden="true"/>
                                            </div>
                                        </div>
                                        <div class='col-sm-6'>
                                            <div class="form-group">
                                                <div><b><p name="nom" id="nom" >Fecha atención </p></b> </div>
                                                <div class='input-group date' id='fechaAtencion'>
                                                    <input type='text' class="form-control" id="fechaAtencionInput" required/>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">                                        
                                        <div class='col-sm-6'>
                                            <div class="form-group">
                                                <div><b><p name="nom" id="nom" >Conducta</p></b> </div>
                                                <input type="text" class="form-control" id="inputConducta" size="45">
                                            </div>
                                        </div>
                                        <div class='col-sm-6'>
                                            <div class="form-group">
                                                <div><b><p name="nom" id="nom" >Diagnóstico</p></b> </div>
                                                <input type="text" class="form-control" id="diagnostico" size="45">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Guardar atención</button>   
                                    </div>
                                </form>
                            </div>   
                            <table id="grid-data-atenciones" class="table table-condensed table-hover table-striped" data-toggle="bootgrid" data-ajax="true" cellspacing="0" width="100%">
                                <thead>
                                    <tr>                
                                        <th data-column-id="tipo_atencion">Atención</th>
                                        <th data-column-id="fecha_atencion">Fecha atención</th>
                                        <th data-column-id="conducta">Conducta</th>
                                        <th data-column-id="diagnostico">Diagnóstico</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!--                    Contenido de los tratamientos de las usuaria-->
                    <div id="pestaniaTratamiento" class="tab-pane fade">
                        <br>
                        <div class="active" id="botton">
                            <button type="button" class="btn btn-primary" onclick="mostarDivTratamiento()" >Adicionar tratamiento</button>

                            <div id="tratamientos" style="display: none;">
                                <!--Formulario para el cargue de nuevas atenciones para la usuaria-->
                                <form id="formTratamientos">
                                    <div class="row">
                                        <div class='col-sm-6'>
                                            <div class="form-group">
                                                <div><b><p name="nom" id="nom" >Tratamiento </p></b> </div>                                             
                                                <input  type="text" class="form-control" name="tratamiento" id="tratamiento" required="este campo es requerido"/>
                                            </div>
                                        </div>
                                        <div class='col-sm-6'>
                                            <div class="form-group">
                                                <div><b><p name="nom" id="nom" >Fecha tratamiento</p></b> </div>
                                                <div class='input-group date' id='fechaTratamiento'>
                                                    <input type='text' class="form-control" id="fechaTratamientoInput" required/>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Guardar tratamiento</button>   
                                    </div>
                                </form>
                            </div>                
                            <table id="grid-data-tratamientos" class="table table-condensed table-hover table-striped" data-toggle="bootgrid" data-ajax="true" cellspacing="0" width="100%">
                                <thead>
                                    <tr>                
                                        <th data-column-id="tratamiento">Tratamiento</th>
                                        <th data-column-id="fecha_tratamiento">Fecha tratamiento</th>                                        
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div id="pestaniaSeguimiento" class="tab-pane fade">
                        <br/>
                        <form id="formSeguimiento">
                            <div class="row">
                                <div class='col-sm-6'>
                                    <div><b><p name="nom" id="nom" >Fecha control CL/VPH</p></b> </div>
                                    <div class='input-group date' id='fechaControl'>
                                        <input type='text' class="form-control" id="fechaControlInput"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class='col-sm-6'>
                                    <div class="form-group">
                                        <div><b><p name="nom" id="nom" >Conducta: </p></b> </div>
                                        <select class="form-control" id="conductaForm">
                                            <option value=""></option>
                                            <option value="Citología en un año">Citología líquida en un año</option>
                                            <option value="Co-Test en un años">Co-Test en un años</option>
                                            <option value="Tamización cada cinco años">Tamización cada cinco años</option>
                                            <option value="Colposcopia Biopsia">Colposcopia Biopsia</option>
                                            <option value="Marcadores pronóstico Ki67-p16">Marcadores pronóstico Ki67-p16</option>
                                            <option value="Manejo según diagnostico histológico">Manejo según diagnostico histológico</option>
                                            <option value="Seguimiento a los 18 meses">Seguimiento a los 18 meses</option>
                                            <option value="Procedimiento de escisión diagnóstico/terapéutico">Procedimiento de escisión diagnóstico/terapéutico</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">                                        
                                <div class='col-sm-6'>
                                    <div class="form-group">
                                        <div><b><p name="nom" id="nom" >Fecha notificación EPS</p></b> </div>
                                        <div class='input-group date' id='fechaNotificacion'>
                                            <input type='text' class="form-control" id="fechaNotificacionInput"/>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-sm-6'>
                                    <div class="form-group">
                                        <div><b><p name="nom" id="nom" >N° oficio notificación </p></b> </div>                                       
                                        <input type='text' class="form-control" id="numero_notificacion"/>                                                                                 
                                    </div>
                                </div>
                            </div>                            
                            <div class="row">
                                <div class='col-sm-6'>
                                    <div class="form-group">
                                        <div><b><p name="nom" id="nom" >Resultado Control </p></b> </div>                                       
                                        <input type='text' class="form-control" id="resultadoControl"/>                                                                                 
                                    </div>
                                </div>
                                <div class='col-sm-6'>
                                    <div class="form-group">
                                        <div><b><p name="nom" id="nom" >Fecha vista domiciliara</p></b> </div>
                                        <div class='input-group date' id='fechaVisita'>
                                            <input type='text' class="form-control" id="fechaVisitaInput"/>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class='col-sm-12'>
                                    <div class="form-group">
                                        <div><b><p name="nom" id="nom" >Observación visita domiciliaria</p></b> </div>
                                        <input type="text" class="form-control" id="obs_visita_domiciliaria" size="45">
                                    </div>
                                </div>
                                <div class='col-sm-12'>
                                    <div class="form-group">
                                        <div><b><p name="nom" id="nom" >Observación EPS</p></b> </div>
                                        <input type="text" class="form-control" id="obs_eps" size="45">
                                    </div>
                                </div>
                                <div class='col-sm-12'>
                                    <div class="form-group">
                                        <div><b><p name="nom" id="nom" >Observación punto de atención</p></b> </div>
                                        <input type="text" class="form-control" id="obs_pnto_atencion" size="45">
                                    </div>
                                </div>
                                <div class='col-sm-12'>
                                    <div class="form-group">
                                        <div><b><p name="nom" id="nom" >Observación SDSC</p></b> </div>
                                        <input type="text" class="form-control" id="obs_sdsc" size="45">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Guardar seguimiento</button>   
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
