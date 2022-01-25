<?php 
	require("../../class/Conect.php");
	require("classGuia.php");
	$obj = new Guia();
	$obj->id    =   $_POST['id'];
    foreach ($obj->cargar() as $value) {
        $obj->guia  = $value['guia'];  # code...
    }
	  
	  // echo "Id de la guia: ".$obj->id;   
	  // echo "<br>".$obj->guia;

?>
<h3>VISTA DEL DOCUMENTO</h3>
<object width="100%" height="600" data="vistas/guias/archivos/<?php echo $obj->guia  ?>" style="margin-top: 20px;">
	
</object>
<br>
<button type="button" class="btn btn-warning"  data-dismiss="modal">Cerrar</button>