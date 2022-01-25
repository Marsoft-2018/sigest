<table class='table table-striped' style='font-size:12px;width: 95%'>
    <thead>
        <tr>
            <th colspan="7">
                <h4>Configuración por cada periodo</h4>                                                    
            </th>
        </tr>
        <tr style="background-color: #AABED9; text-align: center;">      
            <th>Periodo</th>
            <th>% Porcentaje</th>
            <th>Inicio del Periodo</th>
            <th>Fin del Periodo</th>
            <th colspan="3">Acciones</th>                                            
        </tr>
    </thead>
    <tbody>
    <?php               
        $objPeriodos = new Periodo();
        $objPeriodos->idCentro = $_SESSION['institucion'];
        $periodos = $objPeriodos->cargar();
        foreach ($periodos as $key => $campo) {
            ?>
        <tr style="border: 1px solid #AABED9;">
            <td style='color:#000000; margin:0px; padding: 0px; font-size: 11px; width: 30px;'>
                <input type='number' 
                    id="p<?php echo $campo['periodo']; ?>"  
                    name="periodos[<?php echo $campo['periodo'] ?>][idPeriodo]"  class="form form-control" 
                    value="<?php echo $campo['periodo']; ?>" 
                    style='height:23px; border:0px; text-align:center' readonly="readonly">
            </td>
            <td style='color:#000000;margin:0px; padding: 0px;font-size: 11px;'>
                <input type='number' 
                    id="VP<?php echo $campo['periodo']; ?>"
                    name="periodos[<?php echo $campo['valorPeriodo'] ?>][valorPeriodo]"
                    value="<?php echo $campo['valorPeriodo']; ?>"  
                    title='Porcentaje del periodo, por favor ingrese un valor entero entre 1 y 100' class="form form-control" style='height:23px;border:0px; text-align: center' onchange="modificarPeriodo(this.id,this.value)" min="1" max="100">
            </td>
            <td style="color:#000000;margin:0px; padding: 0px;font-size: 11px;">
                <input type = "date"  class="form form-control" 
                    id="FI<?php echo $campo['periodo']; ?>" 
                    name="periodos[<?php echo $campo['fechaInicio'] ?>][fechaInicio]" 
                    value="<?php echo $campo['fechaInicio']; ?>" 
                    style='height:23px;border:0px;' onchange="modificarPeriodo(this.id,this.value)">
            </td>
            <td style="color:#000000;margin:0px; padding: 0px; width: 40px;">
                <input type = "date"  class="form form-control" 
                id="FF<?php echo $campo['periodo']; ?>" 
                name="periodos[<?php echo $campo['fechaCierre'] ?>][fechaCierre]"
                value="<?php echo $campo['fechaCierre']; ?>" 
                style='height:23px;border:0px;' onchange="modificarPeriodo(this.id,this.value)">
            </td>
            <td style="color:#000000;margin:0px; padding: 0px; width: 40px;">
                <button type="button" class="btn btn-danger" title="Eliminar periodo <?php echo $campo['periodo']; ?>"  onclick='eliminarPeriodo(this.id)'><i class="fa fa-close"></i></button>
            </td>
            <td style="color:#000000;margin:0px; padding: 0px; width: 40px;">
                <button type="button" class="btn btn-primary" id="<?php echo $campo['periodo']; ?>" data-toggle="modal" data-target="#staticBackdrop" title="Agregar excepción a profesores" onclick="programarExcepciones(this.id)"><i class="fa fa-calendar"></i></button>
            </td>            
            <td style="color:#000000;margin:0px; padding: 0px; width: 40px;">
                <button type="button" class="btn btn-warning" id="<?php echo $campo['periodo']; ?>" data-toggle="modal" data-target="#staticBackdrop" title="Programar entrega de boletines" onclick="programarEntrega(this.id)"><i class="fa fa-clipboard"></i></button>
            </td>
        </tr>
            <?php
        }
    ?>                                           
    </tbody>
</table> 

