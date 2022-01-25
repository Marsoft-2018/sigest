
<?php
    session_start();
    require("../../Modelo/Conect.php");
    require("../../Modelo/areas.php");
    require("../../Modelo/logros.php");
    
    $objIndicador = new Logro(); 
    $objArea = new Area();
    $objArea->curso = $_POST['curso'];
    $objArea->anho = $_POST['anho'];
    /*
    foreach ($objArea->cargarTodasLasAreas() as $value) {
        if($value['id'] == $_POST['area']){
            $tabla = $value['tipo'];
        }        
    }
    */
    $objIndicador->tabla = $tabla;
    $objIndicador->codArea  = $_POST['area'];
    $objIndicador->periodo  = $_POST['periodo'];
    $objIndicador->codCurso = $_POST['curso'];
?>


<table class='table table-striped'>
    <thead>
        <th>ID</th>            
        <th>Aspecto</th>
        <th>Materia</th>
        <th>Periodo</th>
        <th>IDICADOR DEL LOGRO</th>
        <th colspan='2'>Acciones</th>
        <th>Estado</th>
    </thead>
    <tbody>
        <?php foreach ($objIndicador->cargarLista() as $log) {  ?>
            

        <tr>
            <td><?php echo $log['CODIND'] ?></td>
            <td><?php echo $log['nomCriterio'] ?> </td>
            <td><?php echo $log['abreviatura'] ?> </td>
            <td><?php echo $log['periodo'] ?> </td>
            <td style='font-size:10px;'><?php echo strtoupper($log['INDICADOR']) ?></td>
            <td >
                <span id="<?php echo $log['CODIND'] ?>" title="Editar Indicador" onclick="cargarEdicionLogro(this.id)" style="padding: 0px; text-align:center;font-size: 20px;color:blue;"><i class="fa fa-pencil"></i></span>
            </td>
            <td >
                <span id="<?php echo $log['CODIND'] ?>" title="Eliminar Indicador" onclick="eliminarIndicador(this.id)" style="padding: 0px; text-align:center;font-size: 20px;color:red;"><i class='fa fa-trash'></i></span>
            </td>
            <td style='text-align:center;' >
                <div id = "estadoLogro<?php echo $log['CODIND'] ?>">
                <?php if ($log['estado'] == 1){ ?>
                
                    <span  id='<?php echo $log['CODIND'] ?>' style='padding: 0px; text-align:center;font-size: 20px;color:green;' title='Logro Activo: El logro en este estado será utilizado en los desempeños calificados' onclick='cambiarEstadoLogro(<?php echo $log['CODIND'] ?>,0)'><i class='fa fa-check-circle-o'> </i></span>
                <?php }elseif($log['estado'] == 0){ ?>
                
                    <span id="" style="padding: 0px; text-align:center;font-size: 20px;color:#505050;" title="Logro Inactivo: El logro en este estado no será tenido en cuenta en los desempeños calificados" onclick="cambiarEstadoLogro(<?php echo $log['CODIND'] ?>,1)"><i class='fa fa-times-circle-o'> </i></span>
                <?php }  ?>                    
                </div>               
            </td>
        </tr>
        <?php } ?>
    </tbody>
    <tfoot>
    </tfoot> 
</table>