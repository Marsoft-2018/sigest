<!-- <table cellspacing="0" cellpadding="0" style="width:100%; margin:0 auto; border-collapse:collapse;border:1px;"> -->
<?php 
	$promedioFinal = 0;
	$desPromedio = "";
	$areaNum = 0;
	$areasPerdidas = 0;
	$promedioP1 = 0;
	$promedioP2 = 0;
	$promedioP3 = 0;
	$promedioP4 = 0;
?>
<table class="table">
    <tr>
        <td width='6%' rowspan="7" valign=top style="width:6.52%;border:solid windowtext 1.5pt;border-left:solid windowtext 1.5pt; border-right:none;padding:3px">
            <p class = "MsoNormal" style="margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal;padding:2px;">
                <img src="../vistas/img/<?php echo $escudo ?>" alt="Logo" style="position:relative;  width:90%; height:50px">
            </p>
        </td>
        <td width='20%' rowspan="7" style="width:25.88%; border: solid windowtext 1.5pt; border-left:none; padding:0cm 5.4pt 0cm 5.4pt">
            <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal'>
                <b>
                    <span lang=ES-AR style="font-size:6.0pt;font-family:'Arial','sans-serif'">
                        REPÚBLICA DE COLOMBIA
                    </span>
                </b>
            </p>
            <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal'>
                <span lang=ES-AR style='font-size:5.0pt'>
                    <b><?php echo $nombreInstitucion; ?></b><br>
                </span>
                <span lang=ES-AR style='font-size:5.0pt'>
                    <?php echo $aprobacion ?>
                </span>
            </p>
        </td>
        <td width='7%' valign=top style="width:7.02%;border-top:solid windowtext 1.5pt; border-left:none;border-bottom:none;border-right:solid windowtext 1.0pt;padding: 4pt; font-size:9.0pt">
            Sede: 
        </td>
        <td width='15%' colspan=3 style='width:15.56%; border-top:solid windowtext 1.5pt;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding: 4pt; font-size:9.0pt'>
            <?php 
                foreach ($objSede->reportes() as $key => $sedeN) {
                   echo $sedeN['NOMSEDE'];
                }
            ?>
        </td>
        <td width='11%' style='width:11.98%;border-top:solid windowtext 1.5pt;border-left:none;border-bottom:none;border-right:solid windowtext 1.0pt;padding: 4pt; font-size:9.0pt'>
            Código:
        </td>
        <td width='6%' valign=top style='width:6.0%;border-top:solid windowtext 1.5pt;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt; padding: 4pt; font-size:9.0pt'>
            <?php echo $campo['idMatricula'] ?>
        </td>
        <td width='6%' colspan=2 style='width:6.44%;border-top:solid windowtext 1.5pt;border-left:none;border-bottom:none;border-right:solid windowtext 1.0pt; padding: 4pt; font-size:9.0pt;'>
            Curso:
        </td>
        <td width = "4%" valign = "top" style = "width: 4.46%; border-top:solid windowtext 1.5pt; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding: 4pt; font-size:9.0pt">
            <?php echo $campo['CODGRADO']."°".$campo['grupo'] ?>
        </td>
        <td width='4%' valign=top style='width:4.46%;border-top:solid windowtext 1.5pt;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt; padding: 4pt; font-size:9.0pt'>
            <?php echo $campo['jornada'] ?>
        </td>
        <td width='4%' style='width:4.82%;border-top:solid windowtext 1.5pt; border-left:none;border-bottom:none;border-right:solid windowtext 1.0pt;font-size:9.0pt; padding: 4pt'>
            Año:
        </td>
        <td width='11%' colspan=2 valign=top style='width:11.32%;border-top:solid windowtext 1.5pt;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;padding: 4pt; font-size:9.0pt'>
           <?php echo $campo['anho'] ?>
        </td>
    </tr>
    <tr>
        <td width='67%' colspan=13 valign=top style='width:75%; border:none; border-right:solid windowtext 1.5pt; padding:1.5px;'>
        </td>
    </tr>
    <tr>
        <td width='9%' colspan=2 style='width:9.82%;border:none;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
            <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'>
                <span lang=ES-AR style='font-size:9.0pt'>Estudiante:</span>
            </p>
        </td>
        <td width='33%' colspan=5 valign=top style='width:33.94%; font-size:9.0pt;
        border-top:solid windowtext 1.0pt; 
        border-left:solid windowtext 1.0pt; 
        border-bottom:solid windowtext 1.0pt; 
        border-right:solid windowtext 1.0pt; padding: 4pt'>
            <?php echo $campo['PrimerNombre']." ".$campo['SegundoNombre']." ".$campo['PrimerApellido']." ".$campo['SegundoApellido'] ?>   
        </td>
        <td width='7%' colspan=2 valign=top style='width:7.72%;border:none;border-right:solid windowtext 1.0pt; padding: 4pt; font-size:9.0pt;'>
            Nivel:
        </td>
        <td width='16%' colspan=4 valign=top style='width:16.14%; font-size:8.0pt;
        border-top:solid windowtext 1.0pt;
        border-left:solid windowtext 1.0pt;
        border-bottom:solid windowtext 1.0pt;
        border-right:solid windowtext 1.5pt; padding: 4pt'>
            <?php 
                foreach ($objNivel->segunCurso() as $key => $nivel) {
                    echo $nivel['NOMBRE_NIVEL'];
                }
            ?>
        </td>
    </tr>
    <tr>
        <td width='67%' colspan=13 valign=top style='width:67.6%;border:none;border-right:solid windowtext 1.5pt; padding:1.5px'>
        </td>
    </tr>
    <tr>
        <td width='11%' colspan=3 valign=top style='width:11.0%;border:none;border-right:solid windowtext 1.0pt;font-size:8.0pt; padding: 4pt'>
            Dir. De Grupo:
        </td>
        <td width='41%' colspan=7 valign=top style='width:41.18%; border-top:solid windowtext 1.0pt; border-left:solid windowtext 1.0pt; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; font-size:9.0pt; padding:4pt'>
            <?php 
                echo $directorGrupo;
             ?>
        </td>
        <td width='8%' colspan=2 valign=top style='width:8.9%;border:none;border-right:solid windowtext 1.0pt; text-align:right; font-size:9.0pt; padding-top:4pt'>
            Periodo: 
        </td>
        <td width='6%' valign=top style='width:6.52%;border-top:solid windowtext 1.0pt;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt; padding-top: 4pt; text-align:center;font-size:9.0pt;'>
                    <?php echo $periodoBol ?>
        </td>
    </tr>
    <tr>
        <td width='67%' colspan=13 valign=top style='width:67.6%;border:none;border-right:solid windowtext 1.5pt; padding:1.5px'>
        </td>
    </tr>
    <tr>
        <td width='67%' colspan=13 valign=top style='width:67.6%;border-top:none; border-left:none;border-bottom:solid windowtext 1.5pt;border-right:solid windowtext 1.5pt;background:#D9D9D9;padding:0cm 5.4pt 0cm 5.4pt'>
            <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal'>
                <i>
                    <span lang=ES-AR style='font-size:7.0pt'>
                        Escala de valoración:&nbsp;&nbsp;
                        <?php
                            $objD = new Desempenos();
                            foreach ($objD->Listar() as $desemp) { ?>  
                            <strong style="margin-left: 5px;"><?php echo $desemp['CONCEPT'] ?></strong> <?php echo "de ".$desemp['limiteInf']." hasta ".$desemp['limiteSup'] ?>
                        <?php } 
                        ?>                              
                    </span>
                </i>
            </p>
        </td>
    </tr>
