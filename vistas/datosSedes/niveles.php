<?php 
	$objNivel=new nivel(); 	
?>

<select  id='nivelSel' onchange='cargarGrados(this.value)' class='form form-control'>
    <option value=''>Seleccione...</option>
    <?php 
    	foreach ($objNivel->listar() as $key => $reg) {
    		?>
        	<option value="<?php echo $reg['CODNIVEL'] ?>"><?php echo $reg['NOMBRE_NIVEL'] ?></option>

    		<?php
    	}
     ?>
    <option value='Todos'>Todos...</option>
</select>
<script>
  function cargarGrados(nivel){
        var accion = "listarGradosNivel";        
        $('#lGrados').load('vistas/datosSedes/comboGrados.php',{accion:accion,nivel:nivel});
    }


    function listarGrados(sede){
    	let ini = 0;
        var nivel = document.getElementById('nivelSel').value;
        nt = $("#nivelSel").val();
    	$("#listaGrados").html("");
    	$("#nivelTexto").html("<h3>Nivel seleccionado: "+nt+"</h3>");
        var accion = "listarGrados";
        if(nivel == 'Todos'){
           topeGrados = '120'; 
        }else{
           var topeGrados = document.getElementById('gradoSel').value;
        } 
        switch(nt) {
               	case 'PRE':
               			ini = 0;
               		break;
               	case 'PRI':
               		ini = 1;
               		break;
               	case 'SEC':
               		ini = 6;
               		break;
               	case 'MED':
               		ini = 10;
               		break;
               }       
        for (var i = ini; i <= topeGrados; i++) {            
            campo = '<tr><td><i class="fa fa-trash btn btn-danger"></i></td><td>'+i+'</td><td><input type="number" class="form form-control" id="campo' + i + '" name="campo' + i + '" min="1" ></td></tr>';
            $("#listaGrados").append(campo);
        }
        //$('#listaGrados').load('vistas/datosSedes/gradosTemp.php',{accion:accion,sede:sede,nivel:nivel,gradoTope:topeGrados});
    }
</script>
