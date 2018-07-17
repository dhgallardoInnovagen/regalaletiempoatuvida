<link href="<?php echo base_url() ?>public/css/fileinput.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url() ?>public/js/bootstrap-fileinput.js" ></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/js/funcionesImportarDatos.js"></script>
<div class="form-group" align="center">
    <div class="col-md-9" align="center">
        <br>
        <form  id="fmImportarDatos" name="fmImportarDatos"  enctype="multipart/form-data">
            <div class="alert alert-success" id="operacionExitosa" hidden="true">
                <a href="#" class="close" data-dismiss="success">&times;</a>
                <span id="exito"></span>
            </div>
            <div class="alert alert-danger" id="operacionFallida" hidden="true">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <span id="fallo"></span>
            </div>
            <div class="row">
                <div class="form-group" align="left">
                    <div class="col-xs-6 selectContainer">
                        <label class="col-xs-5 control-label">Fase del proyecto</label>
                        <select class="form-control" name="fase" id="fase">
                            <option value="REG-CCU FASE 1">I Fase</option>
                            <option value="REG-CCU FASE 2" selected="selected">II Fase</option>
                            <option value="REG-CCU FASE 3">III Fase</option>
                        </select>
                    </div>
                    <div class="col-xs-6 selectContainer">
                        <label class="col-xs-4 control-label">Tipo de archivo</label>
                        <select class="form-control" name="tipoArchivo" id="tipoArchivo">
                            <option value="encuestaEpidemiologica">Encuesta epidemiológica</option>
                            <option value="tomaCitologia">Toma citología</option>
                            <option value="resultadoLaboratorio">Resultado laboratorio</option>
                        </select>
                    </div>
                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="form-group" align="center">
                    <input id="inputData" name="inputData"  type="file" class="file-loading" data-show-preview="false">
                    <br>
                    <img hidden="true" id="loading" src="<?php echo base_url() ?>public/img/progressbar.gif" />
                    <div class="panel panel-info" id="panelInfo">
                        <span id="msgInfo"></span>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal para Homologar EPS e IPS-->
<div id="modalHomologador" hidden="true" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Homologar EPS, IPS</h4>
            </div>
            <div class="modal-body">
                <form id="formHomologador" method="post">
                    <span id="contenidoModal"></span>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="homologarIPS_EPS()" >Homologar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>