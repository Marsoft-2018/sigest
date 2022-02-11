<?php 
    echo var_dump($_REQUEST);
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
        <h3>CALIFICACIONES</h3>
        <div class="con-calificaciones">
            <form action="#">
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
            </form>
        </div>

    </div>
    <div class="agregados">
        <h3>CALIFICACIONES AGREGADAS</h3>
        <table class="table table-striped">
            <?php 
                $nt = 1;
                $objCriterios = NEW Criterio();
                foreach ($objCriterios->Listar() as $value) { 
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
                <tr>
                    <th>
                        NOTA <?php echo $nt; ?>
                    </th>
                    <td>
                        <div><?php echo $notaCriterio; ?></div>
                    </td>
                </tr> 
                <?php
                }
                ?>

        </table>
        <h4>Logro</h4>
        <textarea name="logro" id="logro" cols="30" rows="10" readonly="true" class="form form-control">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Temporibus soluta impedit dolore quia velit doloribus mollitia qui eius dicta sequi totam necessitatibus autem accusantium facere perspiciatis earum, quos libero nulla.
        </textarea>
    </div>
</div>