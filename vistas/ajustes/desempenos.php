
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
                <tr class="apuntado">
                    <td style="margin:0px; padding: 0px; text-align:center;font-size: 11px;">
                        <input type="text" class="form form-control" id="DE<?php echo $desemp['idDes'] ?>" value="<?php echo $desemp['CONCEPT'] ?>" required style="margin:0px;border:0px;" onchange="modificarDes(this.id,this.value)">
                    </td>
                    <td style="margin:0px; padding: 0px;">
                        <input type="text" class="form form-control" id="LI<?php echo $desemp['idDes'] ?>"  required value="<?php echo $desemp['limiteInf'] ?>" style="margin:0px;border:0px; text-align:right;" onchange="modificarDes(this.id,this.value)">                
                    </td>   
                    <td style="margin:0px; padding: 0px; ">
                        <input type="text" class="form form-control" id="LS<?php echo $desemp['idDes'] ?>"  required value="<?php echo $desemp['limiteSup'] ?>" style="margin:0px;border:0px;text-align:right;" onchange="modificarDes(this.id,this.value)">
                    </td>                    
                    <td style="margin:0px; padding: 3px; text-align:center;" >
                        <img src="vistas/img/desempenos/<?php echo $desemp['emoticon'] ?>" id="<?php echo $desemp['idDes'] ?>" width="25" height="25" title="cambiar imágen" class="iconosAcciones" onclick="cambiarEmoticon(this.id)"></img>
                    </td>                    
                    <td style="margin:0px; padding: 3px; text-align:center;" >
                        <img src="vistas/img/Iconos/eliminar.png" id="<?php echo $desemp['idDes'] ?>" width="20" height="20" title="Eliminar desempeño" class="iconosAcciones apuntado2" onclick="eliminarDes(this.id)"></img>
                    </td>   
                </tr>
            <?php
            }                                                    
        ?>
    </tbody>
</table>
<form action="" method="POST" onsubmit="return agregarDesempeno()">
    <table>
        <tr>
            <td colspan="4" style="height:23px;"><h3>Nuevo Desempeño</h3></td>
        </tr> 
            <tr>
                <td>Desempeño<br>
                    <select id="desemNuevo" required class="form-control">
                       <option value="">Seleccione..</option>
                       <option value="BAJO">BAJO</option>
                       <option value="BASICO">BASICO</option>
                       <option value="ALTO">ALTO</option>
                       <option value="SUPERIOR">SUPERIOR</option>                                        
                    </select>
                    
                </td>
                <td>Lím. Inferior (De):<br>
                    <input type="number" class="form-control" id="limitInfNuevo" required value="" placeholder="Límite inferior" step="any" min="0">
                </td>
                <td>Lím. Superior (Hasta):<br>
                    <input type="number" class="form-control" id="limitSupNuevo" required value="" placeholder="Límite Superior" step="any" min="0">
                </td>
                <td align="center">
                   <button type="submit" id="btnAjDesemp" class="btn btn-primary" style="margin-top:20px;"><i class="fa fa-plus"></i> Agregar</button>                                                                  
                </td>
            </tr>
    </table>
</form>