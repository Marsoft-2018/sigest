<?php
	//require("../CONECT.php");
    session_start();
    $objCA = new cargaAcademica();
    $objCA->codProfesor = $_POST['idProfesor'];
    $objCA->anho = $_POST['anho'];
    
    $objProfesor = new Profesor();
    $objProfesor->IDUsuario =  $_POST['idProfesor'];
    $nombre = "";
    foreach($objProfesor->cargar() as $value){
        $nombre = $value['PrimerNombre']." ".$value['PrimerApellido']." ".$value['SegundoApellido'];
    }
?>

<!-- Codigo Nuevo -->
<div style="width: 100%;">
    <br>    
    <div class="row">
        <div class="col-md-12">            
            <div class="x_panel">
                <div class="x_title seccion-cabecera">
                  <div class="clearfix">
                      <div class="row">
                          <div class="col col-md-3">
                              <button class="btn btn-primary" onclick="imprimirParte('reporte')"><i class="fa fa-print"></i> Imprimir</button>
                          </div>
                          <div class="col col-md-3">
                            <form method="post" action="vistas/reportes/planillasProfesor/reporte.php?tipoReporte=1&profesor=<?php echo strtoupper($nombre); ?>&idProfesor=<?php echo $_POST['idProfesor']; ?>&anho=<?php echo $_POST['anho']; ?>" target="_blank">
                                <button type="submit" class="btn btn-success"><i class="fa fa-print"></i> Planillas de asistencia</button>  
                            </form>
                          </div>
                          <div class="col col-md-3">
                            <form method="post" action="vistas/reportes/planillasProfesor/reporte.php?tipoReporte=2&profesor=<?php echo strtoupper($nombre); ?>&idProfesor=<?php echo $_POST['idProfesor']; ?>&anho=<?php echo $_POST['anho']; ?>" target="_blank">
                                <button class="btn btn-info" type="submit" ><i class="fa fa-print"></i> Planillas de notas</button> 
                            </form>  
                          </div>
                      </div>
                  </div>
                </div>
                <div class="x_content" id="reporte">  
                    <h3>REPORTE LISTADOS DISTRIBUCION ACADEMICA PROFESOR</h3>  
                    <h3><?php echo strtoupper($nombre); ?></h3>
                    <table class='table table-striped' style="width:100%; border: 1px solid #000; border-collapse: collapse;">
                        <thead>
                          <tr  style="border: 1px solid #000;background-color: #cecece;">
                           <th scope='col'>Área</th>
                            <th scope='col'>Abreviatura</th>
                            <th scope='col'>Grados</th>
                         </tr>
                        </thead>
                        <tbody>
                        <?php 
                        	foreach ($objCA -> verCarga() as $value) {
                        ?>
                        	<tr>
                      			<td style="border: 1px solid #000;">
                      				<?php echo strtoupper($value['Nombre']) ?>
                      			</td>
                      			<td style="border: 1px solid #000;">
                      				<?php echo strtoupper($value['Abreviatura']) ?>
                      			</td>
                      			<td style="border: 1px solid #000; text-align: center; font-size: 1em;">
                      				<?php echo strtoupper($value['CODGRADO']) ?>°
                      			</td>
                    		</tr>
                    	<?php 
                        	}
                        ?>
                     	</tbody>
                    </table>
                </div>                
            </div>            
        </div>
    </div>
</div>	

  