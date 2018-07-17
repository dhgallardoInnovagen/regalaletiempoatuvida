<link href="<?php echo base_url() ?>public/css/jquery.bootgrid.css" rel="stylesheet">
<script src="<?php echo base_url() ?>public/js/jquery.bootgrid.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/js/funcionesReporte4505.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/js/highcharts.js"></script>
<!--Comentario en HTML -->
<div class="col-sm-9">

    <div class="row" id="hola" >
        <div class="col-sm-4 form-group">
         <div class='input-group date' id='fechaInicial'>
            <input type='text'  class="form-control" id="fechaInicialInput" placeholder ="Fecha Inicial" required />
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
    </div>
    <div class="col-sm-4 form-group">
        <div class='input-group date'  id='fechaFinal'>
            <input type='text' class="form-control"  id="fechaFinalInput" placeholder ="Fecha Final"required  />
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
    </div>
    <div class="col-sm-3 form-group">
        <button  onClick="funcionEnviar()" class="btn btn-primary" >
            <span class="glyphicon glyphicon-download-alt" aria-hidden="true"> Consultar</span>
        </button>
    </div>
</div> 


<!--Modal Reporte 4505 --> 

<div class="form-group" id="modalreporte4505" hidden="true" >
    <div class="col-md-12">
        <br>
        <!--<div class="container">-->
            <div class="bootstrap-table">
                <div class="table-responsive">
                    <table id="grid-data" class="table table-hover table-stripedz" data-toggle="bootgrid" data-ajax="true" cellspacing="0" width="80%">
                        <thead>
                            <tr>
                                <th data-column-id="codigo_ips">Código de habilitación IPS primaria</th>
                                <th data-column-id="tipo_id">Tipo de documento</th>
                                <th data-column-id="numero_documento">Numero Documento</th>
                                <th data-column-id="primer_apellido">Primer Apellido</th>
                                <th data-column-id="segundo_apellido2">Segundo Apellido</th>
                                <th data-column-id="primer_nombre">Primer Nombre</th>
                                <th data-column-id="segundo_nombre2">Segundo Apellido</th>
                                <th data-column-id="fecha_nacimiento">Fecha Nacimiento</th>
                                <th data-column-id="fecha_toma">Fecha toma</th>
                                <th data-column-id="genero">Sexo</th>
                                <th data-column-id="pertenencia_etnica1">Pertenencia Etnica</th>
                                <th data-column-id="ocupacion3">Codigo de ocupacion</th>
                                <th data-column-id="nivel_educativo1">Nivel Educativo</th>
                                <th data-column-id="fecha_toma_peso1">Fecha del Peso</th>
                                <th data-column-id="peso">Peso en Kilogramos</th>
                                <th data-column-id="replace">Talla en centimetros</th>
                                <th data-column-id="tamizaje_cuello_terino">Tamizaje Cáncer de Cuello Uterino</th>
                                <th data-column-id="fecha_toma">Fecha Citología Cervico uterina</th>
                                <th data-column-id="fecha_ultima_citologia_4505">Citología Cervico uterina Resultados según Bethesda</th> 
                                <th data-column-id="calidad_muestra1">Calidad en la Muestra de Citología Cervicouterina</th>   
                                <th data-column-id="codigo_ips">Código de habilitación IPS donde se toma Citología Cervicouterina</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        <!--</div>-->
    </div>
</div>
 

