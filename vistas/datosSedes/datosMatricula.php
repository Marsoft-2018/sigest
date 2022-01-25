<?php 
    $accion = "";
    $curso = "";
    $NombreAcudiente = "";
    $barrioAcudiente = "";
    $direccionAcudiente = "";
    $celAcudiente = "";
    $correoAcudiente = "";
    $idMatricula = "";
    $motivosRetiro = "";
    $fechaRetiro = "";

    if(isset($_POST['accion'])){
        $accion = $_POST['accion'];
    }

    if($accion == "Nueva") {
        session_start();
        require("../../Modelo/Conect.php");
        require("../../Modelo/sede.php");
        require("../../Modelo/curso.php");
        require("../../Modelo/Estudiante.php");
        require("../../Modelo/matricula.php");
        $objEstudiante = new Estudiante();
        $objEstudiante->Documento = $_POST['Documento'];
        foreach ($objEstudiante->cargar() as $estudiante) {   
            $Documento = $estudiante['Documento'];
            $PrimerNombre   = $estudiante['PrimerNombre'];
            $SegundoNombre   = $estudiante['SegundoNombre'];
            $PrimerApellido = $estudiante['PrimerApellido'];
            $SegundoApellido = $estudiante['SegundoApellido'];
            $foto = $estudiante['foto'];
        }
        echo "<h3>Estudiante: ".$PrimerNombre." ".$SegundoNombre." ".$PrimerApellido." ".$SegundoApellido."</h3>";
    }elseif($accion == "Editar"){
        $curso = $_POST['curso'];
    }
        
    $objMatricula = new Matricula();
    
    if (isset($_POST['Documento'])) {
        $objMatricula->Documento = $_POST['Documento'];                          
    }

    if(isset($_POST['idMatricula'])){
        $idMatricula = $_POST['idMatricula'];
        $fechaIngreso = "00-00-0000";
        $estado = "";
        $objMatricula->idMatricula = $_POST['idMatricula'];
        foreach ($objMatricula->cargar() as $mt) {
            $fechaIngreso = $mt['fechaIngreso'];
            $estado = $mt['estado'];
            $NombreAcudiente = $mt['NombreAcudiente'];
            $barrioAcudiente = $mt['barrioAcudiente'];
            $direccionAcudiente = $mt['direccionAcudiente'];
            $celAcudiente = $mt['celAcudiente'];
            $correoAcudiente = $mt['correoAcudiente'];
            $motivosRetiro  = $mt['MotivoDeRetiro'];
            $fechaRetiro = $mt['fechaRetiro'];
        }
    }

    $sede = $_POST['sede'];
    $anho = $_POST['anho'];

    $objSede = new Sede();
    $objCurso = new Curso();
    $objCurso->codSede = $sede;
