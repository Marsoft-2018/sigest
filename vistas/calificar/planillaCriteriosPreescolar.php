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

    <table class="table tblPlanilla" style="border: 1px solid #fefa">
        <thead>
            <tr style="color:#fff; background-color: #095daf">
                <th rowspan="2">No.</th>
                <th rowspan="2">CÓDIGO</th>
                <th rowspan="2">ESTUDIANTE</th>
                <th colspan="<?php echo $numCriterios+2 ?>" style="text-align: center; border-left: 1px solid #099daf; border-right: 1px solid #099daf; background-color: #079; " >CALIFICACIONES</th>
                <th rowspan="2">INASISTENCIAS</th>
                <th rowspan="2"></th>
            </tr>
            <tr>
            <?php 
                $nt = 1;
                foreach ($objCriterios->Listar() as $value) { 
                    ?>
                    <th style='border-left: 1px solid #099daf; color: #fff; background-color: #078; font-size:0.8em; text-align:center;'>
                        <?php echo $value['nomCriterio']; ?>                    
                    </th>
                <?php
                    $nt++;
                }
                ?>
                <th style='color: #fff; background-color: #098; text-align: center;' ><span title="Calificación definitiva en el periodo">Def.</span></th>
                <th style='color: #fff; background-color: #098; text-align: center;' >DESEMPEÑO</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                foreach ($objEstudiante->listarCurso() as $estudiante) { ?>
                <tr class="apuntado2" style="color:#000000;font-size: 1em; border-bottom:1px solid #cecece; height: 20px; padding: 0px;margin: 0px;">
                    <td style='padding:0px; margin: 0px; width:20px;'><?php echo $cont; ?></td>
                    <td style='padding:0px; margin: 0px; width:80px;'>
                        <?php echo $estudiante['idMatricula'] ?></td>
                    <td style='padding:0px; margin: 0px; font-size:1.1em; font-weight: bold; width: 32%;'>
                        <?php 
                            echo strtoupper($estudiante['PrimerApellido']." ".$estudiante['SegundoApellido']." ".$estudiante['PrimerNombre']." ".$estudiante['SegundoNombre']) 
                        ?>                    
                    </td>
                    <?php 
                    foreach ($objCriterios->Listar() as $value) { 
                    ?>
                    <td style='padding: 0px; width: 50px;'>                       
                        <div style='position:relative;'>
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
                                   $accionCampo = "agregarNotaCriterio(".$estudiante['idMatricula'].",this.value,".$value['codCriterio'].",'".$tabla."'".",'".$grado."')";
                                }else{
                                   $accionCampo = "modificarNotaCriterio(".$estudiante['idMatricula'].",this.value,".$value['codCriterio'].",'".$tabla."'".",'".$grado."')";
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
                            <img id="cargando<?php echo $value['codCriterio']."_".$estudiante['idMatricula'] ?>" src="tools/load.gif" alt="" style="background-color:#fff;display:none;width:100%;height:100%;float:left;z-index:1200;position:absolute;top:0px;">                
                        </div>
                    </td>
                    <?php 
                    } ?>
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
                        <input type='text' style="margin: 0px; height: 100%; background-color: #afAc;  font-size: 1.1em; font-weight: bold; padding: 5px;"  class="form form-control def<?php echo $estudiante['idMatricula'] ?>"
                            value ="<?php echo $nota ?>" 
                            id ="<?php echo $estudiante['idMatricula'] ?>" readonly>
                    </td>
                    <td  style='padding: 0px; margin: 0px; width: 10%;'>
                        <?php 
                            $des = "";
                            $color = "#000";
                            $fondo = "";
                            $objDesempeno = new Desempenos();
                            $objDesempeno->nota = $nota;
                            $des = $objDesempeno->cargar();
                        ?>
                        <div id="des<?php echo $estudiante['idMatricula'] ?>" style="display: flex; justify-content:flex-start; font-size: 1em;">
                            <div class="marcoDesempeno <?php echo $des; ?>" <?php if($grado <= 0){echo "style='font-size:0.8em;'"; } ?>
                                class="form form-control" >
                                <?php echo $des; ?>
                            </div>
                            <div <?php if($grado >0){echo "style='display:none;'"; } ?>>
                                <?php if($des != ""){ ?>
                                <img src="vistas/img/desempenos/<?php echo $des.".png";?>" alt="<?php echo $des.".png";?>" style="width: 30px;">
                                <?php }?>
                            </div>
                        </div>
                    </td>
                    <td  style='padding: 0px; margin: 0px;'>
                        <div style='height: 100%; margin: 0px; padding: 0px; width: 100%;'>
                            <input type='text' class='form form-control' style="text-align: center;" value='<?php echo $faltas ?>' id="<?php echo "ina".$estudiante['idMatricula'] ?>" onchange='modificarFalta(<?php echo $estudiante['idMatricula'] ?>,this.value)'>
                        </div>
                    </td>
                  <!--     <td style="height: 20px; padding: 0px; margin: 0px; width:70px;">
                        <button class="btn btn-info" style="margin: 0px;"  data-toggle="modal" data-target="#staticBackdrop" >
                            <i class="fa fa-language"> </i>Ver Logros
                        </button>
                      <div class="" style="text-align:left; font-size:9px; width: 100%; overflow: hidden;height: 25px;margin: 0px;" id="log<?php echo $estudiante['idMatricula'] ?>" >
                            <?php 
                                $objLogros = new Logro();
                                $objLogros->periodo = $_POST['periodo'];
                                $objLogros->codCurso = $_POST['curso'];
                                $objLogros->codArea = $_POST['codArea'];
                                $objLogros->tabla = $tabla;
                                $objLogros->calificacion = $nota;
                                //$objLogros->cargar();
                            ?>                        
                        </div>
                    </td> -->
                    <td style="padding: 0px;">
                        <button  type="button" class="btn btn-success" style="width: 100%; margin: 1px;" data-toggle="modal" data-target="#staticBackdrop" onclick="cargarNotasGuardadasEstudiante('<?php echo $estudiante['idMatricula'] ?>')" >
                            <i class="fa fa-gear"></i> Detalles
                        </button>
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

<div id="result"></div>