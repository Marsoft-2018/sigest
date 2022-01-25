<?php
    require("conBDT.php");
    class Usuario extends Conectar{
        function cargar(){
            $consulta=mysql_query("SELECT * FROM USUARIOS");
	 
            $total_usuarios=mysql_num_rows($consulta);
            $total_filas=ceil($total_usuarios/3);
            $cont=0;
            
            $consulta=mysql_query("SELECT * FROM usuarios  ORDER BY idUsuario ");
            
            echo    "<table class='table table-striped tarjeton' style='width:60%;'>";
	
            echo    "<thead>";
            echo        "<tr><td colspan='6' ><h1>ACTUALIZAR USUARIOS</h1></td></tr>";
            echo        "<tr>";
            echo            "<td colspan='7'><a href='#' class='btn btn-primary' id='usuario' onclick='ventanaNuevo(this.id)'>";
            echo                "<i class='fa fa-plus-circle'> </i> Nuevo Usuario</a>";
            echo            "</td>";
            echo        "</tr>";
            echo        "<tr><th>ID</th><th>CONTRASEÑA</th><th>NOMBRE COMPLETO</th><th>ROL</th><th>ESTADO</th><th colspan='2' aling='center'>Acciones</th></tr>  ";  
            echo    "</thead>";
            echo    "<tbody>";
            while ($candidato=Mysql_fetch_array($consulta)){            	
                echo "<tr style='font-size:10px;'>";											

                echo    "<td><input type='text' id='usuario:$candidato[0]' value='".$candidato[0]."'></td>";
                echo    "<td><input type='text' id='contrasena:$candidato[0]' value='".$candidato[1]."'></td>";
                echo    "<td><input type='text' id='nombre:$candidato[0]' value='".$candidato[2]."'></td>";	
                echo    "<td>";
                echo        "<select id='rol:$candidato[0]' >";
                echo        "<option value='$candidato[3]'>$candidato[3]</option>";
                            if($candidato[3]=="ADMINISTRADOR"){
                                echo    "<option value='JURADO'>JURADO</option>";                
                            }else{
                                echo    "<option value='ADMINISTRADOR'>ADMINISTRADOR</option>";
                            }
                //    echo $candidato[3]."</td>";
                echo        "</select>";
                echo    "</td>";
                echo    "<td>";
                echo        "<select id='estado:$candidato[0]' >";
                echo        "<option value='$candidato[4]'>$candidato[4]</option>";
                            if($candidato[4]=="Activo"){
                                echo "<option value='Inactivo'>Inactivo</option>";                
                            }else{
                                echo "<option value='Activo'>Activo</option>";
                            }
                echo        "</select>";
                echo    "</td>";
                echo "</td>";
                $cont=$cont+1;
                echo "<td><a href='#' class='btn btn-success' id='$candidato[0]' onclick='editarUsu()' title='Editar'><i class='fa fa-pencil'> </i></a></td>";
                echo "<td><a href='#' class='btn btn-danger' id='$candidato[0]' onclick='eliminarUsu(this.id)' title='Eliminar usuario'><i class='fa fa-trash-o'> </i></a></td>";
                echo "</tr>";
            }
            
            echo    "</tbody>";
            echo    "<tfoot>";
            echo        "<tr>";
            echo            "<td colspan='7'><a href='#' class='btn btn-primary' id='usuario' onclick='ventanaNuevo(this.id)'>";
            echo                "<i class='fa fa-plus-circle'> </i> Nuevo Usuario</a>";
            echo            "</td>";
            echo        "</tr>";
            echo    "</tfoot>";
            echo  "</table>";
        }//OK
        
        function cantMin(){
            $sqlBusqueda = mysql_query("SELECT ROL FROM usuarios WHERE ESTADO='Activo'");
            $cant=mysql_num_rows($sqlBusqueda);
            return $cant;
        } //OK
        
        function Guardar($idUsuario,$contrasena,$nombreC,$rol,$estado,$institucion){
            mysql_query("INSERT INTO `personeros`.`usuarios` (`idUsuario`, `contrasena`, `NOMBRE`, `ROL`, `ESTADO`, `Institucion_idInstitucion`) VALUES ('$idUsuario','$contrasena','$nombreC','$rol','$estado','$institucion');");
            
        }
        function eliminar($id){
            $cant = $this->cantMin();
            if($cant>1){
                mysql_query("DELETE FROM usuarios WHERE idUsuario='$id'");
            }else{
                echo "<div class='alert alert-dismissable alert-danger' style='width:60%;margin:0 auto;'>";
                echo    "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
                echo    "<h4>Advertencia!</h4>";
                echo    "<p>No se puede eliminar el usuario porque es el único en la base de datos</p>";
                echo "</div>";
            }            
        }//OK
        
        function actualizar($tabla, $campo, $clave, $valor){
            
        }
    }

?>