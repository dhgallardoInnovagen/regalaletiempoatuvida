<script type="text/javascript" src="<?php echo base_url() ?>public/js/bootstrap-fileinput.js" ></script>
<link href="<?php echo base_url() ?>public/css/fileinput.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url() ?>public/js/funcionesSincronizarDatos.js"></script>

<div class="form-group" align="center">
    <div class="col-md-9" align="center">        
        <div class="alert alert-danger" id="errorIndicador" hidden="true">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <output id="msgErrorIndicador"></output>             
        </div>
        <div class="alert alert-success" id="successIndicador" hidden="true">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <output id="msgOkIndicador"></output>
        </div>       
        <div class="row" id="divValidarEncuestas">
            <div class="container">
                <div class="bootstrap-table">
                    <div class="table-responsive">
                    <!--<table id="grid-data" class="table table-bordered table-hover table-striped" data-toggle="bootgrid" data-ajax="true" cellspacing="0" width="100%" data-url="reporte_resultado/getReporteResultado">-->
                        <table id="gridInconsistencias" class="table table-bordered table-hover table-striped" data-toggle="bootgrid" data-ajax="true" cellspacing="0" data-show-export="true" width="100%">                
                            <thead>
                                <tr>
                                    <!--<th data-column-id="id_inconsistencia">Id</th>-->
                                    <th data-column-id="cedula">Cédula</th>
                                    <th data-column-id="prim_nombre" data-formatter="formatNombreCompleto">Nombre completo</th>
                                    <th data-column-id="municipio" >Municipio</th>
                                    <th data-column-id="celular" >Teléfono</th>
                                    <th data-column-id="fecha_tamizacion" >Fecha toma</th>
                                    <th data-column-id="responsable_toma" >Responsable toma</th>
                                    <th data-column-id="estado" data-formatter="formatEstado">Estado</th>
                                    <!--<th data-column-id="accion" data-formatter="commands">Acción inconsistencia</th>-->
        <!--<th data-column-id="fecha_solucion">Fecha solución</th>-->
                                </tr>
                            </thead>
                        </table>
                    </div>              
                </div>  
            </div>


        </div>    

    </div>    
</div>

