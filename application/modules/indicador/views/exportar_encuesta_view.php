<link href="<?php echo base_url() ?>public/css/jquery.bootgrid.css" rel="stylesheet">
<script src="<?php echo base_url() ?>public/js/jquery.bootgrid.js"></script>
<link href="<?php echo base_url() ?>public/css/fileinput.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url() ?>public/js/funcionesExportarEncuestas.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/js/highcharts.js"></script>
<meta charset="UTF-8">
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<div class="form-group" align="center">
    <div class="col-md-10" align="left">          

        <div class="row">
            <div class='col-sm-4'>
                <div class="form-group">
                    <div><b><p name="nom" id="nom" >Fecha inicial </p></b> </div>
                    <div class='input-group date' id='fechaInicial'>
                        <input type='text' class="form-control" id="fechaInicialInput" required/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class='col-sm-4'>
                <div class="form-group">
                    <div><b><p name="nom" id="nom" >Fecha final </p></b> </div>
                    <div class='input-group date' id='fechaFinal'>
                        <input type='text' class="form-control" id="fechaFinalInput" required/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class='col-sm-4'>
                <div class="form-group">
                    <div><b><p name="nom" id="nom" >Fase </p></b></div>
                    <select class="form-control" name="fase" id="fase">                          
                        <option value="REG-CCUFASE2" selected="selected">II Fase</option>
                        <option value="REG-CCUFASE3">III Fase</option>
                    </select>
                </div>    
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <div><b><p name="nom" id="nom" >Incluir números de documento </p></b> </div>
                    <textarea class="form-control bfh-number" id="cedulasIncluir" onkeypress="return validar(event)"  rows="4"></textarea>
                </div>
            </div>  
            <div class="col-sm-12">
                <div class="form-group">
                    <div><b><p name="nom" id="nom" >Excluir números de documento </p></b> </div>
                    <textarea class="form-control bfh-number" id="cedulasExcluir" onkeypress="return validar(event)"  rows="4"></textarea>
                </div>
            </div> 
            <div class="col-sm-12" id="visible" style="margin-top:-100px;">
                <div class="form-group">
                    <textarea class="form-control bfh-number" id="cedulasExcluirBoton" onkeypress="return validar(event)"  rows="4"></textarea>
                </div>
            </div>  

            <div class="modal-footer">
                <button  onClick="funcionEnviarEncuesta()" class="btn btn-primary" >
                    <span><i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;Consultar</span>
                </button>
            </div>

        </div>

    <!-- Exportar encuesta>
    <!--Modal Reporte 4505 --> 

    <div class="form-group" id="modalExportarEncuesta" hidden="true" >
        <div class="col-md-12">
           <div class="bootstrap-table">
            <div class="alert alert-success" id="successIndicador" hidden="true">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <output id="msgOkGestionarUsuario"></output>
        </div> 
            <div class="table-responsive">
                <table id="grid-data" class="table table-condensed table-hover table-striped" data-toggle="bootgrid" data-ajax="true" cellspacing="0" width="100%">
                    <thead>
                        <tr >
                            <th data-column-id="id_toma" data-visible="false">ID Toma</th>
                            <th data-column-id="id_epidemiologica" data-visible="false">ID del Paciente</th>
                            <th data-column-id="fecha_envio">Fecha Envio</th>
                            <th data-column-id="fecha_envio_toma">Fecha Envio</th>
                            <th data-column-id="fecha_reporte">Fecha Reporte</th>
                            <th data-column-id="fecha_toma" data-formatter = "fechaToma">Fecha Toma</th>
                            <th data-column-id="fecha_nacimiento" data-formatter = "fechaNacimiento">Fecha nacimiento</th>
                            <th data-column-id="primer_nombre">Nombre</th>
                            <th data-column-id="primer_apellido">Primer</th>                         
                            <th data-column-id="numero_documento" data-formatter="documento" >Numero de documento</th>             
                            <th data-column-id="nombre_encuestador" data-visible="false">Nombre Encuestador</th>      
                            <th data-column-id="segundo_nombre" data-visible="false">Segundo Nombre</th>
                            <th data-column-id="segundo_apellido" data-visible="false">Segundo Apellido</th>
                            <th data-column-id="telefono" data-visible="false">Telefono O Celular</th>
                            <th data-column-id="municipio">Municipio</th>
                            <th data-column-id="ips" data-formatter = "formatoIps">IPS</th>
                            <th data-column-id="eps">EPS</th>
                            <th data-column-id="fasecon">Fase</th>
                            <th data-column-id="commands" data-formatter="commands" data-sortable="false">Editar</th>
                            <th data-column-id="command" data-formatter="command" data-sortable="false">Excluir</th>                          
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!--modal de editar cada usuario -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Información sobre Paciente</h4>
            </div>
            <div class="modal-body">
                <form id="datosExportarEncuesta" data-toggle="validator"  role="form">
                    <div class="form-group">
                        <div class="row" hidden="true">
                            <br/>
                            <div class="col-md-2"><b><p name="nom" id="nom" >Id paciente </p></b> </div>
                            <div class="col-md-10"><input  type="text" class="form-control" name="cedula" id="cedula" readonly="true"></input>
                                <input  type="text" class="form-control" name="id_epidemiologicaP" id="id_epidemiologica" readonly="true"></input>
                            </div>
                        </div>

                        <div class="row">
                            <br/>
                            <div class="col-md-4"><b><p name="nom" id="nom" >Número documento </p></b> </div>
                            <div class="col-md-6">
                                <input rows="1" type="text" class="form-control" name="cedulaUsuariat" id="cedulaUsuaria" required/>
                            </div>
                            <div class="col-md-6" id="visible">
                                <input rows="1" type="text" class="form-control" name="idtoma" id="id_toma" required/>
                            </div>
                        </div>
                        <div class="row">
                            <br/>
                            <div class="col-md-2"><b><p name="nom" id="nom" >Fase </p></b> </div>
                            <div class="col-md-4">
                             <select  class="form-control" placeholder=".input-lg" name="eps" id="faseInput" >
                                <option>REG-CCUFASE2</option>
                                <option>REG-CCUFASE3</option>                                    
                            </select>
                        </div>     
                        <div class="col-md-2"><b><p name="nom" id="nom" >Fecha Reporte</p></b> </div>
                        <div class="col-md-4">
                            <!--<input rows="1" type="text" class="form-control" name="fechaEncuesta" id="fechaEncuesta" required/>-->
                            <div class='input-group date' id='fechaReporte'>
                                <input type='text' class="form-control" id="fechaReporteInput" required/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>                     
                    </div>


                    <div class="row">
                        <br/>
                        <div class="col-md-2"><b><p name="nom" id="nom" >Fecha Toma</p></b> </div>
                        <div class="col-md-4">
                            <!--<input rows="1" type="text" class="form-control" name="fechaEncuesta" id="fechaEncuesta" required/>-->
                            <div class='input-group date' id='fechaToma'>
                                <input type='text' class="form-control" id="fechaTomaInput" required />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-2"><b><p name="nom" id="nom" >Fecha Envio </p></b> </div>
                        <div class="col-md-4">
                            <div class='input-group date' id='fechaEnvio'>
                                <input type='text' class="form-control"  id="fechaEnvioInput" required />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <br/>
                        <div class="col-md-2"><b><p name="nom" id="nom" >Primer Nombre </p></b> </div>
                        <div class="col-md-4">
                            <input rows="1" type="text" class="form-control" name="primerNombre" id="primerNombreInput" required/>
                        </div>

                        <div class="col-md-2"><b><p name="nom" id="nom" >Segundo Nombre </p></b> </div>
                        <div class="col-md-4">
                            <input rows="1" type="text" class="form-control" name="segundoNombre" id="segundoNombreInput" />
                        </div>


                    </div>

                    <div class="row">
                        <br/>
                        <div class="col-md-2"><b><p name="nom" id="nom" >Primer Apellido </p></b> </div>
                        <div class="col-md-4">
                            <input rows="1" type="text" class="form-control" name="primerApellido" id="primerApellidoInput" required />
                        </div>

                        <div class="col-md-2"><b><p name="nom" id="nom" >Segundo Apellido </p></b> </div>
                        <div class="col-md-4">
                            <input rows="1" type="text" class="form-control" name="segundoApellido" id="segundoApellidoInput" />
                        </div>

                    </div>

                    <div class="row">
                        <br/>
                        <div class="col-md-2"><b><p name="nom" id="nom" >Fecha naciemieto </p></b> </div>
                        <div class="col-md-4">
                            <div class='input-group date' id='fechaNacimiento'>
                                <input type='text' class="form-control" id="fechaNacimientoInput" required />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-2"><b><p name="nom" id="nom" >Municipio </p></b> </div>
                        <div class="col-md-4">
                            <select  class="form-control" placeholder=".input-lg" id="municipioInput" required >
                            </select>
                        </div>



                    </div>

                    <div class="row">
                        <br/>
                        <div class="col-md-2"><b><p name="nom" id="nom" >Celular</p></b> </div>
                        <div class="col-md-4">
                            <input rows="1" type="text" class="form-control" name="telefonoFijo" id="telefonoCelularInput" />
                        </div>
                        <div class="col-md-2"><b><p name="nom" id="nom" >Telefono Fijo</p></b> </div>
                        <div class="col-md-4">
                            <input rows="1" type="text" class="form-control" name="telefonoCelular" id="telefonoFijoInput" />
                        </div>




                    </div>
                    <div class="row">
                        <br/>
                        <div class="col-md-2"><b><p name="nom" id="nom" >Eps </p></b> </div>
                        <div class="col-md-4">
                         <select  class="form-control" placeholder=".input-lg" name="eps" id="epsInput" required >   
                         </select>
                     </div>
                     <div class="col-md-2"><b><p name="nom" id="nom" >Ips </p></b> </div>
                     <div class="col-md-4">
                        <select  class="form-control" placeholder=".input-lg" name="ips" id="ipsInput" required >
                        </select>
                    </div>
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
<!--Final modal de editar cada usuario -->



