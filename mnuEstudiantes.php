<?php 
  if (!isset($_SESSION['idUsuario'])) {
    header("Location: /marsoft/index.php");
  }else{
    require("Modelo/Conect.php");
    require("Modelo/Institucion.php");

    $objCentro = new Institucion();
    // $objCentro->id = $_SESSION['institucion'];
    $objCentro->id = 1;
    $datos = $objCentro->cargar();
    foreach ($datos as $key => $value) {
        $nombre = $value['nombre'];
        $dane   = $value['dane'];
        $nit    = $value['nit'];
        $direccion  = $value['direccion'];
        $telefono   = $value['telefono'];
        $rector = $value['rector'];
        $logo   = $value['logo'];
        $icfes  = $value['icfes'];
        $resolucion = $value['resolucion'];
        $correo = $value['correo'];
        $ciudad = $value['ciudad'];
        $membrete   = $value['membrete'];
    }
  }
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Módulo | Estudiantes</title>
    <link rel="icon" href="tools/sigest-ico.svg" />   
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="complementos/AdminLTE/bootstrap/css/bootstrap.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css" type="text/css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="fonts/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="complementos/AdminLTE/dist/css/AdminLTE.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="complementos/AdminLTE/dist/css/skins/_all-skins.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="complementos/AdminLTE/plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="complementos/AdminLTE/plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="complementos/AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="complementos/AdminLTE/plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="complementos/AdminLTE/plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="complementos/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="complementos/alertifyjs/css/alertify.css" />    
    <link rel="stylesheet" href="complementos/sweetalert2/sweetalert2.css"/>
    <link rel="stylesheet" href="complementos/DataTables/datatables.css"/>
    <link rel='stylesheet' href='css/ventanas.css' type='text/css'/>
    <link rel='stylesheet' href='estilosCSS/estilosGenerales.css' type='text/css'/>    
    <link rel="stylesheet" href="css/menuprofesores.css"> 
    <style>
      .bienvenida{
        margin-top: 5px;
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        justify-content: flex-start;
        align-items: center;
        align-content: stretch;
      }

      .foto-b{
        width: 60px;
      }


      .foto-b img{
        width: 100%;
      }
      
      .titulo-b{
        width: 100%;
        height: 30px;
        padding: 1px;
      }

      .titulo-b h3{
        padding: 0px;
        margin: 0px;
      }

      .nombre-b{
        width: 100%;
        height: 30px;
        padding: 1px;
      }

      .nombre-b h3{
        padding: 0px;
        margin: 0px;
      }

    </style>
  </head>
  <body class="">
    <header class="row cabecera">
      <div class="col-lg-3">
        <div class="logo" style="height: 100px; width: 100%">
          <img src='tools/sigest-n.svg' id='imagen' style='margin-left:0px; width: 60%; margin-top: -20px;'>   
        </div>
        <!-- <h4 style="padding: 0px; margin-top: -20px;">SISTEMA DE GESTIÓN ACADÉMICA<h4>  -->       
      </div>
      <div class="col-lg-6">
        <div class="bienvenida">
          <div class="foto-b">
            <img src="vistas/img/Usuarios/<?php echo $_SESSION['foto']; ?>" alt="">
          </div>
          <div class="rotulos">
            <div class="titulo-b">
              <h3>Módulo para Estudiantes:</h3>
            </div>
            <div class="nombre-b">
              <h3>BIENVENIDO <?php echo $_SESSION['nombre']; ?></h3>
            </div>            
          </div>       
        </div>
        <nav class="menu">
          <div class="animated slow bounceInLeft">
            <div class="menuContenido">
              <div class="menuNumero">
                <i class="fa fa-fw fa-desktop"></i>
                <span>Inicio</span>
                <div class="flecha"></div>
              </div>
              <div class="menuInterno">
                <ul>
              
                  <li>
                      <a href="#" onclick='menu(this.id)' id=''>
                        <i class="fa fa-fw fa-edit"></i> Actividades
                      </a>
                  </li>
                  <li> <a href="Controladores/ctrlLogout.php" ><i class="fa fa-fw fa-power-off"></i> Salir</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="animated slow bounceInDown">
            <div class="menuContenido">
              <div class="menuNumero">
                <i class="fa fa-fw fa-wrench"></i>
                <span>Editar</span> 
                <div class="flecha"></div>
              </div>
              <div class="menuInterno">
                <ul>
                  <li>
                      <a href="#" onclick='menu(this.id)' id='vistas/estudiantes/cambiarPass.php' ><i class='fa fa-user'></i> Cambio Clave</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="animated slow bounceInRight">
            <div class="menuContenido">
              <div class="menuNumero">
                <i class="fa fa-fw fa-bar-chart-o"></i>
                <span>Reportes</span>
                <div class="flecha"></div>
              </div>
              <div class="menuInterno">
                <ul>
                  
                  <li>
                      <a href="#" onclick='menu(this.id)' id='vistas/estudiantes/historial.php'><i class='fa fa-check-circle-o'></i> Historial de  Calificaciones</a>
                  </li> 
                  <li>
                      <a href="#" onclick='menu(this.id)' id='vistas/estudiantes/boletinintro.php'><i class='fa fa-check-circle-o'></i> Boletin X Periodo</a>
                  </li> 
                </ul>
              </div>
            </div>
          </div>
        </nav>       
      </div>
      <div class="col-lg-3" style="text-align: right; height: 100%;">
        <p style="text-align: right;"><?php //echo $nombre ?></p>        
        <div style="height: 50px; width: 100%; position: relative;">
          <img src="vistas/img/<?php echo $logo; ?>" style=' margin:0px; width:12%; margin-right: 15px;'> 
        </div>
      </div>
    </header>
    <hr>
    <div class="section-principal">    
      <div class="content-section-principal">
        <div class='bloqueo' id='bloquear'>
          <img alt="Cargando..." src="estilosCSS/load.gif" width="160" height="160" style='margin-top:200px;margin-left:-100px;'>
        </div>
        <div class='bloqueo' id='capa'><img alt="Cargando..." src="estilosCSS/load.gif" width="60" height="60"></div>
        <!-- Main content -->
        <section class="content" id='modulo'>
          <div>
            
          </div>

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.3.0
        </div>
        <strong>Copyright &copy; 2020 <a href="http://marsoft-sas.com">Ing. Jose Alfredo Tapia</a>.</strong>
        Todos los derechos reservados.
        cel: 3107358169 - 3006469855<br>
        El Carmen de Bolívar -- Colombia
        <div style='margin:0 auto;margin-top:0px;width:25%;'>
          <div class="panel panel-green">
              <div class="panel-heading"  style="padding:5px;">
                  <div class="row">
                      <div class="col-xs-12 text-center">
                          <div><a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/"><img alt="Licencia Creative Commons" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-nd/4.0/88x31.png" /></a></div>
                      </div>
                  </div>
              </div>
              <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/">
                  <div class="panel-footer" style="padding:0px;">
                      <span class="pull-left" style="font-size:10px;">Este Sistema está bajo una Licencia CC-BY-NC-ND 4.0 <i class="fa fa-arrow-circle-right"></i></span>
                      <div class="clearfix"></div>
                  </div>
              </a>
          </div>                        
        </div>
        <!--- para pasar el rol del usuario <input type='hidden' id='OcultoRol' value='$crol' />-->
        <div class='ui-widget' style='display:none;width:450px;margin:0px auto; float:none;' id='barraresultados'>
            <div class='ui-state-highlight ui-corner-all' style='margin-top: 20px; padding: 0 .7em;' id='barraEstado'>

            </div>
        </div> 
      </footer>

      
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
    </div><!-- ./wrapper -->

     <script src="complementos/AdminLTE/plugins/jQuery/jquery-3.4.1.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="complementos/AdminLTE/plugins\jQueryUI/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="complementos/AdminLTE/bootstrap/js/bootstrap.js"></script>
    <!-- Sparkline -->
    <script src="complementos/AdminLTE/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="complementos/AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="complementos/AdminLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="complementos/AdminLTE/plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->
    <script src="complementos/AdminLTE/plugins/moment.min.js"></script>
    <script src="complementos/AdminLTE/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="complementos/AdminLTE/plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="complementos/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="complementos/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="complementos/AdminLTE/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="complementos/AdminLTE/dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="complementos/AdminLTE/dist/js/demo.js"></script>
    <script src="complementos/alertifyjs/alertify.js"></script>  
    <script src="complementos/sweetalert2/sweetalert2.js"></script>
            
    <!--- Las creadas por mi ---->
    <script src="js/AdministrarAcciones.js"></script>
    <script src="js/ajustarParametros.js"></script>
    <script src="js/main.js"></script>  
    <script type='text/javascript' src="js/logros.js"></script> 

  </body>
</html>
