<?php 
if (isset($_POST['sede'])) {  
    session_start();  
    require('../../Modelo/Conect.php');
    require("../../Modelo/entregaDeInformesPeriodo.php");
    require("../../Modelo/Estudiante.php"); 

    $curso = $_POST['curso'];
    $anho = $_POST['anho'];
    $periodo =  $_POST['periodo'];
    $fecha = $_POST['fecha'];
    $accion = "";
    $estado = "";

    $objEstudiante = new Estudiante();
    $objEstudiante->curso = $curso;
    $objEstudiante->anho = $anho;

}
   

?>
<table id="listadoProfe" class='dataTable display table table-striped table-hover no-footer' style="width: 70%;margin: 0 auto; border:1px solid #2A65ED;">
    <thead>
        <tr style='background-color:#2A65ED;color:#fff;'>
            <th>No.</th>
            <th>ESTUDIANTE</th>
            <th>HABILITAR</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $cont = 1;
        foreach ($objEstudiante->listarCurso() as $estudiante) {  
            $estado = "checked";
            $objExcep = new entregaDeInformesPeriodo();
            $objExcep->periodo = $periodo;
            $objExcep->anho = $anho;
            $objExcep->curso = $curso;
            foreach ($objExcep->cargar() as $value) {
                $objHabilitado = new entregaDeInformesPeriodo();
                $objHabilitado->id = $value['id'];
                $objHabilitado->idMatricula = $estudiante['idMatricula'];
                $habilitar = $objHabilitado->validar();
                $accion = 'activarEstudiantes('.$estudiante['idMatricula'].','.$value['id'].','.$habilitar.')';    
                if ($habilitar == "false") { $estado = ""; }                   
            }
        ?>
        <tr >
            <td  style="text-align:center; color:#cecece; margin:0px; padding:0px;"> <?php echo $cont ?></td>
            <td style="color:#000000; margin:0px; padding:0px; width:50%;">
                <?php echo $estudiante['PrimerNombre']." ".$estudiante['SegundoNombre']." ".$estudiante['PrimerApellido']." ".$estudiante['SegundoApellido'] ?>                
            </td>
            <td>
                <label class="switch">
                    <input type="checkbox" 
                        id="<?php echo $estudiante['idMatricula']; ?>" 
                        onclick = "<?php echo $accion; ?>" <?php echo $estado ?>>
                    <span class="slider round"></span>
                </label>
            </td>
        </tr>
        <?php 
            $cont++;
        }
        ?>
    </tbody> 
</table> 