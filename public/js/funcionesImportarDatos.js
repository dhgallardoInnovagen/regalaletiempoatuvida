/*
 * Desarrollado por: Jamith Bolaños Vidal
 * 13 Mayo 2015
 * funciones en javascript para desarrollar funcionalidades sobre Login
 */
var CadenaOptionIPS = "";
var CadenaOptionEPS = "";
var arrayIPS = [];
var arrayEPS = [];
$(document).ready(function () {




    $("#inputData").fileinput({
        language: "es",
        maxFileSize: 20000,
        allowedFileExtensions: ["txt", "csv", "xls"]
    });

    var getIPS = function () {
        return $.getJSON("indicador/getIPS");
    };

    getIPS()
            .done(function (response) {
                if (response.success) {
                    for (var i = 0; i < response.ips.length; i++) {
                        CadenaOptionIPS = CadenaOptionIPS + "<option value=" + response.ips[i].id_ips + ">" + response.ips[i].nombre_ips + "</option>";
                    }
                }
            });

    var getEPS = function () {
        return $.getJSON("indicador/getEPS");
    };

    getEPS()
            .done(function (response) {
                if (response.success) {
                    for (var i = 0; i < response.eps.length; i++) {
                        CadenaOptionEPS = CadenaOptionEPS + "<option value=" + response.eps[i].id_eps + ">" + response.eps[i].nombre_eps + "</option>";
                    }
                }
            });


    $('#tipoArchivo option[value="encuestaEpidemiologica"]').attr("selected", "selected");
    $('#msgInfo').html('<h1>Información<small> Estructura de archivo plano</small></h1>'
            + '<p align="left">'
            + '<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>'
            + '&nbsp;&nbsp;El archivo plano debe estar en formato *.csv o *.txt<br>'
            + '<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>'
            + '&nbsp;&nbsp;El archivo plano debe contener un total de 83 columnas<br>'
            + '<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>'
            + '&nbsp;&nbsp;Verifique que en el contenido del archivo estén correctas las tíldes y eñes.<br>'
            + '<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>'
            + '&nbsp;&nbsp;La información debe estar separada por comas (,)<br>'
            + '<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>'
            + '&nbsp;&nbsp;El archivo plano debe contener las siguiente cabecera  en el orden que se presenta a continuación<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Date Submitted<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Fase del Proyecto<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Nombre de encuestador<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Fecha de reporte<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Primer nombre<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Segundo nombre<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Primer apellido<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Segundo apellido<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Número de documento<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Tipo id<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Genero<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Estado civil<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Fecha de nacimiento<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Teléfono<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Celular<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Departamento<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Municipio<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Zona<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Vereda/Direcicón<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Barrio<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Correo electrónico<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> IPS<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> EPS<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Visita por demanda inducida?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Pertenencia étnica<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Nivel educativo<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿A qué se dedica usted actualmente?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Estrato socioeconómico<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Descripción del servicio<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Cuándo fue la fecha de su última citología?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Cuál fue el resultado de la citología?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Si su citologìa fue anormal, ¿Cuál fue el resultado?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Qué tipo de procedimiento le realizarón?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Hace cuánto le realizaron el procedimiento (meses)?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Su médico le ha comunicado que alguna vez ha tenido infección por VPH?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Cuál ha sido la frecuencia con la que se ha tomado la citología?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Si usted no se ha realizado la citología periódicamente, ¿Cuál ha sido la razón para no hacerlo?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Tiene vida sexual activa?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Edad de la primera relación sexual (Años)?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Número de acompañantes sexuales hasta el momento?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Sabe usted si alguno de sus compañeros sexuales ha tenido (o tiene) relaciones con trabajadoras sexuales?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Qué método de planificación emplea usted actualmente?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Hace cuánto tiempo que emplea el método de planificación (meses)?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Ha presentado alguna enfermedad de transmisión sexual?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Cuál de las siguientes enfermedades de transmisión sexual ha presentado?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Si su respuesta es otro, indique cual:<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Sabe usted si alguno de sus compañeros sexuales ha tenido ETS?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Alguna de sus familiares ha sufrido de cáncer de cuello uterino?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Quienes?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Sabe en que consiste el exámen de citología / Papanicolaou?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Sabe para qué sirve la citología?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Sabe qué es el VPH?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Conoce sobre las pruebas de detección del VPH?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Cuál prueba se ha realizado?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Conoce sobre la vacuna contra el VPH?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Se ha aplicado la vacuna contra el VPH?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Cuál vacuna se ha aplicado?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Cuántas dosis se ha aplicado?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Con respecto la habito de fumar, usted:<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Si es / fue fumador, cuántos cigarrillos fuma, fumaba por día?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Si es / fue fumador ocasional, cuántos cigarrillos consume / consumía al mes?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Por cuántos años ha fumado, o fumo?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Cocina usted con leña?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Cuántas horas al día?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Hace cuántos años?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Consume alimentos ricos en vitamina C (verduras, hortalizas y frutas)?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Consume alimentos ricos en beta - carotenos (zanahoria, espinaca, acelga, tomate)?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Consume alimentos ricos en vitamina A (productos lácteos, huevos)?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Cuál es su peso (kg)?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Cuál es su talla (cm)?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Fecha de la toma?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Gravidez<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Partos<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Abortos<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Cesáreas<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Mortinatos<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Edad del primer embarazo?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Está usted embarazada actualmente?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Cuántos meses de embarazo tiene?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Fecha del último parto?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Edad de la primera menstruación?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Fecha de la última menstruación?<br>'
            + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Edad de la menopausia?<br>'
            + '</p>');
    $('#tipoArchivo').change(function () {
        switch ($(this).val()) {
            case 'encuestaEpidemiologica':
                $('#msgInfo').html('<h1>Información<small> Estructura de archivo plano</small></h1>'
                        + '<p align="left">'
                        + '<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>'
                        + '&nbsp;&nbsp;El archivo plano debe estar en formato *.csv o *.txt<br>'
                        + '<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>'
                        + '&nbsp;&nbsp;El archivo plano debe contener un total de 83 columnas<br>'
                        + '<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>'
                        + '&nbsp;&nbsp;Verifique que en el contenido del archivo estén correctas las tíldes y eñes.<br>'
                        + '<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>'
                        + '&nbsp;&nbsp;La información debe estar separada por comas (,)<br>'
                        + '<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>'
                        + '&nbsp;&nbsp;El archivo plano debe contener las siguiente cabecera  en el orden que se presenta a continuación<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Date Submitted<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Fase del Proyecto<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Nombre de encuestador<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Fecha de reporte<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Primer nombre<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Segundo nombre<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Primer apellido<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Segundo apellido<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Número de documento<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Tipo id<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Genero<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Estado civil<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Fecha de nacimiento<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Teléfono<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Celular<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Departamento<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Municipio<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Zona<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Vereda/Direcicón<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Barrio<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Correo electrónico<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> IPS<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> EPS<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Visita por demanda inducida?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Pertenencia étnica<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Nivel educativo<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿A qué se dedica usted actualmente?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Estrato socioeconómico<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Descripción del servicio<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Cuándo fue la fecha de su última citología?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Cuál fue el resultado de la citología?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Si su citologìa fue anormal, ¿Cuál fue el resultado?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Qué tipo de procedimiento le realizarón?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Hace cuánto le realizaron el procedimiento (meses)?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Su médico le ha comunicado que alguna vez ha tenido infección por VPH?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Cuál ha sido la frecuencia con la que se ha tomado la citología?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Si usted no se ha realizado la citología periódicamente, ¿Cuál ha sido la razón para no hacerlo?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Tiene vida sexual activa?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Edad de la primera relación sexual (Años)?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Número de acompañantes sexuales hasta el momento?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Sabe usted si alguno de sus compañeros sexuales ha tenido (o tiene) relaciones con trabajadoras sexuales?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Qué método de planificación emplea usted actualmente?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Hace cuánto tiempo que emplea el método de planificación (meses)?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Ha presentado alguna enfermedad de transmisión sexual?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Cuál de las siguientes enfermedades de transmisión sexual ha presentado?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Si su respuesta es otro, indique cual:<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Sabe usted si alguno de sus compañeros sexuales ha tenido ETS?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Alguna de sus familiares ha sufrido de cáncer de cuello uterino?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Quienes?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Sabe en que consiste el exámen de citología / Papanicolaou?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Sabe para qué sirve la citología?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Sabe qué es el VPH?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Conoce sobre las pruebas de detección del VPH?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Cuál prueba se ha realizado?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Conoce sobre la vacuna contra el VPH?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Se ha aplicado la vacuna contra el VPH?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Cuál vacuna se ha aplicado?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Cuántas dosis se ha aplicado?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Con respecto la habito de fumar, usted:<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Si es / fue fumador, cuántos cigarrillos fuma, fumaba por día?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Si es / fue fumador ocasional, cuántos cigarrillos consume / consumía al mes?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Por cuántos años ha fumado, o fumo?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Cocina usted con leña?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Cuántas horas al día?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Hace cuántos años?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Consume alimentos ricos en vitamina C (verduras, hortalizas y frutas)?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Consume alimentos ricos en beta - carotenos (zanahoria, espinaca, acelga, tomate)?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Consume alimentos ricos en vitamina A (productos lácteos, huevos)?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Cuál es su peso (kg)?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Cuál es su talla (cm)?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Fecha de la toma?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Gravidez<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Partos<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Abortos<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Cesáreas<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Mortinatos<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Edad del primer embarazo?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Está usted embarazada actualmente?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Cuántos meses de embarazo tiene?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Fecha del último parto?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Edad de la primera menstruación?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Fecha de la última menstruación?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Edad de la menopausia?<br>'
                        + '</p>');
                break;
            case 'tomaCitologia':
                $('#msgInfo').html('<h1>Información<small> Estructura de archivo plano</small></h1>'
                        + '<p align="left">'
                        + '<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>'
                        + '&nbsp;&nbsp;El archivo plano debe estar en formato *.csv o *.txt<br>'
                        + '<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>'
                        + '&nbsp;&nbsp;El archivo plano debe contener un total de 12 columnas<br>'
                        + '<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>'
                        + '&nbsp;&nbsp;Verifique que en el contenido del archivo estén correctas las tíldes y eñes.<br>'
                        + '<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>'
                        + '&nbsp;&nbsp;La información debe estar separada por comas (,)<br>'
                        + '<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>'
                        + '&nbsp;&nbsp;El archivo plano debe contener las siguiente cabecera  en el orden que se presenta a continuación<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Date Submitted<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Fase del Proyecto<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Municipio<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Número de cédula<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ¿Atiende por demanda inducida?<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Fecha de demanda inducida<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Al observar el cuello uterino, se encuentran los siguientes hallazgos:<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Si su respuesta anterior fue Otro, indique cual:<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Observaciones<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Responsable de la toma de la citología<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Nombre completo del responsable de la toma de la citología<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Fecha de la toma de la citología<br>'
                        + '</p>');
                break;
            case 'resultadoLaboratorio':
                $('#msgInfo').html('<h1>Información<small> Estructura de archivo plano</small></h1>'
                        + '<p align="left">'
                        + '<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>'
                        + '&nbsp;&nbsp;El archivo plano debe estar en formato *.csv o *.txt<br>'
                        + '<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>'
                        + '&nbsp;&nbsp;El archivo plano debe contener un total de 20 columnas<br>'
                        + '<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>'
                        + '&nbsp;&nbsp;Verifique que en el contenido del archivo estén correctas las tíldes y eñes.<br>'
                        + '<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>'
                        + '&nbsp;&nbsp;La información debe estar separada por comas (,)<br>'
                        + '<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>'
                        + '&nbsp;&nbsp;El archivo plano debe contener las siguiente cabecera  en el orden que se presenta a continuación<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Orden<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Cedula<br>'                        
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Plan de atencion<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Fecha de toma de muestra<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Municipio<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> IPS<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> EPS<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Calidad de la muestra<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Categorizacion general<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Microorganismos<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Hallazgos no neoplasticos<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Anormalidades en celulas escamosas<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Anormalidades en celulas glandulares<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> OBSERVACIONES<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Validez de la prueba<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> VPH Genotipo 16<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> VPH Genotipo 18<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> OTROS VPH Alto Riesgo<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Reactividad<br>'
                        + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> OBSERVACIONES<br>'
                        + '</p>');
                break;
        }
    });

    $("#fmImportarDatos").submit(function (e) {

        e.preventDefault();
        $("#loading").show();
        $('#operacionFallida').hide();
        $('#operacionExitosa').hide();
        var datos = $('#fmImportarDatos').serializeArray();
        var fileSelect = document.getElementById('inputData');
        var files = fileSelect.files;
        var formData = new FormData();
        var file = files[0];
        formData.append('inputData', file, file.name);
        formData.append('fase', $('#fase').val());
        formData.append('tipoArchivo', $('#tipoArchivo').val());
        $.ajax({
            url: 'indicador/importarDatos',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $("#loading").hide(); // To Hide progress bar
                var res = jQuery.parseJSON(data);
                if (res.success === true) {
                    $('#operacionExitosa').show();
                    $('#exito').text(res.msg);
                }
                else {
                    if (res.title === 'IPS no se encuentra parametrizada') {
                        $('#modalHomologador').modal('show');
                        $('#contenidoModal').html(cadenaHomologador(res.ips, res.eps));
                        //alert('hacent falta las ips: ' + res.ips + 'eps---' + res.eps);
                    } else {
                        $('#operacionFallida').show();
                        $('#fallo').text(res.msg);
                        $('#fmImportarDatos')[0].reset();
                    }
                }
                // $('#fmImportarDatos')[0].reset();
            },
            error: function (e) { // Si no ha podido conectar con el servidor 
                alert(e.message);
            }
        });
    });



});

