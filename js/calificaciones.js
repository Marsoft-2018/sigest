
function ValidarPeriodo(){
    var accion  = "ValidarPeriodo";
    var periodo = $("#periodo").val();
    var anho    = $("#anho").val();
    //alertify.success("Validar periodo: "+periodo+" anho: "+anho);
    $.ajax({
        type : "POST",
        url: "Controladores/ctrlCalificaciones.php",
        data: {accion:accion,periodo:periodo,anho:anho},
        success: function(data){
            //console.log(data);
            data = JSON.parse(data);
            $("#mensajes").html(data["mensaje"]);
        },
        error: function(res){
            console.log('Error_:'+res);
        }
    });
}

function cargarDesemp(idMatricula,nota,grado){   
    var accion  ='Desempeno';
    var area    = $("#areas").val();
    var curso   = $("#curso").val();
    var periodo = $("#periodo").val();
    var anho    = $("#anho").val();     
    $.ajax({
        url:"Controladores/ctrlCalificaciones.php",
        type:"POST",
        data:{accion:accion, nota:nota,grado:grado},
        success: function(data){
            $("#des"+idMatricula).html(data);
        },
        error: function(err){
            console.log("Error: "+err);
        }
    });
}

function cargarTodasLasAreas(){
    var curso = $("#curso").val();
    var anho = $("#anho").val();
    $.ajax({
        type: 'POST',
        url: "Controladores/ctrlAreas.php",
        data: {accion:"CargarTodasLasAreas", curso:curso, anho:anho},
        beforeSend: function(){

        },
        complete:function(data){
            //console.log('Terminó el envío');
        },
        success: function(data){                
            $('#areas').html("");
                 /*        console.log("response: "+response);
                        alertify.success("El curso es: "+curso+" anho: "+anho);*/
           
            $("#areas").append('<option value="">Seleccione..</option>');
            $.each(JSON.parse(data),function(key, registro) {                    
                $("#areas").append('<option value='+registro.id+'>'+registro.tipo+": "+registro.Nombre+'</option>');
                //espacio para recorrer las asignaturas del área
                        
                $.ajax({
                    type: 'POST',
                    url: "Controladores/ctrlAreas.php",
                    data: {accion:"CargarAsignaturas", curso:curso, anho:anho, idArea:registro.id},
                    success: function(response){ 
                        $.each(JSON.parse(response),function(key, dato) {                    
                            $("#areas").append('<option value='+dato.id+'>'+dato.tipo+": "+registro.Abreviatura+"| "+dato.Nombre+'</option>');
                        });
                    },
                    error: function(data){
                        console.log('Error: '+data);
                    }
                });
                //fin del recorrido de las asignaturas
            });
        },
        error: function(data){
            console.log('Error: '+data[0]);
        }
    });
}
 

/*Acciones para la nota definicitva */ 
function agregarNota(idMatricula,nota){
    var accion  = "agregarNota";
    var area    = $("#areas").val();
    var curso   = $("#curso").val();
    var periodo = $("#periodo").val();
    var anho    = $("#anho").val();
    var faltas  = $("#ina"+idMatricula).val();

    if(faltas === undefined ){
        faltas = 0;
    }
    
    $.ajax({
        type: "POST",
        url: "Controladores/ctrlCalificaciones.php",
        data: {accion:accion, nota:nota, faltas:faltas, idMatricula:idMatricula, area:area, periodo:periodo, anho:anho, curso:curso},
        beforeSend: function(){

        },
        success: function(data){
            alertify.success(data);
            $("#"+idMatricula).attr('onchange','');
            $("#"+idMatricula).attr('onchange','modificarNota("+idMatricula+",this.value)');
            $("#el"+idMatricula).fadeIn();
        },
        error:function(res){
            alertify.error(res);
        }
    });
}

function mostrarInasistencias(idMatricula){
    $("#ina"+idMatricula).fadeIn();
}

