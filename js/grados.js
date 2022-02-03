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


function agregarGrado(){
    let accion = "agregar";
    let CODGRADO = $("#CODGRADO").val();
    let NOMGRADO = $("#NOMGRADO").val();
    let idNivel = $("#idNivel").val();
    let nomCampo = $("#nomCampo").val();
    let estiloDesempeno = $("#estiloDesempeno").val();
    $.ajax({
        type: "POST",
        url: "Controladores/ctrlGrados.php",
        data:{accion:accion, CODGRADO:CODGRADO,NOMGRADO:NOMGRADO,CODNIVEL:idNivel,nomCampo:nomCampo, estiloDesempeno:estiloDesempeno},
        success: function(data){
            $("#CODGRADO").val("");
            $("#NOMGRADO").val("");
            $("#idNivel").val("");
            $("#nomCampo").val("");
            $("#estiloDesempeno").val("");
            $('#respuestasGrados').html(data);
        },
        error: function(err){
            console.log("Error: "+err);
        }
    });
    return false;
}

function codigoNivel(id){

    let idNivel = $("#idNivel").val();
    alert("CODIGO DEL NIVEL: "+idNivel);

}

function modificarGrado(id){
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


function eliminarGrado(id){
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