<?php 
  
  require("../../Modelo/Conect.php");  
  require("../../Modelo/Estudiante.php");

  $objEstudiante = new Estudiante();
  $objEstudiante->sede = $_POST['sede'];
  $objEstudiante->curso = $_POST['curso'];
  $objEstudiante->anho = $_POST['anho'];
  $grado;
?>

<!-- if($curso == "Todos"){
                $resultEstudiante=mysql_query("SELECT est.Documento,est.PrimerNombre,est.SegundoNombre,est.PrimerApellido,est.`SegundoApellido`,est.`sexo`,cur.`CODGRADO`,cur.`grupo`,j.`abreviatura` AS 'jornada' ,mt.`estado`, mt.`idMatricula`, mt.`anho`,s.`CODINST` FROM estudiantes est INNER JOIN matriculas mt ON mt.`Documento` = est.`Documento` INNER JOIN sedes s ON mt.codsede = s.CODSEDE INNER JOIN cursos cur ON mt.`Curso`=cur.`codCurso` INNER JOIN jornadas j ON j.`idJornada`=cur.`idJornada` WHERE mt.CODSEDE='$sede' AND mt.`anho`='$anho'  ORDER BY  cur.`CODGRADO`,cur.`grupo`,est.PrimerApellido,est.SegundoApellido,est.PrimerNombre,est.SegundoNombre ASC;") or die ("Error al Consultar a los Estudiantes");
            }else{
                $resultEstudiante=mysql_query("SELECT est.`Documento`,est.`PrimerNombre`,est.`SegundoNombre`,est.`PrimerApellido`,est.`SegundoApellido`,est.`sexo`,cur.`CODGRADO`,cur.`grupo`,j.`abreviatura` AS 'jornada' ,mt.`estado`, mt.`idMatricula`, mt.`anho`,s.`CODINST` FROM estudiantes est INNER JOIN matriculas mt ON mt.`Documento` = est.`Documento` INNER JOIN sedes s ON mt.codsede = s.CODSEDE INNER JOIN cursos cur ON mt.`Curso`=cur.`codCurso` INNER JOIN jornadas j ON j.`idJornada`=cur.`idJornada` WHERE mt.CODSEDE='$sede' AND mt.`Curso`='$curso' AND mt.`anho`='$anho'  ORDER BY  cur.`CODGRADO`,cur.`grupo`,est.PrimerApellido,est.SegundoApellido,est.PrimerNombre,est.SegundoNombre ASC;") or die ("Error al Consultar a los Estudiantes");
            }
            
            $cont=1; -->
<table class="display table table-striped table-hover dataTable no-footer">
    <thead>
        <tr style="background-color:#569C38; color:#fff;">
            <th>No. Lista</th>
            <th>Cod.</th>
            <th>Documento</th>
            <th>1er Nombre</th>
            <th>2do Nombre</th>
            <th>1er Apellido</th>
            <th>2do Apellido</th>
            <th>Sexo</th>
            <th>Curso</th>
            <th>Jornada</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $cont = 1;
            foreach ($objEstudiante->Listar() as $estudiante) { 
                if($estudiante['CODGRADO'] <= 0){
                    $grado = $estudiante['NOMGRADO'];
                }else{
                    $grado = $estudiante['CODGRADO']."°".$estudiante['grupo'];
                }
            ?>
               
                  
        <tr style="color:#000000; margin:0px; padding:0px; width:100%; border-bottom:1px solid #cecece;">
            <td style='text-align:center;'><?php echo $cont ?></td>                                     
            <td> <?php echo $estudiante['num_interno'] ?> </td>                                      
            <td> <?php echo $estudiante['Documento'] ?> </td>
            <td> <?php echo $estudiante['PrimerNombre'] ?> </td>
            <td> <?php echo $estudiante['SegundoNombre'] ?> </td>
            <td> <?php echo $estudiante['PrimerApellido'] ?> </td>                             
            <td> <?php echo $estudiante['SegundoApellido'] ?> </td>
            <td style='text-align:center;'><?php echo $estudiante['sexo'] ?> </td>                                
            <td style='text-align:center;'><?php echo $grado ?> </td>
            <td style='text-align:center;'><?php echo $estudiante['jornada'] ?> </td>
            <?php 
                if($estudiante['estado'] == "Retirado" || $estudiante['estado'] == "Eliminado" ){
                    echo "<td style='color:#fe1510;'> ".$estudiante['estado']." </td>";
                }else{
                    echo "<td> ".$estudiante['estado']." </td>";
                } 
            ?> 
            <td style="color:#000000; padding: 0px; text-align:center; font-size:11px; vertical-align:middle;width:30px;">
                <div class="row">
                    <div class="col-3">
                        <button type="button" data-toggle="modal" data-target="#staticBackdrop" class = "btn btn-warning iconosAcciones hvr-rectangle-in" title="Editar estudiante <?php echo $estudiante['PrimerNombre'] ?>" id = "<?php echo  $estudiante['Documento'] ?>" style="color: #fff; padding: 3px; margin-right: 1px; text-align:center; font-size:11px; vertical-align: middle; display: inline-block; float: left;" onclick="editarEstudiante(2,<?php echo  $estudiante['Documento'] ?>,<?php echo $estudiante['idMatricula'] ?>)" >
                            <i class='fa fa-pencil'></i>
                        </button>                  
                    </div>
                    <div class="col-3">
                        <button type="button"  data-toggle="modal" data-target="#staticBackdrop" class = "btn btn-primary hvr-rectangle-in" title="Agregar nueva matricula" id="<?php echo $estudiante['Documento'] ?>" onclick ="nuevaMatricula(2,<?php echo $estudiante['Documento'] ?>,<?php echo $estudiante['anho'] ?>,<?php echo $objEstudiante->sede ?>)" style="color: #fff; padding: 3px; margin-right: 1px; text-align:center; font-size:11px; vertical-align: middle; display: inline-block; float: left;" >
                            <i class='fa fa-plus'></i>
                        </button>                        
                    </div>
                    <div class="col-3">
                        <button class = "btn btn-danger hvr-rectangle-in" title="Agregar nueva matricula <?php echo $estudiante['PrimerNombre'] ?> " id=" <?php echo $estudiante['Documento'] ?>" style="color: #fff; padding: 3px; margin-right: 1px; text-align:center; font-size:11px; vertical-align: middle; display: inline-block; float: left;"  onclick="eliminarEstudiante(this.id,<?php echo $estudiante['idMatricula'] ?>)" >
                            <i class="fa fa-trash"></i>
                        </button>
                        <?php                             
                            if($estudiante['estado'] == "Eliminado" ){ ?>
                                <button class='btn btn-primary hvr-rectangle-in' 
                                    id = "<?php echo $estudiante['Documento'] ?>"
                                    title = "Restaurar Estudiante <?php echo $estudiante['PrimerNombre']." ".$estudiante['PrimerApellido'] ?>"
                                    style="color: #fff; padding: 3px; margin-right: 1px; text-align:center; font-size:11px; vertical-align: middle; display: inline-block; float: left;"
                                    onclick = "restaurarEstudiante(<?php echo $estudiante['idMatricula'] ?>)">
                                        <i class='fa fa-refresh'></i>
                                    </button>
                        <?php }  ?>                             
                     </div>
                </div>
            </td>
        </tr> 
        <?php $cont++; } ?>   
    </tbody>
</table>