function modificarNota(idMatricula,nota){
    var accion ="modificarNota";
    var area    = $("#areas").val();
    var curso   = $("#curso").val();
    var periodo = $("#periodo").val();
    var anho    = $("#anho").val();
  
     $.ajax({
        type: "POST",
        url: "Controladores/ctrlCalificaciones.php",
        data: {accion:accion, nota:nota, idMatricula:idMatricula, area:area, periodo:periodo, anho:anho, curso:curso},
        beforeSend: function(){

        },
        success: function(data){
            alertify.success(data);
            console.log('test: '+data);                
        },
        error:function(res){
            alertify.error(res);
        }
    });
}

function eliminarNota(idMatricula,tipo){
    var accion  = "eliminarNota";
    var area = $("#areas").val();
    var curso   = $("#curso").val();
    var periodo = $("#periodo").val();
    var anho    = $("#anho").val();

    $.ajax({
        type: "POST",
        url: "Controladores/ctrlCalificaciones.php",
        data: {accion:accion, tipo:tipo, idMatricula:idMatricula, area:area, periodo:periodo, anho:anho, curso:curso},
        beforeSend: function(){

        },
        success: function(data){
            alertify.success(data);
            console.log('test: '+data);
            $("#"+idMatricula).attr('onchange','');
            $("#"+idMatricula).attr('onchange','agregarNota(this.id,this.value)');
            $("#el"+idMatricula).fadeOut();
            $("#ina"+idMatricula).fadeOut();
            $("#"+idMatricula).val("");
            $("#des"+idMatricula).html("");
            $("#log"+idMatricula).html("");
        },
        error:function(res){
            alertify.error(res);
        }
    });               
}

function modificarFalta(idMatricula,falta){
    var accion  = "modificarFalta";
    var area    = $('#areas').val();
    var curso   = $('#curso').val();
    var periodo = $('#periodo').val();
    var anho    = $('#anho').val();
    $.ajax({
        type:"POST",
        url : "Controladores/ctrlCalificaciones.php",
        data:{
            accion:accion,
            area:area,
            curso:curso,
            periodo:periodo,
            anho:anho,
            idMatricula:idMatricula,
            falta:falta
        },
        success:function(data){
            console.log('test:'+data);
        },
        error:function(res){
            console.log('test'+res);
        }
    });
}

//Acciones pra las notas por criterio
  
function agregarNotaCriterio(idMatricula,nota,criterio,tabla,grado){
    var accion  = "agregarNotaCriterio";
    var area    = $("#areas").val();
    var curso   = $("#curso").val();
    var periodo = $("#periodo").val();
    var anho    = $("#anho").val();
    // console.log('test: '+idMatricula+" | "+nota+" | "+criterio+" | "+tabla);
    $.ajax({
        type: "POST",
        url: "Controladores/ctrlCalificaciones.php",
        data: {
            accion:accion,
            nota:nota,
            idMatricula:idMatricula,
            area:area,
            periodo:periodo,
            anho:anho, 
            curso:curso,
            criterio:criterio,
            tabla:tabla
        },
        beforeSend: function(){
            $("#cargando"+criterio+"_"+idMatricula).fadeIn();
            $("#"+criterio+"_"+idMatricula).fadeOut();
            console.log("Ocultando al input: "+"#"+criterio+"_"+idMatricula);
        },
        success: function(data){
            alertify.success(data);
            console.log('test: '+data);
            $("#"+criterio+"_"+idMatricula).attr('onchange','');
            $("#"+criterio+"_"+idMatricula).attr('onchange',"modificarNotaCriterio('"+idMatricula+"',this.value,"+criterio+",'"+tabla+"','"+grado+"');");
            definitivaCriterios(idMatricula,nota,criterio,tabla,grado);
        },
        error:function(res){
            alertify.error(res);
        },
        complete: function(){
            $("#cargando"+criterio+"_"+idMatricula).fadeOut();
            $("#"+criterio+"_"+idMatricula).fadeIn();
        }
    });
}
  
