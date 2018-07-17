/*
 * Desarrollado por: Jamith Bolaños Vidal
 * 13 Mayo 2015
 * funciones en javascript para desarrollar funcionalidades sobre Login
 */

var url;
var inconsistencias;

$(document).ready(function () {

    $("#fmCargarArchivoCedulas").submit(function (e) {
        e.preventDefault();
        var fileSelect = document.getElementById('inputCedulas');
        var files = fileSelect.files;
        var formData = new FormData();
        var file = files[0];
        formData.append('inputCedulas', file, file.name);
        $.ajax({
            url: 'validar_encuesta/getCedulasConArchivo',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.success) {
                    validarErroresEncuestas(res.rows);
                } else {
                    $('#operacionFallida').show();
                    $('#fallo').text(res.msg);
                }
            },
            error: function (e) { // Si no ha podido conectar con el servidor 
                alert(e.toString());

            }
        });
    });

    var getSedes = function () {
        return $.getJSON("exportar_encuesta/getMunicipios");
    };

    getSedes()
        .done(function (response) {
            if (response.success) {
                console.log(response)
                for (var i = 0; i < response.sedes.length; i++) {
                    $("#municipioInput2").append(new Option(response.sedes[i].nombre_municipio, response.sedes[i].id_municipio));
                }
            }
        });

    $("#inputCedulas").fileinput({
        language: "es",
        uploadLabel: 'Validar',
        showCaption: true,
        showRemove: true,
        showUpload: true,
        allowedFileExtensions: ["txt"],
        maxFileSize: 20000
    })
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
    validarErroresEncuestas($('#cedulas').val());
}

function validarPorMunic() {


    fechacargue = $('#fechaInicialInput2').val();
    if(!fechacargue){
        alert('Por favor seleccione una fecha');
        return 0;
    }
   // municipio2 = $('#municipioInput2').val();
    $("#gridValidarEncuestas2").bootgrid('destroy');

    $("#gridValidarEncuestas").bootgrid('destroy');
    $("#gridValidarEncuestas2").bootgrid({
        /* static POST (be aware of the reserved properties (e.g. sort)) */
        navigation: 1,
        post: {
            fechacargue: fechacargue
        },
        labels: {
            infos: ""
        },
        ajax: true,
        responseHandler: function (rq) {
            $(".overflowP").css("overflow-x: visible;");
            $('#divValidarEncuestas2').show();
            inconsistencias = rq.rows;
            $('#msgInfo2').text(rq.msg);
            
            console.log(rq)
            return rq;
        },
        rowCount: -1,
        labels: {
            search: "Buscar por municipio"
        },
      
        formatters: {
            "formatCedulas": function (column, row) {
                if (row.no_ident) {
                    return '<span class="">' + row.no_ident + '</span>';
                } else if (row.cedula) {
                    return '<span class="">' + row.cedula + '</span>';
                }
                else{
                    return '<span class="label label-danger">NO</span>';
                }
            },
            "formatEpidemiologica": function (column, row) {
                if (row.no_ident) {
                    return '<span class="label label-success">SI</span>';
                } else {
                    return '<span class="label label-danger">NO</span>';
                }
            },
            "formatEstadoCuello": function (column, row) {
                if (row.cedula ) {
                    return '<span class="label label-success">SI</span>';
                } else {
                    return '<span class="label label-danger">NO</span>';
                }
            },
         
            "formatFechaCargueEpidemiologica": function (column, row) {
                if (row.fechaepidemiologica) {
                    return '<span class="label label-success">' + row.fechaepidemiologica + '</span>';
                } else {
                    return '<span class="label label-danger">NO</span>';
                }
            },
            "formatUsuarioCargueEpidemiologica": function (column, row) {
                if (row.usuarioepidemiologica) {
                    return '<span class="label label-success">' + row.usuarioepidemiologica + '</span>';
                } else {
                    return '<span class="label label-danger">NO</span>';
                }
            },
            "formatFechaCargueCuello": function (column, row) {
                if (row.fechacuello) {
                    return '<span class="label label-success">' + row.fechacuello + '</span>';
                } else {
                    return '<span class="label label-danger">NO</span>';
                }
            },
            "formatUsuarioCargueCuello": function (column, row) {
                if (row.usuariocuello) {
                    return '<span class="label label-success">' + row.usuariocuello + '</span>';
                } else {
                    return '<span class="label label-danger">NO</span>';
                }
            },
            "formatMunicipio": function (column, row) {
                if (row.municipio) {
                    return '<span class="label label-success">' + row.municipio + '</span>';
                } else {
                    return '<span class="label label-danger">NO</span>';
                }
            },
            "formatFechaToma": function (column, row) {
                if (row.fechatoma) {
                    return '<span class="label label-success">' + row.fechatoma + '</span>';
                } else {
                    return '<span class="label label-danger">NO</span>';
                }
            },
            


        },
        url: "validar_encuesta/validarMunicfecha"
    });


}

