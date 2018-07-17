
<link href="<?php echo base_url() ?>public/css/jquery.bootgrid.css" rel="stylesheet">
<link href="<?php echo base_url() ?>public/css/fileinput.css" rel="stylesheet">
<script src="<?php echo base_url() ?>public/js/jquery.bootgrid.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/js/funcionesGestionarUsuario.js"></script>
<!--inicio de Usuarios Base de Datos-->
<!--Final Usuarios Basee de datos-->

<div class="col-md-11">
    <br>
    <div class="bootstrap-table">
        <div class="alert alert-success" id="successIndicador" hidden="true">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <output id="msgOkGestionarUsuario"></output>
        </div> 
        <div class="table-responsive">
            <table id="grid-data" class="table table-hover table-stripedz" data-toggle="bootgrid" data-url="gestionar_usurio/getGestionarUsuarios">
                <thead>
                    <tr>
                        <th data-column-id="id_usuario" data-visible="false">Id usuario
                        </th>
                        <th data-column-id="nombres">Nombres</th>
                        <th data-column-id="apellidos">Apellidos</th>
                        <th data-column-id="nombre_usuario">Nombre usuario</th>
                        <th data-column-id="numero_documento">Numero Documento</th>
                        <th data-column-id="telefono">Telefono</th>
                        <th data-column-id="correo">Correo</th>
                        <th data-column-id="area_unidad">Area</th>
                        <th data-column-id="sistema">Sistema</th>
                        <th data-column-id="nombre_ips" >IPS</th>
                        <th data-column-id="nombre_eps">EPS</th>
                        <th data-column-id="contrasenia" data-visible="false">Contraseña</th>
                        <th data-column-id="foto_user">Foto</th>
                        <th data-column-id="nombre_rol" data-visible="false">rol</th>
                        <th style="width:150%" data-column-id="commands" data-formatter="commands" data-sortable="false">Acción</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

</div>
</div>




<div id="myModalEditar" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content Editar-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Información del usuario</h4>
            </div>
            <div class="modal-body">
                <form id="form-edit-usuario" data-toggle="validator"  role="form">
                    <div class="form-group">
                        <div class="row" >
                            <br/>
                            <div class="col-md-2"><b><p name="nom" id="nom" >Nombres </p></b> </div>
                            <div class="col-md-4">
                               <input rows="1" type="text" class="form-control" name="nombres" id="nombreInput" placeholder="Nombres" required/>
                           </div>
                           <div class="col-md-2"><b><p name="nom" id="nom" >Apellidos </p></b> </div>
                           <div class="col-md-4">
                               <input  type="text" id="apellidoInput" class="form-control" name="apellidos" placeholder="Apellidos" required />
                           </div>
                       </div>

                       <div class="row">
                        <br/>
                        <div class="col-md-2"><b><p name="nom" id="nom" >Documento </p></b> </div>
                        <div class="col-md-4">
                            <input type="text" id="documentoInput" class="form-control" name="numero_identificacion" placeholder="Numero Documento" required  onKeyPress="return soloNumeros(event)"/>
                        </div>
                        <div class="col-md-4" >
                            <input type="text" id="idUsuarioInput" style="visibility: hidden" class="form-control" name="id_usuario" placeholder="Id Usuario" required  />
                        </div>  



                    </div>


                    <div class="row">
                        <br/>
                        <div class="col-md-2"><b><p name="nom" id="nom" >Correo</p></b> </div>
                        <div class="col-md-4">
                           <input type="text" id="correoInput" class="form-control" name="correo" placeholder="Correo" required />

                       </div>
                       <div class="col-md-2"><b><p name="nom" id="nom" >Telefono</p></b> </div>
                       <div class="col-md-4">
                           <input type="text" id="telefonoInput" class="form-control" name="telefono" placeholder="Telefono" required onKeyPress="return soloNumeros(event)"/>
                       </div>
                   </div>

                   <div class="row">
                    <br/>
                    <div class="col-md-2"><b><p name="nom" id="nom" >Sistema</p></b> </div>
                    <div class="col-md-4">
                       <select name="sistema" class="form-control" id="sistemaInput" required>
                         <option>PORTAL INDICADORES</option>
                         <option>SGBD</option>
                     </select >
                 </div>
                 <div class="col-md-2"><b><p name="nom" id="nom" >Rol</p></b> </div>
                 <div class="col-md-4">
                    <select name="idRol" class="form-control" id="idRol" > 
                      <option></option>
                  </select>
              </div>
          </div>

          <div class="row">
            <br/>
            <div class="col-md-2"><b><p name="nom" id="nom" >Ips</p></b> </div>
            <div class="col-md-4">
             <select name="ips" class="form-control" id="ipsInputR"  >
               <option></option>
           </select>
       </div>
       <div class="col-md-2"><b><p name="nom" id="nom" >Eps</p></b> </div>
       <div class="col-md-4">
        <select name="eps" class="form-control" id="epsInputR"  >
           <option></option>
       </select>
   </div>

