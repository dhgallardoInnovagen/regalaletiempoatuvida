/*
 * Desarrollado por: Jamith Bolaños Vidal
 * 13 Mayo 2015
 * funciones en javascript para desarrollar funcionalidades sobre Login
 */

var url;
var inconsistencias;

$(document).ready(function () {
    $('#cedulas').keyup(function (e) {
        if (e.keyCode === 13) {
            validarInconsistencias();
        }
    });
    $('#tipoBusqueda').val('cedula');

    $('#fechaEnvio').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    $('#tipoBusqueda').change(function () {
        if ($(this).val() == 'cedula' || $(this).val()=='telefono') {
            $('#inputCedula').show();
            $('#inputFecha').hide();
        } else {
            $('#inputCedula').hide();
            $('#inputFecha').show();
        }
    });
}).end();

function validar(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla.keyPress == 17 && tecla.keyPress == 86)
        return true;
    if (tecla == 8 || tecla == 0)
        return true;
    patron = /[0123456789,]/;
    te = String.fromCharCode(tecla);
    return patron.test(te);
}

function validarInconsistencias() {
    $("#gridValidarEncuestas").bootgrid('destroy');
    $("#gridValidarEncuestas").bootgrid({
        navigation: 0,
        post: {
            cedula: $('#cedulas').val(),
            fecha: $('#fechaEnvioInput').val(),
            tipoBusqueda: $('#tipoBusqueda').val()
        }, labels: {
            infos: ""
        }, responseHandler: function (rq) {
            return rq;
        },
        formatters: {
            "formatEpidemiologica": function (column, row)
            {
                if (row.epidemiologica === 'SI') {
                    return '<span class="label label-success">SI</span>';
                } else {
                    return '<span class="label label-danger">NO</span>';
                }
            },
            "formatEstadoCuello": function (column, row)
            {
                if (row.estadoCuello === 'SI') {
                    return '<span class="label label-success">SI</span>';
                } else {
                    return '<span class="label label-danger">NO</span>';
                }
            }
        },
        url: "validar_survey/validarEncuestas"
    });
}

