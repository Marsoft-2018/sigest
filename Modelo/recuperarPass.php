<?php
    //require_once ("Conect.php");
    include ("../Controladores/encript.php");
    class Contrasena extends ConectarPDO{
        public $correo;
        public $usuario;
        public $nombre;
        public $token;
        public $rol;
        public $estado;
        private $sql;

        public function validar() {
            $con = false;
            $this->sql = "SELECT correo AS email FROM t_users u WHERE u.usuario = ? AND estado = 1 UNION SELECT email FROM profesores p WHERE p.idUsuario = ? AND estado = 'Activo'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindParam(1,$this->usuario);
                $stm->bindParam(2,$this->usuario);
                $stm->execute();
                $num = $stm->fetchAll(PDO::FETCH_ASSOC);
                foreach ($num as $value) {                    
                    $con = true;
                }                
                return $con;                               
            } catch (Exception $e) {
                echo "Error en la validacion. ".$e;
            }
        }

        public function datosUsuario(){
            $this->sql = "SELECT u.correo,u.rol,u.nombre FROM t_users u WHERE u.usuario = '".$this->usuario."' UNION SELECT p.email, p.Rol, CONCAT(p.PrimerNombre,' ', p.SegundoNombre,' ', p.PrimerApellido,' ', p.SegundoApellido) AS nombre FROM profesores p WHERE p.idUsuario = '".$this->usuario."' ;";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);               
                return $datos;
            } catch (Exception $e) {
                echo "Error en la validacion. ".$e;
            }   
        }

        public function generarToken(){
            $this->token = $this->getToken($this->rol,$this->usuario);
            if ($this->token == "") {
                $conjuntoLetras = ["!","#","$","%","&","(",")","*","+",",","-",".","/","0","1","2","3","4","5","6","7","8","9",":",";","<","=",">","?","@","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","[","]","^","_","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"];

                $cadena = "";

                for ($i=0; $i < 20 ; $i++) { 
                    $cadena .= $conjuntoLetras[rand(0,85)];
                }
                $this->token = SED::encryption($cadena);    
            }
                    
            if ($this->rol == "Profesor") {
                $this->sql ="UPDATE profesores SET token = '".$this->token."', token_estado = 1 WHERE idUsuario = '".$this->usuario."' AND estado = 'Activo'";
            }elseif($this->rol == "Administrador"){
                $this->sql ="UPDATE t_users SET token = '".$this->token."', token_estado = 1 WHERE usuario = '".$this->usuario."' AND estado = 1";         
            }

            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                return $this->token;
            } catch (Exception $e) {
                echo "error al guardar los datos: ".$e;
            }
        }

        public function getToken($rol,$usuario){
            $token = "";
            if ($rol == "Profesor") {
                $this->sql ="SELECT token FROM profesores WHERE idUsuario = '".$usuario."' AND  token_estado = 1";
            }elseif($rol == "Administrador"){
                $this->sql ="SELECT token FROM t_users WHERE usuario = '".$usuario."' AND token_estado = 1 ";         
            }

            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $Rtoken = $stm->fetchAll(PDO::FETCH_ASSOC);
                foreach ($Rtoken as $value) {
                    $token = $value['token'];
                }
                return $token;
            } catch (Exception $e) {
                echo "error al guardar los datos: ".$e;
            }
        }

        public function reestablecer(){
            $this->contrasena = SED::encryption($this->contrasena);
            if ($this->rol == "Profesor") {
                $this->sql ="UPDATE profesores SET Password = '".$this->contrasena."', token_estado = 0  WHERE idUsuario = '".$this->usuario."' AND token = '".$this->token."' AND token_estado = 1";
            }elseif($this->rol == "Administrador"){
                $this->sql ="UPDATE t_users SET password = '".$this->contrasena."', token_estado = 0  WHERE usuario = '".$this->usuario."' AND token = '".$this->token."' AND token_estado = 1";         
            }
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
            } catch (Exception $e) {
                echo "error al guardar los datos: ".$e;
            }
        }

        public function enviarEmail($usuario,$nombre,$correo,$token){
            

            $url = "http://".$_SERVER['SERVER_NAME'].'/sigest/vistas/usuarios/reestablecerPass.php?us='.$usuario.'&tkn='.$token;
            $fecha = date("D-M-y H:i");
            $mensaje = '
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml">
                    <head>
                      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                      <meta name="viewport" content="width=device-width, initial-scale=1" />
                      <title>Confirm Email</title>
                      <link rel="preconnect" href="https://fonts.googleapis.com">
                      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                      <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
                        <style>
                            body {
                              font-family: "Roboto", sans-serif;
                                -webkit-font-smoothing:antialiased;
                                -webkit-text-size-adjust:none;
                                width: 100%;
                                height: 100%;
                                color: #37302d;
                                background: #ffffff;
                              }
                            
                              h1, h2, h3 {
                                padding: 0;
                                margin: 0;
                                color: #444444;
                                font-weight: 400;
                                line-height: 110%;
                              }
                
                            .card{
                              width: 18rem;
                              border: 1px solid #cacaca;
                              border-radius: 10px;
                              margin: 0 auto;
                
                            }
                
                            .card img{
                              width: 100%;
                              margin-top: 0px;
                
                            }
                
                            .card-body{
                              background-color: #14468A;
                              color: #fafafa;
                              padding: 10px;              
                            }
                
                            .card-body h5{
                              font-size: 1.2em;
                              text-align: center;
                              padding: 0px;   
                              margin: 0px;
                            }
                
                            .card-body p{
                              text-align: left;
                              line-height: 1.5em;
                            }
                
                            .card-body a{
                              text-decoration: none;
                              display: inline-block;
                              text-align: center;
                              color: #fff;
                            }
                
                            .btn {
                              width: 95%;
                              border: 1px solid #cacaca;
                              border-radius: 5px;
                              margin: 0 auto;
                              padding: 8px;
                            }
                
                            .btn-primary{
                              background-color: #21AD0B;
                              transition: 0.5s ease;
                            }
                
                            .btn-primary:hover{
                              cursor: pointer;
                              background-color: #62BC0C;
                            }
                
                
                        </style>
                    </head>
                    <body>
                        <div class="card">
                          <img src="https://colegiosanrafael.com.co/sigest/tools/sigest-n.svg" class="card-img-top" alt="SIGEST">
                          <h5>SISTEMA DE GESTION ACADEMICA - SIGEST</h5>
                          <div class="card-body">
                            <h5 class="card-title"> Hola '.$nombre.'</h5>
                            <p class="card-text">
                            Usted ha solicitado reestablecer su contraseña<br><br>Para continuar con el proceso haga click en el siguiente botón<br><br>
                            </p>            
                            <a class="btn btn-primary" href="'.$url.'">Cambiar contraseña</a>
                          </div>
                        </div>
                    </body>
                </html>';
            require "enviar.php";
            
            $obj = new Enviar();
            $obj->para = $correo;
            
            $obj->url = $url;
            $obj->fecha = date("D-M-y H:i");
            $obj->asunto = "Restablecer contraseña - Sistema de Gestión Académica";
            $obj->mensaje = $mensaje;
            
            $obj->iniciar();
            
            
            /*
            $mail = new PHPMailer(true);
            
            try {
                //Configurar acceso a la cuenta de correo
                $mail->isSMTP();
                $mail->SMTPDebug = 0;
                $mail->Host = "mail.colegiosanrafael.com.co"; //servidor del correo para ejemplo gmail
                $mail->Port = 465; 
                $mail->SMTPSecure = 'tls';
                $mail->SMTPAuth = true;
                $mail->UserName = "soporte@colegiosanrafael.com.co"; //usuario de correo del cpanel
                $mail->Password = "sigest2021**"; //contrseña de ese correo

                //configurar el envio 
                $mail->setFrom('soporte@colegiosanrafael.com.co',"Gestion Académica - Sigest"); //Desde donde se enviara debe ser el mismo correo del acceso inicial
                $mail->addAddress($correo,$nombre); //correo destino

                //Contenido del correo
                $mail->IsHTML(true);
                $mail->Subject = $asunto;
                $mail->Body = $mensaje;
                if ($mail->send()) {
                    $texto = "A su correo $para hemos enviado un mensaje para que reestablesca su cotraseña";
                    $datos = array("estado"=>true,"mensaje"=>$texto);
                    echo json_encode($datos);    
                }else{
                    $texto = "Error no se pudo enviar el mensaje a su correo $para, por favor intentelo nuevamente, de persistir el error pongase en contacto con el administrador del sistema.";
                    $datos = array("estado"=>false,"mensaje"=>$texto);
                    echo json_encode($datos);    
                }                            
            } catch (Exception $e) {
                $texto = "Error no se pudo enviar el mensaje a su correo $para, por favor intentelo nuevamente, de persistir el error pongase en contacto con el administrador del sistema.";
                $datos = array("estado"=>false,"mensaje"=>$texto);
                echo json_encode($datos);      
            }*/
        }

        public function modificar(){
            $this->sql = "";
            $this->contrasena = SED::encryption($this->contrasena);
            switch ($this->rol) {
                case 'Profesor':
                    $this->sql = "UPDATE profesores SET Password = '".$this->contrasena."' WHERE idUsuario = '".$this->usuario."' ";
                    break;
                case 'Administrador':
                    $this->sql = "UPDATE t_users SET password = '".$this->contrasena."' WHERE usuario = '".$this->usuario."'";
                    break;
                case 'Coordinador':
                    $this->sql = "UPDATE t_users SET password = '".$this->contrasena."' WHERE usuario = '".$this->usuario."'";
                    break;
                case 'Estudiante':                
                    $this->sql = "UPDATE estudiantes SET Password = '".$this->contrasena."' WHERE Documento = '".$this->usuario."' ";
                    break;
            }
            if ($this->sql != "") {
                try {
                    $stm = $this->Conexion->prepare($this->sql);
                    $stm->execute();
                    echo "Contraseña modificada con éxito";
                } catch (Exception $e) {
                    echo "error al guardar los datos: ".$e;
                }
            }else{
                echo "Error Consulta vacia:<br> no existe un rol definido<br>";
                // echo "<br>Rol: ".$this->rol;
                // echo "<br>Usuario: ".$this->usuario;
                // echo "<br>Contraseña: ".$this->contrasena;
                // echo "<br>Sql: ".$this->sql;
            }
        }
    }
    
      //$objUsu = new Contrasena();
      //$objUsu->setDatos('Admin','123456');
      //echo $objUsu->generarToken();
?>