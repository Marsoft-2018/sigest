
<div class="x_panel">
    <div class="x_title seccion-cabecera">
      <h3>PLANILLA DE OBSERVACIONES PERIODO <?php echo  $periodo ?></h3>
      <div class="clearfix"></div>
    </div>
    <div class="x_content box-profile">  
        <div class="row">
            <table class="table tblObservaciones" style="border: 1px solid #fefa">
                <thead>
                    <tr style="color:#fff; background-color: #095daf">
                        <th>No.</th>
                        <th>ESTUDIANTE</th>
                        <th>ASISTENCIA</th>
                        <th>CUMPLIMIENTO</th>
                        <th>OBSERVACIONES</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach ($objEstudiante->listarCurso() as $estudiante) { ?>
                        <tr>
                            <td style='padding:0px; margin: 0px; width:20px;'><?php echo $cont; ?></td>
                            <td style='padding:0px; margin: 0px;'>
                                <?php 
                                    echo strtoupper($estudiante['PrimerApellido']." ".$estudiante['SegundoApellido']." ".$estudiante['PrimerNombre']." ".$estudiante['SegundoNombre']) 
                                ?>                    
                            </td>
                            <td style='padding: 0px; margin: 0px;'>                        
                                <div id = "txtNota$est[5]">
                                    <?php 
                                        
                                    ?>
                                    <select name="" id="asistencia<?php echo $estudiante['idMatricula'] ?>" class="form form-control">
                                        <option value="">Seleccione...</option>
                                        <option value="Es Puntual">Es Puntual</option>
                                        <option value="Llega retrasado">Llega retrasado</option>
                                        <option value="Falta algunas veces">Falta algunas veces</option>
                                        <option value="Falta con mucha frecuencia">Falta con mucha frecuencia</option>
                                        <option value="No asiste a clases">No asiste a clases</option>
                                    </select>        
                                                                            
                                </div>
                            </td>
                            <td  style="padding: 0px; margin: 0px;">
                                <select name="" id="cumplimiento<?php echo $estudiante['idMatricula'] ?>" class="form form-control">
                                    <option value="">Seleccione...</option>
                                    <option value="Entrega puntual cumpliendo con lo exigido">Entrega puntual cumpliendo con lo exigido</option>
                                    <option value="Entrega con retraso">Entrega con retraso</option>
                                    <option value="Entrega, pero no cumple con lo exigido">Entrega, pero no cumple con lo exigido</option>
                                    <option value="Pocas veces cumple con la entrega">Pocas veces cumple con la entrega</option>
                                    <option value="No entrega trabajos ni tareas">No entrega trabajos ni tareas</option>
                                </select>

                            </td>
                            <td style="margin: 0px; padding: 0px; width: 30%;">
                                <div style="margin: 0px; padding: 0px; width: 100%; height: 50px; overflow: hidden; ">
                                <textarea name="" id="observacion<?php echo $estudiante['idMatricula'] ?>" cols="30" rows="5" class="form form-control" style="padding:2px; text-align:left; font-size:12px; overflow: auto;"></textarea>  
                                    
                                </div>
                            </td>
                            <td  style='padding: 0px; margin: 0px;'>
                                <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                <button class="btn btn-info"><i class="fa fa-save"></i></button>
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

