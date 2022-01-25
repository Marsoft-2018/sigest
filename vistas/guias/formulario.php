<?php
	session_start();

	require("../../Modelo/Conect.php");
	require '../../Modelo/anhoLectivo.php';
	require("classGuia.php");
	$objGuia = new Guia();
?>

<div class="row">
	<div class="col-md-12">
		<div class="x_panel">
			<div class="x_content">
			<form class="form-label-left input_mask" method="POST" enctype="multipart/form-data" id="formGuia" onsubmit="return agregarGuia()">
			  <div class="col-md-12 col-sm-12  form-group has-feedback">
			  	<label for="">Profesor</label>
			  	<select name="profesor" id="profesores" class="form-control has-feedback-left" required>
			  		<option value="">Seleccione..</option>
			  		<?php 
			  			foreach ($objGuia->profesores() as $campo) {
			  				$sel = "";
			  				if ($_POST['usuario'] == $campo['idUsuario']) {
			  					$sel = "selected";
			  				}
			  				echo "<option value='".$campo['idUsuario']."' $sel>".$campo['nombre']."</option>";
			  			}
			  		?>
			  	</select>
			  </div>
			  <div class="col-md-12 col-sm-12  form-group has-feedback">
			    <label for="">SEDE</label>
                <select id='sede' name='sedeBol' onchange='cargarCursos(this.value)' class='form-control' style='margin:0px; padding: 0px;' required>
                	<option value=''>Seleccione...</option>  
                	<?php                    
                        foreach ($objGuia->sedes() as $registro) {
                        	echo "<option value='".$registro['CODSEDE']."'>".$registro['NOMSEDE']."</option>";
                        }
                  	?>
                </select>   
			  </div>
			  <div class="col-md-12 col-sm-12  form-group has-feedback">
			  	<label for="">Curso</label>
			  	<div id='cursosBol' style='margin:0px; padding: 0px;' >
                    <select id='curso' name='curso' class='form-control' onchange = 'cargarTodasLasAreas()' style='margin:0px; padding: 0px;width:80%;' required>
                    </select>
                </div>			  	 
			  </div>
	            <div class="col-lg-2 col-md-2">
	                <label for="">AÑO</label>
	                <?php                            
	                    $objAnho = new Anho();
	                    $objAnho->inst = $_SESSION['institucion'];
	                    $anhos = $objAnho->Listar();
	                    echo "<select class='form-control' id='anho' name='anho' onchange='ValidarPeriodo(); limpiarAreaDeTrabajo(); cargarTodasLasAreas()'>";
	                    foreach ($anhos as $key => $value) {
	                        echo "<option value='".$value['Alectivo']."'>".$value['Alectivo']."</option>";
	                    }
	                    echo "</select>";
	                ?>                            
	            </div>
			  <div class="col-md-12 col-sm-12  form-group has-feedback">
			    <label>AREA/ASIGNATURA</label>
                <select name="" id="areas" class="form form-control" onchange="limpiarAreaDeTrabajo();">
                    <option value="">Seleccione..</option>
                    <optgroup label="Áreas">
                      
                    </optgroup>
                </select>
			  </div>
			  <div class="col-md-12 col-sm-12  form-group has-feedback">
				<input type="file" name="archivo" id="archivo" class="form-control has-feedback-left"  required>
					<br><br>			    
			  </div>
			  <div class="ln_solid"></div>
			  <div class="form-group row">
			    <div class="col-md-3 col-sm-3 ">
			      <button type="button" class="btn btn-warning"  data-dismiss="modal" style="width: 100%">Cerrar</button>
			    </div>				    
			    <div class="col-md-3 col-sm-3 ">
			      <button type="submit" class="btn btn-success" style="width: 100%">Subir guía</button>
			    </div>
			    <div class="col-md-3 col-sm-3 " id="divCarga">
			    	
			    </div>
			  </div>
			</form>
			</div>
		</div>
	</div>
</div>

  <script type='text/javascript'>
    function cargarAreasGuia(curso){
        var accion='CargarTodasLasAreas';
        $("#celdaAreas").load("Calificar/vistas/planilla.php",{accion:accion,curso:curso},function(){
        });
    }


	function cargarCursos(sede){
	    $("#curso").html("");
	    $("#curso").append("<option value=''>Seleccione...</option>");
	    // var accion='cargarCursos';
	    // var profe='Todos';
	    $.ajax({
	        type: 'POST',
	        url: "vistas/guias/ctrlGuias.php",
	        data: {accion:"cargarCursos", sede:sede},
	        dataType: 'json',
	        success: function(response){
	            //console.log(response);
	            $.each(response, function(index, item) {
	                $("#curso").append("<option value='"+item.codCurso+"'>"+item.CODGRADO+"° "+item.grupo+"</option>");                
	            });
	        },
	        error: function(data){
	            alertify.error("error","Error al cargar los curso de la sede seleccionada");
	        }
	    });
	}

  </script>	