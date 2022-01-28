<?php
    //require("../../../Modelo/nivel.php");
?>
<form action="" method="POST" onsubmit="return agregarGrado()">
    <div class="form-group">
        <label for="exampleInputEmail1">Nivel</label>
        <select id="CODNIVEL" required class="form-control">
            <option value="">Seleccione..</option>
            <?php
                /*$objNivel = new Nivel();
                $objNivel->idInst = $_SESSION['institucion'];

                foreach ($objNivel->listar() as $key => $nivel) { ?>
                    <option value="<?php echo $nivel['CODNIVEL'] ?>"><?php echo $nivel['NOMBRE_NIVEL'] ?></option>
                <?php
                }  */                                                  
            ?>                    
        </select>
    </div>    
    <div class="form-group">
        <label for="exampleInputEmail1">Código</label>
        <input type="number" class="form-control" name="CODGRADO" id="CODGRADO" aria-describedby="emailHelp">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Nombre</label>
        <input type="text" class="form-control" name="NOMGRADO" id="NOMGRADO" placeholder="Ingrese aquí el nombre del grado">
    </div>
    <div class="form-group">
        <label for="nomCampo">Abreviatura</label>
        <input type="text" class="form-control" name="nomCampo" id="nomCampo" placeholder="Abreviatura">
    </div>
    <div class="form-group">
        <label for="estiloDesempeno">Estilo desempeño</label>
        <select name="estiloDesempeno" id="estiloDesempeno" class="form-control" required>
            <option value="">Seleccione..</option>
            <option value="CONCEPTO">CONCEPTO</option>
            <option value="ICONO">ICONO</option>
            <option value="AMBOS">AMBOS</option>                                     
        </select> 
    </div>
    <button type="submit" id="btnAjgrado" class="btn btn-primary" style="margin-top:20px;"><i class="fa fa-plus"></i> Guardar</button>
</form>