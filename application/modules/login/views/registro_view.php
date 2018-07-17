<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Registrarme</title>
    </head>

    <body>
        <h3>REGISTRO</h3><br>


        <form action="<?= base_url() . 'login/usuarios/crear' ?>" align="center" method="POST"> 

            <label for="Nombre">Nombres:</label> 
            <input type="text" name="nombres" value="nombres" /><br />

            <label for="Apellido">Apellidos:</label>
            <input type="text" name="apellidos" value=""/><br />

            <label for="Identificacion">Numero identificación:</label>
            <input type="text" name="numero_identificacion" value=""/><br />

            <label for="Correo">Correo:</label>
            <input type="text" name="correo" value=""/><br />

            <label for="Fecha_nacimiento">Fecha de nacimiento:</label>
            <input type="text" name="fecha_nacimiento" value="" /><br />

            <label for="Username">Nombre de Usuario:</label>
            <input type="text" name="username" value=""/><br />

            <label for="Contraseña">Contraseña:</label>
            <input type="password" name="contrasena" value=""/><br />


            <!--<label>Institución educativa:</label>  
            <input type="Text" name="institucion_educativa"></input><br>
    
            <label>Grado/Semestre:</label>  
            <input type="text" name="grado_semestre"></input><br>
    
            <label>Cargo:</label>  <select name="cargo">
                            <option value="Estudiante">Estudiante</option>
                            <option value="Docente">Docente</option>
            <option value="Padre de familia">Padre de familia</option>
                            </select><br><br>-->
            <input type="submit" name="submit_reg" value="Registrar" />



<!--<a href="usuario.php"><input class="btn" type="submit" value="Volver"></a>
<a href="usuario.php"><input class="btn" type="submit" value="Volver"></input><br></a>-->
        </form>
        <hr>
        <?= validation_errors(); ?>
        </hr>
        <br>

    </body>
</html>