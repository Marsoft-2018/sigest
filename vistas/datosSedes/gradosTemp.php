<?php 
	require("../../Modelo/Conect.php");
	require("../../Modelo/grado.php");
    $objGrad = new grados();
    $objGrad->sede = $_POST['sede'];
?>
<table class='table'>
    <thead >
        <tr>
            <th title=''></th>
            <th>Abr. Nivel</th>
            <th  class='ABR' style='width:20%;text-align:center;'>GRADO</th>
            <th style='color:#000000;margin:0px; padding: 0px; text-align:center;'>Cantidad de Grupos</th>
        </tr>
    </thead>
    <tbody>
    	<?php 
    		foreach ($objGrad->cargarGradosTemp() as $key => $grTemp) {
    	?>		
		<tr class='apuntado'>
            <td style='color:#000000;margin:0px; padding: 0px; text-align:center;font-size: 12px;'>
                <button type='button' class='btn btn-danger btn-xs' id='e".$n[2]."' onclick='eliminarItemGrado(this.id)'>
                    <i class='fa fa-trash-o'></i>
                </button>           
            </td>
            <td style='color:#000000;margin:0px; padding: 0px;font-size: 11px;'>$n[1]</td>
            <td style='color:#000000;margin:0px; padding: 0px; text-align:center;font-size: 11px;'>$n[2]</td>
            <td style='color:#000000;margin:0px; padding: 0px; text-align:center;font-size: 11px;'>
                <input type='text' value='$n[3]' id='G$n[2]'  onchange='modificaGradTemp(this.id,this.value)' class='form form-control' style='margin:0px; padding: 1px; text-align:center;'>
            </td>
        </tr> 
		<?php 
			} 
		?>            
		<tr>
		    <td colspan='5'>
		        <button type='button' id='btnLista2' onclick='trasladar()' class='btn btn-success btnPrincipal'>
		            <i class='fa fa-list-ol'></i> Seguir
		        </button>
		    </td>
		</tr>
	</tbody>
</table>
