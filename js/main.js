
    function logear(){
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
                    
                }else if(data["estado"] == 4){
                    $("#error").html(data["mensaje"]).addClass("animated zoomIn").show('fast',function(){
                        setTimeout(function(){ $("#error").hide() }, 3000);
                    });
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