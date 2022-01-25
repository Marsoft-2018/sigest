<?php 
	require("../../Modelo/Conect.php");
	require("../../Modelo/grado.php");

	$objGr = new grados();
	$objGr->CODNIVEL = $_POST['nivel'];
?>

<label>Hasta el Grado:</label>
<select id='gradoSel' class='form form-control'>
	<option value=''>Seleccione...</option>
	<?php 
		foreach ($objGr->listarPorNivel() as $key => $reg) {
			echo "<option value='".$reg['CODGRADO']."'>".$reg['CODGRADO'].". ".$reg['NOMGRADO']."</option>"; # code...
		}
	?>
</select> 


