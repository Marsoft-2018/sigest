<?php 
	if(isset($_POST['accion'])){
		require("../../models/Conect.php");
		require("../../models/usuario.php");
	}
?>


<table id="tablaUsuarios" class="table table-striped table-bordered tblDetalle" style="width:100%" >
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Usuario</th>
			<th>Perfil</th>
			<th>Fecha de Registro</th>
			<th>Estado</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
			$obj = new Usuario();
				$item =1;
			  $infoDetalle = $obj->listar();
	          foreach($infoDetalle as $campo ){
	          ?>
	          <tr>
				<td style="font-size: 1em;"><?php echo $campo["nombre"]; ?></td>
				<td style="font-size: 1em;"><?php echo $campo["usuario"]; ?></td>
				<td style="font-size: 1em;"><?php echo $campo["rol"]; ?></td>
				<td style="font-size: 1em;"><?php echo $campo["fecha_reg"]; ?></td>
				<td>					
					<label class="switch">					  
					<?php
						if($campo["estado"] != 2){
							echo '<input type="checkbox" id="'.$campo["id_usuario"].'" onclick = "activar(1,this.id)" checked>';
						}else{					    
							echo '<input type="checkbox" id="'.$campo["id_usuario"].'" onclick = "activar(1,this.id)">';
						}
					?>
					  <span class="slider round"></span>
					</label>
				</td>
				<td>
					<button class="btn btn-warning  btn-xs"   data-toggle="modal" data-target="#ventanaFloat" onclick="editarUsuario(this.id)" id="<?php echo $campo["id_usuario"]; ?>">
						<i class="fa fa-pencil"></i>
					</button>
					<button class="btn btn-danger  btn-xs" id="<?php echo $campo["id_usuario"]; ?>" onclick="eliminarUsuario(this.id,1)">
						<i class="fa fa-trash"></i>
					</button>
				</td>

			  </tr>

	          <?php
	          	$item++;
	          }
	          ?>
	</tbody>
</table>