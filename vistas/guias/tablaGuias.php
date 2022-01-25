<?php 
	if(isset($_POST['accion'])){
		require("../../class/Conect.php");
		require("classGuia.php");
	}
	//echo $_POST['usuario'];
    $obj = new Guia();
    $rol = $obj->cargarRol($_POST['usuario']);
?>


<table id="tablaGuias" class="table table-striped table-bordered dataTable" style="width:100%" >
	<thead>
		<tr>
			<th>Sede</th>
			<th>Grado</th>
			<th>Profesor</th>
			<th>Área</th>
			<th>Guía</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php			
			  $infoDetalle = "";
			  if($rol == "Profesor"){
			  	$obj->idProfesor = $_POST['usuario'];
			  	$infoDetalle = $obj->listarProfesor();
			  }else{
			  	$infoDetalle = $obj->listar();
			  }

	          foreach($infoDetalle as $campo ){
	          ?>
	          <tr>
	          	<td><?php echo $campo["sede"]; ?></td>
				<td style="font-size: 1em;"><?php echo $campo["grado"]; ?></td>
				<td style="font-size: 1em;"><?php echo $campo["profesor"]; ?></td>
				<td style="font-size: 1em;"><?php echo $campo["n_area"]; ?></td>
				<td style="font-size: 1em;"><?php echo $campo["guia"]; ?></td>
				<td>
					<button class="btn btn-info  btn-xs" data-toggle="modal" data-target="#ventanaFloat"  id="<?php echo $campo["id"]; ?>" onclick="verGuia(this.id)">
						<i class="fa fa-eye"></i>
					</button>
					<a class="btn btn-success  btn-xs"  target="selft"	 href="vistas/guias/archivos/<?php echo $campo['guia'] ?>"	id="<?php echo $campo["id"]; ?>" title = "Descargar guia">
						<i class="fa fa-download"></i>
					</a>
					<button class="btn btn-danger  btn-xs" id="<?php echo $campo["id"]; ?>" onclick="eliminarGuia(this.id,1)">
						<i class="fa fa-trash"></i>
					</button>
				</td>
			  </tr>

	          <?php } ?>
	</tbody>
</table>