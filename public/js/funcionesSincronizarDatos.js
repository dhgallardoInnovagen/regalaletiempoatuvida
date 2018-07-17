/*
 * Desarrollado por: Jamith Bolaños Vidal
 * 13 Mayo 2015
 * funciones en javascript para desarrollar funcionalidades sobre Login
 */


$(document).ready(function () {

    $('#datosInconsistencia').validator().on('submit', function (e) {
        if (e.isDefaultPrevented()) {
            return false;
        } else {
            e.preventDefault();
            guardarCambios();
        }
    });


    var falta_epidemiologica = 1;
    var falta_estado_cuello = 2;
    var sin_encuestas = 3;
    var sin_fecha_nacimiento = 4;
    var sin_fecha_toma = 5;
    var url = '';
    var id_inconsistencia = null;

    $('#fechaEncuesta').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    $('#fechaTomaSolInconsistencia').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    $('#fechaNacimientoSolInconsistencia').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    $('#categoriaInconsistencia').change(function () {
        if ($(this).val() === falta_epidemiologica) {
            $('#epidemiologica').val('f');
            $('#fechaNacimiento').val('f');
            $('#estadoCuello').val('t');
            $('#fechaToma').val('t');
        } else {
            if ($(this).val() === falta_estado_cuello) {
                $('#epidemiologica').val('t');
                $('#fechaNacimiento').val('t');
                $('#estadoCuello').val('f');
                $('#fechaToma').val('f');
            } else {
                if ($(this).val() === sin_encuestas) {
                    $('#epidemiologica').val('f');
                    $('#fechaNacimiento').val('f');
                    $('#estadoCuello').val('f');
                    $('#fechaToma').val('f');
                } else {
                    if ($(this).val() === sin_fecha_nacimiento) {
                        $('#epidemiologica').val('t');
                        $('#fechaNacimiento').val('f');
                        $('#estadoCuello').val('t');
                        $('#fechaToma').val('t');
                    } else {
                        $('#epidemiologica').val('t');
                        $('#fechaNacimiento').val('t');
                        $('#estadoCuello').val('t');
                        $('#fechaToma').val('f');
                    }
                }
            }
        }
    });

    var getSedes = function () {
        return $.getJSON("inconsistencia/getMunicipios");
    };

    getSedes()
            .done(function (response) {
                if (response.success) {
                    for (var i = 0; i < response.sedes.length; i++) {
                        $("#municipio").append(new Option(response.sedes[i].nombre_municipio, response.sedes[i].id_municipio));
                    }
                }
            });

    var getCategoriaInconsistencia = function () {
        return $.getJSON("inconsistencia/getCategoriaInconsistencia");
    };
    getCategoriaInconsistencia()
            .done(function (response) {
                if (response.success) {
                    for (var i = 0; i < response.categorias.length; i++) {
                        $("#categoriaInconsistencia").append(new Option(response.categorias[i].categoria, response.categorias[i].id_categoria));
                    }
                }
            });
    actualizarDataGridInconsistencia(false);

}).end();

