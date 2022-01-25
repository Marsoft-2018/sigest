<style>

</style>
<?php 
	require("../../class/Conect.php");
	require("classGuia.php");
?>
<h3 style="text-align: center;">MODULO PARA ADMINISTRACION DE GUIAS DE ESTUDIO</h3>
 <div class="row">
	<div class="col-md-12 col-sm-12 ">
		<div class="x_panel">
			<div class="x_title">
				<div class="clearfix"></div>
			</div>
			<!-- tabla ----------- -->
			<div class="x_content">
				<div class="row">
					<div class="col-sm-12">
						<div class="card-box table-responsive" id="modGuias">
							<?php include("tablaGuias.php"); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
				<button class="btn btn-info" data-toggle="modal" data-target="#ventanaFloat"  onclick="cargarFormulario()" tittle="Nuevo Usuario">
	                <i class="fa fa-plus"> Subir Guia</i>
	            </button>
		</div>
	</div>
 </div>
<div class="modal fade" id="ventanaFloat" tabindex="-1" role="dialog" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width: 60%;">
    <div class="modal-content">
      <div class="modal-header">
      	<h2>GUIA DE ESTUDIO</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div id="resultado">
        	
        </div>
      </div>

    </div>
  </div>
</div>