function menu(opcion){			
    $('#bloquear').slideDown('fast');
    $("#modulo").load(opcion,function(){	$("#bloquear").slideUp("fast"); $(".dataTable").dataTable(); });
}



function acciones(moduloED,pasaAccion,ident){			

    var cusu = document.getElementById('OcultoUsuario').value;
    var cpass= document.getElementById('OcultoPass').value;
    var crol= document.getElementById('OcultoRol').value;


    if (moduloED==6) {//Modulo Perfil de usuario
        $('#capa').slideDown('fast');
        $('#capa').load('editar.php',{Edid:cusu,pass:cpass,rol:crol,modulo:moduloED,accion:pasaAccion},function(){
            $('#vacciones').draggable();
        });				
    }	

    if (moduloED==7) {//Modulo listado de profesores
        //alert("Las variables son Modulo: "+moduloED+" accion: "+pasaAccion+" identificador: "+ident);
        var inst= document.getElementById('OcultoInst').value;
        $('#capa').slideDown('fast');
        $('#capa').load('editar.php',{
            Edid:ident,						
            inst:inst,
            modulo:moduloED,
            accion:pasaAccion
        },function(){
            $('#vacciones').draggable();
        });				
    }	


}

function ajustes(moduloED,pasaAccion,ide){
    //Para trabajar con el modulo de las SEDES							    
    if(moduloED==5){
        if(pasaAccion==1){
            //Para Actualizar los datos 									
            var nomSedeED= document.getElementById('sedeED'+ide).value;
            
            $.ajax({
                type: 'POST',
                url: "Controladores/ctrlAjustes.php",
                data: {modulo:moduloED, accion:pasaAccion, institucion:inst, sedeID:ide, sedeNom:nomSedeED},
                beforeSend: function(){
                    $('#bloquear').slideDown('fast');
                },
                complete:function(data){
                    //console.log('Terminó el envío');
                },
                success: function(data){                
                    $('#resultado').html(data);
                    $("#bloquear").slideUp("fast");
                },
                error: function(data){
                    console.log('Error: '+data);
                }
            });
        }	
        
        if(pasaAccion==2){				
            //Para agregar una nueva sede				
            var codSedeN = $('#codSedeNueva').val();
            var nomSedeN = $('#nombreSedeNueva').val();
            if (nomSedeN != 0 && codSedeN != "") {            
                $.ajax({
                    type: "POST",
                    url: 'Controladores/ctrlSedes.php',
                    data: {accion:"agregarSede",codigo:codSedeN,nombre:nomSedeN},
                    success:function(res){
                        $('#listaSedes').load("vistas/datosSedes/listadoSedes.php",
                        {accion:"Mostrar"},function(){
                            alertify.success(res); 
                        });
                    },
                    error:function(res){
                        console.log('Error: '+res);
                    }
                });
            }else {
                alert ("Por favor Ingrese el nombre de la nueva Sede");
            }	
        }
        
        if(pasaAccion==3){//Para eliminar la sede   
            alertify.defaults.transition = "flipy";
            alertify.defaults.theme.ok = "btn btn-primary";
            alertify.defaults.theme.cancel = "btn btn-danger";
            alertify.defaults.theme.input = "form-control";
            
            alertify.confirm(
                '<div class="panel-heading" style="background-color:#902015;color:#fff;"><i class="fa fa-times-circle"> Eliminar Sedes</i></div>', 
                'Señor usuario tenga encuenta esta advertencia, recuerde que al eliminar la sede de la institución se eliminaran todos los datos relacionados a la mismo.', 
                function()
                {                                      
                    $.ajax({
                        type: 'POST',
                        url: "Controladores/ctrlSedes.php",
                        data: {accion:"eliminarSede",codigo:ide},
                        beforeSend: function(){
                           $('#bloquear').slideDown('fast');
                        },
                        success: function(data){                
                            $('#listaSedes').load("vistas/datosSedes/listadoSedes.php",{accion:"cargar"});
                            alertify.success(data);
                            $("#bloquear").slideUp("fast");
                        },
                        error: function(data){
                            console.log('Error: '+data);                            
                        }
                    });
                }, 
                function(){ }
            ).set('closable', false);
        }
        
        //Para configurar los datos correspondiente a los grados areas y cursos de la sede seleccionada
        if(pasaAccion == 4){
            $.ajax({
                type: 'POST',
                url: "vistas/configSedes.php",
                data: {sede:ide},
                beforeSend: function(){
                   $('#bloquear').slideDown('fast');
                },
                complete:function(data){
                    console.log('Terminó el envío');
                },
                success: function(data){                
                    $('#modulo').html(data);
                    $("#bloquear").slideUp("fast");
                },
                error: function(data){
                    console.log('Error: '+data);
                    
                }
            });
        }
    }
}

function cancelar(){
    var y=$(document).ready(function(e) {
        //$('#capa').css('display','none');
        $("#capa").slideUp("fast");
    })
}

function parametros(){
    var institucion= document.getElementById('OcultoInst').value;
	$("#bloquear").slideDown("fast");		
    $("#modulo").load('Config/AjustarParametros.php',{Institucion:institucion},function(){
           $("#bloquear").slideUp("fast");
    });
}

//******--- Eventos relacionados con los estudiantes ---*****//---------------------------------------->>>>>>>>>>>>>>>>>>>

function ventanaModalEditar(){
    var texto = "Listo";
    var color = "#70BB5E";
    swal({
      width: 1100,
      html:'<div id="flotante"></div>',
      showCloseButton: true,
      showCancelButton: true,
      showConfirmButton:false,
      confirmButtonText: texto,
      confirmButtonColor: color,
      focusConfirm: false,
      allowOutsideClick: false,
      preConfirm: cargarLista()
    });
}

function ventanaModalEditarBusqueda(dato){
    var texto = "Listo";
    var color = "#70BB5E";
    swal({
      width: 1100,
      html:'<div id="flotante"></div>',
      showCloseButton: true,
      showCancelButton: true,
      showConfirmButton:false,
      confirmButtonText: texto,
      confirmButtonColor: color,
      focusConfirm: false,
      allowOutsideClick: false,
      preConfirm: buscarEstudiante(dato)
    });
}

function ventanaModalNuevo(){
    swal({
      width: 1100,
      html:'<div id="flotante2"></div>',
      showCloseButton: false,
      showCancelButton: false,
      showConfirmButton:false,
      focusConfirm: false,
      allowOutsideClick: false,
      preConfirm: cargarLista()
    });
}

function buscarEstudiante(dato){
    if(dato != "search"){      
        var institucion=document.getElementById('OcultoInst').value;
        $("#modulo").load('class/buscar.php',{Institucion:institucion,dato:dato});  
    }else{
        dato = document.getElementById("buscarEst").value;
        var institucion=document.getElementById('OcultoInst').value;
        $("#modulo").load('class/buscar.php',{Institucion:institucion,dato:dato});  
    }
}
     
