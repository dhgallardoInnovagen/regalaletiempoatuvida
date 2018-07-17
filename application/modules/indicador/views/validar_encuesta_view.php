<script type="text/javascript" src="<?php echo base_url() ?>public/js/bootstrap-fileinput.js"></script>
<link href="<?php echo base_url() ?>public/css/fileinput.css" rel="stylesheet">
<link href="<?php echo base_url() ?>public/css/styles2.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url() ?>public/js/funcionesValidarEncuesta.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/js/funcionesListasEmbalaje.js"></script>

<div class="form-group" align="center">
    <div class="col-md-11" align="center">
        <div class="alert alert-danger" id="operacionFallida" hidden="true">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <output id="fallo"></output>
        </div>

        <div class="alert alert-success" id="operacionExitosa" hidden="true">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <output id="exito"></output>
        </div>
        <div class="form-group" align="left">
            <div class="bs-example">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" id="tabCedulas" onclick="ocularGridInconsistencias()" href="#sectionA">Ingresar cédulas</a>
                    </li>
                    <!-- <li><a data-toggle="tab" id="tabCargarArchivo" onclick="ocularGridInconsistencias()" href="#sectionB">Cargar archivo</a></li>-->
                    <li>
                        <a data-toggle="tab" id="tabCedulasIndividuales" onclick="ocularGridInconsistencias()" href="#sectionC">Por fecha </a>
                    </li>

                </ul>
                <div class="tab-content">
                    <div id="sectionA" class="tab-pane fade in active">
                        <br> Digite los números de cédulas
                        <textarea class="form-control bfh-number" id="cedulas" onkeypress="return validar(event)" rows="4"></textarea>
                        <br/>
                        <button type="button" class="btn btn-primary pull-right" onclick="validarInconsistencias()">Validar</button>
                        <br/>
                    </div>
                    <div id="sectionB" class="tab-pane fade">
                        <br>
                        <form id="fmCargarArchivoCedulas" name="fmImportarDatos" enctype="multipart/form-data">
                            <input id="inputCedulas" name="inputCedulas" type="file" class="file-loading" data-show-preview="true">
                        </form>
                    </div>
                    <div id="sectionC" class="tab-pane fade">
                        <br>

                        <div class="form-group col-md-12">

                            
                            <div class='col-sm-6'>
                                <div class="form-group">
                                    <label for="sel1">Seleccione fecha de cargue:</label>
                                    <div class='input-group date' id='fechaInicial'>
                                        <input type='text' class="form-control" id="fechaInicialInput2" required/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                    <br/>
                                  <button type="button" class="btn btn-primary pull-right" onclick="validarPorMunic()">Validar</button>
                                </div>
                            </div>
                        </div>
                      
                        <br/>
                        <div class="row" hidden="true" id="divValidarEncuestas2">
                            <div class="table-responsive overflowP">
                                <table id="gridValidarEncuestas2" class="table table-condensed table-hover table-striped" data-toggle="bootgrid" data-ajax="true"
                                    data-response-handler="responseHandler" cellspacing="0" width="100%" data-url="inconsistencia/validarCedulas" rowSelect="true" navigation="3">
                                    <thead>
                                        <tr>
                                            <th data-column-id="numero_documento" data-formatter="formatCedulas">Cédula</th>
                                            <th data-column-id="encuesta_epidemiologica" data-formatter="formatEpidemiologica">Encuesta epidemiológica</th>
                                            <th data-column-id="encuesta_estado_cuello" data-formatter="formatEstadoCuello">Encuesta estado cuello</th>
                                            <!-- <th data-column-id="fecha_nacimiento" data-formatter="formatFechaNacimiento">Fecha nacimiento</th> -->
                                            <th data-column-id="fecha_toma" data-formatter="formatFechaToma">Fecha Toma Citología</th>
                                            
                                            <th data-column-id="fecha_cargue_epidemiologica" data-formatter="formatFechaCargueEpidemiologica">Fecha cargue E Epidemiológica</th>
                                            <th data-column-id="usuario_cargue_epidemiologica" data-formatter="formatUsuarioCargueEpidemiologica">Usuario cargue E Epidemiológica</th>
                                            <th data-column-id="fecha_cargue_cuello" data-formatter="formatFechaCargueCuello">Fecha cargue E Cuello</th>
                                            <th data-column-id="usuario_cargue_cuello" data-formatter="formatUsuarioCargueCuello">Usuario cargue E Cuello</th>
                                            <th data-column-id="municipio" data-formatter="formatMunicipio">Municipio</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <div align="left">
                                    <output id="msgInfo2" align="left"></output>
                                    <br/>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" hidden="true" id="divValidarEncuestas">
            <div class="table-responsive">
                <table id="gridValidarEncuestas" class="table table-condensed table-hover table-striped" data-toggle="bootgrid" data-ajax="true"
                    data-response-handler="responseHandler" cellspacing="0" width="100%" data-url="inconsistencia/validarCedulas">
                    <thead>
                        <tr>
                            <th data-column-id="numero_documento" data-formatter="formatCedulas">Cédula</th>
                            <th data-column-id="encuesta_epidemiologica" data-formatter="formatEpidemiologica">Encuesta epidemiológica</th>
                            <th data-column-id="encuesta_estado_cuello" data-formatter="formatEstadoCuello">Encuesta estado cuello</th>
                            <!-- <th data-column-id="fecha_nacimiento" data-formatter="formatFechaNacimiento">Fecha nacimiento</th> -->
                            <th data-column-id="fecha_toma_citologia" data-formatter="formatFechaTomaCitologia">Fecha citología</th>
                            <th data-column-id="fecha_cargue_epidemiologica" data-formatter="formatFechaCargueEpidemiologica">Fecha cargue E Epidemiológica</th>
                            <th data-column-id="usuario_cargue_epidemiologica" data-formatter="formatUsuarioCargueEpidemiologica">Usuario cargue E Epidemiológica</th>
                            <th data-column-id="fecha_cargue_cuello" data-formatter="formatFechaCargueCuello">Fecha cargue E Cuello</th>
                            <th data-column-id="usuario_cargue_cuello" data-formatter="formatUsuarioCargueCuello">Usuario cargue E Cuello</th>
                            <th data-column-id="municipio" data-formatter="formatMunicipio">Municipio</th>

                        </tr>
                    </thead>
                </table>
            </div>
            <div class="col-md-4">
                <div align="left">
                    <output id="msgInfo" align="left"></output>
                    <br/>
                </div>
            </div>
            
        </div>
        
    </div>
</div>