$obtInicial = "";
$obtAnt = "";
$objActual = "";
function observacionInicial(idMatricula){
    if(objInicial == ""){
        objInicial = $("#observacion"+idMatricula).val();
        $obtAnt = $("#observacion"+idMatricula).val();
        $objActual = $("#observacion"+idMatricula).val();
    }else{
        
    }
}


//------------- Lista de funciones relacionadas con las observaciones del boletín -------------//
function toggleBotones(id,estado){
    if(!estado){
        $("#btnGuardarObservacion"+id).fadeIn('fast');
        $("#btnEliminarObservacion"+id).fadeIn('fast');
    }else{
        $("#btnGuardarObservacion"+id).fadeOut('fast');
        $("#btnEliminarObservacion"+id).fadeOut('fast');
    }
}

function activarObservacionesBoletin(curso){
    //alert("Entro a activar el boton de observaciones");
    var anho = $("#anho").val();
    $.ajax({
        type: "POST",
        url: "Controladores/ctrlObservaciones_boletines.php",
        data: {accion: "Activar",curso:curso,anho:anho},
        success: function(response){
            var response = JSON.parse(response);
            console.log(response);
            if(response.estado == "true"){
                $("#btnObservacion").fadeIn('fast');
            }else{
                $("#btnObservacion").fadeOut('fast');
            }
        },
        error: function(err){
            console.log("Error: "+ err);
        }
    });
}

function cargarObservacionesBoletin(){  
    var accion = 'Listar';
    var periodo = $('#periodo').val();
    var curso = $('#curso').val();
    var anho = $('#anho').val();
    if(anho == ""){
        alertify.error("Por favor Seleccione el año para poder continuar");
    }else if(periodo == ""){
        alertify.error("Por favor Seleccione el periodo para poder continuar");
    }else{
        $.ajax({
            type:"POST",
            url:"Controladores/ctrlObservaciones_boletines.php",
            data:{accion:accion, curso:curso, periodo:periodo, anho:anho},
            beforeSend:function(){
                bloquear();
            },
            success:function(respuesta){
                desBloquear();
                $("#tablaPlanilla").html(respuesta);
                alertify.success("Lista Cargada con éxito");
                $("#tblObservaciones").dataTable();
            },
            error:function(respuesta){
                desBloquear();
                console.log('test: '+respuesta);
            }
        });               
    }
    //return false;
}

function guardarObservacionBoletin(idMatricula, opcion,id){
    if(opcion == 1){
        agregarObservacionBoletin(idMatricula);
    }

    if(opcion == 2){
        modificarObservacionBoletin(idMatricula,id);
    }    
}

function agregarObservacionBoletin(idMatricula){
    //alert("Entro a guardar la observacion con la opcion agregar");
    var accion="agregar";
    var curso =  $('#curso').val();
    var periodo= $('#periodo').val();
    var anho= $('#anho').val();
    var observacion = $("#observacion"+idMatricula).val();
    if(observacion != ""){
        $.ajax({
            type:"POST",
            url:"Controladores/ctrlObservaciones_boletines.php",
            data:{accion:accion, idMatricula:idMatricula, curso:curso, periodo:periodo, anho:anho, observacion:observacion},
            beforeSend:function(){
                $(".cargando"+idMatricula).fadeIn('fast');
            },
            success:function(respuesta){
                alertify.success(respuesta);
                $(".cargando"+idMatricula).fadeOut('fast');
            },
            error:function(respuesta){
                $(".cargando"+idMatricula).fadeOut('fast');
                console.log('test: '+respuesta);
            }
        }); 
    }else{
        alertify.error("La observación no puede estar vacía, Por favor ingresa el texto para poder guardar");
    }
}

function modificarObservacionBoletin(idMatricula,id){
    
    var accion="modificar";
    var observacion = $("#observacion"+idMatricula).val();
    
    $.ajax({
        type:"POST",
        url:"Controladores/ctrlObservaciones_boletines.php",
        data:{accion:accion, id:id, observacion:observacion},
        beforeSend:function(){
            $(".cargando"+idMatricula).fadeIn('fast');
        },
        success:function(respuesta){
            alertify.success(respuesta);
            $(".cargando"+idMatricula).fadeOut('fast');
        },
        error:function(respuesta){
            alertify.success(respuesta);
            $(".cargando"+idMatricula).fadeOut('fast');
            console.log('test: '+respuesta);
        }
    }); 
}    

