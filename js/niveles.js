function nuevoNivel(){
    $('#cargasFormulario').html("");
    $.ajax({
        type: "POST",
        url: "Controladores/ctrlNiveles.php",
        data:{accion:"nuevo"},
        success: function(data){
            $('#cargasFormulario').html(data);
        },
        error: function(err){
            console.log("Error: "+err);
        }
    });
}