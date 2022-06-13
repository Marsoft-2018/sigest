<?php 
    $objCalificaciones = new Calificacion();        
    $objCalificaciones->curso = $curso;
    $objCalificaciones->Anho = $anho;
    $objCalificacion->idMatricula = $idMatricula;
    $objCalificacion->codArea =  $area['id'];
    $objCalificacion->grado = $area['idGrado'];
    $objCalificacion->tipoPromedio = $area['formaDePromediar'];
    $objCalificacion->periodo =$periodoBol;
    
    $calificacion = 0;
    $faltas = 0;

    foreach ($objCalificacion->cargar() as $calif) {
        $calificacion = $calif['NOTA']; 
        $faltas = $calif['Faltas'];      
    } 
    
    $objDesempeno = new Desempenos();
    $objDesempeno->nota = $calificacion;
    $desempeno = $objDesempeno->cargar(); 
?>
<div class="bloque-dimension">
    <div class="dimension-datos dimension-nombre">
        <h4 style="text-transform: uppercase; text-align: left; font-weight: bold; width: 85%; flex-grow:4; padding: 3px; margin: 0px;"><?php echo $area['Nombre'] ?></h4>
        <h5 style="padding-right:5px;">Inasistencias: <strong><?php echo $faltas; ?> </strong></h5>
    </div>
    <div class="dimension-datos">
        <div class="dimension-juicio">
            <strong>Juicio Valorativo: </strong><br> 
            <?php 
                $objCriterios = new Criterio();
                
                foreach($objCriterios->Listar() as $criterio){
                    //echo $criterio['codCriterio']." ".$criterio['nomCriterio']."<br>";
                    
                    $objLogros = new Logro();
                    $objLogros->periodo = $periodoBol;
                    $objLogros->codCurso = $curso;
                    $objLogros->codArea = $area['id'];
                    
                    $objCalificacionCriterio = new Calificacion();
                    $objCalificacionCriterio->periodo = $periodoBol;
                    $objCalificacionCriterio->idMatricula = $idMatricula;
                    $objCalificacionCriterio->codArea = $area['id'];
                    $objCalificacionCriterio->Anho = $anho;
                    $objCalificacionCriterio->curso = $curso;
                    $objCalificacionCriterio->idCriterio = $criterio['codCriterio'];
                    $objCalificacionCriterio->tabla = "Area";

                        
                    $objDesempenoCriterio = new Desempenos();
                    $objDesempenoCriterio->nota = $objCalificacionCriterio->cargarPorCriterio();
                    $desempenoCriterio = $objDesempenoCriterio->cargar(); 

                    //echo "Criterio: ".$criterio['nomCriterio']."Desempeño: ".$desempenoCriterio."<br>";
                    $objLogros->calificacion = $objCalificacionCriterio->cargarPorCriterio();
                    $objLogros->codCriterio = $criterio['codCriterio'];
                    $objLogros->estado = 1;
                    foreach($objLogros->listarLogrosCriterios() as $logro) {
                        switch ($desempenoCriterio) {
                            case 'BAJO':
                                echo "<li><img src='../vistas/img/desempenos/".$desempenoCriterio.".png' width='20px'/> Tengo dificultad para ".$logro['INDICADOR'].".</li>";
                                break;
                            case 'BASICO':
                                echo "<li><img src='../vistas/img/desempenos/".$desempenoCriterio.".png' width='20px'/>Soy capaz de ".$logro['INDICADOR'].'.</li>';
                                break;
                            case 'ALTO':
                                echo "<li><img src='../vistas/img/desempenos/".$desempenoCriterio.".png' width='20px'/>Tengo muy buenas habilidades para ".$logro['INDICADOR'].'.</li>';
                                break;
                            case 'SUPERIOR':
                                echo "<li><img src='../vistas/img/desempenos/".$desempenoCriterio.".png' width='20px'/> Demuestro habilidades superiores para ".$logro['INDICADOR'].'.</li>';
                                break;
                        }
                    }                
                }

            ?>
        </div>
        <div class="dimension-desempeño">
        <?php 
            
            if($desempeno != ""){
                //echo $desempeno;
                echo "<img src='../vistas/img/desempenos/".$desempeno.".png' />"; 
            }
            ?>
        </div>
    </div>
</div>