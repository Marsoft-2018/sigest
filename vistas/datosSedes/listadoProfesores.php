<?php 
if (isset($_POST['sede'])) {  
    session_start();  
    require('../../Modelo/Conect.php');
    require("../../Modelo/profesores.php");  
    $objProfe = new Profesor();
    $objProfe->codsede = $_POST['sede'];
}
   

?>
<table id="listadoProfe" class='display table table-striped table-hover no-footer'>
    <thead>
        <tr style='background-color:#2A6570;color:#fff;'>
            <th>No.</th>
            <th>Documento</th>
            <th>1er Nombre</th>
            <th>2do Nombre</th>
            <th>1er Apellido</th>
            <th>2do Apellido</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $cont = 1;
        foreach ($objProfe->listar() as $profe) { ?>
        <tr style="color:#000000; margin:0px; padding:0px; width:100%; border-bottom:1px solid #cecece;">
            <td style='text-align:center;'> <?php echo $cont ?></td>                                        
            <td><?php echo $profe['Documento'] ?></td>
            <td><?php echo $profe['PrimerNombre'] ?></td>
            <td><?php echo $profe['SegundoNombre'] ?></td>
            <td><?php echo $profe['PrimerApellido'] ?></td>                               
            <td><?php echo $profe['SegundoApellido'] ?></td>
            <td style='color:#000000; padding: 0px; text-align:center; font-size:11px; vertical-align:middle;'>
                <button type="button"   data-toggle="modal" data-target="#staticBackdrop" class="btn btn-info" id="<?php echo $profe['Documento'] ?>" title = "Editar <?php echo $profe['PrimerNombre'].' '.$profe['PrimerApellido'] ?>" class='iconosAcciones' onclick='editarProfesor(1,<?php echo $profe['Documento'] ?>)' style = "padding: 2px; margin: 0px;">
                    <i class="fa fa-pencil"></i>
                </button>
                <button class="btn btn-danger"  id="<?php echo $profe['Documento'] ?>" onclick='eliminarProfesor(this.id)' style = "padding: 2px; margin: 0px;" title='Eliminar Profesor $registro[1] $registro[3]'>
                    <i class="fa fa-trash"></i>
                </button>
            </td>   
        </tr>
        <?php 
            $cont++;
        }
        ?>
    </tbody> 
</table> 