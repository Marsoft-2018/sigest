<table class=MsoTableGrid cellspacing=0 cellpadding=0  style='margin:0 auto; border-collapse:collapse; border:none; width:100%'>
   <tr style='border:solid windowtext 0.5pt;margin:0px;'>
      <td valign=top style='border-left:solid windowtext 1.5pt;border-right:solid windowtext 1.0pt;padding: 2px;'>
          <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:left;line-height:normal'>
              <span style='font-size:10.0pt'> PROMEDIO DEL ESTUDIANTE </span>
          </p>
      </td> 
      <td width='5%' style='width:5.32%;border:solid windowtext 1.0pt;border-left:none;padding:0cm 5.4pt 0cm 5.4pt'>
            <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
              <span  style='font-size:12.0pt'>
                    <!--  /*-------------------- PROMEDIO DEL ESTUDIANTE -----------------------*/-->  
                  <?php
                    $objNumAreas = new Area();
                    $objNumAreas->codSede = $sede;
                    $objNumAreas->anho = $anho;
                    $objNumAreas->idGrado = $grado;
                    $totalAreas = $objNumAreas->totalAreas();
                    $promedioEstudiante = new Calificacion();
                    $promedioEstudiante->periodo = $periodoBol;
                    $promedioEstudiante->idMatricula = $idMatricula;
                    $promedioEstudiante->Anho = $anho;
                    $promedioEstudiante->curso = $curso;
                    $promedioPeriodo = $promedioEstudiante->formato_notas($promedioEstudiante->promedioEstudiante()/$totalAreas);
                    echo round($promedioPeriodo,1);       
                  ?>
              </span>
            </p>
      </td>
      <td width='26%' style='width:26.62%; border:none;border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt'>
        <p class=MsoNormal align=right style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:right;line-height:normal'>
            <span lang=ES-AR style='font-size:10.0pt'>
                PUESTO EN EL PERIODO
            </span>
        </p>
      </td>
      <td width='6%' style='width:6.64%;border:solid windowtext 1.0pt;border-left:none;padding:0cm 5.4pt 0cm 5.4pt'>
        <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
            <span lang=ES-AR style='font-size:12.0pt'>
            <!-- //-- BLOQUE PARA COLOCAR EL PUESTO DEL ESTUDIANTE SEGUN EL PROMEDIO             -->                        
              <?php
                $objEstudiante = new Estudiante();
                $objEstudiante->sede = $sede;
                $objEstudiante->curso = $curso;
                $objEstudiante->anho = $anho;
                
                $objPuesto = new Puesto();
                $objPuesto->idMatri = $idMatricula;
                $objPuesto->cur = $curso;
                $objPuesto->anno = $anho;
                $objPuesto->per = $periodoBol;
                $objPuesto->listaEstudiantes = $objEstudiante->Listar();
                $objPuesto->totalAreas = $totalAreas;
                $objPuesto->promedioEstudiante = $promedioPeriodo;
                $objPuesto->puestoEstudiante();

              ?>
            </span>
        </p>
      </td>
      <td width='23%' style='width:23.98%;border:none;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
        <p class=MsoNormal align=right style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:right;line-height:normal'>
            <span style='font-size:10.0pt'>PROMEDIO GRUPO</span>
        </p>
      </td>
      <td width='8%' style='width:8.1%;border:solid windowtext 1.0pt;border-left:none;border-right:solid windowtext 1.5pt;padding:0cm 20.4pt 0cm 5.4pt'>
        <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:center;line-height:normal'>
            <span lang=ES-AR style='font-size:12.0pt;text-align:center;'>
            <!-- //PROMEDIO DEL GRUPO POR PERIODO
                $promedioGrupo = new Boletin();
                $promedioGrupo->promedioGrupo($centro,$sede,$anho,$periodoBol,$campo,$curso); -->
            </span>
        </p>
      </td>
   </tr>
   <tr>
    <td valign=top style='width:23.58%;border-top:solid windowtext 1.5pt;border-left:solid windowtext 1.5pt;border-bottom:solid windowtext 0.0pt;border-right: solid windowtext 0.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
      <p class=MsoNormal align=right style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:left;line-height:normal'>
          <span lang=ES-AR> OBSERVACIONES:</span>
      </p>
    </td>
    <td colspan=6 style='width:76.42%;border-top:solid windowtext 1.5pt;border-left:none;border-bottom:none;border-right:solid windowtext 1.5pt;padding:0cm 5.4pt 0cm 5.4pt'>
      <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'><span lang=ES-AR style='font-size:6.0pt'></span></p>
    </td>
   </tr>
   <tr>
      <td width='100%' colspan=7 valign=top style='width:100.0%;border:solid windowtext 1.5pt;border-top:none;padding:0cm 5.4pt 0cm 5.4pt'>
        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'><span lang=ES-AR style='font-size:6.0pt'>&nbsp;</span>

        <?php           
          $objObservacion = new observacionBoletin();
          $objObservacion->idMatricula = $idMatricula;
          $objObservacion->periodo = $_POST['periodo'];			
          $objObservacion->anho =$_POST['anho'];
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
          
          </p>
      </td>
   </tr>
</table>