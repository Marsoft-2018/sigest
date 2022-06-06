<tr>
    <td colspan="5" style="border-left: 0px solid; border-bottom: 0px;"> </td>     
    <td colspan="2" style="text-align:center; border:1px solid; font-size: 12px;padding: 2px; letter-spacing: 2px; font-style: italic; font-weight: bold;">
      PROMEDIO
      <?php 
        $objNota = new Calificacion();
        $promedioDefinitivo = $objNota->formato_notas( round(($promedioFinal/$areaNum),1));
      ?>
    </td>
    <td style="text-align:center; border:1px solid; font-size: 15px;"><?php echo $promedioDefinitivo; ?></td>
    <td style="border:1px solid; font-size: 15px; padding-left: 10px;">
      <?php 
        
        $objD = new  Desempenos();
        $objD->nota =  $promedioDefinitivo;
        $desPromedio = $objD->cargar();
        echo $desPromedio;
      ?>        
    </td>
</tr>
</tbody> 
  </table> 
</div>

<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'>
<span lang=ES-AR style='font-size:3.0pt'> &nbsp; </span>
</p>
<table style='margin:0 auto; border-collapse:collapse; border:none; width:100%'>
   <tr>
    <td valign=top style='width:60%;border: solid windowtext 0.5pt;border-left:solid windowtext 0.5pt;border-bottom:solid windowtext 0.0pt;border-right: solid windowtext 0.0pt; padding:0cm 5.4pt 0cm 5.4pt'>
      <p class = "MsoNormal" align ="right" style="margin-bottom:0cm; margin-bottom:.0001pt; text-align:left;line-height:normal">
          <strong> OBSERVACIONES: </strong> 
          <?php 
            // echo $areasPerdidas; 
            // echo "<br>".$areasPerder;

            $objEstado = new Calificacion();
            $objEstado->idMatricula =  $idMatricula;
            echo $objEstado->estadoAnho($areasPerdidas,$areasPerder);
            $estadoAnho = $objEstado->estadoAnho($areasPerdidas,$areasPerder);
            /*foreach($objEstado->recuperacion() as $re){
                
                echo "<br>Presentó Activivdad de autosuficiencia Según acta No. ".$re['numActa']." de ".$re['mesActa']." ".$re['diaActa']." de ".$anho." en el área de ".$re['Nombre']." y su calificación fue de <strong>".$re['NOTA']."</strong>";
            }*/
            
          ?>
      </p>
    </td>
    <td colspan=6 style='width:76.42%;border-top:solid windowtext 0.5pt;border-left:none;border-bottom:none;border-right:solid windowtext 0.5pt; padding:0cm 5.4pt 0cm 5.4pt'>
      
    </td>
   </tr>
   <tr>
      <td width="100%" colspan="7" valign="top" style="width:100.0%;border:solid windowtext 0.5pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt">
        <hr style="border-color: #222; margin-bottom: 2px; ">
        <?php
        
            foreach($objEstado->recuperacion() as $re){
                if($estadoAnho == "Aplazado"){
                    $objRecuperacion = new Calificacion();
                    $notaRecuperacion = $objRecuperacion->formato_notas($re['NOTA']);
                    
                    echo "<br>Realizó actividad complementaria de nivelación del área de <span class='area-r'>".$re['Nombre']."</span> y obtuvo calificación de <strong>".$notaRecuperacion." </strong> (acta No. ".$re['numActa']." de ".$re['mesActa']." ".$re['diaActa']." de ".$anho.")";
                }elseif($estadoAnho == "Reprobado" || $estadoAnho == "Aprobado"){
                    echo "<br>".$re['observacion'];
                }/**/
                //echo "<br>".$re['observacion'];
            }
            
          ?>
        <hr style="border-color: #222; margin-bottom: 40px; ">
      </td>
   </tr>
</table>

<div style="border-top: 1px solid  #222; margin-top: 45px; left: 0px; width: 35%;">
  RECTOR 
</div>
<h1 style='page-break-after:always'></h1>