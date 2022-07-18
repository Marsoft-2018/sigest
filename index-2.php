<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=yes">
	<!-- Estilos CSS -->
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <!-- <link href="estilosCSS/jquery-ui1.css" rel="stylesheet" type="text/css"> -->
    
    <link rel="stylesheet" href="css/animate.css">
    <link rel="icon" href="tools/sigest-ico.svg" />  
    <link rel="stylesheet" href="css/login.css">

	<title>Pagina de Inicio SiGest</title>
	<script src="https://hcaptcha.com/1/api.js" async defer></script>
</head>
<body >
	<main>
		<header>
			<div class="img animated delay-0.5s slow fadeInLeft"></div>
		</header>
		<div  class="row principal">
		  <div id="carouselExampleCaptions" class="carousel slide imagen" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
          <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner  carousel-alto">
          <div class="carousel-item active">
            <img src="tools/banner/banner-1.png" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block carousel-caption-ubicacion filtro3">
              <h5>BIENVENIDO</h5>
				      <p>
                Con el Sistema de gestión académica SiGest la institución educativa puede implementar procesos de <br>registro, control, gestión y administración de la información académica  <br><a href="tools/propuesta.pdf" target="selft">Conoce más</a>
              </p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="tools/banner/banner-2.png" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block carousel-caption-ubicacion2 filtro2">
              <h5>CARÁCTER PEDAGÓGICO</h5>
              <p>
                siGest se desarrolla teniendo en cuenta como marco principal el respeto y el reconocimiento a la labor del profesional de la docencia y la práctica pedagógica
              </p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="tools/banner/banner-3.png" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block carousel-caption-ubicacion2 filtro1">
              <h5>Aumenta la Confiabilidad</h5>
              <p>
                Automatizando los procesos, se reduce la cantidad de errores y se aumenta la confiabilidad. 
                De esta forma, la Institución podra garantizar la calidad de la información que maneja y que presenta.
              </p>
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-target="#carouselExampleCaptions" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-target="#carouselExampleCaptions" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </button>
      </div>
			<div class="marcoLogin" style="">
				<section class="loginA">
					<h1>LOGIN</h1>
					<form name='formulario' method='post' action='' onsubmit='return logear()' target="_self" class="animated delay-1s faster zoomIn" id="frmLogin">
						<label for="usuario">Nombre de Usuario</label>	
              <input name='usuario' type="text" value="" required id='usuario' class='form-control' placeholder="Nombre de Usuario">
						<label for="contrasena">Contraseña</label>	
                        <input name='contrasena' type="password" value='' required id='contrasena' class='form-control' placeholder="Contraseña">
                        <div class="h-captcha" data-sitekey="9b1266f8-f53b-4831-a597-a44d8d6fcc57"></div>
                        <button type="submit" name='boton' id='enviar' class="btn btn-success">Ingresar</button>
                    </form>
                    <div class="panel-footer mensajes">
                        <h5 style="text-align: right;">
                            <a href="vistas/usuarios/recuperarPass.php" class="olvide">Olvidé mi Contraseña</a>
                        </h5>
                        <div class='row' style="padding:15px;">
                           <div class="col-md-12"><span ></span></div>
                           <div class="alert alert-danger" role="alert" id='error' style="display: none;"></div>
                           <div class="alert alert-warning" role="alert" id='advertencia' style="display: none;"></div>
                           <div class="alert alert-warning" role="alert" id='mensajes' style="display: none;"></div>
      
                        </div>
                    </div>
				</section>				
			</div>
		</div>
		<section class="row footer-section">
			<div class="col-lg-4 contenido animated delay-0.5s slow fadeInUp">
				<h3><i class="fa fa-thumb-tack"> </i> Características</h3>
				El Sistema de gestión académica SiGest, como su nombre los indica es un sistema diseñado y desarrollado especialmente para la administración académica, que responde a las exigencias internas y externas de la institución, en desarrollo de la normatividad legal vigente, respetando su autonomía institucional. Es un sistema que brindará dentro de su institución un rendimiento superior y mayor confianza en la información obtenida.  <br><a href="tools/propuesta.pdf" target="selft">Conoce más</a>
			</div>
			<div class="col-lg-4 contenido animated delay-1s slow fadeInUp">
				<h3><i class="fa fa-flag-checkered"> </i> Obtener Activación</h3>
				Como una alternativa económica y asequible, usted puede alquilar el software por un año, con pagos mensuales o anuales; este servicio incluye acceso a nuestro servidor, actualizaciones, capacitación y soporte para el administrador del sistema.
			</div>
			<div class="col-lg-4 contenido animated delay-2s slow fadeInUp">
				<h3><i class="fa fa-info-circle"> </i> Cómo adquiero la licencia?</h3>
				Pongase en contacto ya por los siguiente medios:<br>

				Cel: 310 735 8169<br>

				E-mail: josealf7@gmail.com<br>
			</div>
		</section>
		<footer class="row main-footer">
	        <div class="col-sm-12 col-lg-12">
	          <b>Versión</b> 7.5<br>
	        	<strong>Copyright &copy; <a href="http://marsoft-sas.com">Ing. Jose Alfredo Tapia</a>.</strong>
	        	Todos los derechos reservados.<br>
	        	cel: 3107358169  / El Carmen de Bolívar -- Colombia
	        	
	        </div>
	            <!--	        <div class="col-lg-3 pull-right hidden-xs" style="padding-right: 10px;">
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
	        </div>-->
	    </footer>
	</main>
    <!--<script src="complementos/Jquery/jquery-3.4.1.js"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    <!-- Bootstrap , datatables y alertify 
    <script src="js/bootstrap.min.js"></script>-->
    <script type="text/javascript" src="js/main.js"></script>
</body>
</html>