function editarEstudiante(modulo,id,idMatricula){ 
    
    var sede = $("#sede").val();
    var anho = $("#anho").val();
    var curso = $("#curso").val();
    var accion = "Editar";
    $('#cargasFormulario').load('vistas/formularioEstudiante.php',{
        accion : accion,
        Documento: id,
        idMatricula: idMatricula,                        
        sede: sede,
        curso: curso,
        anho: anho
    }); 
}//ok

      
function editarMatricula(idMatricula){ 
    
    $.ajax({
       type: "POST",
       url: "Controladores/ctrlEstudiantes.php",
       data: {accion:"loadMatricula", idMatricula:idMatricula},
       success: function(data){
            datos = JSON.parse(data);
            $('#anhoMatricula').val(datos[0].anho);
            $('#sedeMatricula').val(datos[0].codsede);
            $('#cursoMatricula').val(datos[0].Curso);
            $('#fechaIngreso').val(datos[0].fechaIngreso);
            $('#estado').val(datos[0].estado);
            $('#txtRetiro').val(datos[0].MotivoDeRetiro);
            $('#fechaRetiro ').val(datos[0].fechaRetiro);
            $('#nombreAcudiente').val(datos[0].NombreAcudiente);
            $('#barrioAcudiente').val(datos[0].barrioAcudiente);
            $('#direccionAcudiente').val(datos[0].direccionAcudiente);
            $('#celAcudiente').val(datos[0].celAcudiente);
            $('#correoAcudiente').val(datos[0].correoAcudiente);
            $("#btnMatricula").attr('onclick',"modificarMatricula('"+idMatricula+"')");
            $("#btnMatricula").html("Guardar");
            
       },
       error: function(err){
           console.log("Error al cargar la matricula"+err);
       }
    });
}

function modificarMatricula(idMatricula){
    var anhoMatricula       = $('#anhoMatricula').val();
    var sedeMatricula       = $('#sedeMatricula').val();
    var cursoMatricula      = $('#cursoMatricula').val();
    var fechaIngreso        = $('#fechaIngreso').val();
    var estado              = $('#estado').val();
    var txtRetiro           = $('#txtRetiro').val();
    var fechaRetiro         = $('#fechaRetiro ').val();
    var nombreAcudiente     = $('#nombreAcudiente').val();
    var barrioAcudiente     = $('#barrioAcudiente').val();
    var direccionAcudiente  = $('#direccionAcudiente').val();
    var celAcudiente        = $('#celAcudiente').val();
    var correoAcudiente     = $('#correoAcudiente').val();
    $.ajax({
       type: "POST",
       url:"Controladores/ctrlEstudiantes.php",
       data: {accion: "setMatricula",
            idMatricula : idMatricula,
            anhoMatricula : anhoMatricula,
            sedeMatricula : sedeMatricula,
            cursoMatricula : cursoMatricula,
            fechaIngreso : fechaIngreso,
            estado : estado,
            txtRetiro : txtRetiro,
            fechaRetiro : fechaRetiro,
            nombreAcudiente : nombreAcudiente,
            barrioAcudiente : barrioAcudiente,
            direccionAcudiente : direccionAcudiente,
            celAcudiente : celAcudiente,
            correoAcudiente : correoAcudiente
       },
       success: function(data){
           data = JSON.parse(data);
           if(data["estado"]== 1){
                alertify.success(data["mensaje"]);
           }else{
               alertify.success(data["mensaje"]);
           }
       },
       error: function(err){
           console.log("Error al modificar matricula: "+err);
       }
    });      
}

function cargarCursosMatricula(sede){
    $("#cursoMatricula").html("");
    $("#cursoMatricula").append("<option value=''>Seleccione...</option>");
    $.ajax({
        type: 'POST',
        url: "Controladores/ctrlSedes.php",
        data: {accion:"cargarCursos", sede:sede},
        dataType: 'json',
        success: function(response){
            $.each(response, function(index, item) {
                $("#cursoMatricula").append("<option value='"+item.codCurso+"'>"+item.CODGRADO+"° "+item.grupo+"</option>");                
            });
        },
        error: function(data){
            alertify.error("error","Error al cargar los curso de la sede seleccionada");
        }
    });
}

function cargarCursos(sede){
    $("#curso").html("");
    $("#curso").append("<option value=''>Seleccione...</option>");
    // var accion='cargarCursos';
    // var profe='Todos';
    $.ajax({
        type: 'POST',
        url: "Controladores/ctrlSedes.php",
        data: {accion:"cargarCursos", sede:sede},
        dataType: 'json',
        success: function(response){
            //console.log(response);
            $.each(response, function(index, item) {
                if(item.CODGRADO <=0 ){
                    $("#curso").append("<option value='"+item.codCurso+"'>"+item.NOMGRADO+"</option>");
                }else{
                    $("#curso").append("<option value='"+item.codCurso+"'>"+item.CODGRADO+"° "+item.grupo+"</option>");                
                }
            });
        },
        error: function(data){
            alertify.error("error","Error al cargar los curso de la sede seleccionada");
        }
    });
}

function listarCursosSede(){
    var sede = $("#sede").val();
    $.ajax({
        type: 'POST',
        url: "vistas/datosSedes/listaCursos.php",
        data: {accion:"cargarCursos", sede:sede},
        success: function(response){
            $("#listaGradosAsoc").html(response);
        },
        error: function(data){
            alertify.error("error","Error al cargar los curso de la sede seleccionada");
        }
    });
}

    
function cambioDeJornada(curso,jornada){
    var accion  = "cambiarJornada";
    $.ajax({
        type    : "POST",
        url     : "Controladores/ctrlSedes.php",
        data    : {accion: accion, curso:curso, jornada:jornada},
        beforeSend : function(){            
            $('#bloquear').slideDown('fast');
        },
        success : function(data){
            $('#bloquear').slideUp('fast');
        },
        error: function(response){
            console.log('Error: '+response);
        }
    });
}

function agregarCurso(sede){
    if (sede == "") {
        sede = $("#sedeBol").val();
    }
    var accion  = 'agregarCurso'; 
    var grado   = $("#newGrado").val();
    var grupo   = $("#newGrupo").val();
    var jornada = $("#jorNueva").val();
    $.ajax({
        type    : "POST",
        url     : "Controladores/ctrlSedes.php",
        data    : {accion: accion, sede:sede, grado : grado, grupo:grupo, jornada:jornada},
        beforeSend : function(){            
            $('#bloquear').slideDown('fast');
        },
        success : function(data){
            alertify.success(data);
            $('#bloquear').slideUp('fast');
            listarCursosSede();
        },
        error: function(response){
            console.log('Error: '+response);
        }
    });
}

