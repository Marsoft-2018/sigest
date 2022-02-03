<?php 
    if (isset($_POST['accion'])) {
        session_start();
        require('../../Modelo/Conect.php');
        require("../../Modelo/sede.php");
        require("../../Modelo/nivel.php");
        require("../../Modelo/grado.php");
        require("../../Modelo/curso.php");
        require("../../Modelo/profesores.php");
        require("../../Modelo/Estudiante.php");
        require("../../Modelo/jornada.php");
        require("../../Modelo/matricula.php");  
        $objGrad = new Grado();
        $objJornada = new Jornada();    
        $objGrad->sede = $_POST['sede'];
    }else{
        require("../Modelo/matricula.php");         
    }
?>
<div class="row"> 
  <div class="col-md-12 panel-footer">
    <h3>Nuevos Cursos</h3>                         
    <div class="row">
        <div class="col-md-4">
            <label>Grado:</label>
            <select id='newGrado' style='margin:0px;font-size: 12px;' class='form form-control'>
                <option value=''>Seleccione...</option>
                <?php 
                    $objGrado = new grados();
                    foreach ($objGrado->listar() as $key => $gr) {
                        echo "<option value='".$gr['CODGRADO']."'>".strtoupper($gr['NOMGRADO'])." - ".$gr['CODNIVEL']."</option>";
                    }
                ?>                             
            </select>
        </div>
        <div class="col-md-2">
            <label>Grupo:</label>
            <input type='number' value='' min="1" id='newGrupo' style='margin:0px;font-size: 12px;' class='form form-control'>
        </div>
        <div class="col-md-3">
            <label>Jornada:</label>
            <select id='jorNueva' style='margin:0px;font-size: 12px;' class='form form-control'>
                <option value=''>Seleccione...</option>
                <?php 
                    foreach ($objJornada->listar() as $key => $jornada) {
                       echo "<option value='".$jornada['idJornada']."'>".$jornada['Nombre']."</option>"; 
                    }
                ?>                             
            </select>
        </div>
        <div class="col-md-3">
            <button type='button' onclick="agregarCurso('<?php echo $_POST['sede'] ?>')" class='btn btn-primary'  style="margin-top: 20px; padding:10px 35px;">
                <i class='fa fa-plus'></i> Agregar
            </button>
        </div>
    </div>             
</div> 
<hr>   
<h3 style="text-align: center;">Niveles y grados Asociados a la Sede</h3>
<div class="row">
    <div class="col-md-12">
        <table class='table table-striped' style="border-collapse: collapse;border:1px solid #cdcdcd;">
            <thead>
                <tr  style="border-collapse: collapse;border:1px solid #cdcdcd;">
                    <th>NIVEL</th>
                    <th>GRADO</th>
                    <th style="text-align: center;">GRUPO</th>
                    <th style="text-align: center;">JORNADA</th>
                    <th></th>
                </tr>
            </thead>
            <tbody >
                <?php 
                    foreach ($objGrad->cargarCursos() as $key => $lista) { ?>               
                    <tr>                            
                        <td style="width: 30%;"><?php echo $lista['NOMBRE_NIVEL']; ?></td>
                        <td><?php echo strtoupper($lista['NOMGRADO'])  ?></td>
                        <td style='text-align:center;'><?php echo $lista['grupo'] ?></td>
                        <td style='color:#000000;margin:0px; padding: 0px; text-align:center;font-size: 10px;'>
                            <select id="<?php echo $lista['codCurso'] ?>" onchange='cambioDeJornada(this.id,this.value)' class='form form-control'>
                            <?php 
                                foreach ($objJornada->listar() as $key => $jornada) {
                                    if ($jornada['idJornada'] == $lista['idJornada']) {
                                        echo "<option selected value='".$jornada['idJornada']."'>".$jornada['Nombre']."</option>";         
                                    }else{
                                        echo "<option value='".$jornada['idJornada']."'>".$jornada['Nombre']."</option>"; 
                                    }         
                                }
                            ?>                           
                            </select>
                        </td>
                        <td style='color:#000000;margin:0px; padding: 0px; text-align:center;font-size: 12px;width:25px;'>            
                            <button type='button' class='btn btn-danger btn-xs' id="<?php echo $lista['codCurso'] ?>." onclick='eliminarCurso(this.id)'>
                                <i class='fa fa-trash-o'></i>
                            </button>           
                        </td>
                    </tr>
                <?php }  ?>  
            </tbody>
        </table>        
    </div>
</div>
<div class="row">
    <div class="col-md-12" style='text-align: center;'>
        <div class="panel panel-success" style='padding: 0px;margin:0 auto;width:100%;'>
          <div class="panel-heading" style='padding: 5px;height:30px;'>
             <h4 style='margin:0px;padding: 0px;letter-spacing:0px;'>RESUMEN SOBRE LA CANTIDAD ACTUAL DE ESTUDIANTES POR CURSO</h4>
          </div>
          <div class="panel-body" id="resumenEst" style='padding: 0px;'>   
            <?php 
                $listaCursos = $objGrad->cargarCursos();
            ?>
            <table class='table table-striped' style='border:1px solid rgba(190,220,240,0.4);margin:0px;'>        
                <tr>
                    <th style='text-align:left;border:1px solid rgba(190,220,240,0.4);'>CURSOS</th>
                    <?php 
                        foreach ($listaCursos as $curso) {
                            echo "<th style='text-align:center;width:35px;padding:0px;font-size:10px;border:1px solid rgba(190,220,240,0.4);vertical-align:middle;'>".$curso['CODGRADO']."° ".$curso['grupo']."</th>";
                        }
                     ?>
                </tr>        
                <tr style=''>
                    <th style='text-align:left;font-size:11px;'>CANT. ESTUDIANTES</th>
                    <?php 
                        foreach ($listaCursos as $curso) {
                            $objMatricula = new Matricula();
                            $cantidad = $objMatricula->numeroEstudiantes($curso['codCurso'],$_POST['sede'],date("Y"));
                            echo "<td style='text-align:center;font-size:10px;border:1px solid rgba(190,220,240,0.4);vertical-align:middle;'>".$cantidad."</td>";
                        }
                    ?>           
                </tr> 
            </table>                                     
          </div>
        </div>
    </div>
</div>