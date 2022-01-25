    <tr>        
        <td colspan="2" style="text-align:right; border:1px solid; font-size: 12px;padding: 2px; letter-spacing: 2px; font-style: italic; font-weight: bold;">
          PROMEDIOS DEL ESTUDIANTE
        </td>
        <?php 
          for ($i=1; $i <=4 ; $i++) { ?>
            <td style="text-align:center; border:1px solid; font-size: 15px;">
              <?php 
              switch ($i) {
                  case 1:                           
                      $promedioP1 = round(($promedioP1/$areaNum),1); 
                      echo $promedioP1;
                     break;
                  case 2:                           
                      $promedioP2 = round(($promedioP2/$areaNum),1); 
                      echo $promedioP2;
                     break;
                  case 3:                           
                      $promedioP3 = round(($promedioP3/$areaNum),1); 
                      echo $promedioP3;
                     break;
                  case 4:                           
                      $promedioP4 = round(($promedioP4/$areaNum),1); 
                      echo $promedioP4;
                     break;  
                }
                
              ?>
            </td>
        <?php 
          }
        ?>
        <td style="text-align:center; border:1px solid; font-size: 15px;"><?php echo round(($promedioFinal/$areaNum),1); ?></td>
        <td style="border:1px solid; font-size: 15px; padding-left: 10px;">
          <?php 
            $objD = new  Desempenos();
            $objD->nota = $acumFinal;
            $desPromedio = $objD->cargar();
            echo $desPromedio;
          ?>        
        </td>
    </tr>
  </tbody> 
</table> 
</div>
<br>        
<table class=MsoTableGrid cellspacing=0 cellpadding=0  style='margin:0 auto;border-collapse:collapse;border:none;width:50%'>
 <tr style='border:solid windowtext 0.5pt;margin:0px;'>
     <td width='26%' colspan='2' style='width:26.62%;border:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
         <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal;text-align:center;'>
             <span lang=ES-AR style='font-size:10.0pt'>
                 PUESTOS DEL ESTUDIANTE
             </span>
         </p>
     </td>
     <td width='26%' colspan='' style='width:26.62%;border:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
         <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal;'>
             <span lang=ES-AR style='font-size:10.0pt'>
                 RESULTADO DEL AÑO LECTIVO
             </span>
         </p>
     </td>
 </tr>

 <tr>

     <td style='width:26.62%;border:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
         <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
             <span lang=ES-AR>
                 <strong>En el Grupo: </strong>
                 <?php 
                    //-- BLOQUE PARA COLOCAR EL PUESTO DEL ESTUDIANTE SEGUN EL PROMEDIO EN EL GRUPO
                    $puesto = new Puesto();
                    $puesto->finalGrupo($centro,$sede,$anho,$periodoBol,$curso,$idMatricula);

                 ?>
                             
             </span>
         </p>
     </td>

     <td style='width:26.62%;border:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
         <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
             <span lang=ES-AR>
                 <strong>En el Grado: </strong>
                            //-- BLOQUE PARA COLOCAR EL PUESTO DEL ESTUDIANTE SEGUN EL PROMEDIO EN EL GRADO
                            $puestoG = new Puestos();
                            $puestoG->finalGrado($centro,$sede,$anho,$periodoBol,$curso,$idMatricula);
             </span>
         </p>
     </td>
     <td width='26%' colspan='' style='width:26.62%;border:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
           <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal;'>
               <span lang=ES-AR style='font-size:10.0pt'>
                <strong>
                  <?php 
                    $objEstado = new Calificacion();
                    echo strtoupper($objEstado->estadoAnho($areasPerdidas,$areasPerder));
                  ?>
                </strong>
               </span>
           </p>
       </td>
   </tr>
</table>
<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'>
<span lang=ES-AR style='font-size:3.0pt'> &nbsp; </span>
</p>
<table style='margin:0 auto; border-collapse:collapse; border:none; width:100%'>
   <tr>
    <td valign=top style='width:60%;border: solid windowtext 0.5pt;border-left:solid windowtext 0.5pt;border-bottom:solid windowtext 0.0pt;border-right: solid windowtext 0.0pt; padding:0cm 5.4pt 0cm 5.4pt'>
      <p class = "MsoNormal" align ="right" style="margin-bottom:0cm; margin-bottom:.0001pt; text-align:left;line-height:normal ">
          <strong> OBSERVACIONES: </strong>           
      </p>
    </td>
    <td colspan=6 style='width:76.42%;border-top:solid windowtext 0.5pt;border-left:none;border-bottom:none;border-right:solid windowtext 0.5pt; padding:0cm 5.4pt 0cm 5.4pt'>
      
    </td>
   </tr>
   <tr>
      <td width="100%" colspan="7" valign="top" style="width:100.0%;border:solid windowtext 0.5pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt">
        <hr style="border-color: #222; margin-bottom: 40px; ">
        <hr style="border-color: #222; margin-bottom: 40px; ">
      </td>
   </tr>
</table>

<div style="border-top: 1px solid  #222; margin-top: 45px; left: 0px; width: 35%;">
  RECTOR 
</div>
<h1 style='page-break-after:always'></h1>