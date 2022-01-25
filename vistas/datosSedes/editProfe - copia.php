<?php 
    session_start();
    require("../../Modelo/Conect.php");
    require("../../Modelo/sede.php");
    require("../../Modelo/profesores.php");
    require("../../Controladores/encript.php");
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

    if (isset($_POST['profesorID'])) {
        $objProfesor->IDUsuario = $_POST['profesorID'];
        $IDUsuario = $_POST['profesorID'];
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

<div style='width:98%;'>
    <div class="row">
        <div class="col-lg-12">
            <div class="bs-example" data-example-id="table-within-panel">
                <div class="panel panel-info">
                    <div class="panel-heading">
                       <h4>DATOS DEL PROFESOR A EDITAR <?php echo $IDUsuario; ?></h4>
                    </div>
                    <div class="panel-body">                        
                        <div class='panel panel-default'>
                            <div class='panel-heading'><h4>Datos de Usuario</h4></div>
                            <div class='panel-body'>
                                <div class='row'>
                                    <div class='col-md-8'>
                                        <div class='row'>
                                            <div class='col-md-6'> 
                                                <label for="">Usuario:</label>
                                                <input type='TEXT' required value='<?php echo $IDUsuario; ?>' id="USU<?php echo $IDUsuario; ?>" onchange='buscarUsuario(1,this.value); modificarProfe(this.id,this.value)' class='form-control'>
                                                <div id='mostrarMensaje1'></div>
                                            </div>
                                            <div class='col-md-6'>
                                                <label for="">Contraseña:</label>
                                                <input type='text' value="<?php echo $objE->decryption($Password) ?>" id="CON<?php echo $IDUsuario; ?>" onchange='modificarProfe(this.id,this.value)' class='form-control'>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-md-6'>
                                                <label for="">Rol:</label>
                                                <select id="ROL<?php echo $IDUsuario ?>" onchange='modificarProfe(this.id,this.value)' class='form-control'>
                                                    <option value="<?php echo $Rol ?>">
                                                        <?php echo $Rol ?>
                                                    </option>
                                                </select>
                                            </div>
                                            <div class='col-md-6'>
                                                <label for="">Estado:</label>
                                                <select id="EST<?php echo $IDUsuario ?>" onchange='modificarProfe(this.id,this.value)'  class='form-control'>
                                                    <option value="Activo" <?php if($estado == 'Activo'){ echo "selected"; } ?>>
                                                        Activo
                                                    </option>
                                                    <option value="Inactivo" <?php if($estado == 'Inactivo'){ echo "selected"; } ?>>
                                                       Inactivo
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='col-md-4'>
                                        <form id='cambioFotoProfe' enctype='multipart/form-data' method='post' target='resultadoEnvio' onsubmit='cambiarFotoProfesor()'>

                                            <div id='fotoVistaPrevia' >                                    
                                                <a href='#' id='elegirIMG' class='btn btn-default' onclick='elegirIMG(this)'>Cambiar Imágen</a>
                                                <img src="vistas/img/Usuarios/<?php echo $foto ?>" id='fotoUs' style='margin:0px;height:130px;width:100px;box-shadow: 2px 5px 5px rgba(153,153,153,1);background-color:#ffffff;border-radius:10px;'>
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
                            </div>
                        </div>
                        <div class='panel panel-default'>
                            <div class='panel-heading'><h4>Datos Básicos</h4></div>
                            <div class='panel-body'>
                                <div class='row'>
                                    <div class='col-md-3'>
                                        <label for="">Primer Nombre</label>
                                        <input type='TEXT' id="NO1<?php echo $IDUsuario ?>" onchange='modificarProfe(this.id,this.value)' required value="<?php echo $PrimerNombre ?> "class='form-control'>                                
                                    </div>
                                    <div class='col-md-3'>
                                        <label for="">Segundo Nombre</label>
                                        <input type='TEXT' id="NO2<?php echo $IDUsuario ?>" onchange='modificarProfe(this.id,this.value)' value="<?php echo $SegundoNombre ?> " class='form-control'>                                
                                    </div>
                                    <div class='col-md-3'>
                                        <label for="">Primer Apellido</label>
                                        <input type='Text' id="AP1<?php echo $IDUsuario ?>" onchange='modificarProfe(this.id,this.value)' value="<?php echo $PrimerApellido ?> " class='form-control'>
                                    </div>
                                    <div class='col-md-3'>
                                        <label for="">Segundo Apellido:</label>
                                        <input type='TEXT' id="AP2<?php echo $IDUsuario ?>" onchange='modificarProfe(this.id,this.value)' value="<?php echo $SegundoApellido ?> " class='form-control'>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-3'>
                                        <label for="">Documento</label>
                                        <input type='text' id="DOC<?php echo $IDUsuario ?>" onchange='modificarProfe(this.id,this.value)' required value="<?php echo $Documento ?> "  class='form-control'>
                                    </div>
                                    <div class='col-md-3'>
                                        <label for="">Fecha de Nacimiento</label>
                                        <input type='date' id="NAC<?php echo $IDUsuario ?>" onchange='modificarProfe(this.id,this.value)' size='10' value="<?php echo $fechaNacimiento ?>" class='form-control'>
                                    </div>
                                    <div class='col-md-2'>
                                        <label for="">Sexo</label>
                                        <select id="SEX<?php echo $IDUsuario ?>" onchange='modificarProfe(this.id,this.value)' class='form-control'>
                                            <option value="M" <?php if($sexo =='M'){ echo "selected"; } ?>>M</option>
                                            <option value="F" <?php if($sexo =='F'){ echo "selected"; } ?>>F</option>
                                        </select>
                                    </div>
                                    <div class='col-md-4'></div>
                                </div>
                            </div>
                        </div>
                        <div class='panel panel-default'>
                            <div class='panel-heading'><h4>Datos de Ubicación y Contacto</h4></div>
                            <div class='panel-body'>
                                <div class='row'>
                                    <div class='col-md-3'>
                                        <label for="">Barrio</label>
                                        <input type='TEXT' id="BAR<?php echo $IDUsuario ?>" onchange='modificarProfe(this.id,this.value)' required value="<?php echo $Barrio ?> " lock='true' class='form-control'>                    
                                    </div>
                                    <div class='col-md-3'>
                                        <label for="">Dirección</label>
                                        <input type='text' id="DIR<?php echo $IDUsuario ?>" onchange='modificarProfe(this.id,this.value)' value="<?php echo $Dir ?> " required class='form-control'>
                                        </div>
                                        <div class='col-md-3'>
                                        <label for="">Celular</label>
                                        <input type='text' id="CEL<?php echo $IDUsuario ?>" onchange='modificarProfe(this.id,this.value)' required value="<?php echo $celular ?> " class='form-control'>
                                        </div>
                                        <div class='col-md-3'>
                                        <label for="">Correo Electrónico</label>
                                        <input type='email' id="COR<?php echo $IDUsuario ?>" onchange='modificarProfe(this.id,this.value)' required value="<?php echo $email ?> " class='form-control'>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='panel panel-default'>
                            <div class='panel-heading'><h4>Datos de Pertenencia</h4></div>
                            <div class='panel-body'>
                                <div class='row' style='text-align:center'>
                                    <div class='col-md-3'>
                                        <label for="">Nivel de Estudios</label>
                                        <select id="NES<?php echo $IDUsuario ?>" class='form-control' onchange='modificarProfe(this.id,this.value)'>
                                            <?php 
                                                foreach ($objProfesor->listarNivelEstudios() as $nivel) {
                                                    $sel = "";
                                                    if ($nivel['id'] == $idNivelEstudios) {
                                                       $sel = "selected";
                                                    }
                                                    echo "<option value='".$nivel['nivelEstudio']."' ".$sel." >".$nivel['nivelEstudio']."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class='col-md-2'>
                                        <label for="">Enfásis</label>
                                        <input type='text' id="ENF<?php echo $IDUsuario ?>" name='NewENF' value="<?php echo $enfasis ?> " placeholder='Enfásis' class='form-control' onchange='modificarProfe(this.id,this.value)'>
                                    </div>
                                    <div class='col-md-2'>
                                        <label for="">Escalafón</label>
                                        <input type='text' id="GES<?php echo $IDUsuario ?>" onchange='modificarProfe(this.id,this.value)' value="<?php echo $gradoEscalafon ?> " class='form-control' style='text-align:center;'>
                                    </div>
                                    <div class='col-md-2'>
                                        <label for="">Sede</label>
                                        <select id="SED<?php echo $IDUsuario ?>" onchange='modificarProfe(this.id,this.value)' class='form-control'>
                                            <?php 
                                                $objSede = new sede();                                    
                                                foreach ($objSede->listar() as $sede) {
                                                    $sel = "";
                                                    if ($sede['CODSEDE'] == $codsede) {
                                                       $sel = "selected";
                                                    }
                                                    echo "<option value='".$sede['CODSEDE']."' ".$sel.">".$sede['NOMSEDE']."</option>";
                                                }
                                             ?>                                
                                        </select>
                                    </div>
                                    <div class='col-md-3'>
                                        <label for="">Director de Grupo</label>
                                        <select name="DG1<?php echo $IDUsuario ?>" id="DG1<?php echo $IDUsuario ?>" onchange='modificarProfe(this.id,this.value);Mostrarcurso(this.value)' class="form form-control">
                                            <option value="SI" <?php if($dirGrupo =='SI'){ echo "selected"; } ?>>SI</option>
                                            <option value="NO" <?php if($dirGrupo =='NO'){ echo "selected"; } ?>>NO</option>
                                        </select>
                                    </div>
                                </div>
                                </div>
                                </div>
                                 <div class='row'>
                                    <div class='col-md-12' id='cursoOculto'>
                                        <?php 
                                            require("direccionGrupo.php");
                                        ?>
                                    </div>
                                <div class='row'>
                                    <div class='col-md-6'>
                                        <input type='hidden' name='accion' value='agregarProfesor'>
                                        <iframe name='cuadroDeCarga' style='display:none'></iframe>
                                        
                                    </div>
                                    <div class='col-md-6'>
                                     <input type='button' class='btn btn-success' onclick='cancelar2();cargarListaProfesores()' value='Listo' style='padding:10px;margin:10px 20px;width:90%;'>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>