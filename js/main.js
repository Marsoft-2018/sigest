function logear() {
    $.ajax({
        type:"POST",
        data:$('#frmLogin').serialize(),
        url:"Controladores/ctrlValidacion.php",
        success:function(data){
            data = JSON.parse(data);
            
            console.log('Mensaje: '+data["mensaje"]);
            // respuesta = respuesta.trim();
            // console.log(respuesta);
            if(data["estado"] == 1) {
                window.location="inicio.php";
            }else if(data["estado"] == 2){
                $("#mensajes").html(data["mensaje"]).addClass("animated zoomIn").show('fast',function(){
                    setTimeout(function(){ $("#mensajes").hide() }, 10000);
                });
            }else if(data["estado"] == 3){
                if(data["mensaje"] != ""){
                    $("#mensajes").html(data["mensaje"]).addClass("animated zoomIn").show('fast',function(){
                        setTimeout(function(){ $("#mensajes").hide(); window.location="inicio.php";}, 6000);
                    });
                }else{
                    window.location="inicio.php";
                }
                
            }else{
                $("#error").html("El Nombre de usuario o la contraseña no es correcto").addClass("animated zoomIn").show('fast',function(){
                    setTimeout(function(){ $("#error").hide() }, 3000);
                });
            }
        }
    });
    return false;
}

function salir(){
	top.location.href = "http://";
}

function limpiarAreaDeTrabajo(){   
    document.getElementById("tablaPlanilla").innerHTML="";    
    //document.getElementById("tablaObservaciones").innerHTML='';           
}

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


   /* $("#mensajes").load("Controladores/ctrlCalificaciones.php",{accion:accion,periodo:periodo,anho:anho},function(){
        
    });
    $("#mensajesObs").load("Controladores/ctrlCalificaciones.php",{accion:accion,periodo:periodo},function(){
        
    });*/
}

function cargarDesemp(idMatricula,nota){
    var accion  ='Desempeno';
    var area    = $("#areas").val();
    var curso   = $("#curso").val();
    var periodo = $("#periodo").val();
    var anho    = $("#anho").val();        
    $("#des"+idMatricula).load("Controladores/ctrlCalificaciones.php",{accion:accion, nota:nota},function(){
        /*alertify.success("El estudiante es: "+codigo+" Nota es: "+nota+" El Curso es: "+curso);
        alertify.success("El Area es: "+area+" El periodo es: "+periodo+" El Año es: "+anho);*/
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
  
function agregarNotaCriterio(idMatricula,nota,criterio,tabla){
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

        },
        success: function(data){
            alertify.success(data);
            console.log('test: '+data);
            $("#"+criterio+"_"+idMatricula).attr('onchange','');
            $("#"+criterio+"_"+idMatricula).attr('onchange',"modificarNotaCriterio('"+idMatricula+"',this.value,"+criterio+",'"+tabla+"');");
            definitivaCriterios(idMatricula,nota,criterio,tabla);
        },
        error:function(res){
            alertify.error(res);
        }
    });
}
  
function modificarNotaCriterio(idMatricula,nota,criterio,tabla){
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

        },
        success: function(data){
            alertify.success(data);
            console.log('test: '+data);
            $("#"+criterio+"_"+idMatricula).attr('onchange','');
            $("#"+criterio+"_"+idMatricula).attr('onchange','modificarNotaCriterio(this.id,this.value);');
            definitivaCriterios(idMatricula,nota,criterio,tabla);
        },
        error:function(res){
            alertify.error(res);
        }
    });
}

