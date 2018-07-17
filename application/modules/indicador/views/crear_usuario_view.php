<link href="<?php echo base_url() ?>public/css/jquery.bootgrid.css" rel="stylesheet">
<script src="<?php echo base_url() ?>public/js/jquery.bootgrid.js"></script>
<script src="<?php echo base_url() ?>public/css/jquery.easyui.min.js"></script>
<link href="<?php echo base_url() ?>public/css/fileinput.css" rel="stylesheet">
<link href="<?php echo base_url() ?>public/css/easy.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url() ?>public/js/funcionesCrearUsuario.js"></script>

       
        
        
       
       

 
        <form id="form-create-empleado"  action="<?= base_url() . 'indicador/crear_usuario/crear' ?>" align="center" method="POST"> 

            <label for="Nombre">Nombres:</label> 
            <input type="text" name="nombres"  /><br />

            <label for="Apellido">Apellidos:</label>
            <input type="text" name="apellidos" value=""/><br />

            <label for="Identificacion">Numero identificación:</label>
            <input type="text" name="numero_identificacion" value=""/><br />

            <label for="Correo">Correo:</label>
            <input type="text" name="correo" value=""/><br />

            <label for="Correo">Telefono:</label>
            <input type="text" name="telefono" value=""/><br />

            <label for="Fecha_nacimiento">Fecha de nacimiento:</label>
            <input type="text" name="fecha_nacimiento" value="" /><br />

            <select name="sistema">
            	<option>PORTAL INDICADORES</option>
            	<option>SGBD</option>
            </select >
            <select name="ips" id="ipsInput">
                
            </select>
            <select name="usuarioI" id="usuarioInput">
            </select>
            
            <select name="eps" id="epsInput">
            </select>
            <label for="Username">Nombre de Usuario:</label>
            <input type="text" name="username" value=""/><br />

            <label for="Contraseña">Contraseña:</label>
            <input type="password" name="contrasena" value=""/><br />
            <input type="file"  name="foto_user">
            <input type="submit" name="submit_reg" value="Registrar" />

        </form>
        <hr>
        <?= validation_errors(); ?>
        </hr>
        <br>

