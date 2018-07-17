/*
 * Desarrollado por: Jamith Bolaños Vidal
 * 30 Marzo 2016
 * funciones en javascript para desarrollar funcionalidades para exportar encuestas
 */
var fruitvegbasket = [];
$(document).ready(function () {

    //variables para peticion get ->Diego Gallardo 
    var fechatoma2 = 0;
    var municipio2 = 0;
    var ips2 = 0;



    $('#datosExportarEncuesta').validator().on('submit', function (e) {
        if (e.isDefaultPrevented()) {
            return false;
        } else {
            e.preventDefault();
            guardarCambios();
        }
    });
    $("#ipsInput").append(new Option("ESE Norte 1 - Buenos Aires", "4"));
    $('#municipioInput').change(function () {
        $("#ipsInput").empty();
        if ($(this).val() == "Buenos Aires") {
            $("#ipsInput").append(new Option("ESE Norte 1 - Buenos Aires", "4"));
        }
        if ($(this).val() == "Corinto") {
            $("#ipsInput").append(new Option("ESE Norte 2 - Corinto", "5"));
            $("#ipsInput").append(new Option("IPSI ACIN - Corinto", "6"));
        }
        if ($(this).val() == "El Tambo") {
            $("#ipsInput").append(new Option("ESE Hospital - El Tambo", "10"));
        }
        if ($(this).val() == "Florencia") {
            $("#ipsInput").append(new Option("ESE Suroccidente - Florencia", "19"));
        }
        if ($(this).val() == "Guachene") {
            $("#ipsInput").append(new Option("ESE Norte 2 - Guachené", "7"));
        }
        if ($(this).val() == "Páez") {
            $("#ipsInput").append(new Option("ESE Tierradentro - Páez", "15"));
            $("#ipsInput").append(new Option("IPSI Nasa Cxha Cxha", "16"));
        }
        if ($(this).val() == "Patía") {
            $("#ipsInput").append(new Option("ESE Hospital - El Bordo", "17"));
        }
        if ($(this).val() == "Piendamó") {
            $("#ipsInput").append(new Option("ESE Centro 1 - Piendamó", "12"));
            $("#ipsInput").append(new Option("IPSI Totoguampa", "13"));
        }
        if ($(this).val() == "Puerto Tejada") {
            $("#ipsInput").append(new Option("ESE Norte 3 - Puerto Tejadas", "8"));
        }
        if ($(this).val() == "San Sebastián") {
            $("#ipsInput").append(new Option("ESE Suroriente - San Sebastián", "18"));
        }
        if ($(this).val() == "Santander de Quilichao") {
            $("#ipsInput").append(new Option("FIG - Santander de Quilichao", "1"));
            $("#ipsInput").append(new Option("Quilisalud E.S.E", "2"));
            $("#ipsInput").append(new Option("IPSI ACIN - Santander de Quilichao", "3"));
        }
        if ($(this).val() == "Totoró") {
            $("#ipsInput").append(new Option("ESE Popayán - Totoró", "12"));
            $("#ipsInput").append(new Option("IPSI Totoguampa", "13"));
            $("#ipsInput").append(new Option("IPSI Namoi Wars", "14"));
        }


    });

    $('#fechaInicial').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('#fechaFinal').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $("#fechaInicialInput").on("dp.change", function (e) {
        $('#fechaFinal').data("DateTimePicker").minDate(e.date);
    });
//    $("#fechaFinalInput").on("dp.change", function (e) {
//        $('#fechaInicial').data("DateTimePicker").maxDate(e.date);
//    });
//    $('#fechaTomaInput').datetimepicker({
//        format: 'YYYY-MM-DD'
//    });
    $('#fechaReporteInput').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('#fechaEnvioInput').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('#fechaNacimientoInput').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    var getSedes = function () {
        return $.getJSON("exportar_encuesta/getMunicipios");
    };

    getSedes()
            .done(function (response) {
                if (response.success) {
                    for (var i = 0; i < response.sedes.length; i++) {
                        $("#municipioInput").append(new Option(response.sedes[i].nombre_municipio));
                    }
                }
            });
    var getSedes = function () {
        return $.getJSON("exportar_encuesta/getIps");
    };

    /* getSedes()
     .done(function (response) {
     if (response.success) {
     for (var i = 0; i < response.sedes.length; i++) {
     $("#ipsInput").append(new Option(response.sedes[i].nombre_ips, response.sedes[i].id_ips));
     }
     }
     });
     var getSedes = function () {
     return $.getJSON("exportar_encuesta/getEps");
     };*/

    getSedes()
            .done(function (response) {
                if (response.success) {
                    for (var i = 0; i < response.sedes.length; i++) {
                        $("#epsInput").append(new Option(response.sedes[i].nombre_eps, response.sedes[i].id_eps));
                    }
                }
            });

}).end();



