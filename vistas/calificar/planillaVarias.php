<?php 
    $objCriterios = new Criterio();
    $numCriterios = $objCriterios->conteoCriterios();
    $objArea = new Area();
    $objArea->curso = $_POST['curso'];
    $objArea->anho = $_POST['anho'];
    $tabla = "Asignatura";
    foreach ($objArea->cargarTodasLasAreas() as $value) {
        if($value['id'] == $_POST['codArea']){
            $tabla = $value['tipo'];
        }        
    }
    // echo "Tabla: ".$tabla." Area: ".$_POST['codArea']." | curso: ".$objArea->curso."| año: ".$objArea->anho." | periodo: ".$periodo;
?>

<form action="" onsubmit="return guardarNotasVarias()" id="formPlanilla">
    <table class="table tblPlanilla" style="border: 1px solid #fefa">
        <thead>
            <tr style="color:#fff; background-color: #095daf">
                <th rowspan="2">No.</th>
                <th rowspan="2">CÓDIGO</th>
                <th rowspan="2">ESTUDIANTE</th>
                <th colspan="<?php echo $numCriterios+2 ?>" style="text-align: center; border-left: 1px solid #099daf; border-right: 1px solid #099daf; background-color: #079; " >CALIFICACIONES</th>
                <th rowspan="2">DESEMPEÑO</th>
                <th rowspan="2">LOGROS CARGADOS</th>
                <th rowspan="2">INASISTENCIAS</th>
            </tr>
            <tr>
                <?php 
                foreach ($objCriterios->Listar() as $value) {
                    echo "<th style='border-left: 1px solid #099daf; color: #fff; background-color: #078; font-size:0.8em;'>Nota: ".$value['nomCriterio']."</th>";
                }
                // for ($i=1; $i <= $numCriterios; $i++) { 
                    
                // }
                ?>
                <th style='color: #fff; background-color: #098;' colspan="2"><span title="Calificación definitiva en el periodo">Def.</span></th>
            </tr>
        </thead>
        <tbody>
            <?php 
                foreach ($objEstudiante->listarCurso() as $estudiante) { ?>
                <tr class="apuntado2" style="color:#000000;font-size: 11px; border-bottom:1px solid #cecece; height: 20px; padding: 0px;margin: 0px;">
                    <td style='padding:0px; margin: 0px; width:20px;'><?php echo $cont; ?></td>
                    <td style='padding:0px; margin: 0px; width:80px;font-size:12px;'><?php echo $estudiante['idMatricula'] ?></td>
                    <td style='padding:0px; margin: 0px; font-size:11px; width: 30%;'>
                        <?php 
                            echo strtoupper($estudiante['PrimerApellido']." ".$estudiante['SegundoApellido']." ".$estudiante['PrimerNombre']." ".$estudiante['SegundoNombre']) 
                        ?>                    
                    </td>
                    <?php 
                    foreach ($objCriterios->Listar() as $value) { ?>
                    <td style='padding: 0px; width: 50px;'>                       
                        <div id = "txtNota$est[5]">
                            <?php 
                                $notaCriterio = "";
                                $objNotaCriterio = new Calificacion();
                                $objNotaCriterio->periodo = $_POST['periodo'];
                                $objNotaCriterio->idMatricula = $estudiante['idMatricula'];
                                $objNotaCriterio->codArea = $codArea;
                                $objNotaCriterio->Anho = $_POST['anho'];
                                $objNotaCriterio->curso = $_POST['curso'];
                                $objNotaCriterio->tabla = $tabla;
                                $objNotaCriterio->idCriterio = $value['codCriterio'];

                                $notaCriterio = $objNotaCriterio->cargarPorCriterio();
                                if($notaCriterio == ""){
                                   $accionCampo = "agregarNotaCriterio(".$estudiante['idMatricula'].",this.value,".$value['codCriterio'].",'".$tabla."')";
                                }else{
                                   $accionCampo = "modificarNotaCriterio(".$estudiante['idMatricula'].",this.value,".$value['codCriterio'].",'".$tabla."')";
                                }
                            ?>
                            <input type ='text' 
                                class ='form-control <?php echo $estudiante['idMatricula'] ?> criterios<?php echo $estudiante['idMatricula'] ?>'
                                style ="margin: 0px; height: 100%;"  
                                value ="<?php echo $notaCriterio; ?>" 
                                id ="<?php echo $value['codCriterio']."_".$estudiante['idMatricula'] ?>" 
                                onchange ="<?php echo $accionCampo ?>" 
                                
                                name ="notas[]"
                            >                   
                        </div>
                    </td>
                    <?php } ?>
                    <td  style='padding: 0px; width: 50px;'>
                        <!-- Nota definitiva -->
                        <?php 
                            $nota = "";
                            $faltas = 0;
                            $objCalificacion = new Calificacion();
                            $objCalificacion->periodo = $periodo;
                            $objCalificacion->idMatricula = $estudiante['idMatricula'];
                            $objCalificacion->codArea = $codArea;
                            $objCalificacion->Anho = $_POST['anho'];
                            $objCalificacion->curso = $_POST['curso'];
                            $objCalificacion->tabla = $tabla;

                            foreach ($objCalificacion->cargar() as $notaArea) {
                                $nota = $notaArea['NOTA'];
                                $faltas =  $notaArea['Faltas'];
                            }     

                            if($nota == "")               {
                               // $accionCampo = "agregarNota(".$estudiante['idMatricula'].",this.value)";
                            }else{
                               // $accionCampo = "modificarNota(".$estudiante['idMatricula'].",this.value)";
                            }
                        ?>
                        <input type='text' 
                            style="margin: 0px; height: 100%; background-color: #afAc;  font-size: 1.3em; padding: 5px;" 
                            class='form-control def<?php echo $estudiante['idMatricula'] ?>' 
                            value ="<?php echo $nota ?>" 
                            id ="<?php echo $estudiante['idMatricula'] ?>" readonly>
                    </td>
                    <td  style='padding: 0px; margin: 0px; width: 20px; text-align: center;'>
                        <i class='fa fa-trash eliminarNota' 
                            id='el<?php echo $estudiante['idMatricula'] ?>' 
                            onclick='eliminarNota(<?php echo $estudiante['idMatricula'] ?>,1)' 
                            style="<?php if($nota == ""){ echo $oculto; }elseif($nota > 0){ echo $visible; } ?> padding-top: 6px; padding-bottom: 5px;" 
                            title ="Eliminar calificación"

                            ></i>
                    </td>
                    <td  style='padding: 0px; margin: 0px;'>
                        <?php 
                            $des = "";
                            $color = "#000";
                            $fondo = "";
                            $objDesempeno = new Desempenos();
                            $objDesempeno->nota = $nota;
                            $des = $objDesempeno->cargar();
                            if ($des == "BAJO") {
                                $color = "#fff";
                                $fondo = "#ff0000";
                            }
                        ?>
                        <div  style='width:100%; padding: 5px; margin: 0px; background-color: <?php echo $fondo; ?>; color: <?php echo $color; ?>' id="des<?php echo $estudiante['idMatricula'] ?>">
                            <?php 
                               echo $des; 
                            ?>
                        </div> 
                    </td>
                    <td style="width:30%; height: 20px; padding: 0px; margin: 0px;">
                        <div class="" style="text-align:left; font-size:9px; width: 100%; overflow: hidden;height: 25px;margin: 0px;" id="log<?php echo $estudiante['idMatricula'] ?>" >
                            <?php 
                                $objLogros = new Logro();
                                $objLogros->periodo = $_POST['periodo'];
                                $objLogros->codCurso = $_POST['curso'];
                                $objLogros->codArea = $_POST['codArea'];
                                $objLogros->tabla = $tabla;
                                $objLogros->calificacion = $nota;
                                $objLogros->cargar();
                            ?>                        
                        </div>
                    </td>
                    <td  style='padding: 0px; width: 50px; height: 20px; margin: 0px;'>
                        <div style='height: 100%; margin: 0px; padding: 0px; width: 100%;'>
                            <input type='text' class='form-control' style='padding: 5px; text-align:center; margin:0px; height: 100%;' value='<?php echo $faltas ?>' id="<?php echo "ina".$estudiante['idMatricula'] ?>" onchange='modificarFalta(<?php echo $estudiante['idMatricula'] ?>,this.value)'>
                        </div>
                    </td>
                </tr>
            <?php 
                $cont++;
                $des="";
                $nota="";  
            }
            ?>
        </tbody>
        <tfoot>
        </tfoot>
    </table>    
</form>
<div id="result"></div>