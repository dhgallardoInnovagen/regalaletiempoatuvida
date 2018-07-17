//var idIndicador = null;
$(document).ready(function () {

//fjdidf
//djfjdf
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

}).end()
function funcionEnviar(){
 var fechaI = $('#fechaInicialInput').val();
 var fechaF = $('#fechaFinalInput').val();
    //Se verifica que el valor del campo este vacio
    if (fechaI == '' || fechaF == '') {
      alert('No se ha Ingresado la fecha.');
    }else {
      $("#grid-data").bootgrid("destroy");
      $("#grid-data").bootgrid({
        post: function ()
        {
          return {
            fechaInicial: $('#fechaInicialInput').val(),
            fechaFinal: $('#fechaFinalInput').val()
          }
        },
        url: "reporte_4505/getReporte4505",
        templates: {
            header: "<div id=\"{{ctx.id}}\" class=\"{{css.header}}\"><div class=\"row\"><div class=\"col-sm-12 actionBar\"><div class=\"btn-group\" role=\"group\"><button type=\"button\"  class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" onClick=\"exportarArchivo()\" aria-haspopup=\"true\" aria-expanded=\"false\"><span class=\"glyphicon glyphicon-download-alt\" aria-hidden=\"true\"> Descargar</span></button></div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<p class=\"{{css.search}}\"></p><p class=\"{{css.actions}}\"></p></div></div></div>"
        }
      });
      $('#modalreporte4505').show();
    }
  }

  function exportarArchivo() {


      location.href  = 'reporte_4505/exportarReporte4505'
      + '/' +  $('#fechaInicialInput').val()
       + '/' + $('#fechaFinalInput').val();

  }

//$(document).ready(function(){
  // 
//}).end();
//function exportarReporteTamizacion(){
  //  $.post('reporte_tamizacion/exportarReporteTamizacion');
//}
