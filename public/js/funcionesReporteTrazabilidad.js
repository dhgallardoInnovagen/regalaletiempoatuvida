/*
 * Desarrollado por: Jamith Bolaños Vidal
 * 13 Mayo 2015
 * funciones en javascript para desarrollar funcionalidades sobre Login
 */

//var idIndicador = null;
$(document).ready(function () {
    var idIndicador = null; 
    var getIindicador = function (id) {
        return $.getJSON("indicador/getIndicadorPorId", {
            "idIndicador": id
        });
    };
    var grid = $("#grid-data").bootgrid({
        ajax: true,
        post: function ()
        {
            /* To accumulate custom parameter with the request object */
            return {
                id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
            };
        },
        url: "reporte_trazabilidad/getIndicadoresDiligenciados",
        selection: true,
        multiSelect: true,
        rowSelect: true,
        keepSelection: true,
        formatters: {
            "commands": function (column, row)
            {
                return '<button id="btnDesplegarTrazabilidad" onClick="actualizarDatosTrazabilidad(' + row.id_indicador + ')" type="button" class="btn btn-xs btn-default command-edit" data-row-id="' + row.id_indicador + ' "><span class="glyphicon glyphicon-ok"></span></button>';
            },
//            "consolidado": function (column, row)
//            {
//                if (row.consolidado_denominador != null) {
//
//                    return row.consolidado_numerador + '/' + row.consolidado_denominador + "<br> <b>(" + row.consolidado + ")</b>";
//                } else {
//                    return row.consolidado_numerador;
//                }
//
//            },
            "consolidado": function (column, row) {
                return formatoConsolidado(row.consolidado);
            },
            "sede_2": function (column, row) {
                return formatoConsolidado(row.sede_2);
            },
            "sede_3": function (column, row) {
                return formatoConsolidado(row.sede_3);
            },
            "sede_4": function (column, row) {
                return formatoConsolidado(row.sede_4);
            },
            "sede_5": function (column, row) {
                return formatoConsolidado(row.sede_5);
            },
            "sede_6": function (column, row) {
                return formatoConsolidado(row.sede_6);
            },
            "sede_7": function (column, row) {
                return formatoConsolidado(row.sede_7);
            },
            "sede_8": function (column, row) {
                return formatoConsolidado(row.sede_8);
            },
            "sede_9": function (column, row) {
                return formatoConsolidado(row.sede_9);
            },
            "sede_10": function (column, row) {
                return formatoConsolidado(row.sede_10);
            },
            "sede_11": function (column, row) {
                return formatoConsolidado(row.sede_11);
            },
            "sede_12": function (column, row) {
                return formatoConsolidado(row.sede_12);
            },
            "sede_13": function (column, row) {
                return formatoConsolidado(row.sede_13);
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
                            $('#nombreIndicador').val(response.data[0].nombre_indicador);
                            $('#interpreatacionIndicador').val(response.data[0].interpretacion);
                            $('#definicionOperacional').val(response.data[0].definicion_operacional);
                            $('#coeficienteIndicador').val(response.data[0].coeficiente);
                            $('#fuenteIndicador').val(response.data[0].fuente);
                            $('#metaIndicador').val(response.data[0].meta);
                        }
                    });
        });
    });
}).end();

function formatoConsolidado(campoRegistro) {
    if (campoRegistro) {
        var array = campoRegistro.split("=");
        if (array.length == 2) {
            return '<p align="center">' + array[0] + '<BR >' + '<b>(' + array[1] + ')</b></p>';
        }
        if (array.length == 1) {
            return '<p align="center"><b>' + array[0] + '</b></p>';
        }
    }
}
function abrirVentantaIndicadores() {
    $('#container').hide();
    $('#myModal').modal('show');    
}

