<?php 
  if (!isset($_SESSION['idUsuario'])) {
    header("Location: /sigest/index.php");
  }else{
    require("Modelo/Conect.php");
    require("Modelo/Institucion.php");

    $objCentro = new Institucion();
    $objCentro->id = $_SESSION['institucion'];
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
    <title>Módulo | Profesor</title>
    <link rel="icon" href="tools/sigest-ico.svg" />   
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=0, maximum-scale=1, user-scalable=no" >
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
    <link rel='stylesheet' href='css/planilla.css' type='text/css'/>
  </head>
  <body class="">
<div class="wrapper">
    <header class="row cabecera">
      <div class="col-lg-3">
        <div class="logo" style="height: 100px; width: 100%">
          <img src='tools/sigest-n.svg' id='imagen' style='margin-left:0px; width: 60%; margin-top: -20px;'>   
        </div>
        <!-- <h4 style="padding: 0px; margin-top: -20px;">SISTEMA DE GESTIÓN ACADÉMICA<h4>  -->       
      </div>
      <div class="col-lg-6">
        <h3>Módulo para Docentes</h3> 
        <nav class="menu">
          <div class="animated slow bounceInLeft">
            <div class="menuContenido">
              <div class="menuNumero">
                <i class="fa fa-fw fa-desktop"></i>
                <span>Inicio</span>
                <div class="flecha"></div>
              </div>
              <div class="menuInterno" style="over-flow:auto;">
                <ul>
                  <li>
                    <a href="#" onclick='menu(this.id)' id='vistas/logroIntro.php'>
                      <i class="glyphicon glyphicon-list-alt"></i> Logros
                    </a>
                  </li>
                  <li>
                      <a href="#" onclick='menu(this.id)' id='vistas/calificarIntro.php'>
                        <i class="fa fa-fw fa-edit"></i> Calificar
                      </a>
                  </li><!--
                  <li>
                      <a href="https://meet.jit.si/Grupo7-3--11324400033801-108" target="selft">
                        <i class="fa fa-fw fa-edit"></i> Clase Virtual
                      </a>
                  </li>
                  <li>
                      <a href="https://classroomscreen.com/app/signup" target="selft" >
                        <i class="fa fa-fw fa-edit"></i> Pizarron
                      </a>
                  </li>-->
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
                      <a href="#" onclick='menu(this.id)' id='vistas/perfil.php' ><i class='fa fa-user'></i> Perfil</a>
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
                      <a href="#" onclick='menu(this.id)' id='vistas/reportes/listadoIntroProfe.php'><i class='fa fa-check-circle-o'></i> Planillas y Listados</a>
                  </li> 
                  <li>
                      <a href="#" onclick='menu(this.id)' id='vistas/reportes/reporteLogros.php'>
                        <i class='fa fa-list-ol'></i> Listado de logros
                      </a>
                  </li> 
                  <li>
                      <a href="#" onclick='menu(this.id)' id='vistas/reportes/Desempenos/reporteIntro.php'>
                        <i class='fa fa-newspaper-o'></i> Desempeño por estudiante
                      </a>
                  </li> 
                </ul>
              </div>
            </div>
          </div>
        </nav>       
      </div>
      <div class="col-lg-3" style="text-align: right; height: 100%;">
        <p style="text-align: right;"><?php echo $nombre ?></p>        
        <div style="height: 50px; width: 100%; position: relative;">
          <img src="vistas/img/<?php echo $logo; ?>" style=' margin:0px; width:12%; margin-right: 15px;'> 
        </div>
        <div class="navbar-custom-menu"  style="width:100%; text-align: right; float:right; background-color: red; margin-top: 15px;">
          <ul class="nav navbar-nav">                          
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu" style="position:absolute; right:0px;">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span class="hidden-xs"><i class="fa fa-user"></i> <?php echo $_SESSION['nombre']; ?> <b class="caret"></b></span>
              </a>
              <ul class="dropdown-menu" style="background-color:#4B4B4D; color: #21C621;">
                <!-- User image -->
                <li class="user-header">
                  <img src="vistas/img/Usuarios/<?php echo  $_SESSION['foto']; ?>" class="img-circle" alt="User Image">
                  <p>
                    <?php echo $_SESSION['nombre']; ?>
                    <small>Rol: <?php echo $_SESSION['rol']; ?></small>
                  </p>
                </li>
                <!-- Menu Footer-->
                <li class="divider"></li>                        
                <li class="user-footer"  style="background-color: #21C621;">
                  <div class="pull-left">
                    <a href="#" onclick='menu(this.id)' id='vistas/perfil.php' class="btn btn-default btn-flat"><i class="fa fa-fw fa-user"></i>Editar Perfil</a>
                  </div>
                  <div class="pull-right">
                    <a href="Controladores/ctrlLogout.php" class="btn btn-default btn-flat"><i class="fa fa-fw fa-power-off"></i> Salir</a>
                  </div>
                </li>
              </ul>
            </li>            
          </ul>
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
          
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog fade in" role="document" style="width: 70%;">
        <div class="modal-content">
          <div class="modal-header">
            <span class="modal-title" id="tituloModal" style="font-size: 2em; font-weight: bold; text-transform: uppercase"></span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="cargasFormulario">    ...   
          </div>
        </div>
      </div>
    </div>
      
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
    <script type="text/javascript" src="js/grados.js"></script>
    <script type="text/javascript" src="js/niveles.js"></script>
    <script type="text/javascript" src="js/desempenos.js"></script>
    <script type="text/javascript" src="js/calificaciones.js"></script>
    <script type="text/javascript" src="js/planillas.js"></script>
    <script type="text/javascript" src="js/observaciones.js"></script>
  </body>
</html>
