<?php 
  if (!isset($_SESSION['idUsuario'])) {
    header("Location: /marsoft/index.php");
  }
  
    
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SiGest | Panel Control</title>
    <link rel="icon" href="tools/sigest-ico.svg" />  
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="complementos/AdminLTE/bootstrap/css/bootstrap.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css" type="text/css">
    <!-- Ionicons -->
    <!-- <link rel="stylesheet" href="fonts/ionicons.min.css"> -->
    <!-- Theme style -->
    <link rel="stylesheet" href="complementos/AdminLTE/dist/css/AdminLTE.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="complementos/AdminLTE/dist/css/skins/_all-skins.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="complementos/AdminLTE/plugins/iCheck/flat/blue.css">
    <link rel="stylesheet" href="complementos/AdminLTE/plugins/iCheck/all.css">
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

    <link rel="stylesheet" href="complementos/AdminLTE/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">

    <link rel="stylesheet" href="complementos/AdminLTE/select2/css/select2.min.css">

    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="complementos/alertifyjs/css/alertify.css" /> 
    <link rel="stylesheet" href="complementos/sweetalert2/sweetalert2.css"/>
    <link rel="stylesheet" href="complementos/DataTables/datatables.css"/>
    <link rel="stylesheet" href="complementos/hover-master/hover-min.css">
    <link rel='stylesheet' href='estilosCSS/estilosGenerales.css' type='text/css'/>
    <link rel='stylesheet' href='css/ventanas.css' type='text/css'/>
    <link rel='stylesheet' href='css/planilla.css' type='text/css'/>
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="index2.html" class="logo" style="background-color: #2B3B4D;">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">
            <img src='tools/sigest-ico.svg' id='icono' style='margin-left:0px; width: 100%;'><b>S</b>G
          </span>
          <!-- logo for regular state and mobile devices -->
          <span style="width: 80%; height: 100%;">
            <img src='tools/sigest-bc.svg' id='imagen' style='margin-left:0px; width: 60%; margin-top: -20px;'>
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


                    <img src="vistas/img/Usuarios/<?php echo  $_SESSION['foto']; ?>" class="img-circle" alt="User Image">
                    <p>
                      <?php echo $_SESSION['nombre']; ?>
                      <small>Rol: <?php echo $_SESSION['rol']; ?></small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                   <li>
                            
                        </li>
                        <li>
                                                      
                        </li>
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
          <form action="" method="post" class="sidebar-form">
            <div class="input-group" >
              <input type="text" id='buscarEst' value='' class='form-control' placeholder='Buscar estudiante' title='Para buscar un estudiante ingrese su numero de Documento' onkeyup='buscarEstudiante(this.value)'>              
              <span class="input-group-btn">
                <button type="button" name="search" id="search-btn" class="btn btn-flat" onclick='buscarEstudiante(this.name)'><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header"><i class="fa fa-fw fa-dashboard"></i> Menú Principal</li>
            <li class="active treeview">
              <a href="#">
                <i class="fa fa-fw fa-desktop"></i>  <span>Inicio</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li>
                    <a href="#"  onclick='menu(this.id)' id='vistas/institucion.php'><i class="fa fa-institution"></i> Institución</a>
                </li>
                <!-- <li>
                    <a href="#" onclick='menu(this.id)' id='EditAreas.php'><i class="fa fa-book"></i> Áreas</a>
                </li> -->
                <li  class="treeview menu-open">
                  <a href="#"><i class="fa  fa-sitemap"></i>Organización Sedes
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu" style="display: block;">
                    <li><a href="#" onclick='menu(this.id)' id='vistas/sedes.php'><i class="fa fa-circle-o"></i>Listado Sedes</a></li>
                    <li>
                      <a href="#" onclick='menu(this.id)' id='vistas/datosSedes/organizacionCursos.php'>
                        <i class="fa fa-circle-o"></i> Grupos/Cursos
                      </a>
                    </li>
                    <li class="treeview">
                      <a href="#"  onclick='menu(this.id)' id='vistas/datosSedes/pensum.php'><i class="fa fa-circle-o"></i> Areas/Asignaturas</a>
                    </li>
                  </ul>
                </li>
                <li>
                    <a href="#" onclick='menu(this.id)' id='vistas/Profesores.php'><i class="fa fa-briefcase"></i> Profesores</a>
                </li>
                <li>
                  <a href="#" onclick='menu(this.id)' id='vistas/direccionGrupos.php' >
                    <span><i class='fa fa-compass'></i> Direccion de Grupos</span>
                  </a>
                </li>
                <li>
                  <a href="#" onclick='menu(this.id)' id='vistas/cargaAcademica.php' >
                    <span><i class='fa fa-language'></i> Distribución Académica</span>
                  </a>
                </li>
                <li>
                    <a href="#" onclick='menu(this.id)' id='vistas/Estudiantes.php'><i class="fa fa-group"></i> Estudiantes</a>
                </li>
                <li>
                    <a href="#" onclick='menu(this.id)' id='vistas/guias/formulario.php'><i class="fa fa-columns"></i> Guías</a>
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
                    <a href="#" onclick='menu(this.id)' id='vistas/calificarIntro.php'><i class="fa fa-fw fa-edit"></i> Calificaciones</a>
                </li>
                <li>
                    <a href="#" onclick='menu(this.id)' id='vistas/logroIntro.php'><i class="glyphicon glyphicon-list-alt"></i> Logros</a>
                </li>
                <li>
                    <a href="#" onclick='menu(this.id)' id='vistas/perfil.php' ><i class='fa fa-user'></i> Perfil</a>
                </li>
                <li>
                    <a href="#" onclick='menu(this.id)' id='vistas/nivelacionIntro.php'><i class="fa fa-star-half-o"></i> Nivelaciones</a>
                </li>
                <li>
                  <a href="#" onclick='menu(this.id)' id='vistas/promoverIntro.php' >
                    <span><i class='fa fa-mortar-board'></i> Pomover Estudiantes</span>
                  </a>
                </li>
                <li>
                    <a href="#" onclick='menu(this.id)' id='vistas/datosSedes/traslados/trasladarIntro.php'><i class="fa fa-fw fa-flag"></i> Trasladar Estudiantes</a>
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
                
                <li>
                    <a href="#" onclick='menu(this.id)' id='vistas/boletinIntro.php'><i class="fa fa-file-text-o"></i> Boletines</a>
                </li>
                <li>
                    <a href="#" onclick='menu(this.id)' id='vistas/carnetIntro.php' ><i class='fa fa-credit-card'></i> Carnets</a>
                </li>