function eliminarCurso(curso){
    alertify.defaults.transition = "flipy";
    alertify.defaults.theme.ok = "btn btn-primary";
    alertify.defaults.theme.cancel = "btn btn-danger";
    alertify.defaults.theme.input = "form-control";
    alertify.confirm(
        '<div class="panel-heading" style="background-color:#902015;color:#fff;"><i class="fa fa-times-circle"> Eliminar Curso</i></div>', 
        'Para continuar con la eliminación del curso presione el botón OK, recuerde que se eliminaran todos los datos relacionados al mismo.', 
        function()
        {             
            var accion='eliminarCurso'; 
            $.ajax({
                type : "POST",
                url     : "Controladores/ctrlSedes.php",
                data    : {accion : accion, curso : curso},
                beforeSend : function(){            
                    $('#bloquear').slideDown('fast');
                },
                success : function(data){
                    alertify.success(data);
                    $('#bloquear').slideUp('fast');
                    listarCursosSede();
                },
                error : function(response){
                    console.log("Error: "+response);
                }
            }); 
        }, 
        function() { }
    ).set('closable', false);
}//ok

function cargarPensumSede(){
    var sede = $("#sede").val();
    var anho = $("#anho").val();
    $.ajax({
        type: 'POST',
        url: "vistas/datosSedes/areasIH.php",
        data: {accion:"cargarPensum", sede:sede, anho:anho},
        success: function(response){
            $("#datosIH").html(response);
        },
        error: function(data){
            alertify.error("error","Error al cargar los curso de la sede seleccionada");
        }
    });
}


function quitarMensaje(){
    $('#mensajeCurso').text("");
    $('#mensajeCurso').html("<div class='alert alert-success alert-dismissable' id='mensajeExito'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Listo, El estudiante cambió de curso exitosamente</div>");
    $('#mensajeCurso').fadeOut(3000);
}

function cargarNuevoEstudiante(){
    var sede=document.getElementById('sede').value;
    var anho = document.getElementById('anho').value;
    var curso = document.getElementById('curso').value;
    
    $('#cargasFormulario').load('vistas/formularioEstudiante.php',{sede:sede, anho:anho, curso:curso });
}

function previsualizarFotoEst(input) {    
    var archivo = document.getElementById("foto").files;
    var tamanho=archivo[0].size;
    var tipo=archivo[0].type;
    var nombre=archivo[0].name;
    if(tamanho>1024*1024){
        alertify.error("El archivo supera el limite del tamaño máximo permitido de 1Mb");
        $('#fotoUs').attr('src', 'IMAGENES/Usuarios/silueta.jpg');
        archivo.wrap('<form>').closest('formProfe').get(0).reset();
        archivo.unwrap();
    }else if(tipo!="image/jpg" && tipo!="image/jpeg" && tipo!="image/png" ){
        alertify.error("Este tipo de archivo no es permitido");
         archivo.wrap('<form>').closest('formProfe').get(0).reset();
         archivo.unwrap();
        $('#fotoUs').attr('src', 'IMAGENES/Usuarios/silueta.jpg');
    }else{
       if (input.files && input.files[0]) {
            var reader = new FileReader();            
            reader.onload = function (e) {
                $('#fotoUs').attr('src', e.target.result);
                $('#guardarIMG').fadeIn();
            }            
            reader.readAsDataURL(input.files[0]);
        } 
    }    
}

function agregarEstudiante(){    
    var foto = $('#foto').prop('files')[0];          
    var formData = new FormData();
    formData.append('accion','agregarEstudiante');
    formData.append('foto',foto);
    formData.append('usuario',$("#usuario").val());
    formData.append('contrasena',$("#contrasena").val());
    formData.append('num_interno',$("#num_interno").val());
    formData.append('tipoDocumento',$("#tipoDocumento").val()); 
    formData.append('documento',$("#documento").val());
    formData.append('primerNombre',$("#primerNombre").val());
    formData.append('segundoNombre',$("#segundoNombre").val());
    formData.append('primerApellido',$("#primerApellido").val());
    formData.append('segundoApellido',$("#segundoApellido").val());
    formData.append('fechaNacimiento',$("#fechaNacimiento").val());
    formData.append('sexo',$("#sexo").val());
    formData.append('sede',$("#sedeMatricula").val());
    formData.append('documento',$("#documento").val());
    formData.append('cursoMatricula',$("#cursoMatricula").val());
    formData.append('fechaIngreso',$("#fechaIngreso").val());
    formData.append('nombreAcudiente',$("#nombreAcudiente").val());
    formData.append('barrioAcudiente',$("#barrioAcudiente").val());
    formData.append('direccionAcudiente',$("#direccionAcudiente").val());
    formData.append('celAcudiente',$("#celAcudiente").val());
    formData.append('correoAcudiente',$("#correoAcudiente").val());
    formData.append('anho',$("#anhoMatricula").val());
    formData.append('correo',$("#correo").val());
    
    $.ajax({
            type: 'POST',
            url: "Controladores/ctrlEstudiantes.php",
            data:  formData,                        
            processData:false,
            cache:false,
            contentType: false,
            success: function(data){                
                //$("#pruebaGuardado").html(data);
                alertify.success(data); 
                cargarLista(2);
            },
            error: function(data){
                console.log('Error: '+data);
            }
        });
    return false;
}


function modificarEstudiante(){
    var foto = $('#foto').prop('files')[0];          
    var formData = new FormData();
    formData.append('accion','modificar');
    formData.append('documentoAnterior',$("#documentoAnterior").val());
    formData.append('foto',foto);
    formData.append('usuario',$("#usuario").val());
    formData.append('contrasena',$("#contrasena").val());
    formData.append('num_interno',$("#num_interno").val());
    formData.append('tipoDocumento',$("#tipoDocumento").val()); 
    formData.append('documento',$("#documento").val());
    formData.append('primerNombre',$("#primerNombre").val());
    formData.append('segundoNombre',$("#segundoNombre").val());
    formData.append('primerApellido',$("#primerApellido").val());
    formData.append('segundoApellido',$("#segundoApellido").val());
    formData.append('fechaNacimiento',$("#fechaNacimiento").val());
    formData.append('sexo',$("#sexo").val());
    formData.append('sede',$("#newSede").val());
    formData.append('documento',$("#documento").val());
    formData.append('cursoMatricula',$("#cursoMatricula").val());
    formData.append('fechaIngreso',$("#fechaIngreso").val());
    formData.append('nombreAcudiente',$("#nombreAcudiente").val());
    formData.append('barrioAcudiente',$("#barrioAcudiente").val());
    formData.append('direccionAcudiente',$("#direccionAcudiente").val());
    formData.append('celAcudiente',$("#celAcudiente").val());
    formData.append('correoAcudiente',$("#correoAcudiente").val());
    formData.append('anho',$("#anho").val());
    formData.append('correo',$("#correo").val());
    
    $.ajax({
            type: 'POST',
            url: "Controladores/ctrlEstudiantes.php",
            data:  formData,                        
            processData:false,
            cache:false,
            contentType: false,
            success: function(data){                
                //$("#pruebaGuardado").html(data);
                alertify.success(data); 
                cargarLista(2);
            },
            error: function(data){
                console.log('Error: '+data);
            }
        });
    return false;       
}//ok

