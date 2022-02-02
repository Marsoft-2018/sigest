function nuevoGrado(){
    $('#cargasFormulario').html("");
    $('#tituloModal').html("Formulario para Grados");
    $.ajax({
        type: "POST",
        url: "Controladores/ctrlGrados.php",
        data:{accion:"nuevo"},
        success: function(data){
            $('#cargasFormulario').html(data);
        },
        error: function(err){
            console.log("Error: "+err);
        }
    });
}

function editarGrado(id){
    $('#cargasFormulario').html("");
    $('#tituloModal').html("Formulario para Grados");
    $.ajax({
        type: "POST",
        url: "Controladores/ctrlGrados.php",
        data:{accion:"editar", CODGRADO:id},
        success: function(data){
            $('#cargasFormulario').html(data);
        },
        error: function(err){
            console.log("Error: "+err);
        }
    });
}