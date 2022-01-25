<?php 
    $objProfesores = new Profesor();
    $objCargaAcademica = new cargaAcademica();
    $objAreas = new Area();
    $objCurso = new Curso();
    $objCurso->codSede = $_POST['sede'];
    $objProfesores->codsede = $_POST['sede'];
    $objCargaAcademica->anho = $_POST['anho'];
    $objCargaAcademica->codsede = $_POST['sede'];
    $objAreas->anho = $_POST['anho'];
    $objAreas->codSede = $_POST['sede'];
    $listaAreas = $objAreas->listar();
    $listaCursos = $objCurso->listaXsedes();
    $listaProfesores = $objProfesores->Listar();
?>
<dir class="row">
    <div class="col-md-9">
        <table id='sudoku' class='table sudoku' >
            <thead>
                <tr>
                    <th class='celdaTitulo'>ÁREAS | ASIGNATURAS</th>
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
                foreach ($listaAreas as $area) {                    
                    $numDir = 0;
                    $claseDir = "";

                    echo "<tr class='apuntado'>";
                    echo "<th title='".$area['Nombre']."' class='filaProfe'>".$area['Abreviatura']." - ".$area['Nombre']."</th>"; 
                    //Recorrido de las areas nuevamente
                    foreach ($listaCursos as $cur) {
                       //En esta parte se verifica que tipo de input se coloca verificacndo la tabla cargaAcademica
                        $objCarga = new cargaAcademica();
                        $objCarga->codCurso = $cur['codCurso'];
                        $objCarga->codigoA = $area['id'];
                        $objCarga->anho = $anho;

                        $conteoReg = 0;
                        $celdaProfe = "";
                        $colorProfe = "";
                        //1. se verifica si este profesor ya tiene esa area en ese curso
                        foreach ($objCarga->cargarCelda() as $carga) {
                            $celdaProfe = $carga['IDUsuario'];
                            $celdaNombreProfe = $carga['nombre'];
                            $colorProfe = $carga['color'];
                        }
                        if($celdaProfe == ""){?>
                            <td class = "celdaCuerpo ap" 
                                title = "<?php echo $cur['CODGRADO']."°".$cur['grupo'] ?>" 
                                id = "Cel<?php echo $cur['codCurso'].$area['id'] ?>" 
                                onclick = "asignar(<?php echo $cur['codCurso'] ?>,<?php echo $area['id'] ?>,0)">                                     
                            </td> 
                        <?php

                        }else{ ?>
                         <td class = "celdaCuerpo ap" 
                            title = "<?php echo $celdaNombreProfe ?>" 
                            style = "background-color: <?php echo $colorProfe ?>" 
                            id = "Cel<?php echo $cur['codCurso'].$area['id'] ?>" 
                            onclick = "quitar(<?php echo $cur['codCurso'] ?>,<?php echo $area['id'] ?>,0,<?php echo $celdaProfe ?>)"> 
                        </td> 
                        <?php 
                        }
                    }
                    echo "</tr>";
                    //filas para las asignaturas del área
                    $objAsignatura = new Asignatura();
                    $objAsignatura->idArea = $area['id'];
                    foreach ($objAsignatura->listar() as $value) {
                        echo "<tr class='apuntado'>";
                        echo "<th title='Área: ".$area['Nombre']." | ".$value['Nombre']."' class='filaAsignatura'>".$area['Abreviatura']." | ".$value['Abreviatura']." - ".$value['Nombre']."</th>"; 
                        foreach ($listaCursos as $cur) {
                           //En esta parte se verifica que tipo de input se coloca verificacndo la tabla cargaAcademica
                            $objCarga = new cargaAcademica();
                            $objCarga->codCurso = $cur['codCurso'];
                            $objCarga->codigoA = $value['id'];
                            $objCarga->anho = $anho;

                            $conteoReg = 0;
                            $celdaProfe = "";
                            $colorProfe = "";
                            //1. se verifica si este profesor ya tiene esa area en ese curso
                            foreach ($objCarga->cargarCelda() as $carga) {
                                $celdaProfe = $carga['IDUsuario'];
                                $celdaNombreProfe = $carga['nombre'];
                                $colorProfe = $carga['color'];
                            }
                            if($celdaProfe == ""){ ?>
                                <td class = "celdaCuerpo ap" 
                                    title = "<?php echo $cur['CODGRADO']."°".$cur['grupo'] ?>" 
                                    id = "Cel<?php echo $cur['codCurso'].$value['id'] ?>" 
                                    onclick = "asignar(<?php echo $cur['codCurso'] ?>,0,<?php echo $value['id'] ?>)">                                     
                                </td> 
                            <?php

                            }else{ ?>
                                <td class = "celdaCuerpo ap" 
                                    title = "<?php echo $celdaNombreProfe ?>" 
                                    style = "background-color: <?php echo $colorProfe ?> " 
                                    id = "Cel<?php echo $cur['codCurso'].$value['id'] ?>" 
                                    onclick = "quitar(<?php echo $cur['codCurso'] ?>,0,<?php echo $value['id'] ?>,<?php echo $celdaProfe ?>)">
                                </td> 
                            <?php 
                            }
                        }
                        echo "</tr>";
                    }

                }
                ?>
            </tbody> 
            <tfoot>
                <tr>
                    <th class='celdaTitulo'>ÁREAS | ASIGNATURAS</th>
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
    <div class="col-md-3">
        <table class="table table-striped">
            <thead><tr><td>Sel</td><td>Color</td><td>PROFESORES</td><td></td></tr></thead>
                <?php  

                foreach ($listaProfesores as $prof) {                    
                    echo " <tr class='apuntado'>
                                <td>
                                    <input type='radio' id='".$prof['IDUsuario']."' name='profe' value='".$prof['IDUsuario']."'  onclick='marcarProfesor(\"".$prof['color']."\",\"".$prof['IDUsuario']."\")' >                                
                                </td>
                                <td style='padding:0px;'>
                                    <div class='btn' style='padding:10px; background-color: ".$prof['color'].";' id='".$prof['color']."' title='".$prof['IDUsuario']."' onclick='marcarProfesor(\"".$prof['color']."\",\"".$prof['IDUsuario']."\")'>
                        
                                    </div>
                                </td>
                                <td style='padding:0px;'>
                                    <button type='button' class='btn btn-default'  style='text-align: left; width: 100%; padding:5px; color: #fff; background-color: ".$prof['color'].";' data-toggle='modal' data-target='#staticBackdrop' id='".$prof['IDUsuario']."' onclick='editarProfesor(1,this.id)'>
                                        ".strtoupper($prof['PrimerNombre']." ".$prof['SegundoNombre']." ".$prof['PrimerApellido']." ".$prof['SegundoApellido'])."
                                    </button>
                                </td>
                                <td style='padding:0px;'>
                                    <button type='button' class='btn btn-warning' style='width: 100%; padding:5px;' data-toggle='modal' data-target='#staticBackdrop' id='".$prof['IDUsuario']."' onclick='verCargaAcademicaProfesor(1,this.id)'>
                                        <i class='fa fa-file'></i>
                                    </button>
                                </td>
                            </tr>";
                }
                ?>
            
        </table>   
        <div id='pruebas'></div>
        <!-- <?php  
        echo "<select multiple id='profesor' class='form form-control'>";
        echo "<option value=''>Sel...</option>";
        foreach ($listaProfesores as $prof) {
            echo "<option value='".$prof['IDUsuario']."'>".strtoupper($prof['PrimerNombre']." ".$prof['SegundoNombre']." ".$prof['PrimerApellido']." ".$prof['SegundoApellido'])."</option>";
        }
        echo "</select>";
        ?> -->
    </div>
</dir>
