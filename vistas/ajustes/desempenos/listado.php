<button type="button" id="btnNuevoDesempeno" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop"  onclick="nuevoDesempeno()" style="width: 50%; margin:20px 0px; padding:7px;">
    <i class="fa fa-plus"></i> Nuevo Desempeno
</button>                                                                  
                
<table class='table table-striped' style='font-size:12px;'>
    <thead>
        <tr style='background-color: #AABED9;'>
            <th >Desempeño</th>
            <th style='width:20%;'>Limite Inferior(de)</th>
            <th style='width:20%;'>Limite Superior(hasta)</th>
            <th>Ícono</th>
            <th colspan='2' >Acciones</th>
        </tr>
    </thead>
    <tbody id='tDesempenos'>                                            
    <?php
            $objDesemp = new Desempenos();
            $objDesemp->idInst = $_SESSION['institucion'];

            foreach ($objDesemp->Listar() as $key => $desemp) {
            ?>
                <tr class="apuntado" style="margin:0px; padding: 0px; font-size: 1.2em">
                    <td style="margin:0px; padding: 0px;">
                        <?php echo $desemp['CONCEPT'] ?>
                    </td>
                    <td style="margin:0px; padding: 0px;">
                        <?php echo $desemp['limiteInf'] ?>
                    </td>   
                    <td style="margin:0px; padding: 0px; ">
                        <?php echo $desemp['limiteSup'] ?>
                    </td>                    
                    <td style="margin:0px; padding: 3px; text-align:center;" >
                        <img src="vistas/img/desempenos/<?php echo $desemp['emoticon'] ?>" id="<?php echo $desemp['idDes'] ?>" width="25" height="25" title="cambiar imágen" class="iconosAcciones" onclick="cambiarEmoticon(this.id)"></img>
                    </td>                    
                    <td style="margin:0px; padding: 3px; text-align:center;" >
                        <button class="btn btn-danger" title="Eliminar desempeño" onclick="eliminarDesempeno(<?php echo $desemp['idDes'] ?>)" ><i class="fa fa-trash"></i></button>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#staticBackdrop"  onclick="editarDesempeno(<?php echo $desemp['idDes'] ?>)" ><i class="fa fa-pencil"></i></button>
                    </td>   
                </tr>
            <?php
            }                                                    
        ?>
    </tbody>
</table>