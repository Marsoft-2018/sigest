
<table class='table table-striped' style='font-size:12px;'>
    <thead>
        <tr style='background-color: #AABED9;'>
            <th >Abreviatura/código</th>
            <th style='width:40%;'>Nombre</th>
            <th >No. orden</th>
            <th colspan='2' >Acciones</th>
        </tr>
    </thead>
    <tbody id='tNiveles'>                                            
        <?php
            $objNivel = new Nivel();
            $objNivel->idInst = $_SESSION['institucion'];

            foreach ($objNivel->listar() as $key => $nivel) {
            ?>
                <tr class="apuntado">
                    <td style="margin:0px; padding: 0px; text-align:center;font-size: 11px;">
                        <input type="text" class="form form-control" id="DE<?php echo $nivel['CODNIVEL'] ?>" value="<?php echo $nivel['CODNIVEL'] ?>" required style="margin:0px;border:0px;" onchange="modificarNivel(this.id,this.value)">
                    </td>
                    <td style="margin:0px; padding: 0px;">
                        <input type="text" class="form form-control" id="LI<?php echo $nivel['CODNIVEL'] ?>"  required value="<?php echo $nivel['NOMBRE_NIVEL'] ?>" style="margin:0px;border:0px;" onchange="modificarNivel(this.id,this.value)">                
                    </td>   
                    <td style="margin:0px; padding: 0px; ">
                        <input type="text" class="form form-control" id="LS<?php echo $nivel['CODNIVEL'] ?>"  required value="<?php echo $nivel['orden'] ?>" style="margin:0px;border:0px;text-align:center;" onchange="modificarNivel(this.id,this.value)">
                    </td>                   
                    <td style="margin:0px; padding: 3px; text-align:center;" >
                        <img src="vistas/img/Iconos/eliminar.png" id="<?php echo $nivel['CODNIVEL'] ?>" width="20" height="20" title="Eliminar nivele" class="iconosAcciones apuntado2" onclick="eliminarNivel(this.id)"></img>
                    </td>   
                </tr>
            <?php
            }                                                    
        ?>
    </tbody>
</table>
<form action="" method="POST" onsubmit="return agregarNivel()">
    <table>
        <tr>
            <td colspan="4" style="height:23px;"><h3>Nuevo nivel</h3></td>
        </tr> 
            <tr>
                <td>
                    <label>Abreviatura</label>
                    <input type="text" name="CODNIVEL" id="CODNIVEL" required class="form-control">                    
                </td>
                <td>
                    <label>Nombre</label>
                    <input type="text" class="form-control" name="NOMBRE_NIVEL" id="NOMBRE_NIVEL" required value="">
                </td>
                <td>
                    <label>No. de orden</label>
                    <input type="number" class="form-control" name="orden" id="orden" required value="" title="Ingrese aquí el número par el orden de prioridad en el nivel" step="any" min="0">
                </td>
                <td>
                   <button type="submit" id="btnAjnivel" class="btn btn-primary" style="margin-top:20px;"><i class="fa fa-plus"></i> Agregar</button>                                                                  
                </td>
            </tr>
    </table>
</form>