<h3>Estilo de calificación</h3>
<h5>
    El modelo de la planilla indica al sistema como será el proceso de calificación en cada periodo durante el año lectivo, escoja el modelo de calificación y estilo de logros a utilizar en la institución.
</h5>
<div class="box box-primary box-solid">
    <div class="box-header">
    <div class="row">
        <div class="col-md-4">    
            <label for="tipoPlanilla">Seleccione el Estilo de calificación</label>
            <select name="" id="tipoPlanilla" class="form form-control"  onchange ="mostrarVariasCalificaciones(this.value)">
                <option value="">Seleccione...</option>
                <option value="Unica" <?php if($tipoPlanilla == "Unica"){ echo "selected"; } ?>>Calificación Única por periodo</option>
                <option value="Criterios" <?php if($tipoPlanilla == "Criterios"){ echo "selected"; } ?>>Calificación por criterios</option>
                <option value="Varias" <?php if($tipoPlanilla == "Varias"){ echo "selected"; } ?>>Varias Calificaciones por periodo</option>
            </select>
            <hr>
            <div id="totalNotas" style="display: none;">
                <label for="">Catidad de notas</label>   
                <input type="number" id="cantidad_notas" name="cantidad_notas" value="<?php echo $cantidad_notas = 0; ?>" min="1" class="form form-control">

            </div> 
        </div>
        <div class="col-md-8">
            <div class="direct-chat-text info">
                <strong>Calificación Única por periodo:</strong> Esta planilla le dará al docente la posibilidad de ingresar solo la calificación definitiva en el periodo. <br><br>
                <strong>Calificación por criterios:</strong> Esta planilla le dará al docente la posibilidad de ingresar las calificaciones de acuerdo a cada uno de los criterios establecidos en la pestaña con el mismo nombre y calcular la calificación definitiva en el periodo de acuerdo al porcentaje definido en cada uno de ellos.<br><br>
                <strong>Varias Calificaciones por periodo:</strong> Esta planilla solicitará al docente el ingreso del número de calificaciones establecidas para calcular la calificación definitiva en el periodo mediante el promedio de estas.
            </div>                                            
        </div>
    </div>
    </div>
    <div class="box-body bg-success ">
        <div class="row">
            <div class="col-md-4">  
                <label for="tipo_logros">Seleccione el estilo de logros</label>
                <select name="tipo_logros" id="tipo_logros" class="form form-control">
                    <option value="">Seleccione...</option>
                    <option value="ninguno" <?php if($tipo_logros == "ninguno"){ echo "selected"; } ?>>Sin logros</option>
                    <option value="definitiva" <?php if($tipo_logros == "definitiva"){ echo "selected"; } ?>>Logros por desempeño definitivo</option>
                    <option value="criterios" <?php if($tipo_logros == "criterios"){ echo "selected"; } ?>>Logros por criterio</option>
                </select>                
            </div>
            <div class="col-md-8">
                <div class="direct-chat-text info">
                    <strong>Sin logros: </strong> Esta opción deshabilita el ingreso de los logros al profesor, muestra una planilla únicamente para calificaciones y no se mostraran logros en el boletín.<br><br>
                    <strong>Logros por desempeño definitivo: </strong>Esta opción prepara al sistema para mostrar en el boletín los logros de manera general de acuerdo a cada indicador ingresado por el docente en el módulo logros, teniendo en cuenta el desempeño definitivo.<br><br>
                    <strong>Logros por criterio: </strong>Esta opción prepara al sistema para mostrar en el boletín los logros de acuerdo al desempeño obtenido por el estudiante en cada uno de los criterios definidos, teniendo en cuenta el ingreso de ellos en el módulo logros. <strong>está opción debe utilizarse únicamente con el estilo de planillas "Calificación por criterios"</strong>.
                </div>                                            
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <button class="btn btn-success" onclick="guardarTipoPlanilla()">
            <i class="fa fa-save"></i>Guardar Estilo de calificacion
        </button>
    </div>
</div> 