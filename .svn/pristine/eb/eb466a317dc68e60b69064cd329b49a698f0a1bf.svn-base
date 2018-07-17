<link href="<?php echo base_url() ?>public/css/fileinput.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url() ?>public/js/funcionesConfiguracion.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/js/bootstrap-fileinput.js" ></script>
<script type="text/javascript">


</script>
<link href="<?php echo base_url() ?>public/css/saphv2.css" rel="stylesheet">
<div class="container">
    <h1 align="center">Mi Cuenta</h1>
    <div class="row">
        <form id="form-edit-usuario" name="form-edit-usuario"  role="form" enctype="multipart/form-data">
            <div class="col-sm-3 text-center"  style="">
                <img id="imagen2"  class="img-circle" src="configuracion/traerUsuarioFoto" >
                <div class="row">
                    <br/>
                    
                     <div  class="btn btn-primary btn-file">
                      <span><i class="fa fa-folder-open-o" aria-hidden="true"></i>&nbsp;&nbsp;Examinar...</span>
                        <input id="inputImagen" name="inputImagen" multiple="false" value="configuracion/traerUsuarioFoto" type="file" class="file-loading"   data-show-upload="true" data-show-preview="true">
                        <br/>
                     </div>
                    
                </div>
            </div>
            <div class="col-sm-3" >
                <div class="row">
                    <div class="form-group">
                        <div class="row" >
                            <br/>
                            <div class="col-md-4"><b><p name="nom" id="nom" >Nombres </p></b> </div>
                            <div class="col-md-12">
                                <input rows="1" type="text" class="form-control" name="nombres" id="nombreInput" placeholder="Nombres" value="" required />
                            </div>
                        </div>
                        <div class="row">
                            <br/>
                            <div class="col-md-4"><b><p name="nom" id="nom" >Documento </p></b> </div>
                            <div class="col-md-12">
                                <input type="text" id="documentoInput" class="form-control" name="numero_identificacion" placeholder="Numero Documento"   onKeyPress="return soloNumeros(event)" required />
                            </div>
                        </div>
                        <div class="row">
                            <br/>
                            <div class="col-md-4"><b><p name="nom" id="nom" >Correo</p></b> </div>
                            <div class="col-md-12">
                                <input type="text" id="correoInput" class="form-control" name="correo" placeholder="Correo"   required />
                            </div>
			</div>				
		    </div>	
		</div>	
	    </div>
			
	    <div class="col-sm-3" >
		<div class="row">
		    <br/>
		    <div class="col-md-4"><b><p name="nom" id="nom" >Apellido </p></b> </div>
		    <div class="col-md-12">
		    <input  type="text" id="apellidoInput" class="form-control" name="apellidos" placeholder="Apellidos"   required />
		    </div>
		</div>
		<div class="row">
		    <br/>
		    <div class="col-md-4"><b><p name="nom" id="nom" >Telefono</p></b> </div>
		    <div class="col-md-12">
		    <input type="text" id="telefonoInput" class="form-control" name="telefono" placeholder="Telefono"   onKeyPress="return soloNumeros(event)" required />
		    </div>
		</div>
		<div class="row">
		    <div class="modal-footer">
		    <br/>
		    <br/>
		    <br/>
		    <br/>
		    <button type="submit" class="btn btn-primary"  value="Registrar">Registrar</button>				
		    </div>
		</div>	
	    </div>
        </form>	
          <br/>
		    <br/>
		    <br/>
        <div class="col-sm-2" style="margin-top:14.7%;">
            <div id="recuva" class="row"><button  class="btn btn-primary" onclick="abrirModelContrasena()" >Cambiar Contraseña</button></div>
        </div>
    </div>
    
 </div>

</div>
<div id="modalcambiarContrasena" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Cambiar Contraseña</h4>
            </div>
            <div class="modal-body">
                <form id="fm_cambiarContrasena" name="fm_cambiarContrasena" data-toggle="validator"  role="form">
                    <div class="form-group">

                        <div class="row">
                            <br/>
                            <div class="col-md-4"><b><p name="nom" id="nom" >Contraseña</p></b> </div>
                            <div class="col-md-4">
                                <input type="password" class="form-control" id="contraseñaInput1" name="contrasena1"  placeholder="Contraseña" required/>
                            </div>
                        </div>
                        <div class="row">
                            <br/>
                            <div class="col-md-4"><b><p name="nom" id="nom" >Repita contraseña</p></b> </div>
                            <div class="col-md-4">
                                <input type="password" class="form-control" id="contrasenaInput" name="contrasena"  placeholder="Contraseña" required/>
                            </div>
                        </div> 

                    </div>
                    <br/>
                    <div class="modal-footer">
                        <button  type="submit" class="btn btn-primary" value="Registrar">Cambiar</button>
                        <button type="button"  class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#imagen2').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#inputImagen").change(function () {
        readURL(this);
    });
</script>