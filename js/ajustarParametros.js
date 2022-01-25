
    /*function salir(){top.location.href = "http://localhost/boletinesV2.5/";}*/
    
    function guardarAnno(){
        var inst=document.getElementById('OcultoInst').value;
        var anno=document.getElementById('newYear').value;
        var accion='guardarAnno';
        var modulo='annoLectivo';
        $("#resulAnno").load("vistas/Ajustar.php",{inst:inst,accion:accion,modulo:modulo,anno:anno});            
    }
    
    
    function agregarPeriodo(){
        var accion='agregarPeriodo';
        var modulo='periodos';
        var per = $("#newPer").val();
        var porce = $("#newPor").val();
        var fechaInicio = $("#fecInicio").val();
        var fechaCierre = $("#fecCierre").val();

        $.ajax({
            type: 'POST',
            url: "Controladores/ctrlAjustes.php",
            data: {
                accion:accion,
                modulo:modulo,
                per:per,
                porce:porce,
                fechaInicio:fechaInicio,
                fechaCierre:fechaCierre
            },
            beforeSend: function(){
                $('#bloquear').slideDown('fast');
            },
            complete:function(data){
                //console.log('Terminó el envío');
            },
            success: function(data){          
                $('#periodosRes').html("");             
                $('#periodosRes').html(data);
                $("#bloquear").slideUp("fast");
            },
            error: function(data){
                console.log('Error: '+data);
            }
        });
        return false;
    }
    
    function modificarPeriodo(id, valor){        
        var largo = (id.length)-2;
        var clave = id.substr(2,largo); 
        var campoR = id.substr(0,2);
        var campo = 0;
        
        if(campoR == 'VP'){
            campo='valorPeriodo';
        }else if(campoR == 'FI'){
            campo = 'fechaInicio';
        }else if(campoR == 'FF'){
            campo =  'fechaCierre';
        } 
                        
        var accion='Modificar';
        var modulo='periodos';
        
        $("#divResultados").load("Controladores/ctrlAjustes.php",{
            accion:accion,
            modulo:modulo,
            campo:campo,
            clave:clave,
            valor:valor
        },function(){
            alertify.success("Periodo modificado con éxito");        
        });
    }
    
    function eliminarPeriodo(id){
        var accion='Eliminar';
        var modulo='periodos';
        $.ajax({
            type: 'POST',
            url: "Controladores/ctrlAjustes.php",
            data: {
                accion:accion,
                modulo:modulo,
                per:id
            },
            beforeSend: function(){
                $('#bloquear').slideDown('fast');
            },
            complete:function(data){
                //console.log('Terminó el envío');
            },
            success: function(data){          
                $('#periodosRes').html("");             
                $('#periodosRes').html(data);
                $("#bloquear").slideUp("fast");
            },
            error: function(data){
                console.log('Error: '+data);
            }
        });
    }
    
//==========---*** Para la configurar el modulo de Desempeños  ***---=========//    
    //Funcion para agregar los Desempeños
    function agregarDesempeno(){
        var desempNombre = document.getElementById('desemNuevo').value;        
        var desempInf = document.getElementById('limitInfNuevo').value; 
        var desempSup = document.getElementById('limitSupNuevo').value; 
        var modulo = 'Desempenos';
        var accion = 'agregarDesempeno';
        $.ajax({
            type: 'POST',
            url: "Controladores/ctrlAjustes.php",
            data: {
                modulo:modulo,
                accion:accion,
                Desempeno:desempNombre,
                desempInf:desempInf,
                desempSup:desempSup
            },
            beforeSend: function(){
                $('#bloquear').slideDown('fast');
            },
            complete:function(data){
                //console.log('Terminó el envío');
            },
            success: function(data){          
                $('#desempenhosMarco').html("");             
                $('#desempenhosMarco').html(data);
                $("#bloquear").slideUp("fast");
            },
            error: function(data){
                console.log('Error: '+data);
            }
        });
        return false;
    }

    //Funcion para Eliminar los Desempeños
    function eliminarDes(id){ 
        var modulo='Desempenos';
        var accion='eliminar';

        $.ajax({
            type: 'POST',
            url: "Controladores/ctrlAjustes.php",
            data: {modulo: modulo, accion: accion, id: id},
            beforeSend: function(){
                $('#bloquear').slideDown('fast');
            },
            complete:function(data){
                //console.log('Terminó el envío');
            },
            success: function(data){          
                $('#desempenhosMarco').html("");             
                $('#desempenhosMarco').html(data);
                $("#bloquear").slideUp("fast");
            },
            error: function(data){
                console.log('Error: '+data);
            }
        });    
    }
    
    //Funcion para Modificar los Desempeños
    function modificarDes(id,valor){
        var largo = (id.length)-2;
        var clave = id.substr(2,largo); 
        var campoR = id.substr(0,2);
        var campo = 0;
        if(campoR == 'LI'){
            campo = 'limiteInf';
        }else if(campoR == 'LS'){
            campo = 'limiteSup';
        }else if(campoR == 'DE'){
            campo = 'CONCEPT';
        }
            
        var modulo='Desempenos';
        var accion='modificar';  
        $.ajax({
            type: 'POST',
            url: "Controladores/ctrlAjustes.php",
            data: {modulo:modulo,accion:accion, campo:campo,clave:clave, valor:valor},
            beforeSend: function(){
                $('#bloquear').slideDown('fast');
            },
            complete:function(data){
                //console.log('Terminó el envío');
            },
            success: function(data){          
                $('#resultados').html("");             
                $('#resultados').html(data);
                $("#bloquear").slideUp("fast");
            },
            error: function(data){
                console.log('Error: '+data);
            }
        });    
    }
