<!--<script type="text/javascript" src="<?php echo base_url() ?>public/js/funcionesWest.js"></script>-->
<!--<link rel="stylesheet" href="<?php echo base_url() ?>public/css/menucss.css" type="text/css"/>-->
<!--        <meta charset="utf-8">-->
<!--        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
         The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags 
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="<?php echo base_url() ?>public/images/favicon.png">       
         Bootstrap core JS              
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.min.js"></script> 
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.easyui.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>public/js/bootstrap.min.js" ></script>
        <script type="text/javascript" src="<?php echo base_url() ?>public/js/bootstrap-formhelpers.js" ></script>
        <script type="text/javascript" src="<?php echo base_url() ?>public/js/jquery.bootgrid.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>public/js/moment.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>public/js/bootstrap-datetimepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>public/js/validator.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>public/js/funcionesHeader.js"></script>
        <script type="text/javascript">
            var BASE_URL = '<?php echo base_url(); ?>';
        </script>    <title>:.Regálale tiempo a tu vida.:</title>
         Bootstrap core CSS 
        <link href="<?php echo base_url() ?>public/css/bootstrap.css" rel="stylesheet"> 
        <link href="<?php echo base_url(); ?>/public/css/bootstrap-formhelpers.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>public/css/jquery.bootgrid.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>public/css/bootstrap-datetimepicker.min.css" rel="stylesheet">    
        <link href="<?php echo base_url() ?>public/css/bootstrap-table.css" rel="stylesheet" type="text/css" >
        <link href="<?php echo base_url() ?>public/css/saphv2.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>public/css/principal.css" rel="stylesheet" type="text/css" >
        <link href="<?php echo base_url() ?>public/css/styleMenu.css" rel='stylesheet' type='text/css' />
        <link rel="stylesheet" href="<?php echo base_url() ?>public/css/font.css" type="text/css"/>
        <script src="<?php echo base_url() ?>public/js/modernizr.js"></script>
<link href="<?php echo base_url() ?>public/css/styleMenu.css" rel='stylesheet' type='text/css' />-->
<link href="<?php echo base_url() ?>public/css/styleMenu.css" rel='stylesheet' type='text/css' />
<script src="<?php echo base_url() ?>public/js/modernizr.js"></script>

