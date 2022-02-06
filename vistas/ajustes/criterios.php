<table class='table table-striped' style='font-size:12px;'>
    <thead>
        <tr style='background-color: #AABED9;'>
            <th align='right'>ID</th>
            <th style='width:50%;'>NOMBRE DEL CRITERIO</th>
            <th style='width:20%;'>PORCENTAJE</th>
            <th  colspan='2'>ACCIONES</th>
        </tr>
    </thead>
    <tbody id='listaCriterios'>
        <?php
            $objCriterio = new Criterio();
            $objCriterio->codinst = $_SESSION['institucion'];
            foreach ($objCriterio->Listar() as $criterio) {
               ?>
                <tr class="apuntado">
                    <td align="right" style="margin:0px; padding: 0px; text-align:left;font-size: 11px;">
                        <input type="text" class="form form-control" id="Cl<?php echo $criterio['codCriterio'] ?>" value="<?php echo $criterio['codCriterio'] ?>" readonly="true" style="margin:0px;border:0px;">
                    </td>                                            
                    <td style="margin:0px; padding: 0px; text-align:left;font-size: 11px;">
                        <input type="text" class="form form-control" id="NC<?php echo $criterio['codCriterio'] ?>" value="<?php echo $criterio['nomCriterio'] ?>" style="margin:0px;border:0px;">
                    </td>
                    <td style="margin:0px; padding: 0px; text-align:left;font-size: 11px;">
                        <input type="number" class="form form-control" id="PC<?php echo $criterio['codCriterio'] ?>"  value="<?php echo $criterio['porcentaje'] ?>" style="margin:0px;border:0px;" step=".01" min="1" max="100">
                    </td>                                                   
                    <td style="margin:0px; padding: 0px; text-align:left;font-size: 11px;">
                        <button type="button" 
                            id = "<?php echo $criterio['codCriterio'] ?>"
                            class = "btn btn-success" 
                            title = "Guardar Criterio"  
                            onclick = "modificarCriterio(this.id)">
                                <i class="fa fa-save"></i>
                        </button>
                    </td>
                    <td style="margin:0px; padding: 0px; text-align:left;font-size: 11px;">
                        <button type="button" 
                            id = "<?php echo $criterio['codCriterio'] ?>" 
                            class = "btn btn-danger" 
                            title = "Eliminar Criterio"  
                            onclick = "eliminarCriterio(this.id)">
                            <i class="fa fa-close"></i>
                        </button>
                    </td>   
                </tr>
            <?php 
            }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" style='height:23px;'><h4>Nuevo Críterio</h4></td>
        </tr>
        <tr>
            <td>
                <label for="">Nombre del criterio:</label>
                <input type='Text' id='criterioNuevo' required value='' placeholder='Críterio' class='form form-control'>
            </td>
            <td>
                <label for="">Porcentaje</label>
                <input type='Text' id='porcCriterioNuevo' required value='' placeholder='Porcentaje' class='form form-control'  step=".01" min="1" max="100">
            </td>
            <td align='center'>
                <button type='button' id='btnAgCriterio' class='btn btn-primary' style='margin-top:20px;' onclick="agregarCriterio()">
                    <i class='fa fa-plus'></i> Agregar
                </button>
            </td>
        </tr>
    </tfoot>
</table>