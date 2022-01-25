<?php 
    require("../Modelo/Conect.php");
    require("../Modelo/sede.php");
    require("../Modelo/profesores.php");
    require("../Controladores/encript.php");
    $objE = new SED();

    $objProfesor = new Profesor();
    $IDUsuario          = "";
    $codsede            = "";
    $Password           = "";
    $Rol                = "Profesor";
    $Documento          = "";
    $PrimerNombre       = "";
    $SegundoNombre      = "";
    $PrimerApellido     = "";
    $SegundoApellido    = "";
    $fechaNacimiento    = "00-00-0000";
    $sexo               = "";
    $Dir                = "";
    $Barrio             = "";
    $celular            = "";
    $email              = "";
    $gradoEscalafon     = "";
    $estado             = "";
    $dirGrupo           = "";
    $idNivelEstudios    = "";
    $enfasis            = "";
    $foto               = "silueta.jpg";

    if (isset($_SESSION['usuario'])) {
        $objProfesor->IDUsuario = $_SESSION['usuario'];
        $IDUsuario = $_SESSION['usuario'];
        foreach ($objProfesor->cargar() as $profe) {
            $codsede = $profe['codsede'];
            $Password = $profe['Password'];
            $Documento = $profe['Documento'];
            $PrimerNombre = $profe['PrimerNombre'];
            $SegundoNombre = $profe['SegundoNombre'];
            $PrimerApellido = $profe['PrimerApellido'];
            $SegundoApellido = $profe['SegundoApellido'];
            $fechaNacimiento = $profe['fechaNacimiento'];
            $sexo = $profe['sexo'];
            $Dir = $profe['Dir'];
            $Barrio = $profe['Barrio'];
            $celular = $profe['celular'];
            $email = $profe['email'];
            $gradoEscalafon = $profe['gradoEscalafon'];
            $estado = $profe['estado'];
            $dirGrupo = $profe['dirGrupo'];
            $idNivelEstudios = $profe['idNivelEstudios'];
            $enfasis = $profe['enfasis'];
            $foto = $profe['foto'];
        }
    }
    
