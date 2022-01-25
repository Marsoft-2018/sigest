
<div class="x_panel">
    <div class="x_title seccion-cabecera">
      <h3>PLANILLA DE CALIFICACIÓN DEFINITIVA PARA EL PERIODO <?php echo  $periodo ?></h3>
      <div class="clearfix"></div>

        <div style="font-size:12px; padding:2px; text-align:center; margin:0px;width: 100%; color: #095daf;">
            <?php
                echo "Escala de valoración:&nbsp;&nbsp;";
                $objD = new Desempenos();
                $listDes = $objD->Listar();
                foreach ($listDes as $key => $desemp) {
                    echo "<strong>".$desemp['CONCEPT']."</strong>: de ".$desemp['limiteInf']." hasta ".$desemp['limiteSup']."&nbsp;&nbsp;/&nbsp;&nbsp;";
                } 
            ?>  
        </div>
    </div>
    <div class="x_content box-profile">  
        <div class="row">
            <table class="table tblPlanilla" style="border: 1px solid #fefa;border-collapse: collapse;">
                <thead>
                    <tr style="color:#fff; background-color: #095daf">
                        <th>No.</th>
                        <th>CÓDIGO</th>
                        <th>ESTUDIANTE</th>
                        <th>CALIFICACION</th>
                        <th></th>
                        <th>DESEMPEÑO</th>
                        <th>LOGRO</th>
                        <th>INASISTENCIAS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach ($objEstudiante->listarCurso() as $estudiante) { 
                            $faltas = "";
                        ?>
                        <tr class="apuntado2" style="color:#000000; font-size: 11px; border-bottom:1px solid #cecece; height: 20px; padding: 0px; margin: 0px;">
                            <td style='padding:0px; margin: 0px; width:20px; text-align: center;'>
                                <div class="ajustado">
                                    <?php echo $cont; ?>
                                </div>
                            </td>
                            <td style='padding:0px; margin: 0px; width:80px;font-size:12px;'>
                                <div class="ajustado">
                                <?php echo $estudiante['idMatricula'] ?>
                                </div>
                            </td>
                            <td style='padding:0px; margin: 0px; font-size:11px; width: 20%;'>
                                <div class="ajustado">
                                    <?php 
                                        echo strtoupper($estudiante['PrimerApellido']." ".$estudiante['SegundoApellido']." ".$estudiante['PrimerNombre']." ".$estudiante['SegundoNombre']) 
                                    ?>                                    
                                </div>                    
                            </td>
                            <td style='margin: 0px; padding: 0px; width: 50px;'>    
                                <div id = "txtNota$est[5]" style="margin: 0px; padding: 0px; height: 100%;" >
                                    <?php 
                                        
                                        $objCalificacion = new Calificacion();
                                        $objCalificacion->periodo = $periodo;
                                        $objCalificacion->idMatricula = $estudiante['idMatricula'];
                                        $objCalificacion->codArea = $codArea;
                                        $objCalificacion->Anho = $_POST['anho'];
                                        $objCalificacion->curso = $_POST['curso'];

                                        foreach ($objCalificacion->cargar() as $notaArea) {
                                            $nota = $notaArea['NOTA'];
                                            $faltas = $notaArea['Faltas'];
                                        }     

                                        if($nota == "")               {
                                            $accionCampo = "agregarNota(".$estudiante['idMatricula'].",this.value)";
                                        }else{
                                            $accionCampo = "modificarNota(".$estudiante['idMatricula'].",this.value)";
                                        }
                                    ?>
                                    <input type='text' class='form-control notaIn' value="<?php echo $nota ?>" id="<?php echo $estudiante['idMatricula'] ?>" onchange="<?php echo $accionCampo ?>" onkeyup="cargarDesemp(this.id,this.value), cargarLogro(this.id,this.value), mostrarInasistencias(this.id)" title="Por favor utilice el punto (.) como separador de decimales y no la coma">
                                    
                                </div>
                            </td>
                            <td  style='padding: 0px; margin: 0px; width: 20px; text-align: center;'>
                                <div class="ajustado eliminarNota" id='el<?php echo $estudiante['idMatricula'] ?>' onclick='eliminarNota(<?php echo $estudiante['idMatricula'] ?>,1)' style="<?php if($nota == ""){ echo $oculto; }elseif($nota > 0){ echo $visible; } ?>">
                                <i class='fa fa-trash' ></i>
                                    
                                </div>
                            </td>
                            <td  style='padding: 0px; margin: 0px;'>
                                <div class="ajustado" style='padding-left: 5px; margin: 0px;' id="des<?php echo $estudiante['idMatricula'] ?>">
                                    <?php 
                                        $objDesempeno = new Desempenos();
                                        $objDesempeno->nota = $nota;
                                        echo $objDesempeno->cargar();
                                    ?>
                                </div> 
                            </td>
                            <td style="width: 50%; overflow: hidden;margin: 0px;padding: 0px;">
                                <div class="logro" id="log<?php echo $estudiante['idMatricula'] ?>" >
                                    <?php 
                                        $objLogros = new Logro();
                                        $objLogros->periodo = $_POST['periodo'];
                                        $objLogros->codCurso = $_POST['curso'];
                                        $objLogros->codArea = $_POST['codArea'];
                                        $objLogros->calificacion = $nota;
                                        $objLogros->cargar();
                                    ?>                        
                                </div>
                            </td>
                            <td  style='padding: 0px; margin: 0px;  width: 50px;'>
                                <input type='text' value="<?php echo $faltas ?>" class='form-control faltas' style='<?php if($nota == ""){ echo $oculto; }elseif($nota > 0){ echo $visible; } ?>' value='' id="<?php echo "ina".$estudiante['idMatricula'] ?>" onchange='modificarFalta(<?php echo $estudiante['idMatricula'] ?>,this.value)'>
                                
                            </td>
                        </tr>
                    <?php 
                        $cont++;
                        $des="";
                        $nota="";  
                    }
                    ?>
                </tbody>
            </table>            
        </div>
    </div>
</div>

