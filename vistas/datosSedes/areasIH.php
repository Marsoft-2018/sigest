<?php 
    if(isset($_POST['sede'])){
        $sede = $_POST['sede'];
    }
    if (isset($_POST['accion'])) {
        session_start();
        require("../../Modelo/Conect.php"); 
        require("../../Modelo/areas.php");  
        require("../../Modelo/asignatura.php");
        require("../../Modelo/grado.php");
        require("../../Modelo/anhoLectivo.php");

        $objGrad = new grados();
        $objArea = new Area();
        $objAnhos = new Anho();
        $objArea->codSede = $sede;
        if (isset($_POST['anho'])) {
            $objArea->anho = $_POST['anho'];
        }else{
            //$objArea->anho =  date("Y");
            $objArea->anho =  $objAnhos->cargar(); 
        }
        $cont=1; 
        $cantGrados = 0;
    }
?>
<div class='panel-footer' id='nuevasAreasAsig'>
    <h3>Nueva Área o Asignatura</h3>
    
    <div class='row' id='asigNueva'>
        <div class='col-md-3'>
            <label>Dependencia con el área</label>
            <!-- <input type='text' name='' value='' list='listaA' placeholder='Seleccione...' >    -->           
            <select  id='txtIdArea' name="depeArea" class='form form-control'>   
                <option value='Ninguna'>No depende de otra área</option>                
                <?php foreach ($objArea->listar() as $area) {
                    echo "<option value='".$area['id']."'>".$area['Nombre']."</option>";
                } ?>                                                               
            </select>
        </div>
        <div class='col-md-1'>
            <label>Abreviatura</label>
            <input type='text' value='' id='txtCod' title='Por favor ingrese el código de la asignatura sin espacios' maxlength='3' class='form form-control'>
        </div>
        <div class='col-md-3'>
            <label>Nombre del Área/Asignatura</label>
            <input type='text' value='' id='txtNombre' title='Por favor ingrese el Nombre de la asignatura' class='form form-control' >
        </div>
        <div class='col-md-2'> 
           <button type='button' id='botonAsignatura2' class='btn btn-primary ui-state-default btnPrincipal' style='margin-top: 23px; width: 100%;' onclick='agregarAreaxSede(<?php echo $_POST['sede']; ?>)'><i class='fa fa-plus'></i> Agregar</button>
        </div>
    </div>
