<!--/*
 * Autor: Jamith Bolaños Vidal
 * Fecha: 08/07/2015
 * Modelo que realiza el acceso a los datos relacionado con la información del reporte de resultados
 */-->
<script type="text/javascript" src="<?php echo base_url() ?>public/js/funcionesReporteResultado.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/js/highcharts.js"></script>

<div class="form-group">
    <div class="col-md-9">
        <br> 
        <div class="container">
            <div class="bootstrap-table">
                <div class="table-responsive">            
                    <table id="grid-data" class="table table-bordered table-hover table-striped" data-toggle="bootgrid" data-ajax="true" cellspacing="0" width="100%" data-url="reporte_resultado/getReporteResultado">
                        <thead>
                            <tr>                   
                                <th data-column-id="nombre_indicador">Indicador</th>
                                <th data-column-id="fecha_inicial">Fecha Inicial</th>
                                <th data-column-id="fecha_final">Fecha Final</th>
                                <th data-column-id="sede_2" data-formatter="sede_2">Buenos Aires</th>                        
                                <th data-column-id="sede_3" data-formatter="sede_3">Corinto</th>
                                <th data-column-id="sede_4" data-formatter="sede_4">Tambo</th>
                                <th data-column-id="sede_5" data-formatter="sede_5">Florencia</th>
                                <th data-column-id="sede_6" data-formatter="sede_6">Guachene</th>
                                <th data-column-id="sede_7" data-formatter="sede_7">Páez</th>
                                <th data-column-id="sede_8" data-formatter="sede_8">Patía</th>
                                <th data-column-id="sede_9" data-formatter="sede_9">Piendamó</th>
                                <th data-column-id="sede_10" data-formatter="sede_10">Prto Tejada</th>
                                <th data-column-id="sede_11" data-formatter="sede_11">San Sebastián</th>
                                <th data-column-id="sede_12" data-formatter="sede_12">Santander</th>
                                <th data-column-id="sede_13" data-formatter="sede_13">Totoró</th>                        
                                <th data-column-id="consolidado" data-formatter="consolidado">Consolidado</th>
<!--                                <th data-column-id="tipo_meta" >Tipo meta</th>
                                <th data-column-id="meta" data-formatter="inaceptable">Inaceptable</th>
                                <th data-column-id="meta" data-formatter="optima">Optimo</th>                                               -->
                                <!--<th data-column-id="semaforo" data-formatter="semaforo" data-sortable="false">Meta</th>-->
                            </tr>
                        </thead>	
                    </table>
                </div>  
            </div>
        </div>
    </div>

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
                    <div class="row">                        
                        <div class="col-md-3"><b><p name="nom" id="nom" >Nombre indicador </p></b> </div>
                        <div class="col-md-9"><output name="nombreIndicador" id="nombreIndicador"></output></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"><b><p name="nom" id="nom" >Interpretacion </p></b> </div>
                        <div class="col-md-9"><output name="interpreatacionIndicador" id="interpreatacionIndicador"></output></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"><b><p name="nom" id="nom" >Definición operacional </p></b> </div>
                        <div class="col-md-9"><output name="definicionOperacional" id="definicionOperacional"></output></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"><b><p name="nom" id="nom" >Coeficiente </p></b> </div>
                        <div class="col-md-9"><output name="coeficienteIndicador" id="coeficienteIndicador"></output></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"><b><p name="nom" id="nom" >Fuente</p></b> </div>
                        <div class="col-md-9"><output name="fuenteIndicador" id="fuenteIndicador"></output></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"><b><p name="nom" id="nom" >Meta </p></b> </div>
                        <div class="col-md-9"><output name="metaIndicador" id="metaIndicador"></output></div>
                    </div>
                    <!--   Insertar la tabla donde se van a mostrar los resultados del indicador-->
                    <div class="row">
                        <div class="form-group" align="center">
                            <div class="col-md-10" align="center">
                                <br> 
                                <div class="table-responsive">
                                    <table id="resultadoIndicador" class="table table-condensed table-hover table-striped" data-ajax="true" cellspacing="0" width="100%" >
                                        <thead>
                                            <tr>
                                    <!--            <th data-column-id="id" data-type="numeric" data-identifier="true">ID</th>-->
                                                <th data-column-id="fecha_inicial">Fecha Inicial</th>
                                                <th data-column-id="fecha_final">Fecha Final</th>
                                                <th data-column-id="numerador">Numerador</th>
                                                <th data-column-id="denominador">Denominador</th>
                                                <th data-column-id="meta">Meta</th>
                                                <th data-column-id="resultado" data-formatter="formatResultado">Resultado</th>
                                            </tr>
                                        </thead>	
                                    </table>    
                                </div>
                            </div>    
                        </div>
                    </div>
                    <button type="button" class="btn btn-default"  onClick="graficarTrazabilidad()">Graficar</button>
                    <div id="container" style="margin: 0 auto">                       
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