</table>
<table border=1 cellspacing=0 cellpadding=0 width='100%' style='width:100.16%;margin:0 auto;border-collapse:collapse;border:none'>
    <tr>
        <td rowspan=3 style='width:200.1pt;border-top:windowtext;border-left: windowtext;border-bottom:black;border-right:black;border-style:solid; border-width:1.5pt;padding:0cm 5.4pt 0cm 15.4pt'>
            <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'>
                <span lang=ES style='font-size:12.0pt'>
                    AREAS/ ASIGNATURAS
                </span>
            </p>
        </td>
        <td rowspan=3 style='width:10.05pt;border-top:solid windowtext 1.5pt; border-left:none;border-bottom:solid black 1.5pt;border-right:solid windowtext 1.5pt;'>
            <p class=MsoNormal align=center style='margin-top:0cm;margin-right:5.65pt;margin-bottom:0cm;margin-left:5.65pt;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                <b>
                    <span lang=ES-AR style='font-size:8.0pt;font-family:'Arial','sans-serif''>
                        I.H.
                    </span>
                </b>
            </p>
        </td>
        <td width=569 colspan=6 style='width:426.55pt;border-top:solid black 1.5pt;border-left:none;border-bottom:solid windowtext 1.5pt;border-right:solid windowtext 1.5pt;padding:0cm 5.4pt 0cm 5.4pt'>
            <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                <b>
                    <i>
                        <span lang=ES-AR style='font-size:12.0pt'>
                            DESEMPEÑO ACADÉMICO
                        </span>
                    </i>
                </b>
            </p>
        </td>
    </tr>
    <tr>
        <td colspan='4' style='width:118.7pt;border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid windowtext 1.5pt;padding:0cm 5.4pt 0cm 5.4pt'>
            <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                <span lang=ES-AR style='font-size:12.0pt'>
                    NOTAS POR PERIODO
                </span>
            </p>
        </td>
        <td colspan='2' style='width:400.85pt;border-top:none;border-left:none;border-bottom:solid black 1.5pt;border-right:solid black 1.5pt;padding:0cm 5.4pt 0cm 5.4pt'>
            <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:center;line-height:normal'>
                <span lang=ES-AR>
                    PERIODO FINAL
                </span>
            </p>
        </td>
    </tr>
    <tr>
        <td style='width:10pt;border-top:none;border-left:none; border-bottom:solid black 1.5pt;border-right:solid black 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
            <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:center;line-height:normal'>
                <span lang=ES-AR style='font-size:10.0pt'>
                    1P
                </span>
            </p>
        </td>
        <td style='width:10pt;border-top:none;border-left:none; border-bottom:solid black 1.5pt;border-right:solid black 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
            <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:center;line-height:normal'>
                <span lang=ES-AR style='font-size:10.0pt'>
                    2P
                </span>
            </p>
        </td>
        <td style='width:10pt;border-top:none;border-left:none; border-bottom:solid black 1.5pt;border-right:solid black 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
            <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:center;line-height:normal'>
                <span lang=ES-AR style='font-size:10.0pt'>
                    3P
                </span>
            </p>
        </td>
        <td style='width:10pt;border-top:none;border-left:none; border-bottom:solid black 1.5pt;border-right:solid black 1.5pt;padding:0cm 5.4pt 0cm 5.4pt'>
            <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:center;line-height:normal'>
                <span lang=ES-AR style='font-size:10.0pt'>
                    4P
                </span>
            </p>
        </td>
        <td style='width:10pt;border-top:none;border-left:none; border-bottom:solid black 1.5pt;border-right:solid black 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
            <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:center;line-height:normal'>
                <span lang=ES-AR style='font-size:10.0pt'>
                    DEFINITIVA
                </span>
            </p>
        </td>
        <td style='width:90pt;border-top:none;border-left:none;border-bottom:solid black 1.5pt;border-right:solid black 1.5pt;padding:0cm 5.4pt 0cm 5.4pt'>
            <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                <span lang=ES-AR style='font-size:8.0pt'>
                    DESEMPEÑO ACADÉMICO
                </span>
            </p>
        </td>
    </tr>	
	<?php 
        foreach ($sqlAreas as $key => $area) {
            include("bloqueAreas.php");
        }
    ?> 