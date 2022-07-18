var marcado = true;

function cargarCursosBol(sede){ 
  var accion='cargarCombo';
  var profe='Todos';
  $("#cursosBol").load("Consultas/modelos/vistaCursos.php",{sede:sede,Profe:profe,accion:accion},function(){
      //alertify.success("La sede es: "+sede);
  });
}

function verificaDirectorDeGrupo(curso){
    var accion='verificarDireccionDeGrupo';
    //alert("El código del curso es: "+curso);
    $("#continuar").slideDown('fast');
    $("#continuar").load("Consultas/modelos/vistaCursos.php",{accion:accion,curso:curso});
}

function tipoBol(){
    var tipo = $("#tipoB").val();
    //alert("El tipo de boletin sera: "+tipo);
    var formulario = document.getElementById('tipoBoletin');
    if(tipo != "" ){      
      formulario.action="Controladores/ctrlBoletin.php";
      return true;
    }else{
      return false;
    }        
}

function cargarListaEstudiantes(){
  var curso = $("#curso").val();
  if(curso != ""){
    if(marcado){  
      $('#bloquear').slideDown('fast');
      var accion = "listadoEstudiantes";
      var sede = $("#sede").val();
      var curso = $("#curso").val();
      var anho = $("#anho").val();
      
        $("#listadoEstudiantes").load("vistas/boletines/listadoEstudiante.php",{
          accion:accion,
          sede:sede,
          curso:curso,
          anho:anho
        },
          function(){
            $("#bloquear").slideUp("fast"); 
            $("#lista").dataTable();  
            $("#btnConsultarCurso").html("<i class='fa fa-list-alt'></i> Ocultar Listado");
          });
    }else{              
      $("#listadoEstudiantes").html("");
      $("#btnConsultarCurso").html("<i class='fa fa-list-alt'></i> Ver Listado");
    }
    marcado = !marcado;
  }else{
    alertify.error("Por favor seleccione el curso antes");
    $("#checkEstudiante").attr('checked', false);
  }  
}

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