function eliminarEstudiante(Documento,idMatricula){
    alertify.defaults.transition = "flipy";
    alertify.defaults.theme.ok = "btn btn-primary";
    alertify.defaults.theme.cancel = "btn btn-danger";
    alertify.defaults.theme.input = "form-control";
    alertify.confirm(
        '<div class="panel-heading" style="background-color:#902015;color:#fff;"><i class="fa fa-times-circle"> Eliminar Estudiante</i></div>', 
        'Señor usuario tenga encuenta esta advertencia, Para eliminar los datos del Estudiante presione el botón OK, recuerde que al eliminar al estudiante de la institución se eliminaran todos los datos relacionados al mismo.', 
        function()
        { 
            var sede    = $('#sedeBol').val(); 
            var curso   = $('#cursoBol').val();
            var anho    = $('#anho').val();
            var accion  = 'eliminar'; 
            $.ajax({
                type: 'POST',
                url : 'Controladores/ctrlEstudiantes.php',
                beforeSend: function(){ bloquear(); },
                data : {
                    accion    : accion,
                    documento : Documento,
                    idMatricula : idMatricula
                },
                success: function(data){
                    cargarLista(2);
                    desBloquear();
                    alertify.success(data);
                },
                error: function(res){
                    console.log('test: '+res);
                }
            }); 
        }, function(){  /*alertify.error('Cancel') */ }
    ).set('closable', false);
}//ok

function restaurarEstudiante(idMatricula){
    alertify.defaults.transition = "flipy";
    alertify.defaults.theme.ok = "btn btn-primary";
    alertify.defaults.theme.cancel = "btn btn-danger";
    alertify.defaults.theme.input = "form-control";
    alertify.confirm(
        '<div class="panel-heading" style="background-color:#164EC1;color:#fff;"><i class="fa fa-info-circle"> Restaurar Estudiante</i></div>', 
        'Para restaurar los datos del Estudiante precione el botón OK.', 
        function()
        {             
            var accion  = 'restaurarEstudiante'; 
            $.ajax({
                type: 'POST',
                url : 'Controladores/ctrlEstudiantes.php',
                beforeSend: function(){ bloquear(); },
                data : {
                    accion    : accion,
                    idMatricula : idMatricula
                },
                success: function(data){
                    cargarLista(2);
                    desBloquear();
                    alertify.success(data);
                },
                error: function(res){
                    console.log('test: '+res);
                }
            });
        }, 
        function()
        { 
            //alertify.error('Cancel')
        }
    ).set('closable', false);
}//ok

function cargarResumen(sede,anho){
    $("#resumenEst").load("vistas/datosSedes/resumenCursos.php",{accion:"CargarResumen",sede:sede,anho:anho});
}

//*****-- Eventos relacionados con los profesores ---*****//---------------------------------------->>>>>>>>>>>>>>>>>>>
    
    function editarProfesor(modulo,id){
        var sede = $("#sede").val();
        var accion="editarProfesor";
        $('#cargasFormulario').load('vistas/datosSedes/editProfe.php',{
            profesorID: id, 
            accion: accion,
            sede:sede
        }); 
        //alertify.alert("Los datos pasados son: Id "+id+" modulo: "+modulo);
    }
    
    function cargarNuevoProfe(){
        var sede=document.getElementById('sede').value;
        var accion="cargarNuevoProfe";

        $('#cargasFormulario').load('vistas/datosSedes/editProfe.php',{
            sede:sede,
            accion:accion
        }); 
    }

    function agregarCursoProfe(id,valor){
        var largo=(id.length)-3;
        var clave=id.substr(3,largo);        
        var accion='agregarCursoProfe'; 
        var letra=id.substr(0,3);
        $('#resultadoAct').load('Config/ajustesSedes.php',{accion:accion,clave:clave,valor:valor});
    }
    
    function cambiarCursoProfe(id,valor){
        var largo=(id.length)-3;
        var clave=id.substr(3,largo);        
        var accion='modificarCursoProfe'; 
        var letra=id.substr(0,3);
        $('#resultadoAct').load('Config/ajustesSedes.php',{accion:accion,clave:clave,valor:valor}); 
    }
    
    //Funcion para previsualizar las fotos de los profesores -- codigo tomado de http://jsfiddle.net/LvsYc/-  Adaptado por mi//
    function previsualizar(input) {
        
        var archivo = document.getElementById("foto").files;
        var tamanho=archivo[0].size;
        var tipo=archivo[0].type;
        var nombre=archivo[0].name;
        if(tamanho>1024*1024){
            alertify.error("El archivo supera el limite del tamaño máximo permitido de 1Mb");
            $('#fotoUs').attr('src', 'vistas/img/Usuarios/silueta.jpg');
            archivo.wrap('<form>').closest('formFoto').get(0).reset();
            archivo.unwrap();
        }else if(tipo!="image/jpg" && tipo!="image/jpeg" && tipo!="image/png" ){
            $('#fotoUs').attr('src', 'vistas/img/Usuarios/silueta.jpg');
            alertify.error("Este tipo de archivo no es permitido");
            archivo.wrap('<form>').closest('formFoto').get(0).reset();
            archivo.unwrap();
        }else{
           if (input.files && input.files[0]) {
                var reader = new FileReader();            
                reader.onload = function (e) {
                    $('#fotoUs').attr('src', e.target.result);
                    $('#guardarIMG').fadeIn();
                }            
                reader.readAsDataURL(input.files[0]);
            } 
        }        
    }
    
    function cambiarFotoUsuario(rol){         
        var foto = $('#foto').prop('files')[0];          
        var formData = new FormData();
        var usuario = $("#usuario").val();
        var fotoAnterior = $("#fotoAnterior").val();
        formData.append('foto',foto);
        formData.append('usuario',usuario);
        formData.append('rol',rol);   
        formData.append('fotoAnterior',fotoAnterior);       
        $.ajax({
            type: 'POST',
            url: "Controladores/ctrlFotos.php",
            data:  formData,                        
            processData:false,
            cache:false,
            contentType: false,
            beforeSend: function(){                            
                $('#bloquear').slideDown('fast');
            },
            success: function(data){ 
                $("#fotoAnterior").val("");
                alertify.success("Se cambió la imagen con éxito"); 
                $('#bloquear').slideUp('fast');
                $("#fotoAnterior").val(data);
            },
            error: function(data){
                console.log('Error: '+data);
            }
        });
        return false;
    }
    
    function eliminarProfesor(documento){  
        alertify.defaults.transition = "flipy";
        alertify.defaults.theme.ok = "btn btn-primary";
        alertify.defaults.theme.cancel = "btn btn-danger";
        alertify.defaults.theme.input = "form-control";
        alertify.confirm(
            '<div class="panel-heading" style="background-color:#902015;color:#fff;"><i class="fa fa-times-circle"> Eliminar Profesor</i></div>', 
            'Señor usuario tenga encuenta esta advertencia, recuerde que al eliminar al profesor de la institución se eliminaran todos los datos relacionados al mismo.', 
            function()
            { 
                var sede    =   $("#sede").val(); 
                var accion  =   "eliminar"; 
                $.ajax({
                    type : "POST",
                    url  : "Controladores/ctrlProfesores.php",
                    data : {accion:accion, sede:sede, documento:documento },
                    beforeSend : function(){
                        $('#bloquear').slideDown('fast');
                    },
                    success : function(data){
                        cargarDatosDocentes();                            
                        alertify.success(data); 
                        $('#bloquear').slideUp('fast');
                    },
                    error : function(response){
                        console.log("Error: "+response);
                    }
                });
            }, 
            function(){ }
        ).set('closable', false);
    }
    
    function buscarUsuario(tabla,id){
        var accion='BuscarUsuario';
        //document.getElementById('mostrarMensaje1').style.display = 'block';
        $("#mostrarMensaje1").load('Config/ajustesSedes.php',{accion:accion,tabla:tabla,idUsuario:id},function(){
            
        });
    }
    
    function Mostrarcurso(valor){
        //alertify.success("se desea mostrar? "+valor);
        if(valor=='SI'){
            $("#cursoOculto").fadeIn();
        }else if(valor=='NO'){
            $("#cursoOculto").hide();
        }
        
    }
    
    function quitarDirCurso(profesor,curso){
        var sede=document.getElementById("sedeBol").value;
        var accion='quitarDirCurso';
        //alertify.alert("Los valores son id= "+id);
        $("#"+curso+profesor).load('Config/ajustesSedes.php',{accion:accion,sede:sede,profesor:profesor,idCurso:curso},function(){
            alertify.success("Se quitó el curso al profesor");
        });
    }
    
    function ponerDirCurso(profesor,curso){
        var accion='ponerDirCurso';
        //alertify.alert("Los valores son id= "+id);
        $("#"+curso+profesor).load('Config/ajustesSedes.php',{accion:accion,profesor:profesor,idCurso:curso},function(){
            alertify.success("Se agregó el curso al profesor");
        });
    }

    function cargarListaProfesores(){
        // var inst = document.getElementById('OcultoInst').value;
        var sede = document.getElementById('sede').value;
        var accion='cargarListaProfe';
        //alertify.success("La sede es: "+curso);
        $("#listadoProfesoresSede").load("vistas/datosSedes/listadoProfesores.php",
          {
            accion:accion
          },function(){
            alertify.success("Cargado con éxito");
        });
        return false;
    }//ok   

    function cargarMatriz(){
        var sede = document.getElementById('sede').value;
        var anho = document.getElementById('anho').value;        
        var accion="cargarMatriz";
        $("#cargaAcademica").load("Controladores/ctrlCargaAcademica.php",{accion:accion, sede:sede, anho:anho});
    }

    function cargarDatosDocentes(){        
        var sede    = $("#sede").val();
        var accion  = 'cargarListaProfe';
        $("#listadoProfesoresSede").load("vistas/datosSedes/listadoProfesores.php",
          {
            accion:accion,
            sede:sede
          },function(){
            alertify.success("Cargado con éxito");
            $("#listadoProfe").dataTable();
        });

        return false;
    }


    function verCargaAcademicaProfesor(modulo, id){
        var anho = $("#anho").val();
        
        $.ajax({
            url: 'Controladores/ctrlCargaAcademica.php',
            type: 'POST',
            data:{accion: "verCargaAcademicaProfesor", idProfesor: id,  anho:anho},
            success: function(res){
                 $("#cargasFormulario").html(res);
            },
            error: function(err){
                console.log("Error: "+err);
            }
        }); 
    }

    function bloquear(){
        $('#bloquear').slideDown('fast');
    }
    function desBloquear(){
        $('#bloquear').slideUp('fast');
    }

    function imprimirParte(parte){
	  var ficha = document.getElementById(parte);
	  var ventimp = window.open(' ', 'popimpr');
	  ventimp.document.write( ficha.innerHTML );
	  ventimp.document.close();
	  ventimp.print( );
	  ventimp.close();
    }
