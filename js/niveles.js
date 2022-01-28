function nuevoNivel(){
    $('#cargasFormulario').html("");
    $.ajax({
        type: "POST",
        url: "vistas/ajustes/niveles/formulario.php",
        success: function(data){
            $('#cargasFormulario').html(data);
        },
        error: function(err){
            console.log("Error: "+err);
        }
    });
}