function eliminarObservacionBoletin(idMatricula,id){
    alertify.defaults.transition = "flipy";
    alertify.defaults.theme.ok = "btn btn-primary";
    alertify.defaults.theme.cancel = "btn btn-danger";
    alertify.defaults.theme.input = "form-control";
    alertify.confirm(
        '<div class="panel-heading" style="background-color:#902015;color:#fff;"><i class="fa fa-times-circle"> Eliminar Observación</i></div>', 
        'Para continuar con la eliminación la observación seleccionada presione el botón OK', 
        function()
        {             
            $.ajax({
                type:"POST",
                url:"Controladores/ctrlObservaciones_boletines.php",
                data:{accion:"eliminar", id:id},
                beforeSend:function(){
                    $(".cargando"+idMatricula).fadeIn('fast');
                },
                success:function(respuesta){
                    alertify.success(respuesta);
                    $(".cargando"+idMatricula).fadeOut('fast');
                    $("#observacion"+idMatricula).val("");
                },
                error:function(respuesta){
                    alertify.success(respuesta);
                    $(".cargando"+idMatricula).fadeOut('fast');
                    console.log('test: '+respuesta);
                }
            }); 
        }, function(){  /*alertify.error('Cancel') */ }
    ).set('closable', false);

}   
//####==== Lista de funciones relacionadas con las observaciones de cada area ===#####//

function cargarListaObservaciones(){  
    var accion = 'lista';
    var area = $('#areas').val();
    var periodo = $('#periodo').val();
    var curso = $('#curso').val();
    var anho = $('#anho').val();
    if(area == ""){
        alertify.error("Por favor Seleccione el área para poder continuar");
    }else if(periodo == ""){
        alertify.error("Por favor Seleccione el periodo para poder continuar");
    }else{
        $.ajax({
            type:"POST",
            url:"vistas/calificar/observaciones.php",
            data:{accion:accion, curso:curso, codArea:area, periodo:periodo, anho:anho},
            beforeSend:function(){
                bloquear();
            },
            success:function(respuesta){
                desBloquear();
                $("#tablaPlanilla").html(respuesta);
                alertify.success("Lista Cargada con éxito");
                $("#tblObservaciones").dataTable();
            },
            error:function(respuesta){
                desBloquear();
                console.log('test: '+respuesta);
            }
        });               
    }
    //return false;
}

function agregarObservacion(estudiante,observacion){
    var accion="agregarObservacion";
    var curso=document.getElementById('curso').value;
    var periodo=document.getElementById('periodo').value;
    var anho=document.getElementById('anho').value;
    var inst=document.getElementById('institucion').value;
    $("#obs"+estudiante).load("Calificar/vistas/planilla.php",
        {
         accion:accion,
         inst:inst,
         observacion:observacion,
         estudiante:estudiante,
         periodo:periodo,
         anho:anho,
         curso:curso
        },function(){
        alertify.success("Observacion Agregada con éxito");
    });
}

function modificarObservacion(estudiante,observacion){
    var accion="modificarObservacion";
    var curso=document.getElementById('curso').value;
    var periodo=document.getElementById('periodo').value;
    var anho=document.getElementById('anho').value;
    var inst=document.getElementById('institucion').value;
    $("#obs"+estudiante).load("Calificar/vistas/planilla.php",
        {
         accion:accion,
         inst:inst,
         observacion:observacion,
         estudiante:estudiante,
         periodo:periodo,
         anho:anho,
         curso:curso
        },function(){
        alertify.success("Observación Modificada con éxito");
    });
}    

function eliminarObservacion(estudiante,idObservacion){
    //alertify.alert("Los datos son: "+estudiante+" IdObservacion: "+idObservacion);
    var accion="eliminarObservacion";
    $("#obs"+estudiante).load("Calificar/vistas/planilla.php",
        {
         accion:accion,
         idObservacion:idObservacion,
         estudiante:estudiante
        },function(){
        alertify.success("Observación Eliminada con éxito");
    });
}     

function modificarObservacionAsignatura(estudiante,observacion){
    var accion="modificarObservacionAsignatura";
    var area=document.getElementById('areas').value;
    var curso=document.getElementById('curso').value;
    var periodo=document.getElementById('periodo').value;
    var anho=document.getElementById('anho').value;
    var inst=document.getElementById('institucion').value;
    $("#obs"+estudiante).load("Calificar/vistas/planilla.php",
        {
         accion:accion,
         inst:inst,
         observacion:observacion,
         estudiante:estudiante,
         area:area,
         periodo:periodo,
         anho:anho,
         curso:curso
        },function(){
        /*alertify.success("El estudiante es: "+codigo+" Nota es: "+nota+" El Curso es: "+curso);
        alertify.success("El Area es: "+area+" El periodo es: "+periodo+" El Año es: "+anho);*/
    });
}  
