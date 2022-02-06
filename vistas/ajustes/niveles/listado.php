<button type="button" id="btnNuevoGrado" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop"  onclick="nuevoNivel()" style="width: 50%; margin:20px 0px; padding:7px;">
    <i class="fa fa-plus"> </i> Nuevo Nivel
</button>  
<table class='table table-striped' style='font-size:12px;'>
    <thead>
        <tr style='background-color: #AABED9;'>
            <th >Abreviatura/código</th>
            <th style='width:40%;'>Nombre</th>
            <th >No. orden</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody id='tNiveles'>                                            
        <?php
            $objNivel = new Nivel();
            //$objNivel->idInst = $_SESSION['institucion'];

            foreach ($objNivel->listar() as $nivel) {
            ?>
                <tr>
                    <td style="margin:0px; padding: 0px; text-align:center;font-size: 11px;">
                        <?php echo $nivel['CODNIVEL'] ?>
                    </td>
                    <td style="margin:0px; padding: 0px;">
                        <?php echo $nivel['NOMBRE_NIVEL'] ?>
                    </td>   
                    <td style="margin:0px; padding: 0px; ">
                        <?php echo $nivel['orden'] ?>
                    </td>                   
                    <td style="margin:0px; padding: 3px; text-align:center;" >
                        <button class="btn btn-danger" onclick="eliminarNivel('<?php echo $nivel['CODNIVEL'] ?>')" ><i class="fa fa-trash"></i></button>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#staticBackdrop"  onclick="editarNivel('<?php echo $nivel['CODNIVEL'] ?>')" ><i class="fa fa-pencil"></i></button>
                    </td>   
                </tr>
            <?php
            }                                                    
        ?>
    </tbody>
</table>