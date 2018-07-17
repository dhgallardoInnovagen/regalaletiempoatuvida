Number.prototype.round = function(places) {
    return +(Math.round(this + "e+" + places) + "e-" + places);
}

//$.fn.datebox.defaults.formatter = function(date) {
//    var y = date.getFullYear();
//    var m = date.getMonth() + 1;
//    var d = date.getDate();
//    return y + '-' + (m < 10 ? ('0' + m) : m) + '-' + (d < 10 ? ('0' + d) : d);
//}

$.fn.combobox.defaults.filter = function(q,row){
      var opts = $(this).combobox('options');
      return row[opts.textField].toUpperCase().indexOf(q.toUpperCase()) >= 0;
};

$(document).ready(function() {

});

function leadZero(v) {
    return v < 10 ? '0' + v : v;
}

function calcularBrecha(rowP, valorP) {
    var valor = (valorP == null) ? valorP : parseFloat(valorP);
    var resultado = '';
    if (!isNaN(valor)) {

        var resultadoF = valor * rowP.FACTOR_DE_CALCULO;
        var ma = rowP.META_ANUAL.replace(",", ".");
        resultado = resultadoF - ma;
        var operador = rowP.SIMBOLO_OPERADOR;

        if (operador == '<') {
//            resultado += 1;
            if (resultado < 0) {
                resultado = 0;
            }
        } else if (operador == '<=' && resultado <= 0) {
            resultado = 0;
        } else if (operador == '>') {
//            resultado -= 1;
            if (resultado > 0) {
                resultado = 0;
            }
        } else if (operador == '>=' && resultado >= 0) {
            resultado = 0;
        }
        resultado = Math.abs(resultado.round(2));
    }
    return resultado;
}

function formato_fecha(date) {
    var _fecha = {ENE: '01', FEB: '02', MAR: '03', ABR: '04', MAY: '05', JUN: '06', JUL: '07', AGO: '08', SEP: '09', OCT: '10', NOV: '11', DIC: '12'}

    for (var i in _fecha)
        date = date.replace(i, _fecha[i]);

    return date;
}

function formato_decimal(valorP) {
    if (valorP) {
        if (valorP.substring(0, 1) == ',') {
            valorP = '0' + valorP;
        }
        valorP = valorP.replace(",", ".");
    }
    return valorP;
}

function rgbToHex(rgb) {
    rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    return "#" +
            ("0" + parseInt(rgb[1], 10).toString(16)).slice(-2) +
            ("0" + parseInt(rgb[2], 10).toString(16)).slice(-2) +
            ("0" + parseInt(rgb[3], 10).toString(16)).slice(-2);
}

function cerrarSesion() {
       
}