<style>
    .bloque-dimension{
        border: 1px solid #000;
        display: flex;
        justify-content: flex-start;
        flex-flow: column nowrap;
        align-items: center;
        margin:0px;
    }
    .dimension-datos{
        border: 1px solid #000;
        display: flex;
        justify-content: space-around;
        flex-flow: row nowrap;
        align-items: stretch;
        width: 100%;
    }

    .dimension-juicio{
        align-self: flex-start;
        flex-grow: 4;
        padding: 5px;
    }
    .dimension-desempeño{
        align-self: center;
        flex-grow: 0.5;
    }
</style>
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
        <h4 style="text-transform: uppercase; text-align: left; font-weight: bold;width: 85%;flex-grow:4;"><?php echo $area['Nombre'] ?></h4>
        <p>inasistencias: <strong><?php echo $faltas; ?> </strong></p>
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
                if($desmFinal == "BAJO"){
                    $areasPerdidas += 1;
                    $areaAplazada = $area['Nombre'];
                }
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