/*
 * Desarrollado por: Jamith Bolaños Vidal
 * 13 Mayo 2015
 * funciones en javascript para desarrollar funcionalidades sobre Login
 */

var url;


$(document).ready(function () {

    $('#datosIndicador').validator().on('submit', function (e) {
        if (e.isDefaultPrevented()) {
            return false;
        }
        else {
            e.preventDefault();
            guardarCambios();
        }
    });
    
    $('#formNuevaVigencia').validator().on('submit', function (e) {
        if (e.isDefaultPrevented()) {
            return false;
        }
        else {
            e.preventDefault();
            generarVigencia();
        }
    });

    $('#metaDeficiente').change(function () {
        if ($(this).val() == 'mayor') {
            $('#metaOptima').val('menor');
        } else {
            $('#metaOptima').val('mayor');
        }
    });

    $('#metaOptima').change(function () {
        if ($(this).val() == 'mayor') {
            $('#metaDeficiente').val('menor');
        } else {
            $('#metaDeficiente').val('mayor');
        }
    });

    $('#fechaInicial').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('#fechaFinal').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $("#fechaInicial").on("dp.change", function (e) {
        $('#fechaFinal').data("DateTimePicker").minDate(e.date);
    });
    $("#fechaFinal").on("dp.change", function (e) {
        $('#fechaInicial').data("DateTimePicker").maxDate(e.date);
    });
    var idIndicador = null;
    var getIindicador = function (id) {
        return $.getJSON("indicador/getIndicadorPorId", {
            "idIndicador": id
        });
    };

    var getTipoIndicador = function () {
        return $.getJSON("indicador/getClasificacionIndicador");
    };

    getTipoIndicador()
            .done(function (response) {
                if (response.success) {
                    for (var i = 0; i < response.clasificacionIndicador.length; i++) {
                        $("#clasificacionIndicador").append(new Option(response.clasificacionIndicador[i].clasificacion, response.clasificacionIndicador[i].id_clasificacion));
                    }
                }
            });

//    var getUnidadOperacional = function () {
//        return $.getJSON("indicador/getUnidadOperacional")
//    }
//
//    getUnidadOperacional()
//            .done(function (response) {
//                if (response.success) {
//                    for (var i = 0; i < response.unidad_operacional.length; i++) {
//                        $("#unidadOperacional").append(new Option(response.unidad_operacional[i].unidad_operacional, response.unidad_operacional[i].id_unidad_operacional));
//                    }
//                }
//            });

    var getUsuarios = function () {
        return $.getJSON("indicador/getUsuarios")
    }

    getUsuarios()
            .done(function (response) {
                if (response.success) {
                    for (var i = 0; i < response.responsables.length; i++) {
                        $("#responsable").append(new Option(response.responsables[i].nombre_usuario, response.responsables[i].id_usuario));
                    }
                }
            });

    $("#resultadoIndicador").bootgrid({
        /* static POST (be aware of the reserved properties (e.g. sort)) */
        post: {
            idIndicador: idIndicador
        },
        url: "indicador/getRegistroIndicador"
    });

    $("#tblIndicadoresNuevaVigencia").bootgrid({
        ajax: true,
        post: function ()
        {
            /* To accumulate custom parameter with the request object */
            return {
                id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
            };
        },
        labels: {
            search: "Buscar"
        },
        url: "indicador/getIndicadores",
        selection: true,
        multiSelect: true,
        keepSelection: true

    });
   
    var grid = $("#grid-data").bootgrid({
        ajax: true,
        post: function ()
        {
            /* To accumulate custom parameter with the request object */
            return {
                id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
            };
        },
        labels: {
            search: "Buscar"
        },
        templates: {
            header: "<div id=\"{{ctx.id}}\" class=\"{{css.header}}\"><div class=\"row\"><div class=\"col-sm-12 actionBar\"><button type=\"button\" class=\"btn btn-default\" onClick=\"abrirVentantaNuevoPeriodo()\"><span class=\"glyphicon glyphicon-check\" aria-hidden=\"true\"></span>&nbsp;Nuevo periodo</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-default\" onClick=\"abrirVentantaNuevoIndicador()\"><span class=\"glyphicon glyphicon-plus\" aria-hidden=\"true\"></span>&nbsp;Adicionar indicador</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<p class=\"{{css.search}}\"></p><p class=\"{{css.actions}}\"></p></div></div></div>"
        },
        url: "indicador/getIndicadores",
        selection: true,
        multiSelect: true,
        formatters: {
            "commands": function (column, row)
            {
                return '<button id="btnDesplegarRegistroInd" onClick="abrirVentanaEditarIndicador(' + row.id_indicador + ')" type="button" class="btn btn-xs btn-default command-edit" data-row-id="' + row.id_indicador + ' "><span class="glyphicon glyphicon-pencil"></span></button>' +
                        '<button id="btnDesplegarRegistroInd" onClick="abrirVentanaEliminarIndicador(' + row.id_indicador + ',\'' + row.nombre_indicador + '\')" type="button" class="btn btn-xs btn-default command-edit" data-row-id="' + row.id_indicador + ' "><span class="glyphicon glyphicon-remove"></span></button>';
            }
        }
    }).on("loaded.rs.jquery.bootgrid", function ()//se activa cuando se carga un indicador  para observar en detalle
    {
        /* Executes after data is loaded and rendered */
        grid.find(".command-edit").on("click", function (e)
        {
            // idIndicador = $(this).data("row-id");
            idIndicador = $(this).data("row-id");
            getIindicador($(this).data("row-id"))
                    .done(function (response) {
                        //done() es ejecutada cuándo se recibe la respuesta del servidor. response es el objeto JSON recibido
                        if (response.success) {
                            $('#idIndicador').val(response.data[0].id_indicador);
                            $('#nombreIndicador').val(response.data[0].nombre_indicador);
                            $('#formaCalculo').val(response.data[0].forma_calculo);
                            $('#definicionOperacional').val(response.data[0].definicion_operacional);
                            $('#coeficienteIndicador').val(response.data[0].coeficiente);
                            $('#fuenteIndicador').val(response.data[0].fuente);
                            $('#metaIndicador').val(response.data[0].meta);
                            $('#clasificacionIndicador').val(response.data[0].id_clasificacion);
//                            $('#unidadOperacional').val(response.data[0].id_unidad_operacional);
                            $('#responsable').val(response.data[0].id_usuario);
                            $('#cmbNumerador').val(response.data[0].condicion_numerador);
                            $('#cmbDenominador').val(response.data[0].condicion_denominador);
                            if (response.data[0].tipo_meta == 'mayor') {
                                $('#metaOptima').val('mayor');
                                $('#metaIndicadorOptima').val(response.data[0].limite_superior);
                                $('#metaDeficiente').val('menor');
                                $('#metaIndicadorDeficiente').val(response.data[0].limite_inferior);
                            } else {
                                $('#metaOptima').val('menor');
                                $('#metaIndicadorOptima').val(response.data[0].limite_inferior);
                                $('#metaDeficiente').val('mayor');
                                $('#metaIndicadorDeficiente').val(response.data[0].limite_superior);
                            }

                            if (response.data[0].mide_todos_municipios == 't') {
                                $("#aplicacion").val('Municipal');

                            } else {
                                $("#aplicacion").val('Departamental');
                            }
                            // $('#mideTodosMunicipios').val(response.data[0].mide_todos_municipios);
                        }
                    });

        });
    });
}).end();

