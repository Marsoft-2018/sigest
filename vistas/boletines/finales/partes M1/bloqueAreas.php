<?php 
	include("ctrlBloqueArea.php");
?>
<tr>
    <td class="mayusculas" style="border:1px solid; font-size: 15px; padding: 2px; padding-left: 5px;">     
        <?php echo $area['Nombre'] ?> 
    </td>
    <td style="text-align:center; border:1px solid; font-size: 15px;">
        <?php echo $area['intensidad'] ?>                
    </td>
    <?php            
        foreach ($objPeriodo->cargar() as $per) { 
            $acumPer = 0;
            $objCalificacion->periodo = $per['periodo']; 
            $notaPeriodo = 0;               
            foreach ($objCalificacion->cargar() as $calif) {
                $objD = new  Desempenos();                   
                $objCalificacion->nota = $calif['NOTA'];
                $objCalificacion->porPeriodo = $per['valorPeriodo'];

                $acumPer = $objCalificacion->acumulado();
                $acumFinal += $objCalificacion->acumulado();
                $objD->nota = $acumFinal;
                $desmFinal = $objD->cargar();
                $inasFinal += $calif['Faltas'];
                $notaPeriodo = $calif['NOTA']; 
                switch ($per['periodo']) {
                    case 1:                           
                        $promedioP1 += $calif['NOTA'];
                       break;
                    case 2:                           
                        $promedioP2 += $calif['NOTA'];
                       break;
                    case 3:                           
                        $promedioP3 += $calif['NOTA'];
                       break;
                    case 4:                           
                        $promedioP4 += $calif['NOTA'];
                       break;  
                }   
            } 
            echo '<td style="text-align:center; border:1px solid; font-size: 15px;">'.round($notaPeriodo,1).'</td>';
        } 
        $areaNum += 1;
        $promedioFinal += $acumFinal;
    ?>  
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