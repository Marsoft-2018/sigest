<?php 
  if($periodo != 'Todos' && $tipoDatos == "Notas"){  ?>
<tr class='bordes2' height='24' style='height:18.0pt';border-top:3px double #000;>
      <td colspan='3' class='bordes2' ><div align='right'>PROMEDIO DEL GRUPO POR MATERIA:&nbsp;</div></td>
      
      <?php 
      foreach ($objArea->cargarPensum() as $area) { 
        
        for ($i=1; $i <= $periodo; $i++) { 
          $nota = 0;
          $objCalificacion = new Calificacion();
          $objCalificacion->periodo = $i;
          $objCalificacion->codArea = $area['id'];
          $objCalificacion->Anho = $_POST['anho'];
          $objCalificacion->curso = $_POST['curso'];

          $promedioArea = $objCalificacion->promedioAreaXcurso();
          ?>                          
          <td class="bordes" bgcolor=''>        
            <?php 
              echo round(($promedioArea / ($nolista-1) ), 2)  
            ?>
          </td> <?php           
        }

      }

      ?>


      <td colspan='2' class='bordes2'>
          <?php 
            //echo $promedioGrupo = round(($objCalificacion->promedioXcurso() / $nolista),2); 
            echo round($promedioCurso/($nolista-1),2);
          ?>       
      </td>
</tr>
<?php 
}
 ?>