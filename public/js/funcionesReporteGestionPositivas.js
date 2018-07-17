/*
 * Desarrollado por: Jamith Bolaños Vidal
 * 13 Mayo 2015
 * funciones en javascript para desarrollar funcionalidades sobre Login
 */

//var idIndicador = null;
$(document).ready(function () {
    $('#fechaAtencion').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('#fechaTratamiento').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('#fechaNotificacion').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('#fechaControl').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('#fechaVisita').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('#formAtenciones').validator().on('submit', function (e) {
        if (e.isDefaultPrevented()) {
            return false;
        }
        else {
            e.preventDefault();
            guardarAtenciones();
        }
    });

    $('#formTratamientos').validator().on('submit', function (e) {
        if (e.isDefaultPrevented()) {
            return false;
        }
        else {
            e.preventDefault();
            guardarTratamientos();
        }
    });

    $('#formSeguimiento').validator().on('submit', function (e) {
        if (e.isDefaultPrevented()) {
            return false;
        }
        else {
            e.preventDefault();
            guardarSeguimiento();
        }
    });
    head = "<div id=\"{{ctx.id}}\" class=\"{{css.header}}\"><div class=\"row\"><div class=\"col-sm-12 actionBar\">";
    if (rol == 1 || rol == 2) {
        head = head + "<div class=\"btn-group\" role=\"group\">"
                + "<button type=\"button\"  class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" onClick=actualizarPositivas() aria-haspopup=\"true\" aria-expanded=\"false\"><span class=\"glyphicon glyphicon-check\" aria-hidden=\"true\"> Actualizar Positivas</span>"
                + "</button>"
                + "</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    }
//   head = head + '<div class="btn-group" role="group"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Ver <span class="caret"></span></button><ul class="dropdown-menu"><li><a href="#">Todo</a></li><li><a onClick="verConSeguimiento">Con seguimiento</a></li></ul></div>'
    head = head + "<div class=\"btn-group\" role=\"group\">"
    head = head + "<button type=\"button\" class=\"btn btn-default\" onClick=\"VerUsuariasSeguimiento()\"><span class=\"glyphicon glyphicon-eye-open\" aria-hidden=\"true\"></span>&nbsp;Ver seguimientos </button>"
//            + "<button type=\"button\"  class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" onClick=\"location.href='gestion_positivas/exportarReporteTamizacion'\" aria-haspopup=\"true\" aria-expanded=\"false\"><span class=\"glyphicon glyphicon-download-alt\" aria-hidden=\"true\"> Consolidado</span>"
//            + "</button>"
            + "</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<p class=\"{{css.search}}\"></p><p class=\"{{css.actions}}\"></p></div></div></div>";



    var grid = $("#grid-data").bootgrid({
        ajax: true,
        post: function ()
        {
            /* To accumulate custom parameter with the request object */
            return {
                id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
            };
        },
        url: "gestion_positivas/getPositivas",
        selection: true,
        multiSelect: true,
        labels: {
            search: "Buscar"
        }
        ,
        templates: {
            header: head
        },
        formatters: {
            "commands": function (column, row)
            {
                return '<button id="btnDesplegarRegistroInd" onClick="abrirVentanaGestinarPositiva(' + row.id_positivas + ')" type="button" class="btn btn-xs btn-default command-edit" data-row-id="' + row.id_positivas + ' "><span class="glyphicon glyphicon-edit"></span></button>';
            },
            "seguimiento": function (column, row) {
                if (row.estado == 'SEGUIMIENTO') {
                    return "<b>" + row.cedula + " </b><span class=\"label label-success\">Con seguimiento</span>";
                } else {
                    return "<b>" + row.cedula + " </b><span class=\"label label-warning\">Sin seguimiento</span>";
                }
            }
        }
    });
}).end();

function exportarReporteTamizacion() {
    $.post('gestion_positivas/exportarReporteTamizacion');
}

function abrirVentanaGestinarPositiva(id_positivas) {
    $('#modalGestionPositivas').modal('show');
    asignarDatos(id_positivas);
}

function asignarDatos(id_positiva) {
    var i = 0;
    var row = $("#grid-data").bootgrid("getCurrentRows");
    while (i < row.length) {
        if (id_positiva.toString() === row[i].id_positivas) {
            $('#nombre').val(row[i].nombre);
            $('#cedula').val(row[i].cedula);
            $('#direccion').val(row[i].direccion);
            $('#municipio').val(row[i].municipio);
            $('#edad').val(row[i].edad);
            $('#telefono').val(row[i].telefono);
            $('#eps').val(row[i].eps);
            $('#ips').val(row[i].ips);
            $('#citologia').val(row[i].resul_cito);
            $('#vph').val(row[i].resul_vph);
            $('#fecha_toma').val(row[i].fecha_toma);
            $('#conducta').val(row[i].conducta);
            $('#conductaForm').val(row[i].conducta);
            $("#fechaNotificacionInput").val(row[i].fecha_noti_eps);
            $("#numero_notificacion").val(row[i].no_oficio);
            $("#fechaControlInput").val(row[i].fecha_control_cotest);
            $("#resultadoControl").val(row[i].resultado_control);
            $("#fechaVisitaInput").val(row[i].fecha_visita_domiciliaria);
            $("#obs_visita_domiciliaria").val(row[i].visita_domiciliaria);
            $("#obs_eps").val(row[i].observaciones_eps);
            $("#obs_pnto_atencion").val(row[i].observaciones_pto);
            $("#obs_sdsc").val(row[i].observaciones_sds);
            $('#id_positiva').val(id_positiva);
            i = row.length;
        }
        i++;
    }

    $("#grid-data-atenciones").bootgrid('destroy');
    var grid = $("#grid-data-atenciones").bootgrid({
        ajax: true,
        navigation: 0,
        post: function ()
        {
            /* To accumulate custom parameter with the request object */
            return {
                idPositiva: $('#id_positiva').val()
            };
        },
        labels: {
            infos: "",
            noResults: "No existen atenciones para la beneficiaria"

        },
        url: "gestion_positivas/getAtenciones",
        selection: true,
        multiSelect: true
    });

    $("#grid-data-tratamientos").bootgrid('destroy');
    var grid = $("#grid-data-tratamientos").bootgrid({
        ajax: true,
        navigation: 0,
        post: function ()
        {
            /* To accumulate custom parameter with the request object */
            return {
                idPositiva: $('#id_positiva').val()
            };
        },
        labels: {
            infos: "",
            noResults: "No existen tratamientos asociados a la beneficiaria"

        },
        url: "gestion_positivas/getTratamientos",
        selection: true,
        multiSelect: true
    });

}

function guardarAtenciones() {
    $.post('gestion_positivas/asignarAtencion', {
        tipoAtencion: $('#tipoAtencion').val(),
        fechaAtencion: $('#fechaAtencionInput').val(),
        conducta: $('#inputConducta').val(),
        diagnostico: $('#diagnostico').val(),
        idPositiva: $('#id_positiva').val()
    }, function (result) {
        if (result.success) {
            $("#grid-data-atenciones").bootgrid('destroy');
            var grid = $("#grid-data-atenciones").bootgrid({
                ajax: true,
                navigation: 0,
                post: function ()
                {
                    /* To accumulate custom parameter with the request object */
                    return {
                        idPositiva: $('#id_positiva').val()
                    };
                },
                labels: {
                    infos: "",
                    noResults: "No existen atenciones para la beneficiaria"

                },
                url: "gestion_positivas/getAtenciones",
                selection: true,
                multiSelect: true
            });
            $("#fechaAtencionInput").val('');
            $("#inputConducta").val('');
            $("#diagnostico").val('');
            $("#atenciones").hide();

        } else {
            alert("No se puedo cargar la información, por favor intente nuevamente");
        }
    }, 'json');
}

function guardarTratamientos() {
    $.post('gestion_positivas/asignarTratamiento', {
        tratamiento: $('#tratamiento').val(),
        fechaTratamiento: $('#fechaTratamientoInput').val(),
        idPositiva: $('#id_positiva').val()
    }, function (result) {
        if (result.success) {
            $("#grid-data-tratamientos").bootgrid('destroy');
            var grid = $("#grid-data-tratamientos").bootgrid({
                ajax: true,
                navigation: 0,
                post: function ()
                {
                    /* To accumulate custom parameter with the request object */
                    return {
                        idPositiva: $('#id_positiva').val()
                    };
                },
                labels: {
                    infos: "",
                    noResults: "No existen tratamientos asociados a la beneficiaria"

                },
                url: "gestion_positivas/getTratamientos",
                selection: true,
                multiSelect: true
            });
            $("#formTratamientos").form("clear");
            $("#tratamientos").hide();

        } else {
            alert("No se puedo cargar la información, por favor intente nuevamente");
        }
    }, 'json');
}
function mostarDivAtencion() {
    if ($('#atenciones').is(":hidden")) {
        $("#atenciones").show();
        $("#id_positiva").hide();
    } else {
        $("#atenciones").hide();
    }
}

function mostarDivTratamiento() {
    if ($('#tratamientos').is(":hidden")) {
        $("#tratamientos").show();
    } else {
        $("#tratamientos").hide();
    }
}

function actualizarDaaGrid() {
    $("#grid-data").bootgrid('reload');
}

function guardarSeguimiento() {
    if ($("#conductaForm").val() != "" || $("#fechaNotificacionInput").val() != "" || $("#numero_notificacion").val() != "" || $("#fechaControlInput").val() != "" || $("#resultadoControl").val() != "" || $("#fechaVisitaInput").val() != "" || $("#obs_visita_domiciliaria").val() != "" || $("#obs_eps").val() != "" || $("#obs_pnto_atencion").val() != "" || $("#obs_sdsc").val() != "") {
        $.post('gestion_positivas/asignarSeguimiento', {
            idPositiva: $('#id_positiva').val(),
            conducta: $("#conductaForm").val(),
            fechaNotificacion: $("#fechaNotificacionInput").val(),
            numeroNotificacion: $("#numero_notificacion").val(),
            fechaControl: $("#fechaControlInput").val(),
            resultadoControl: $("#resultadoControl").val(),
            fechaVisita: $("#fechaVisitaInput").val(),
            obs_visita: $("#obs_visita_domiciliaria").val(),
            obs_eps: $("#obs_eps").val(),
            obs_pto_atencion: $("#obs_pnto_atencion").val(),
            obs_sdsc: $("#obs_sdsc").val()
        }, function (result) {
            if (result.success) {
                $("#grid-data").bootgrid('reload');
                $('#success').show();
                $('#modalGestionPositivas').modal('hide');
                $('#msgSuccess').val(result.msg);
                setInterval(function () {
                    $('#success').hide();
                }, 6000);
            } else {
                $('#error').show();
                $('#msgError').val(result.msg);
                setInterval(function () {
                    $('#error').hide();
                }, 6000);
            }
        }, 'json');
    }
}

function VerUsuariasSeguimiento() {
    $("#grid-data").bootgrid('destroy');
    var grid = $("#grid-data").bootgrid({
        ajax: true,
        post: function ()
        {
            /* To accumulate custom parameter with the request object */
            return {
                id: "b0df282a-0d67-40e5-8558-c9e93b7befed",
                seguimiento: true
            };
        },
        url: "gestion_positivas/getPositivas",
        selection: true,
        multiSelect: true,
        labels: {
            search: "Buscar"
        }
        ,
        templates: {
            header: head
        },
        formatters: {
            "commands": function (column, row)
            {
                return '<button id="btnDesplegarRegistroInd" onClick="abrirVentanaGestinarPositiva(' + row.id_positivas + ')" type="button" class="btn btn-xs btn-default command-edit" data-row-id="' + row.id_positivas + ' "><span class="glyphicon glyphicon-edit"></span></button>';
            },
            "seguimiento": function (column, row) {
                if (row.estado == 'SEGUIMIENTO') {
                    return "<b>" + row.cedula + " </b><span class=\"label label-success\">Con seguimiento</span>";
                } else {
                    return "<b>" + row.cedula + " </b><span class=\"label label-warning\">Sin seguimiento</span>";
                }
            }
        }
    });
}

function actualizarPositivas() {
    //alert("actualizando positivas");
     $("#loading").show();
    $.post('gestion_positivas/actualizarPositivas', function (result) {
        if (result.success) {
            $("#loading").hide();
            $('#success').show();
            $('#msgSuccess').val("Se ingresaron " + result.contadoPositivas + " datos de beneficiarias positivas y " + result.contadorSeguimientos + " Seguimiento.");
            setInterval(function () {
                $('#success').hide();
            }, 6000);
        } else {
            $("#loading").hide();
            $('#error').show();
            $('#msgError').val("Se ha presentado un error al actualizar positivas, por favor contacte al administrador del sistema.");
            setInterval(function () {
                $('#error').hide();
            }, 6000);
        }
    }, 'json');
}