function nuevaMatricula(modulo,id,anho,sede){ 
    //alertify.alert("esta en la funcion nuevaMatricula (Modulo: "+modulo +" Id: "+id +" Año: "+ anho+" Sede: "+sede+" Inst: "+inst+") del archivo administrarAcciones.js");
    
    var accion="Nueva";
    // if(modulo == 2){      
    //     ventanaModalEditar();  
    // }else if(modulo == 3){
    //     ventanaModalEditarBusqueda(id);
    // }
    $('#cargasFormulario').load('vistas/datosSedes/datosMatricula.php',{
        Documento:id,                        
        sede:sede,
        anho:anho,
        accion:accion
    }); 
}//ok

function cargarCursosMat(sede){
    var accion='listadoCursos';
    var profe='Todos';
    $("#cursosMat").load("Config/ajustesSedes.php",{sede:sede,usuario:profe,accion:accion});        
}

function addMatricula(estudiante){
    var sede    = $("#sedeMatricula").val();
    var documento   = $("#documento").val();
    var cursoMatricula  = $("#cursoMatricula").val();
    var fechaIngreso    = $("#fechaIngreso").val();
    var nombreAcudiente = $("#nombreAcudiente").val();
    var barrioAcudiente = $("#barrioAcudiente").val();
    var direccionAcudiente  = $("#direccionAcudiente").val();
    var celAcudiente    = $("#celAcudiente").val();
    var correoAcudiente = $("#correoAcudiente").val();
    var anho    = $("#anhoMatricula").val();
    var accion = "addMatricula";
     $.ajax({
        type: 'POST',
        url: "Controladores/ctrlEstudiantes.php",
        data: {
            sede    : sede,
            documento   : estudiante,
            cursoMatricula  : cursoMatricula,
            fechaIngreso    : fechaIngreso,
            nombreAcudiente : nombreAcudiente,
            barrioAcudiente : barrioAcudiente,
            direccionAcudiente  : direccionAcudiente,
            celAcudiente    : celAcudiente,
            correoAcudiente : correoAcudiente,
            anho    : anho,
            accion  : accion
        },
        beforeSend: function(){
            $('#bloquear').slideDown('fast');
        },
        complete:function(data){
            //console.log('Terminó el envío');
        },
        success: function(data){                
            alertify.success(data);
            console.log('test agregar matricula: '+data);
            $("#listadoMatriculas").load("vistas/datosSedes/listadoMatriculasEstudiante.php",{Documento:estudiante});
            $("#bloquear").slideUp("fast");
        },
        error: function(data){
            console.log('Error: '+data);

        }
    });
}

