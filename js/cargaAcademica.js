var seleccionados = []; 
var marcados = []; 
var profeSel = 0;
var profeColor = 0;

function cargarMatriz(){ 
    var el = seleccionados.length;
    seleccionados.splice(0,el); 
    let sede = $("#sede").val(); 
    let anho = $("#anho").val();      
    var accion = "cargarMatriz";
    //alertify.success("Esta en carga academica.js la accion es: "+accion+"\nel anho es: "+anho+" la sede es: "+sede);
    $('#bloquear').slideDown('fast');
    $("#matrizCarga").load("Controladores/ctrlCargaAcademica.php",{
        accion:accion,
        sede:sede,
        anho:anho
    },function(){
        $('#bloquear').slideUp('fast');
        //$("#sudoku").dataTable();
        swal.close();
    });
}

function seleccionar(clase,id){    
    var valor = $("#"+id).val();

    if(valor === '-'){
        $("#sudoku").find("input."+clase).addClass('roja').removeClass('ap').removeClass('blanco').attr('readonly','true').val("X");
        $("input.roja").removeAttr('onclick');
        $("#"+id).val("O").removeClass('roja').removeClass('ap').addClass('verde').removeClass('blanco');

    }else if(valor === 'O'){        
        $("#"+id).attr('readonly','false').val("-");
        $("#sudoku").find("input."+clase).removeClass('roja').addClass('ap').addClass('blanco').attr('readonly','false').val("-").attr("onclick","agregar(this.name,this.id)");

        //alert("hasta a aqui esta bien");
    }
    $("#modulo").css('height','2300px'); 
}

function seleccionarCelda(id){    
    var valor = $("#"+id).val();
    encontrado = false;
    htm = '';
    for (var i = 0; i < seleccionados.length; i++) {
        if(seleccionados[i] == id){
            seleccionados.splice(i,i);
            $("#"+id).removeClass('verde').addClass('blanco');
            $("#"+id).attr('style','');
            encontrado = true;
        }
        htm += seleccionados[i]+"<br>";
        $("#pruebas").html(''+htm);
    }
    if(!encontrado){            
        seleccionados.push(id);
        $("#"+id).addClass('verde').removeClass('blanco');
    }
}

function marcarProfesor(color,idProfe){
    profeSel = idProfe;
    profeColor = color;
    //$("#pruebas").html('Profe: '+profeSel+" color: "+profeColor);
}

$("#btnPrueba").click(function(){
    asignar();
});

function bloquearVentana(){
     swal({
      width: 200,
      html:'<div id="flotante"><img src="estilosCSS/load.gif" width="150"/></div>',
      showCloseButton: false,
      showCancelButton: false,
      showConfirmButton:false,
      confirmButtonText: "OK",
      confirmButtonColor: "#2A9B18",
      focusConfirm: false,
      allowOutsideClick: false,
    });
}

function asignar(curso,area,asignatura){ 
    var profe = profeSel; 
    var celda = "Cel"+curso+area;
    if (area == 0) {        
        celda = "Cel"+curso+asignatura;
    }
    var accion = 'asignar'; 
    var anho = $("#anho").val();
    //alertify.alert("Datos: Profesor: "+profe+" Curso: "+idCurso+" Area: "+idArea+" idCelda: "+celda+" Tipo: "+tipo);
    if (profe == 0) {
        alertify.warning("HOla Por favor seleccione un profesor para poder realizar la asignación");
    }else{ 
        $.ajax({
            type : "POST",
            url  : "Controladores/ctrlCargaAcademica.php",
            data : {accion:accion, anho : anho, profe : profe, idCurso : curso, idArea : area, idAsignatura : asignatura},
            success : function(response){
                $("#"+celda).attr('title',''+profeSel);
                $("#"+celda).attr('style','background-color:'+profeColor);
                $("#"+celda).removeClass('verde').addClass('blanco');
                $("#"+celda).attr('onclick','');
                $("#"+celda).attr('onclick','quitar('+curso+','+area+','+asignatura+','+profeSel+')');
                alertify.success(response);
            },
            error: function(err){
                console.log('Error: '+err);
            }
        }) ;    
    }
}

function quitar(curso, area, asignatura, profe){
    let celda = "Cel"+curso+area;
    var anho = $("#anho").val();
    if (area == 0) {
        celda = "Cel"+curso+asignatura;
    }

    $.ajax({
        type : "POST",
        url  : "Controladores/ctrlCargaAcademica.php",
        data : {accion:'quitar', anho : anho, profe : profe, idCurso : curso, idArea : area, idAsignatura : asignatura},
        success : function(response){
            $("#"+celda).removeClass('verde').addClass('blanco');
            $("#"+celda).attr('style','');
            $("#"+celda).attr('onclick','');
            $("#"+celda).attr('onclick','asignar('+curso+','+area+','+asignatura+')');
            alertify.success(response);
        },
        error: function(err){
            console.log('Error: '+err);
        }
    }) ; 
    
}

function agregarDirCurso(idProfesor,idCurso){
    //seleccionar(clase,idEspacio);
    bloquearVentana();
    var celda = "dir"+idProfesor+idCurso;
    var accion = "agregarDirCurso"; 
    //alertify.alert("Datos: Profesor: "+idProfesor+" Curso: "+idCurso);
    $("#"+celda).load("Controladores/ctrlCargaAcademica.php",{
        accion : accion,
        idProfesor : idProfesor,
        idCurso : idCurso
    },function(){
        swal.close();
    });
}

function eliminarDirCurso(idProfesor,idCurso){
    //seleccionar(clase,idEspacio);
    bloquearVentana();
    var celda = "dir"+idProfesor+idCurso;
    var accion = "eliminarDirCurso"; 
    //alertify.alert("Datos: Profesor: "+profe+" Curso: "+idCurso+" Area: "+idArea+" idCelda: "+celda+" Tipo: "+tipo);
    $("#"+celda).load("Controladores/ctrlCargaAcademica.php",{
        accion : accion,
        idProfesor : idProfesor,
        idCurso : idCurso
    },function(){
        swal.close();
    });
}


$('.select2').select2();

//iCheck for checkbox and radio inputs
$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
  checkboxClass: 'icheckbox_minimal-blue',
  radioClass   : 'iradio_minimal-blue'
});
//Red color scheme for iCheck
$('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
  checkboxClass: 'icheckbox_minimal-red',
  radioClass   : 'iradio_minimal-red'
});
//Flat red color scheme for iCheck
$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
  checkboxClass: 'icheckbox_flat-green',
  radioClass   : 'iradio_flat-green'
});

//Colorpicker
$('.my-colorpicker1').colorpicker();
//color picker with addon
$('.my-colorpicker2').colorpicker();