function funcionEnviarEncuesta() {//inico Funcion

    var fechaI = $('#fechaInicialInput').val();
    var fechaF = $('#fechaFinalInput').val();
    var cedulasIncluir = -999;
    if ($('#cedulasIncluir').val() != '') {
        cedulasIncluir = $('#cedulasIncluir').val();
    }
    var cedulasExcluir = -999;
    if ($('#cedulasExcluir').val() != '') {
        cedulasExcluir = $('#cedulasExcluir').val();
    }
    var cedulasExcluirBoton = -999;
    if ($('#cedulasExcluirBoton').val() != '') {
        cedulasExcluirBoton = $('#cedulasExcluirBoton').val();
    }
    //Se verifica que el valor del campo este vacio
    if (fechaI == '' || fechaF == '') {
        alert('No se ha Ingresado la fecha.');
    } else {//inicio else 

        fechatoma2 = $('#fechaInicialInput').val();
        municipio2 = $('#municipioInput').val();
        ips2 = $('#ipsInput').val();


        $("#grid-data").bootgrid("destroy");
        var grid = $("#grid-data").bootgrid({
            ajax: true,
            post: function ()
            {
                return {
                    fechaToma: $('#fechaInicialInput').val(),
                    municipio: $('#municipioInput').val(),
                    ips: $('#ipsInput').val()
                }
            },
            url: "listas_embalaje/getEncuestas",
            templates: {
                header: "<div id=\"{{ctx.id}}\" class=\"{{css.header}}\"><div class=\"row\"><div class=\"col-sm-12 actionBar\"><div class=\"btn-group\" role=\"group\"> <button onclick='funcionDescargarComprobantes()' class='btn btn-primary'><span><i class='fa fa-download' aria-hidden='true'></i>&nbsp;&nbsp;Comprobante resultados</span> </div>&nbsp;&nbsp&nbsp;&nbsp<div class=\"btn-group\" role=\"group\"> <button onclick='funcionDescargar()' class='btn btn-primary'><span><i class='fa fa-download' aria-hidden='true'></i>&nbsp;&nbsp;Lista Embalaje</span> </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<p class=\"{{css.search}}\"></p><p class=\"{{css.actions}}\"></p></div></div></div>"
            },
            formatters: {
                "commands": function (column, row)
                {
                    return '<button id="btnDesplegarRegistroInd" onClick="abrirVentanaEditarExportarEncuestas(' + row.id_epidemiologica + ')" type="button" class="btn btn-xs btn-default command-edit" data-row-id="' + row.id_epidemiologia + ' "><span class="glyphicon glyphicon-pencil"></span></button>';
                },
                "command": function (column, row)
                {
                    return '<input id="' + row.id_toma + '" onClick="abrirVentanaEliminarExportarEncuestas(' + row.id_epidemiologica + ',\'' + row.id_toma + '\')" type="checkbox" data-row-id="' + row.id_epidemiologia + ' "></input>';
                },
                "formatoIps": function (column, row) {
                    if (row.coherenciaIpsMunicipio === true) {
                        return '<span class="label label-success">' + row.ips + '</span>';
                    } else {
                        return '<span class="label label-danger">' + row.ips + '</span>';
                    }
                },
                "fechaToma": function (column, row) {

                    var hoy = new Date().toJSON().slice(0, 10);
                    var fechaIni = '2015-01-01';
                    if (row.fecha_toma < fechaIni || row.fecha_toma > hoy) {
                        return '<span class="label label-danger">' + row.fecha_toma + '</span>';
                    } else {
                        return '<span class="label label-success">' + row.fecha_toma + '</span>';
                    }
                },
                "fechaNacimiento": function (column, row) {
                    fecha = new Date(row.fecha_nacimiento);
                    hoy = new Date(row.fecha_toma);
                    edad = parseInt((hoy - fecha) / 365 / 24 / 60 / 60 / 1000)

                    if (edad < 25 || edad > 65) {
                        return '<span class="label label-danger">' + row.fecha_nacimiento + '</span>';
                    } else {
                        return '<span class="label label-success">' + row.fecha_nacimiento + '</span>';
                    }
                }

            },

        });
        $('#modalExportarEncuesta').show();

    }//Fin Else


}//Fin funcion


