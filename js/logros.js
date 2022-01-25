    function agregarLogro(tabla){
        var accion = "guardarLogro";
        var area    = $("#areas").val();
        var curso   = $("#curso").val();
        var periodo = $("#periodo").val();
        var anho    = $("#anho").val(); 
        var indicador = $('#logroInfinitivo').val();
        var criterio  = $('#codCriterio').val();

        $.ajax({
            type: "POST",
            url: "Controladores/ctrlCalificaciones.php",
            data: {accion: accion, indicador:indicador, codCriterio:criterio, area:area, periodo:periodo, curso:curso},
            success: function(data){
                cargarListadoLogros();
                $('#logroSuperior').html('');
                $('#logroAlto').html('');
                $('#logroBasico').html('');
                $('#logroBajo').html('');
            },
            error: function(){
                alertify.error("Error: al agregar el indicador");
            }
        });
    }

    function cargarAreasCursoProfesor(curso,profesor){
        var accion = 'cargarAreasCursoProfesor';
        $("#celdaAreas").load("Calificar/vistas/planilla.php",{accion:accion,curso:curso,profesor:profesor},function(){
            /*alertify.success("El estudiante es: "+codigo+" Nota es: "+nota+" El Curso es: "+curso);
            alertify.success("El Area es: "+area+" El periodo es: "+periodo+" El Año es: "+anho);*/
        });
    }

    function cargarListadoLogros(){
        var accion  = 'cargarListadoLogro';
        var area    = $("#areas").val();
        var curso   = $("#curso").val();
        var periodo = $("#periodo").val();
        var anho    = $("#anho").val(); 
        if (area == "") {
            alertify.error("Por favor seleccione el área para poder continuar");
        }else if(periodo == ""){
            alertify.error("Por favor seleccione el periodo para poder continuar");
        }

        if(area != "" && periodo != ""){
            $("#tablaLogros").load("vistas/calificar/listaLogros.php",{
                accion:accion,curso:curso,area:area,periodo:periodo,anho:anho},function(){
            });            
        }
        return false;
    }

    function cargarFormLogros(){
        var accion  = 'cargarListadoLogro';
        var area    = $("#areas").val();
        var curso   = $("#curso").val();
        var periodo = $("#periodo").val();
        var anho    = $("#anho").val(); 
        if (area == "") {
            alertify.error("Por favor seleccione el área para poder continuar");
        }else if(periodo == ""){
            alertify.error("Por favor seleccione el periodo para poder continuar");
        }else{
            $("#formularioLogros").load("vistas/calificar/formularioLogros.php",{
                accion:accion, 
                curso:curso, 
                area:area, 
                periodo:periodo,
                anho:anho
            }, function(){
                    cargarListadoLogros();
                });            
        }

    }

    function concatenarLogro(texto) {        
        $('#logroSuperior').html('<strong>DESEMPEÑO - SUPERIOR:</strong> Demuestro habilidades superiores para '+texto);
        $('#logroAlto').html('<strong>DESEMPEÑO - ALTO:</strong> Tengo muy buenas habilidades para '+texto);
        $('#logroBasico').html('<strong>DESEMPEÑO - BASICO:</strong> Soy capaz de '+texto+'.');
        $('#logroBajo').html('<strong>DESEMPEÑO - BAJO:</strong> Tengo dificultad para '+texto+'.');
    }

function cargarEdicionLogro(id){
    var accion = "cargarEdicionLogro";
    $.ajax({
        type:"POST",
        url: "Controladores/ctrlCalificaciones.php",
        data: {accion: accion, id:id},
        datatype: "json",
        success: function(response){
            response = JSON.parse(response);
            $("#codCriterio").val(response[0]['codCriterio']);
            $("#logroInfinitivo").val(response[0]['INDICADOR']);
            concatenarLogro(response[0]['INDICADOR']);
            $("#btnEditar").fadeIn();   
            $("#btnCancelar").fadeIn();                             
            $("#btnAgregar").attr({'disabled':true});
            $("#btnEditar").attr({'onclick':'guardarCambios('+response[0]['CODIND']+')'});                
        },
        error: function(data){
            alertify.error("Error: no se pudo cargar el indicador");
        }
    });
}

function guardarCambios(id){
    var accion  = "modificarLogro"; 
    var indicador = $('#logroInfinitivo').val();
    var criterio  = $('#codCriterio').val();

    $.ajax({
        type: "POST",
        url: "Controladores/ctrlCalificaciones.php",
        data: {accion: accion, indicador:indicador, codCriterio:criterio, id:id },
        success: function(data){
            cargarListadoLogros();
            $('#logroInfinitivo').val("");
            $('#codCriterio').val("");
            $('#logroSuperior').html('');
            $('#logroAlto').html('');
            $('#logroBasico').html('');
            $('#logroBajo').html('');
            alertify.success(data);
            $("#btnEditar").fadeOut();
            $("#btnCancelar").fadeOut(); 
            $("#btnAgregar").removeAttr('disabled');
        },
        error: function(){
            alertify.error("Error: al las modificaciones en el indicador");
        }
    });        
}//OK

function cancelarEdicion(){
    $('#logroInfinitivo').val("");
    $('#codCriterio').val("");
    $('#logroSuperior').html('');
    $('#logroAlto').html('');
    $('#logroBasico').html('');
    $('#logroBajo').html('');
    $("#btnEditar").fadeOut();
    $("#btnCancelar").fadeOut();
    $("#btnAgregar").removeAttr('disabled');
}

function eliminarIndicador(id){
    alertify.defaults.transition = "flipy";
    alertify.defaults.theme.ok = "btn btn-primary";
    alertify.defaults.theme.cancel = "btn btn-danger";
    alertify.defaults.theme.input = "form-control";
    alertify.confirm(
        '<div class="panel-heading" style="background-color:#902015;color:#fff;"><i class="fa fa-times-circle"> Eliminar Indicador</i></div>', 
        'Para continuar con la eliminación del indicador presione el botón OK.', 
    function()
    { 
        var accion  = 'eliminarIndicador'; 
        $.ajax({
            type: "POST",
            url: "Controladores/ctrlCalificaciones.php",
            data:{accion:accion, id:id},
            success:function(data){
                alertify.success(data);
                cargarListadoLogros();
            },
            error:function(){
                alertify.error("Error: No se pudo eliminar el Indicador");
            }
        });
    }, 
    function(){ }).set('closable', false);        
} 

function cambiarEstadoLogro(id,estado){        
    var accion='cambiarEstadoLogro';
    $.ajax({
        type: "POST",
        url: "Controladores/ctrlCalificaciones.php",
        data:{accion:accion, id:id, estado:estado},
        success:function(data){
            cargarListadoLogros();
        },
        error:function(){
            alertify.error("Error: No se pudo cambiar el estado del Indicador");
        }
    });
}

function limpiarAreaLogros(){   
    $("#formularioLogros").html('');           
}
