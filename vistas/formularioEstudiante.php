<?php 
    session_start();
    require("../Modelo/Conect.php");
    require("../Modelo/sede.php");
    require("../Modelo/curso.php");
    require("../Modelo/Estudiante.php");
    require("../Modelo/matricula.php");
    require("../Controladores/encript.php");
        
    $IDUsuario  = "";
    $Password   = "123456";
    $tipoDocumento = "";
    $Documento = "";
    $PrimerNombre   = "";
    $SegundoNombre   = "";
    $PrimerApellido = "";
    $SegundoApellido = "";
    $fechaNacimiento  = "";
    $sexo  = "";
    $correo  = "";
    $foto = "silueta.jpg";
    $accionFormulario = "";
    $num_interno = 0;
    $edad = 0;

    $objE = new SED();
 
    if(isset($_POST['Documento'])){
        $accionFormulario = "modificarEstudiante()";
        $objEstudiante = new Estudiante();
        $objEstudiante->Documento = $_POST['Documento'];
        foreach ($objEstudiante->cargar() as $estudiante) {      
            $IDUsuario  = $estudiante['IDUsuario'];
            $Password   = $estudiante['Password'];
            $tipoDocumento = $estudiante['tipoDocumento']; 
            $Documento = $estudiante['Documento'];
            $PrimerNombre   = $estudiante['PrimerNombre'];
            $SegundoNombre   = $estudiante['SegundoNombre'];
            $PrimerApellido = $estudiante['PrimerApellido'];
            $SegundoApellido = $estudiante['SegundoApellido'];
            $fechaNacimiento  = $estudiante['fechaNacimiento'];
            $sexo  = $estudiante['sexo']; 
            $foto = $estudiante['foto'];
            $correo = $estudiante['correo'];
            $num_interno = $estudiante['num_interno'];
        }
    }else{
        $accionFormulario = "agregarEstudiante()";
    }
    
    if($fechaNacimiento != ""){
        $edad = $objEstudiante->edad($fechaNacimiento);
    }
?>

