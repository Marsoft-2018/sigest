<?php 
if (isset($_POST['sede'])) {  
    session_start();  
    require('../../Modelo/Conect.php');
    require("../../Modelo/profesores.php");  
    require("../../Modelo/excepcionesPeriodos.php");  

    $objProfe = new Profesor();
    $objProfe->codsede = $_POST['sede'];

    $periodo =  $_POST['periodo'];
    $accion = "";
}
   

?>
<table id="listadoProfe" class='display table table-striped table-hover no-footer'>
    <thead>
        <tr style='background-color:#2A6570;color:#fff;'>
            <th>No.</th>
            <th>DOCENTE</th>
            <th>Fecha de inicio</th>
            <th>Fecha de Cierre</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $cont = 1;
        foreach ($objProfe->listar() as $profe) {  
            $accion = 'guardarExcepcion('.$profe['IDUsuario'].','.$periodo .')';         
            $fechaInicio = "";
            $fechaCierre  = "";
            $objExcep = new excepcionPeriodo();
            $objExcep->periodo = $periodo;
            $objExcep->anho = $_POST['anho'];
            $objExcep->idUsuario = $profe['IDUsuario'];
            foreach ($objExcep->cargar() as $value) {
                $fechaInicio = $value['fechaInicio'];
                $fechaCierre  = $value['fechaCierre'];
                $accion = 'modificarExcepcion('.$profe['IDUsuario'].','.$periodo .')';     
            }
        ?>
        <tr >
            <td  style="text-align:center; color:#cecece; margin:0px; padding:0px;"> <?php echo $cont ?></td>
            <td style="color:#000000; margin:0px; padding:0px; width:50%;">
                <?php echo $profe['PrimerNombre']." ".$profe['SegundoNombre']." ".$profe['PrimerApellido']." ".$profe['SegundoApellido'] ?>                
            </td>
            <td style="color:#000000; margin:0px; padding:0px;">
                <input type="date" class="form form-control" id="FI<?php echo $profe['IDUsuario'] ?>" value="<?php echo $fechaInicio ; ?>">
            </td>   
            <td  style="color:#000000; margin:0px; padding:0px;">
                <input type="date" class="form form-control" id="FC<?php echo $profe['IDUsuario'] ?>" value="<?php echo $fechaCierre; ?>">
            </td>
            <td  style="margin:0px; padding:0px;">
                <button class="btn btn-success" id="add<?php echo $profe['IDUsuario'] ?>" onclick="<?php echo $accion ?>">
                    <i class="fa fa-save"></i>
                </button>
                <button class="btn btn-danger" id="rem<?php echo $profe['IDUsuario'] ?>" onclick="eliminarExcepcion(<?php echo $profe['IDUsuario'] ?>,<?php echo $periodo ?>)">
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