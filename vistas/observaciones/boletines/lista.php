
<div class="x_panel">
    <div class="x_title seccion-cabecera">
      <h3>PLANILLA DE OBSERVACIONES PARA BOLETIN PERIODO <?php echo  $periodo ?></h3>
      <div class="clearfix"></div>
    </div>
    <div class="x_content box-profile">  
        <div class="row">
            <table class="table tblObservaciones" style="border: 1px solid #fefa">
                <thead>
                    <tr style="color:#fff; background-color: #095daf">
                        <th>No.</th>
                        <th>ESTUDIANTE</th>
                        <th>OBSERVACIONES</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach ($objEstudiante->listarCurso() as $estudiante) { 
                            $observacionTexto = "";
                            $opcion = 1;
                            $observacionId = 0;
                                            
                            $objObservacion = new observacionBoletin();
                            $objObservacion->idMatricula = $estudiante['idMatricula'];
                            $objObservacion->anho = $_POST['anho'];
                            $objObservacion->periodo = $_POST['periodo'];

                            foreach ($objObservacion->cargar() as $observacion) {
                                $observacionTexto = $observacion['observacion'];
                                $opcion = 2;
                                $observacionId = $observacion['id'];
                            }
                            
                            ?>
                        <tr>
                            <td style='padding:0px; margin: 0px; width:20px;'><?php echo $cont; ?></td>
                            <td style='padding:0px; margin: 0px; font-size:1.1em; font-weight: bold;'>
                                <?php 
                                    echo strtoupper($estudiante['PrimerApellido']." ".$estudiante['SegundoApellido']." ".$estudiante['PrimerNombre']." ".$estudiante['SegundoNombre']) 
                                ?>                    
                            </td>
                            <td style="margin: 0px; padding: 0px; width: 50%;">
                                <div style="margin: 0px; padding: 0px; width: 100%; height: 50px; overflow: hidden; ">
                                    <textarea name="" id="observacion<?php echo $estudiante['idMatricula'] ?>" cols="30" rows="5" class="form form-control" style="padding:2px; text-align:left; font-size:12px; overflow: auto;"><?php echo $observacionTexto; ?></textarea>                                      
                                </div>
                            </td>
                            <td  style='padding: 0px; margin: 0px; width:80px'>
                                <div class="guardando" style="position:relative;">
                                    <div class="cargando<?php echo $estudiante['idMatricula'] ?>"  style="background-color:#fff;display:none;width:100%;height:100%;z-index:1200;position:absolute;top:0px;">
                                        <img src="tools/load.gif" alt="" style="margin-left: 25%; width: 50%;">                                   
                                    </div> 
                                    <button class="btn btn-danger" onclick="eliminarObservacionBoletin('<?php echo $estudiante['idMatricula']; ?>','<?php echo $observacionId; ?>')"><i class="fa fa-trash"></i></button>
                                    <button class="btn btn-info" onclick="guardarObservacionBoletin('<?php echo $estudiante['idMatricula']; ?>','<?php echo $opcion; ?>','<?php echo $observacionId; ?>')"><i class="fa fa-save"></i></button>
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
            </table>            
        </div>
    </div>
</div>