function actualizarDatosTrazabilidad(id_indicador) {
    $('#myModal').modal('hide');
    $('#informacionTrazabilidad').show();
    $("#resultadoIndicador").bootgrid("destroy");
    $("#resultadoIndicador").bootgrid({
        post: function ()
        {
            return {
                idIndicador: id_indicador
            }
        },
        url: "reporte_resultado/getReporteResultadoPorId",
        templates: {
            search: ""
        },
        formatters: {
            "consolidado": function (column, row) {
                return formatoConsolidado(row.consolidado);
            },
            "sede_2": function (column, row) {
                return formatoConsolidado(row.sede_2);
            },
            "sede_3": function (column, row) {
                return formatoConsolidado(row.sede_3);
            },
            "sede_4": function (column, row) {
                return formatoConsolidado(row.sede_4);
            },
            "sede_5": function (column, row) {
                return formatoConsolidado(row.sede_5);
            },
            "sede_6": function (column, row) {
                return formatoConsolidado(row.sede_6);
            },
            "sede_7": function (column, row) {
                return formatoConsolidado(row.sede_7);
            },
            "sede_8": function (column, row) {
                return formatoConsolidado(row.sede_8);
            },
            "sede_9": function (column, row) {
                return formatoConsolidado(row.sede_9);
            },
            "sede_10": function (column, row) {
                return formatoConsolidado(row.sede_10);
            },
            "sede_11": function (column, row) {
                return formatoConsolidado(row.sede_11);
            },
            "sede_12": function (column, row) {
                return formatoConsolidado(row.sede_12);
            },
            "sede_13": function (column, row) {
                return formatoConsolidado(row.sede_13);
            },
        }
    }).on("loaded.rs.jquery.bootgrid", function ()//se activa cuando se carga un indicador  para observar en detalle
    {
        ocultarTodo(16);
        });
    $("#resultadoIndicador").bootgrid("reload");
}

function getResultado(row) {
    var opcElegida = $('#cmbSede').val();   
    var cadenaConsolidado;
    switch(opcElegida){
        case "4": cadenaConsolidado = row.sede_2;
            break;
        case "5": cadenaConsolidado = row.sede_3;
            break;
        case "6": cadenaConsolidado = row.sede_4;
            break;
        case "7": cadenaConsolidado = row.sede_5;
            break;
        case "8": cadenaConsolidado = row.sede_6;
            break;
        case "9": cadenaConsolidado = row.sede_7;
            break;
        case "10": cadenaConsolidado = row.sede_8;
            break;
        case "11": cadenaConsolidado = row.sede_9;
            break;
        case "12": cadenaConsolidado = row.sede_10;
            break;
        case "13": cadenaConsolidado = row.sede_11;
            break;
        case "14": cadenaConsolidado = row.sede_12;
            break;
        case "15": cadenaConsolidado = row.sede_13;
            break;
        break;
    default:
        cadenaConsolidado = row.consolidado;
    }
    
    if (cadenaConsolidado) {
        var array = cadenaConsolidado.split("=");
        if (array.length == 2) {
            return  array[1];
        }
        if (array.length == 1) {
            return array[0];
        }
    }
}
function graficarTrazabilidad() {
    $('#container').show();
    ocultarColumna();
    var rows = $('#resultadoIndicador').bootgrid('getCurrentRows');
    var datos = [];
    var metaAnual = [];
    var rangoFechas = [];
    var nombre_indicador;
    if (rows.length) {
        $.each(rows, function (index, row) {
            var cadenaValor = getResultado(row);
            var cadenaMetaAnual = row.meta;
            nombre_indicador = row.nombre_indicador;
            var fechaFinal = row.fecha_final;
            if (cadenaValor !== null  && cadenaValor !== 'NA') {
                datos.push(parseFloat(cadenaValor));
                metaAnual.push(parseFloat(cadenaMetaAnual));
                rangoFechas.push(fechaFinal);
            }
        });
    }
    $('#container').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: 'Trazabilidad del indicador - '+$('#cmbSede  option:selected').text()
        },
        subtitle: {
            text: nombre_indicador
        },
        xAxis: {
            type: 'datetime',
            categories: rangoFechas
        },
        yAxis: {
            title: {
                text: 'Valor observado'
            }
        },
        tooltip: {
            crosshairs: true,
            shared: true
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true
            }
        },
        series: [{
                name: "VALOR OBTENIDO",
                data: datos
            }
//        ,
//        {
//            name: 'META',
//            data: metaAnual
//        }
        ]
    });
}

function ocultarColumna() {
    var opcElegida = $('#cmbSede').val();   
    ocultarTodo(opcElegida); 
}

function ocultarTodo(filaNoOcultar) {
    datos = document.getElementById('resultadoIndicador');
    filas = datos.rows;
    for (var r = 0; r < filas.length; r++) {
        celdas = filas[r].cells;
        for (var i = 4; i <= 15; i++) {
            if (i != filaNoOcultar) {
                celdas[i].style.display = "none";
            } else {
                celdas[i].style.display = "";
            }
        }
    }

}

function imprimir() {
    print($('#informacionTrazabilidad'));
}
