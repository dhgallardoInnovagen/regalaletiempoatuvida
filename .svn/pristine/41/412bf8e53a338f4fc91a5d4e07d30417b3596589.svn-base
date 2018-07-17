/*
 * Desarrollado por: Jamith Bolaños Vidal
 * 13 Mayo 2015
 * funciones en javascript para desarrollar funcionalidades sobre Login
 */

//var idIndicador = null;
$(document).ready(function () {
    head =  "<div id=\"{{ctx.id}}\" class=\"{{css.header}}\"><div class=\"row\"><div class=\"col-sm-12 actionBar\">";
            if(rol == 1 || rol == 2){
            head = head +"<div class=\"btn-group\" role=\"group\">"
            +"<button type=\"button\"  class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" onClick=\"location.href='reporte_tamizacion/exportarRecomendacionesTamizadas'\" aria-haspopup=\"true\" aria-expanded=\"false\"><span class=\"glyphicon glyphicon-download-alt\" aria-hidden=\"true\"> Archivo Recomendaciones</span>"
            +"</button>"
            +"</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            }
            head = head +"<div class=\"btn-group\" role=\"group\">"
            +"<button type=\"button\"  class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" onClick=\"location.href='reporte_tamizacion/exportarReporteTamizacion'\" aria-haspopup=\"true\" aria-expanded=\"false\"><span class=\"glyphicon glyphicon-download-alt\" aria-hidden=\"true\"> Consolidado</span>"
            +"</button>"
            +"</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<p class=\"{{css.search}}\"></p><p class=\"{{css.actions}}\"></p></div></div></div>";
    
    
   var grid = $("#grid-data").bootgrid({
        ajax: true,
        post: function ()
        {
            /* To accumulate custom parameter with the request object */
            return {
                id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
            };
        },
        url: "reporte_tamizacion/getReporteTamizacion",
        selection: true,
        multiSelect: true,
        labels: {
            search: "Buscar"
        },
        templates: {
            header: head
        },
        formatters: {
            "commands": function(column, row)
            {
                return '<button id="btnDesplegarRegistroInd" onClick="abrirVentanaIngresarIndicador('+row.id_registro_indicador+')" type="button" class="btn btn-xs btn-default command-edit" data-row-id="' + row.id_registro_indicador + ' "><span class="glyphicon glyphicon-edit"></span></button>';
            },
            "resultado":function(column, row)
            {
                if(row.resultado !== null){
                    return (Math.floor((row.resultado) *100)/100);
                }
            },
            "indicadoresALlenar":function(column, row)
            {
                if(row.resultado == null){
                    return "<b>"+row.nombre_indicador+" </b><span class=\"label label-info\">Nuevo</span>";
                }else{
                    return row.nombre_indicador;
                }
            }
        }
    });
}).end()

function exportarReporteTamizacion(){
    $.post('reporte_tamizacion/exportarReporteTamizacion');
}