</div>
<hr>
<h3 style='text-align:center;'>DISTRIBUCION DE LA INTENSIDAD HORARIA POR GRADOS</h3>
<table class='table' style='overflow-x:scroll;'>
    <thead style='overflow-x:auto;background-color: #a0df9d'>
        <tr >
            <th>Elim</th>
            <th>ABR</th>
            <th>NOMBRE DEL AREA/ASIGNATURA</th>
        <?php 
        	foreach ($objGrad->listar() as $grados) { 
                $idGrado = $grados['CODGRADO'];       		
        		if($grados['CODGRADO']<=11){
	                echo "<th style='text-align:center;font-size: 20px; font-weight: bold;border-right:1px solid #fff;'>".$grados['CODGRADO']."°</th>";
	            }elseif($grados['CODGRADO']<=121){
	                echo "<th style='text-align:center;font-size: 20px; font-weight: bold;border:1px solid #cecece;'>C.".$cont."°</th>";
	                $cont++;
	            }
        	}
        ?>
            <th>TIPO PROMEDIO</th>
		</tr>        
    </thead>
    <tbody >
        <?php        	
    	foreach ($objArea->listar() as $area) { ?>
			<tr class='area'>
                <td style='margin:0px; padding: 0px;font-size: 12px; text-align: center;'>
                    <i class="fa fa-trash eliminarArea" id='el<?php echo $area['id'] ?>' onclick="eliminarAreaxSede(<?php echo $area['id'] ?>,<?php echo $sede ?>,1)"></i>
                </td>
                <td style='color:#000000;margin:0px; padding: 0px;font-size: 12px;'>
                	<?php echo $area['Abreviatura'] ?>
          		</td>
                <td style='color:#000000;margin:0px; padding: 0px;font-size: 12px;width:250px;'>
                	<?php echo $area['Nombre'] ?>
                </td>
				<?php
					foreach ($objGrad->listar() as $grados) {
						$objArea->idAsignatura = $area['id'];
                        $objArea->id = $area['id'];
						$objArea->idGrado = $grados['CODGRADO'];
						$hr = 0;
						?>	
						<td style='color:#000000;margin:0px; padding: 0px;font-size: 12px; border:0px solid;'>
    						<?php
                            $accion = "agregarIntensidad(".$area['id'].",".$grados['CODGRADO'].",this.value,1)";
    						foreach ($objArea->cargarIntensidad() as $horas) {
    							$hr = $horas['intensidad'];
                                $accion ="modificarIntensidad(".$area['id'].",".$grados['CODGRADO'].",this.value,1)";
    						}
                            
    						?> 
                            <input type='number' 
                            	value="<?php echo $hr ?>" 
                            	id="<?php echo $grados['CODGRADO'].$area['id'] ?>" 
                            	name="G<?php echo $grados['CODGRADO'] ?>" 
                            	title=" <?php echo $grados['CODGRADO'].'° -'.$area['Nombre'] ?>" 
                            	class="<?php echo 'horas'.$grados['CODGRADO'] ?>" 
                            	onchange="<?php echo $accion ?>" 
                            	onclick='seleccionar(this.id)' 
                            	onblur='deseleccionar(this.id)' 
                            	onfocus='quitarCero(this.id)' 
                            	style='text-align:center;font-size:15px;padding:1px;'
                            >
						</td>
						<?php 
		        	}
				?>
                <td style="padding: 0px; margin: 0px;">                    	
           			<select class='form form-control' 
                        id="FPRO<?php echo $area['id'];  ?>"  
                        name='FPRO' 
                        onchange = 'modificarTipoPromedio(<?php echo $area['id'];  ?>, this.value)' 
                        style = "padding: 0px; margin: 0px; font-size: 10px; height: 26px;">
           				<option  value="IH" <?php if($area['formaDePromediar'] == 'IH'){ echo "selected"; } ?>>IH</option>
                        <option  value='Normal' <?php if($area['formaDePromediar'] == 'Normal'){ echo "selected"; } ?>>Normal</option>
                        <option  value='Porcentaje' <?php if($area['formaDePromediar'] == 'Porcentaje'){ echo "selected"; } ?>>Porcentaje</option>
            		</select>
                </td>
            </tr>
        <?php 
        	$objArea->id = $area['id'];  
            $objAsignaturas = new Asignatura();
            $objAsignaturas->idArea = $area['id']; 
        	foreach ($objAsignaturas->listar() as $asignatura) { ?>
                <!-- Fila asignaturas -->
            	<tr>
    				<td style='color:#f00; margin:0px; padding-top: 1px; padding-bottom: 0px; font-size: 12px; text-align: center;'>
    					<i class="fa fa-trash" onclick="eliminarAreaxSede(<?php echo $asignatura['id'] ?>,<?php echo $sede ?>,2)"></i>
    				</td>
    				<td style='padding:0px;'>
                       <input type="text" 
                       class = "form form-control"
                       id = "abreviatura<?php echo $asignatura['id'];  ?>" 
                       value = "<?php echo $asignatura['Abreviatura']; ?>" 
                       onchange = "modificaAsignatura(<?php echo $asignatura['id']; ?>)"  
                       style = "padding: 0px; margin: 0px; font-size: 10px; height: 23px;">
                   </td>
    				<td style='padding:0px;'>
                       <input type='text' 
                       class='form form-control' 
                       id = "nombre<?php echo $asignatura['id']; ?>" 
                       value="<?php echo $asignatura['Nombre']; ?>" 
                       onchange='modificaAsignatura(<?php echo $asignatura['id']; ?>)'  
                       style="padding: 0px; margin: 0px; font-size: 10px; height: 23px;">
                   </td>
                    <?php
            		foreach ($objGrad->listar() as $grados) {
            			$objAsignaturas->id = $asignatura['id'];
            			$objAsignaturas->idGrado = $grados['CODGRADO'];
            			$asighr = $objAsignaturas->intensidad(); ?>
    				<td style='color:#000000;margin:0px; padding: 0px;font-size: 12px; border:0px solid;'>
                        <?php
                        if ($asighr == 0) {
                            $accion = "agregarIntensidad(".$asignatura['id'].",".$grados['CODGRADO'].",this.value,2)";
                        }else{
                            $accion ="modificarIntensidad(".$asignatura['id'].",".$grados['CODGRADO'].",this.value,2)";
                        }
                          
                        ?> 
                        <input type='number' 
                            value="<?php echo $asighr ?>" 
                            id="<?php echo $grados['CODGRADO'].$asignatura['id'] ?>" 
                            name="Asig<?php echo $area['id'].$grados['CODGRADO']; ?>" 
                            title=" <?php echo $grados['CODGRADO']."° ".$area['Abreviatura']."-".$asignatura['Nombre'] ?>" 
                            class='horas' 
                            onchange="<?php echo $accion ?>; totalHorasArea(<?php echo $area['id']; ?>,<?php echo $grados['CODGRADO'] ?>)" 
                            onclick='seleccionar(this.id)' 
                            onblur='deseleccionar(this.id)' 
                            onfocus='quitarCero(this.id)'>

                    </td>
                    <?php }  ?>
            		<td style='color:#000000;margin:0px; padding: 0px;font-size: 11px;'>
                        <?php 
                            $oculto = "";
                            if($area['formaDePromediar'] != 'Porcentaje'){ 
                                $oculto = "display: none;"; 
                            }else{
                                $oculto = "";
                            }

                        ?>
                       <input type = 'number' 
                            class = "porcentaje<?php echo $area['id'];  ?> " 
                            id = "porcentaje<?php echo $asignatura['id'] ?>" 
                            value="<?php echo $asignatura['porcentaje'] ?>" 
                            onchange = 'modificaAsignatura(<?php echo $asignatura['id']; ?>)' 
                            placeholder = 'Porcentaje' 
                            style='margin: 0px;  font-size: 12px; text-align: center; padding: 1px; border: 0px; <?php echo $oculto ?>'
                        >
                    </td>
            	</tr>
            	<?php 
        	}
        }
        ?>   
    </tbody>
    <tfoot>
        <tr>
            <td colspan='3' style='color:#000000;margin:0px; text-align:center;padding: 0px;font-size: 11px;'>
                <h4>TOTAL HORAS ASIGNADAS</h4>
            </td>
            <?php 
                foreach ($objGrad->listar() as $grados) {
				//$objArea->id = $area['id'];
				$objArea->idGrado = $grados['CODGRADO'];
				$totalhr = $objArea->totalHoras($grados['CODGRADO']);
			?>
			<td style='color:#000000;margin:0px; padding: 0px;font-size: 11px;'>                           
                <input type='text' name='' id="totalIH<?php echo $grados['CODGRADO'] ?>" value="<?php echo $totalhr ?>" class="total<?php echo $grados['CODGRADO'] ?>	" style="text-align: center;font-size: 20px;color: #010588; font-weight: bold;">
            </td>   
            <?php 
				}
            ?>                      	
        </tr>                    
    </tfoot>
</table>