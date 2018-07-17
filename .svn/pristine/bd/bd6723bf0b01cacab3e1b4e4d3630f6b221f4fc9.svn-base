/*
 * Desarrollado por: Jamith Bolaños Vidal
 * 30 Marzo 2016
 * funciones en javascript para desarrollar funcionalidades para exportar encuestas
 */
  var fruitvegbasket = [];
 $(document).ready(function () {

    $('#datosExportarEncuesta').validator().on('submit', function (e) {
        if (e.isDefaultPrevented()) {
            return false;
        }
        else {
            e.preventDefault();
            guardarCambios();
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
    $("#fechaFinalInput").on("dp.change", function (e) {
        $('#fechaInicial').data("DateTimePicker").maxDate(e.date);
    });
    $('#fechaTomaInput').datetimepicker({
        format: 'YYYY-MM-DD'
    });
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

    getSedes()
    .done(function (response) {
        if (response.success) {
            for (var i = 0; i < response.sedes.length; i++) {
                $("#ipsInput").append(new Option(response.sedes[i].nombre_ips,response.sedes[i].id_ips));
            }
        }
    });
    var getSedes = function () {
        return $.getJSON("exportar_encuesta/getEps");
    };

    getSedes()
    .done(function (response) {
        if (response.success) {
            for (var i = 0; i < response.sedes.length; i++) {
                $("#epsInput").append(new Option(response.sedes[i].nombre_eps,response.sedes[i].id_eps));
            }
        }
    });

}).end();



 function funcionEnviarEncuesta(){//inico Funcion

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
  }else {//inicio else 


    $("#grid-data").bootgrid("destroy");
    var grid = $("#grid-data").bootgrid({
        ajax: true,
        post: function ()
        {
          return {
            fechaInicial: $('#fechaInicialInput').val(),
            fechaFinal: $('#fechaFinalInput').val(),
            fase: $('#fase').val(),
            cedulasIncluir: cedulasIncluir,
            cedulasExcluir: cedulasExcluir,
            cedulasExcluirBoton : cedulasExcluirBoton
        }
    },
    url: "exportar_encuesta/getEncuestas",
    templates: {
        header: "<div id=\"{{ctx.id}}\" class=\"{{css.header}}\"><div class=\"row\"><div class=\"col-sm-12 actionBar\"><div class=\"btn-group\" role=\"group\"><button type=\"button\"  class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" onClick=\"exportarEncuestas()\" aria-haspopup=\"true\" aria-expanded=\"false\"><span><i class=\"fa fa-download \" aria-hidden=\"true\"></i>&nbsp;&nbsp;Descargar</span></button></div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<p class=\"{{css.search}}\"></p><p class=\"{{css.actions}}\"></p></div></div></div>"
    },
    formatters: {
        "commands": function(column, row)
        {
            return '<button id="btnDesplegarRegistroInd" onClick="abrirVentanaEditarExportarEncuestas(' + row.id_epidemiologica + ')" type="button" class="btn btn-xs btn-default command-edit" data-row-id="' + row.id_epidemiologia + ' "><span class="glyphicon glyphicon-pencil"></span></button>' ;
        },
        "command": function(column, row)
        {
            return '<input id="'+ row.id_toma +'" onClick="abrirVentanaEliminarExportarEncuestas(' + row.id_epidemiologica + ',\'' + row.id_toma + '\')" type="checkbox" data-row-id="' + row.id_epidemiologia + ' "></input>';
        },
        "formatoIps": function(column, row){
        if (row.coherenciaIpsMunicipio === true) {
                    return '<span class="label label-success">'+ row.ips +'</span>';
                } else {
                    return '<span class="label label-danger">'+ row.ips +'</span>';
                }
        },
        "fechaToma": function(column, row){
             var hoy = new Date().toJSON().slice(0,10);
             var fechaIni = '2015-01-01';
            if (row.fecha_toma < fechaIni || row.fecha_toma > hoy) {
                return '<span class="label label-danger">'+ row.fecha_toma +'</span>';
            }else{
                return '<span class="label label-success">'+ row.fecha_toma +'</span>';
            }
        },
        "fechaNacimiento": function(column, row){
            fecha = new Date(row.fecha_nacimiento);
            hoy = new Date(row.fecha_toma);
            edad = parseInt((hoy -fecha)/365/24/60/60/1000) 
        
            if (edad < 25 || edad > 65 ) {
                return '<span class="label label-danger">'+ row.fecha_nacimiento +'</span>';
            }else{
                return '<span class="label label-success">'+ row.fecha_nacimiento +'</span>';
            }
        }
        
    },

});
$('#modalExportarEncuesta').show();

  }//Fin Else


}//Fin funcion


//Hola 
function abrirVentanaEditarExportarEncuestas(id_epidemiologica) {

    url = 'exportarEncuestas/editarExportarEncuesta';
    $('#myModal').modal('show');
    var getEpidemiologica = function (id_epidemiologica) {
        return $.getJSON("exportar_encuesta/getExportarEncuestasPorId", {
            "idEpidemiologica": id_epidemiologica
        });
    }
    getEpidemiologica(id_epidemiologica)
    .done( function( response ) {

        //done() es ejecutada cuándo se recibe la respuesta del servidor. response es el objeto JSON recibido
        if( response.success ) {
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
    $.post('exportar_encuesta/getGuardarDatos', {
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
        ips: $("#ipsInput option:selected" ).text(),
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
    
if($("#"+ idToma).is(':checked')) {    
    fruitvegbasket.push(idToma);    
}else{   

    fruitvegbasket = $.grep(fruitvegbasket, function(value) {
      return value != idToma;
    });

}
 $('#cedulasExcluirBoton').text(fruitvegbasket);

 id_epidemiologica = idEpidemiologica;
 id_toma = idToma;

}

//Fin hola 
function exportarEncuestas(){  
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
    location.href = 'exportar_encuesta/exportarEncuestas'
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
function exportarRecomendaciones(){
    $.post('exportar_encuesta/exportarRecomendaciones');
} 