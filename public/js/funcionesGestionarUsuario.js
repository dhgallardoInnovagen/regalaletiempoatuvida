
$(document).ready(function() {
    $('#sumit').click(function(){
        if($("#correoInput").val().indexOf('@', 0) == -1 || $("#correoInput").val().indexOf('.', 0) == -1) {
            alert('El correo electrónico introducido no es correcto.');
            return false;
        }
    });
    // llamar la imgen del formulario//

      

   // Final de llamar el formulario 


    $('#idUsuarioInput').attr('disabled','-1');
    $('#form-edit-usuario').validator().on('submit', function (e) {
        if (e.isDefaultPrevented()) {
            return false;
        }
        else {
            e.preventDefault();
            guardar();
        }
    });
      $('#form-create-usuario').validator().on('submit', function (e) {
        if (e.isDefaultPrevented()) {
            return false;
        }
        else {
            e.preventDefault();
            guardarCambios();
        }
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
        url: "gestionar_usuario/getGestionarUsuarios",
        selection: true,
        multiSelect: true,
        labels: {
            search: "Buscar"
        },
         templates: {
        header: "<div id=\"{{ctx.id}}\" class=\"{{css.header}}\"><div class=\"row\"><div class=\"col-sm-12 actionBar\"><div class=\"btn-group\" role=\"group\"><button type=\"button\"  class=\"btn btn-primary dropdown-toggle\" data-toggle=\"dropdown\" onClick=\"abrirModelNuevoUsuario()\" aria-haspopup=\"true\" aria-expanded=\"false\"><span><i class=\"fa fa-user-plus \" aria-hidden=\"true\"></i>&nbsp;&nbsp; Nuevo&nbsp;Usuario</span></button></div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<p class=\"{{css.search}}\"></p><p class=\"{{css.actions}}\"></p></div></div></div>"
    },
      formatters: {
        "commands": function(column, row)
        {
            return '<button id="btnDesplegarRegistroInd" onClick="abrirModelEditarUsuario(' + row.id_usuario + ',\'' + row.nombre_rol + '\')" type="button" class="btn btn-xs btn-default command-edit" data-row-id="' + row.id_usuario + ',\'' + row.nombre_rol +' \' "><span class="glyphicon glyphicon-pencil"></span></button>' +
            '<button id="btnDesplegarRegistroInd" onClick="abrirModelEliminarUsuario(' + row.id_usuario + ',\'' + row.numero_documento + '\')" type="button" class="btn btn-xs btn-default command-delete" data-row-id="' + row.id_usuario + ' "><span class="glyphicon glyphicon-remove"></span></button>';
        }
    },  
       
    });
    
    var getUsers = function () {
        return $.getJSON("gestionar_usuario/getUser");
    };

    getUsers()
    .done(function (response) {
        if (response.success) {
            for (var i = 0; i < response.sedes.length; i++) {
                $("#idRol").append(new Option(response.sedes[i].nombre_rol, response.sedes[i].id_rol));
            }
        }
    });

var getIPS = function () {
        return $.getJSON("gestionar_usuario/getIps");
    };

    getIPS()
    .done(function (response) {
        if (response.success) {
            for (var i = 0; i < response.sedes.length; i++) {
                $("#ipsInputR").append(new Option(response.sedes[i].nombre_ips, response.sedes[i].id_ips));
            }
        }
    });

var getEPS = function () {
        return $.getJSON("gestionar_usuario/getEps");
    };

    getEPS()
    .done(function (response) {
        if (response.success) {
            for (var i = 0; i < response.sedes.length; i++) {
                $("#epsInputR").append(new Option(response.sedes[i].nombre_eps, response.sedes[i].id_eps));
            }
        }
    });
    
   /*Nuevo Usuario*/
   var getSedes = function () {
        return $.getJSON("gestionar_usuario/getUser");
    };

    getSedes()
    .done(function (response) {
        if (response.success) {
            for (var i = 0; i < response.sedes.length; i++) {
                $("#idUserInput").append(new Option(response.sedes[i].nombre_rol, response.sedes[i].id_rol));
            }
        }
    });

var getSedes = function () {
        return $.getJSON("gestionar_usuario/getIps");
    };

    getSedes()
    .done(function (response) {
        if (response.success) {
            for (var i = 0; i < response.sedes.length; i++) {
                $("#ipsInput").append(new Option(response.sedes[i].nombre_ips, response.sedes[i].id_ips));
            }
        }
    });

var getSedes = function () {
        return $.getJSON("gestionar_usuario/getEps");
    };

    getSedes()
    .done(function (response) {
        if (response.success) {
            for (var i = 0; i < response.sedes.length; i++) {
                $("#epsInput").append(new Option(response.sedes[i].nombre_eps, response.sedes[i].id_eps));
            }
        }
    });
    
  
    
    
    
    
    
});
    

