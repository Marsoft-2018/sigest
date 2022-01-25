<?php    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    require 'PHPMailer/Exception.php';
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';

    class Enviar{
        public $url;
        public $fecha;
        public $para;
        public $asunto;
        public $mensaje;
        public function iniciar(){
            $mail = new PHPMailer(true);
            
            try {
                //Server settings
                $mail->SMTPDebug = 0;                     
                $mail->isSMTP();  
                $mail->Host       = 'mail.colegiosanrafael.com.co';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'soporte@colegiosanrafael.com.co';
                $mail->Password   = 'sigest2021**';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;
            
                //Recipients
                $mail->setFrom('soporte@colegiosanrafael.com.co', 'Sigest');
                $mail->addAddress($this->para); 
                $mail->addAddress('soporte@colegiosanrafael.com.co'); 
                /*
                //Attachments
                $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
                */
            
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = $this->asunto;
                $mail->Body    = $this->mensaje;
                //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            /*
                $mail->send();
                echo 'Message has been sent'; */
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
            }
        }
    }