function modificarNotaCriterio(idMatricula,nota,criterio,tabla,grado){
    var accion  = "modificarNotaCriterio";
    var area    = $("#areas").val();
    var curso   = $("#curso").val();
    var periodo = $("#periodo").val();
    var anho    = $("#anho").val();
    // console.log('test: '+idMatricula+" | "+nota+" | "+criterio+" | "+tabla);
    $.ajax({
        type: "POST",
        url: "Controladores/ctrlCalificaciones.php",
        data: {
            accion:accion,
            nota:nota,
            idMatricula:idMatricula,
            area:area,
            periodo:periodo,
            anho:anho, 
            curso:curso,
            criterio:criterio,
            tabla:tabla
        },
        beforeSend: function(){
            $("#cargando"+criterio+"_"+idMatricula).fadeIn();
            $("#"+criterio+"_"+idMatricula).fadeOut('fast');
        },
        success: function(data){
            alertify.success(data);
            definitivaCriterios(idMatricula,nota,criterio,tabla,grado);
        },
        error:function(res){
            alertify.error(res);
        },
        complete: function(){
            $("#cargando"+criterio+"_"+idMatricula).fadeOut();
            $("#"+criterio+"_"+idMatricula).fadeIn();
        }
    });
}

function definitivaCriterios(idMatricula,nota,criterio,tabla,grado){
    var accion  = "definitivaCriterios";
    var area    = $("#areas").val();
    var curso   = $("#curso").val();
    var periodo = $("#periodo").val();
    var anho    = $("#anho").val();
    // console.log('test: '+idMatricula+" | "+nota+" | "+criterio+" | "+tabla);
    $.ajax({
        type: "POST",
        url: "Controladores/ctrlCalificaciones.php",
        data: {
            accion:accion,
            nota:nota,
            idMatricula:idMatricula,
            area:area,
            periodo:periodo,
            anho:anho, 
            curso:curso,
            criterio:criterio,
            tabla:tabla
        },
        beforeSend: function(){

        },
        success: function(data){
            $("#"+idMatricula).val(data);
            cargarDesemp(idMatricula,data,grado);
            cargarLogro(idMatricula,data);
            mostrarInasistencias(idMatricula);
            console.log('test: '+data);
            // $(".criterios"+idMatricula).attr('onchange','');
            // $(".criterios"+idMatricula).attr('onchange','modificarNota(this.id,this.value)');
            $("#el"+idMatricula).fadeIn();
            guardarDefinitiva(idMatricula,data,tabla);
        },
        error:function(res){
            alertify.error(res);
        }
    });
}

function guardarDefinitiva(idMatricula,nota,tabla){
    var accion  = "guardarDefinitiva";
    var area    = $("#areas").val();
    var curso   = $("#curso").val();
    var periodo = $("#periodo").val();
    var anho    = $("#anho").val();
    var faltas  = $("#ina"+idMatricula).val();

    if(faltas === undefined ){
        faltas = 0;
    }
    
    $.ajax({
        type: "POST",
        url: "Controladores/ctrlCalificaciones.php",
        data: {
            accion  : accion,
            nota    : nota,
            faltas  : faltas,
            idMatricula : idMatricula,
            area    : area,
            periodo : periodo,
            anho    : anho,
            curso   : curso,
            tabla   : tabla
        },
        beforeSend: function(){
        },
        success: function(data){
            alertify.success(data);
            $("#"+idMatricula).attr('onchange','');
            $("#"+idMatricula).attr('onchange','modificarNota(this.id,this.value)');
            //$("#el"+idMatricula).fadeIn();
        },
        error:function(res){
            alertify.error(res);
        },
        complete: function(){

        }
    });
}


//--------------------------------------------------------------------//
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
  