function eliminarMatricula(idMatricula,documento){
    alertify.defaults.transition = "flipy";
    alertify.defaults.theme.ok = "btn btn-primary";
    alertify.defaults.theme.cancel = "btn btn-danger";
    alertify.defaults.theme.input = "form-control";
    alertify.confirm(
        '<div class="panel-heading" style="background-color:#902015;color:#fff;"><i class="fa fa-times-circle"> Eliminar Matricula '+idMatricula+'</i></div>', 
        'Señor usuario tenga encuenta esta advertencia, Para eliminar los datos del Estudiante precione el botón OK, recuerde que al eliminar al estudiante de la institución se eliminaran todos los datos relacionados al mismo.', 
        function()
        { 
            $.ajax({
                type: 'POST',
                url: "Controladores/ctrlEstudiantes.php",
                data: {accion:"eliminarMatricula", idMatricula:idMatricula},
                success: function(data){                
                    alertify.success(data);
                    $("#listadoMatriculas").load("vistas/datosSedes/listadoMatriculasEstudiante.php",{Documento:documento});
                    $("#bloquear").slideUp("fast");
                },
                error: function(data){
                    console.log('Error: '+data);

                }
            });
        }, 
        function()
        { 
            //alertify.error('Cancel')
        }
    ).set('closable', false);
}

function retirar(idMatricula){
    let Documento = $("#documento").val();
    let fechaRetiro = $("#fechaRetiro").val();
    let MotivoDeRetiro = $("#txtRetiro").val();
    $.ajax({
        type : 'POST',
        url  : 'Controladores/ctrlEstudiantes.php',
        beforeSend : function(){
            $("#progreso").fadeIn("fast");
        },
        data:{
            accion : "retirar", 
            idMatricula : idMatricula,
            fechaRetiro : fechaRetiro, 
            MotivoDeRetiro : MotivoDeRetiro
        },
        success: function(data){
            console.log('test retirar estudiante: '+data);
            $("#progreso").fadeOut("fast");
            $("#progreso").html(data);
            $("#listadoMatriculas").load("vistas/datosSedes/listadoMatriculasEstudiante.php",{Documento:Documento})
        },
        error : function(res){

        }
    })
}

function razonesdeRetiro(id,valor){
    if(valor=='Retirado'){
        $('#motivosRetiro').fadeIn("fast");
        //$('#motivosRetiro').display=block;
    }else{
        $('#txtRetiro').val("");
        $('#fechaRetiro').val("");
        $('#motivosRetiro').fadeOut('fast');
    }
}//ok

function actualizarPerfilProfesor(){
    $.ajax({
        type: 'POST',
        url: "Controladores/ctrlProfesores.php?accion=actualizarPerfilProfesor",
        data:$("#formPerfil").serialize(),
        beforeSend: function(){
            $('#bloquear').slideDown('fast');
        },
        success: function(data){
            //$("#resultado").html(data);
            $('#bloquear').slideUp('fast');
            alertify.success(data);
        },
        error: function(data){
            alertify.error(data);
            console.log('test: '+data);
            $('#bloquear').slideUp('fast');
        }
    });
    return false;
}

function actualizarProfesor(idAnterior){
    $.ajax({
        type: 'POST',
        url: "Controladores/ctrlProfesores.php?accion=actualizarProfesor&id="+idAnterior,
        data:$("#formularioProfesor").serialize(),
        beforeSend: function(){
            $('#bloquear').slideDown('fast');
        },
        success: function(data){
            //$("#resultado").html(data);
            $('#bloquear').slideUp('fast');
            alertify.success(data);
        },
        error: function(data){
            alertify.error(data);
            console.log('test: '+data);
            $('#bloquear').slideUp('fast');
        }
    });
    return false;
}


function agregarProfesor(){                
    var foto = $('#foto').prop('files')[0];          
    var formData = new FormData();
    formData.append('accion','agregar');
    formData.append('foto',foto);
    formData.append('usuario',$("#usuario").val());
    formData.append('contrasena',$("#contrasena").val());    
    formData.append('color',$("#color").val());
    formData.append('PrimerNombre',$("#PrimerNombre").val());
    formData.append('SegundoNombre',$("#SegundoNombre").val());
    formData.append('PrimerApellido',$("#PrimerApellido").val());
    formData.append('SegundoApellido',$("#SegundoApellido").val());
    formData.append('documento',$("#documento").val());
    formData.append('sexo',$("#sexo").val());
    formData.append('fechaNacimiento',$("#fechaNacimiento").val());
    formData.append('correo',$("#correo").val());
    formData.append('barrio',$("#barrio").val());
    formData.append('direccion',$("#direccion").val());
    formData.append('telefono',$("#telefono").val());
    formData.append('estudios',$("#estudios").val());
    formData.append('enfasis',$("#enfasis").val());
    formData.append('escalafon',$("#escalafon").val());
    formData.append('sede',$("#sede").val());    
    $.ajax({
        type: 'POST',
        url: "Controladores/ctrlProfesores.php",
        data:  formData,                        
        processData:false,
        cache:false,
        contentType: false,
        success: function(data){                
            //$("#resultado").html(data);
            alertify.success(data); 
        },
        error: function(data){
            console.log('Error: '+data);
        }
    });
    return false;
}

function reporteLogros(url){
    $('#bloquear').slideDown('fast');
    $("#modulo").load(url,function(){    $("#bloquear").slideUp("fast"); $("#tablaDatos").dataTable();});
}

function calcular_IHSede(){
    var totalIH = 0;
    $('input[name="horasAxS"]').each(
        function() {
            var valorASumar=$(this).val();
            totalIH += parseInt(valorASumar);
        }
    );
    $("#totalIHxSEDE").val(totalIH);
} 

function agregarAreaxSede(sede){
    var idArea   = $("#txtIdArea").val();
    var nombre = $("#txtNombre").val(); 
    var abreviatura    = $("#txtCod").val();
    var anho    = $('#anho').val(); 
    var accion  = 'agregarArea'; 

    if (idArea != "Ninguna") {
        accion  = 'agregarAsignatura'; 
    }

    $.ajax({
        type: 'POST',
        url: "Controladores/ctrlAreas.php",
        data:  { accion:accion, sede:sede, idArea:idArea, nombre:nombre, abreviatura:abreviatura, anho:anho},        
        beforeSend: function(){
            $('#bloquear').slideDown('fast');
        },
        success: function(data){                
            //$("#resultado").html(data);
            alertify.success(data); 
            $("#datosIH").load("vistas/datosSedes/areasIH.php",
                {accion:accion, sede:sede, anho:anho},function(){
                    $('#bloquear').slideUp('fast');
                }
            );
            $("#txtIdArea").val("Ninguna");
            $("#txtNombre").val(""); 
            $("#txtCod").val("");
        },
        error: function(data){
            console.log('Error: '+data);
        }
    });
}

function modificarIntensidad(idArea, grado, horas, tabla){
  var accion='modificarIntensidad'; 
  $.ajax({
    type: "POST",
    url: 'Controladores/ctrlAreas.php',
    data: {accion:accion, idArea:idArea, grado:grado, horas:horas, tabla:tabla},
    success: function(data){               
      alertify.success(data);
      var totalHoras = 0;
      $("input[name='G"+grado+"']").each(function() {
        totalHoras= parseInt(totalHoras) + parseInt($(this).val());
      });
      $("#totalIH"+grado).val(totalHoras);
    },
    error: function(data){
        console.log('Error: '+data);
    }
  });    
}

