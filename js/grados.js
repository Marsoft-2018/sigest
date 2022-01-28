function nuevoGrado(){
    $('#cargasFormulario').html("");
    $.ajax({
        type: "POST",
        url: "vistas/ajustes/grados/formulario.php",
        success: function(data){
            $('#cargasFormulario').html(data);
        },
        error: function(err){
            console.log("Error: "+err);
        }
    });
}