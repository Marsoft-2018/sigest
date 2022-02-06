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


function editarNivel(id){
    $('#cargasFormulario').html("");
    $('#tituloModal').html("Formulario para Niveles");
    $.ajax({
        type: "POST",
        url: "Controladores/ctrlNiveles.php",
        data:{accion:"editar", CODNIVEL:id},
        success: function(data){
            $('#cargasFormulario').html(data);
        },
        error: function(err){
            console.log("Error: "+err);
        }
    });
}

function agregarNivel(){
    $('#respuestasNiveles').html("");
    let accion = "agregar";
    let CODNIVEL = $("#CODNIVEL").val();
    let NOMBRE_NIVEL = $("#NOMBRE_NIVEL").val();
    let orden = $("#orden").val();
    
    $.ajax({
        type: "POST",
        url: "Controladores/ctrlNiveles.php",
        data:{accion:accion, CODNIVEL:CODNIVEL,NOMBRE_NIVEL:NOMBRE_NIVEL,orden:orden},
        success: function(data){
            $("#CODNIVEL").val("");
            $("#NOMBRE_NIVEL").val("");
            $("#orden").val("");
            
            $('#respuestasNiveles').html(data);
            mostrarNiveles();
        },
        error: function(err){
            console.log("Error: "+err);
        }
    });
    return false;
}

function modificarNivel(id){
    $('#respuestasNiveles').html("");
    let accion = "modificar";
    let CODNIVEL = $("#CODNIVEL").val();
    let NOMBRE_NIVEL = $("#NOMBRE_NIVEL").val();
    let orden = $("#orden").val();
    
    $.ajax({
        type: "POST",
        url: "Controladores/ctrlNiveles.php",
        data:{accion:accion, id:id, CODNIVEL:CODNIVEL,NOMBRE_NIVEL:NOMBRE_NIVEL,orden:orden},
        success: function(data){
            $("#CODNIVEL").val("");
            $("#NOMBRE_NIVEL").val("");
            $("#orden").val("");
            
            $('#respuestasNiveles').html(data);
            mostrarNiveles();
        },
        error: function(err){
            console.log("Error: "+err);
        }
    });
}


function eliminarNivel(id){
    alertify.defaults.transition = "flipy";
    alertify.defaults.theme.ok = "btn btn-primary";
    alertify.defaults.theme.cancel = "btn btn-danger";
    alertify.defaults.theme.input = "form-control";
    alertify.confirm(
        '<div class="panel-heading" style="background-color:#902015;color:#fff;"><i class="fa fa-times-circle"> Eliminar Niveles</i></div>', 
        'Señor usuario tenga encuenta esta advertencia, recuerde que al eliminar al Nivel de la institución se eliminaran todos los datos relacionados al mismo. Para eliminar los datos del Nivel seleccionado presione el botón OK', 
        function()
        {             
            $.ajax({
                type: "POST",
                url: "Controladores/ctrlNiveles.php",
                data:{accion:"eliminar", CODNIVEL:id},
                success: function(data){
                    alertify.message(data);
                    mostrarNiveles();
                },
                error: function(err){
                    console.log("Error: "+err);
                }
            });
        }, function(){  /*alertify.error('Cancel') */ }
    ).set('closable', false);

   
}

function mostrarNiveles(){    
    $.ajax({
        type: "POST",
        url: "Controladores/ctrlNiveles.php",
        data:{accion:"mostrar"},
        success: function(data){
            $('#NivelesMarco').html(data);
        },
        error: function(err){
            console.log("Error: "+err);
        }
    });
}