function agregarIntensidad(idArea, grado, horas, tabla){
    console.log('test: '+idArea+", "+grado+", "+horas+", "+tabla);
  var accion='agregarIntensidad'; 
  $.ajax({
    type: "POST",
    url: 'Controladores/ctrlAreas.php',
    data: {accion:accion, idArea:idArea, grado:grado, horas:horas, tabla:tabla},
    success: function(data){
      alertify.success(data);
      totalizarHoras(grado);
      $("#"+grado+idArea).attr('onchange','');
      $("#"+grado+idArea).attr('onchange','modificarIntensidad('+idArea+','+grado+',this.value,'+tabla+')');
    },
    error: function(data){
        console.log('Error: '+data);
    }
  });    
}
    
function modificarTipoPromedio(idArea, tipo){
  var accion = 'modificarTipoPromedio'; 
  var anho = $("#anho").val();
  
  $.ajax({
    type: "POST",
    url: 'Controladores/ctrlAreas.php',
    data: {accion:accion, idArea:idArea, tipo:tipo, anho:anho },
    success: function(data){               
      alertify.success(data);  
      if (tipo == "Porcentaje") {
          $(".porcentaje"+idArea).fadeIn();
      } else{
        $(".porcentaje"+idArea).fadeOut();
      }      
    },
    error: function(data){
        console.log('Error: '+data);
    }
  });    
}
    
function modificaAreaS(id,campo){ 
    //alert("Campo: "+campo+" Clave: "+id);
    //var abr=id;
    if(campo == 'FPRO'){
      campo = 'formaDePromediar';
      var largo = (id.length)-4;
      var clave = id.substr(4,largo);  
      var valor = document.getElementById(''+id).value;
      //alertify.alert("Los valores recibidos son: ID: "+id+" Campo: "+campo+" clave resultado de extraer los 3 primeros caráteres es: "+clave+" el valor es: "+valor);
      if(valor == "Porcentaje"){  
        alertify.success("La nota definitiva del área se calculará según el porcentaje de cada asignatura, por favor ingrese el porcentaje.");
        $("input.asignatura"+clave).removeAttr('readonly');
        //$("input.asignatura"+clave).attr('readonly','false');
      }else if(valor == "IH"){  
        alertify.success("La nota definitiva del área se calculará según la Intensidad Horaria de cada asignatura");            
        $("input.asignatura"+clave).attr('readonly','true');
      }else if(valor == "Normal"){  
        alertify.success("La nota definitiva del área se calculará promediando las notas de sus asignaturas.");            
        $("input.asignatura"+clave).attr('readonly','true');
      }
      var accion = 'modificaAreaS'; 
      $('#resultadoAct').load('Config/ajustesSedes.php',
        {accion:accion,campo:campo,clave:clave,valor:valor}
      );
    }else{
      var largo = (id.length)-3;
      var clave = id.substr(3,largo);        
      var ih    = document.getElementById(''+id).value;
      //alertify.alert("Los valores recibidos son: ID: "+id+" Campo: "+campo+" clave resultado de extraer los 3 primeros caáteres es: "+clave+"Valor: "+ih);
      var accion = 'modificaAreaS'; 
      $('#resultadoAct').load('Config/ajustesSedes.php',
        {accion:accion,campo:campo,clave:clave,valor:ih}
      );

      var totalHoras = 0;
      $("input[name='"+campo+"']").each(function() {
          totalHoras= parseInt(totalHoras) + parseInt($(this).val());
      });
      document.getElementById("totalIH"+campo).value=totalHoras;
    }
}
    
function modificaAsignatura(id){
    var accion = 'modificaAsignatura';
    let nombre = $("#nombre"+id).val();
    let abreviatura = $("#abreviatura"+id).val();
    let porcentaje = $("#porcentaje"+id).val();

    $.ajax({
        type: "POST",
        url: 'Controladores/ctrlAreas.php',
        data: {
            accion:accion,
            id:id,
            nombre:nombre,
            abreviatura:abreviatura,
            porcentaje:porcentaje
        },
        success: function(data){               
          alertify.success(data); 
        },
        error: function(data){
            console.log('Error: '+data);
        }
    });
}
    
function  eliminarAreaxSede(idarea, sede, tabla){
  var accion='eliminarAreaAsignatura'; 
  var anho    = $('#anho').val(); 
  var tipo = "Área";
  if (tabla != 1) {
    tipo = "Asignatura";
  }
  alertify.defaults.transition = "flipy";
  alertify.defaults.theme.ok = "btn btn-primary";
  alertify.defaults.theme.cancel = "btn btn-danger";
  alertify.defaults.theme.input = "form-control";
  alertify.confirm(
      '<div class="panel-heading" style="background-color:#902015;color:#fff;"><i class="fa fa-times-circle"> Eliminar '+tipo+'</i></div>', 
      'Señor usuario tenga encuenta esta advertencia, Para eliminar los datos presione el botón OK, recuerde que al eliminarla se eliminaran todos los datos relacionados al mismo.<br> Al confirmar no se podrá deshacer', 
      function()
      { 
        $.ajax({
          type: "POST",
          url: 'Controladores/ctrlAreas.php',
          data: {accion:accion,tabla:tabla,idArea:idarea,anho:anho},
          beforeSend: function(){
            $('#bloquear').slideDown('fast');
          },
          success: function(data){               
              $("#datosIH").load("vistas/datosSedes/areasIH.php",{accion:accion, sede:sede, anho:anho},function(){
                $('#bloquear').slideUp('fast'); 
              });
          },
          error: function(data){
              console.log('Error: '+data);
          }
        });              
      }, 
      function()
      { 
          //alertify.error('Cancel')
      }
  ).set('closable', false); 
}
    
function eliminarAsigxS(id,idarea){
    var sede=document.getElementById('sedeBol').value; 
    var accion='eliminarAxS'; 
    $('#listadoAreasAsigSede').load('Config/ajustesSedes.php',{accion:accion,sede:sede,idAsignatura:id,idArea:idarea});  
}

function totalHorasArea(area,grado){
    let totalHoras = 0;
    $("input[name='Asig"+area+grado+"']").each(function() {
        totalHoras = parseInt(totalHoras) + parseInt($(this).val());
    });
    $("#"+grado+area).val(totalHoras);
    modificarIntensidad(area, grado, totalHoras, 1);
    totalizarHoras(grado);
}

