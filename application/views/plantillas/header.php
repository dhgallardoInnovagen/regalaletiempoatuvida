<!DOCTYPE html>
<html>
    <?php
    if ($this->session->userdata('logged_in') == FALSE) {
        redirect('login');
    }
    ?>
    <head>
        <link rel="icon" href="<?php echo base_url() ?>public/images/favicon.png">       
        <!-- Bootstrap core JS -->             
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
        <!-- Bootstrap core CSS -->
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
    <nav  class="navbar navbar-default" >
        <div class="col-md-8">
            <table border='0'>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>
                        <img class="img-responsive" align='left' width='15%' height="5%" src="<?php echo base_url(); ?>public/images/logo-pie-de-pagina.png">
                        <br>
                        <h4 ><font color='#fffff' style="font-family: 'Comfortaa'">&nbsp;&nbsp;Portal Indicadores</font></h4>
                    </td>
                </tr>
            </table>
        </div>
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li id="user-setting" class="dropdown">           
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" id='btnMenuConfig'>
                        <img src="<?php echo base_url() ?>indicador/configuracion/traerUsuarioFoto">
                        <label id="nombre_usuario" class="hidden-xs"></label></span> <label id="apellido_usuario" class="hidden-xs"></label>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" id="user-setting2">
                        <?php if ($this->session->userdata('rol') == 1) { ?>  
                            <!--rol administrado y tecnico-->
                            <li><a href="<?php echo base_url(); ?>indicador/gestionar_usuario"><span class="glyphicon glyphicon-user"></span> Gestionar Usuarios</a></li>
                        <?php } ?>
                        <li><a href="<?php echo base_url(); ?>indicador/configuracion" ><span class="glyphicon glyphicon-cog"></span> Mi Cuenta</a></li>
                        <li><a href="<?php echo base_url(); ?>public/recursos/Manual de Usuario portal Indicadores - V0.4.pdf" download="Manual de usuario.pdf"><span class="glyphicon glyphicon-file"></span> Manual de usuario</a></li>
                        <li><a href="<?php echo base_url(); ?>login/logout"><span class="glyphicon glyphicon-off"></span> Salir</a></li>                       
                    </ul>
                </li>

            </ul>
        </div>
    </nav>

    <!--Fin del panel-->
</head>
<body>
    <div class="row"><!-- este div se cierra en el footer-->