function validarErroresEncuestas(cedulas) {
    $("#gridValidarEncuestas").bootgrid('destroy');
    $("#gridValidarEncuestas2").bootgrid('destroy');
    $("#gridValidarEncuestas").bootgrid({
        /* static POST (be aware of the reserved properties (e.g. sort)) */
        navigation: 0,
        post: {
            cedulas: cedulas
        },
        labels: {
            infos: ""
        },
        responseHandler: function (rq) {

            $('#divValidarEncuestas').show();
            inconsistencias = rq.rows;
            $('#msgInfo').text(rq.msg);
            return rq;
        },
        formatters: {
            "formatEpidemiologica": function (column, row) {
                if (row.encuesta_epidemiologica === 'SI') {
                    return '<span class="label label-success">SI</span>';
                } else {
                    return '<span class="label label-danger">NO</span>';
                }
            },
            "formatEstadoCuello": function (column, row) {
                if (row.encuesta_estado_cuello === 'SI') {
                    return '<span class="label label-success">SI</span>';
                } else {
                    return '<span class="label label-danger">NO</span>';
                }
            },
            "formatFechaNacimiento": function (column, row) {
                if (row.fechFechaNacimiento !== '') {
                    return "<span class='label label-success'>" + row.fechFechaNacimiento + " </span>";
                } else {
                    return '<span class="label label-danger">NO</span>';
                }
            },
            "formatFechaTomaCitologia": function (column, row) {
                if (row.fechFechaToma !== '') {
                    return '<span class="label label-success">' + row.fechFechaToma + '</span>';
                } else {
                    return '<span class="label label-danger">NO</span>';
                }
            },
            "formatFechaCargueEpidemiologica": function (column, row) {
                if (row.fechaCargue602) {
                    return '<span class="label label-success">' + row.fechaCargue602 + '</span>';
                } else {
                    return '<span class="label label-danger">NO</span>';
                }
            },
            "formatUsuarioCargueEpidemiologica": function (column, row) {
                if (row.usuarioCargue602) {
                    return '<span class="label label-success">' + row.usuarioCargue602 + '</span>';
                } else {
                    return '<span class="label label-danger">NO</span>';
                }
            },
            "formatFechaCargueCuello": function (column, row) {
                if (row.fechaCargue603) {
                    return '<span class="label label-success">' + row.fechaCargue603 + '</span>';
                } else {
                    return '<span class="label label-danger">NO</span>';
                }
            },
            "formatUsuarioCargueCuello": function (column, row) {
                if (row.usuarioCargue603) {
                    return '<span class="label label-success">' + row.usuarioCargue603 + '</span>';
                } else {
                    return '<span class="label label-danger">NO</span>';
                }
            },
            "formatMunicipio": function (column, row) {
                if (row.procedencia) {
                    return '<span class="label label-success">' + row.procedencia + '</span>';
                } else {
                    return '<span class="label label-danger">NO</span>';
                }
            },
            


        },
        url: "validar_encuesta/validarCedulas"
    });
}

function reportarInconsistencias() {
    $.post('validar_encuesta/reportarInconsistencias', {
        inconsitencias: inconsistencias
    }, function (result) {
        if (result.success) {
            $('#operacionExitosa').show();
            $('#exito').val(result.msg);
            setInterval(function () {
                $('#operacionExitosa').hide()
            }, 6000);
        } else {
            $('#operacionFallida').show();
            $('#fallo').val(result.msg);
            setInterval(function () {
                $('#operacionFallida').hide()
            }, 6000);
        }
        $('#modalNuevaVigencia').modal('hide');
    }, 'json');
}

function ocularGridInconsistencias() {
    $('#divValidarEncuestas').hide();
    $('#divValidarEncuestas2').hide();
} //dps mapa social