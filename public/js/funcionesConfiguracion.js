$(document).ready(function () {

    
    var base_url = window.location.origin;
    var getUsuario = function () {
        return $.getJSON("configuracion/getUsuariosPorId", {});
    };
    getUsuario()
            .done(function (response) {
                //done() es ejecutada cuándo se recibe la respuesta del servidor. response es el objeto JSON recibido
                if (response.success) {
                    $('#idUsuarioInput').val(response.data[0].id_usuario);
                    $('#documentoInput').val(response.data[0].numero_documento);
                    $('#correoInput').val(response.data[0].correo);
                    $('#apellidoInput').val(response.data[0].apellidos);
                    $('#telefonoInput').val(response.data[0].telefono);
                    $('#nombreInput').val(response.data[0].nombres);
                    

                }
            });


 

    $("#form-edit-usuario").submit(function (e) {

        e.preventDefault();
        var datos = $('#form-edit-usuario').serializeArray();
        var fileSelect = document.getElementById('inputImagen');
        var files = fileSelect.files;
        //var formData = new FormData();
        var formData = new FormData();
        formData.append('inputImagen', files);
        $.ajax({
            url: 'configuracion/getGuardarDatos',
            type: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function () {
                alert("Datos ingresados Correctamente");
                location.reload();
            },
            error: function (error) {
                alert("Error de Datos");
            }
        });
        return false;
    });



    $('#sumit').click(function () {
        if ($("#correoInput").val().indexOf('@', 0) == -1 || $("#correoInput").val().indexOf('.', 0) == -1) {
            alert('El correo electrónico introducido no es correcto.');
            return false;
        }
    });

    $("#fm_cambiarContrasena").submit(function (e) {

        e.preventDefault();
        var datos = $('#fm_cambiarContrasena').serializeArray();
        //var formData = new FormData();
        var formData = new FormData();
        $.ajax({
            url: 'configuracion/guardarContrasena',
            type: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function () {
                alert("Cambio de Contraeña Correctamente");
                location.reload();
            },
            error: function (error) {
                alert("Error de cambio de contraseña");
            }
        });

        $('#modalcambiarContrasena').modal('hide');
    });
});

function soloNumeros(e) {
    var key = window.Event ? e.which : e.keyCode
    return ((key >= 48 && key <= 57) || (key == 8))
}


/*Final*/

function abrirModelContrasena() {
    $('#modalcambiarContrasena').modal('show');
}

/*function base64encode(binary) {
    return btoa(unescape(encodeURIComponent(binary)));
}*/

function base64Encode(str) {
        var CHARS = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
        var out = "", i = 0, len = str.length, c1, c2, c3;
        while (i < len) {
            c1 = str.charCodeAt(i++) & 0xff;
            if (i == len) {
                out += CHARS.charAt(c1 >> 2);
                out += CHARS.charAt((c1 & 0x3) << 4);
                out += "==";
                break;
            }
            c2 = str.charCodeAt(i++);
            if (i == len) {
                out += CHARS.charAt(c1 >> 2);
                out += CHARS.charAt(((c1 & 0x3)<< 4) | ((c2 & 0xF0) >> 4));
                out += CHARS.charAt((c2 & 0xF) << 2);
                out += "=";
                break;
            }
            c3 = str.charCodeAt(i++);
            out += CHARS.charAt(c1 >> 2);
            out += CHARS.charAt(((c1 & 0x3) << 4) | ((c2 & 0xF0) >> 4));
            out += CHARS.charAt(((c2 & 0xF) << 2) | ((c3 & 0xC0) >> 6));
            out += CHARS.charAt(c3 & 0x3F);
        }
        return out;
    }