function actualizarDataGridInconsistencia(verTodo) {
    var cadenaSi = '<span class="label label-success">SI</span>';
    var cadenaNo = '<span class="label label-danger">NO</span>';

    var getInconsistencia = function (id) {
        return $.getJSON("inconsistencia/getInconsistenciaPorId", {
            "idInconsistencia": id
        });
    };

    var grid = $("#gridInconsistencias").bootgrid({
        url: "sincronizar_datos/getDatosTamizadas",
        post: function ()
        {
            return {
                verTodo: verTodo
            };
        },
        templates: {
            header: "<div id=\"{{ctx.id}}\" class=\"{{css.header}}\"><div class=\"row\"><div class=\"col-sm-12 actionBar\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<button type=\"button\" class=\"btn btn-default\" onClick=\"VerTodasInconsistencias()\"><span class=\"glyphicon glyphicon-arrow-up\" aria-hidden=\"true\"></span>&nbsp;Sincronizar Pacific</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-default\" onClick=\"actualizarDatos()\"><span class=\"glyphicon glyphicon-refresh\" aria-hidden=\"true\"></span>&nbsp;Actualizar datos</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<p class=\"{{css.search}}\"></p><p class=\"{{css.actions}}\"></p></div></div></div>"
        },
        formatters: {
            "commands": function (column, row)
            {
                return '<button id="btnDesplegarRegistroInd" onClick="abrirVentanaSolucionarInconsistencia(' + row.numero_documento + ')" type="button" class="btn btn-xs btn-default command-ok" data-row-id="' + row.id_inconsistencia + ' "><span class="glyphicon glyphicon-ok"></span></button>' +
                        '<button id="btnDesplegarRegistroInd" onClick="abrirVentanaEditarInconsistencia(' + row.id_inconsistencia + ')" type="button" class="btn btn-xs btn-default command-edit" data-row-id="' + row.id_inconsistencia + ' "><span class="glyphicon glyphicon-pencil"></span></button>' +
                        '<button id="btnDesplegarRegistroInd" onClick="abrirVentanaEliminarInconsistencia(' + row.id_inconsistencia + ',\'' + row.numero_documento + '\')" type="button" class="btn btn-xs btn-default command-delete" data-row-id="' + row.id_inconsistencia + ' "><span class="glyphicon glyphicon-remove"></span></button>';
            },
            "formatEpidemiologica": function (column, row)
            {
                if (row.encuesta_epidemiologica === 't') {
                    return cadenaSi;
                } else {
                    return cadenaNo;
                }
            }, "formatNombreCompleto": function (column, row) {
                var nombre_completo = "";
                nombre_completo = row.prim_nombre;
                if(row.seg_nombre != null){
                    nombre_completo = nombre_completo +  " " + row.seg_nombre;
                }
                nombre_completo = nombre_completo +  " " + row.prim_apellido;
                if(row.seg_apellido != null){
                    nombre_completo = nombre_completo +  " " + row.seg_apellido;
                }
                return nombre_completo;
            }, "formatEstadoCuello": function (column, row)
            {
                if (row.encuesta_estado_cuello === 't') {
                    return cadenaSi;
                } else {
                    return cadenaNo;
                }
            },
            "formatFechaNacimiento": function (column, row)
            {
                if (row.fecha_nacimiento === 't') {
                    return cadenaSi;
                } else {
                    return cadenaNo;
                }
            },
            "formatFechaTomaCitologia": function (column, row)
            {
                if (row.fecha_toma_citologia === 't') {
                    return cadenaSi;
                } else {
                    return cadenaNo;
                }
            },
            "formatEstado": function (column, row)
            {
                if (row.sinc_pacific === null) {
                    return '<span class="label label-warning">Sin sincronizar</span>';
                } else {

                    if (row.sin_pacific === true) {
                        return '<span class="label label-success">Sincronizado</span>';
                    } else {

                    }
                }
            }
        }
    }).on("loaded.rs.jquery.bootgrid", function ()//se activa cuando se carga un indicador  para observar en detalle
    {
        grid.find(".command-edit").on("click", function (e)
        {
            idInconsistencia = $(this).data("row-id");
            getInconsistencia($(this).data("row-id"))
                    .done(function (response) {
                        if (response.success) {
                            $('#cedulaUsuaria').val(response.data[0].numero_documento);
                            $('#nombreUsuaria').val(response.data[0].nombre_usuaria);
                            $('#diligencia').val(response.data[0].diligencia);
                            $('#categoriaInconsistencia').val(response.data[0].id_categoria);
                            $('#fechaEncuestaInput').val(response.data[0].fecha_encuesta);
                            $('#municipio').val(response.data[0].id_municipio);
                            $('#epidemiologica').val(response.data[0].encuesta_epidemiologica);
                            $('#estadoCuello').val(response.data[0].encuesta_estado_cuello);
                            $('#fechaNacimiento').val(response.data[0].fecha_nacimiento);
                            $('#fechaToma').val(response.data[0].fecha_toma_citologia);
                            $('#observacion').val(response.data[0].observacion);
                            $('#id_inconsistencia').val(response.data[0].id_inconsistencia);
                        }
                    });
        });
        grid.find(".command-ok").on("click", function (e)
        {
            idInconsistencia = $(this).data("row-id");
            $('#idInconsistenciaInput').val(idInconsistencia);
        });
    });
}

function VerTodasInconsistencias() {
    $("#gridInconsistencias").bootgrid('destroy');
    actualizarDataGridInconsistencia(true);
}