</div>

<div class="row">
    <br/>
    <div class="col-md-2"><b><p name="nom" id="nom" >Nombre Usuario</p></b> </div>
    <div class="col-md-4">
        <input type="text" id="userInput" class="form-control" name="username" placeholder="Usuario" required />
    </div>
    <div class="col-md-2"><b><p name="nom" id="nom" >Contraseña</p></b> </div>
    <div class="col-md-4">
        <input type="password" class="form-control" id="contraseñaInput" name="contrasena" placeholder="Contraseña" required/>
    </div>
</div>

<div class="row">
   <br/>

   <div class="col-md-2"><b><p name="nom" id="nom" >Area Unidad</p></b> </div>
   <div class="col-md-4">
    <select name="area" class="form-control" id="areaInputR"  >
        <option>UDM</option>
        <option>USAM</option>
        <option>UDM</option>
        <option>AGAF</option>
        <option>AGF</option>
        <option>AGA</option>
        <option>UGE</option>
        <option>ADN</option>
        <option>AGT</option>
        <option>ACE</option>
        <option>AGC</option>
    </select>
</div>

</div>

</div>
<br/>
<div class="modal-footer">
 <button type="submit" class="btn btn-primary" id="sumit" value="Registrar">Guardar</button>
 <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
</div>
</form>

</div>

</div>
</div>
</div>
<!--Final modal de editar cada usuario -->






<!--modal de Nuevo usuario -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Registrar Nuevo usuario</h4>
            </div>
            <div class="modal-body">
                <form id="form-create-usuario" data-toggle="validator" enctype="multipart/form-data"  role="form">
                    <div class="form-group">
                        <div class="row" >
                            <br/>
                            <div class="col-md-4">
                               <input rows="1" type="text" class="form-control" name="nombres" id="nombreInputR" placeholder="Nombres" required/>
                           </div>
                           <div class="col-md-4">
                               <input  type="text" id="apellidoInputR" class="form-control" name="apellidos" placeholder="Apellidos" required />
                           </div>
                       </div>

                       <div class="row">
                        <br/>

                        <div class="col-md-8">
                            <input type="text" id="identificacionInputR" class="form-control" name="numero_identificacion" placeholder="Numero Documento" required  onKeyPress="return soloNumeros(event)"/>
                        </div>                            
                    </div>


                    <div class="row">
                        <br/>

                        <div class="col-md-4">
                           <input type="text" id="correoInputR" class="form-control" name="correo" placeholder="Correo" required />

                       </div>

                       <div class="col-md-4">
                           <input type="text" id="telefonoInputR" class="form-control" name="telefono" placeholder="Telefono" required onKeyPress="return soloNumeros(event)"/>
                       </div>
                   </div>

                   <div class="row">
                    <br/>

                    <div class="col-md-4">
                       <select name="sistema" class="form-control" id="sistemaInputR" required>
                         <option>PORTAL INDICADORES</option>
                         <option>SGBD</option>
                     </select >
                 </div>

                 <div class="col-md-4">
                    <select name="usuarioI" class="form-control" id="idUserInput" required>
                    </select>

                </div>


            </div>

            <div class="row">
                <br/>

                <div class="col-md-4">
                 <select name="ips" class="form-control" id="ipsInput"  >
                    <option value="">IPS</option>
                </select>
            </div>

            <div class="col-md-4">
                <select name="eps" class="form-control" id="epsInput"  >
                    <option value="">EPS</option>
                </select>
            </div>

        </div>

        <div class="row">
            <br/>
            <div class="col-md-4">
                <input type="text" id="userInputR" class="form-control" name="username" placeholder="Usuario" required />
            </div>
            <div class="col-md-4">
                <select  class="form-control"  id="areaInputE"  >
                    <option></option>
                    <option>UDM</option>
                    <option>USAM</option>
                    <option>UDM</option>
                    <option>AGAF</option>
                    <option>AGF</option>
                    <option>AGA</option>
                    <option>UGE</option>
                    <option>ADN</option>
                    <option>AGT</option>
                    <option>ACE</option>
                    <option>AGC</option>
                </select>
            </div>
        </div>
        <div class="row">
            <br/>
            <div class="col-md-4">
                <input type="password" class="form-control" id="contraseñaInputR" name="contrasena" placeholder="Contraseña" required/>
            </div> 

        </div>
    
    </div>
    <br/>
    <div class="modal-footer">
     <button type="submit" class="btn btn-primary" id="sumit" value="Registrar">Registrar</button>
     <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
 </div>
</form>

</div>

</div>
</div>
</div>
<!--Final modal nuevo usuario -->

<!--modal de Eliminar cada usuario -->
<div id="modalEliminarUsuario" hidden="true" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Eliminar Usuario</h4>
            </div>
            <div class="modal-body">
                <output id="msgEliminarUsuarios"></output>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" data-dismiss="modal" onclick="eliminarUsuarios()" >Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!--Final modal de editar cada usuario -->















