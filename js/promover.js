function continuar(){
    var accion=document.getElementById('accion').value;
    if(accion=='Automatico'){
        cargarMatriz();
    }else if(accion=='Manual'){
        cargarMatrizManual();
    }else if(accion=='0'){
        alertify.error("Seleccione el proceso para poder continuar");
    }
}

function cargarMatriz(){        
    var sede = $('#sede').val();
    var accion = "cargarMatrizEstudiantes";
    var anho =  $('#anho').val();
    $.ajax({
        type: "POST",
        url: "Controladores/ctrlPromover.php",
        data: {accion:accion,sede:sede,anho:anho},
        beforeSend: function(){
            bloquear();
        },
        complete:function(data){
            desBloquear();
        },
        success: function(data){
            $("#matrizCarga").html(data);
            $('#bloquear').slideUp('fast');
            $(".dataTable").dataTable();
        },
        error: function(res){
            console.log('test: '+res);
            $('#bloquear').slideUp('fast');
        }
    });
}

function Promover(estudiante,grado,grupo){
    //alert("Los datos recibidos son estudiante: "+estudiante+" grado: "+grado+" grupo: "+grupo);
    var accion="PromoverEstudiantes";
    $("#est-"+estudiante).load("config/ctrlPromover.php",{accion:accion,estudiante:estudiante,grado:grado,grupo:grupo});
}

function cargarMatrizManual(){
    alertify.alert("Continua el proceso con la matriz manual");
}


function cerrarAnho(){
    //alert("Los datos recibidos son estudiante: "+estudiante+" grado: "+grado+" grupo: "+grupo);
    var accion = "cerrarAnho";
    $.ajax({
        type:"POST",
        url: "Controladores/ctrlPromover.php",
        data: {accion:accion},
        success: function(data){
            $("#resultadoAnho").html(data);
        },
        error: function(res){
            console.log('test: '+res);
        }
    });    
}

function limpiarMatriz(){
    $("#matrizCarga").html("");
}