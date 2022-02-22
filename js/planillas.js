
function cargarLista(modulo){
    //alertify.success("El modulo es: "+modulo);
    var curso = $('#curso').val();
    var anho = $("#anho").val();
    switch(modulo) {
        case 1:
            var accion = 'lista';
            var area = $('#areas').val();
            var periodo = $('#periodo').val();
            if(area == ""){
                alertify.error("Por favor Seleccione el área para poder continuar");
            }else if(periodo == ""){
                alertify.error("Por favor Seleccione el periodo para poder continuar");
            }else{
                $.ajax({
                    url:"Controladores/ctrlPlanillas.php",
                    type:"POST",
                    beforeSend:function(){
                        $('#bloquear').slideDown('fast');
                    },
                    data:{accion:accion, curso:curso, codArea:area, periodo:periodo, anho:anho},
                    success: function(response){
                        $("#tablaPlanilla").html(response);
                    },
                    error: function(err){
                        console.log(err);
                    },
                    complete:function(){
                        alertify.success("Lista Cargada con éxito");
                        $('#bloquear').slideUp('fast');
                    }
                });
                // $("#tablaPlanilla").load("vistas/calificar/planilla.php",{
                //         accion:accion, curso:curso, codArea:area, periodo:periodo, anho:anho
                //     },function(){
                // });                  
            }
            //alertify.success("La sede es: "+curso);
 
            break;
        case 2:
            var sede = document.getElementById('sede').value;
            var accion='listadoEstudiantes';
            //alertify.success("La sede es: "+curso);
            $("#listadoEstudiantesSede").load("vistas/datosSedes/listadoEstudiantes.php",
              {
                accion: accion,
                curso: curso,
                anho: anho,
                sede: sede
              },function(){
                alertify.success("Cargado con éxito");
                $(".dataTable").dataTable();
                cargarResumen(sede,anho);
            });
            break;
    }
    
    return false;
}//ok
