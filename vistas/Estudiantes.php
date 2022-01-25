<?php
    
  session_start();  
  require('../Modelo/Conect.php');
  require("../Modelo/sede.php");
  require("../Modelo/anhoLectivo.php");
  $obj = new Sede();
  $objAnhos = new Anho();
?>  

<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title seccion-cabecera">
          <h3>MODULO PARA REGISTRO DE ESTUDIANTES</h3>
          <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <h4 style='margin:0px;letter-spacing: 10px;text-align: center;'>
          DATOS PARA LA CONSULTA
        </h4>
        <form method="post" action="vistas/reportes/enPdf/reporte.php?tipoReporte=1" target="_blank" id="formEstudiante">
          <div class="row">
            <div class="col-lg-7">
                <div class="col-lg-6 col-md-6">
                  <label for="">SEDE</label>
                    <select id='sede' name='sede' onchange='cargarCursos(this.value)'class='form-control' style='margin:0px; padding: 0px;' required>
                      <option value=''>Seleccione...</option>
                      <?php
                        $dataSed = $obj->listar();
                        foreach ($dataSed as $key => $value) {
                        ?>
                          <option value="<?php  echo $value['CODSEDE']; ?>">
                            <?php  echo $value['NOMSEDE']; ?>
                          </option>
                        <?php 
                        }
                      ?>
                  </select>
                </div>                            
                <div class="col-lg-3 col-md-3">
                    <label for="">CURSO</label>
                    <div id='cursos' style='margin:0px; padding: 0px;'>
                      <select id='curso' name='curso' class='form-control' style='margin:0px; padding: 0px;' required>
                        <option value=''>Seleccione...</option>    

                        <option value='todos'>Todos</option>                              
                      </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3">
                  <label for="">AÑO</label>                             
                    <select name="anho" id="anho" class="form-control">
                      <?php
                      foreach ($objAnhos->listar() as $anho) {
                        echo "<option value='".$anho['Alectivo']."'>".$anho['Alectivo']."</option>";
                       }                                         
                      ?>
                  </select>                            
                </div>              
            </div>
            <div class="col-lg-5 col-sm-12">
              <div class="row">
                <div class="col-lg-4 col-sm-4">
                      <button type='button' class='btn btn-success' id='ConsultarCurso' value='Mostrar' style="margin:0 auto;margin-top:25px;width: 100%;" onclick="cargarLista(2)">
                        <i class='fa fa-list'></i> Ver Listado
                      </button>
                </div>
                <div class="col-lg-4 col-sm-4">
                  <button type="button" class="btn btn-primary btnPrincipal" style="margin-top:25px;" data-toggle="modal" data-target="#staticBackdrop" title="Agregar Estudiante" onclick="cargarNuevoEstudiante()"><i class="fa fa-plus"></i> Nuevo Estudiante</button>
                </div>  
                <div class="col-lg-4 col-sm-4">
                  <button type="submit" class="btn btn-info btnPrincipal" style="margin-top:25px;" title="Ver reporte pdf" ><i class="fa fa-eye"></i> reporte PDF</button>
                </div> 
              </div>  
            </div>               
            
          </div>
        </form>  
        <div class="row" style="margin-top: 50px;">
          <div class="col-md-12" id='listadoEstudiantesSede'>
            
          </div>                     
        </div>         
        <div class="row">                                  
          <div class="col-md-12" style='text-align: center;'>
            <div class="panel panel-success" style='padding: 0px;margin:0 auto;width:100%;'>
              <div class="panel-heading" style='padding: 5px;height:30px;'>
                 <h4 style='margin:0px;padding: 0px;letter-spacing:0px;'>RESUMEN SOBRE LA CANTIDAD DE ESTUDIANTES POR CURSO</h4>
              </div>
              <div class="panel-body" id="resumenEst" style='padding: 0px;'>                                        
              </div>
            </div>
          </div>
        </div>
      </div>                        
    </div>
  </div>
</div>

        <div class='panel-foot'><span id="resultadoAct"></span></div>   
  <div id="PRUEBAS" ></div>


<script src="complementos/DataTables/datatables.js"></script>
<script type="text/javascript">
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
  function calcularEdad(fecha)
  {
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

  
</script>