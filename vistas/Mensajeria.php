<?php
    require('../class/Usuarios.php');
    $tabla=$_POST['tabla'];
    $accion=$_POST['accion'];
    if($accion=='cambiarContrasena'){
        if($tabla==1){
            $clave=$_POST['clave'];
            $valor=$_POST['valor'];
            $contrasenaActual=$_POST['contrasenaActual'];
            $perfil=new Usuario();
            $contra=$perfil->contrasena($clave,$tabla);            
            if($contrasenaActual==$contra){                
                $perfil->modificarContrasenaAdministrador($clave,$valor);
            }else{
                echo "<div class='alert alert-danger alert-dismissable'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                            No coinciden los datos, contraseña no actualizada.
                        </div>";
            }
        }
        if($tabla==2){
            $clave=$_POST['clave'];
            $valor=$_POST['valor'];
            $contrasenaActual=$_POST['contrasenaActual'];
            $perfil=new Usuario();
            $contra=$perfil->contrasena($clave,$tabla);
            
            if($contrasenaActual==$contra){                
                $perfil->modificarContrasenaProfesor($clave,$valor);
            }else{
                echo "<div class='alert alert-danger alert-dismissable'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                            No coinciden los datos, contraseña no actualizada.
                        </div>";
            }           
        }
    }

    if($accion=='modificarPerfil'){
        if($tabla==1){
            $campo=$_POST['campo'];
            $clave=$_POST['clave'];
            $valor=$_POST['valor'];
            //echo "esta en las acciones de la tabla administrar y se reciben la variables<br>Campo: $campo<br>Clave: $clave<br>Valor: $valor";
            $perfil=new Usuario();
            $perfil->modificarAdministrador($clave,$campo,$valor);
        }
        if($tabla==2){
            $campo=$_POST['campo'];
            $clave=$_POST['clave'];
            $valor=$_POST['valor'];
            //echo "esta en las acciones de la tabla administrar y se reciben la variables<br>Campo: $campo<br>Clave: $clave<br>Valor: $valor";
            $perfil=new Usuario();
            $perfil->modificarProfesor($clave,$campo,$valor); 
        }
        if($tabla==3){

        }
    }
?>