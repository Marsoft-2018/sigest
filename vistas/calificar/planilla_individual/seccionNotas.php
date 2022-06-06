<div class="divListaDeNotas" id="listaDeNotas">
    <h3>CALIFICACIONES AGREGADAS</h3>
    <table class="table table-striped">
        <?php 
            $nt = 1;
                $objNotaCriterio = new Calificacion();
                $objNotaCriterio->periodo = $_POST['periodo'];
                $objNotaCriterio->idMatricula = $estudiante['idMatricula'];
                $objNotaCriterio->codArea = $_POST['area'];
                $objNotaCriterio->Anho = $_POST['anho'];
                $objNotaCriterio->curso = $_POST['curso'];
                $objNotaCriterio->tabla = "Area";
            foreach ($objNotaCriterio->listarNotasPorCriterio() as $campo) {   ?>
            <tr style="padding:0px; margin:0px;">
                <th style="padding:0px; margin:0px;width:40%;">
                    NOTA <?php echo $nt; ?>
                </th>
                <td style="padding:0px; margin:0px;width:30%;">
                    <div>
                        <input type="number" name="" id="<?php echo $campo['id'] ?>" step="any" class="form form-control" value="<?php echo $campo['nota']; ?>" >    
                    </div>
                </td>
                <td style="padding:0px; margin:0px;">
                    <button class="btn btn-success" title="Guardar nota" onclick="modificarNotaEspecifica('<?php echo $campo['id'] ?>')"> <i class="fa fa-check"></i></button>
                </td>
                <td style="padding:0px; margin:0px;">
                    <button class="btn btn-danger" title="Eliminar nota" onclick="eliminarNotaEspecifica('<?php echo $campo['id'] ?>')"> <i class="fa fa-trash"></i></button>
                </td>
            </tr> 
            <?php
                $nt++;
            }
            ?>

    </table>
</div>
<div class="divDefinitiva" >
    <?php 
        $des = "";
        $objDesempeno = new Desempenos();
        $objDesempeno->nota = $nota;
        $des = $objDesempeno->cargar();
    ?>
    <h4>NOTA DEFINITIVA</h4>
    <div class="notaDef" id="notaDefinitiva">
        <?php echo $nota; ?>
        <h5>DESEMPEÑO</h5>
        <span id="divDesempeño" class="marcoDesempeno <?php echo $des; ?>" style="font-size: 0.5em"><?php echo $des; ?></span>
    </div>
</div>