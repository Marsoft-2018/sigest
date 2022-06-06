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
                $objNotaAcumulada = new Calificacion();
                $acumPer = $objNotaAcumulada->formato_notas( round($objCalificacion->acumulado(),1));
                $acumFinal += $objCalificacion->acumulado();
                $objD->nota = round($acumFinal,1);
                $desmFinal = $objD->cargar();
                $inasFinal += $calif['Faltas'];
            } 
            echo '<td style="text-align:center; border:1px solid; font-size: 15px;">'.$acumPer.'</td>';
        } 
        $areaNum += 1;
        $promedioFinal +=  round($acumFinal,1);
    ?>  
    <td style="text-align:center; border:1px solid; font-size: 15px;"><?php echo $inasFinal ?></td>
    <td style="text-align:center; border:1px solid; font-size: 15px;">
        <?php  
            $objNotaArea = new Calificacion();
            $acumuladoArea = $objNotaArea->formato_notas( round($acumFinal,1));
        echo $acumuladoArea; 
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