function soloNumeros(e){
    var key = window.Event ? e.which : e.keyCode 
return ((key >= 48 && key <= 57) || (key==8)) 
}

   
   /*Final Usuario*/

function guardarCambios() {
    $.post('gestionar_usuario/crear', {
        id_usuario: $('#idUsuarioInput').val(),
        nombre: $('#nombreInputR').val(),
        apellido: $('#apellidoInputR').val(),
        identificacion: $('#identificacionInputR').val(),
        correo: $('#correoInputR').val(),
        telefono: $('#telefonoInputR').val(),
        sistema:$('#sistemaInputR').val(),
        usuario:$('#idUserInput').val(),
        idEps:$('#epsInputR').val(),
        user: $('#userInputR').val(),
        contrasena: $('#contraseñaInputR').val(),
        area_unidad: $('#areaInputE').val(),
        idIps: $('#ipsInputR').val()
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

       
}
function abrirModelNuevoUsuario(){


  $('#myModal').modal('show');
}

function abrirModelEditarUsuario(){

  $('#myModal').modal('show');
}
function abrirModelEliminarUsuario(idUsuario, numeroCedula){
 $('#modalEliminarUsuario').modal('show');
 $('#msgEliminarUsuarios').val('Está seguro que desea eliminar al usuario con número de documento: ' + numeroCedula);
 id_usuario = idUsuario;
 numero_documento = numeroCedula;
}
function eliminarUsuarios(numeroCedula) {
    $.post('gestionar_usuario/eliminarUsuarios', {
        idUsuario: id_usuario,
        numeroCedula:numero_documento

    },function (result) {
        if (result.success) {
            $("#grid-data").bootgrid('reload');
            setInterval(function () {

            }, 6000);
        } else {

            setInterval(function () {

            }, 6000);
        }
    },'json');
$('#myModal').modal('hide');
}
function abrirModelEditarUsuario(id_usuario) {
    var row = $("#grid-data").bootgrid("getCurrentRows");
    $('#myModalEditar').modal('show');
    var getUsuario = function (id_usuario) {
        return $.getJSON("gestionar_usuario/getUsuariosPorId", {
            "idUsuario": id_usuario
        });
    }
    getUsuario(id_usuario)
    .done( function( response ) {

        //done() es ejecutada cuándo se recibe la respuesta del servidor. response es el objeto JSON recibido
        if( response.success ) {
         $('#idUsuarioInput').val(response.data[0].id_usuario);
         $('#ipsInputR').val(response.data[0].id_ips);
         $('#epsInputR').val(response.data[0].id_eps);
         $('#nombreInput').val(response.data[0].nombres);
         $('#apellidoInput').val(response.data[0].apellidos);
         $('#userInput').val(response.data[0].nombre_usuario);
         $('#contraseñaInput').val(response.data[0].contrasenia);
         $('#telefonoInput').val(response.data[0].telefono);
         $('#correoInput').val(response.data[0].correo);
         $('#documentoInput').val(response.data[0].numero_documento);
         $('#idRol').val(response.data[0].id_rol);
         $('#areaInputR').val(response.data[0].area_unidad);
         //$('#idUserInputR').val('Administrador');
         $("#sistemaInput").val(response.data[0].sistema);

        // $("#fotoInput").val(response.data[0].foto_user);
        // console.log(response.data[0].nombre_rol);
         

     }
 });


}
function guardar() {
    $.post('gestionar_usuario/getGuardarDatos', {
        id_usuario: $('#idUsuarioInput').val(),
        id_ips: $('#ipsInputR').val(),
        id_eps: $('#epsInputR').val(),
        nombres: $('#nombreInput').val(),
        apellidos: $('#apellidoInput').val(),
        user: $('#userInput').val(),
        contrasena: $('#contraseñaInput').val(),
        telefono: $('#telefonoInput').val(),
        correo: $('#correoInput').val(),
        numero_documento: $('#documentoInput').val(),
        area: $('#areaInputR').val(),
        sistema: $('#sistemaInput').val(),
        foto: $('#fotoInput').val(),

    }, function (result) {
        if (result.success) {
            $("#grid-data").bootgrid('reload');
            setInterval(function () {
           
            }, 1000);
        } else {

            setInterval(function () {

            }, 1000);
        }
    }, 'json');
$('#myModalEditar').modal('hide');
}