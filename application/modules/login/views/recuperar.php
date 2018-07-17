<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <div class="container">
            <?php
            echo validation_errors();
            echo form_open();
            echo form_fieldset('Recuperar Contraseña');
            ?>
            <p>
                <?php
                echo form_label('Correo Electronico');
                $datos = array(
                    'name' => 'correo',
                    'id' => 'correo',
                    'placeholder' => 'Digita tu Correo'
                );
                echo form_input($datos);
                ?>
            </p>
            <p>
                <?php
                $datos = array(
                    'value' => 'Recuperar Contraseña'
                );
                echo form_submit($datos);
                ?>
            </p>

            <?php
            echo form_fieldset_close();
            echo form_close();
            ?>
        </div>
    </body>
</html>