function agregarNotaAsignatura(estudiante,nota){
    var accion="agregarNotaAsignatura";
    var area=document.getElementById('areas').value;
    var curso=document.getElementById('curso').value;
    var periodo=document.getElementById('periodo').value;
    var anho=document.getElementById('anho').value;
    var faltas = document.getElementById('ina'+estudiante).value;
    var inst=document.getElementById('institucion').value;
    $("#txtNota"+estudiante).load("Calificar/vistas/planilla.php",
        {
         accion:accion,
         inst:inst,
         nota:nota,
         faltas:faltas,
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
  
function modificarNotaAsignatura(estudiante,nota){
    var accion="modificarNotaAsignatura";
    var area=document.getElementById('areas').value;
    var curso=document.getElementById('curso').value;
    var periodo=document.getElementById('periodo').value;
    var anho=document.getElementById('anho').value;
    var inst=document.getElementById('institucion').value;
    $("#des"+estudiante).load("Calificar/vistas/planilla.php",
        {
         accion:accion,
         inst:inst,
         nota:nota,
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

function modificarFaltaAsignatura(estudiante,falta){
    var accion="modificarFaltaAsignatura";
    var area=document.getElementById('areas').value;
    var curso=document.getElementById('curso').value;
    var periodo=document.getElementById('periodo').value;
    var anho=document.getElementById('anho').value;
    var inst=document.getElementById('institucion').value;
    $("#ina"+estudiante).load("Calificar/vistas/planilla.php",
        {
         accion:accion,
         inst:inst,
         falta:falta,
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
  
function cargarLogro(idMatricula,nota){
    var accion  = "cargarLogro";
    var area    = $("#areas").val();
    var curso   = $("#curso").val();
    var periodo = $("#periodo").val();
    var anho    = $("#anho").val();        
    $("#log"+idMatricula).load("Controladores/ctrlCalificaciones.php",{
        accion:accion, 
        nota:nota,
        periodo:periodo,
        curso:curso,
        area:area
    });
}

function mostrarCampos(estudiante){
    document.getElementById('ina'+estudiante).style.display = 'block';
    document.getElementById('obs'+estudiante).style.display = 'block';
}

function mostrarVariasCalificaciones(tipo){
    if(tipo == "Varias"){
        $('#totalNotas').fadeIn('fast');  

    }else{
        $('#totalNotas').fadeOut('slow');  
    }    
}

function guardarTipoPlanilla(){
    var cantidad_notas = "";
    var tipo = $("#tipoPlanilla").val();
    var tipo_logros = $("#tipo_logros").val();
    if (tipo == "Varias") {
        cantidad_notas = $("#cantidad_notas").val();
    }
    
    var tipo_promedio = "Normal";
    $.ajax({
        type: "POST",
        url: "Controladores/ctrlTipoPlanilla.php",
        data: {
            accion:"guardar",
            tipoPlanilla:tipo,
            cantidad_notas:cantidad_notas,
            tipo_promedio:tipo_promedio,
            tipo_logros: tipo_logros
        },
        success: function(data){
            alertify.success(data);
        },
        error: function(data){
            console.log('test: '+data);
        }
    });
}
    
function calcularDefinitiva(id,cantNotas){
    suma = 0;        
    $("."+id).each(function() {
        if ($(this).val() == "") {
            nota = 0;
        }else{
            nota = $(this).val();
        }
        suma = parseFloat(suma) + parseFloat(nota);
    });

    def = parseFloat(suma)/cantNotas;
    $(".def"+id).val(def.toFixed(1));
    cargarDesemp(id,def);
    cargarLogro(id,def);
}    
        
function guardarNotasVarias(){
    $.ajax({
        type: 'POST',
        url: "Controladores/ctrlCalificaciones.php?accion=agregarVariasNotas",
        data:$("#formPlanilla").serialize(),
        beforeSend: function(){
            bloquear();
        },
        complete:function(data){
            desBloquear();
        },
        success: function(data){
            $("#result").html(data);
            alertify.success(data);
        },
        error: function(data){
            alertify.error("Error al tratar guardar las notas\n"+data);
            desBloquear();
        }
    });
    return false;
}

function cargarNotasGuardadasEstudiante(idMatricula){
    //var sede=document.getElementById('sede').value;
    $('#cargasFormulario').html("");
    $('#tituloModal').html("Formulario de calificaciones");
    var anho = $('#anho').val();
    var curso = $('#curso').val();
    var area = $("#areas").val();
    var periodo = $("#periodo").val();
    $.ajax({
        type: "POST",
        url: "Controladores/ctrlCalificaciones.php",
        data: {accion:"verPlanillaIndividual", idMatricula:idMatricula, area:area, anho:anho, curso:curso, periodo:periodo},
        success: function(data){
            $('#cargasFormulario').html(data);
        },
        error: function(err){
            console.log("Error: "+err);
        }
    });
}

const modificarNotaEspecifica = (id)=>{
    $.ajax({
        url: "tools/load.gif",
        success: function(data){
            $("#btn"+id).html(data);
        }
    });
}