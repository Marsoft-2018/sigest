<?php 
    session_start();    
    require("../../../Modelo/Conect.php");  
    require("../../../Modelo/sede.php");  
    require("../../../Modelo/curso.php");
    require("../../../Modelo/Estudiante.php");
    require("../../../Modelo/areas.php");
    require("../../../Modelo/Calificacion.php");
    require("../../../Modelo/matricula.php");
    require("../../../Modelo/desempenhos.php");
    require("../../../Modelo/puesto.php");

    $periodo = $_POST['periodo'];
    $curso = $_POST['curso'];    
    $anho = $_POST['anho'];
    $tipoUsuario = $_SESSION['rol'];

    $objCurso = new Curso();
    $objCurso->curso = $curso ;
    $objCurso->anho = $anho;
    $objCurso->idUsuario =  $_SESSION['idUsuario'];
    $esDir = $objCurso->esDirector();
    if ($esDir) {
        # code...
           

            $desempenho = "";
            if (isset($_POST['desempenho'])) {
                $desempenho = $_POST['desempenho'];
            }

            $nota = "";
            $objEstudiante = new Estudiante();
            $objEstudiante->curso = $curso;
            $objEstudiante->anho = $anho;
            


            $bajo = 0;
            $basico = 0;
            $alto = 0;
            $superior = 0;
            $porcentajeBajo = 0;
            $porcentajeBasico = 0;
            $porcentajeAlto = 0;
            $porcentajeSuperior = 0;

            $objSede = new Sede();
            $sede = $objSede->sedeCurso($curso);

            $objMatricula = new Matricula();
            $totalEstudiantes = $objMatricula->numeroEstudiantes($curso,$sede,$anho);
            $numEspacios = $totalEstudiantes;
            //echo "Total estudiantes: ".$totalEstudiantes;
            $grado;
            $grupo;
            $totalAreas = 0;
            $numAsig    = 0;
            $promedios = array();

            $objArea = new Area();

            $objCurso->curso = $curso;

            foreach ($objCurso->consultarGrado() as $campo) {
                $grado = $campo['CODGRADO'];
                $grupo = $campo['grupo'];
            }

            $objArea->idGrado = $grado;
            $objArea->anho = $anho;
            $objArea->codSede = $sede;

            foreach ($objArea->cargarPensum() as $area) { 
                $totalAreas++;
            }

            //$totalEstudiantes = 0;
            
            $objNotas = new Calificacion();
            $objNotas->periodo   = $periodo;
            $objNotas->Anho  = $anho;
            $objNotas->curso = $curso;
            $listaNotas = $objNotas->listaPromedios();
            foreach ($listaNotas as $itemNota) {        
                $objDes = new Desempenos();
                $objDes->nota = $itemNota['promedio'] / $totalAreas;
                $des = $objDes->cargar();
                switch ($des) {
                    case 'BAJO':
                        $bajo = $bajo + 1;
                        break;
                    case 'BASICO':
                        $basico = $basico + 1;
                        break;
                    case 'ALTO':
                        $alto = $alto + 1;
                        break;
                    case 'SUPERIOR':
                        $superior = $superior + 1;
                        break;
                } 
            }

            $porcentajeBajo = ($bajo * 100)/ $totalEstudiantes ;
            $porcentajeBasico = ($basico * 100)/ $totalEstudiantes ;
            $porcentajeAlto = ($alto * 100)/ $totalEstudiantes ;
            $porcentajeSuperior = ($superior * 100)/ $totalEstudiantes ;


            $barraSuperior = round(($superior * 35)/ ($totalEstudiantes/$numEspacios),3);
            $posSuperior = round(261- $barraSuperior,3);

            $barraAlto = round(($alto * 35)/ ($totalEstudiantes/$numEspacios),3);
            $posAlto = round(261- $barraAlto,3);

            $barraBasico = round(($basico * 35)/ ($totalEstudiantes/$numEspacios),3);
            $posBasico = round(261- $barraBasico,3);

            $barraBajo = round(($bajo * 35)/ ($totalEstudiantes/$numEspacios),3);
            $posBajo = round(261- $barraBajo,3);
        ?>
        <?php 
            
        ?>
        <div class="x_panel">
            <div class="x_title seccion-cabecera">
              <h3>RESUMEN DE DESEMPEÑOS</h3>
              <div class="clearfix" style="text-align: right;">Fecha: <strong><?php echo date("Y-m-d") ?></strong> </div>
            </div>
            <div class="x_content box-profile">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-xs-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">PORCENTAJE SEGÚN EL PROMEDIO</h3>

                                      <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                      </div>
                                    </div>
                                    <div class="box-body chart-responsive">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                <div class="col-lg-6 col-md-6 col-xs-6">
                                  <!-- small box -->
                                  <div class="small-box bg-aqua">
                                    <div class="inner">
                                      <p>SUPERIOR</p>
                                      <h3><?php echo round($porcentajeSuperior,1) ?><sup style="font-size: 20px">%</sup></h3>                
                                     
                                    </div>
                                    <div class="icon">
                                      <i class="ion ion-bag"></i>
                                    </div>
                                    <a href="#" class="small-box-footer"> Estudiantes: <strong>     <?php echo $superior ?></strong></a>
                                  </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-6 col-md-6 col-xs-6">
                                  <!-- small box -->
                                  <div class="small-box bg-green">
                                    <div class="inner">
                                      <p>ALTO</p>
                                      <h3><?php echo round($porcentajeAlto,1) ?><sup style="font-size: 20px">%</sup></h3>              
                                      
                                    </div>
                                    <div class="icon">
                                      <i class="ion ion-stats-bars"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">Estudiantes: <strong>     <?php echo $alto ?></strong></a>
                                  </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-6 col-md-6 col-xs-6">
                                  <!-- small box -->
                                  <div class="small-box bg-yellow">
                                    <div class="inner">
                                      <p>BASICO</p>                  
                                      <h3><?php echo round($porcentajeBasico,1) ?><sup style="font-size: 20px">%</sup></h3>
                                      
                                    </div>
                                    <div class="icon">
                                      <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">Estudiantes: <strong><?php echo $basico ?></strong></a>
                                  </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-6 col-md-6 col-xs-6">
                                  <!-- small box -->
                                  <div class="small-box bg-red">
                                    <div class="inner">
                                      <p>BAJO</p>                  
                                      <h3><?php echo round($porcentajeBajo,1) ?><sup style="font-size: 20px">%</sup></h3>
                                      
                                    </div>
                                    <div class="icon">
                                      <i class="ion ion-pie-graph"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">Estudiantes: <strong><?php echo $bajo ?></strong></a>
                                  </div>
                                </div>
                            </div>
                                        <!--- Fin de la primera columna -->
                                    </div>
                                </div>
                            </div>
                            <!------- fin porcentajes --->
                            <div class="col-lg-6 col-md-12 col-xs-12">
                                    <div class="box box-success">
                                        <div class="box-header with-border">
                                          <h3 class="box-title">GRÁFICO DE DESEMPEÑOS</h3>

                                          <div class="box-tools pull-right">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                          </div>
                                        </div>
                                        <div class="box-body chart-responsive">
                                          <div class="chart" id="bar-chart" style="height: 300px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                                <svg height="300" version="1.1" width="614" style="overflow: hidden; position: relative; left: -0.5px;">
                                                <desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></desc>
                                                <defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs>

                                                <?php 
                                                    $y = 261;
                                                    if ($totalEstudiantes > 0) {
                                                        for ($i=0; $i <= $totalEstudiantes; $i += ($totalEstudiantes / $numEspacios)) { ?>                         
                                                        <text 
                                                            x="32.859375" y="<?php echo $y ?>" 
                                                            text-anchor="end" 
                                                            font-family="sans-serif" 
                                                            font-size="12px" 
                                                            stroke="none" 
                                                            fill="#888888" 
                                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" 
                                                            font-weight="normal"
                                                        >
                                                            <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                                                <?php echo round($i,0) ?>
                                                            </tspan>
                                                        </text>
                                                        <path fill="none" stroke="#aaaaaa" d="M45.359375,<?php echo $y ?>H588.5" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                                        </path>
                                                    <?php 
                                                            $y = $y - 35;
                                                        } 
                                                    }
                                                ?>
                                                
                                                <text x="420" y="273.5" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,7)">
                                                <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">BAJO</tspan>
                                                </text>
                                                <text x="300" y="273.5" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,7)">
                                                <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">BASICO</tspan>
                                                </text>
                                                <text x="180" y="273.5" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,7)">
                                                <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">ALTO</tspan>
                                                </text>
                                                <text x="80" y="273.5" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,7)">
                                                <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">SUPERIOR</tspan>
                                                </text>
                                                <rect x="55" y="<?php echo $posSuperior ?>" width="50" height="<?php echo $barraSuperior ?>" rx="0" ry="0" fill="#00a6ff" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;">
                                                </rect>
                                                <rect x="161" y="<?php echo $posAlto ?>" width="50" height="<?php echo $barraAlto ?>" rx="0" ry="0" fill="#157F21" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;">
                                                </rect>
                                                <rect x="272" y="<?php echo $posBasico ?>" width="50" height="<?php echo $barraBasico ?>" rx="0" ry="0" fill="#F0AF01" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;">
                                                </rect>
                                                <rect x="383" y="<?php echo $posBajo ?>" width="50" height="<?php echo $barraBajo ?>" rx="0" ry="0" fill="#AF0204" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;">
                                                </rect>
                                                </svg>
                                                <div class="morris-hover morris-default-style" style="left: 515.689px; top: 112px; display: none;">
                                                <div class="morris-hover-row-label">2012</div>
                                                <div class="morris-hover-point" style="color: #00a65a"></div>
                                                <div class="morris-hover-point" style="color: #f56954"></div>
                                                </div>
                                                </div>
                                    </div>
                                    <!-- /.box-body -->
                                  </div>
                            </div>
                        </div>        
                    </div>
                </div>
            </div>
        </div>
        <div class="x_panel">
            <div class="x_title seccion-cabecera">
              <h3>REPORTE DETALLADO </h3>
              <div class="clearfix"></div>
            </div>
            <div class="x_content box-profile">
            <table class="table " border='0' cellpadding='0' cellspacing='0' style= "border-collapse:collapse; table-layout:fixed; width:100%;">
                <thead>
                    <tr style="color:#fff; background-color: #095daf; text-align: center; padding: 2px; font-weight: bold;">
                        <td width='10' >Nº</td>
                        <td width='90'>ESTUDIANTE</td>
                        <?php 
                            foreach ($objArea->cargarPensum() as $area) { ?>         
                            <td width="20" title="<?php echo $area['Nombre'] ?>">
                                <?php echo $area['Abreviatura'] ?>
                            </td>        
                        <?php } ?>
                        <td width='20'>PROM. GERAL</td>
                        <td width='20'>PUESTO</td>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $nolista = 1;
                    foreach ($objEstudiante->listarCurso() as $estudiante) { ?>
                    <tr>
                        <td class="" style="padding: 2px; border: 1px solid #5d5d5d;"><?php echo $nolista ?></td>
                        <td class="" style="padding:2px; border: 1px solid #5d5d5d;">
                            <?php echo $estudiante['PrimerApellido']." ". $estudiante['SegundoApellido']." ". $estudiante['PrimerNombre']." ". $estudiante['SegundoNombre'] ?> 
                        </td>
                        <?php 
                        $promedio = 0;
                        $objAreaEst = new Area();
                        $objAreaEst->idGrado = $grado;
                        $objAreaEst->anho = $anho;
                        $objAreaEst->codSede = $sede;
                        foreach ($objAreaEst->cargarPensum() as $area) {
                            $nota = "-"; 
                                $nota = "-";
                                $objNota = new Calificacion();
                                $objNota->periodo = $periodo;
                                $objNota->idMatricula = $estudiante['idMatricula'];
                                $objNota->codArea = $area['id'];
                                $objNota->Anho = $_POST['anho'];
                                $objNota->curso = $_POST['curso'];

                                foreach ($objNota->cargar() as $notaArea) {
                                    $nota = $notaArea['NOTA'];
                                } 

                                $objDesempeno = new Desempenos();
                                $objDesempeno->nota = $nota;
                                $des = $objDesempeno->cargar();
                                switch ($des) {
                                    case 'BAJO':
                                        echo "<td class='' style='color:#f00;padding: 2px; border: 1px solid #5d5d5d;'>".$des."</td>";
                                        break;                                
                                    default:
                                        echo "<td class='' style='padding: 2px; border: 1px solid #5d5d5d;'>".$des."</td>";
                                        break;
                                }                        
                            
                            //for ($i=1; $i <= $periodo ; $i++) { }      
                        }?>        
                        <td class=''  style='padding: 2px; border: 1px solid #5d5d5d;'>
                            <?php 
                                $objCalificacion = new Calificacion(); 
                                $objCalificacion->periodo = $periodo;
                                $objCalificacion->idMatricula = $estudiante['idMatricula'];
                                $objCalificacion->Anho = $anho;
                                $objCalificacion->curso = $curso ;
                                $promedio = $objCalificacion->promedioEstudiante();
                                $promedioEst = round(($promedio / $totalAreas),2);
                                //echo  $promedioEst;
                                $promedios[] = ($promedio / $totalAreas);


                                $desGeneral = new Desempenos();
                                $desGeneral->nota = $promedioEst;
                                $des = $desGeneral->cargar();
                                switch ($des) {
                                    case 'BAJO':
                                        echo "<div style='margin:0px;color:#f00;'>".$des."</div>";
                                        break;                                
                                    default:
                                        echo "<div style='margin:0px;'>".$des."</div>";
                                        break;
                                }  
                            ?>
                        </td>
                        <td class=''  style='padding: 2px; border: 1px solid #5d5d5d;'>
                            <?php 
                                $objPuesto = new Puesto();
                                $objPuesto->idMatri = $estudiante['idMatricula'];
                                $objPuesto->cur = $curso;
                                $objPuesto->anno = $anho;
                                $objPuesto->per = $periodo;
                                $objPuesto->listaEstudiantes = $objEstudiante->Listar();
                                $objPuesto->totalAreas = $totalAreas;
                                $objPuesto->promedioEstudiante = $promedioEst;
                                echo $objPuesto->puestoEstudiante();
                            ?>
                        </td>
                    </tr>

                    <?php 
                        $nolista++; 
                    }
                    ?> 
                </tbody>
            </table>
            </div>
        </div>
<?php  }else{ ?>
        <div class='alert' style = "font-size: 1.5em; margin:20px; padding: 50px; text-align:center; background-color: #FFD80080">
                <h1>Este reporte está disponible unicamente para el director del curso</h1>
            </div>
<?php } ?>