<!--modal para crear y editar una nueva inconsistencia-->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Información sobre inconsistencia</h4>
            </div>
            <div class="modal-body">
                <form id="datosInconsistencia" data-toggle="validator"  role="form">
                    <div class="form-group">
                        <div class="row" hidden="true">
                            <br/>
                            <div class="col-md-2"><b><p name="nom" id="nom" >Id indicador </p></b> </div>
                            <div class="col-md-10"><input  type="text" class="form-control" name="cedula" id="cedula" readonly="true"></input>
                                <input  type="text" class="form-control" name="id_inconsistencia" id="id_inconsistencia" readonly="true"></input>
                            </div>
                        </div>
                        <div class="row">
                            <br/>
                            <div class="col-md-2"><b><p name="nom" id="nom" >Número documento </p></b> </div>
                            <div class="col-md-4">
                                <input rows="1" type="text" class="form-control" name="cedulaUsuaria" id="cedulaUsuaria" required/>
                            </div>
                            <div class="col-md-2"><b><p name="nom" id="nom" >Nombre usuaria </p></b> </div>
                            <div class="col-md-4">
                                <input rows="1" type="text" class="form-control" name="nombreUsuaria" id="nombreUsuaria" required/>
                            </div>
                        </div>
                        <div class="row">
                            <br/>
                            <div class="col-md-2"><b><p name="nom" id="nom" >Diligencia </p></b> </div>
                            <div class="col-md-4">
                                <input rows="1" type="text" class="form-control" name="diligencia" id="diligencia" required/>
                            </div>
                            <div class="col-md-2"><b><p name="nom" id="nom" >Tipo inconsistencia </p></b> </div>
                            <div class="col-md-4">
                                <select class="form-control" name="categoriaInconsistencia" id="categoriaInconsistencia" required></select>
                            </div>
                        </div>
                        <div class="row">
                            <br/>
                            <div class="col-md-2"><b><p name="nom" id="nom" >Fecha encuesta </p></b> </div>
                            <div class="col-md-4">
                                <!--<input rows="1" type="text" class="form-control" name="fechaEncuesta" id="fechaEncuesta" required/>-->
                                <div class='input-group date' id='fechaEncuesta'>
                                    <input type='text' class="form-control" id="fechaEncuestaInput"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-2"><b><p name="nom" id="nom" >Municipio </p></b> </div>
                            <div class="col-md-4">
                                <select  class="form-control" placeholder=".input-lg" name="municipio" id="municipio" required></select>
                            </div>
                        </div>
                        <div class="row">
                            <br/>
                            <div class="col-md-2"><b><p name="nom" id="nom" >Encuesta epidemiológica </p></b> </div>
                            <div class="col-md-4">
                                <select  class="form-control" name="epidemiologica" id="epidemiologica" disabled="true">
                                    <option value="t">SI</option>
                                    <option value="f">NO</option>
                                </select>
                            </div>
                            <div class="col-md-2"><b><p name="nom" id="nom" >Encuesta de estado del cuello </p></b> </div>
                            <div class="col-md-4">
                                <select class="form-control" name="estadoCuello" id="estadoCuello" disabled="true">
                                    <option value="t">SI</option>
                                    <option value="f">NO</option>
                                </select>                              
                            </div>
                        </div>
                        <div class="row">
                            <br/>
                            <div class="col-md-2"><b><p name="nom" id="nom" >Fecha nacimiento</p></b> </div>
                            <div class="col-md-4">
                                <select class="form-control" name="fechaNacimiento" id="fechaNacimiento" disabled="true">
                                    <option value="t">SI</option>
                                    <option value="f">NO</option>
                                </select>
                            </div>
                            <div class="col-md-2"><b><p name="nom" id="nom" >Fecha toma</p></b> </div>
                            <div class="col-md-4">
                                <select class="form-control" name="fechaToma" id="fechaToma" disabled="true">
                                    <option value="t">SI</option>
                                    <option value="f">NO</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <br/>
                            <div class="col-md-2"><b><p name="nom" id="nom" >Observación </p></b> </div>
                            <div class="col-md-10"><textarea rows="1" type="text" class="form-control"  name="observacion" id="observacion" required></textarea></div>
                        </div>
                    </div>
                    <br/>
                    <div class="modal-footer">
                        <button type="submit"  class="btn btn-primary">Enviar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
                <!--   Insertar la tabla donde se van a mostrar los resultados del indicador-->

            </div>

        </div>
    </div>
</div>
<!--fin modal para crear y editar una nueva inconsistencia-->

<!-- Modal cambiar estado a eliminar inconsistencias -->
<div id="modalEliminarInconsistencia" hidden="true" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Cambiar estado inconsistencia</h4>
            </div>
            <div class="modal-body">
                <output id="msgEliminarIndicador"></output>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="eliminarInconsistencia()" >Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!--fin modal para eliminar inconsistencias-->

<!-- Modal solucionar inconsistencias -->
<div id="modalSolucionarInconsistencia" hidden="true" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Solucionar inconsistencia</h4>
            </div>
            <div class="modal-body">
                <output id="msgSolucionarInconsistencia"></output>

                <form id="formSolucionarInconsistencia">
                    <br/>
                    <div class="row" hidden="true">                                              
                        <input  type="text" class="form-control" name="idInconsistenciaInput" id="idInconsistenciaInput" readonly="true"></input>
                    </div>
                    <div class="row">
                        <div class="col-md-2"><b><p name="nom" id="nom" >Número cédula</p></b> </div>
                        <div class="col-md-10">
                            <input rows="1" type="text" class="form-control" name="cedulaInput" id="cedulaInput" readonly="true"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"><b><p name="nom" id="nom" >Fecha nacimiento</p></b> </div>
                        <div class="col-md-4">
                            <div class='input-group date' id='fechaNacimientoSolInconsistencia'>
                                <input type='text' class="form-control" id="fechaNacimientoInput" required=""/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-2"><b><p name="nom" id="nom" >Fecha toma</p></b> </div>
                        <div class="col-md-4">
                            <div class='input-group date' id='fechaTomaSolInconsistencia'>
                                <input type='text' class="form-control" id="fechaTomaInput" required=""/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btnSolucionarInconsistencia" disabled="true" onclick="solucionarInconsistencia()" >Solucionar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
<!--fin modal solucionar inconsistencias-->