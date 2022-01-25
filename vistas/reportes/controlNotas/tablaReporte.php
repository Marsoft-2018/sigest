<?php 
    require("../../../Modelo/Conect.php");
    require("../../../Modelo/areas.php");
    require("../../../Modelo/curso.php");
    require("../../../Modelo/profesores.php");
    require("../../../Modelo/cargaAcademica.php");
    require("../../../Modelo/matricula.php");

    if(isset($_POST['accion'])){
        $accion = $_POST['accion']; 
    }else{
        echo "No se recibe una accion para ejecutar";
        $accion = 'nada';
    }

    if($accion == 'cargarMatriz'){        
        $sede = $_POST['sede'];
        $anho = $_POST['anho'];
        $periodo = $_POST['periodo'];    

        $objArea = new Area();
        $objArea->codSede = $sede;
        $objArea->anho    = $anho;

        $objCurso = new Curso();
        $objCurso->codSede = $_POST['sede'];
        
        $objProfesores = new Profesor();
        $objProfesores->codsede = $_POST['sede'];

        $listaAreas      = $objArea->listar();
        $listaCursos     = $objCurso->listaXsedes();
        $listaProfesores = $objProfesores->Listar();
    }
?>

<?php 

?>
<table class='table table-striped' style="border: 2px solid #5A9Eaf;">
    <thead>
        <tr style="text-align: center; background-color: #095daf; color:#fff;">
            <th >AREAS</th>
            <?php 
                foreach ($listaCursos as $cur) {
                   if($cur['CODGRADO'] <= 11){  
                        echo "<th  style='text-align: center; border-left: 1px solid #dddddd;' id='dir".$cur['codCurso']."'>";
                        echo    $cur['CODGRADO']."°".$cur['grupo']."</th> ";
                        }
                }
                //me falta el ciclo para las asignaturas
            ?>
        </tr> 
    </thead>
    <tbody id='matrizAreas'>                     
        <?php 
            $cont = 1;
            $tipo = '';
        foreach ($listaAreas as $area) {                    
            $numDir = 0;
            $claseDir = "";

            echo "<tr class='apuntado'>";
            echo "<th title='".$area['Nombre']."' class='filaProfe'>".$area['Abreviatura']." - ".$area['Nombre']."</th>"; 
            //Recorrido de las areas nuevamente
            foreach ($listaCursos as $cur) {
                $objTcurso = new cargaAcademica();
                //$objTcurso->codProfesor = $profe['IDUsuario'];
                $objTcurso->anho = $anho;
                $objEstudiantes = new Matricula ();
                $totalEstudiantes = $objEstudiantes->numeroEstudiantes($cur['codCurso'],$sede,$anho);
               //En esta parte se verifica que tipo de input se coloca verificacndo la tabla cargaAcademica
                $objCarga = new cargaAcademica();
                $objCarga->codCurso = $cur['codCurso'];
                $objCarga->codArea = $area['id'];
                $objCarga->codigoA = $area['id'];
                $objCarga->anho = $anho;

                $conteoReg = 0;
                $celdaNombreProfe = "";
                $celdaProfe = "";
                $colorCelda = "";
                $colorLetra = "";
                $colorProfe = "";

                $objIntensidad = new Area();
                $objIntensidad->id = $area['id'];
                $objIntensidad->idGrado = $cur['CODGRADO'];
                $ih = 0;
                foreach ($objIntensidad->cargarIntensidad() as $campoih) {
                    $ih = $campoih['intensidad'];
                }

                if ($ih != 0) {
                $TotalEstNotas = $objCarga->totalNotas($cur['codCurso'],$area['id'],$anho,$periodo);  
                $faltan = $totalEstudiantes - $TotalEstNotas;
                if ($totalEstudiantes > 0) {
                    if($TotalEstNotas < $totalEstudiantes){
                        $porcentaje = ($faltan * 100)/$totalEstudiantes;
                        switch ($porcentaje) {
                            case $porcentaje>=90:
                                $colorCelda = "#f00";
                                $colorLetra = "#fff";
                                break;
                            case $porcentaje>=50:
                                $colorCelda = "#f60";
                                $colorLetra = "#fff";
                                break;
                            case $porcentaje>0:
                                $colorCelda = "#fe0";
                                $colorLetra = "#000";
                                break;
                        }
                        
                    }else{
                        $colorCelda = "#095F05";
                        $colorLetra = "#fff";
                    }
                }else{
                    $colorCelda = "#5d5d5d";
                    $colorLetra = "#3d3d3d";
                    $faltan = "-";
                }

                                
                //1. se verifica si este profesor ya tiene esa area en ese curso
                foreach ($objCarga->cargarCelda() as $carga) {
                    $celdaProfe = $carga['IDUsuario'];
                    $celdaNombreProfe = $carga['nombre'];
                    $colorProfe = $carga['color'];
                }
                if($celdaProfe == ""){
                    ?>
                    <td class="celdaCuerpo ap" style="background-color: <?php echo $colorCelda ?>; color:<?php echo $colorLetra ?>;" title="<?php echo $cur['CODGRADO']."°".$cur['grupo'] ?>" id="Cel<?php echo $cur['codCurso'].$area['id'] ?>" >                         
                        <div class="marcoEtiqueta">
                            Faltan: <?php echo $faltan ?><br>
                            De: <?php echo $totalEstudiantes ?><br>
                            <div class="datoProfe">
                                <p>
                                    Profesor del área:<br>
                                    <?php echo $celdaNombreProfe ?>
                                </p>
                            </div>
                        </div>                                        
                    </td> 
                    <?php

                    }else{ ?>
                    <td class="celdaCuerpo ap" style="background-color: <?php echo $colorCelda ?>;color:<?php echo $colorLetra ?>; " id="<?php echo $cur['codCurso'].$area['id'] ?>"> 
                        <div class="marcoEtiqueta">
                            Faltan: <?php echo $faltan ?><br>
                            De: <?php echo $totalEstudiantes ?><br>
                            <div class="datoProfe">
                                <p>
                                    Profesor del área:<br>
                                    <?php echo $celdaNombreProfe ?>
                                </p>
                            </div>
                        </div>
                    </td> 
                    <?php 
                    }                    
                }else{
                    echo "<td style = 'background-color: #e2e2e2;'>&nbsp;</td>";
                }

            }
        }
        ?>
    </tbody> 
    <tfoot>
        <tr style="text-align: center; background-color: #095daf; color:#fff;">
            <th >AREAS</th>
            <?php 
                foreach ($listaCursos as $cur) {
                   if($cur['CODGRADO'] <= 11){  
                        echo "<th  style='text-align: center; border-left: 1px solid #dddddd;' id='dir".$cur['codCurso']."'>";
                        echo    $cur['CODGRADO']."°".$cur['grupo']."</th> ";
                        }
                }
                //me falta el ciclo para las asignaturas
            ?>
        </tr>                 
    </tfoot>
</table>