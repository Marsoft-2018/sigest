<?php
    $opcion = "agregarDesempeno()";
    $emoticon = "";
    $idDes = "";
    $CONCEPT = "";
    $limiteInf = "";
    $limiteSup = "";
  
    if(isset($_POST['idDes'])){
        $idDes = $_POST['idDes'];
        $objDesempeno = new Desempenos();
        $objDesempeno->idDes = $idDes;
        foreach ($objDesempeno->load() as $Desempeno) {
            $CONCEPT = $Desempeno["CONCEPT"];
            $limiteInf = $Desempeno["limiteInf"];
            $limiteSup = $Desempeno["limiteSup"];
            $emoticon = $Desempeno["emoticon"];
            $opcion = "modificarDesempeno('".$idDes."')";
        }
    }  /**/

?>
<form id="formDesempenos" action="" method="post" enctype="multipart/form-data">
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-5 col-lg-5 form-group">
            <label for="exampleInputEmail1">Código</label>
            <input type="number" class="form-control" name="idDes" id="idDes" aria-describedby="codigohelp" value="<?php echo $idDes ?>" readonly="true">
        </div>
        <div class="col-sm-12 col-md-7 col-lg-7 form-group">
            <label for="exampleInputPassword1">Nombre/concepto</label>
            <input type="text" class="form-control" name="CONCEPT" id="CONCEPT" placeholder="Ingrese aquí el nombre del Desempeno" list="listaDesempenos" value="<?php echo $CONCEPT ?>" required>
            <datalist id="listaDesempenos">
                <option value="BAJO">
                <option value="BASICO">
                <option value="ALTO">
                <option value="SUPERIOR">
            </datalist>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-5 form-group">
            <label for="limiteInf">Limite Inferior</label>
            <input type="number" class="form-control" name="limiteInf" id="limiteInf" value="<?php echo $limiteInf ?>">
            <small id="codigohelp" class="form-text text-muted">Enumero los Desempenos en orden de prioridad</small>
        </div>
        <div class="col-sm-12 col-md-7 col-lg-7 form-group">
            <label for="limiteSup">Limite Superior</label>
            <input type="number" class="form-control" name="limiteSup" id="limiteSup" value="<?php echo $limiteSup ?>" required>
            <small id="codigohelp" class="form-text text-muted">Enumero los Desempenos en orden de prioridad</small>
        </div>
    <div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12 form-group">
        <label for="exampleInputEmail1">Icono/Imagen</label>
        <?php if($emoticon != ""){ ?>
        <img src="vistas/img/desempenos/<?php echo $emoticon ?>" id="ft<?php echo $idDes ?>" width="25" height="25" title="cambiar imágen" class="iconosAcciones" onclick="cambiarEmoticon(this.id)"></img>
        <?php } else{ ?>
        <?php } ?>
            <div id="preview">
                <img src="" alt="" id="previewImagen" width="100">
            </div>      
        <input type="file" name="emoticon" id="emoticon" class="form form-control" onchange="previewIcono()">
    </div>   
    </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <button type="button" id="btnAjDesempeno" class="btn btn-primary" style="font-size: 1.2em; padding: 10px; width: 100%; box-sizing: border-box;" onclick="<?php echo $opcion ?>"><i class="fa fa-plus"></i> Guardar</button>
        </div>
        <div class="col-md-6">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="font-size: 1.2em; padding: 10px; width: 100%; box-sizing: border-box;">Cancelar</button>
        </div>
    </div> 
    <hr>
    <div id="respuestasDesempenos"></div>  
</div>
</form>