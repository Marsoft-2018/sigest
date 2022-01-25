<?php 
    $totalSedes = $objSede->totalSedes();
    $combinar = 0;
    $totalAreas = 0;
 ?>
<table border='0' cellpadding = "0" cellspacing = "0" class='bordes2' style="border-collapse:collapse; table-layout:fixed; width:100%">
    <tr height=17 style='height:5.75pt'>       
        <td colspan='7' style='width:805pt;text-align:center;padding:1px;'>            
           <img src="../../img/<?php echo $logo ?>" alt='' style='width:50px;height:50px;margin 0 auto;'>
           <h3 style='text-align:center;padding:0px;margin:0px;'><?php echo $institucion ?></h3>
           <h2 style='text-align:center;padding:0px;margin:0px;'> Consolidado <?php echo strtolower($tipoDatos) ?> </h2>
        </td>
    </tr>
    <tr height='17' style='height:12.75pt' class='bordes4'>
        <?php if($totalSedes > 1){ ?>
        <td>SEDE: <?php echo $nombreSede ?></td>
        <?php }else{ ?>
            <td>&nbsp;</td>
        <?php } ?>
        <td>GRADO: <?php echo $grado; ?></td>
        <td>GRUPO: <?php echo $grupo; ?></td>
        <td colspan='2'>&nbsp;</td>
        <td>
           <div align='right'>
                PERIODO:&nbsp;
                <?php 
                    if($tipoDatos == 'Definitivo'){
                       echo "Final";                            
                    } elseif($periodo != 'Todos' or $tipoDatos == 'General'){
                        if($tipoDatos == "Nota Requerida" and $periodo != 4){
                            echo ($periodo+1);
                            $combinar = 1; 
                        }else{
                            echo $periodo;
                            $combinar = $periodo; 
                        }                  
                    }
                ?>
           </div>
        </td>
        <td style='text-align:right;padding-right:5px;'>AÑO:&nbsp;<?php echo $anho ?></td>           
    </tr>
</table> 

<!-- 
        //-------------- Consulta para recorrer el listado de estudiantes en el curso ----------------//        
        $sqlalum="SELECT est.`Documento`,est.`PrimerApellido`,est.`SegundoApellido`,est.`PrimerNombre`,est.`SegundoNombre`,mat.`idMatricula` FROM estudiantes est INNER JOIN matriculas mat ON mat.`Documento` = est.`Documento` WHERE mat.`estado` = 'Matriculado' AND mat.`Curso`='$curso' AND mat.`anho` = '$anho'  ORDER BY est.`PrimerApellido`,est.`SegundoApellido`,est.`PrimerNombre`,est.`SegundoNombre` ASC;";

        $resultalum=mysql_query($sqlalum,$conexion) or die ("NO TRAJO LOS NOMBRE DE LOS ALUMNOS<BR>".mysql_error());
        $totEspaciosAsignaturas=0;
        $nolista=1; 
        $totalEspacios=0;
        //Algoritmo para determinar el total espacios para visualizar los periodos
        while($ear=mysql_fetch_array($sqlAreasC)){
            $c=mysql_query("select count(Abreviatura) from asignaturas_sedes ass where ass.idArea='$ear[0]' AND ass.`$campo`<>0 AND ass.ih<>0");
            while($con_asig=mysql_fetch_array($c)){
                if($con_asig[0]>0){
                    if($con_asig[0]>1){
                        $totalEspacios=$totalEspacios+$con_asig[0];
                    }else{
                        $totalEspacios++;
                    }
                }else{
                    $totalEspacios++;
                }
            }
        }
 -->
