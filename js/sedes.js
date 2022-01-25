

    function modificaGradTemp(id,valor){
        var largo=(id.length)-1;
        var clave=id.substr(1,largo);
        var sede=document.getElementById('sedeBol').value;
        var accion='modificaGradoTemp';
        $('#resultadoAct').load('Config/ajustesSedes.php',{accion:accion,sede:sede,clave:clave,gradoTope:valor});
    }
    
    function eliminarItemGrado(id){
        var largo=(id.length)-1;
        var clave=id.substr(1,largo);
        var sede=document.getElementById('sedeBol').value; 
        var accion='eliminarGradoTemp';       
        $('#listaGrados').load('Config/ajustesSedes.php',{accion:accion,sede:sede,clave:clave},function(){
             alertify.success ("Se eliminó el grado satisfactoriamente");
        });        
    }  
    
    function trasladar(){
        var sede=document.getElementById('sedeBol').value; 
        var accion='trasladarGT'; 
        $('#listaGradosAsoc').load('Config/ajustesSedes.php',{accion:accion,sede:sede},function(){
             alertify.success ("Los grupos para cada grado se crearon satisfactoriamente, por favor continue con la asignación de jornadas");
        });
    }
    
    function cambioDeJornada(idCr,idJornada){
        var sede=document.getElementById('sedeBol').value; 
        var accion='cambioJornada';
        var largo=(idCr.length)-2;
        var idcurso=idCr.substr(2,largo);
        //alert('los valores son: Sede: '+sede+' accion: '+accion+" el curso recibido es: "+idCr+" el curso real es: "+idcurso+" el id de la jornada es: "+idJornada);
        $('#resultadoAct').load('Config/ajustesSedes.php',{accion:accion,sede:sede,idcurso:idcurso,idJornada:idJornada});
    }
    
    function agregarCurso(){
        var sede=document.getElementById('sedeBol').value; 
        var accion='agregarCurso'; 
        var grado=document.getElementById('newGrado').value;
        var grupo=document.getElementById('newGrupo').value;
        var jornada=document.getElementById('jorNueva').value;
        $('#listaGradosAsoc').load('Config/ajustesSedes.php',{accion:accion,sede:sede,grado:grado,grupo:grupo,jornada:jornada});
    }
    
    function eliminarCurso(id){
        var sede=document.getElementById('sedeBol').value; 
        var accion='eliminarCurso'; 
        $('#listaGradosAsoc').load('Config/ajustesSedes.php',{accion:accion,sede:sede,idcurso:id}); 
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

    // function agregarAreaxSede(){
    //     var txtIdArea   = $("#txtIdArea").val();
    //     var txtNombreAs = $("#txtNombre").val(); 
    //     var txtCodAs    = $("#txtCod").val();
    //     var sede    = $('#sedeBol').val(); 
    //     var anho    = $('#anho').val(); 
    //     var accion  = 'agregarAreaxSede'; 
    //     alertify.alert("los valores a pasar son: Sede: "+sede+" - accion: "+accion+" idArea: "+txtIdArea+" - abreviatura: "+txtCodAs+" - nombre: "+txtNombreAs);
    //     $('#listadoAreasAsigSede').load('Controladores/ctrlSedes.php',{
    //         accion:accion,
    //         sede:sede,
    //         txtIdArea:txtIdArea,
    //         txtNombreAs:txtNombreAs,
    //         txtCodAs:txtCodAs,
    //         anho:anho
    //     },function(){
    //         $("#datosIH").load("vistas/datosSedes/areasIH.php");
    //         $("#txtIdArea").val("Ninguna");
    //         $("#txtNombre").val(""); 
    //         $("#txtCod").val("");

    //     });  
    // }
    
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
            {accion:accion,campo:campo,clave:clave,valor:valor},
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
    
    function modificaAsig(id,valor,campoR){
      var largo = id.length;
      var grado = id.substr(2,3);
      var clave = id.substr(5,(largo-5));
      var campo = 0;
      if(campoR == '1'){
        campo = 'Abreviatura';
      }else if(campoR == '2'){
        campo = 'Nombre';
      }else if(campoR == '3'){
        campo = 'IH';
      }else if(campoR == '4'){
        campo = 'porcentaje';
      }
      //alertify.success("Datos para la consulta: "+campo+", "+grado+", "+clave+", "+valor);
      var accion='modificaAxS';
      $('#resultadoAct').load('Config/ajustesSedes.php',
        {accion:accion,campo:campo,clave:clave,valor:valor,grado:grado}
      );
    }
    
    function  eliminarAreaxSede(idarea){
        var sede=document.getElementById('sedeBol').value; 
        var accion='eliminarAreaxSede'; 
        $('#listadoAreasAsigSede').load('Config/ajustesSedes.php',{accion:accion,sede:sede,idArea:idarea});  
    }
    
    function eliminarAsigxS(id,idarea){
        var sede=document.getElementById('sedeBol').value; 
        var accion='eliminarAxS'; 
        $('#listadoAreasAsigSede').load('Config/ajustesSedes.php',{accion:accion,sede:sede,idAsignatura:id,idArea:idarea});  
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
    month = month-1;
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
    dteDate = new Date(year,month,day);
 
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
    var patron = new RegExp("^(19|20)+([0-9]{2})([-])([0-9]{1,2})([-])([0-9]{1,2})$");
 
    if(fecha.search(patron) == 0)
    {
        var values = fecha.split("-");
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
    var fecha = document.getElementById("NAC").value;
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