function  totalizarHoras(grado){
    var totalHoras = 0;
    $("input[name='G"+grado+"']").each(function() {
        totalHoras = parseInt(totalHoras) + parseInt($(this).val());
    });
    $("#totalIH"+grado).val(totalHoras);
}


    //******--- Eventos relacionados con la distribucion académica ---*****//
    function guardarDistCursos(){
        var formData = new FormData(document.getElementById("formularioDistCurso"));
        var sede=document.getElementById("sedeBol").value;
        formData.append("accion", "guardarDistCursos"); //Esta línea me sirve para agregar otra variable con su respectivo valor.
        formData.append("sede", sede);
        $.ajax({
                url: "Config/ajustesSedes.php",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            })
            .done(function(res){            
                $("#distCursos").html(res);
        });
    }
    
    function guardarDistAreas(){
        var formData = new FormData(document.getElementById("formularioDistAreas"));
        var sede=document.getElementById("sedeBol").value;
        formData.append("accion", "guardarDistAreas"); //Esta línea me sirve para agregar otra variable con su respectivo valor.
        formData.append("sede", sede);
        $.ajax({
                url: "Config/ajustesSedes.php",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            })
            .done(function(res){            
                $("#distAreas").html(res);
        });
    }
    
    function quitarItemCurso(id){
        var sede=document.getElementById("sedeBol").value;
        var accion='quitarItemCurso';
        //alertify.alert("Los valores son id= "+id);
        $("#distCursos").load('Config/ajustesSedes.php',{accion:accion,sede:sede,idItem:id},function(){
            alertify.success("Se quitó el curso al profesor");
        });
    }
    
    function quitarItemArea(id,tabla){
        var sede=document.getElementById("sedeBol").value;
        var accion='quitarItemArea';
        if(tabla==1){
            tabla="Areas";
        }else if(tabla==2){
            tabla="Asignaturas";
        }
        //alertify.alert("Los valores son id= "+id);
        $("#distAreas").load('Config/ajustesSedes.php',{accion:accion,sede:sede,tabla:tabla,idItem:id},function(){
            alertify.success("Se quitó el área al profesor");
        });
    }    
    

    
    //***** Eventos relacionados con el modulo *************//

    $("#recargar").click(function(){
        var institucion= document.getElementById('OcultoInst').value;
        var sedeBol= document.getElementById('sedeBol').value;  
        $("#modulo").load('vistas/ConfigSedes.php',{Institucion:institucion,Edtabla:sedeBol},function(){
            alertify.success("Recargado");
        });
    });
    $("#acordion2").accordion();
    // $("#dataTables-profesores").dataTable({ responsive: true });
    $('.ventanaFlotante').draggable();
    $('.ventanaFlotante').resizable();
    
    function seleccionar(id,campo){
       $('#'+id).addClass('seleccionado');        
    }
    
    function deseleccionar(id){
       $('#'+id).removeClass('seleccionado');
        var c=document.getElementById(''+id).value;
        //alertify.alert("E valor del cuadro es:-"+c+";");
        if(c==''){
            document.getElementById(''+id).value=0;
        }
    }
    function quitarCero(id){
        var c=document.getElementById(''+id).value;
        //alertify.alert("E valor del cuadro es:-"+c+";");
        if(c==0){
            document.getElementById(''+id).value='';
        }
    }  
    
//Código tomado de http://www.lawebdelprogramador.com/codigo/JavaScript/2380-Calcular-la-edad-desde-una-fecha-dada-en-HTML5.html    
    
/**
 * Funcion que devuelve true o false dependiendo de si la fecha es correcta.
 * Tiene que recibir el dia, mes y año
 */
function isValidDate(day,month,year)
{
    var dteDate;
 
    // En javascript, el mes empieza en la posicion 0 y termina en la 11 
    //   siendo 0 el mes de enero
    // Por esta razon, tenemos que restar 1 al mes
    month=month-1;
    // Establecemos un objeto Data con los valore recibidos
    // Los parametros son: año, mes, dia, hora, minuto y segundos
    // getDate(); devuelve el dia como un entero entre 1 y 31
    // getDay(); devuelve un num del 0 al 6 indicando siel dia es lunes,
    //   martes, miercoles ...
    // getHours(); Devuelve la hora
    // getMinutes(); Devuelve los minutos
    // getMonth(); devuelve el mes como un numero de 0 a 11
    // getTime(); Devuelve el tiempo transcurrido en milisegundos desde el 1
    //   de enero de 1970 hasta el momento definido en el objeto date
    // setTime(); Establece una fecha pasandole en milisegundos el valor de esta.
    // getYear(); devuelve el año
    // getFullYear(); devuelve el año
    dteDate=new Date(year,month,day);
 
    //Devuelva true o false...
    return ((day==dteDate.getDate()) && (month==dteDate.getMonth()) && (year==dteDate.getFullYear()));
}
 
/**
 * Funcion para validar una fecha
 * Tiene que recibir:
 *  La fecha en formato ingles yyyy-mm-dd
 * Devuelve:
 *  true-Fecha correcta
 *  false-Fecha Incorrecta
 */
function validate_fecha(fecha)
{
    var patron=new RegExp("^(19|20)+([0-9]{2})([-])([0-9]{1,2})([-])([0-9]{1,2})$");
 
    if(fecha.search(patron)==0)
    {
        var values=fecha.split("-");
        if(isValidDate(values[2],values[1],values[0]))
        {
            return true;
        }
    }
    return false;
}
 
/**
 * Esta función calcula la edad de una persona y los meses
 * La fecha la tiene que tener el formato yyyy-mm-dd que es
 * metodo que por defecto lo devuelve el <input type="date">
 */
function calcularEdad()
{
    var fecha=document.getElementById("NAC").value;
    if(validate_fecha(fecha)==true)
    {
        // Si la fecha es correcta, calculamos la edad
        var values=fecha.split("-");
        var dia = values[2];
        var mes = values[1];
        var ano = values[0];
 
        // cogemos los valores actuales
        var fecha_hoy = new Date();
        var ahora_ano = fecha_hoy.getYear();
        var ahora_mes = fecha_hoy.getMonth()+1;
        var ahora_dia = fecha_hoy.getDate();
 
        // realizamos el calculo
        var edad = (ahora_ano + 1900) - ano;
        if ( ahora_mes < mes )
        {
            edad--;
        }
        if ((mes == ahora_mes) && (ahora_dia < dia))
        {
            edad--;
        }
        if (edad > 1900)
        {
            edad -= 1900;
        }
 
        // calculamos los meses
        var meses=0;
        if(ahora_mes>mes)
            meses=ahora_mes-mes;
        if(ahora_mes<mes)
            meses=12-(mes-ahora_mes);
        if(ahora_mes==mes && dia>ahora_dia)
            meses=11;
 
        // calculamos los dias
        var dias=0;
        if(ahora_dia>dia)
            dias=ahora_dia-dia;
        if(ahora_dia<dia)
        {
            ultimoDiaMes=new Date(ahora_ano, ahora_mes, 0);
            dias=ultimoDiaMes.getDate()-(dia-ahora_dia);
        }
 
        document.getElementById("edad").value=edad+" años";
    }else{
        document.getElementById("edad").value="La fecha es incorrecta";
    }
}
