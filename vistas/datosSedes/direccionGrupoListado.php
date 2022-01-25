<?php 
    $objProfesores = new Profesor();
    $objProfesores->codsede = $_POST['sede'];
    $objCurso = new Curso();
    $objCurso->codSede = $_POST['sede'];
    $listaCursos = $objCurso->listaXsedes();
    $listaProfesores = $objProfesores->Listar();
?>
<dir class="row">
    <div class="col-md-12">
        <table id='sudoku' class='table sudoku' >
            <thead>
                <tr>
                    <th></th>
                    <th class='celdaTitulo'>PROFESORES</th>
                    <?php 
                        foreach ($listaCursos as $cur) {
                           if($cur['CODGRADO'] <= 11){  
                                echo "<th class='celdaCuerpo' id='dir".$cur['codCurso']."'>";
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
                foreach ($listaProfesores as $prof) {                    
                    $numDir = 0;
                    $claseDir = "";
                    $celdaNombreProfe = strtoupper($prof['PrimerNombre']." ".$prof['SegundoNombre']." ".$prof['PrimerApellido']." ".$prof['SegundoApellido']);
                    echo "<tr class='apuntado'>";
                    echo "<td style='width:30px; padding:0px; text-align:center;'>";
                    echo    $cont;
                    echo "</td>";
                    echo "<th class='filaProfe celdaProfe'>
                            <div data-toggle='modal' data-target='#staticBackdrop' id='".$prof['IDUsuario']."' onclick='editarProfesor(1,this.id)'>
                                        ".$celdaNombreProfe."
                            </div>
                        </th>"; 
                    //Recorrido de las profs nuevamente
                    foreach ($listaCursos as $cur) {
                       //En esta parte se verifica que tipo de input se coloca verificacando la tabla direccioncursos
                        $objProfesor = new Profesor();
                        $conteoReg = 0;
                        $celdaProfe = "";
                        $curso = $cur['CODGRADO']."°".$cur['grupo'];
                        $colorProfe = $prof['color'];
                        //1. se verifica si este profesor ya tiene esa prof en ese curso
                        foreach ($objProfesor->direccionDeCurso($prof['Documento'], $anho,$cur['codCurso']) as $carga) {
                            $celdaProfe = $carga['ID'];                            
                        }

                        if($celdaProfe == ""){?>
                            <td class="celdaCuerpo ap" title="<?php echo $curso ?>" id="Cel<?php echo $cur['codCurso'].$prof['Documento'] ?>" onclick="asignarDir(<?php echo $cur['codCurso'] ?>,<?php echo $prof['Documento'] ?>,'<?php echo $colorProfe ?>')">                                     
                            </td> 
                        <?php

                        }else{ ?>
                         <td class="celdaCuerpo ap" title="<?php echo $curso." - ".$celdaNombreProfe ?>" style="background-color: <?php echo $colorProfe ?> " id="Cel<?php echo $cur['codCurso'].$prof['Documento'] ?>" onclick="quitarDir(<?php echo $cur['codCurso'] ?>,<?php echo $prof['Documento'] ?>,'<?php echo $colorProfe ?>')">
                        </td> 
                        <?php 
                        }
                    }
                    $cont++;
                }
                ?>
            </tbody> 
            <tfoot>
                <tr>
                    <th></th>
                    <th class='celdaTitulo'>PROFESORES</th>
                    <?php 
                        foreach ($listaCursos as $cur) {
                           if($cur['CODGRADO'] <= 11){  
                                echo "<th class='celdaCuerpo' id='dir".$cur['codCurso']."'>";
                                echo    $cur['CODGRADO']."°".$cur['grupo']."</th> ";
                                }
                        }
                        //me falta el ciclo para las asignaturas
                    ?>
                </tr>                
            </tfoot>
        </table>
    </div>
</dir>