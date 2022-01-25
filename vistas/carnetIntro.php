
<?PHP
  require("../CONECT.php");
  require("../class/Conect.php");  
  require("../class/Ajustes.php");
  $institucionID=$_POST['Institucion'];
  $usuario=$_POST['usuario'];
  $sede;
?>

<!-- Codigo Nuevo -->
<div style="width: 100%;">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-info">
        <div class="panel-heading"><h2>DATOS RELACIONADOS CON LOS CARNETS</h2></div>
        <div class="panel-body">                        
          <div class="row">
              <div class="col-md-4">
                <form method="post" action="vistas/carnetsTemp.php" target="_blank">
                  <div class="panel panel-info" style='margin-top:15px;height: 100%;'>
                    <div class="panel-body">
                      <div class="row">
                          <div class="col-md-12" >
                              <label for="" style='margin-top:15px;'>CURSO:</label>
                              <?php
                                  //COnsulta para seleccionar los cursos asignados al profesor OJO reemplazar el id de usuario por la variable
                                  $sqlCurso=mysql_query("SELECT * FROM cursos ORDER BY codSede,CODGRADO;");

                                  echo "<div id='cursosBol' style='margin:0px; padding: 0px;'>";
                                  $rcargar=mysql_num_rows($sqlCurso);
                                  echo "<select id='curso' name='curso' class='form-control' required onchange='limpiar()'>";
                                  echo "<option value=''>Seleccione...</option>";
                                  while($n=mysql_fetch_array($sqlCurso)){
                                    $sqlSede=mysql_query("SELECT NOMSEDE FROM sedes WHERE CODSEDE='$n[0]'");
                                    while($nomSede=mysql_fetch_array($sqlSede)){
                                      echo "<option value='$n[2]'>$nomSede[0] - ".$n[1]."° ".$n[3]."</option>"; 
                                    }                                                   
                                  }
                                              echo   "</select>"; 
                                  echo "</div>";
                              ?>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-12"> 
                              <label for="" style='margin-top:15px;'>MODELO: </label> 
                              <?php
                                  echo "<div id='tipDatos' style='margin:0px; padding: 0px;'>
                                  <select id='tipoDatos' name='tipoDatos' class='form-control' required onchange='limpiar2();cargarModelo(this.value)'>
                                      <option value=''>Seleccione...</option>
                                      <option value='Modelo1-H'>Modelo 1</option>
                                      <option value='Modelo2-H'>Modelo 2</option>
                                      <option value='Modelo3-H'>Modelo 3</option>
                                      <option value='Modelo4-H'>Modelo 4</option>
                                      <option value='Modelo5-V'>Modelo 5</option>
                                      <option value='Modelo6-V'>Modelo 6</option>
                                      <option value='Modelo7-V'>Modelo 7</option>
                                      <option value='Modelo8-V'>Modelo 8</option>
                                  </select>
                                  </div>";
                              ?>                               
                          </div>                        
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <label style='margin-top:15px;'>AÑO:</label>
                          <?php
                            $objAnno=new Anhio();
                            $anhoAct=$objAnno->Listar($institucionID);
                          ?>
                        </div>
                      </div>
                      <div class="row">
                          <div class="col-md-12" style="padding-top: 20px;"> 
                              <input type="submit" class="form form-control btn btn-success" value="Continuar" />
                          </div>                        
                      </div>
                    </div>
                  </div>                          
              </div>                   
              </form>  
              <div class="col-md-8">                                
                  <div class="panel panel-green">
                      <div class="panel-heading seccion-cabecera">
                        <h3>VISTA PREVIA DEL MODELO</h3>
                      </div>
                      <div class="panel-body" style='padding-top:25px;height:320px;width:100%;text-align:center;overflow:auto; background-color:rgb(29,32,41);' id='vistaModelo'>
                      </div>
                  </div>
              </div>
          </div>
        </div>
      </div>            
    </div>
  </div>
</div>	
	
<!--------- CÓDIGO ANTERIOR -------------------->
  <script type='text/javascript'>
  	function salir(){
		top.location.href = "http://";
    }
      
    function limpiar2(){
        document.getElementById('vistaModelo').innerHTML="";
        $("#btnImprimir").fadeOut();
    }

    
      function cargarModelo(modelo){
          if(modelo=='Modelo1-H'){
              document.getElementById('vistaModelo').innerHTML="<img src='IMAGENES/Carnets/eje1.png' style='margin:0 auto;'>";
          }
          if(modelo=='Modelo2-H'){
              document.getElementById('vistaModelo').innerHTML="<img src='IMAGENES/Carnets/eje2.png' style='margin:0 auto;'>";
          }
          if(modelo=='Modelo3-H'){
              document.getElementById('vistaModelo').innerHTML="<img src='IMAGENES/Carnets/eje3.png' style='margin:0 auto;'>";
          }
          if(modelo=='Modelo4-H'){
              document.getElementById('vistaModelo').innerHTML="<img src='IMAGENES/Carnets/eje4.png' style='margin:0 auto;'>";
          }
          if(modelo=='Modelo5-V'){
              document.getElementById('vistaModelo').innerHTML="<img src='IMAGENES/Carnets/eje5.png' style='margin:0 auto;'>";
          }
          if(modelo=='Modelo6-V'){
              document.getElementById('vistaModelo').innerHTML="<img src='IMAGENES/Carnets/eje6.png' style='margin:0 auto;'>";
          }
          if(modelo=='Modelo7-V'){
              document.getElementById('vistaModelo').innerHTML="<img src='IMAGENES/Carnets/eje7.png' style='margin:0 auto;'>";
          }
          if(modelo=='Modelo8-V'){
              document.getElementById('vistaModelo').innerHTML="<img src='IMAGENES/Carnets/eje8.png' style='margin:0 auto;'>";
          }
          
      }
  </script>	

  