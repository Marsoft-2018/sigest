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
            $objGrado = new grados();

            foreach ($objGrado->listar() as $grado) {
            ?>
                <tr class="apuntado">
                    <td style="margin:0px; padding: 0px; text-align:center;font-size: 11px;">
                        <input type="text" class="form form-control" id="COD<?php echo $grado['CODGRADO'] ?>" value="<?php echo $grado['CODGRADO'] ?>" required style="margin:0px;border:0px;" onchange="modificarGrado(this.id,this.value)">
                    </td>
                    <td style="margin:0px; padding: 0px;">
                        <input type="text" class="form form-control" id="NOM<?php echo $grado['CODGRADO'] ?>"  required value="<?php echo $grado['NOMGRADO'] ?>" style="margin:0px;border:0px; text-align:right;" onchange="modificarGrado(this.id,this.value)">                
                    </td>   
                    <td style="margin:0px; padding: 0px; ">
                        <input type="text" class="form form-control" id="ABR<?php echo $grado['CODGRADO'] ?>"  required value="<?php echo $grado['nomCampo'] ?>" style="margin:0px;border:0px;text-align:right;" onchange="modificarGrado(this.id,this.value)">
                    </td>   
                    <td style="margin:0px; padding: 0px; ">
                        <input type="text" class="form form-control" id="DES<?php echo $grado['CODGRADO'] ?>"  required value="<?php echo $grado['estiloDesempeno'] ?>" style="margin:0px;border:0px;text-align:right;" onchange="modificarGrado(this.id,this.value)">
                    </td>                   
                    <td style="margin:0px; padding: 3px; text-align:center;" >
                        <img src="vistas/img/Iconos/eliminar.png" id="<?php echo $grado['CODGRADO'] ?>" width="20" height="20" title="Eliminar gradoeño" class="iconosAcciones apuntado2" onclick="eliminarGrado(this.id)"></img>
                    </td>   
                </tr>
            <?php
            }                                                    
        ?>
    </tbody>
</table>