<div class="col-sm-1" style="padding-left: -15px;">
    <nav class="main-menu">
        <div class="contenedor1">
            <div class="contenedor2">
                <ul>
                    <li>
                        <a href="<?php echo base_url(); ?>indicador/reporte_tamizacion">
                            <img id="icnTamizacion" class="icon-menu" src="<?php echo base_url(); ?>public/images/iconos/Icon_Tamizacion.png">
                            <span class="nav-text">                      
                                Reporte tamización
                            </span>
                        </a>
                    </li>             
                    <li>
                        <a href="<?php echo base_url(); ?>indicador/gestion_positivas">
                            <img id="icnPositivas" class="icon-menu" src="<?php echo base_url(); ?>public/images/iconos/Icon_Positivas.png">                    
                            <span class="nav-text">
                                Gestion Positivas
                            </span>                    
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>indicador/reporte_insatisfactorias">
                            <img id="icnPositivas" class="icon-menu" src="<?php echo base_url(); ?>public/images/iconos/Icon_Insatisfactorias.png">                    
                            <span class="nav-text">
                                Reporte insatisfactorias
                            </span>                    
                        </a>
                    </li>
                    <?php if ($this->session->userdata('rol') == 1) { ?> 
                        <li class="has-subnav">
                            <a href="<?php echo base_url(); ?>indicador/gestionarIndicador">
                                <img id="icnGIndicador" class="icon-menu" src="<?php echo base_url(); ?>public/images/iconos/Icon_GIndicador.png">                         
                                <span class="nav-text">
                                    Gestionar indicador
                                </span>                         
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($this->session->userdata('rol') == 1 || $this->session->userdata('rol') == 2) { ?>  
                        <!--                rol administrado y tecnico-->
                        <li>
                            <a href="<?php echo base_url(); ?>indicador/sincronizar_datos">
                                <img id="icnTamizacion" class="icon-menu" src="<?php echo base_url(); ?>public/images/iconos/Icon_pdf.png">
                                <span class="nav-text">                      
                                    Sincronizar Datos
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>indicador/listas_embalaje">
                                <img id="icnTamizacion" class="icon-menu" src="<?php echo base_url(); ?>public/images/iconos/Icon_pdf.png">
                                <span class="nav-text">                      
                                    Listas Embalaje
                                </span>
                            </a>
                        </li>
                        <li class="has-subnav">
                            <a href="<?php echo base_url(); ?>indicador/ingresar_indicador">
                                <img id="icnIngIndicador" class="icon-menu" src="<?php echo base_url(); ?>public/images/iconos/Icon_Indicador.png">                          
                                <span class="nav-text">
                                    Ingresar Indicador
                                </span>                         
                            </a>
                        </li>
                        <li class="has-subnav">
                            <a href="<?php echo base_url(); ?>indicador/importarDatosView"">
                                <img id="icnImportar" class="icon-menu" src="<?php echo base_url(); ?>public/images/iconos/Icon_Importar.png">                       
                                <span class="nav-text">Importar Datos</span>                       
                            </a>

                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>indicador/exportar_encuesta">
                                <img id="icnExportar" class="icon-menu" src="<?php echo base_url(); ?>public/images/iconos/Icon_Exportar.png">                         
                                <span class="nav-text">
                                    Exportar Encuesta
                                </span>                       
                            </a>
                        </li>   
                        <li>
                            <a href="<?php echo base_url(); ?>indicador/validar_encuesta">
                                <img id="icnValidar" class="icon-menu" src="<?php echo base_url(); ?>public/images/iconos/Icon_Validar.png">                          
                                <span class="nav-text">
                                    Validador Encuestas
                                </span>                         
                            </a>
                        </li>    
                        <li>
                            <a href="<?php echo base_url(); ?>indicador/inconsistencia">
                                <img id="icnInconsistencias" class="icon-menu" src="<?php echo base_url(); ?>public/images/iconos/Icon_Inconsistencias.png">                          
                                <span class="nav-text">
                                    Gestionar Inconsistencia
                                </span>                      
                            </a>
                        </li>   
                    <?php } ?>
                    <?php if ($this->session->userdata('rol') == 1 || $this->session->userdata('rol') == 2 || $this->session->userdata('rol') == 3) { ?>
                        <!--                rol administrado y tecnico-->
                        <li>
                            <a href="<?php echo base_url(); ?>indicador/resultados_pdf">
                                <img id="icnPdf" class="icon-menu" src="<?php echo base_url(); ?>public/images/iconos/Icon_pdf.png">                          
                                <span class="nav-text">
                                    Resultados PDF
                                </span>                         
                            </a>
                        </li>   
                        <li>
                            <a href="<?php echo base_url(); ?>indicador/validar_survey">
                                <img id="icnSurvey" class="icon-menu" src="<?php echo base_url(); ?>public/images/iconos/Icon_SurveyGizmo.png">                          
                                <span class="nav-text">
                                    Validar SurveyGizmo
                                </span>                          
                            </a>
                        </li>
                    <?php } ?>

                    <li>
                        <a href="<?php echo base_url(); ?>indicador/reporte_resultado">
                            <img id="icnMedicion" class="icon-menu" src="<?php echo base_url(); ?>public/images/iconos/Icon_Medicion.png">
                            <span class="nav-text">
                                Reporte Medición
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>indicador/reporte_trazabilidad">
                            <img id="icnTrazabilidad" class="icon-menu" src="<?php echo base_url(); ?>public/images/iconos/Icon_Trazabilidad.png">
                            <span class="nav-text">
                                Reporte Trazabilidad
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>indicador/reporte_4505">
                            <img id="icn4505" class="icon-menu"  src="<?php echo base_url(); ?>public/images/iconos/Icon_4505.png">
                            <span class="nav-text">
                                Reporte 4505
                            </span>
                        </a>
                    </li>                    
                </ul>  
            </div>
        </div>
    </nav>
</div>
