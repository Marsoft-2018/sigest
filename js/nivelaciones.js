function cargarListaNivelacion(){
    //alertify.success("El modulo es: "+modulo);
    var curso = $('#curso').val();
    var area = $('#areas').val();
    var anho = $("#anho").val();
    var accion = 'listaEstudiantes';
    if(area === ""){
        alertify.error("Por favor Seleccione el área para poder continuar");
    }else if(anho === ""){
        alertify.error("Por favor Seleccione el año para poder continuar");
    }else{
        $('#bloquear').slideDown('fast');
        $.ajax({
            type:"POST",
            url:"Controladores/ctrlNivelaciones.php",
            data: {accion:accion, curso:curso, codArea:area, anho:anho},
            success: function(data){
                $("#tablaPlanilla").html(data);
                alertify.success("Lista Cargada con éxito");
                $('#bloquear').slideUp('fast');
            },
            error: function(err){
                console.log("Error: "+err)
            }
        });                  
    }
    
    return false;
}

function agregarNivelacion(idMatricula){
    var curso = $('#curso').val();
    var area = $('#areas').val();
    var nota = $("#nota"+idMatricula).val();
    var anho = $("#anho").val();
    var numActa = $("#numActa"+idMatricula).val();
    var diaActa = $("#diaActa"+idMatricula).val();
    var mesActa = $("#mesActa"+idMatricula).val();
    var observacion = $("#observacion"+idMatricula).val();
    var accion = 'agregar';
    //$('#bloquear').slideDown('fast');
    $.ajax({
        type:"POST",
        url:"Controladores/ctrlNivelaciones.php",
        data: {accion:accion,idMatricula:idMatricula, curso:curso, codArea:area,nota:nota, anho:anho, numActa: numActa, diaActa:diaActa, mesActa:mesActa, observacion: observacion},
        success: function(data){
            alertify.success("Respuesta: "+data);
            //$('#bloquear').slideUp('fast');
        },
        error: function(err){
            console.log("Error: "+err);
        }
    });
}