?>

    <div class="clearfix"></div>
    <hr>
        <h2>PERFIL DEL DOCENTE</h2>
    <hr>
    <div class="row">
      <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">

            <div class="clearfix"></div>
          </div>
          <div class="x_content box-profile">
            <div class="col-md-3 col-sm-3  profile_left">
              <div class="profile_img">
                <div id="crop-avatar">
                  <form id='cambioFotoProfe' enctype='multipart/form-data' method='post' target='resultadoEnvio' onsubmit="cambiarFotoUsuario('Profesor')">
                      <div id='fotoVistaPrevia' >                                    
                          <a href='#' id='elegirIMG' class='btn btn-default' onclick='elegirIMG(this)'>Cambiar Imágen</a>
                          <img id='fotoUs' class="img-responsive avatar-view" src="vistas/img/Usuarios/<?php echo $foto ?>" width="250" alt="Foto" title="Cambiar Foto">                            
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
              <h3><?php echo $nombre ?></h3>
              <div class="clearfix"></div>

              <ul class="list-unstyled user_data">
                <li><i class="fa fa-map-marker user-profile-icon"></i> <?php echo $direccion; ?>
                </li>

                <li>
                  <i class="fa fa-briefcase user-profile-icon"></i> <?php echo $cargo; ?>
                </li>

                <li class="m-top-xs">
                  <i class="fa  fa-envelope-o user-profile-icon"></i>
                  <a href="#"><?php echo $correo; ?></a>
                </li>
                <li>
                    <i class="fa fa-calendar"></i>
                        <span><?php echo $fecha_reg; ?></span>
                </li>
              </ul>
            </div>
              <form action="" method="post" id="formPerfil" onsubmit="return actualizarPerfilProfesor()">
                <div class="col-md-9 col-sm-9 ">
                  <div class="profile_title row">                    
                  </div>
                  <!-- start of user-activity-graph -->
                  <div id="graph_bar" style="width:100%;">
                      <div class="x_content">
                        <div class="form-group row">
                          <label class="control-label col-md-2 col-sm-2 ">Usuario</label>
                          <div class="col-md-4 col-sm-4 ">
                            <input type="text" id="usuario" name="usuario" value="<?php echo $usuario;?>" class="form-control" placeholder="Nombre de usuario" require>
                          </div>
                          <label class="control-label col-md-2 col-sm-2 ">Contraseña<span class="required">*</span>
                          </label>
                          <div class="col-md-4 col-sm-4 ">
                            <div class="input-group">
                              <input type="password" id="contrasena" name="contrasena" value="<?php echo $password; ?>" class="form-control" placeholder="Contraseña" require readonly >
                              <span class="input-group-addon btn bg-green" title="Cambiar contraseña" onclick="contrasena('<?php echo $usuario; ?>','<?php echo $_SESSION['rol'] ?>')"
                              ><i class="info fa fa-check">Cambiar</i></span>
                            </div>  
                          </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                          <label class="control-label col-md-3 col-sm-3 ">Primer Nombre</label>
                          <div class="col-md-9 col-sm-9 ">                           
                            <input type="text" id="PrimerNombre" name="PrimerNombre" value="<?php echo $PrimerNombre; ?>" class="form-control"  require>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="control-label col-md-3 col-sm-3 ">Segundo Nombre</label>
                          <div class="col-md-9 col-sm-9 ">                           
                            <input type="text" id="SegundoNombre" name="SegundoNombre" value="<?php echo $SegundoNombre; ?>" class="form-control"  require>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="control-label col-md-3 col-sm-3 ">Primer Apellido</label>
                          <div class="col-md-9 col-sm-9 ">                           
                            <input type="text" id="PrimerApellido" name="PrimerApellido" value="<?php echo $PrimerApellido; ?>" class="form-control"  require>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="control-label col-md-3 col-sm-3 ">Segundo Apellido</label>
                          <div class="col-md-9 col-sm-9 ">                           
                            <input type="text" id="SegundoApellido" name="SegundoApellido" value="<?php echo $SegundoApellido; ?>" class="form-control"  require>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="control-label col-md-3 col-sm-3 ">No. de Documento</label>
                          <div class="col-md-9 col-sm-9 ">                           
                            <input type="number" id="documento" name="documento" value="<?php echo $Documento; ?>" class="form-control"  require>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="control-label col-md-3 col-sm-3 ">Sexo</label>
                          <div class="col-md-3 col-sm-3 ">                           
                            <select id="SEX<?php echo $IDUsuario ?>" name="sexo" class='form-control'>
                                <option value="M" <?php if($sexo =='M'){ echo "selected"; } ?>>M</option>
                                <option value="F" <?php if($sexo =='F'){ echo "selected"; } ?>>F</option>
                            </select>
                          </div>
                          <label class="control-label col-md-3 col-sm-3" style="text-align: right;">Fecha Nacimiento</label>
                          <div class="col-md-3 col-sm-3 ">                           
                            <input type='date' id="NAC<?php echo $IDUsuario ?>" name="fechaNacimiento" size='10' value="<?php echo $fechaNacimiento ?>" class='form-control'>
                          </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                          <label class="control-label col-md-3 col-sm-3 ">Correo</label>
                          <div class="col-md-9 col-sm-9 ">
                            <input type="email" id="correo" name="correo" value="<?php echo $correo; ?>" class="form-control" placeholder="Correo electrónico" require>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="control-label col-md-3 col-sm-3 ">Barrio</label>
                          <div class="col-md-9 col-sm-9 ">
                            <input type="text" id="barrio" name="barrio" value="<?php echo $Barrio; ?>" class="form-control">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="control-label col-md-3 col-sm-3 ">Dirección</label>
                          <div class="col-md-9 col-sm-9 ">
                            <input type="text" id="direccion" name="direccion" value="<?php echo $Dir; ?>" class="form-control">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="control-label col-md-3 col-sm-3 ">Teléfono</label>
                          <div class="col-md-9 col-sm-9 ">
                            <input type="text" id="telefono" name="telefono" value="<?php echo $telefono;?>" class="form-control" placeholder="Línea" require>
                          </div>
                        </div>
                        <hr>
                        <div class="form-group row grid_slider">
                            <label class="control-label col-md-3 col-sm-3 ">
                                Nivel de estudios
                            </label>
                            <div class="col-md-9 col-sm-9  ">
                                <select id="NES<?php echo $IDUsuario ?>" class='form-control' name="estudios">
                                    <?php 
                                        foreach ($objProfesor->listarNivelEstudios() as $nivel) {
                                            $sel = "";
                                            if ($nivel['id'] == $idNivelEstudios) {
                                               $sel = "selected";
                                            }
                                            echo "<option value='".$nivel['id']."' ".$sel." >".$nivel['nivelEstudio']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                          <label class="control-label col-md-3 col-sm-3 " >Enfasís</label>
                          <div class="col-md-4 col-sm-4 ">
                            <input type='text' id="ENF<?php echo $IDUsuario ?>" name='enfasis' value="<?php echo $enfasis ?> " placeholder='Enfásis' class='form-control'>
                          </div>
                          <label class="control-label col-md-2 col-sm-2 " style="text-align: right;">Escalafón</label>
                          <div class="col-md-3 col-sm-3 ">
                            <input type='text' id="GES<?php echo $IDUsuario ?>" name="escalafon" value="<?php echo $gradoEscalafon ?> " class='form-control' style='text-align:center;'>
                          </div>
                        </div>
                      </div>
                </div>
                <div class="row"> 
                <div class="col-md-4">              
                    <button type="submit" class="btn btn-success" style="width: 100%;">
                        <i class="fa fa-save m-left-xs"></i> Actualizar
                    </button>                    
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