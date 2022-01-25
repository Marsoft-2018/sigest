<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistema | Panel Control</title>
    <link rel="icon" href="IMAGENES/Iconos/Icono.ico" />  
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

    <link rel="stylesheet" href="complementos/alertifyjs/css/alertify.css" />    
    <link rel="stylesheet" href="complementos/sweetalert2/sweetalert2.css"/>
    <link rel="stylesheet" href="complementos/DataTables/datatables.css"/>
    <link rel='stylesheet' href='estilosCSS/estilosGenerales.css' type='text/css'/>    
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="index2.html" class="logo" style="background-color: #000;">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><img src='vistas/img/Iconos/Icono.ico' id='icono' style='margin-left:0px;width: 50px;'><b>M</b>S</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg" style="background-color: #000;width: 100%;">
            <img src='tools/Marsoft2017-NP.png' id='imagen' style='margin-left:0px;'>
          </span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">                          
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <span class="hidden-xs"><i class="fa fa-user"></i> <?php echo $_SESSION['nombre']; ?> <b class="caret"></b></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">


                    <img src="vistas/img/usuarios/<?php echo $_SESSION['foto']; ?>" class="img-circle" alt="User Image">
                    <p>
                      <?php echo $_SESSION['nombre']; ?>
                      <small>Rol: Docente</small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="divider"></li>                        
                  <li class="user-footer">
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
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header"><i class="fa fa-fw fa-dashboard"></i> Menú Principal</li>
            <li class="active treeview">
              <a href="#">
                <i class="fa fa-fw fa-desktop"></i>  <span>Inicio</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li>
                    <a href="#" onclick='menu(this.id)' id='vistas/logroIntro.php'><i class="glyphicon glyphicon-list-alt"></i> Logros</a>
                </li>
                <li>
                    <a href="#" onclick='menu(this.id)' id='vistas/calificarIntro.php'><i class="fa fa-fw fa-edit"></i> Calificar</a>
                </li>
                 <li>
                    <!--<a href="#" onclick='menu(this.id)' id='Calificar/inasistenciasIntro.php' title='Historial sobre las inasistencias de los estudiantes durante el año lectivo'><i class="fa fa-calendar"></i> Historial de Faltas</a>-->
                </li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-fw fa-wrench"></i> 
                <span>Edición</span><i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li>
                    <a href="#" onclick='menu(this.id)' id='vistas/perfil.php' ><i class='fa fa-user'></i> Perfil</a>
                </li>
              </ul>
            </li>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-fw fa-bar-chart-o"></i>  <span>Reportes</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <!-- <li>
                    <a href="#" onclick='menu(this.id)' id='Calificar/consolidadoIntro.php'><i class='glyphicon glyphicon-tasks'></i> Consolidado</a>
                </li> -->
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
                <!-- <li>
                    <a href="#" onclick='menu(this.id)' id='Consultas/estadisticas.php' ><i class='fa fa-bar-chart-o'></i> Estadisticas</a>
                </li> -->
                <!-- <li>
                    <a href="#" onclick='menu(this.id)' id='Consultas/reporteGraficoAreas.php' ><i class='fa fa-renren'></i> Desempeño Institucional</a>
                </li> -->
                <!--
                <p style='padding:0px;margin:0px;'>------------------------------------------------------------------</p>
                <li>
                    <a href="#" onclick='menu(this.id)' id='Consultas/constanciaIntro.php' ><i class='fa fa-tags'></i> Constancias de Estudio</a>
                </li>-->
              </ul>
            </li>
            <li><a href="#"><i class="fa fa-book"></i> <span>Documentación</span></a></li>
            <li> 
              <a href="#" onclick='menu(this.id)' id='vistas/licencia.html'><i class="fa fa-question-circle"></i><span> Acerca De...</span></a>                                    
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header)
        <section class="content-header">
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>
 -->
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
        <strong>Copyright &copy; 2018 <a href="http://marsoft-sas.com">Ing. Jose Alfredo Tapia</a>.</strong>
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
