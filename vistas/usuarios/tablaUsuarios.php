<?php 
	if(isset($_POST['accion'])){
		require("../../Modelo/Conect.php");
		require("../../Modelo/usuario.php");
	}
?>


<table id="tablaUsuarios" class="display table table-striped table-hover dataTable no-footer" style="width: 95%" >
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
			$objUsuario = new Usuario();
			$item =1;

	        foreach($objUsuario->listar() as $usuario ){
	          ?>
	          <tr>
				<td style="font-size: 1em;"><?php echo $usuario["nombre"]; ?></td>
				<td style="font-size: 1em;"><?php echo $usuario["usuario"]; ?></td>
				<td style="font-size: 1em;"><?php echo $usuario["rol"]; ?></td>
				<td style="font-size: 1em;"><?php echo $usuario["fecha_reg"]; ?></td>
				<td>					
					<label class="switch">					  
					<?php
						if($usuario["estado"] != 2){
							echo '<input type="checkbox" id="'.$usuario["id_usuario"].'" onclick = "activar(1,this.id)" checked>';
						}else{					    
							echo '<input type="checkbox" id="'.$usuario["id_usuario"].'" onclick = "activar(1,this.id)">';
						}
					?>
					  <span class="slider round"></span>
					</label>
				</td>
				<td>
					<!--
					<button class="btn btn-warning  btn-xs"   data-toggle="modal" data-target="#ventanaFloat" onclick="editarUsuario(this.id)" id="<?php echo $usuario["id_usuario"]; ?>">
						<i class="fa fa-pencil"></i>
					</button>
					<button class="btn btn-danger  btn-xs" id="<?php echo $usuario["id_usuario"]; ?>" onclick="eliminarUsuario(this.id,1)">
						<i class="fa fa-trash"></i>
					</button>-->
				</td>

			  </tr>

	          <?php
	          	$item++;
	          }
	          ?>
	</tbody>
</table>