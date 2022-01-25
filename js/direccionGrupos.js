// var seleccionados = []; 
// var marcados = []; 
// var profeSel = 0;
// var profeColor = 0;

function cargarMatriz(){ 
    let sede = $("#sede").val(); 
    let anho = $("#anho").val();      
    var accion = "cargarMatriz";
    $('#bloquear').slideDown('fast');
    $("#matrizCarga").load("Controladores/ctrlDireccionGrupos.php",{
        accion:accion,
        sede:sede,
        anho:anho
    },function(){
        $('#bloquear').slideUp('fast');
    });
}

// function seleccionar(clase,id){    
//     var valor = $("#"+id).val();

//     if(valor === '-'){
//         $("#sudoku").find("input."+clase).addClass('roja').removeClass('ap').removeClass('blanco').attr('readonly','true').val("X");
//         $("input.roja").removeAttr('onclick');
//         $("#"+id).val("O").removeClass('roja').removeClass('ap').addClass('verde').removeClass('blanco');

//     }else if(valor === 'O'){        
//         $("#"+id).attr('readonly','false').val("-");
//         $("#sudoku").find("input."+clase).removeClass('roja').addClass('ap').addClass('blanco').attr('readonly','false').val("-").attr("onclick","agregar(this.name,this.id)");

//         //alert("hasta a aqui esta bien");
//     }
//     $("#modulo").css('height','2300px'); 
// }

// function seleccionarCelda(id){    
//     var valor = $("#"+id).val();
//     encontrado = false;
//     htm = '';
//     for (var i = 0; i < seleccionados.length; i++) {
//         if(seleccionados[i] == id){
//             seleccionados.splice(i,i);
//             $("#"+id).removeClass('verde').addClass('blanco');
//             $("#"+id).attr('style','');
//             encontrado = true;
//         }
//         htm += seleccionados[i]+"<br>";
//         $("#pruebas").html(''+htm);
//     }
//     if(!encontrado){            
//         seleccionados.push(id);
//         $("#"+id).addClass('verde').removeClass('blanco');
//     }
// }

// function marcarProfesor(color,idProfe){
//     profeSel = idProfe;
//     profeColor = color;
// }

// $("#btnPrueba").click(function(){
//     asignar();
// });


function asignarDir(curso,profeSel,profeColor){ 
    var profe = profeSel; 
    var celda = "Cel"+curso+profe;
    var accion = 'asignar'; 
    var anho = $("#anho").val();
    //alertify.alert("Datos: Profesor: "+profe+" Curso: "+curso+" Color: "+profeColor+" idCelda: "+celda);
    $.ajax({
        type : "POST",
        url : "Controladores/ctrlDireccionGrupos.php",
        data : {accion : accion, anho : anho, profe : profe, curso : curso},
        beforesend:function(){
            $('#bloquear').slideDown('fast');
        },
        success : function(data){
            $("#"+celda).attr('title',''+profeSel);
            $("#"+celda).attr('style','background-color:'+profeColor);
            $("#"+celda).removeClass('verde').addClass('blanco');
            $("#"+celda).attr('onclick','');
            $("#"+celda).attr("onclick",'quitarDir('+curso+','+profe+',"'+profeColor+'")');
            alertify.success(data);
            $('#bloquear').slideUp('fast');
        },
        error : function(res){
            alertify.error(res);
            $('#bloquear').slideUp('fast');
        }
    });
}

function quitarDir(curso,profe,color){
    let celda = "Cel"+curso+profe;
    var anho = $("#anho").val();

    $.ajax({
        type : "POST",
        url  : "Controladores/ctrlDireccionGrupos.php",
        data : {accion : "quitar", anho : anho, profe : profe, curso : curso},
        success : function(data){
            $("#"+celda).removeClass('verde').addClass('blanco');
            $("#"+celda).attr('style','');
            $("#"+celda).attr('onclick','');
            $("#"+celda).attr("onclick",'asignarDir('+curso+','+profe+',"'+color+'")');
            alertify.success(data);
        },
        error: function(res){
            alertify.error(res);
        }
    });    
}