function actualizarDatos() {
    $.post('sincronizar_datos/actualizarDatos', {
    }, function (result) {
        if (result.success) {
            $('#gridInconsistencias').bootgrid('reload');
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
        $('#modalSolucionarInconsistencia').modal('hide');
    }, 'json');
}

function abrirVentanaEditarInconsistencia() {
    url = 'inconsistencia/editarInconsistencia';
    $('#myModal').modal('show');
}

function abrirVentanaSolucionarInconsistencia(numeroDocumento) {
    $('#formSolucionarInconsistencia').form('clear');
    $('#modalSolucionarInconsistencia').modal('show');
    $.post('validar_encuesta/validarCedulas', {
        cedulas: numeroDocumento
    }, function (result) {
        if (result.success) {
            if (result.rows.length > 0) {
                if (result.rows[0].encuesta_epidemiologica == 'SI' && result.rows[0].encuesta_estado_cuello == 'SI') {
                    $('#msgSolucionarInconsistencia').hide();
                    $('#btnSolucionarInconsistencia').prop('disabled', false);
                    $('#cedulaInput').val(result.rows[0].numero_documento);
                    $('#fechaNacimientoInput').val(result.rows[0].fechFechaNacimiento);
                    $('#fechaTomaInput').val(result.rows[0].fechFechaToma);
                } else {
                    $('#btnSolucionarInconsistencia').prop('disabled', true);
                    $('#msgSolucionarInconsistencia').show();
                    $('#msgSolucionarInconsistencia').val('No es posible solucionar la inconsistencia, debido a que hace falta una o más encuestas');
                }
            }
        } else {
            $('#msgSolucionarInconsistencia').val('Ha ocurrido un error, por favor comuniquese con el administrador del sistema');
        }
    }, 'json');
}

function guardarCambios() {
    $.post(url, {
        id_inconsistencia: $('#id_inconsistencia').val(),
        numeroDocumento: $('#cedulaUsuaria').val(),
        nombreUsuaria: $('#nombreUsuaria').val(),
        id_categoria: $('#categoriaInconsistencia').val(),
        fechaEncuesta: $('#fechaEncuestaInput').val(),
        municipio: $("#municipio option:selected").text(),
        id_municipio: $('#municipio').val(),
        diligencia: $('#diligencia').val(),
        epidemiologica: $('#epidemiologica').val(),
        estadoCuello: $('#estadoCuello').val(),
        fechaNacimiento: $('#fechaNacimiento').val(),
        fechaToma: $('#fechaToma').val(),
        observacion: $('#observacion').val()
    }, function (result) {
        if (result.success) {
            $("#gridInconsistencias").bootgrid('reload');
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
    }, 'json');
    $('#myModal').modal('hide');
}

function abrirVentanaEliminarInconsistencia(idInconsistencias, numeroCedula) {
    $('#modalEliminarInconsistencia').modal('show');
    $('#msgEliminarIndicador').val('Está seguro que desea eliminar la inconsistencia correspondiente a la paciente con número de documento: ' + numeroCedula);
    id_inconsistencia = idInconsistencias;
    //alert('esta segudo que desea eliminar la inconsistencias de la paciente con cédula: '+numeroCedula);
}

function eliminarInconsistencia() {
    $.post('inconsistencia/eliminarInconsistencia', {
        idInconsistencia: id_inconsistencia
    }, function (result) {
        if (result.success) {
            $('#gridInconsistencias').bootgrid('reload');
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
        $('#modalEliminarInconsistencia').modal('hide');
    }, 'json');
}

function solucionarInconsistencia() {
    if ($('#fechaNacimientoInput').val() !== '' && $('#fechaTomaInput').val()) {
        $.post('inconsistencia/solucionarInconsistencia', {
            fechaNacimiento: $('#fechaNacimientoInput').val(),
            fechaToma: $('#fechaTomaInput').val(),
            numeroCedula: $('#cedulaInput').val(),
            idInconsistencia: $('#idInconsistenciaInput').val()
        }, function (result) {
            if (result.success) {
                $('#gridInconsistencias').bootgrid('reload');
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
            $('#modalSolucionarInconsistencia').modal('hide');
        }, 'json');
    }
}

function descargarInconsistencia() {
    $.post('inconsistencia/export_data', function () {
//            if (result.success) {
//                $('#gridInconsistencias').bootgrid('reload');
//                $('#successIndicador').show();
//                $('#msgOkIndicador').val(result.msg);
//                setInterval(function () {
//                    $('#successIndicador').hide();
//                }, 6000);
//            } else {
//                $('#errorIndicador').show();
//                $('#msgErrorIndicador').val(result.msg);
//                setInterval(function () {
//                    $('#errorIndicador').hide();
//                }, 6000);
//            }
        //$('#modalEliminarInconsistencia').modal('hide');
    });
}