<style>

</style>
<?php 
	require("../../Modelo/Conect.php");
	require("../../Modelo/usuario.php");
?>
<h3 style="text-align: center;">MODULO PARA ADMINISTRACION DE USUARIOS</h3>
 <div class="row">
	<div class="col-md-12 col-sm-12 ">
		<div class="x_panel">
			<div class="x_title">
			</div>
			<!-- tabla ----------- -->
			<div class="x_content">
				<div class="row">
					<div class="col-sm-12">
						<div class="card-box table-responsive" id="ModUsuario">
							<?php include("tablaUsuarios.php"); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
 </div>
<div class="modal fade" id="ventanaFloat" tabindex="-1" role="dialog" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width: 100%;">
    <div class="modal-content">
      <div class="modal-header">
      	<h2 id="tituloVentana"></h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div id="resultado"></div>
      </div>

    </div>
  </div>
</div>
<script src="complementos/DataTables/datatables.js"></script>