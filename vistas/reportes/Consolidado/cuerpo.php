<?php 
    $nolista = 1;
    foreach ($objEstudiante->Listar() as $estudiante) { 
        $areasPerdidas = $totalAreas;

    ?>
    <tr>
        <td class="bordes" style="border-right:1.0pt solid black; font-size: 11px; text-align:left; ">
            <?php echo $estudiante['num_interno'] ?>
        </td>
        <td class="bordes" style="border-right:1.0pt solid black"><?php echo $nolista ?></td>
        <td class="bordesnom" style="font-size:11px;padding:3px;">
            <?php echo $estudiante['PrimerApellido']." ". $estudiante['SegundoApellido']." ". $estudiante['PrimerNombre']." ". $estudiante['SegundoNombre'] ?> 
        </td>
        <?php 
            $promedio = 0;
            $objAreaEst = new Area();
            $objAreaEst->idGrado = $grado;
            $objAreaEst->anho = $anho;
            $objAreaEst->codSede = $_POST['sede'];
            foreach ($objAreaEst->cargarPensum() as $area) {
                $nota = "-"; 
                if($periodo != "Todos"){  
                    switch ($tipoDatos) {
                        case 'NotasPeriodo':
                            $nota = "-";
                            $objNota = new Calificacion();
                            $objNota->periodo = $periodo;
                            $objNota->idMatricula = $estudiante['idMatricula'];
                            $objNota->codArea = $area['id'];
                            $objNota->Anho = $_POST['anho'];
                            $objNota->curso = $_POST['curso'];
                            $objNota->grado = $grado;
                            $objNota->tipoPromedio = $area['formaDePromediar'];

                            foreach ($objNota->cargar() as $notaArea) {
                                $nota = round($notaArea['NOTA'],1);
                            } 

                            $objDesempeno = new Desempenos();
                            $objDesempeno->nota = $nota;
                            $des = $objDesempeno->cargar(); 
                            if(is_numeric($nota)){
                                $nota = $objNota->formato_notas($nota);
                            }
                            switch ($des) {
                                case 'BAJO':
                                    echo "<td class='bordes' style='color:#f00;'>".$nota."</td>";
                                    $areasPerdidas = $areasPerdidas + 1;
                                    break;
                                
                                default:
                                    echo "<td class='bordes'>".$nota."</td>";
                                    break;
                            }   
                        break;                        
                        case 'NotasAnteriores':
                            for ($i=1; $i <= $periodo ; $i++) { 
                                $nota = "-";
                                $objNota = new Calificacion();
                                $objNota->periodo = $i;
                                $objNota->idMatricula = $estudiante['idMatricula'];
                                $objNota->codArea = $area['id'];
                                $objNota->Anho = $_POST['anho'];
                                $objNota->curso = $_POST['curso'];
                                $objNota->grado = $grado;
                                $objNota->tipoPromedio = $area['formaDePromediar'];

                                foreach ($objNota->cargar() as $notaArea) {
                                    $nota = round($notaArea['NOTA'],1);
                                } 

                                $objDesempeno = new Desempenos();
                                $objDesempeno->nota = $nota;
                                $des = $objDesempeno->cargar();
                                if(is_numeric($nota)){
                                    $nota = $objNota->formato_notas($nota);
                                }

                                switch ($des) {
                                case 'BAJO':
                                    echo "<td class='bordes' style='color:#f00;'>".$nota."</td>";
                                    break;
                                
                                default:
                                    echo "<td class='bordes'>".$nota."</td>";
                                    break;
                                }  
                            }        
                            break;
                        case 'Desempeno':
                            for ($i=1; $i <= $periodo ; $i++) { 
                                $nota = "-";
                                $objNota = new Calificacion();
                                $objNota->periodo = $i;
                                $objNota->idMatricula = $estudiante['idMatricula'];
                                $objNota->codArea = $area['id'];
                                $objNota->Anho = $_POST['anho'];
                                $objNota->curso = $_POST['curso'];
                                $objNota->grado = $grado;
                                $objNota->tipoPromedio = $area['formaDePromediar'];

                                foreach ($objNota->cargar() as $notaArea) {
                                    $nota = round($notaArea['NOTA'],1);
                                } 

                                $objDesempeno = new Desempenos();
                                $objDesempeno->nota = $nota;
                                $des = $objDesempeno->cargar();
                                switch ($des) {
                                    case 'BAJO':
                                        echo "<td class='bordes' style='color:#f00;'>".$des."</td>";
                                        break;                                
                                    default:
                                        echo "<td class='bordes'>".$des."</td>";
                                        break;
                                }                        
                            }
                            break;
                        case 'Acumulado':                                   
                            $acumulado = 0;
                            
                            if($periodo == "Todos"){
                                $objPeriodoMax = new Periodo();
                                $periodo = $objPeriodoMax->periodoMax();
                            }
                            
                            for ($i = 1; $i <= $periodo ; $i++) { 
                                $nota = 0;
                                $porcentajePeriodo = 0;
                                $objCalif = new Calificacion();
                                $objPeriodo = new Periodo();
                                $objPeriodo->periodo = $i;
                                foreach ($objPeriodo->valorPeriodo() as $dato) {
                                    $porcentajePeriodo = $dato['valorPeriodo'];
                                }
                                
                                $objCalif->periodo = $i;
                                $objCalif->idMatricula = $estudiante['idMatricula'];
                                $objCalif->codArea = $area['id'];
                                $objCalif->Anho = $_POST['anho'];
                                $objCalif->curso = $_POST['curso'];
                                $objCalif->grado = $grado;
                                $objCalif->tipoPromedio = $area['formaDePromediar'];
                                foreach ($objCalif->cargar() as $notaArea) {
                                    $nota = round($notaArea['NOTA'],1);
                                }
                                $objCalif->nota = $nota;
                                $objCalif->porPeriodo = $porcentajePeriodo;
                                
                                $acumulado = $acumulado + $objCalif->acumulado();                      
                            }

                            if($acumulado >= 3.45 and $acumulado < 3.5){
                                $acumulado = 3.5;
                            }

                            $nota = $acumulado; 

                            $color = "";

                            if($periodo == 3 or $periodo == 4){
                                $objDesempeno = new Desempenos();
                                $objDesempeno->nota = $nota;
                                $des = $objDesempeno->cargar();
                                switch ($des) {
                                    case 'BAJO':
                                        $color = "style='background-color:#f00;'";
                                        break;
                                    
                                    default:
                                        $color = "";
                                        break;
                                }                                 
                            } 

                            $acumulado = $objCalif->formato_notas($acumulado);
                            echo "<td class='bordes' $color> ".round($acumulado,2)." </td>";   
                        break;
                        case 'Nota Requerida':                            
                            $acumulado = 0;
                            $sumaPorcentajes = 0;
                            $objPeriodoMax = new Periodo();
                            $periodoMax = $objPeriodoMax->periodoMax();
                            
                            if($periodo != "Todos" && $periodo != $periodoMax){
                                for ($i = 1; $i <= $periodo ; $i++) { 
                                    $nota = 0;
                                    $porcentajePeriodo = 0;
                                    $objCalif = new Calificacion();
                                    $objPeriodo = new Periodo();
                                    $objPeriodo->periodo = $i;
                                    foreach ($objPeriodo->valorPeriodo() as $dato) {
                                        $porcentajePeriodo = $dato['valorPeriodo'];
                                    }
                                    
                                    $sumaPorcentajes = $sumaPorcentajes + $porcentajePeriodo;
                                    $objCalif->periodo = $i;
                                    $objCalif->idMatricula = $estudiante['idMatricula'];
                                    $objCalif->codArea = $area['id'];
                                    $objCalif->Anho = $_POST['anho'];
                                    $objCalif->curso = $_POST['curso'];
                                    $objCalif->grado = $grado;
                                    $objCalif->tipoPromedio = $area['formaDePromediar'];

                                    foreach ($objCalif->cargar() as $notaArea) {
                                        $nota = round($notaArea['NOTA'],1);
                                    }  
                                    $objCalif->nota = $nota;
                                    $objCalif->porPeriodo = $porcentajePeriodo;
                                    $acumulado = $acumulado + $objCalif->acumulado();         
                                    
                                    
                                }
                                $nota = $acumulado; 
                                
                                //echo $sumaPorcentajes."<br>";
                                $notaMin = $objCalif->notaMinima();
                                $notaRequerida = round(($notaMin - $nota ) * 4,1);
                                $background = "";
                                if($notaRequerida > $objCalif->notaMaxima()){
                                    $background = "background-color:red;";
                                }elseif($notaRequerida >= 4.5){
                                    $background = "background-color:#efda65;";
                                }
                                echo "<td class='bordes' style='$background'>";
                                //echo $notaRequerida;
                                echo $objCalif->formato_notas($notaRequerida);
                                echo "</td>"; 
                            }else{
                                echo "<td class='bordes'> - </td>";
                            } 
                        break;
                        case 'Definitivo':                                   
                            $acumulado = 0;
                            $areasPerdidas = 0;
                            if($periodo == "Todos"){
                                $objPeriodoMax = new Periodo();
                                $periodo = $objPeriodoMax->periodoMax();
                            }
                            
                            for ($i = 1; $i <= $periodo ; $i++) { 
                                $nota = 0;
                                $porcentajePeriodo = 0;
                                $objCalif = new Calificacion();
                                $objPeriodo = new Periodo();
                                $objPeriodo->periodo = $i;
                                foreach ($objPeriodo->valorPeriodo() as $dato) {
                                    $porcentajePeriodo = $dato['valorPeriodo'];
                                }
                                
                                $objCalif->periodo = $i;
                                $objCalif->idMatricula = $estudiante['idMatricula'];
                                $objCalif->codArea = $area['id'];
                                $objCalif->Anho = $_POST['anho'];
                                $objCalif->curso = $_POST['curso'];
                                $objCalif->grado = $grado;
                                $objCalif->tipoPromedio = $area['formaDePromediar'];
                                foreach ($objCalif->cargar() as $notaArea) {
                                    $nota = round($notaArea['NOTA'],1);
                                }
                                $objCalif->nota = $nota;
                                $objCalif->porPeriodo = $porcentajePeriodo;
                                
                                $acumulado = $acumulado + $objCalif->acumulado();                      
                            }

                            if($acumulado >= 3.45 and $acumulado < 3.5){
                                $acumulado = 3.5;
                            }

                            $nota = $acumulado; 

                            $color = "";

                            $objDesempeno = new Desempenos();
                            $objDesempeno->nota = $nota;
                            $des = $objDesempeno->cargar();
                            //echo $des;
                            if ($des == 'BAJO') {
                                $color = "style='background-color:#f00;'";
                                $areasPerdidas = $areasPerdidas + 1;
                            }else{
                                $color = "";
                            }
                          
                            echo "<td class='bordes' $color> ".round($acumulado,1)." </td>";   
                        break;
                    }       
                }
            }?>        
                <td class='bordes3'>
                    <?php 
                        $objCalificacion = new Calificacion(); 
                        $objCalificacion->periodo = $periodo;
                        $objCalificacion->idMatricula = $estudiante['idMatricula'];
                        $objCalificacion->Anho = $_POST['anho'];
                        $objCalificacion->curso = $_POST['curso'] ;
                        $promedio = $objCalificacion->promedioEstudiante($tipoDatos);
                        $promedioEst = round(($promedio / $totalAreas),2);
                        echo $objCalificacion->formato_notas($promedioEst);
                        //echo  $promedioEst;
                        $promedioCurso += $promedioEst;
                    ?>
                    <?php $promedios[] = ($promedio / $totalAreas) ?>
                </td>
                <td class='bordes4'>
                    
                    <?php 
                        $objPuesto = new Puesto();
                        $objPuesto->idMatri = $estudiante['idMatricula'];
                        $objPuesto->cur = $_POST['curso'];
                        $objPuesto->anno = $anho;
                        $objPuesto->per = $periodo;
                        $objPuesto->listaEstudiantes = $objEstudiante->Listar();
                        $objPuesto->totalAreas = $totalAreas;
                        $objPuesto->promedioEstudiante = $promedioEst;
                        $objPuesto->puestoEstudiante();
                    ?>
                </td>
                <?php if ($tipoDatos == "Definitivo") { ?>
                <td class='bordes4'>                    
                    <?php 
                        $objCal = new Calificacion();
                        echo $objCal->estadoAnho($areasPerdidas,$areasParaPerder);
                    ?>
                </td>
                <?php } ?>
    </tr>

<?php 
        $nolista++; 
    }
 ?>					        
            <!-- }else{
                //Cuando se quiere mostrar todos los periodos
                if($tipoConsolidado == 'General'){
                    <td class='bordesnom' style='font-size:10px;padding:3px;width:100px;' colspan=''>
                    echo    utf8_encode($alumno[3])." ".utf8_encode($alumno[4])." ".utf8_encode($alumno[1])." ".utf8_encode($alumno[2])." 
                    </td>";
                    $objNota = new bloqueNota();
                    $objNota->cargar($usuario,$alumno[0],$alumno[5],$periodo,$anho,$sede,$campo,$tipoDato,$inst);                         
                    $objNota->vistaPromedioDefinitivo($alumno[5],$anho,$sede,$campo,$tipoDato,$inst);
                    
                    <td class='bordes4'>";
                            $objPro=new Puestos ();
                            $objPro->finalGrupo($inst,$sede,$anho,$periodo,$curso,$alumno[5]); // Puesto Final en el grupo                       
                    </td>";

                    $nolista++;	
                }elseif($tipoConsolidado == 'Definitivo'){
                    <td class='bordesnom' style='font-size:10px;padding:3px;width:100px;' colspan=''>";
                    echo    utf8_encode($alumno[3])." ".utf8_encode($alumno[4])." ".utf8_encode($alumno[1])." ".utf8_encode($alumno[2])." ";
                    </td>";
                    $objNota = new bloqueNota();
                    $objNota->vistaNotaDefinitiva($usuario,$alumno[5],$periodo,$anho,$sede,$campo,$tipoDato,$inst);// Nota Definitiva
                    $objNota->vistaPromedioDefinitivo($alumno[5],$anho,$sede,$campo,$tipoDato,$inst);// Promedio Definitivo
                    $objNota->vistaEstadoDefinitivo($usuario,$alumno[5],$periodo,$anho,$sede,$campo,$tipoDato,$inst); // estado del año lectivo
                    $nolista++;
                }
            }    -->