function validar(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla.keyPress == 17 && tecla.keyPress == 86)
        return true;
    if (tecla == 8 || tecla == 0)
        return true;
    patron = /[0123456789.]/;
    te = String.fromCharCode(tecla);
    return patron.test(te);
}

function abrirVentanaEditarIndicador(id_indicador) {
    $('#myModal').modal('show');
    url = "indicador/editarIndicador";
    $("#resultadoIndicador").bootgrid("destroy");
    $("#resultadoIndicador").bootgrid({
        post: function ()
        {
            return {
                id_Indicador: id_indicador
            }
        },
        url: "indicador/getRegistroIndicador"
    });
}

function guardarCambios() {
    //var datos = $('#datosIndicador').serializeArray();
    $.post(url, {
        idIndicador: $('#idIndicador').val(),
        nombreIndicador: $('#nombreIndicador').val(),
        formaCalculo: $('#formaCalculo').val(),
        definicionOperacional: $('#definicionOperacional').val(),
        coeficienteIndicador: parseFloat($('#coeficienteIndicador').val()),
        fuenteIndicador: $('#fuenteIndicador').val(),
        metaIndicador: $('#metaIndicadorOptima').val(),
        clasificacionIndicador: $('#clasificacionIndicador').val(),
//        unidadOperacional: $('#unidadOperacional').val(),
        idUsuario: $("#responsable").val(),
        mideTodosMunicipios: $("#aplicacion").val(),
        condicionNumerador: $("#cmbNumerador").val(),
        condicionDenominador: $("#cmbDenominador").val(),
        tipoMeta: $("#metaOptima").val(),
        limiteInferior: (parseFloat($('#metaIndicadorOptima').val()) < parseFloat($('#metaIndicadorDeficiente').val())) ? parseFloat($('#metaIndicadorOptima').val()) : parseFloat($('#metaIndicadorDeficiente').val()),
        limiteSuperior: (parseFloat($('#metaIndicadorOptima').val()) > parseFloat($('#metaIndicadorDeficiente').val())) ? parseFloat($('#metaIndicadorOptima').val()) : parseFloat($('#metaIndicadorDeficiente').val())

    }, function (result) {
        if (result.success) {
            $("#grid-data").bootgrid('reload');
            $('#successIndicador').show();
            $('#msgOkIndicador').val(result.msg);
            setInterval(function () {
                $('#successIndicador').hide();
            }, 6000);
        } else {
            $('#errorIndicador').show();
            $('#msgErrorIndicador').val(result.msg);
            setInterval(function () {
                $('#errorIndicador').hide()
            }, 6000);
        }
    }, 'json');
    $('#myModal').modal('hide');
}

