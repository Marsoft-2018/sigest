<?php
	require("../../models/Conect.php");
	require("../../models/usuario.php");
	$objUsuario = new Usuario();
	$id_usuario = "";
	$usuario 	= "";
	$nombre 	= "";
	$direccion 	= "";
	$telefono 	= "";
	$estado 	= "";
	$correo 	= "";
	$ciudad 	= "";
	$rol		= "";
	$cargo 		= "";
	$password	= "";
	$fecha_reg 	= "";
	$accion = "guardarUsuario('agregar')";

	if (isset($_POST['id'])) {
		//include("../../models/encript.php");
		$id_usuario = $_POST['id'];
		$objUsuario->id_usuario = $_POST['id'];
		$accion = "guardarUsuario('modificar')";
		foreach ($objUsuario->cargar() as  $campo) {
			$nombre 	= $campo['nombre'];
			$usuario 	= $campo['usuario'];
			$password 	= SED::decryption($campo['password']);
			$rol 	= $campo['rol'];			
			$cargo 	= $campo['cargo'];
			$direccion 	= $campo['direccion'];
			$telefono 	= $campo['telefono'];
			$estado 	= $campo['estado'];
			$correo 	= $campo['correo'];
			$ciudad 	= $campo['ciudad'];
			$fecha_reg 	= $campo['fecha_reg'];
		}
	}
?>

<div class="row">
	<div class="col-md-12">
		<div class="x_panel">
			<div class="x_content">
			<form class="form-label-left input_mask" method="POST" id="formUsuario" onsubmit="return <?php echo $accion; ?>">
			  <input type="hidden" class="form-control has-feedback-left" id="id_usuario" name="id_usuario" value="<?php echo $id_usuario; ?>" placeholder="Nombre Completo">
			  <div class="col-md-12 col-sm-12  form-group has-feedback">
			    <input type="text" class="form-control has-feedback-left" id="nombre" name="nombre" value="<?php echo $nombre; ?>" placeholder="Nombre Completo">
			    <span class="fa fa-tag form-control-feedback left" aria-hidden="true"></span>
			  </div>
			  <div class="col-md-12 col-sm-12  form-group has-feedback">
			    <input type="text" class="form-control has-feedback-left" id="cargo" name="cargo" value="<?php echo $cargo; ?>" placeholder="nombre de cargo" title="Cargo del usuario">
			    <span class="fa fa-briefcase form-control-feedback left" aria-hidden="true"></span>
			  </div>
			  <div class="col-md-12 col-sm-12  form-group has-feedback">
			    <input type="text" class="form-control has-feedback-left" id="usuario" name="usuario" value="<?php echo $usuario; ?>" placeholder="Nombre de usuario" title="Nombre de usuario">
			    <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
			  </div>
			  <div class="col-md-12 col-sm-12  form-group has-feedback">
			    <input type="password" class="form-control has-feedback-left" id="password" name="password" value="<?php echo $password; ?>" placeholder="Contraseña"	 title="Contraseña">
			    <span class="fa fa-key form-control-feedback left" aria-hidden="true"></span>
			  </div>
			  <div class="col-md-12 col-sm-12  form-group has-feedback">
			    <span class="fa fa-legal form-control-feedback left" aria-hidden="true"></span>
			    <select name="rol" id="rol"  title="Perfíl de usuario" class="form-control has-feedback-left" >
			    	<option value="">Seleccione...</option>
			    	<option value="Administrador" <?php if($rol == "Administrador"){ echo "selected"; } ?>>Administrador</option>
			    	<option value="Coordinador" <?php if($rol == "Coordinador"){ echo "selected"; } ?>>Coordinador</option>
			    	<option value="Taller" <?php if($rol == "Taller"){ echo "selected"; } ?>>Taller</option>
			    </select>
			  </div>

			  <div class="col-md-12 col-sm-12 form-group has-feedback">
			    <input type="mail" class="form-control has-feedback-left" id="correo" name="correo" value="<?php echo $correo; ?>" placeholder="Correo">
			    <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
			  </div>
			  <div class="col-md-12 col-sm-12  form-group has-feedback">
			    <input type="text" class="form-control has-feedback-left" id="ciudad" name="ciudad"  placeholder="Ciudad" value="<?php echo $ciudad; ?>">
			    <span class="fa fa-map-marker form-control-feedback left" aria-hidden="true"></span>
			  </div>
			  <div class="col-md-12 col-sm-12  form-group has-feedback">
			    <input type="text" class="form-control has-feedback-left" id="direccion" placeholder="Dirección" name="direccion" value="<?php echo $direccion; ?>">
			    <span class="fa fa-map-signs form-control-feedback left" aria-hidden="true"></span>
			  </div>
			  <div class="col-md-12 col-sm-12  form-group has-feedback">
			    <input type="text" class="form-control has-feedback-left" id="telefono" placeholder="Teléfono" name="telefono" value="<?php echo $telefono; ?>">
			    <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
			  </div>
			  <div class="ln_solid"></div>
			  <div class="form-group row">
			    <div class="col-md-12 col-sm-12 ">
			      <button type="button" class="btn btn-primary"  data-dismiss="modal">Cerrar</button>
			      <button type="submit" class="btn btn-success">Guardar</button>
			    </div>
			  </div>
			</form>
			</div>
		</div>
	</div>
</div>