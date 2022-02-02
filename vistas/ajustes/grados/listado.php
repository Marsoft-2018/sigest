<button type="button" id="btnNuevoGrado" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop"  onclick="nuevoGrado()" style="margin:20px;">
    <i class="fa fa-plus"></i> Nuevo
</button>                                                                  
                
<table class='table table-striped' style='font-size:12px;'>
    <thead>
        <tr style='background-color: #AABED9;'>
            <th >Código</th>
            <th style='width:20%;'>Nombre</th>
            <th style='width:20%;'>Abreviatura</th>
            <th>Estilo desempeño</th>
            <th colspan='2' >Acciones</th>
        </tr>
    </thead>
    <tbody id='tGrados'>                                            
        <?php
            $objGrado = new Grado();

            foreach ($objGrado->listar() as $grado) {
            ?>
                <tr>
                    <td style="margin:0px; padding: 0px; text-align:center;font-size: 11px;">
                        <?php echo $grado['CODGRADO'] ?>
                    </td>
                    <td style="margin:0px; padding: 0px;">
                        <?php echo $grado['NOMGRADO'] ?>
                    </td>   
                    <td style="margin:0px; padding: 0px; ">
                        <?php echo $grado['nomCampo'] ?>
                    </td>   
                    <td style="margin:0px; padding: 0px; ">
                        <?php echo $grado['estiloDesempeno'] ?>
                    </td>                   
                    <td style="margin:0px; padding: 3px; text-align:center;" >
                        <button class="btn btn-danger" data-toggle="modal" data-target="#staticBackdrop"  onclick="eliminarGrado(<?php echo $grado['CODGRADO'] ?>)" ><i class="fa fa-trash"></i></button>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#staticBackdrop"  onclick="editarGrado(<?php echo $grado['CODGRADO'] ?>)" ><i class="fa fa-pencil"></i></button>
                    </td>   
                </tr>
            <?php
            }                                                    
        ?>
    </tbody>
</table>