<?php
    require("conBDT.php");
    class Alumno extends Conectar{
        public $id;
        public $sql;
        function Cargar(){
            echo    "<table class='table table-striped tarjeton' style='width:70%;' id='tablaAlumnos'>";

                    $consulta=Mysql_query("SELECT * FROM alumnos");

                    $total_alumnos=Mysql_num_rows($consulta);

                    $total_filas=ceil($total_alumnos/3);

                    $cont=0;

                    $consulta=Mysql_query("SELECT * FROM alumnos ORDER BY grado,grupo, APELLIDO1,APELLIDO2,NOMBRE1,NOMBRE2 DESC ");
            echo        "<thead>";    
            echo            "<tr><th colspan='5'><h1>ALUMNOS REGISTRADOS</h1></th></tr>";
            echo            "<tr><td colspan='4'><a href='#' class='btn btn-primary' onclick='ventanaNuevoAlumno()'><i class='fa fa-plus-circle'> Agregar Alumno </i></a></td></tr>";
            echo            "<tr class='TITULO' BGCOLOR='#00005B'>";
            echo                "<th>Código</th>";
            echo                "<th>Grado</th>";
            echo                "<th>Nombre Completo</th>";
            echo                "<th>Estado</th>";
            echo                "<th colspan='2'>Acciones</th>";
            echo            "</tr>";
            echo        "</thead>";
            echo        "<tbody>";
                    while ($alumno=Mysql_fetch_array($consulta)){            
                        echo "<tr style='font-size:10px;'> ";													
                        echo "<TD>".$alumno[0]."</TD>";
                        echo "<td >".$alumno[1]."- $alumno[2] </td>
                        <td>$alumno[3] $alumno[4] $alumno[5] $alumno[6]</td>";	
                        if($alumno[7]=='Ya Voto'){
                            echo "<td><span class='btn btn-default'>$alumno[7]</span></td>";
                            echo "<td><a href='#' class='btn btn-default' title='Editar datos del alumno' style='color:#cecece;'><i class='fa fa-pencil'> </i></a></td>";
                            echo "<td><a href='#' class='btn btn-default' style='color:#cecece;' title='Elimina el registro del alumno de la base da datos'><i class='fa fa-trash-o'> </i></a></td>";
                        }else{
                            echo "<td><span class='btn btn-warning'>$alumno[7]</span></td>";
                            echo "<td><a href='#' class='btn btn-success' title='Editar datos del alumno' id='".$alumno[0]."' onclick='ventanaEditarAlumno(this.id)'><i class='fa fa-pencil'> </i></a></td>";
                            echo "<td><a href='#' class='btn btn-danger' id='".$alumno[0]."' onclick='eliminarAlumno(this.id)' title='Elimina el registro del alumno de la base da datos'><i class='fa fa-trash-o'> </i></a></td>";
                        }
                        $cont=$cont+1;
                        
                        echo "</tr>";
                    }
            echo        "</tbody>";
            echo        "<tfoot>";
            echo            "<tr><td colspan='4'><a href='#' class='btn btn-primary' onclick='ventanaNuevoAlumno()'><i class='fa fa-plus-circle'> Agregar Alumno </i></a></td></tr>";
            echo        "</tfoot>";    
            echo    "</table>";
        }

        function buscar(){
             $this->sql = Mysql_query("SELECT * FROM alumnos WHERE CODEST = '".$this->id."' ORDER BY grado,grupo, APELLIDO1,APELLIDO2,NOMBRE1,NOMBRE2 DESC ");

             return $this->sql;

        }

        function Eliminar($id){
            mysql_query("DELETE FROM alumnos WHERE CODEST='$id';");
        }
        
        function Actualizar(){
            
        }
        
        function Guardar($codEst,$nombre1,$nombre2,$apellido1,$apellido2,$grado,$grupo,$sexo,$estado,$institucion){
            mysql_query("INSERT INTO `personeros`.`alumnos` (`CODEST`, `GRADO`, `GRUPO`, `APELLIDO1`, `APELLIDO2`, `NOMBRE1`, `NOMBRE2`, `EST`, `codInst`, `SEXO`) VALUES ('$codEst','$grado','$grupo','$apellido1','$apellido2','$nombre1','$nombre2','$estado','$institucion','$sexo'); 
");
        }
    }
?>