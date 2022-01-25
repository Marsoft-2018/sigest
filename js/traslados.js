var selEstdudiante = false;
function cargarCursosDestino(sede){
    $("#cursoDestino").html("");
    $("#cursoDestino").append("<option value=''>Seleccione...</option>");
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
                $("#cursoDestino").append("<option value='"+item.codCurso+"'>"+item.CODGRADO+"° "+item.grupo+"</option>");                
            });
        },
        error: function(data){
            alertify.error("error","Error al cargar los curso de la sede seleccionada");
        }
    });
}

// function cargarListaEstudiantes(){
//   var marcado 	= $("#checkEstudiante").is(":checked");
//   var curso 	= document.getElementById("cursoBol").value;
//   if(curso 		!= ""){
//     if(marcado){  
//       bloquearVentana();    
//       var accion = "listadoEstudiantes";
//       var sede 	 = document.getElementById("sedeBol").value;
//       var curso  = document.getElementById("cursoBol").value;
//       var anho 	 = document.getElementById("newYear").value;
      
//         $("#listadoEstudiantes").load("Config/ctrlBoletin.php",{accion:accion,sede:sede,curso:curso,anho:anho},
//           function(){
//             swal.close();
//           });
//     }else{              
//       $("#listadoEstudiantes").html("");
//     }
//   }else{
//     alertify.error("Por favor seleccione el curso antes");
//     $("#checkEstudiante").attr('checked', false);
//   }  
// }

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

function verificarSedeOrigen(){
  var sede1 = $("#sede").val();
  var sede2 = $(".sedeDestino").val();
  if(sede1 == sede2){
    $("#sedeDes").addClass("error");
    alertify.error("La sede de destino no puede ser igual a la sede de origen\n Por favor revise los datos");
    habilitarContinuar(0);
  }else{
    $("#sedeDes").removeClass("error");
    habilitarContinuar(1);
  }
}

function verificarCurso(cursoDestino){
  var accion = "VerificarCurso";
  let cursoActual = $("#curso").val();
  $.ajax({
    type:"POST",
    url: "Controladores/ctrlTraslados.php",
    data:{accion:accion, cursoActual:cursoActual, cursoDestino:cursoDestino},
    success: function(data){
      data = JSON.parse(data);            
      if(data["estado"] != 1) {
        alertify.error(""+data["mensaje"]);
        habilitarContinuar(0)
      }else{
        habilitarContinuar(1);
      }

    },
    error: function(res){
      console.log('test: '+res);
    }
  });
}

function limpiarListado(){	              
  $("#listadoEstudiantes").html("");
  $("#btnConsultarCurso").html("<i class='fa fa-list-alt'></i> Ver Listado");
  marcado = !marcado;
}

function habilitarContinuar(estado){
  if (estado == 0) {
    $("#btnContinuar").attr("disabled","true");
  }else{
    $("#btnContinuar").removeAttr("disabled");
  }
}


function trasladar(){
  var accion = "Trasladar";  
  $.ajax({
    type : "POST",
    url : "Controladores/ctrlTraslados.php?accion="+accion,
    data: $("#formTraslados").serialize(),
    beforeSend: function(){
        bloquear();
    },
    complete:function(data){
        desBloquear();
    },
    success: function(data){
      alertify.success(data);
      marcado = true;
      cargarListaEstudiantes();
    },
    error: function(data){
        desBloquear();
    }
  });
  return false;
}