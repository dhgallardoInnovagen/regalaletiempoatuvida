/*
 * Desarrollado por: Jamith Bolaños Vidal
 * 13 Mayo 2015
 * funciones en javascript para desarrollar funcionalidades sobre Login
 */
$(document).ready(function () {
    $("#inputData").fileinput({
        language: "es",
        maxFileSize: 20000,
        allowedFileExtensions: ["pdf"]
    });

    $('#numCampania').keyup(function (e) {
        if ($.isNumeric($('#numCampania').val())) {
            $('#btnDescargarCampania').attr('disabled', false);
        } else {
            $('#btnDescargarCampania').attr('disabled', true);
        }
    });
    $("#fDescargarCampania").submit(function (e) {
        e.preventDefault();
    });
    $('#numCampania').change(function (e) {
        if ($.isNumeric($('#numCampania').val())) {
            $('#btnDescargarCampania').attr('disabled', false);
        } else {
            $('#btnDescargarCampania').attr('disabled', true);
        }
    });
    $("#fDescargarCampania").submit(function (e) {
        e.preventDefault();
    });



    head = "<div id=\"{{ctx.id}}\" class=\"{{css.header}}\"><div class=\"row\"><div class=\"col-sm-12 actionBar\">";
    if (rol == 1 || rol == 2) {
        head = head + "<div class=\"btn-group\" role=\"group\">"
                + "<button type=\"button\"  class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" onClick=\"abrirVentanaEmergenteResultadosPDF()\" aria-haspopup=\"true\" aria-expanded=\"false\"><span class=\"glyphicon glyphicon-download-alt\" aria-hidden=\"true\"> Descargar campaña</span>"
                + "</button>"
                + "</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    }
    head = head + "<div class=\"btn-group\" role=\"group\">"
            + "</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<p class=\"{{css.search}}\"></p><p class=\"{{css.actions}}\"></p></div></div></div>";

    $("#fmCargarResultados").submit(function (e) {
        e.preventDefault();
        $("#loading").show();
        $('#operacionFallida').hide();
        $('#operacionExitosa').hide();
        var datos = $('#fmCargarResultados').serializeArray();
        var fileSelect = document.getElementById('inputData');
        var files = fileSelect.files;
        var formData = new FormData();
        formData.append('inputData', files);
        $.ajax({
            url: 'resultados_pdf/cargarResultados',
            type: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (data) {
                $("#loading").hide(); // To Hide progress bar
                $('#operacionExitosa').hide();
                $('#operacionFallida').hide();
                $('#operacionInfo').hide();
                var res = jQuery.parseJSON(data);
                if (res.cargados === true) {
                    $('#operacionExitosa').show();
                    $('#exito').text(res.cargadosMsg);
                    $('#kv-success-2 ul').append(res.cargadosMsg);
                }
                if (res.noCargados === true) {
                    $('#operacionFallida').show();
                    $('#fallo').text(res.noCargadosMsg);
                    $('#kv-success-2 ul').append(res.noCargadosMsg);
                }
                if (res.yaCargados === true) {
                    $('#operacionInfo').show();
                    $('#info').text(res.yaCargadosMsg);
                    $('#kv-success-2 ul').append(res.yaCargadosMsg);
                }
                // $('#fmImportarDatos')[0].reset();
                $('#kv-success-2').fadeIn('slow');
            },
            error: function (e) { // Si no ha podido conectar con el servidor 
                alert(e.message);
            }
        });
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
        url: "resultados_pdf/getResultadosPDF",
        selection: true,
        multiSelect: true,
        templates: {
            header: head
        },
        formatters: {
            "commands": function (column, row)
            {
                return '<button id="btnDescargarResultado" onClick="descargarResultado(' + row.cod_mx + ')" type="button" class="btn btn-xs btn-default command-ok" data-row-id="' + row.cod_mx + ' "><span class="glyphicon glyphicon-download-alt"></span></button> \n\
                        <button id="btnDescargarResultado" onClick="verObservacion(' + row.cod_mx + ')" type="button" class="btn btn-xs btn-default command-ok" data-row-id="' + row.cod_mx + ' "><span class="glyphicon glyphicon-eye-open"></span></button>'
            }
        }
    });
});

function descargarResultado(cod_mx) {
    location.href = 'resultados_pdf/descargarPDF'
            + '/' + cod_mx;
}

function abrirVentanaEmergenteResultadosPDF() {
    //this.location.reload();
    $('#fDescargarCampania').form("clear");
    $("#modalDescargarCampania").modal('show');
}

function descargarCampania() {
    numCampania = $('#numCampania').val();
    if ($('#numCampania').val() !== '' && $.isNumeric($('#numCampania').val())) {
        $.post('resultados_pdf/validarCampania', {
            numeroCampania: numCampania
        }, function (result) {
            if (result.success) {
                $("#modalDescargarCampania").modal('hide');
                window.location.href = 'resultados_pdf/descargar_campania'
                        + '/' + numCampania;
            } else {
                $("#modalDescargarCampania").modal('hide');
                $('#cargueInfo').show();
                $('#msgCargue').val(result.msg);
                setInterval(function () {
                    $('#cargueInfo').hide();
                }, 12000);
            }
        }, 'json');
    } else {
        alert('El número de campaña debe ser un número o no debe estar vacío');
    }
}

function verObservacion(cod_mx){
     $("#modalObservacion").modal('show');
      $.post('resultados_pdf/getObservacion', {
            cod_mx: cod_mx
        }, function (result) {
            if(result.obs !== null){
                $('#msgInfo').val(result.obs);
            }else{
                $('#msgInfo').val("No existen observaciones para la campaña");
            }             
        }, 'json');
}