<table border='0' cellpadding='0' cellspacing='0' style= "border-collapse:collapse; table-layout:fixed; width:100%;">
<?php 
    if($periodo != "Todos"){ ?>
        <tr>
            <td class='bordes' width = '32' 
                <?php if($periodo > 1 && $tipoDatos != "Acumulado" && $tipoDatos != "Nota Requerida" && $tipoDatos != "NotasPeriodo" && $tipoDatos != "Definitivo"){echo "rowspan ='2'";} ?>>
                Código
            </td>
            <td class='bordes' width='10'  
                <?php if($periodo > 1 && $tipoDatos != "Acumulado" && $tipoDatos != "Nota Requerida" && $tipoDatos != "NotasPeriodo" && $tipoDatos != "Definitivo"){echo "rowspan ='2'";} ?>>
                Nº
            </td>
            <td class='bordes' width='100' 
                <?php if($periodo > 1 && $tipoDatos != "Acumulado"  && $tipoDatos != "Nota Requerida" && $tipoDatos != "NotasPeriodo" && $tipoDatos != "Definitivo"){echo "rowspan ='2'";} ?>>
                ESTUDIANTE
            </td>
            <?php 
            foreach ($objArea->cargarPensum() as $area) { ?>         
                <td class="bordeareas" 
                    width="30"  
                    <?php 
                        if($periodo > 1 && $tipoDatos != "Acumulado" && $tipoDatos != "Nota Requerida" && $tipoDatos != "NotasPeriodo" && $tipoDatos != "Definitivo"){echo "colspan ='$periodo'";} 
                    ?> 
                    title = "<?php echo $area['Nombre'] ?>"
                >
                    <?php echo $area['Abreviatura'] ?>
                </td>        
            <?php 
                $totalAreas++;
            }
            ?>
                <td class='bordeareas' 
                    width='20' 
                    <?php if($periodo > 1 && $tipoDatos != "Acumulado"  && $tipoDatos != "Nota Requerida" && $tipoDatos != "NotasPeriodo" && $tipoDatos != "Definitivo"){echo "rowspan ='2'";} ?>
                >
                    PROM. GERAL
                </td>
                <td class='bordeareas' 
                    width='20'   
                    <?php if($periodo > 1 && $tipoDatos != "Acumulado"  && $tipoDatos != "Nota Requerida" && $tipoDatos != "NotasPeriodo" && $tipoDatos != "Definitivo"){echo "rowspan ='2'";} ?>
                >
                    PUESTO
                </td>
                <?php if($tipoDatos == "Definitivo"){ ?>
                <td class='bordeareas' width='40'>
                    AÑO LECTIVO
                </td>
            <?php } ?>
        </tr>
        <?php 
            if($periodo > 1 && $tipoDatos != "Acumulado" && $tipoDatos != "Nota Requerida" && $tipoDatos != "NotasPeriodo" && $tipoDatos != "Definitivo"){ 
        ?>
        <tr>
            <?php 
            for ($a=0; $a < $totalAreas ; $a++) { 
                for ($i=1; $i <= $periodo  ; $i++) { 
                    echo "<td class='bordeareas' width='30' >P".$i."</td>";
                }            
            }
            ?>
        </tr>
    <?php } ?>
<?php } ?>
<!--         }else{
            if($tipoDatos == 'General'){

                //Encabezado del cuerpo del consolidado cuando son todos los periodos
                echo "<tr>";
                echo    "<td rowspan='2' class='bordes' width='45' >Código</td>";
                echo    "<td rowspan='2' class='bordes' width='20' >Nº</td>";
                echo    "<td rowspan='2' class='bordes' width='210'>ESTUDIANTE</td>";   
                //echo    "<td class='bordeareas' width='40'>Areas ->></td>";
                while($materia=mysql_fetch_array($sqlAreas)){
                    //Verifico que asignatura coincide con el área
                    $sqlAsig=mysql_query("SELECT Abreviatura,Nombre,IH,codAsig FROM asignaturas_sedes WHERE idArea='$materia[0]' AND $campo<>0;");
                    $numAsig=mysql_num_rows($sqlAsig);
                    if($numAsig>0){
                        while($asigReg=mysql_fetch_array($sqlAsig)){
                            echo "<td rowspan='' colspan='".$periodoMax."' class='bordeareas'  title='".utf8_encode($materia[2])."'>".utf8_encode($materia[1])."<br> $asigReg[1]</td>";
                            //$totEspaciosAsignaturas++;
                        }                                    
                    }elseif($numAsig==0){
                        echo "<td rowspan='' colspan='".$periodoMax."' class='bordeareas'  title='".utf8_encode($materia[2])."'>".utf8_encode($materia[1])."</td>";
                    } 
                    //$totalEspacios++;
                }
                echo    "<td rowspan='2' class='bordeareas' width='40' >PROM. GERAL</td>";
                echo    "<td rowspan='2' class='bordeareas' width='40' >PUESTO</td>";  
                echo "</tr>";

                echo "<tr>";
                    //echo "<td class='bordeareas' width='40'>Periodos >></td>";
                    while($totalEspacios>=1){
                        for($p=$periodoMin;$p<=$periodoMax;$p++){
                            echo "<td class='bordeareas'>".$p."P</td>";                
                        }
                        $totalEspacios--;
                    }                
                echo "</tr>";
                //Fin del encabezado 
            }elseif($tipoDatos == 'Definitivo'){
                echo "<tr>";
                echo    "<td rowspan='2' class='bordes' width='32' >Código</td>";
                echo    "<td rowspan='2' class='bordes' width='10' >Nº</td>";
                echo    "<td rowspan='2' class='bordes' width='100'>ESTUDIANTE</td>";   
                while($materia=mysql_fetch_array($sqlAreas)){
                    //Verifico que asignatura coincide con el área
                    echo "<td rowspan='2' class=bordeareas width=30 title='".utf8_encode($materia[2])."'>".utf8_encode($materia[1])."</td>";

                }            
                echo    "<td rowspan='2' class='bordeareas' width='20' >PROMEDIO</td>";  
                echo    "<td rowspan='2' class='bordeareas' width='20' >AÑO LECTIVO</td>";
                echo "</tr>";
            }
        }

        if($periodo!='Todos' or $tipoDatos == 'Definitivo'){
            echo  "<tr height=15 style='mso-height-source:userset;height:11.25pt'> </tr>"; 
        }  -->