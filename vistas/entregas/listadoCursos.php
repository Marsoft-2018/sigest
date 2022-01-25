<?php 
if (isset($_POST['sede'])) {  
    session_start();  
    require('../../Modelo/Conect.php');
    require("../../Modelo/curso.php");  
    require("../../Modelo/entregaDeInformesPeriodo.php");

    $objCurso = new Curso();
    $objCurso->codSede = $_POST['sede'];

    $periodo =  $_POST['periodo'];
    $accion = "";
    $activo = "disabled";
}
   
?>
    <div class="row">
        <div class="container">
            <div class="col-md-12">
                <h3>Programar una misma fecha para todos los cursos</h3>            
                <div class="form-group row">
                    <label class="control-label col-md-2 col-sm-2 ">Fecha:</label>
                    <div class="col-md-3 col-sm-3 ">
                        <input type="date" class="form form-control" id="fechaAll" value="<?php echo date('Y-m-d') ?>" require>
                    </div>
                    <div class="col-md-4 col-sm-4 ">
                        <button class="btn btn-primary" type="button" onclick="fechaParaTodos()">
                            Aplicar
                        </button>                    
                    </div>
                </div> 
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="overflow: auto;">
            <table id="listadoProfe" class='display table table-striped table-hover no-footer dataTable' style="border:1px solid #a16520; position: relative;">
                <thead>
                    <tr style='background-color:#a16520;color:#fff;'>
                        <th>No.</th>
                        <th colspan="2">Curso</th>
                        <th>Fecha de entrega</th>
                        <th colspan="3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $cont = 1;
                    foreach ($objCurso->listaXsedes() as $curso) {  
                        $accion = 'guardarEntregaInformePeriodo('.$curso['codCurso'].','.$periodo .','.$_POST['anho'].')';         
                        $fecha = "";
                        $fechaCierre  = "";
                        $objEntrega = new entregaDeInformesPeriodo();
                        $objEntrega->periodo = $periodo;
                        $objEntrega->anho = $_POST['anho'];
                        $objEntrega->curso = $curso['codCurso'];
                        foreach ($objEntrega->cargar() as $value) {
                            $fecha = $value['fecha'];
                            $accion = 'modificarEntregaInformePeriodo('.$curso['codCurso'].','.$periodo.','.$_POST['anho'].')';    
                            $activo = "";
                        }
                    ?>
                    <tr >
                        <td  style="text-align:center; color:#cecece; margin:0px; padding:0px;"> <?php echo $cont ?></td>
                        <td style="color:#000000; margin:0px; padding:0px; width:50%;">
                            <?php echo $curso['NOMGRADO']." - ".$curso['grupo'] ?>                
                        </td>
                        <td style="color:#000000; margin:0px; padding:0px; width:50%;">
                            <?php echo $curso['CODGRADO']."° ".$curso['grupo'] ?>                
                        </td>
                        <td style="color:#000000; margin:0px; padding:0px;">
                            <input type="date" class="form form-control" 
                            name = "<?php echo $curso['codCurso'] ?>"
                            id="FI<?php echo $curso['codCurso'] ?>" 
                            value="<?php echo $fecha ; ?>" onchange="activarGuardar(this.name)">
                        </td> 
                        <td  style="margin:0px; padding:0px; width: 40px;">
                            <button class="btn btn-success" 
                                id="add<?php echo $curso['codCurso'] ?>" 
                                onclick="<?php echo $accion ?>"
                                <?php echo $activo ?>
                            >
                                <i class="fa fa-save"></i>
                            </button>
                        </td>
                        <td  style="margin:0px; padding:0px;width: 40px;">
                            <button class="btn btn-info" 
                                id="exe<?php echo $curso['codCurso'] ?>" 
                                onclick="listarEstudiantesEntrega(<?php echo $curso['codCurso'] ?>,<?php echo $periodo ?>,<?php echo $_POST['anho'] ?>)" 
                                <?php echo $activo ?>
                            >
                                <i class="fa fa-thumb-tack"></i>
                            </button>
                        </td>
                        <td  style="margin:0px; padding:0px; width: 40px;">
                            <button class="btn btn-danger" 
                                id="rem<?php echo $curso['codCurso'] ?>" 
                                onclick="eliminarEntregaInforme(<?php echo $curso['codCurso'] ?>,<?php echo $periodo ?>,<?php echo $_POST['anho'] ?>)"
                                <?php echo $activo ?>
                            >
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php 
                        $cont++;
                        $activo = "disabled";
                    }
                    ?>
                </tbody> 
            </table> 
        </div>
    </div>
    