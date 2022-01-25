<?php
    $usu = $_GET['us'];
    $token = $_GET['tkn'];
?>
<style>
    .panelExterno{
        margin-top:0px;
        height:900px;
        padding-top: 7%;
        background:  rgba(230,230,230,0.2);
    }
    .panelInterno{
        background:  rgba(250,250,250,1);
        box-shadow: 0px 5px 180px  rgba(175,175,175,0.8);
        border-radius: 5px 35px 5px 5px;
        margin:0 auto; 
        position:absolute; 
        width: 100%;
    }
    .titulo{
        border-radius: 5px 20px 0px 0px;
        padding: 20px; 
        text-align: center; 
        margin: 0px;
        margin-top: 5px;
        font-size:25px;
        font-weight:bold;
        background:#098689;
        color:#ffffff;
        font-family:verdana;
    }
    .boton{
        font-size:14px;
        border-radius:10px;
        margin-top: 20px;
        padding: 10px;
        width: 100%;

    }
</style>
</head>

<div class="panelInterno">
    <div class='panel-heading' style="margin:0px;">
        <h3 class="titulo">REESTABLECER CONTRASEÑA</h3>
    </div>
    <div class="panel-body" style="margin:0px;">
        <div class="row" style="margin-top:0px;">
            <div class="col-md-12">
                <form name='formulario' method='post' action='' onsubmit='return reestablecer()' id='frmLogin' target="_self" class="animated zoomIn">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                        <input type="password" class="form-control" placeholder="Nueva Contraseña" id="contrasena" required="required">
                    </div>  
                    <hr>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
                        <input type="password" class="form-control" placeholder="Confirmar Contraseña" id="contrasena2" required="required">
                    </div>                            <input type="hidden" id="usu" value="<?php echo $usu ?>">   
                    <input type="hidden" id="tkn" value="<?php echo $token ?>">        
                    <input type="submit" value="Enviar" name='boton' id='enviar' class="btn btn-success boton" >
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            </div>
        </div>

    </div>
    <div class="panel-footer">
        <div class='row' style="padding:15px;">
           <div class="alert" id='mensaje' style="display: none;"></div>

        </div>
        <h5 style="text-align: center;">
            <a href="../../index.php">Iniciar Sesión</a>
        </h5>
    </div>
</div>
