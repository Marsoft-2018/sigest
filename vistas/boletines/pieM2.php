<table style='margin:0 auto; border-collapse:collapse; border:none; width:100%'>
   <tr>
    <td valign=top style='width:60%;border: solid windowtext 0.5pt;border-left:solid windowtext 0.5pt;border-bottom:solid windowtext 0.0pt;border-right: solid windowtext 0.0pt; padding:0cm 5.4pt 0cm 5.4pt'>
      <p class = "MsoNormal" align ="right" style="margin-bottom:0cm; margin-bottom:.0001pt; text-align:left;line-height:normal">
          <strong> OBSERVACIONES Y/O RECOMENDACIONES:</strong>
          <?php 
            if($periodoBol == 4){
            $objEstado = new Calificacion();
            echo $objEstado->estadoAnho($areasPerdidas,$areasPerder);
            $estado = $objEstado->estadoAnho($areasPerdidas,$areasPerder);
            
                switch ($estado) {
                  case 'Reprobado':
                     echo ", debe reiniciar el grado ".$gradoR;
                    break;
                  case 'Aplazado':
                      echo ", debe recuperar el área de ".strtoupper($areaAplazada);
                    break;
                  default:
                    # code...
                    break;
                }
            }
            $objObservacion = new observacionBoletin();
            $objObservacion->idMatricula = $idMatricula;
            $objObservacion->periodo = $_POST['periodo'];			
            $objObservacion->anho =$_POST['anho'];
          ?>
      </p>
    </td>
    <td colspan=6 style='width:76.42%;border-top:solid windowtext 0.5pt;border-left:none;border-bottom:none;border-right:solid windowtext 0.5pt; padding:0cm 5.4pt 0cm 5.4pt'>
      
    </td>
   </tr>
   <tr>
      <td width="100%" colspan="7" valign="top" style="width:100.0%;border:solid windowtext 0.5pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; font-size: 1.2em;font-style:italic;">
          <?php 
            $textObservacion = "";
            foreach($objObservacion->cargar() as $observacion){ 
                $textObservacion = $observacion['observacion'];
            }
            
            if($textObservacion != ""){
                echo $observacion['observacion'];
            }else{ ?>
                <hr style="border-color: #888; margin-bottom: 30px; margin-top: 2px;">
                <hr style="border-color: #888; margin-bottom: 5px; ">
                <hr style="border-color: #888; margin-bottom: 30px; margin-top: 30px;">
                <hr style="border-color: #888; margin-bottom: 30px; margin-top: 2px;">
         <?php               
            }
          ?>
      </td>
   </tr>
</table>