//===========---****     Fin de las funciones para los Desempeños       ****---=========//
    
//==========---*** Para la configurar el modulo de criterios de evaluación ***---=========//
    //Agregar criterio nuevo
    function agregarCriterio(){
        var criterio = $("#criterioNuevo").val();
        var porcCriterio = $("#porcCriterioNuevo").val();        
        var modulo = 'Criterios';
        var accion = 'agregarCriterio';
        if(criterio == '' || porcCriterio == ''){
            alertify.error("Por favor ingrese los datos completos para poder continuar");
        }else{
            $.ajax({
                type: "POST",
                url : "Controladores/ctrlAjustes.php",
                data : {
                    modulo : modulo,
                    accion : accion,
                    criterio : criterio,
                    pCriterio : porcCriterio
                },
                beforeSend: function(){
                    $('#bloquear').slideDown('fast');
                },
                success: function(data){
                    $("#criteriosMarco").html("");
                    $("#criteriosMarco").html(data);
                    $('#bloquear').slideUp('fast');
                },
                error: function(data){
                    console.log('Error: '+data);
                    $('#bloquear').slideUp('fast');
                }
            });
        }
    }

    //Modificar Criterio
    function modificarCriterio(id){
        var modulo='Criterios';
        var accion='modificarCriterio';
        let nombre = $("#NC"+id).val();
        let porcentaje = $("#PC"+id).val();
        $.ajax({
            type: "POST",
            url : "Controladores/ctrlAjustes.php",
            data : {modulo:modulo,accion:accion,id:id,nombre:nombre,porcentaje:porcentaje},
            beforeSend: function(){
                $('#bloquear').slideDown('fast');
            },
            success: function(data){
                $('#bloquear').slideUp('fast');
                alertify.success(data);
            },
            error: function(data){
                console.log('Error: '+data);
                $('#bloquear').slideUp('fast');
            }
        });         
    }
    
    //Eliminar criterio
    function eliminarCriterio(id){
        var modulo='Criterios';
        var accion='eliminarCriterio';
        alertify.defaults.transition = "flipy";
        alertify.defaults.theme.ok = "btn btn-primary";
        alertify.defaults.theme.cancel = "btn btn-danger";
        alertify.defaults.theme.input = "form-control";
        alertify.confirm(
          '<div class="panel-heading" style="background-color:#902015;color:#fff;"><i class="fa fa-times-circle"> Eliminar Criterio</i></div>', 
          'Señor usuario tenga encuenta esta advertencia, Para eliminar los datos presione el botón OK, recuerde que al eliminarlo se eliminaran todos los datos relacionados al mismo.<br> Al confirmar no se podrá deshacer', 
          function()
          { 
            $.ajax({
                type: "POST",
                url: 'Controladores/ctrlAjustes.php',
                data: {
                    modulo : modulo,
                    accion : accion,
                    id : id
                },
                beforeSend: function(){
                    $('#bloquear').slideDown('fast');
                },
                success: function(data){
                    $("#criteriosMarco").html("");
                    $("#criteriosMarco").html(data);
                    $('#bloquear').slideUp('fast');
                },
                error: function(data){
                    console.log('Error: '+data);
                    $('#bloquear').slideUp('fast');
                }
            });              
          }, 
          function()
          { 
              //alertify.error('Cancel')
          }
        ).set('closable', false);  
    }
//===========---****     Fin de las funciones para los criterios       ****---=========//
    
    
    $("#recargar").click(function(){
        var institucion= document.getElementById('OcultoInst').value;           
        $("#modulo").load('Config/AjustarParametros.php',{Institucion:institucion},function(){
            alertify.success("Recargado");
        });
    });
    

    function guardarModeloInforme(){
        var accion = 'guardarModeloInforme';
        var modulo = 'modelos';
        var modelo = $("#modelo").val(); 
        var areasReprobar = $("#numAreas").val();     
        $.ajax({
            type: 'POST',
            url: "Controladores/ctrlAjustes.php",
            data: {
                accion : accion,
                modulo : modulo,
                modelo : modelo,
                areasReprobar : areasReprobar
            },
            beforeSend: function(){
                bloquear();
            },
            complete:function(data){
                //console.log('Terminó el envío');
            },
            success: function(data){          
                $('#divResultados').html("");             
                $('#divResultados').html(data);
                desBloquear();
                alertify.success("El modelo fue seleccionado de manera exitosa");
                
            },
            error: function(data){
                console.log('Error: '+data);
                desBloquear();
            }
        });
    }
