/*
 * Desarrollado por: Jamith Bolaños Vidal
 * 13 Mayo 2015
 * funciones en javascript para desarrollar funcionalidades sobre Login
 */

/*$(document).ready(function() {
    $('#fmLogin').form('clear');
    $('#password').keypress(function(event) {
        if(event.keyCode == 13){
            login();
        }
    });
     $('#usuario').keypress(function(event) {
        if(event.keyCode == 13){
            login();
        }
    });
});*/

function login() { 
    if ($('#inputUsuario').val() != '' && $('#inputPassword').val() != ''){
        $('#fmLogin').submit(function(e){
            e.preventDefault();
            var datos = $('#fmLogin').serializeArray();
            $.ajax({
                url: 'login/login1',
                type: 'POST',
                data: datos,
                success: function(data) {
                    var res = jQuery.parseJSON(data);                  
                    if (res.success == 1) {                      
                        location.href = res.url;
                    }
                    else {                 
                        $('#inputUsuario').val('');
                        $('#inputPassword').val('');
                        $('#inputUsuario').focus();
                        $('#errorLogin').show();
                        $('span').html(res.msg);                    
//                        $.messager.show({
//                            title: res.title,
//                            msg: res.msg,
//                            timeout: 3000,
//                            showType: 'slide'
//                        });
                    }
                },
                error: function(e) { // Si no ha podido conectar con el servidor 
                // Código en caso de fracaso en el envío
                }
            });  
        });      
    }
}