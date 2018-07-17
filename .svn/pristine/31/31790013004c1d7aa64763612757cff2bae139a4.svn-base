<!--/*
 * Autor: Jamith Bolaños Vidal
 * Fecha: 08/07/2015
 * Modelo que realiza el acceso a los datos relacionado con la información del reporte de resultados
 */-->
<script type="text/javascript" src="<?php echo base_url() ?>public/js/funcionesReporteTrazabilidad.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/js/exporting.js"></script>


<div class="form-group">


    <div class="col-md-8" align="center">
        <div id="reporteTrazabilidad">            
            <div align ="left">
                <button type="button" class="btn btn-default"  onClick="abrirVentantaIndicadores()">Elegir Indicador</button>
                <!--                <button type="button" class="btn btn-default"  onClick="imprimir()">Imprimir</button>        -->
            </div>
            <div id="informacionTrazabilidad" hidden="true">                
                <br/>
                <div align="left">
                    <div class="row">                        
                        <div class="col-md-3"><b><p name="nom" id="nom" >Nombre indicador </p></b> </div>
                        <div class="col-md-9"><output name="nombreIndicador" id="nombreIndicador"></output></div>
                    </div>
                    <!--                    <div class="row">
                                            <div class="col-md-3"><b><p name="nom" id="nom" >Interpretacion </p></b> </div>
                                            <div class="col-md-9"><output name="interpreatacionIndicador" id="interpreatacionIndicador"></output></div>
                                        </div>-->
                    <div class="row">
                        <div class="col-md-3"><b><p name="nom" id="nom" >Definición operacional </p></b> </div>
                        <div class="col-md-9"><output name="definicionOperacional" id="definicionOperacional"></output></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"><b><p name="nom" id="nom" >Constante </p></b> </div>
                        <div class="col-md-9"><output name="coeficienteIndicador" id="coeficienteIndicador"></output></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"><b><p name="nom" id="nom" >Fuente</p></b> </div>
                        <div class="col-md-9"><output name="fuenteIndicador" id="fuenteIndicador"></output></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"><b><p name="nom" id="nom" >Meta óptima </p></b> </div>
                        <div class="col-md-9"><output name="metaIndicador" id="metaIndicador"></output></div>
                    </div>
                    <!--                       Insertar la tabla donde se van a mostrar los resultados del indicador-->
                    <div class="row">
                        <div class="form-group" align="left">
                            <div class="col-md-12" align="left">
                                <br> 
                                <div class="table-responsive">
                                    <table id="resultadoIndicador" name="resultadoIndicador" data-toggle="bootgrid" class="table table-condensed table-hover table-striped" data-ajax="true" cellspacing="0" width="100%" data-url="reporte_resultado/getReporteResultadoPorId" >
                                        <thead>
                                            <tr id="rowTable">
                                    <!--            <th data-column-id="id" data-type="numeric" data-identifier="true">ID</th>-->
                                                <td data-column-id="nombre_indicador">Indicador</td>
                                                <th data-column-id="fecha_inicial">Fecha Inicial</th>
                                                <th data-column-id="fecha_final">Fecha Final</th>                                                 
                                                <th data-column-id="meta">Meta</th>                                                
                                                <th data-column-id="sede_2" data-formatter="sede_2" hidden="true" type="hidden" data-visible="true">Buenos Aires</th>                        
                                                <th data-column-id="sede_3" data-formatter="sede_3" hidden="true" type="hidden" data-visible="true">Corinto</th>
                                                <th data-column-id="sede_4" data-formatter="sede_4" hidden="true" type="hidden" data-visible="true">Tambo</th>
                                                <th data-column-id="sede_5" data-formatter="sede_5" hidden="true" type="hidden" data-visible="true">Florencia</th>
                                                <th data-column-id="sede_6" data-formatter="sede_6" hidden="true" type="hidden" data-visible="true">Guachene</th>
                                                <th data-column-id="sede_7" data-formatter="sede_7" hidden="true" type="hidden" data-visible="true">Páez</th>
                                                <th data-column-id="sede_8" data-formatter="sede_8" hidden="true" type="hidden" data-visible="true">Patía</th>
                                                <th data-column-id="sede_9" data-formatter="sede_9" hidden="true" type="hidden" data-visible="true">Piendamó</th>
                                                <th data-column-id="sede_10" data-formatter="sede_10" hidden="true" type="hidden" data-visible="true">Prto Tejada</th>
                                                <th data-column-id="sede_11" data-formatter="sede_11" hidden="true" type="hidden" data-visible="true">San Sebastián</th>
                                                <th data-column-id="sede_12" data-formatter="sede_12" hidden="true" type="hidden" data-visible="true">Santander</th>
                                                <th data-column-id="sede_13" data-formatter="sede_13" hidden="true" type="hidden" data-visible="true">Totoró</th>                        
                                                <!--<th data-column-id="consolidado" data-formatter="consolidado">Consolidado</th>-->
                                                <th data-column-id="consolidado" data-formatter="consolidado" hidden="true" type="hidden">Consolidado</th>
                                            </tr>
                                        </thead>	
                                    </table>    
                                </div>
                            </div>    
                        </div>
                    </div>
                    <!--Se crea la lista de los municipios con el consolidado, el id es la posicion del departamento en la tabla del bootgrid.
                    -->
                    <div class="col-md-4">                   
                        <select class="form-control"  id="cmbSede" required>
                            <option value="16">Consolidado</option>
                            <option value="4">Buenos aires</option>
                            <option value="5">Corinto</option>
                            <option value="6">Tambo</option>
                            <option value="7">Florencia</option>
                            <option value="8">Guachene</option>
                            <option value="9">Páez</option>
                            <option value="10">Patía</option>
                            <option value="11">Piendamó</option>
                            <option value="12">Prto Tejada</option>
                            <option value="13">San Sebastián</option>
                            <option value="14">Santander</option>
                            <option value="15">Totoró</option>
                        </select>
                        
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-default"  onClick="graficarTrazabilidad()">Graficar Trazabilidad</button>                        
                    </div>
                </div>                
            </div>            
            <div id="container" style="margin: 0 auto" hidden="true">                       
            </div>
            
        </div>
    </div>
 <br>


    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Información sobre el indicador</h4>
                </div>
                <div class="modal-body" align="left">

                    <div class="table-responsive">            
                        <table id="grid-data" class="table table-bordered table-hover table-striped"  data-ajax="true" cellspacing="0" width="100%" data-url="reporte_trazabilidad/getIndicadoresDiligenciados">
                            <thead>
                                <tr>                                        
                                    <th data-column-id="nombre_indicador">Indicador</th>
                                    <th data-column-id="meta">Meta</th>
                                    <th data-column-id="commands" data-formatter="commands" data-sortable="false">Seleccionar</th>
                                </tr>
                            </thead>	
                        </table>
                    </div>                  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>                    
                </div>
            </div>
        </div>
    </div>
</div>

