<?php 
    session_start();
    $usuario = $_SESSION['idUsuario'];
    $rol = $_SESSION['rol'];
?>
<div class="container">
    <br>    
    <div class="row">
        <div class="col-md-12">            
            <div class="x_panel">
                <div class="x_title seccion-cabecera">
                    <h3>CAMBIAR CONTRASEÑA</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12" class="animated zoomIn">
                                <label for="">Contraseña Nueva</label>
                                <div class="input-group" style="margin-bottom: 30px;">
                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                    <input type="password" class="form-control" placeholder="Contraseña Nueva " id="contrasena" required="required">
                                </div>  
                                <label for="">Confirmar Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
                                    <input type="password" class="form-control" placeholder="Confirmar Contraseña" id="contrasena2" required="required">
                                </div> 
                                <hr>      
                                <button class="btn btn-success boton" onclick="cambiarContrasenha('<?php echo $usuario ?>','<?php echo $rol ?>')">
                                    <i class="fa fa-save"></i> Guardar
                                </button>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert" id='mensaje' style="display: none;"></div>
                        </div>
                    </div>                                
                </div>                
            </div>            
        </div>
    </div>
</div>


