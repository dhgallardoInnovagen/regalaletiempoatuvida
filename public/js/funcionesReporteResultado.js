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
    }

    $("#resultadoIndicador").bootgrid({
        /* static POST (be aware of the reserved properties (e.g. sort)) */
        post: {
            idIndicador: idIndicador
        },
        url: "indicador/getRegistroIndicador"
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
        url: "reporte_resultado/getReporteResultado",
        selection: true,
        multiSelect: true,
        templates: {
            header: "<div id=\"{{ctx.id}}\" class=\"{{css.header}}\"><div class=\"row\"><div class=\"col-sm-12 actionBar\"><div class=\"btn-group\" role=\"group\"><button type=\"button\"  class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" onClick=\"location.href='reporte_resultado/exportarReporteResultado'\" aria-haspopup=\"true\" aria-expanded=\"false\"><span class=\"glyphicon glyphicon-download-alt\" aria-hidden=\"true\"> Descargar</span></button></div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<p class=\"{{css.search}}\"></p><p class=\"{{css.actions}}\"></p></div></div></div>"
        },
        formatters: {
            "semaforo": function (column, row) {
                var porcentaje = null;
                var resultado = null;
                var colorSemaforo;
                if (row.consolidado) {
                    var array = row.consolidado.split("=");
                    if (array.length === 2) {
                        resultado = array[1];
                    }
                    if (array.length === 1) {
                        resultado = array[0];
                    }
                }
                if (row.tipo_meta === 'mayor' && row.meta !== 0 && resultado !== null) {
                    porcentaje = (resultado * 100) / row.meta;
                    if (resultado < row.limite_inferior) {
                        colorSemaforo = 'Inaceptable';
                    } else {
                        if (resultado > row.limite_superior) {
                            colorSemaforo = 'Óptima';
                        } else {
                            colorSemaforo = 'Aceptable';
                        }
                    }
                } else {
                    if (row.tipo_meta === 'menor' && resultado !== null) {
                        if (resultado < row.limite_inferior) {
                            colorSemaforo = 'Óptima';
                        } else {
                            if (resultado > row.limite_superior) {
                                colorSemaforo = 'Inaceptable';
                            } else {
                                colorSemaforo = 'Aceptable';
                            }

                        }
                    }
                }
                if (colorSemaforo !== null)
                    return '<b>' + colorSemaforo +'</b>';
            },
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
            "optima": function (column, row) {
                if (row.tipo_meta === 'mayor') {
                    return ' >' + row.limite_superior;
                } else {
                    return  row.limite_inferior+' <';
                }
            },
            "inaceptable": function (column, row) {
                if (row.tipo_meta === 'mayor') {
                    return   row.limite_inferior + ' <';
                } else {
                    return ' >' + row.limite_superior;
                }
            }
        }
    })
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
    return "<p align='center'><b>-</b></p>";
}

function actualizarDatosRegistroIndicador(id_indicador) {
    $("#resultadoIndicador").bootgrid("destroy");
    $("#resultadoIndicador").bootgrid({
        post: function ()
        {
            return {
                id_Indicador: id_indicador
            }
        },
        url: "indicador/getRegistroIndicador",
        templates: {
            search: "false"
        },
        formatters: {
            "formatResultado": function (column, row)
            {
                if (row.resultado) {
                    var valor = parseFloat(row.resultado);
                    row.resultado = valor.toFixed(2);
                    return valor.toFixed(2);
                } else {
                    row.resultado = row.numerador;
                    return row.numerador;
                }

            }

        }
    });
//    
// $("#resultadoIndicador").load('indicador/getRegistroIndicador', {id_Indicador: id_indicador});  
}

function graficarTrazabilidad() {
    $('#container').show();
    var rows = $('#resultadoIndicador').bootgrid('getCurrentRows');
    var datos = [];
    var metaAnual = [];
    var rangoFechas = [];
    if (rows.length) {
        $.each(rows, function (index, row) {
            var cadenaValor = row.resultado;
            var cadenaMetaAnual = row.meta;
            var fechaInicial = row.fecha_inicial
            if (cadenaValor !== null && cadenaMetaAnual !== null) {
                datos.push(parseFloat(cadenaValor));
                metaAnual.push(parseFloat(cadenaMetaAnual));
                rangoFechas.push(fechaInicial);
            }
        });
    }
    $('#container').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: 'Gráfica de Trazabilidad'
        },
        subtitle: {
            text: 'Monitoreo de indicadores'
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
            },
            {
                name: 'META',
                data: metaAnual
            }
        ]
    });
}