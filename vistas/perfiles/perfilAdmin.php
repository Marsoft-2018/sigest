    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Perfil de Usuario</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content box-profile">
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12  profile_left">
              <div class="col-lg-12 col-md-12 col-sm-4 col-xs-12 profile_img">
                <div id="crop-avatar">
                  <form id='cambioFotoProfe' enctype='multipart/form-data' method='post' target='resultadoEnvio' onsubmit="cambiarFotoUsuario('<?php echo $_SESSION['rol']; ?>')">
                        <div id='fotoVistaPrevia' >                                    
                            <a href='#' id='elegirIMG' class='btn btn-default' onclick='elegirIMG(this)'>Cambiar Imágen</a>
                            <img id='fotoUs' class="img-responsive avatar-view" src="vistas/img/Usuarios/<?php echo $_SESSION['foto'] ?>" width="250" alt="Foto" title="Cambiar Foto">                            
                            <input type='hidden' value='0' name='fotoAnterior'>                                               
                            <input type='file' id='foto' name='foto' onchange='previsualizar(this)' />
                        </div>                            
                        <iframe name='resultadoEnvio' style='display:none;'></iframe>
                        <div id='mostrarMensajeImagen'></div>
                        <input type='hidden' value='$registro[1]' name='idUsuario'>
                        <input type='submit' value='Guardar Imágen' id='guardarIMG' class='btn btn-primary' style='margin-top:20px;display:none;width:98%;'>
                    </form>
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-8 col-xs-12 profile_img">
                <h3><?php echo $nombre ?></h3>
                <div class="clearfix"></div>

                <ul class="list-unstyled user_data">
                  <li><i class="fa fa-map-marker user-profile-icon"></i> <?php echo $direccion; ?>
                  </li>

                  <li>
                    <i class="fa fa-briefcase user-profile-icon"></i> <?php echo $_SESSION['cargo']; ?>
                  </li>

                  <li class="m-top-xs">
                    <i class="fa fa-external-link user-profile-icon"></i>
                    <a href="#" target="_blank"><?php echo $correo; ?></a>
                  </li>
                </ul>
                <br />
              </div>
            </div>
              <form action="" method="post" id="formPerfil" onsubmit="return actualizarPerfil()" >
                <div class="col-md-9 col-sm-12 ">
                  <div class="profile_title">
                    <div class="col-md-6">
                      
                    </div>
                  </div>
                  <!-- start of user-activity-graph -->
                  <div id="graph_bar" style="width:100%;">
                    <div class="x_content">
                      <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">
                          Fecha registro
                        </label>
                        <div class="col-md-9 col-sm-9 ">
                          <div id="reportrange" class="pull-left" style="margin-bottom: 15px; background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #E6E9ED">
                            <i class="fa fa-calendar"></i>
                            <span><?php echo $fecha_reg; ?></span> <b class="caret"></b>
                          </div>
                        </div>
                        <label class="control-label col-md-3 col-sm-3 ">Nombre</label>
                        <div class="col-md-9 col-sm-9 ">                         
                          <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" class="form-control" placeholder="Nombre completo" require>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">Usuario</label>
                        <div class="col-md-9 col-sm-9 ">
                          <input type="text" id="usuario" name="usuario" value="<?php echo $usuario;?>" class="form-control" placeholder="Nombre de usuario" require>
                          <input type="hidden" id="idUsuario" name="idUsuario" value="<?php echo  $_SESSION['idUsuario'];?>" class="form-control" placeholder="Nombre de usuario" require>
                          <input type="hidden" id="rol" name="rol" value="<?php echo $_SESSION['rol']; ?>" class="form-control" require>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">
                          Contraseña<span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 ">
                          <div class="input-group">
                            <input type="password" id="contrasena" name="contrasena" value="<?php echo $password; ?>" class="form-control" placeholder="Contraseña" require readonly >
                            <span class="input-group-addon btn bg-green" title="Cambiar contraseña" onclick="contrasena('<?php echo $usuario; ?>','<?php echo $_SESSION['rol'] ?>')"
                            ><i class="info fa fa-check">Cambiar</i></span>
                          </div>                            
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">Correo</label>
                        <div class="col-md-9 col-sm-9 ">
                          <input type="email" id="correo" name="correo" value="<?php echo $correo; ?>" class="form-control" placeholder="Correo electrónico" require>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">Dirección</label>
                        <div class="col-md-9 col-sm-9 ">
                          <input type="text" id="direccion" name="direccion" value="<?php echo $direccion; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">Teléfono</label>
                        <div class="col-md-9 col-sm-9 ">
                          <input type="text" id="telefono" name="telefono" value="<?php echo $telefono;?>" class="form-control" placeholder="Línea" require>
                        </div>
                      </div>
                      <div class="form-group row grid_slider">
                        <label class="control-label col-md-3 col-sm-3 ">
                          <?php 
                            if ($_SESSION['rol'] == "Profesor") {
                              echo "Nivel de estudios";
                            }else{
                              echo "Cargo";
                            }
                          ?>
                        </label>
                        <div class="col-md-9 col-sm-9  ">
                          <input type="text" id="cargo" name="cargo" value="<?php echo $cargo; ?>" class="form form-control"/>
                        </div>
                      </div>

                      <div class="form-group row">
                        <div class="col-lg-8 col-md-4 col-sm-4 col-xs-6 ">
                          
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 ">
                          <button class="btn btn-success" style="width: 100%" type="submit"><i class="fa fa-save"> Guardar Cambios</i></button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="resultado"></div>

<script>
    $('#fotoVistaPrevia').hover(
        function() {
            $(this).find('a').fadeIn();
        }, function() {
            $(this).find('a').fadeOut();
        }
    );
    $('#elegirIMG').on('click', function(e) {
         e.preventDefault();
        $('#foto').click();
    });
    $('#guardarIMG').click(function(){
        $('#guardarIMG').fadeOut();
    });
</script> 