<li>
                    <a href="#" onclick='menu(this.id)' id='vistas/ConsolidadoGenIntro.php' ><i class='fa fa-archive'></i> Consolidado</a>
                </li>               
                <li>
<a href="#" onclick='menu(this.id)' id='vistas/reportes/certificacionesIntro.php'><i class="fa fa-file-text-o"></i> Constancias y Certificaciones</a>
                </li>
                <li>
                  <a href="#" onclick='menu(this.id)' id='vistas/reportes/controlIngresoDeNotas.php' >
                    <span><i class='fa fa-cubes'></i> Control Ingreso de Notas</span>
                  </a>
                </li>
                <li>
                    <a href="#" onclick='menu(this.id)' id='Consultas/reporteGraficoAreas.php' ><i class='fa fa-renren'></i> Desempeño Institucional</a>
                </li>
                <li>
                    <a href="#" onclick='menu(this.id)' id='Consultas/estadisticas.php' ><i class='fa fa-bar-chart-o'></i> Estadisticas</a>
                </li>
                <li>

                    <a href="#" onclick='reporteLogros(this.id)' id='vistas/reportes/reporteLogros.php'>
                      <i class='fa fa-list-ol'></i> Listado de logros
                    </a>
                </li> 
                <li>
                    <a href="#" onclick='menu(this.id)' id='vistas/reportes/listadoIntro.php'><i class='fa fa-check-circle-o'></i> Planillas y Listados</a>
                </li>

                <!--
                <p style='padding:0px;margin:0px;'>------------------------------------------------------------------</p>
                <li>
                    <a href="#" onclick='menu(this.id)' id='Consultas/constanciaIntro.php' ><i class='fa fa-tags'></i> Constancias de Estudio</a>
                </li>
                <li>

                    <a href="#" onclick='menu(this.id)' id='Vistas/certificadoIntro.php' ><i class='fa fa-stack-overflow'></i> Certificaciones</a>
                </li>-->
                    

              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-fw fa-legal"></i>  <span>Gobierno escolar</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li>
                    <a href="#" onclick='menu(this.id)' id='personero/vista/usuarios.php' ><i class='glyphicon glyphicon-user'></i> Usuarios</a>
                </li> 
                <li>
                    <a href="#" onclick='menu(this.id)' id='personero/vista/candidatos.php'><i class="glyphicon glyphicon-tower"></i> Candidatos</a>
                </li>
                <li>
                    <a href="#" onclick='menu(this.id)' id='vistas/Estudiantes.php' ><i class='fa fa-group'></i> Estudiantes</a>
                </li>
                <li>
                    <a href="#" onclick='menu(this.id)' id='personero/vista/conteo.php' ><i class='glyphicon glyphicon-hand-up '></i> Conteo de Votos</a>
                </li>
              </ul>
            </li>
            <li class="header">Ayuda</li> 
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
    <div class="bloqueo" id = "bloquear">
      <div class="carga">
        <img alt="Cargando..." src="estilosCSS/load.gif" >
      </div>
    </div>
    
        <!-- Main content -->
        <section class="content" id='modulo'>
          

        </section>

        <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog fade in" role="document" style="width: 70%;">
            <div class="modal-content">
              <div class="modal-header">
                <span class="modal-title" id="tituloModal" style="font-size: 2em; font-weight: bold; text-transform: uppercase"></span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body" id="cargasFormulario">
                ...
              </div>
            </div>
          </div>
        </div>
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.3.0
        </div>
        <strong>Copyright &copy; 2018 <a href="http://marsoft-sas.com">Ing. Jose Alfredo Tapia</a>.</strong>
        Todos los derechos reservados.
        cel: 3107358169<br>
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

    <!-- jQuery 2.1.4 -->
    <script src="complementos/AdminLTE/plugins/jQuery/jquery-3.4.1.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="complementos/AdminLTE/plugins\jQueryUI/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="complementos/AdminLTE/bootstrap/js/bootstrap.js"></script>
    <!-- Morris.js charts -->
    <!-- Librerias para construir los gráficos 
    <script src="complementos/AdminLTE/plugins/raphael-min.js"></script>
    <script src="complementos/AdminLTE/plugins/morris/morris.min.js"></script>
  -->
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

    <script src="complementos/AdminLTE/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <script src="complementos/AdminLTE/select2/js/select2.full.min.js"></script>
    <script src="complementos/AdminLTE/plugins/iCheck/icheck.min.js"></script>


    <!-- Bootstrap WYSIHTML5 -->
    <script src="complementos/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="complementos/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="complementos/AdminLTE/plugins/fastclick/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="complementos/AdminLTE/dist/js/app.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) 
    <script src="complementos/AdminLTE/dist/js/pages/dashboard.js"></script>-->
    <!-- AdminLTE for demo purposes -->
    <script src="complementos/AdminLTE/dist/js/demo.js"></script>
    <script src="complementos/alertifyjs/alertify.js"></script>  
    <script src="complementos/sweetalert2/sweetalert2.js"></script>
    <!-- <script src="js/jquery.flot.pie.js"></script>      
    <script src="js/jquery.flot.pie.js"></script> -->
            
    <!--- Las creadas por mi ---->
    <script src="js/AdministrarAcciones.js"></script>
    <script src="js/ajustarParametros.js"></script>
    <script src="js/main.js"></script>  
    <script type='text/javascript' src="js/traslados.js"></script> 
    <script type='text/javascript' src="js/logros.js"></script> 
    <script type='text/javascript' src="js/boletines.js"></script>
    <script type="text/javascript" src="js/promover.js"></script>
    <script type="text/javascript" src="js/nivelaciones.js"></script>
    <script type="text/javascript" src="js/grados.js"></script>
    <script type="text/javascript" src="js/niveles.js"></script>
    <script type="text/javascript" src="js/desempenos.js"></script>
    <script type="text/javascript" src="js/calificaciones.js"></script>
    <script type="text/javascript" src="js/planillas.js"></script>

    <!-- <script src="complementos/DataTables/datatables.js"></script>   -->
  </body>
</html>
