
<style>
      .notasEstudiantes{
        margin-top: 5px;
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        justify-content: flex-start;
        align-items: center;
        align-content: stretch;
      }

      .anho{
        width: 20%;
        height: 100%;
        background-color: #06caF3; 
        color: #fff;
        font-size: 2em;
        text-align: center;
      }

      .areas{
        width: 80%;
        border: 1px solid blue;
      }
    
</style>

<div>

 <?php
    session_start();
    require("../../Modelo/Conect.php");
    require("../../Modelo/Institucion.php");
    require("../../Modelo/sede.php");
    require("../../Modelo/curso.php");
    require("../../Modelo/periodos.php");
    require("../../Modelo/matricula.php");
    require("../../Modelo/anhoLectivo.php");
    require("../../Modelo/areas.php");
    require("../../Modelo/Estudiante.php");
    require("../../Modelo/Calificacion.php");
    require("../../Modelo/desempenhos.php");
    require("../../Modelo/puesto.php");
    require("../../Modelo/entregaDeInformesPeriodo.php");
    //require("../../Controladores/ctrlBloqueArea.php");

    // $curso   = $_POST['curso'];
    // $anho    = $_POST['anho'];
    // $periodo = $_POST['periodo'];
    $grado;
    $grupo;
    $usuario = "Todos";
    $totalAreas = 0;
    $numAsig    = 0;
    $areasParaPerder = 0;
    $promedios = array();
    $promedioCurso = 0;

    $objInstitucion = new Institucion();
    $objAnho = new Anho();
    $objSede = new Sede();
    $objCurso = new Curso();
    $objArea = new Area();
    $objEstudiante = new Estudiante();
    $objEntrega = new entregaDeInformesPeriodo();
    $objMatriculas = new Matricula();
    $objMatriculas->Documento = $_SESSION['idUsuario'];

    foreach ($objInstitucion->cargar() as $dato) {
        $institucion = $dato['nombre'];
        $logo = $dato['logo'];
    }


?> 


</div>
<div class="container">
    <br>    
    <div class="row">
        <div class="col-md-12">            
            <div class="x_panel">
                <div class="x_title seccion-cabecera">
                    <h3>Historial de calificaciones <hr><?php echo $_SESSION['nombre']; ?></h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php 
                        $count = 0;
                        foreach ($objMatriculas->listar() as $value) { 
                            $delay = "delay-".$count."s";
                            if ($value['idMatricula'] ): ?>
                                
                            <?php endif ?>
                            <div class="notasEstudiantes animated bounceIn <?php echo $delay; ?> ">
                                <div class="anho ">
                                    <h1>Año</h1>
                                    <label><?php echo $value['anho'] ?></label>
                                </div>
                                <div class="areas">
                                    <table class="table table-striped">
                                        <thead>
                                            <caption>Areas</caption>
                                            <tr>
                                                <?php 

                                                ?>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div> 
                    <?php 
                        $count++;
                        }
                    ?>                              
                </div>                
            </div>            
        </div>
    </div>
</div>