<!--/*
 * Autor: Jamith Bolaños Vidal
 * Fecha: 08/07/2015
 * Modelo que realiza el acceso a los datos relacionado con la información del reporte de resultados
 */-->
<link href="<?php echo base_url() ?>public/css/jquery.bootgrid.css" rel="stylesheet">
<script src="<?php echo base_url() ?>public/js/jquery.bootgrid.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/js/funcionesReporteInsatisfactorias.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/js/highcharts.js"></script>
<script type="text/javascript">
    var rol = '<?= $this->session->userdata('rol') ?>'; //Se asigna el rol del usuario
</script>
<div class="form-group">
    <div class="col-md-10">
        <br>
        <div class="container">
            <div class="bootstrap-table">
                <div class="table-responsive">
                    <table id="grid-data" class="table table-hover table-stripedz" data-toggle="bootgrid" data-ajax="true" cellspacing="0" width="100%" data-url="reporte_tamizacion/getReporteTamizacion">
                        <thead>
                            <tr>
                                <th data-column-id="cedula">Cedula</th>
                                <th data-column-id="nombre">Nombres</th>
                                <th data-column-id="telefono">Contacto</th>
                                <th data-column-id="campania">N° Campaña</th>
                                <th data-column-id="cod_mx">Cód Muestra</th>
                                <th data-column-id="municipio">Municipio</th>
                                <th data-column-id="ips">Ips</th>
                                <th data-column-id="fecha_toma">Fecha toma</th>
                                <th data-column-id="fecha_seg_toma">Fecha retoma</th>           
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>