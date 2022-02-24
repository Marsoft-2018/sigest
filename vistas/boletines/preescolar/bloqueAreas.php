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
                $objLogros = new Logro();
                $objLogros->periodo = $periodoBol;
                $objLogros->codCurso = $curso;
                $objLogros->codArea = $area['id'];
                $objLogros->calificacion = $calificacion;
                $objLogros->cargar();
            ?>
        </div>
        <div class="dimension-desempeño">
        <?php 
            $objDesempeno = new Desempenos();
            $objDesempeno->nota = $calificacion;
            $desempeno = $objDesempeno->cargar(); 
            if($desempeno != ""){
                //echo $desempeno;
                echo "<img src='../vistas/img/desempenos/".$desempeno.".png' />"; 
            }
            ?>
        </div>
    </div>
</div>