?>

    <div class="panel panel-primary">
        <div class="panel-heading" style="padding:2px;height:30px;">
            <h4 style="padding:2px;margin: 0px;">Datos de la Matricula </h4>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-2">
                    <label for="">Año:</label>
                    <input 
                        type = "number" 
                        id = "anhoMatricula" 
                        name = "anho" 
                        value = "<?php echo $anho ?>" class="form-control" 
                    >
                </div>
                <div class="col-md-3" style="margin:0px;padding:0px;">
                    <label for="">Sede:</label>
                    <select 
                        name = "sede" 
                        id = "sedeMatricula" 
                        class="form-control"
                        onchange = "cargarCursosMatricula(this.value)" 
                        required 
                    >
                        <option value="" selected="selected">Seleccione...</option>  
                    <?php 
                        foreach ($objSede->listar() as $datoSede) {
                            $sel = "";
                            if($sede == $datoSede['CODSEDE']){
                                $sel = "selected";
                            }
                            echo "<option value='".$datoSede['CODSEDE']."' $sel>".$datoSede['NOMSEDE']."</option>";
                        }
                    ?>    
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="">Grado y Grupo</label>
                    <select name="cursoMatricula" id="cursoMatricula" class="form-control" required>
                        <option value="" selected="selected">Seleccione...</option>
                        <?php 
                            foreach ($objCurso->listaXsedes() as $resp) {
                                $sele = "";
                                if($curso == $resp['codCurso']){
                                    $sele = "selected";
                                }
                                echo '<option value="'.$resp['codCurso'].'" '.$sele.'>'.$resp['CODGRADO']."°".$resp['grupo'].'</option>';
                            }
                        ?>
                    </select>  
                </div>
                <div class="col-md-2">
                    <label for="">Fecha de Ingreso</label>
                    <input type="date" name="fechaIngreso" id="fechaIngreso" value="<?php echo $fechaIngreso ?>" class="form form-control" title="Ingrese la fecha de ingreso del estudiante a la institución">
                </div> 
                <div class='col-md-3'>
                    <?php 
                        $mostrar = "display:none;";
                    ?>
                    <label for="">Estado:</label>
                    <select id="estado" name="estado" onchange="razonesdeRetiro('<?php echo $idMatricula; ?>',this.value)" class='form-control'>
                        <option value="">Seleccione...</option> 
                        <option value='Retirado' <?php if ($estado == "Retirado") { echo "selected"; $mostrar = ""; } ?>>Retirado</option>
                        <option value='Matriculado' <?php if ($estado == "Matriculado") { echo "selected"; $mostrar = "display:none;";} ?>>Matriculado</option>
                    </select>
                </div>
            </div>
            <div class='row' id='motivosRetiro' style="<?php echo $mostrar; ?>">
                <div class='col-md-9'>
                   Motivo del retiro:
                   <textarea id='txtRetiro' onchange='' class="form form-control" style='height: 100px; width: 100%;'><?php echo $motivosRetiro ?></textarea>
                </div>
                <div class='col-md-3'>
                    <label for="">Fecha de retiro:</label>
                    <input type = 'date' 
                        id = 'fechaRetiro' 
                        onchange = 'modificarMatricula(this.id,this.value)' 
                        value = '<?php echo $fechaRetiro ?>' 
                        class='form-control'
                    >
                    <button class="btn btn-info" 
                        style="margin-top: 10px; margin-bottom: 10px; width: 100%; padding: 5px;" 
                        onclick="retirar(<?php echo $idMatricula; ?>)"
                    >
                        <i class="fa fa-location-arrow"></i> Retirar
                    </button>
                    <div class="progress progress-sm active" id="progreso" style="display: none;">
                        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 90%">
                            <span class="sr-only">90% Complete</span>
                        </div>
                    </div> 
                </div>
            </div>
            <div class='row' >
                <div class='panel panel-default' style='margin:10px;'>
                    <div class='panel-heading' style='padding: 2px;'>
                        <h4 style='margin: 2px;'>Listado de matriculas</h4>
                    </div>
                    <div class='panel-body' style='padding: 5px;padding-left:2px;overflow:auto;text-align:center;' id='listadoMatriculas'>   
                        <?php include("listadoMatriculasEstudiante.php") ?>                   
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading" style="padding:2px;height:30px;">
                        <h4 style="padding:2px;margin: 0px;">
                            Datos de Ubicación y Contacto del Acudiente
                        </h4>
                    </div>
                    <div class="panel-body" style="padding:0px;">                                
                        <div class="row" style="padding:2px;margin:1px;">
                            <div class="col-md-4" style="margin:0px;padding:0px;">
                                Nombres y Apellidos:
                                <input type="text" name="nombreAcudiente" id="nombreAcudiente" value="<?php echo $NombreAcudiente; ?>" class="form-control">                                
                            </div>
                            <div class="col-md-2" style="margin:0px;padding:0px;">
                                Barrio:
                                <input type="Text" name="barrioAcudiente" id="barrioAcudiente" value="<?php echo $barrioAcudiente; ?>" class="form-control">                                
                            </div>
                            <div class="col-md-2" style="margin:0px;padding:0px;">
                                Dirección:
                                <input type="text" name="direccionAcudiente" id="direccionAcudiente" value="<?php echo $direccionAcudiente; ?>" class="form-control">
                            </div>
                            <div class="col-md-2" style="margin:0px;padding:0px;">
                                Celular:
                                <input type="text" name="celAcudiente" id="celAcudiente" value="<?php echo $celAcudiente; ?>" class="form-control">
                            </div>                                    
                            <div class="col-md-2" style="margin:0px;padding:0px;">
                                Correo Electrónico:
                                <input type="email" name="correoAcudiente" id="correoAcudiente" value="<?php echo $correoAcudiente; ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>            
            </div>
            <div class='row' style="<?php if($accion == "Nueva"){ echo "display:block;"; }else{ echo "display:none;"; } ?>">
                <div class='col-md-6'>
                    <iframe name='cuadroDeCarga' style='display:none'></iframe>
                    &nbsp;
                </div>
                <div class='col-md-3'>
                    <button  type="button" id="btnMatricula"
                        class="btn btn-success btnPrincipal" 
                        onclick="addMatricula(<?php echo $_POST['Documento']; ?>)" 
                    >
                        Matricular
                    </button>
                </div>
                <div class='col-md-3'>  
                    <button id='botonCan' data-dismiss="modal" class='btn btn-warning btnPrincipal' > 
                        Cerrar
                    </button>
                </div>                        
            </div>
            <div id="respuesta"></div>
        </div>
    </div> 