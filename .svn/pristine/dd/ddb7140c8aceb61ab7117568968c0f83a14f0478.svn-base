<script type="text/javascript" src="<?php echo base_url() ?>public/js/bootstrap-fileinput.js" ></script>
<link href="<?php echo base_url() ?>public/css/fileinput.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url() ?>public/js/funcionesValidarSurvey.js"></script>

<div class="form-group" align="center">
    <div class="col-md-9" align="center">        
        <div class="alert alert-danger" id="operacionFallida" hidden="true">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <output id="fallo"></output>             
        </div>  

        <div class="alert alert-success" id="operacionExitosa" hidden="true">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <output id="exito"></output>
        </div>
        <div class="form-group" align="left">
            <div class="row">
                <div class="col-md-7">
                    <br/>
                    <div id="inputCedula" >
                        <input class="form-control" id="cedulas" ></input>
                    </div>
                    <div id="inputFecha" hidden="true">
                        <div class='input-group date' id='fechaEnvio'>
                            <input type='text' class="form-control" id="fechaEnvioInput" required/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <br/>
                    <select class="form-control" placeholder=".input-lg" id="tipoBusqueda" required>
                        <option value="cedula" selected>Cedula</option>
                        <option value="fechaEnvio">Fecha envío</option>
                        <option value="telefono">Celular</option>
                    </select>                   

                </div>
                <div class="col-md-1">
                    <br/>
                    <button type="button"  class="btn btn-primary pull-right" onclick="validarInconsistencias()" >Validar</button>                   
                </div>
            </div>
        </div>
        <div class="row" id="divValidarEncuestas">
            <div class="table-responsive">
                <table id="gridValidarEncuestas" class="table table-condensed table-hover table-striped" data-toggle="bootgrid" data-ajax="true" data-response-handler="responseHandler" cellspacing="0" width="100%" data-url="inconsistencia/validarCedulas">
                    <thead>
                        <tr>
                            <th data-column-id="numero_documento">Cédula</th>
                            <th data-column-id="Nombre" >Usuaria</th>
                            <th data-column-id="municipio" >Procedencia</th>
                            <th data-column-id="ips" >IPS</th>   
                            <th data-column-id="eps" >EPS</th>
                            <th data-column-id="contacto" >Contacto</th>
                            <th data-column-id="diligencia">Dilgencia</th>
                            <th data-column-id="fecha_encuesta">Fecha encuesta</th>
                            <th data-column-id="epidemiologica" data-formatter="formatEpidemiologica">Encuesta epidemiológica</th>
                            <th data-column-id="estadoCuello" data-formatter="formatEstadoCuello">Encuesta estado cuello</th>
                            <th data-column-id="fecha_toma">Fecha toma</th>
                        </tr>
                    </thead>	
                </table> 
            </div>
            <div class="col-md-4">
                <div  align="left">
                    <output id="msgInfo" align="left"></output>                    
                    <br/>
                </div>
            </div>
        </div>
    </div>    
</div>