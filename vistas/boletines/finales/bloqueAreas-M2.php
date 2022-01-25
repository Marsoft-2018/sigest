<?php 
	include("ctrlBloqueArea.php");
?>
<tr>
    <td style="border:1px solid; font-size: 15px; padding: 2px; padding-left: 5px;">     
        <?php echo strtoupper ($area['Nombre']) ?> 
    </td>
    <td style="text-align:center; border:1px solid; font-size: 15px;">
        <?php echo $area['intensidad'] ?>                
    </td>
    <?php            
        foreach ($objPeriodo->cargar() as $per) { 
            $acumPer = 0;
            $objCalificacion->periodo = $per['periodo'];                
            foreach ($objCalificacion->cargar() as $calif) {
                $objD = new  Desempenos();                   
                $objCalificacion->nota = $calif['NOTA'];
                $objCalificacion->porPeriodo = $per['valorPeriodo'];

                $acumPer = $objCalificacion->acumulado();
                $acumFinal += $objCalificacion->acumulado();
                $objD->nota = $acumFinal;
                $desmFinal = $objD->cargar();
                $inasFinal += $calif['Faltas'];
            } 
            echo '<td style="text-align:center; border:1px solid; font-size: 15px;">'.round($acumPer,1).'</td>';
        } 
        $areaNum += 1;
        $promedioFinal += $acumFinal;
    ?>  
    <td style="text-align:center; border:1px solid; font-size: 15px;"><?php echo $inasFinal ?></td>
    <td style="text-align:center; border:1px solid; font-size: 15px;">
        <?php  
            echo round($acumFinal,1); 
        ?>
    </td>
    <td style="border:1px solid; font-size: 15px; padding-left: 10px;">
        <?php 
            echo $desmFinal;
            if($desmFinal == "BAJO"){
                $areasPerdidas += 1;
            }

        ?>        
    </td>
</tr>