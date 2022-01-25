<?php 
	require("../../Modelo/Conect.php");
	require("../../Modelo/curso.php");

	$objGr = new grados();
	$objGr->codSede = $_POST['sede'];
?>

<label>Hasta el Grado:</label>
<select id='gradoSel' class='form form-control'>
	<option value=''>Seleccione...</option>
	<?php 
		foreach ($objGr->listarXsedes() as $key => $reg) {
			echo "<option value='".$reg['CODGRADO']."'>".$reg['CODGRADO'].". ".$reg['NOMGRADO']."</option>"; # code...
		}
	?>
</select> 
