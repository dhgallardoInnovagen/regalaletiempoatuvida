$(document).ready(function () {+3
    0
    var getUsuarioInicial = function () {
        return $.getJSON(BASE_URL + 'indicador/configuracion/getUsuariosPorId', {});
    };
    getUsuarioInicial()
            .done(function (response) {
                //done() es ejecutada cuándo se recibe la respuesta del servidor. response es el objeto JSON recibido
                if (response.success) {
                    $('#idUsuarioInput').val(response.data[0].id_usuario);
                    $('#apellido_usuario').text(response.data[0].apellidos);
                    $('#nombre_usuario').text(response.data[0].nombres);
                }
            });

});



