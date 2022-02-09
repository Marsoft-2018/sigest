    
//==========---*** Para la configurar el modulo de Desempeños  ***---=========//    
    
function nuevoDesempeno(){
    $('#cargasFormulario').html("");
    $('#tituloModal').html("Formulario para Desempeños");
    $.ajax({
        type: "POST",
        url: "Controladores/ctrlDesempenos.php",
        data:{accion:"nuevo"},
        success: function(data){
            $('#cargasFormulario').html(data);
        },
        error: function(err){
            console.log("Error: "+err);
        }
    });
}

function editarDesempeno(id){
    $('#cargasFormulario').html("");
    $('#tituloModal').html("Formulario para Desempeños");
    $.ajax({
        type: "POST",
        url: "Controladores/ctrlDesempenos.php",
        data:{accion:"editar", idDes:id},
        success: function(data){
            $('#cargasFormulario').html(data);
        },
        error: function(err){
            console.log("Error: "+err);
        }
    });
}

function agregarDesempeno(){
    $('#respuestasDesempenos').html("");
    var imagen = $("#emoticon")[0].files[0];
    console.log("Archivo: "+imagen.name);
    var form_data = new FormData(formDesempenos);
    form_data.append('accion', "agregar");
    form_data.append('CONCEPT', $("#CONCEPT").val());
    form_data.append('limiteInf', $("#limiteInf").val());
    form_data.append('limiteSup', $("#limiteSup").val());
    form_data.append('emoticon', imagen);
    // $.ajax({
    //     type: "POST",
    //     url: "Controladores/ctrlDesempenos.php",
    //     data:   form_data,
    //     success: function(data){
    //         // $("#idDes").val("");
    //         // $("#CONCEPT").val("");
    //         // $("#limiteInf").val("");
    //         // $("#limiteSup").val("");
    //         // $("#emoticon").val("");
            
    //         $('#respuestasDesempenos').html(data);
    //         mostrarDesempenos();
    //     },
    //     error: function(err){
    //         console.log("Error: "+err);
    //     }
    // });
    return false;
}

function modificarDesempeno(id){
    $('#respuestasDesempenos').html("");
    let accion = "modificar";
    let CONCEPT = $("#CONCEPT").val();
    let limiteInf = $("#limiteInf").val();
    let limiteSup = $("#limiteSup").val();
    let emoticon = $("#emoticon").val();
    $.ajax({
        type: "POST",
        url: "Controladores/ctrlDesempenos.php",
        data:{accion:accion, idDes:id,CONCEPT:CONCEPT,limiteInf:limiteInf,limiteSup:limiteSup, emoticon:emoticon},
        success: function(data){
            $("#idDes").val("");
            $("#CONCEPT").val("");
            $("#limiteInf").val("");
            $("#limiteSup").val("");
            $("#emoticon").val("");
            $('#respuestasDesempenos').html(data);
            mostrarDesempenos();
        },
        error: function(err){
            console.log("Error: "+err);
        }
    });
}


function eliminarDesempeno(id){
    alertify.defaults.transition = "flipy";
    alertify.defaults.theme.ok = "btn btn-primary";
    alertify.defaults.theme.cancel = "btn btn-danger";
    alertify.defaults.theme.input = "form-control";
    alertify.confirm(
        '<div class="panel-heading" style="background-color:#902015;color:#fff;"><i class="fa fa-times-circle"> Eliminar Desempenos</i></div>', 
        'Señor usuario tenga encuenta esta advertencia, recuerde que al eliminar al Desempeno de la institución se eliminaran todos los datos relacionados al mismo. Para eliminar los datos del Desempeno seleccionado presione el botón OK', 
        function()
        {             
            $.ajax({
                type: "POST",
                url: "Controladores/ctrlDesempenos.php",
                data:{accion:"eliminar", idDes:id},
                success: function(data){
                    alertify.message(data);
                    mostrarDesempenos();
                },
                error: function(err){
                    console.log("Error: "+err);
                }
            });
        }, function(){  }
    ).set('closable', false);

   
}

function mostrarDesempenos(){    
    $.ajax({
        type: "POST",
        url: "Controladores/ctrlDesempenos.php",
        data:{accion:"mostrar"},
        success: function(data){
            $('#DesempenosMarco').html(data);
        },
        error: function(err){
            console.log("Error: "+err);
        }
    });
}

function previewIcono(){
    console.log("Cambiando imagen");
    var archivo = $("#emoticon")[0].files[0];
    //onst archivo = $("#emoticon").files;
    if(!archivo){
        $("#previewImagen").src="";
        return;
    }
    imagen = archivo;
    ruta = URL.createObjectURL(imagen);
    $("#previewImagen").attr('src', ruta);
    
}