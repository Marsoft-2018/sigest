<?php
    $opcion = "agregarNivel()";    
    $CODNIVEL = "";
    $NOMBRE_NIVEL = "";
    $orden = "";
    
    if(isset($_POST['CODNIVEL'])){
        $CODNIVEL = $_POST['CODNIVEL'];
        $objNivel = new Nivel();
        $objNivel->CODNIVEL = $CODNIVEL;
        foreach ($objNivel->cargar() as $Nivel) {
            $CODNIVEL = $Nivel["CODNIVEL"];
            $NOMBRE_NIVEL = $Nivel["NOMBRE_NIVEL"];
            $orden = $Nivel["orden"];
            $opcion = "modificarNivel('".$CODNIVEL."')";
        }
    }

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-6 form-group">
            <label for="exampleInputPassword1">Nombre</label>
            <input type="text" class="form-control" name="NOMBRE_NIVEL" id="NOMBRE_NIVEL" placeholder="Ingrese aquí el nombre del Nivel" list="listaNiveles" value="<?php echo $NOMBRE_NIVEL ?>" >
            <datalist id="listaNiveles">
                <option value="PREESCOLAR">
                <option value="BASICA PRIMARIA">
                <option value="BASICA SECUNDARIA">
                <option value="MEDIA VOCACIONAL">
                <option value="CICLO I">
                <option value="CICLO II">
                <option value="CICLO III">
                <option value="CICLO IV">
                <option value="CICLO V">
                <option value="CICLO VI">
            </datalist>
        </div>
        <div class="col-sm-12 col-md-3 col-lg-3 form-group">
            <label for="exampleInputEmail1">Abreviatura/Código</label>
            <input type="text" class="form-control" name="CODNIVEL" id="CODNIVEL" aria-describedby="codigohelp" value="<?php echo $CODNIVEL ?>">
            <small id="codigohelp" class="form-text text-muted">Ingrese una abreviatura única para cada nivel</small>
        </div>
        <div class="col-sm-12 col-md-3 form-group">
            <label for="orden">Orden de prioridad</label>
            <input type="number" class="form-control" name="orden" id="orden" value="<?php echo $orden ?>">
            <small id="codigohelp" class="form-text text-muted">Enumere los niveles en orden de prioridad</small>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <button type="button" id="btnAjNivel" class="btn btn-primary" style="font-size: 1.2em; padding: 10px; width: 100%; box-sizing: border-box;" onclick="<?php echo $opcion ?>"><i class="fa fa-plus"></i> Guardar</button>
        </div>
        <div class="col-md-6">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="font-size: 1.2em; padding: 10px; width: 100%; box-sizing: border-box;">Cancelar</button>
        </div>
    </div> 
    <hr>
    <div id="respuestasNiveles"></div>  
</div>