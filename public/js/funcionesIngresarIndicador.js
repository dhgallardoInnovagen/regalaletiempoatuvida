/*
 * Desarrollado por: Jamith Bolaños Vidal
 * 13 Mayo 2015
 * funciones en javascript para desarrollar funcionalidades sobre Login
 */

$(document).ready(function() {    
    //    data grid para manejar los indicadores de la pagina principal
    $('#numerador').keyup(function() {
        calcularValor();
    });

    $('#denominador').keyup(function() {
        calcularValor();
    });
    
    $('#datosIndicador').validator().on('submit', function (e) {
        if (e.isDefaultPrevented()) {
            return false;
        }
        else {
            e.preventDefault();
            guardarRegistroIndicador();
        }
    });
    
    $('#coeficienteIndicador').keyup(function() {
        calcularValor();
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
        url: "ingresar_indicador/getRegistroIndicador",
        selection: true,
        multiSelect: true,
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

function abrirVentanaIngresarIndicador(id_indicador){
    $('#myModal').modal('show'); 
    $('#numerador').val("");
    $('#denominador').val("");
    $('#resultado').val("");
    var getRegistroIndicador = function(id){         
        return $.getJSON( "ingresar_indicador/getRegistroIndicadorPorId", {
            "idRegistroIndicador" : id
        });
    }
    getRegistroIndicador(id_indicador)
    .done( function( response ) {
        var meta;
        //done() es ejecutada cuándo se recibe la respuesta del servidor. response es el objeto JSON recibido
        if( response.success ) {
            $('#idIndicador').val(response.rows[0].id_indicador);
            $('#idRegistroIndicador').val(response.rows[0].id_registro_indicador);
            $('#nombreIndicador').val(response.rows[0].nombre_indicador);
            $('#nombreMunicipio').val(response.rows[0].nombre_municipio);
            $('#definicionOperacional').val(response.rows[0].definicion_operacional);
            $('#coeficienteIndicador').val(response.rows[0].coeficiente);
            if(response.rows[0].tipo_meta == 'mayor'){
               meta = 'Inaceptable ['+response.rows[0].limite_inferior+'] < Aceptable > ['+response.rows[0].limite_superior+'] Óptima ';
            }else{
               meta = 'Óptima ['+response.rows[0].limite_inferior+'] < Aceptable > ['+response.rows[0].limite_superior+'] Inaceptable';
            }
            $('#metaIndicador').val(meta);
            $('#numerador').val(response.rows[0].numerador_r);
            $('#denominador').val(response.rows[0].denominador_r);
             $('#interpretacionIndicador').val(response.rows[0].interpretacion);
             $('#formaCalculo').val(response.rows[0].forma_calculo);
            calcularValor();
        }
    });
}

function calcularValor(){
    var numerador = parseFloat($('#numerador').val());
    var denominador = parseFloat($('#denominador').val());
    var coeficiente = parseFloat($('#coeficienteIndicador').val());
    if (!isNaN(numerador) && !isNaN(denominador) && denominador !== 0) {
        var resultado = (numerador / denominador)*coeficiente;
        $('#resultado').val(resultado);
    }else{
        $('#resultado').val("");
    }
}

function guardarRegistroIndicador(){
    if($('#resultado').val()!== "" && !isNaN($('#numerador').val()) && !isNaN($('#denominador').val())){
        $.post('ingresar_indicador/setRegistroIndicador', {
            idRegistroIndicador: $('#idRegistroIndicador').val(),
            numerador: $('#numerador').val(),
            denominador: $('#denominador').val(),
            coeficiente: $('#coeficienteIndicador').val()
        }, function(result) {
            if (result.success) {
                $("#grid-data").bootgrid('reload');
                $('#successIndicador').show();
                $('#msgOkIndicador').val(result.msg); 
                setInterval(function () {
                    $('#successIndicador').hide()
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
}