<div id='vacciones'>
    <form id='formularioEstudiante' enctype="multipart/form-data" method='post' onsubmit="return <?php echo $accionFormulario; ?>" target='cuadroDeCarga'>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 style="letter-spacing: 10px;font-weight:bold;margin:0px;">DATOS DEL ESTUDIANTE A MATRICULAR</h4>
                    </div>
                    <div class="panel-body">
                        <div style="border:1px solid rgba(190,200,230,0.4);padding:2px;">
                            <div class="row">
                                <div class="col-md-2">
                                    <form id="formFoto" style="margin: 0 auto;">
                                        <div id="fotoVistaPrevia" >
                                            <a href="#" id="elegirIMG" class="btn btn-default" onclick="elegirIMG(this)">
                                                Cambiar Imágen
                                            </a>                                                
                                            <img src="vistas/img/Usuarios/<?php echo $foto; ?>" name="fotoUsuario" id="fotoUs" style="margin-left:50px; height:60%; width:60%; box-shadow: 2px 5px 5px rgba(153,153,153,1); background-color:#ffffff; border-radius:10px;">
                                            <input type="hidden" value="<?php echo $foto; ?>" name="fotoAnterior">
                                            <input type="file" id="foto" name="foto" onchange="previsualizar(this)" />
                                        </div>                            
                                        <iframe name="resultadoEnvio" style="display:none;"></iframe>
                                        <div id="mostrarMensajeImagen"></div>
                                    </form>
                                </div>
                                <div class="col-md-10">
                                    <div class="panel panel-default" style="padding:1px 1px 20px 1px;">
                                        <div class="panel-heading" style="padding:1px;">
                                            <h4 style="padding:2px;margin: 0px;"> Datos de Usuario </h4>
                                        </div>
                                        <div class="panel-body" style="padding:0px;">
                                            <div class="row" style="padding:2px;margin:1px;">
                                                <div class="col-md-4"> 
                                                   <label for="">Usuario:</label>
                                                   <input type="text" required value="<?php echo $IDUsuario; ?>" name="usuario" id="usuario" onkeyup="buscarUsuario(2,this.value);" class="form-control" readonly="true">
                                                   <div id="mostrarMensaje1"></div>
                                                </div>
                                                <div class="col-md-4">             
                                                   <label for="">Contraseña:</label>
                                                   <input 
                                                        type = "text" 
                                                        value = "<?php echo $objE->decryption($Password); ?>" name = "contrasena" 
                                                        id = "contrasena" 
                                                        class = "form-control"
                                                    >
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Número Interno:</label>
                                                    <input type="number"  class="form-control" id="num_interno" name="num_interno" value="<?php echo $num_interno; ?>">
                                                    <select id="rol" name="rol" class="form-control" style="display: none;" >
                                                        <option value="Estudiante" selected="selected">Estudiante</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="padding:2px;height:30px;">
                                        <h4 style="padding:2px;margin: 0px;">Datos Básicos</h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row" style="margin:0px;padding:0px;">
                                            <div class="col-md-3" style="margin:0px;padding:0px;">
                                                <label for="">Primer Nombre:</label>
                                                <input type="text" name="primerNombre" id="primerNombre" required value="<?php echo $PrimerNombre; ?>" required class="form-control">                   
                                            </div>
                                            <div class="col-md-3" style="margin:0px;padding:0px;">
                                                <label for="">Segundo Nombre:</label>
                                                <input type="text" name="segundoNombre" id="segundoNombre" value="<?php echo $SegundoNombre; ?>" class="form-control">                  
                                            </div>
                                            <div class="col-md-3" style="margin:0px;padding:0px;">
                                                <label for="">Primer Apellido:</label>
                                                <input type="Text" name="primerApellido" id="primerApellido" value="<?php echo $PrimerApellido; ?>" required class="form-control">                                
                                            </div>
                                            <div class="col-md-3" style="margin:0px;padding:0px;">
                                                <label for="">Segundo Apellido:</label>
                                                <input type="text" name="segundoApellido" id="segundoApellido" value="<?php echo $SegundoApellido; ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row" style="margin:0px;padding:0px;">
                                            <div class="col-md-3">
                                                <label for="">Documento:</label>
                                                <input type="text" name="documento" id="documento" required value="<?php echo $Documento; ?>" class="form form-control" onkeyup="buscarUsuario(2,this.value);">
                                                <input type="hidden" name="documentoAnterior" id="documentoAnterior" value="<?php echo $Documento; ?>" class="form form-control" >
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Tipo:</label>
                                                <select name="tipoDocumento" id="tipoDocumento" required class="form-control">
                                                    <option value="" >Seleccione...</option>                                      
                                                    <option value="RC" <?php if($tipoDocumento == 'RC'){ echo "Selected";} ?>>RC</option>
                                                    <option value="TI" <?php if($tipoDocumento == 'TI'){ echo "Selected";} ?>>TI</option>
                                                    <option value="CC" <?php if($tipoDocumento == 'CC'){ echo "Selected";} ?>>CC</option>                                               
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Fecha Nac:</label>
                                                <input type="date" name="fechaNacimiento" id="fechaNacimiento" size="10" value="<?php echo $fechaNacimiento; ?>" class="form-control" onchange="calcularEdad(this.value);" title="Ingrese la fecha de nacimiento del estudiante">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Sexo:</label>
                                                <select name="sexo" id="sexo" required class="form-control">
                                                    <option value="" >Seleccione...</option>
                                                    <option value="F" <?php if($sexo == 'F'){ echo "Selected";} ?>>F</option>
                                                    <option value="M" <?php if($sexo == 'M'){ echo "Selected";} ?>>M</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Edad:</label>
                                                <input type="text" id="edad" value="<?php echo $edad; ?>"  class="form-control" readonly="true">
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-md-4">
                                                <label for="">Correo:</label>
                                                <input type="email" id="correo" value="<?php echo $correo; ?>"  class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>                               
                                <?php 
                                    include("datosSedes/datosMatricula.php");
                                ?>
                            </div>
                            <div class="row modal-footer">
                                <div class="col-md-6"></div>  
                                <div class="col-md-3">
                                    <button type="submit"  class="btn btn-success btnPrincipal" >
                                        Guardar
                                    </button> 
                                </div>      
                                <div class="col-md-3" style="margin:0px;padding:0px;">
                                    <button type="button" id="botonCan"  class="btn btn-warning btnPrincipal" data-dismiss="modal">
                                        Cerrar
                                    </button>  
                                </div> 
                                <iframe name="cuadroDeCarga" style="display:none"></iframe>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div id="pruebaGuardado"></div>
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
    
    $('#documento').keyup(function () {
        var texto = $(this).val();
        $('#usuario').val(texto);
    });
</script>