<?php 
    //echo var_dump($_REQUEST);
    $objEstudiante = new Estudiante();
    $objEstudiante->idMatricula = $_POST['idMatricula'];
    $nombre = "";
    $foto = "silueta.jpg";
    foreach ($objEstudiante->cargarPorIdMatricula() as $estudiante) {
        $nombre = $estudiante['PrimerNombre']." ".$estudiante['SegundoNombre']." ".$estudiante['PrimerApellido']." ".$estudiante['SegundoApellido'];
        if($estudiante['foto'] != ""){
            $foto = $estudiante['foto'];
        }
    }


?>

<!-- Nota definitiva -->
<?php 
    $nota = "";
    $faltas = 0;
    $objCalificacion = new Calificacion();
    $objCalificacion->periodo = $_POST['periodo'];
    $objCalificacion->idMatricula = $_POST['idMatricula'];
    $objCalificacion->codArea = $_POST['area'];
    $objCalificacion->Anho = $_POST['anho'];
    $objCalificacion->curso = $_POST['curso'];
    $objCalificacion->tabla = "Area";

    foreach ($objCalificacion->cargar() as $notaArea) {
        $nota = $notaArea['NOTA'];
        $faltas =  $notaArea['Faltas'];
    }   
?>

<!-- logros -->
<?php 
    $objLogros = new Logro();
    $objLogros->periodo = $_POST['periodo'];
    $objLogros->codCurso = $_POST['curso'];
    $objLogros->codArea = $_POST['area'];
    $objLogros->tabla = "Area";
    $objLogros->calificacion = $nota;
?> 

<div class="contenedor-planilla">
    <div class="form-digitar">
        <div class="dt-basicos">
            <h3>ESTUDIANTE</h3>
            <img src="vistas/img/Usuarios/<?php echo $foto ?>" alt="foto">
            <div class="nom-estudiante">
                <h3 style="text-transform: uppercase;"><?php echo $nombre ?></h3>
            </div>
        </div>
        <hr>
        <div class="con-calificaciones" style="display: none;"> 
            <h3>CALIFICACIONES</h3>
                <div class="notas">
                <?php 
                $nt = 1;
                $objCriterios = NEW Criterio();
                foreach ($objCriterios->Listar() as $value) { ?>
                    <!-- <label for="CA1">Calificación No. <?php echo $nt; ?></label>
                    <input type="number" name="CA<?php echo $nt; ?>" class="form form-control"> -->
                <?php
                    $nt++;
                    $notaCriterio = "";
                                $objNotaCriterio = new Calificacion();
                                $objNotaCriterio->periodo = $_POST['periodo'];
                                $objNotaCriterio->idMatricula = $estudiante['idMatricula'];
                                $objNotaCriterio->codArea = $_POST['area'];
                                $objNotaCriterio->Anho = $_POST['anho'];
                                $objNotaCriterio->curso = $_POST['curso'];
                                $objNotaCriterio->tabla = "Area";
                                $objNotaCriterio->idCriterio = $value['codCriterio'];

                                $notaCriterio = $objNotaCriterio->cargarPorCriterio();
                                if($notaCriterio == ""){
                                   $accionCampo = "agregarNotaCriterio(".$estudiante['idMatricula'].",this.value,".$value['codCriterio'].",'Area')";
                                }else{
                                   $accionCampo = "modificarNotaCriterio(".$estudiante['idMatricula'].",this.value,".$value['codCriterio'].",'Area')";
                                }
                            ?>
                            <input type ='text' 
                                class ='form-control <?php echo $estudiante['idMatricula'] ?> criterios<?php echo $estudiante['idMatricula'] ?>'
                                style ="margin: 0px; height: 100%;"  
                                value ="<?php echo $notaCriterio; ?>" 
                                id ="<?php echo $value['codCriterio']."_".$estudiante['idMatricula'] ?>" 
                                onchange ="<?php echo $accionCampo ?>" 
                                
                                name ="notas[]"
                            > 
                <?php
                }
                ?>
                                    
                </div>
                <div class="esp-boton">
                    <button class="btn btn-primary btn-addNotas" ><i class="fa fa-plus">Agregar</i></button>
                </div>
        </div>

    </div>
    <div class="agregados">
        <div class="seccionNotas" id="seccionNotas">
            <?php include("seccionNotas.php"); ?>
        </div>
    </div>
</div>
    <div class="seccionLogros" style="width: 100%;" >             
        <h4>Logros</h4>
        <div id="logro" readonly="true" >
            <?php $objLogros->cargar(); ?>
        </div>
    </div>
<hr>
<button class="btn btn-warning"  data-dismiss="modal" style="width: 30%; padding:10px;right:30px;"> Cerrar</button>