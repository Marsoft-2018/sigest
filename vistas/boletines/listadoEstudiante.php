<?php 
	session_start();
	require("../../Modelo/Conect.php");
	require("../../Modelo/Estudiante.php");

    $objLista = new Estudiante();
	$objLista->curso = $_POST['curso'];
    $objLista->anho = $_POST['anho'];
?>

<div class='divLista'>
	<h3>LISTA DE ESTUDIANTES EN EL CURSO</h3>
	<table class='table table-striped dataTable' id="lista">
		<thead>
			<tr>
				<th>Seleccione</th>
				<th>Primer Nombre</th>
				<th>Segundo Nombre</th>
				<th>Primer Apellido</th>
				<th>Segundo Apellido</th>		
			</tr>	
		</thead>
		<tbody>
			<?php 
			$num = 1;
			foreach ($objLista->listarCurso() as $estudiante) { ?>				
			<tr>
				<td class="marcaLista">
					<input type="checkbox" value="<?php echo $estudiante['idMatricula'] ?>" name = "Estudiante[]" style="height: 15px;"/>
				</td>
				<td class="datoLista">
					<?php echo $estudiante['PrimerNombre']; ?>
				</td>
				<td class="datoLista">
					<?php echo $estudiante['SegundoNombre']; ?>
				</td>
				<td class="datoLista">
					<?php echo $estudiante['PrimerApellido']; ?>
				</td>
				<td class="datoLista">
					<?php echo $estudiante['SegundoApellido']; ?>
				</td>
			</tr>
			<?php 
					$num++;
				}
			?>
		</tbody>
	</table>	
</div>

<script src="complementos/DataTables/datatables.js"></script>