//Hola 
function abrirVentanaEditarExportarEncuestas(id_epidemiologica) {

    url = 'listas_embalaje/editarExportarEncuesta';
    $('#myModal').modal('show');
    var getEpidemiologica = function (id_epidemiologica) {
        return $.getJSON("exportar_encuesta/getExportarEncuestasPorId", {
            "idEpidemiologica": id_epidemiologica
        });
    }
    getEpidemiologica(id_epidemiologica)
            .done(function (response) {

                //done() es ejecutada cuándo se recibe la respuesta del servidor. response es el objeto JSON recibido
                if (response.success) {
                    $('#cedulaUsuaria').val(response.data[0].numero_documento);
                    $('#fechaTomaInput').val(response.data[0].fecha_toma);
                    $('#fechaReporteInput').val(response.data[0].fecha_reporte);
                    $('#fechaEnvioInput').val(response.data[0].fecha_envio);
                    $('#primerNombreInput').val(response.data[0].primer_nombre);
                    $('#segundoNombreInput').val(response.data[0].segundo_nombre);
                    $('#primerApellidoInput').val(response.data[0].primer_apellido);
                    $('#segundoApellidoInput').val(response.data[0].segundo_apellido);
                    $('#fechaNacimientoInput').val(response.data[0].fecha_nacimiento);
                    $('#telefonoCelularInput').val(response.data[0].celular);
                    $('#telefonoFijoInput').val(response.data[0].telefono);
                    $('#municipioInput').val(response.data[0].municipio);
                    $('#ipsInput').val(response.data[0].id_ips);
                    $('#epsInput').val(response.data[0].id_eps);
                    $('#id_epidemiologica').val(response.data[0].id_epidemiologica);
                    $('#faseInput').val(response.data[0].fasecon);
                    $('#id_toma').val(response.data[0].id_toma);
                } else {
                    alert('Error en la consulta');
                }
            });
}
function guardarCambios() {
    $.post('listas_embalaje/getGuardarDatos', {
        id_toma: $('#id_toma').val(),
        id_epidemiologica: $('#id_epidemiologica').val(),
        numero_documento: $('#cedulaUsuaria').val(),
        fechaToma: $('#fechaTomaInput').val(),
        fecha_envio: $('#fechaEnvioInput').val(),
        fecha_reporte: $('#fechaReporteInput').val(),
        primer_nombre: $('#primerNombreInput').val(),
        segundo_nombre: $('#segundoNombreInput').val(),
        primer_apellido: $('#primerApellidoInput').val(),
        segundo_apellido: $('#segundoApellidoInput').val(),
        fecha_nacimiento: $('#fechaNacimientoInput').val(),
        celular: $('#telefonoCelularInput').val(),
        telefono: $('#telefonoFijoInput').val(),
        municipio: $('#municipioInput').val(),
        ips: $("#ipsInput option:selected").text(),
        eps: $("#epsInput option:selected").text(),
        fase: $("#faseInput option:selected").text(),
    }, function (result) {
        if (result.success) {
            $("#gryData").bootgrid('reload');
            $('#myModal').modal('hide');
            $('#successIndicador').show();
            $('#msgOkGestionarUsuario').val(result.msg);
        } else {
            alert(result.msg);
        }
    }, 'json');

    $('#myModal').modal('hide');
}

function abrirVentanaEliminarExportarEncuestas(idEpidemiologica, idToma) {

    if ($("#" + idToma).is(':checked')) {
        fruitvegbasket.push(idToma);
    } else {

        fruitvegbasket = $.grep(fruitvegbasket, function (value) {
            return value != idToma;
        });

    }
    $('#cedulasExcluirBoton').text(fruitvegbasket);

    id_epidemiologica = idEpidemiologica;
    id_toma = idToma;

}

//Fin hola 
function exportarEncuestas() {
    var cedulasIncluir = -999;
    if ($('#cedulasIncluir').val() != '') {
        cedulasIncluir = $('#cedulasIncluir').val();
    }
    var cedulasExcluir = -999;
    if ($('#cedulasExcluir').val() != '') {
        cedulasExcluir = $('#cedulasExcluir').val();
    }
    var cedulasExcluirBoton = -999;
    if ($('#cedulasExcluirBoton').val() != '') {
        cedulasExcluirBoton = $('#cedulasExcluirBoton').val();
    }
    location.href = 'listas_embalaje/exportarEncuestas'
            + '/' + $('#fase').val()
            + '/' + $('#fechaInicialInput').val()
            + '/' + $('#fechaFinalInput').val()
            + '/' + cedulasIncluir
            + '/' + cedulasExcluir
            + '/' + cedulasExcluirBoton;
}
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
function exportarRecomendaciones() {
    $.post('listas_embalaje/exportarRecomendaciones');
}


//realizado por Diego Gallardo 

function funcionDescargar() {
    var data = {nombre_ips: $("#ipsInput").text(), tipoArchivo: 'templatelistas', fechatoma: fechatoma2, municipio: municipio2, ips: ips2, current: 1,
        rowCount: -1}
    var url = "listas_embalaje/getDescargarlistas"
    $.post(url, data).done(function (data) {
        if (data) {
            var url1 = $('#base').val() + data;
            window.open(url1, "_blank");
        } else {
            alert('No existen datos para descargar');
        }
    });
}

function funcionDescargarComprobantes() {
    var data = {nombre_ips: $("#ipsInput").text(), tipoArchivo: 'templateresultados', fechatoma: fechatoma2, municipio: municipio2, ips: ips2, current: 1,
        rowCount: -1}
    var url = "listas_embalaje/getDescargarlistas"
    $.post(url, data).done(function (data) {
        if (data) {
            var url1 = $('#base').val() + data;
            window.open(url1, "_blank");
        } else {
            alert('No existen datos para descargar');
        }
    });
}