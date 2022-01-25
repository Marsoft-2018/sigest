<?php 
	include("ctrlBloqueArea.php");
?>

<table border=1 cellspacing=0 cellpadding=0 width='100%' class="bloq-areas" style='width:100%;margin:0 auto;border-collapse:collapse;border:1px solid;'>
    <tr>
        <td colspan="8">AREA: <strong><?php echo strtoupper ($area['Nombre']) ?></strong></td>
        <td colspan="2">IH: <?php echo $area['intensidad'] ?></td>
        <td colspan="9">DOCENTE: 
        	<strong>
			<?php 
				  $objPensum->id = $area['id'];
                  $objPensum->curso = $curso;
				  foreach ($objPensum->profesorAsignado() as $key => $campo) {
				  	echo strtoupper ($campo['profesor']);
				  }
			?>
			</strong>
        </td>
    </tr>
    <tr class="cn">
        <td colspan="4">PERIODO 1</td>
        <td colspan="4">PERIODO 2</td>
        <td colspan="4">PERIODO 3</td>
        <td colspan="4">PERIODO 4</td>
        <td rowspan="2" style="text-align: center;">TOTAL INASIST</td>
        <td rowspan="2" style="text-align: center;">ACUM FINAL</td>
        <td rowspan="2" style="text-align: center;">VAL FINAL</td>
    </tr>
    <tr class="cn">
        <td>Calif</td>
        <td>Acum</td>
        <td>Val.</td>
        <td>Ina</td>
        <td>Calif</td>
        <td>Acum</td>
        <td>Val.</td>
        <td>Ina</td>
        <td>Calif</td>
        <td>Acum</td>
        <td>Val.</td>
        <td>Ina</td>
        <td>Calif</td>
        <td>Acum</td>
        <td>Val.</td>
        <td>Ina</td>
    </tr>
    <tr class="c">
        <td style="font-size: 15px;"><?php echo $calP1 ?></td>
        <td style="font-size: 15px;"><?php echo $acumP1?></td>
        <td style="font-size: 15px;"><?php echo $desmP1 ?></td>
        <td style="font-size: 15px;"><?php echo $inaP1 ?></td>
        <td style="font-size: 15px;"><?php echo $calP2 ?></td>
        <td style="font-size: 15px;"><?php echo $acumP2 ?></td>
        <td style="font-size: 15px;"><?php echo $desmP2 ?></td>
        <td style="font-size: 15px;"><?php echo $inaP2 ?></td>
        <td style="font-size: 15px;"><?php echo $calP3 ?></td>
        <td style="font-size: 15px;"><?php echo $acumP3 ?></td>
        <td style="font-size: 15px;"><?php echo $desmP3 ?></td>
        <td style="font-size: 15px;"><?php echo $inaP3 ?></td>
        <td style="font-size: 15px;"><?php echo $calP4 ?></td>
        <td style="font-size: 15px;"><?php echo $acumP4 ?></td>
        <td style="font-size: 15px;"><?php echo $desmP4 ?></td>
        <td style="font-size: 15px;"><?php echo $inaP4 ?></td>
        <td style="font-size: 15px;"><?php echo $inasFinal ?></td>
        <td style="font-size: 15px;"><?php 	echo $acumFinal; ?></td>
        <td style="font-size: 15px;"><?php echo $desmFinal ?></td>
    </tr>
    <tr>
        <td colspan="19">
            <strong>Juicio Valorativo: </strong><br> 
            <?php 
                $objLogros = new Logro();
                $objLogros->periodo = $periodoBol;
                $objLogros->codCurso = $curso;
                $objLogros->codArea = $area['id'];
                switch ($periodoBol) {
                    case 1:
                        $objLogros->calificacion = $calP1;
                        break;
                    case 2:
                        $objLogros->calificacion = $calP2;
                        break;
                    case 3:
                        $objLogros->calificacion = $calP3;
                        break;
                    case 4:
                        $objLogros->calificacion = $calP4;
                        break;
                }

                $objLogros->cargar();
                if($desmFinal == "BAJO"){
                    $areasPerdidas += 1;
                    $areaAplazada = $area['Nombre'];
                }
                // echo "<pre>";
                // var_dump($objLogro);
                // echo "</pre>";
            ?>
        </td>
    </tr>
</table> 