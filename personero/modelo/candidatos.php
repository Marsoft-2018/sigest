<?php
    require("../../class/Conect.php");
    require("../../class/matricula.php");
    class Candidato extends Conectar{
        function Cargar(){
            echo "<table class='table table-striped tarjeton' style='width:70%;'>";
                    $cont=0;
                    $consulta=mysql_query("SELECT ca.`id`,est.`PrimerNombre`,est.`SegundoNombre`,est.`PrimerApellido`,est.`SegundoApellido`,ft.foto,mt.`idMatricula`
                        FROM candidatos ca
                        INNER JOIN matriculas mt ON mt.`idMatricula` = ca.`idMatricula` 
                        INNER JOIN estudiantes est ON est.`Documento` = mt.`Documento`
                        LEFT JOIN fotoestudiantes ft ON ft.`IDUsuario` = est.`Documento` 
                        INNER JOIN cursos cur ON mt.`Curso`=cur.`codCurso` 
                        WHERE cur.`CODGRADO` = '11' AND mt.`anho`='2018' AND mt.`estado` = 'Matriculado' 
                        ORDER BY  cur.`CODGRADO`,cur.`grupo`,est.PrimerApellido,est.SegundoApellido,est.PrimerNombre,est.SegundoNombre ASC;");
               
            echo    "<thead>";
            echo        "<tr><td colspan='4'><h1>CANDIDATOS REGISTRADOS</h1></td></tr>";
            echo        "<tr class='TITULO' BGCOLOR='#00005B'><td>No.</td><td>NOMBRE COMPLETO</td><td colspan='3'>FOTO</td></tr>";
            echo    "</thead>";
            echo    "<tbody>";
                    while ($candidato=Mysql_fetch_array($consulta)){	
                        echo "<tr> ";													
                        if ($candidato[0]<=9){
                            echo "<TD>0".$candidato[0]."</TD>";
                        }else{
                            echo "<TD >".$candidato[0]."</TD>";
                        }
                        echo "<td><div id='".$candidato[1]."' >".$candidato[2]." ".$candidato[3]." ".$candidato[4]."</div></td>
                        <td><img src='IMG/".$candidato[5]."' width='40' height='40' /></td>";		            
                        echo "</td>";
                        $cont=$cont+1;
                        echo "<td><a href='#' class='btn btn-success' title='Editar datos del Candidato' id='".$candidato[6]."' onclick='ventanaEditarAlumno(this.id)'><i class='fa fa-pencil'> </i></a></td>";
                        echo "<td><a href='#' class='btn btn-danger' id='".$candidato[6]."' onclick='eliminarCandidato(this.id)' title='Elimina el registro del candidato de la base da datos'><i class='fa fa-trash-o'> </i></a></td>";
                        echo "</tr>";					
                    }	        
                
            echo    "<tr><td colspan='4'><a href='#' class='btn btn-primary' id='Candidatos' onclick='cargarNuevoCandidato()'>Nuevo Candidato</a></td></tr>";
            echo    "</tbody>";
            echo "</table>";
        }//ok

        function cargarNuevo(){
            $consulta=mysql_query("SELECT * FROM alumnos WHERE grado='11' ORDER BY grado,grupo, APELLIDO1,APELLIDO2,NOMBRE1,NOMBRE2 DESC ");
            
            echo '<form id="formularioSeleccionCandidatos" method="post" target="cargaSelCandidatos" onsubmit="guardarSeleccionCandidatos()" enctype="multipart/form-data">';
            echo    "<table class='table table-striped tarjeton' style='width:70%;' id='tablaPosiblesCandidatos'>";            
            echo        "<thead>";    
            echo            "<tr><th colspan='5'><h1>LISTADO DE POSIBLES CANDIDATOS</h1></th></tr>";
            echo            "<tr>";
            echo                "<td colspan='4'>";
            echo                    "<div class='alert alert-info alert-dismissable' style='margin:0 auto; margin-top:10px; width:80%;'>
                                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                        El listado de posibles candidatos es tomado del último grado en la institución. 
                                    </div>";
            echo                "</td>";
            echo            "</tr>";
            echo            "<tr class='TITULO' BGCOLOR='#00005B'>";
            echo                "<th>Código</th>";
            echo                "<th>Grado</th>";
            echo                "<th>Nombre Completo</th>";
            echo                "<th>Seleccione</th>";
            echo            "</tr>";
            echo        "</thead>";
            echo        "<tbody>";
                    while ($candidato=Mysql_fetch_array($consulta)){            
                        echo "<tr style='font-size:10px;'> ";													
                        echo    "<td>".$candidato[0]."</td>";
                        echo    "<td>".$candidato[1]."- $candidato[2] </td>";
                        echo    "<td>$candidato[3] $candidato[4] $candidato[5] $candidato[6]</td>";	
                        echo    "<td>";
                        //Verificar primero si es candidato
                        $sqlYaes=mysql_query("SELECT ca.alumnos_CODEST FROM candidatos ca WHERE ca.alumnos_CODEST='".$candidato[0]."';");
                        $resYa=mysql_num_rows($sqlYaes);
                        if($resYa>0){
                            echo "<div class='alert alert-success' style='margin:0 auto;'>                                        
                                        Ya es Candidato 
                                    </div>";;
                        }else{
                            echo  "<div class='checkbox checkbox-success'>
                                        <input type='checkbox' name='conjuntoCandidatos[]' value='".$candidato[0]."' id='".$candidato[0]."' title='Candidato $candidato[0]' style='margin:0 auto; padding: 0px;'>

                                        <label for='".$candidato[0]."'>

                                        </label>
                                    </div>";   
                        }                  
                        
                        //echo        "<input type='checkbox' value='' id='$candidato[0]' >";
                        echo    "</td>";
                        echo "</tr>";
                    }
            echo        "</tbody>";
            echo        "<tfoot>";
            echo            "<tr><td colspan='3'><button type='button' class='btn btn-outline btn-warning' id='Candidatos' onclick='administrar(this.id)'>Regresar</button></td><td>
                                <input type='submit' value='Listo' class='btn btn-outline btn-success' id='enviar' style='width:90%'></a></td></tr>";
            echo        "</tfoot>";    
            echo    "</table>";
            
            echo      "<iframe name='cargaSelCandidatos' style='display:none;'></iframe>";
        }//ok

        function editar(){
            
        }
        
        function Guardar($datos){
            $cara;            
            //var_dump($datos); 
            foreach($datos as $valores){ 
                $sqlSexo = mysql_query("SELECT sexo FROM alumnos WHERE CODEST='$valores'");
                while($s=mysql_fetch_array($sqlSexo)){
                    
                    if($s[0]=="M"){
                        $cara='CARA (10).png';
                    }else{
                        $cara='CARA (9).png';
                    }
                }
                //echo "<br>Valores uno por uno ".$valores;
                mysql_query("INSERT INTO `personeros`.`candidatos` (`FOTO`, `alumnos_CODEST`) VALUES ('$cara', '$valores');");
            }
            echo '<div class="alert alert-success alert-dismissable" style="margin:0 auto;margin-top:20px;width:50%;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Se agregó con éxito los registros de los candidatos.
                </div>';
        }//ok
        
        function eliminar($codigo){
            $verifica=$this->conVotos($codigo);
            if($verifica>0){
                echo '<div class="alert alert-danger alert-dismissable" style="margin:0 auto;margin-top:20px;width:50%;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Señor usuario no es posible eliminar los candidatos que contienen votos registrados, no se eliminó ningún registro.
                </div>';
            }else{
                mysql_query("DELETE FROM candidatos WHERE alumnos_CODEST='$codigo';");
                echo '<div class="alert alert-success alert-dismissable" style="margin:0 auto;margin-top:20px;width:50%;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Candidato eliminado con éxito.
                </div>';
            }
        }//ok
        
        function actualizar(){
            
        }//Pendiente por realizar
        
        function ninguno(){
            echo '<div class="alert alert-danger alert-dismissable" style="margin:0 auto;margin-top:20px;width:50%;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Debe escoger por lo menos un candidato, no se agregó ningún registro.
                </div>';
        }//ok
        
        function conVotos($codigo){
            $sql1=mysql_query("SELECT rv.* FROM registrovotos rv 
            INNER JOIN candidatos cd ON rv.Numero=cd.id 
            INNER JOIN alumnos al ON al.`CODEST`=cd.alumnos_CODEST
            WHERE cd.alumnos_CODEST='$codigo'");
            $res=mysql_num_rows($sql1);
            return $res;
        }//ok
    }
?>