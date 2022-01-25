<!Doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=yes">
	<!-- Estilos CSS -->
    <link href="css/bootstraps3.1.css" rel="stylesheet">

    <!-- <link href="estilosCSS/jquery-ui1.css" rel="stylesheet" type="text/css"> -->
    <link rel='stylesheet' href='estilosCSS/estiloCSS3.css' type='text/css' />
    <link rel='stylesheet' href='estilosCSS/estilo1.css' type='text/css' />
    <link rel="stylesheet" href="css/animate.css">
    <link rel="icon" href="vistas/img/Iconos/Icono.ico" />

<title>Pagina de Inicio MarSoft</title>
<style>
    .olvide{
        
    }
</style>
</head>
<body oncontextmenu="return false"  style="background-image: url('tools/textu1.png');">
   
    	<div class="panel" style='margin-top:0px;height:900px;background:  rgba(230,230,230,0.2);'>
            <div class="panel-heading " style='text-align:center;'>&nbsp;</div>
    	    <div class="panel-body" style='text-align:center;margin:50px;'>
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4 ">
                        <div class="panel ui-widget-content ui-corner-all animated fast bounceInDown" style='box-shadow: 0px 5px 180px  rgba(175,175,175,0.8) ;border-radius: 5px 35px 5px 5px;margin:0 auto;position:absolute;height:500px;'>
                            <div class='panel-heading' style="margin:0px;">
                                <div class="row">
                                    <div class='divCinta'>
                                        <img src='tools/Cinta.png' >
                                    </div>
                                    <div class="col-md-12">
                                        <?php	$imagenes=array("tools/sigest-1.svg","tools/sigest.svg","tools/sigest-1b.svg","tools/sigest-3.svg");
                                             Shuffle($imagenes);
                                        ?>
                                        <img src='<?php echo $imagenes[0]; ?>' id="image">
                                    </div> 
                                </div>
                                <h3 style='padding:6px;text-align:center;margin:0px;margin-top:5px;font-size:15px;font-weight:bold;background:#098689;color:#ffffff;font-family:verdana;'>SISTEMA DE GESTIÓN ACADÉMICA</h3>
                            </div>
                            <div class="panel-body" style="margin:0px;">
                                <div class="row" style="margin-top:0px;">
                                    <div class="col-md-12">
                                         <form name='formulario' method='post' action='' onsubmit='return logear()' id='frmLogin' target="_self" class="animated delay-1s faster zoomIn">
                                            <input name='usuario' type="text" value="" required id='usuario' class='form-control' placeholder="Nombre de Usuario" style="margin-bottom: 10px;">
                                            <input name='contrasena' type="password" value='' required id='contrasena' class='form-control' placeholder="Contraseña" style="margin-bottom: 10px;">
                                            <input type="submit" value="Ingresar" name='boton' id='enviar' class="btn btn-success" style='height:30px;font-size:14px;border-radius:10px;'>                                            
                                        </form>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12"></div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class='row' style="padding:15px;">
                                   <div class="col-md-12"><span ></span></div>
                                   <div class="alert alert-danger" id='error' style="display: none;"></div>
                                   <div class="alert alert-warning" id='advertencia' style="display: none;"></div>
                                   <div class="alert alert-warning" id='mensajes' style="display: none;"></div>
              
                                </div>
                                <h5 style="text-align: right;">
                                    <a href="vistas/usuarios/recuperarPass.php" class="olvide">Olvidé mi Contraseña</a>
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
    <script src="complementos/Jquery/jquery-3.4.1.js"></script>

    <!-- Bootstrap , datatables y alertify -->
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
</body>
</html>