/*
 *Se llama esta función cuando se desea crear un nuevo indicador
 **/
function abrirVentantaNuevoIndicador() {
    url = "indicador/nuevoIndicador";
    $("#cmbNumerador").val("vacio");
    $("#cmbDenominador").val("vacio");
    $('#myModal').modal('show');
    $('#datosIndicador').form("clear");
}

function abrirVentanaEliminarIndicador(id_indicador, row) {
    $('#modalEliminarIndicador').modal('show');
    $('#msgEliminarIndicador').val('Está seguro que desea eliminar el indicador: ' + row);
    idIndicador = id_indicador;
}

function eliminarIndicador() {
    $.post('indicador/eliminarIndicador', {
        idIndicador: idIndicador
    }, function (result) {
        if (result.success) {
            $('#grid-data').bootgrid('reload');
            $('#successIndicador').show();
            $('#msgOkIndicador').val(result.msg);
            setInterval(function () {
                $('#successIndicador').hide()
            }, 6000);
        } else {
            $('#errorIndicador').show();
            $('#msgErrorIndicador').val(result.msg);
            setInterval(function () {
                $('#errorIndicador').hide()
            }, 6000);
        }
        $('#modalEliminarIndicador').modal('hide');
    }, 'json');
}

function abrirVentantaNuevoPeriodo() {
    $('#formNuevaVigencia').form("clear");   
    $('#fechaInicial').val('');
    $('#fechaFinal').val('');
    $('#tblIndicadoresNuevaVigencia').bootgrid('reload');
    $('#modalNuevaVigencia').modal('show');
}

function generarVigencia() {
    var rowSeleccionados = $("#tblIndicadoresNuevaVigencia").bootgrid("getSelectedRows");
    if (rowSeleccionados.length > 0) {
        $.post('indicador/crearPeriodos', {
            idIndicadores: rowSeleccionados,
            fechaInicial: $('#fechaInicialInput').val(),
            fechaFinal: $('#fechaFinalInput').val()
        }, function (result) {
            if (result.success) {
                $('#successIndicador').show();
                $('#msgOkIndicador').val(result.msg);
                setInterval(function () {
                    $('#successIndicador').hide();
                }, 6000);
            } else {
                $('#errorIndicador').show();
                $('#msgErrorIndicador').val(result.msg);
                setInterval(function () {
                    $('#errorIndicador').hide();
                }, 6000);
            }
            $('#modalNuevaVigencia').modal('hide');
        }, 'json');
    }
}

function abrirDialogoCondicion() {
    $("#modalCondicion").modal("show");
}

function asignarCondicion() {
    $("#modalCondicion").modal("hide");
}