function cadenaHomologador(ips, eps) {
    var cadena = "";
    posicion = 0;
    arrayIPS = ips;
    arrayEPS = eps;
    for (var i = 0; i < ips.length; i++) {
        cadena = cadena + "<div class=\"row\"><div class=\"col-lg-8\">" + ips[i] + "</div><div class=\"col-lg-4\"> <select class=\"form-control\" id=" + ips[i] + " placeholder=\".input-lg\">" + CadenaOptionIPS + "<select></div></div>";
    }

    cadena = cadena + "<br/>";
    for (var i = 0; i < eps.length; i++) {
        cadena = cadena + "<div class=\"row\"><div class=\"col-lg-8\">" + eps[i] + "</div><div class=\"col-lg-4\"> <select class=\"form-control\" id=" + eps[i] + " placeholder=\".input-lg\">" + CadenaOptionEPS + " <select></div></div>";
    }
    return cadena;
}

function homologarIPS_EPS() {
    var my_form = $('#formHomologador');
    var data = [];
    var cadena = "";
    var i = 0;
    $('select', my_form).each(
            function () {
                var val = $(this).val();
                data[i] = val;
                i++;
            }
    );
    var formData = new FormData();
    formData.append('arrayIPS', arrayIPS);
    formData.append('arrayEPS', arrayEPS);
    formData.append('data', data);
    $.ajax({
        url: 'indicador/setIPS_EPSHomologas',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            $("#loading").hide(); // To Hide progress bar
            var res = jQuery.parseJSON(data);
            if (res.success === true) {
                $('#modalHomologador').modal('hide');
                $('#operacionExitosa').show();
                $('#exito').text(res.msg);

            } else {
                $('#modalHomologador').modal('hide');
                $('#operacionFallida').show();
                $('#fallo').text(res.msg);
            }
        },
        error: function (e) { // Si no ha podido conectar con el servidor 
            alert(e.message);
        }
    });
}