function definitivaCriterios(idMatricula,nota,criterio,tabla){
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
            cargarDesemp(idMatricula,data);
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
            $("#el"+idMatricula).fadeIn();
        },
        error:function(res){
            alertify.error(res);
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

function cargarRegistroNotas(){ 
    let sede = $("#sede").val(); 
    let anho = $("#anho").val(); 
    let periodo = $("#periodo").val();
    var accion = "cargarMatriz";
    $.ajax({
      type: "POST",
      url: "vistas/reportes/controlNotas/tablaReporte.php",
      data:{accion:accion,sede:sede,periodo:periodo,anho:anho},
      beforeSend:function(){
        bloquear();
      },
      success: function(response){
        $("#matrizCarga").html(""+response);
        desBloquear();
      },
      error:function(response){
        $("#matrizCarga").html("Error: "+response);
        desBloquear();
      }
    }); 
    return false;
}

function cargarReporteDesempeño(){
    $("#marcoReporte").html("");
    //alertify.success("El modulo es: "+modulo);
    var curso = document.getElementById('curso').value;
    var anho = $("#anho").val();
    var accion = 'lista';
    //var desempenho = $('#desempenho').val();
    var periodo = $('#periodo').val();

    $.ajax({
        type: "POST",
        url: "vistas/reportes/Desempenos/tablaReporte.php",
        data: {accion:accion, curso:curso, periodo:periodo, anho:anho},
        beforeSend: function(){
            bloquear();
        },
        success:function(respuesta){
            $("#marcoReporte").html(respuesta);
            $(".tblReporte").dataTable();
            desBloquear();
        },
        error: function(respuesta){
            desBloquear();
        }
    });
    
    return false;
}//ok

function actualizarPerfil(){
    $.ajax({
        type: 'POST',
        url: "Controladores/ctrlPerfil.php?accion=Actualizar",
        data:$("#formPerfil").serialize(),
        beforeSend: function(){
            bloquear();
        },
        success: function(data){
            //$("#resultado").html(data);
            desBloquear();
            alertify.success(data);
        },
        error: function(data){
            alertify.error(data);
            console.log('test: '+data);
            desBloquear();
        }
    });
    return false;
}

function contrasena(usuario,rol){       
   alertify.defaults.transition = "flipy";
    alertify.defaults.theme.ok = "btn btn-primary";
    alertify.defaults.theme.cancel = "btn btn-danger";
    alertify.defaults.theme.input = "form-control";
    alertify.confirm(
        '<div class="alert" style="background-color:#098689; color:#fff; padding: 10px 10px;"><h3 style="padding: 0px; margin:0px;" ><i class="fa fa-user"> Cambiar Contraseña</i></h3></div>',
        '<form name="formulario" method="post" id="frmLogin" target="_self" class="animated zoomIn">'+
            '<label>Nueva contraseña</label>'+
            '<div class="input-group">'+
                '<span class="input-group-addon"><i class="fa fa-key"></i></span>'+
                '<input type="password" value="" class="form-control" placeholder="Nueva Contraseña" id="contrasena1" required="required">'+
            '</div>'+
            '<hr>'+
            '<label>Confirmar contraseña</label>'+
            '<div class="input-group">'+
                '<span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>'+
                '<input type="password" value=""  class="form-control" placeholder="Confirmar Contraseña" id="contrasena2" required="required">'+
            '</div>'+                 
        '</form>', 
        function()
        { 
            var contrasena1 = document.getElementById('contrasena1').value;
            var contrasena2 = document.getElementById('contrasena2').value;
            var accion = 'modificar';                 
            if(contrasena1 == contrasena2){
                $.ajax({
                    type: "POST",
                    url: "Controladores/ctrlContrasenas.php",
                    data: {accion:accion, usuario:usuario, contrasena:contrasena1, rol:rol},
                    success: function(respuesta){
                        alertify.success(respuesta);
                        $("#contrasena").val(contrasena1);
                    },
                    error: function(respuesta){
                        console.log('test: '+respuesta);
                    }
                });
            }else{
                alertify.error("Las contraseñas no coinciden");
                exit;
            }                  
        }, 
        function()
        { 
            //alertify.error('Cancel')
        }
    ).set('closable', false);
}

function verReporte(id) {
    $("#marcoReporte").html("");
    //alertify.success("El modulo es: "+modulo);
    var curso = $('#curso').val();
    var anho = $("#anho").val();
    var accion = 'reporte';
    //var desempenho = $('#desempenho').val();
    var periodo = $('#periodo').val();

    $.ajax({
        type: "POST",
        url: "Controladores/ctrlEstudiantes.php",
        data: {accion:accion, curso:curso, periodo:periodo, anho:anho},
        beforeSend: function(){
            bloquear();
        },
        success:function(respuesta){
            $("#cargasFormulario").html(respuesta);            
            desBloquear();
        },
        error: function(respuesta){
            desBloquear();
        }
    });
    
    return false;
}


function programarExcepciones(periodo){        
    $('#cargasFormulario').load('vistas/excepciones/formularioExcepciones.php',{periodo:periodo});
}

function listarExcepciones(){
    var sede    = $("#sede").val();
    var anho    = $("#anho").val();
    var periodo    = $("#periodo").val();
    var accion  = 'cargarListaProfe';
    $("#listadoProfesoresSede").load("vistas/excepciones/listadoProfesores.php",
      {
        accion:accion,
        sede:sede,
        anho:anho,
        periodo:periodo
      },function(){
        alertify.success("Cargado con éxito");
    });

    return false;
}

function guardarExcepcion(profe,periodo){
    
    var anho    = $("#anho").val();
    var fechaInicio = $("#FI"+profe).val();
    var fechaCierre = $("#FC"+profe).val();
    var accion  = 'guardar';

    $.ajax({
        type: "POST",
        url: "Controladores/ctrlExcepcionesPeriodos.php",
        data: {
            accion:accion, 
            periodo:periodo, 
            anho:anho, 
            idUsuario:profe, 
            fechaInicio:fechaInicio, 
            fechaCierre:fechaCierre
        },
        success: function(data){
            alertify.success(data);
            $("#add"+profe).attr('onclick','');
            $("#add"+profe).attr('onclick','modificarExcepcion('+profe+','+periodo+')');            
        },
        error:function(res){
            alertify.error(res);
        }
    });
}

function modificarExcepcion(profe,periodo){    
    var anho    = $("#anho").val();
    var fechaInicio = $("#FI"+profe).val();
    var fechaCierre = $("#FC"+profe).val();
    var accion  = 'modificar';

    $.ajax({
        type: "POST",
        url: "Controladores/ctrlExcepcionesPeriodos.php",
        data: {
            accion:accion, 
            periodo:periodo, 
            anho:anho, 
            idUsuario:profe, 
            fechaInicio:fechaInicio, 
            fechaCierre:fechaCierre
        },
        success: function(data){
            alertify.success(data);  
            $("#add"+profe).attr('onclick','');
            $("#add"+profe).attr('onclick','modificarExcepcion('+profe+','+periodo+')');         
        },
        error:function(res){
            alertify.error(res);
        }
    });
}

function eliminarExcepcion(profe,periodo){
    
    var anho    = $("#anho").val();
    var accion  = 'eliminar';

    $.ajax({
        type: "POST",
        url: "Controladores/ctrlExcepcionesPeriodos.php",
        data: {
            accion:accion, 
            periodo:periodo, 
            anho:anho, 
            idUsuario:profe
        },
        success: function(data){
            alertify.success(data);  
            $("#add"+profe).attr('onclick','');
            $("#add"+profe).attr('onclick','guardarExcepcion('+profe+','+periodo+')');
            $("#FI"+profe).val("");
            $("#FC"+profe).val("");          
        },
        error:function(res){
            alertify.error(res);
        }
    });
}

function activarPeriodo(tipo){
    switch(tipo) {
        case "Periodos":                
            $("#periodo").removeAttr('disabled');
            break;
        case "Final":            
            $("#periodo").attr('disabled','true');
            break;
    }    
}

function cambiarSede(sedeNew){
    var sedeOld = $("#sedeOld").val();
    if(sedeNew != sedeOld){
        $("#advertencia").html('<div class="alert alert-warning">Al confimar el cambio de sede del profesor se eliminará la carga académica del mismo en la sede anterior</div>');
        $("#cambiaSede").val("SI");
    }else{
        $("#advertencia").html('');
        $("#cambiaSede").val("NO");
    }
}

/* Acciones para programar la fecha en que los estudiantes pueden ver y descargar los informes */

function programarEntrega(periodo){        
    $('#cargasFormulario').load('vistas/entregas/formularioEntregas.php',{periodo:periodo});
}

function listarCursosEntrega(){
    var sede    = $("#sede").val();
    var anho    = $("#anho").val();
    var periodo    = $("#periodo").val();
    var accion  = 'cargarListaCursos';
    $("#listados").load("vistas/entregas/listadoCursos.php",
      {
        accion:accion,
        sede:sede,
        anho:anho,
        periodo:periodo
      },function(){
        alertify.success("Cargado con éxito");
    });

    return false;
}

function activarGuardar(id){
    console.log('test: '+id);
    $("#add"+id).removeAttr('disabled');
}

function guardarEntregaInformePeriodo(curso,periodo,anho){
    let accion = "Agregar";
    let fecha = $("#FI"+curso).val();    
    $.ajax({
        type : "POST",
        url : "Controladores/ctrlEntregaInformes.php",
        data : {accion:accion, fecha:fecha, curso :curso,periodo :periodo,anho :anho},
        success: function(data){
            alertify.success(data);
            $("#add"+curso).attr('onclick','');
            $("#add"+curso).attr('onclick','modificarEntregaInformePeriodo('+curso+','+periodo+','+anho+')');
            $("#exe"+curso).removeAttr('disabled');
            $("#rem"+curso).removeAttr('disabled');
        }
    });
}   

function eliminarEntregaInforme(curso,periodo){
    
    var anho    = $("#anho").val();
    var accion  = 'eliminar';

    $.ajax({
        type: "POST",
        url: "Controladores/ctrlEntregaInformes.php",
        data: {
            accion:accion, 
            periodo:periodo, 
            anho:anho, 
            curso:curso
        },
        success: function(data){
            alertify.success(data);  
            $("#add"+curso).attr('onclick','');
            $("#add"+curso).attr('onclick','guardarEntregaInformePeriodo('+curso+','+periodo+','+anho+')');
            $("#FI"+curso).val("");  
            $("#add"+curso).attr('disabled','true');
            $("#exe"+curso).attr('disabled','true');
            $("#rem"+curso).attr('disabled','true');       
        },
        error:function(res){
            alertify.error(res);
        }
    });
}

function fechaParaTodos(){
    let accion = "FechaTodos";
    let fecha = $("#fechaAll").val();  
    var anho    = $("#anho").val();
    var periodo    = $("#periodo").val(); 
    var sede    = $("#sede").val(); 
    $.ajax({
        type : "POST",
        url : "Controladores/ctrlEntregaInformes.php",
        beforeSend: function(){ bloquear(); },
        data : {accion:accion, fecha:fecha, sede:sede, anho:anho, periodo:periodo},
        success: function(data){
            listarCursosEntrega();
            desBloquear();
        }
    });
} 

function modificarEntregaInformePeriodo(curso,periodo,anho){
    let accion = "modificar";
    let fecha = $("#FI"+curso).val();    
    $.ajax({
        type : "POST",
        url : "Controladores/ctrlEntregaInformes.php",
        data : {accion:accion, fecha:fecha, curso :curso,periodo :periodo,anho :anho},
        success: function(data){
            alertify.success(data);
            $("#add"+curso).attr('disabled','true');
        }
    });
}   

function listarEstudiantesEntrega(curso,periodo,anho){
    let accion = "activarEstudiantes";
    let sede = $("#sede").val();
    let fecha = $("#FI"+curso).val();    
    $.ajax({
        type : "POST",
        url : "vistas/entregas/listadoEstudiantes.php",
        data : {accion:accion, fecha:fecha, curso :curso,periodo :periodo,anho :anho, sede: sede},
        success: function(data){
            alertify.success("Cargado con éxito");
            $("#listados").html('');
            $("#listados").html(data);
        },error: function(data){
            alertify.error("Error al cargar los estudiantes");
        }
    });
}

function activarEstudiantes(estudiante,idEntrega,estado){
    let accion = "activarEstudiantes";
    if ( $('#'+estudiante).attr('checked')) {
        $('#'+estudiante).attr('checked', false);
    } else {
        $('#'+estudiante).attr('checked', 'checked');
    }  
    console.log('test: '+estudiante+" "+idEntrega+" "+estado);
    $.ajax({
        type : "POST",
        url : "Controladores/ctrlEntregaInformes.php",
        data : {
            accion : accion, 
            estudiante : estudiante, 
            idEntrega : idEntrega,
            estado : estado 
        },
        success: function(data){
            alertify.success(data);
            $("#"+estudiante).attr('onclick','activarEstudiantes('+estudiante+','+idEntrega+','+!estado+')');
        }
    });
}  

function cambiarContrasenha(usuario, rol){
    console.log('Rol: '+rol+" | Usuario: "+usuario);
    var accion = "modificar";
    let contrasena = $("#contrasena").val();
    let contrasena2 = $("#contrasena2").val();
    if (contrasena == contrasena2) {
        $.ajax({
            type : "POST",
            url : "Controladores/ctrlContrasenas.php",
            data : {
                accion : accion, 
                usuario : usuario, 
                rol : rol,
                contrasena : contrasena 
            },
            success: function(data){
                alertify.success(data);                
            }
        });
    }else{
        alertify.error("<i class='fa fa-exclamation-circle'></i> Por favor verifique:<br>Las contraseñas deben ser iguales");
    }    
}

function cargarBoletinEstudiante(sede,curso,anho,estudiante){
    var periodo = $("#periodo").val();
    console.log('sede: '+sede+" curso: "+curso+" anho: "+anho+" Estudiante: "+estudiante);
    $.ajax({
        type: "POST",
        url: "Controladores/ctrlBoletin.php",
        data: {
            accion:"boletinEstudiante",
            sede: sede,
            curso: curso,
            anho: anho,
            periodo: periodo, 
            Estudiante: estudiante,
            tipoB: "paraEstudiante",
            Pg: 1,
            Cant: 1,
            boletinEstudiante: "true"
        },
        success: function(data){
            $("#view_boletin").html(data);
        },
        error: function(res){

        }
    });
}

function reportePlanillas(){
    $.ajax({
        type: 'POST',
        url: "vistas/reportes/enPdf/reporte.php",
        data:$("#formPlanilla").serialize(),
        beforeSend: function(){
            $('#bloquear').slideDown('fast');
        },
        success: function(data){
            $("#planillaResultado").html(data);
            $('#bloquear').slideUp('fast');
            alertify.success("Listo");
        },
        error: function(data){
            alertify.error(data);
            console.log('test: '+data);
            $('#bloquear').slideUp('fast');
        }
    });
    return false;
}