
<div class="x_panel">
    <div class="x_title seccion-cabecera">
      <h3>PLANILLA DE NIVELACIÓN O RECUPERACIÓN </h3>
      <div class="clearfix"></div>

        <div style="font-size:12px; padding:2px; text-align:center; margin:0px;width: 100%; color: #095daf;">
            <?php
               /* echo "Escala de valoración:&nbsp;&nbsp;";
                $objD = new Desempenos();
                $listDes = $objD->Listar();
                foreach ($listDes as $key => $desemp) {
                    echo "<strong>".$desemp['CONCEPT']."</strong>: de ".$desemp['limiteInf']." hasta ".$desemp['limiteSup']."&nbsp;&nbsp;/&nbsp;&nbsp;";
                } */
            ?>  
        </div>
    </div>
    <div class="x_content box-profile">  
        <div class="row">
            <table class="table tblPlanilla" style="border: 1px solid #fefa; border-collapse: collapse;">
                <thead>
                    <tr style="color:#fff; background-color: #F08080">
                        <th rowspan="2">No.</th>
                        <th rowspan="2">CÓDIGO</th>
                        <th rowspan="2">ESTUDIANTE</th>
                        <th rowspan="2" colspan="2">CALIFICACION</th>
                        <th rowspan="2">DESEMPEÑO</th>
                        <th colspan="3">DATOS ACTA NIVELACION</th>
                        <th rowspan="2">OBSERVACION</th>
                        <th rowspan="2"></th>
                    </tr>
                    <tr>
                        <th>No. ACTA</th>
                        <th>DIA</th>
                        <th>MES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $cont = 1;
                        foreach ($obj->listaEstudiantes() as $estudiante) {
                            $nota = "";
                            $numActa= "";
                            $diaActa="";
                            $mesActa="";
                        if($estudiante['desempeno'] == "BAJO"){
                            $objCargado = new Nivelacion();
                            $objCargado->Anho = $_POST['anho'];
                            $objCargado->idMatricula = $estudiante['idMatricula'];
                            $objCargado->codArea = $_POST['codArea'];
                            foreach($objCargado->cargar() as $dato){
                                $nota = $dato['NOTA'];
                                $numActa= $dato['numActa'];
                                $diaActa= $dato['diaActa'];
                                $mesActa= $dato['mesActa'];
                            }
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
                            <td style='padding:0px; margin: 0px; font-size:11px; width: 30%;'>
                                <div class="ajustado">
                                    <?php 
                                        echo strtoupper($estudiante['PrimerApellido']." ".$estudiante['SegundoApellido']." ".$estudiante['PrimerNombre']." ".$estudiante['SegundoNombre']) 
                                    ?>                                    
                                </div>                    
                            </td>
                            <td style='margin: 0px; padding: 0px; width: 50px;'>    
                                <div id = "" style="margin: 0px; padding: 0px; height: 100%;" >
                                    <?php 
                                        /*
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
                                        }*/
                                    ?>
                                    <input type='text' class='form-control notaIn' value="<?php echo $nota ?>" id="nota<?php echo $estudiante['idMatricula'] ?>" onkeyup="cargarDesemp(this.id,this.value)" title="Por favor utilice el punto (.) como separador de decimales y no la coma">
                                    
                                </div>
                            </td>
                            <td  style='padding: 0px; margin: 0px; width: 20px; text-align: center;'>
                                <div class="ajustado eliminarNota" id='el<?php echo $estudiante['idMatricula'] ?>' onclick='eliminarNotaNivelacion(<?php echo $estudiante['idMatricula'] ?>)' style="<?php if($nota == ""){ echo $oculto; }elseif($nota > 0){ echo $visible; } ?>">
                                <i class='fa fa-trash' ></i>
                                    
                                </div>
                            </td>
                            <td  style='padding: 0px; margin: 0px;'>
                                <div class="ajustado" style='padding-left: 5px; margin: 0px;' id="des<?php echo $estudiante['idMatricula'] ?>">
                                    <?php 
                                       /* $objDesempeno = new Desempenos();
                                        $objDesempeno->nota = $nota;
                                        echo $objDesempeno->cargar();*/
                                    ?>
                                </div> 
                            </td>
                            <td style=" width: 50px;  margin: 0px;padding: 0px;">
                                <div>
                                    <input type='text' class='form-control' value="<?php echo $numActa ?>" id="numActa<?php echo $estudiante['idMatricula'] ?>" onchange="" >
                                </div>
                            </td>
                            <td  style='padding: 0px; margin: 0px;  width: 50px;'>
                                <input type='text' class='form-control' value="<?php echo $diaActa ?>" id="diaActa<?php echo $estudiante['idMatricula'] ?>" onchange="" >
                            </td>
                            <td  style='padding: 0px; margin: 0px;  width: 150px;'>
                                <select class='form-control' id="mesActa<?php echo $estudiante['idMatricula'] ?>" >
                                    <option value="Noviembre">Noviembre</option>
                                    <option value="Diciembre">Diciembre</option>
                                </select>
                            </td>
                            <td  style='padding: 0px; margin: 0px;'>
                                <input type='text' class='form-control' value="<?php echo $observacion ?>" id="observacion<?php echo $estudiante['idMatricula'] ?>" onchange="" >
                            </td>
                            <td   style='padding: 0px; margin: 0px;'><button class="btn btn-success" onclick="agregarNivelacion(<?php echo $estudiante['idMatricula'] ?>)" style="margin: 0px;"> Guardar </button></td> 
                        </tr>
                    <?php 
                        $cont++;
                        $des="";
                        $nota="";  
                        }
                    }
                    ?>
                </tbody>
            </table>            
        </div>
    </div>
</div>

