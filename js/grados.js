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
    $('#respuestasGrados').html("");
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
            mostrarGrados();
        },
        error: function(err){
            console.log("Error: "+err);
        }
    });
    return false;
}

function modificarGrado(id){
    $('#respuestasGrados').html("");
    let accion = "modificar";
    let CODGRADO = $("#CODGRADO").val();
    let NOMGRADO = $("#NOMGRADO").val();
    let idNivel = $("#idNivel").val();
    let nomCampo = $("#nomCampo").val();
    let estiloDesempeno = $("#estiloDesempeno").val();
    $.ajax({
        type: "POST",
        url: "Controladores/ctrlGrados.php",
        data:{accion:accion, id:id, CODGRADO:CODGRADO,NOMGRADO:NOMGRADO,CODNIVEL:idNivel,nomCampo:nomCampo, estiloDesempeno:estiloDesempeno},
        success: function(data){
            $("#CODGRADO").val("");
            $("#NOMGRADO").val("");
            $("#idNivel").val("");
            $("#nomCampo").val("");
            $("#estiloDesempeno").val("");
            $('#respuestasGrados').html(data);
            mostrarGrados();
        },
        error: function(err){
            console.log("Error: "+err);
        }
    });
}


function eliminarGrado(id){
    alertify.defaults.transition = "flipy";
    alertify.defaults.theme.ok = "btn btn-primary";
    alertify.defaults.theme.cancel = "btn btn-danger";
    alertify.defaults.theme.input = "form-control";
    alertify.confirm(
        '<div class="panel-heading" style="background-color:#902015;color:#fff;"><i class="fa fa-times-circle"> Eliminar Grados</i></div>', 
        'Señor usuario tenga encuenta esta advertencia, recuerde que al eliminar al grado de la institución se eliminaran todos los datos relacionados al mismo. Para eliminar los datos del grado seleccionado presione el botón OK', 
        function()
        {             
            $.ajax({
                type: "POST",
                url: "Controladores/ctrlGrados.php",
                data:{accion:"eliminar", CODGRADO:id},
                success: function(data){
                    alertify.message(data);
                    mostrarGrados();
                },
                error: function(err){
                    console.log("Error: "+err);
                }
            });
        }, function(){  /*alertify.error('Cancel') */ }
    ).set('closable', false);

   
}

function mostrarGrados(){    
    $.ajax({
        type: "POST",
        url: "Controladores/ctrlGrados.php",
        data:{accion:"mostrar"},
        success: function(data){
            $('#gradosMarco').html(data);
        },
        error: function(err){
            console.log("Error: "+err);
        }
    });
}