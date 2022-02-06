<?php
    $opcion = "agregarGrado()";
    $CODNIVEL = "";
    $CODGRADO = "";
    $NOMGRADO = "";
    $nomCampo = "";
    $estiloDesempeno = "";
    if(isset($_POST['CODGRADO'])){
        $CODGRADO = $_POST['CODGRADO'];
        $objGrado = new Grado();
        $objGrado->CODGRADO = $CODGRADO;
        foreach ($objGrado->cargar() as $grado) {
            $CODNIVEL = $grado["CODNIVEL"];
            $NOMGRADO = $grado["NOMGRADO"];
            $nomCampo = $grado["nomCampo"];
            $estiloDesempeno = $grado["estiloDesempeno"];
            $opcion = "modificarGrado('".$CODGRADO."')";
        }
    }

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 form-group">
            <label for="exampleInputEmail1">Nivel</label>
            <select id="idNivel"  class="form-control" required">
                <option value="">Seleccione..</option>
                <?php
                    $objNivel = new Nivel();
                    $objNivel->idInst = $_SESSION['institucion'];

                    foreach ($objNivel->listar() as $key => $nivel) { ?>
                        <option value="<?php echo $nivel['CODNIVEL']; ?>" <?php if($nivel['CODNIVEL'] == $CODNIVEL){ echo 'selected'; } ?> ><?php echo $nivel['NOMBRE_NIVEL'] ?></option>
                    <?php
                    }                                                   
                ?>                    
            </select>
        </div>   
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-5 col-lg-5 form-group">
            <label for="exampleInputEmail1">Código</label>
            <input type="number" class="form-control" name="CODGRADO" id="CODGRADO" aria-describedby="codigohelp" value="<?php echo $CODGRADO ?>">
            <small id="codigohelp" class="form-text text-muted">Enumero los grados en orden de prioridad</small>
        </div>
        <div class="col-sm-12 col-md-7 col-lg-7 form-group">
            <label for="exampleInputPassword1">Nombre</label>
            <input type="text" class="form-control" name="NOMGRADO" id="NOMGRADO" placeholder="Ingrese aquí el nombre del grado" list="listaGrados" value="<?php echo $NOMGRADO ?>" >
            <datalist id="listaGrados">
                <option value="PRIMERO">
                <option value="SEGUNDO">
                <option value="TERCERO">
                <option value="CUARTO">
                <option value="QUINTO">
                <option value="SEXTO">
                <option value="SEPTIMO">
                <option value="OCTAVO">
                <option value="NOVENO">
                <option value="DECIMO">
                <option value="UNDECIMO">
            </datalist>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-5 form-group">
            <label for="nomCampo">Abreviatura</label>
            <input type="text" class="form-control" name="nomCampo" id="nomCampo" placeholder="Abreviatura" value="<?php echo $nomCampo ?>">
        </div>
        <div class="col-sm-12 col-md-7 col-lg-7 form-group">
            <label for="estiloDesempeno">Estilo desempeño</label>
            <select name="estiloDesempeno" id="estiloDesempeno" class="form-control" required>
                <option value="">Seleccione..</option>
                <option value="CONCEPTO" <?php if($estiloDesempeno == 'CONCEPTO'){ echo 'selected'; }?>>CONCEPTO</option>
                <option value="ICONO" <?php if($estiloDesempeno == 'ICONO'){ echo 'selected'; }?>>ICONO</option>
                <option value="AMBOS" <?php if($estiloDesempeno == 'AMBOS'){ echo 'selected'; }?>>AMBOS</option>                                     
            </select> 
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <button type="button" id="btnAjgrado" class="btn btn-primary" style="font-size: 1.2em; padding: 10px; width: 100%; box-sizing: border-box;" onclick="<?php echo $opcion ?>"><i class="fa fa-plus"></i> Guardar</button>
        </div>
        <div class="col-md-6">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="font-size: 1.2em; padding: 10px; width: 100%; box-sizing: border-box;">Cancelar</button>
        </div>
    </div> 
    <hr>
    <div id="respuestasGrados"></div>  
</div>