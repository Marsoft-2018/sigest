function actualizarPerfil(pas,rol){
	switch(pas) {
		case 1:
			accion = "Agregar";
			break;
		case 2:
			accion = "Actualizar";
			break;
	}
  alertify.success("Accion "+rol);
	$.ajax({
        type: 'POST',
        url: "controllers/ctrlPerfil.php?accion="+accion"&rol="+rol,
        data:$("#formPerfil").serialize(),
        beforeSend: function(){
            $('#bloquear').slideDown('fast');
        },
        success: function(data){
            $("#resultado").html(data);
            alertify.success("Perfil actualizado con éxito, los cambios se verán reflejados en el próximo inicio de sesión");
            $('#bloquear').slideUp('fast');
        },
        error: function(data){
            alertify.error("Error al modificar el perfil");
            $('#bloquear').slideUp('fast');
        }
    });
}

function eliminarPerfil(){
	accion = "Eliminar";
	$.ajax({
        type: 'POST',
        url: "controllers/ctrlPerfil.php?accion="+accion,
        data:$("#formPerfil").serialize(),
        beforeSend: function(){
            bloquear();
        },
        complete:function(data){
            desBloquear();
        },
        success: function(data){
            $("#resultado").html(data);
            alertify.success("Perfil eliminado con éxito, los cambios se verán reflejados en el próximo inicio de sesión");
           //cargarPerfil();
        },
        error: function(data){
            alertify.error("Error al modificar el perfil");
            desBloquear();
        }
    });
}
