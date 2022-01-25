<?php
    $usu = $_GET['us'];
    $token = $_GET['tkn'];
?>
<!Doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=yes">
	<!-- Estilos CSS -->
    <link href="../../css/bootstraps3.1.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../font-awesome/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="../../css/animate.css">
    <link rel="icon" href="../../vistas/img/Iconos/Icono.ico" />

<title>Pagina de Inicio Sigest</title>
<style>
    .panelExterno{
        margin-top:0px;
        height:900px;
        padding-top: 7%;
        background:  rgba(230,230,230,0.2);
    }
    .panelInterno{
        background:  rgba(250,250,250,1);
        box-shadow: 0px 5px 180px  rgba(175,175,175,0.8);
        border-radius: 5px 35px 5px 5px;
        margin:0 auto; 
        position:absolute; 
        width: 100%;
    }
    .titulo{
        border-radius: 5px 20px 0px 0px;
        padding: 20px; 
        text-align: center; 
        margin: 0px;
        margin-top: 5px;
        font-size:25px;
        font-weight:bold;
        background:#098689;
        color:#ffffff;
        font-family:verdana;
    }
    .boton{
        font-size:14px;
        border-radius:10px;
        margin-top: 20px;
        padding: 10px;
        width: 100%;

    }
</style>
</head>
<body oncontextmenu="return false"  style="background-image: url('../../tools/textu1.png');">
   
    	<div class="panelExterno" style=''>
    	    <div class="panel-body" style='text-align:center;margin:50px;'>
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4 ">
                        <div class="panelInterno">
                            <div class='panel-heading' style="margin:0px;">
                                <h3 class="titulo">REESTABLECER CONTRASEÑA</h3>
                            </div>
                            <div class="panel-body" style="margin:0px;">
                                <div class="row" style="margin-top:0px;">
                                    <div class="col-md-12">
                                        <form name='formulario' method='post' action='' onsubmit='return reestablecer()' id='frmLogin' target="_self" class="animated zoomIn">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                                <input type="password" class="form-control" placeholder="Nueva Contraseña" id="contrasena" required="required">
                                            </div>  
                                            <hr>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
                                                <input type="password" class="form-control" placeholder="Confirmar Contraseña" id="contrasena2" required="required">
                                            </div>                            <input type="hidden" id="usu" value="<?php echo $usu ?>">   
                                            <input type="hidden" id="tkn" value="<?php echo $token ?>">        
                                            <input type="submit" value="Enviar" name='boton' id='enviar' class="btn btn-success boton" >
                                        </form>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                    </div>
                                </div>

                            </div>
                            <div class="panel-footer">
                                <div class='row' style="padding:15px;">
                                   <div class="alert" id='mensaje' style="display: none;"></div>
              
                                </div>
                                <h5 style="text-align: center;">
                                    <a href="../../index.php">Iniciar Sesión</a>
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>
    	</div>
	
    <footer class="main-footer" style="padding-left:10px;">
        <div class="pull-right hidden-xs" style="padding-right: 10px;">
          <b>Version</b> 3.0
            <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/">
                  <div class="panel-footer" style="padding:0px;">
                        <span class="pull-left" style="font-size:9px;">
                            Este Sistema está bajo una Licencia CC-BY-NC-ND 4.0 
                            <i class="fa fa-arrow-circle-right"></i>
                        </span>
                        <div class="clearfix"></div>
                  </div>
            </a>
            <div>
                <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/">
                    <img alt="Licencia Creative Commons" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-nd/4.0/88x31.png" />
                </a>
            </div>
        </div>
        <strong>Copyright &copy; 2018 <a href="http://marsoft-sas.com">Ing. Jose Alfredo Tapia</a>.</strong>
        Todos los derechos reservados.<br>
        cel: 3107358169<br>
        El Carmen de Bolívar -- Colombia
      </footer>
    <script src="../../complementos/Jquery/jquery-3.4.1.js"></script>

    <!-- Bootstrap , datatables y alertify -->
    <script src="../../js/bootstrap.min.js"></script>
    <script type="text/javascript">
        function reestablecer() {
            var usuario = $("#usu").val();
            var token = $("#tkn").val();
            var accion = "reestablecer";
            var contrasena = $("#contrasena").val();
            var contrasena2 = $("#contrasena2").val();
            if( contrasena != contrasena2){                
                $("#mensaje").html("Por favor verifique las contraseñas deben ser iguales").removeClass("alert-success").addClass("alert-danger animated zoomIn").show('fast');
            }else{
               $.ajax({
                    type:"POST",
                    data:{accion:accion, usuario:usuario,token:token,contrasena:contrasena},
                    url:"../../Controladores/ctrlContrasenas.php",
                    success:function(repuesta){
                        repuesta = repuesta.trim();
                        if (repuesta) {
                            console.log(repuesta);
                            $("#mensaje").html("Contraseña reestablecida con éxito puede iniciar sesión").removeClass("alert-danger").addClass("alert-success animated zoomIn").show('fast');
                        } else {
                            console.log(repuesta);
                            $("#mensaje").html("Error, no se pudo cambiar la contraseña, intentelo nuevamente").removeClass("alert-success").addClass("alert-danger animated zoomIn").show('fast');
                        }
                    }
                });
            }
            return false;             
        }
    </script>
</body>
</html>