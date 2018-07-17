<link href="<?php echo base_url() ?>public/css/fileinput.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url() ?>public/js/bootstrap-fileinput.js" ></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/js/funcionesResultadosPdf.js"></script>
<script type="text/javascript">
    var rol = '<?= $this->session->userdata('rol') ?>'; //Se asigna el rol del usuario
</script>
<div class="form-group" align="center">
    <div class="col-md-10" align="center">
        <br>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#menu1">Descargar resultados</a></li>
            <?php if ($this->session->userdata('rol') == 1 || $this->session->userdata('rol') == 2) { ?> 
                <li><a data-toggle="tab" href="#home">Subir resultados PDF</a></li>
            <?php } ?>

        </ul>
        <br>
        <div class="tab-content">
            <div id="home" class="tab-pane fade">
                <form  id="fmCargarResultados" name="fmCargarResultados"  enctype="multipart/form-data" >
                    <div class="alert alert-success" id="operacionExitosa" hidden="true">
                        <!--<a href="#" class="close" data-dismiss="success">&times;</a>-->
                        <span id="exito"></span>
                    </div>
                    <div class="alert alert-warning" id="operacionInfo" hidden="true">
                        <!--<a href="#" class="close" data-dismiss="alert">&times;</a>-->
                        <span id="info"></span>
                    </div>
                    <div class="alert alert-danger" id="operacionFallida" hidden="true">
                        <!--<a href="#" class="close" data-dismiss="alert">&times;</a>-->
                        <span id="fallo"></span>
                    </div>

                    <br><br>
                    <input id="inputData" name="inputData[]" multiple="true"  type="file" class="file-loading"  data-show-upload="false" data-show-preview="false">
                    <br>
                    <img hidden="true" id="loading" src="<?php echo base_url() ?>public/img/progressbar.gif" />
                    <b><p name="nom" id="nom" align="left">Observación</p></b>
                    <div><textarea rows="3" type="text" class="form-control"  name="observacion" id="observacion"></textarea></div>
                    <br>
                    <button type="submit"  class="btn btn-primary pull-right">Enviar</button>                    
                </form>                
            </div>
            <div id="menu1" class="tab-pane fade in active">
                <div class="alert alert-warning" id="cargueInfo" hidden="false">
                    <!--<a href="#" class="close" data-dismiss="alert">&times;</a>-->                  
                    <output id="msgCargue"></output>
                </div>
                <div class="form-group" id="modalTamizadas">
                    <div class="col-md-12">
                        <br>
                        <!--<div class="container">-->
                        <div class="bootstrap-table">
                            <div class="table-responsive">
                                <table id="grid-data" class="table table-condensed table-hover table-striped" data-toggle="bootgrid" data-ajax="true">
                                    <thead>
                                        <tr>
                                            <th data-column-id="cod_mx">Código laboratorio</th>
                                            <th data-column-id="cedula">N° documento</th>                                            
                                            <th data-column-id="fecha_cargue">Fecha cargue</th>
                                            <th data-column-id="fecha_toma">Fecha de toma</th>
                                            <th data-column-id="campania">N° Campaña</th>
                                            <th data-column-id="municipio">Municipio</th>
                                            <th data-column-id="observacion"  data-visible="false">Observación</th>
                                            <th data-column-id="accion" data-formatter="commands">Descargar</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <!--</div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--</div>-->
<!-- Modal para descargar resultados por campaña -->
<div id="modalDescargarCampania" hidden="true" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Descargar resultados campaña</h4>
            </div>
            <div class="modal-body">
                <form id ="fDescargarCampania">                    
                    <div class="form-group">
                        <div class="row" >
                            <br/>
                            <div class="col-md-3"><b><p  >N° Campaña </p></b> </div>
                            <div class="col-md-9"><input  type="text"  class="form-control" name="numCampania" id="numCampania" required="true"></input></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnDescargarCampania" onclick="descargarCampania()" class="btn btn-primary">Descargar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver la observación -->
<div id="modalObservacion" hidden="true" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Observación campaña</h4>
            </div>
            <div class="modal-body">
               <output id="msgInfo"></output>
            </div>
        </div>
    </div>
</div>