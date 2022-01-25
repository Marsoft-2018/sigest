<!Doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=yes">
	<!-- Estilos CSS -->
    <link href="../../css/bootstraps3.1.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../font-awesome/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="../../css/animate.css">
    <title>SiGest | Recuperar Contraseña</title>
    <link rel="icon" href="../../tools/sigest-ico.svg" />  
<style>
    body{
        background-color: rgba(200,206,250,0.9);
    }
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
        border: 4px solid #fff;
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
    .bloqueo{
        position:absolute;
        width:100%;
        height:2500px;
        background-color: rgba(34,44,54,0.8);
        z-index:5;
        display:none;
        margin:0px auto;
        
        padding-top:50px;
        text-align:center;
        /*text-shadow: 0px 1px 5px rgba(153,153,153,1);*/
        vertical-align:central;
    }

    .carga{
        margin-left: 43%;
        margin-top: 15%;
        background-color: #fff;
        border-radius: 50%;
        border: 2px solid rgba(100,154,160,0.5); 
        box-shadow: 0px 0px 20px rgba(255,255,255,0.6);
        padding: 5px;
        width: 170px;
        height: 170px;

    }

    .carga img{
        width: 100%;
    }

    label{
        text-align: left;
    }
</style>
</head>
<body oncontextmenu="return false"  style="background-image: url('../../tools/textu1.png');">
        <div class="bloqueo" id = "bloquear">
          <div class="carga">
            <img alt="Cargando..." src="../../estilosCSS/load.gif" >
          </div>
        </div>
    	<div class="panelExterno" style=''>
    	    <div class="panel-body" style='margin:50px;'>
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4 ">
                        <div class="panelInterno">
                            <div class='panel-heading' style="margin:0px;">
                                <h3 class="titulo">RECUPERAR CONTRASEÑA</h3>
                            </div>
                            <div class="panel-body" style="margin:0px;">
                                <div class="row" style="margin-top:0px;">
                                    <div class="col-md-12">
                                        <form name='formulario' method='post' action='' onsubmit='return recuperar()' id='frmLogin' target="_self" class="animated zoomIn">
                                            <label for="">Usuario</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                <input type="text" class="form-control" placeholder="Por favor ingrese aquí su Nombre de usuario" id="usuario" required="required">
                                            </div>                                     
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
                            </div>
                            <h5 style="text-align: center;">
                                <a href="../../index.php">Regresar</a>
                            </h5>
                        </div>
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>
    	</div>
	
    <footer class="main-footer" style="padding-left:10px;">
        <div class="pull-right hidden-xs" style="padding-right: 10px;">
          <b>Version</b> 3.0
            <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/">
                  <div class="panel-footer" style="padding:0px;">
                        <span class="pull-left" style="font-size:9px;">
                            Este Sistema está bajo una Licencia CC-BY-NC-ND 4.0 
                            <i class="fa fa-arrow-circle-right"></i>
                        </span>
                        <div class="clearfix"></div>
                  </div>
            </a>
            <div>
                <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/">
                    <img alt="Licencia Creative Commons" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-nd/4.0/88x31.png" />
                </a>
            </div>
        </div>
        <strong>Copyright &copy; 2018 <a href="http://marsoft-sas.com">Ing. Jose Alfredo Tapia</a>.</strong>
        Todos los derechos reservados.<br>
        cel: 3107358169<br>
        El Carmen de Bolívar -- Colombia
      </footer>
    <script src="../../complementos/Jquery/jquery-3.4.1.js"></script>

    <!-- Bootstrap , datatables y alertify -->
    <script src="../../js/bootstrap.min.js"></script>
    <script type="text/javascript">
        function recuperar() {
            var usuario = $("#usuario").val();
            var accion = "recuperar";
            $.ajax({
                type:"POST",
                data:{accion:accion, usuario:usuario},
                url:"../../Controladores/ctrlContrasenas.php",
                beforeSend: function(){
                    $('#bloquear').slideDown('fast');
                },
                success:function(respuesta){
                    respuesta = JSON.parse(respuesta);
                    //console.log('test: '+respuesta.resultado);
                    if(respuesta.estado){
                        $("#mensaje").html(""+respuesta.mensaje).removeClass("alert-danger").addClass("alert-success animated zoomIn").show('fast');
                    }else{
                        $("#mensaje").html(""+respuesta.mensaje).removeClass("alert-success").addClass("alert-danger animated zoomIn").show('fast');
                    }
                    //console.log(respuesta);
                    $("#bloquear").slideUp("fast");
                }
            });
            return false;
        }
    </script>
</body>
</html>