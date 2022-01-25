<?php
    require("../../CONECT.php");
    $semanas=4;
    $dias=5;
    $diasT=$semanas*5;
    $diasLetra=array('L','M','M','J','V');
    $anho = date("Y");
    $curso=$_POST['cursoBol'];
    $tipoDatos=$_POST['tipoDatos'];
    $centro='';
    $membrete='';
    $sede='';
    $gradoGrupo=0;
    if(isset($_POST['sedeBol'])){
        $codSede=$_POST['sedeBol']; 
    }  
      
    $ProfesorUnitario=false;
    
    //recorro los profesores asignados en la sede
    $consultaProfes=mysql_query("SELECT IDUsuario,PrimerNombre,SegundoNombre,PrimerApellido,SegundoApellido FROM profesores WHERE codSede='$codSede'");

    $CursosSede=mysql_query("SELECT codCurso FROM cursos WHERE codSede='$codSede'");
    $conteoCursosSede=mysql_num_rows($CursosSede);
    
    while($rp=mysql_fetch_array($consultaProfes)){        
        $CursosProfesor=mysql_query("SELECT codCurso FROM distribucionCursos WHERE codProfesor='$rp[0]'");        
        $conteoCursosProfesor=mysql_num_rows($CursosProfesor);
        
        //Se evalua si cumple con la condicion de ser docente de multiples grados
        if($conteoCursosProfesor==$conteoCursosSede){
            //Consulta para membretear la hoja
            $ProfesorUnitario=true;
            $sqlDatosMembrete=mysql_query("SELECT cen.`NOMBREINST`,sd.`NOMSEDE`,cen.`LOGO`
            FROM  sedes sd            
            INNER JOIN centroeducativo cen ON sd.`CODINST`=cen.`CODINST`
            WHERE sd.`codSede`='$codSede';");

            while($dm=mysql_fetch_array($sqlDatosMembrete)){
                $centro=$dm[0];
                $sede=$dm[1];
                $logo=$dm[2];
            }  
            //-------------- Consulta para recorrer el listado de estudiantes en el curso ----------------//
		
            $sqlEst="SELECT est.`Documento`,est.`PrimerApellido`,est.`SegundoApellido`,est.`PrimerNombre`,est.`SegundoNombre`,cursos.`CODGRADO`,cursos.`grupo` FROM estudiantes est  INNER JOIN matriculas mt ON mt.`Documento` = est.`Documento` INNER JOIN cursos ON cursos.`codCurso`= mt.`Curso` WHERE mt.`codSede`='$codSede' AND mt.`anho` = '$anho' ORDER BY cursos.`CODGRADO`,cursos.`grupo`,est.`PrimerApellido`,est.`SegundoApellido`,est.`PrimerNombre`,est.`SegundoNombre` ASC;";

            $resultalum=mysql_query($sqlEst,$conexion) or die ("NO TRAJO LOS NOMBREs DE LOS ALUMNOS<BR>".mysql_error());

            $nolista=1;	
            echo '<header class="clearfix">';
                echo "<table style='border:0px;background-color:#fff;'>";
                    echo "<tr style='border:0px;background-color:#fff;'>";
                    echo    "<td style='border:0px;padding-left:5px;width:50px;background-color:#fff;'>
                                <div id='logo'>
                                    <img src='../../IMAGENES/$logo' style='width:50px;'>
                                </div>
                            </td>";
                    echo    "<td colspan='2' style='border:0px;background-color:#fff;'>
                                <div class='clearfix' style='margin:0px;'>
                                    <div style='font-size:14px;margin:0 auto;'><strong>$centro</strong></div>  
                                    <div style='font-size:12px;'>SEDE: $sede</div>            
                                </div>
                    </td>";

                    echo "</tr>";
            echo "</table>";

                if($tipoDatos=='Notas'){
                    echo "<h1>PLANILLA PARA CONTROL DE CALIFICACIONES</h1>";
                }elseif($tipoDatos=='Asistencia'){
                    echo "<h1>PLANILLA PARA CONTROL DE ASISTENCIAS</h1>";
                }
                echo "</header>";
            echo "<table>";
                    echo "<tr height='20'>";
                    echo    "<td colspan='2' style='border:0px;padding:5px;'>DOCENTE:<strong> $rp[1] $rp[2] $rp[3] $rp[4]</strong></td>";
                    if($tipoDatos=='Notas'){
                        echo    "<td colspan='2' style='border:0px;'>PERIODO: ______</td>";
                        echo    "<td colspan='2' style='border:0px;'>AREA/ASIGNATURA: ______________________</td>";
                    }elseif($tipoDatos=='Asistencia'){
                        echo    "<td colspan='2' style='border:0px;'>MES: ___________________ </td>";
                    }
                    echo "</tr>";
            echo "</table>";
            echo "<main style='margin-top:1px;'>";
            echo "<table border='0' cellpadding='0' cellspacing='0' class=xl8812683 style='border-collapse:collapse;table-layout:fixed;width:100%'>";
                //Encabezado de la Tabla
                if($tipoDatos=='Notas'){
                    echo "<tr>";
                    echo    "<td class='bordes' width='10' >Nº</td>";
                    echo    "<td class='bordes' width='20' >Código</td>";
                    echo    "<td class='bordes' width='90'>ESTUDIANTE</td>";                    
                    echo    "<td class='bordes' width='15' >Grado</td>";

                    while($semanas>=1){
                        echo "<td class='bordeareas' width='30' style='border-left:2px solid #000;'>NOTA ".( 5 - $semanas)."</td>"; 
                        $semanas=$semanas-1;
                    }
                    $semanas=4;

                    echo    "<td class='bordeareas' width='20' style='border-left:2px solid #000;'>DEFINITIVA</td>";  
                    echo "</tr>";

                }elseif($tipoDatos=='Asistencia'){
                    echo "<tr>";
                    echo    "<td rowspan='2' class='bordes' width='10' >Nº</td>";
                    echo    "<td rowspan='2' class='bordes' width='20' >Código</td>";
                    echo    "<td rowspan='2' class='bordes' width='80'>ESTUDIANTE</td>";
                    echo    "<td rowspan='2' class='bordes' width='15' >Grado</td>";
                    while($semanas>=1){
                        echo "<td colspan='5' class='bordeareas' width='30' style='border-left:2px solid #000;'>SEMANA ".( 5 - $semanas)."</td>"; 
                        $semanas=$semanas-1;
                    }
                    $semanas=4;

                    echo    "<td rowspan='2' class='bordeareas' width='20' style='border-left:2px solid #000;'>TOTAL</td>";  
                    echo "</tr>";
                    echo "<tr>";
                    while($semanas>=1){
                        $i=1;
                        while($i<=$dias){
                            if($i==1){
                                echo "<td class='bordeareas' width='30' style='border-left:2px solid #000;'>".($diasLetra[$i-1])."</td>"; 
                            }else{
                                echo "<td class='bordeareas' width='30' >".($diasLetra[$i-1])."</td>";
                            }
                            $i++;
                        }
                        $semanas--;
                    }
                    echo "</tr>";
                }
                //Fin del encabezado


                //Filas de los registros por estudiantes
                if($tipoDatos=='Notas'){
                    while ($alumno=mysql_fetch_array($resultalum)){	
                        $semanas=4;
                        echo    "<tr height=24 style='mso-height-source:userset;height:18.0pt'>";
                        echo        "<td class=bordes style='border-right:1.0pt solid black'>$nolista</td>";
                        echo        "<td class=bordes style='border-right:1.0pt solid black; font-size: 10px; text-align:left; '>$alumno[0]</td>";                
                        echo        "<td class='bordesnom' style='font-size:11px;padding:3px;'>".strtoupper($alumno[1])." ".strtoupper($alumno[2])." ".strtoupper( $alumno[3])." ".strtoupper($alumno[4])."</td>"; 
                        echo        "<td class=bordes style='border-right:1.0pt solid black'>$alumno[5]°$alumno[6]</td>";
                                while($semanas>=1){
                                    echo "<td class='bordes' >&nbsp;</td>";
                                    $semanas--;
                                }
                        echo        "<td class='bordes4' style='border-left:2px solid #000;'>&nbsp;</td>"; 
                        echo    "</tr>";
                        $nolista++;
                    }
                }elseif($tipoDatos=='Asistencia'){
                    while ($alumno=mysql_fetch_array($resultalum)){	
                        $semanas=4;
                        echo    "<tr height=24 style='mso-height-source:userset;height:18.0pt'>";                
                        echo        "<td class=bordes style='border-right:1.0pt solid black'>$nolista</td>";
                        echo        "<td class=bordes style='border-right:1.0pt solid black; font-size: 10px; text-align:left; '>$alumno[0]</td>";
                        //echo        "<td class='bordesnom' style='font-size:11px;padding:3px;'>".utf8_encode($alumno[1])." ".utf8_encode($alumno[2])." ".utf8_encode($alumno[3])." ".utf8_encode($alumno[4])." </td>";
                        echo        "<td class='bordesnom' style='font-size:11px;padding:3px;'>".strtoupper($alumno[1])." ".strtoupper($alumno[2])." ".strtoupper( $alumno[3])." ".strtoupper($alumno[4])."</td>";
                        echo        "<td class=bordes style='border-right:1.0pt solid black'>$alumno[5]°$alumno[6]</td>";
                                    while($semanas>=1){
                                        $c=1;
                                        while($c<=$dias){
                                            if($c==1){
                                                echo "<td class='bordeareas' width='30' style='border-left:2px solid #000;'>&nbsp;</td>"; 
                                            }else{
                                                echo "<td class='bordes' >&nbsp;</td>";
                                            }
                                            $c++;
                                        }                                       
                                        $semanas--;
                                    }
                        echo        "<td class='bordes4' style='border-left:2px solid #000;'>&nbsp;</td>"; 
                        echo    "</tr>";
                        $nolista++;
                    }
                    for($i=$nolista;$i<=$nolista+3;$i++){
                        $semanas=4;
                        echo    "<tr height=24 style='mso-height-source:userset;height:18.0pt'>";                
                        echo        "<td class=bordes style='border-right:1.0pt solid black'>$i</td>";
                        echo        "<td class=bordes style='border-right:1.0pt solid black; font-size: 8px; text-align:left; '></td>";
                        //echo        "<td class='bordesnom' style='font-size:11px;padding:3px;'>".utf8_encode($alumno[1])." ".utf8_encode($alumno[2])." ".utf8_encode($alumno[3])." ".utf8_encode($alumno[4])." </td>";
                        echo        "<td class='bordesnom' style='font-size:11px;padding:3px;'></td>";
                        echo        "<td class=bordes style='border-right:1.0pt solid black'></td>";
                                    while($semanas>=1){
                                        $c=1;
                                        while($c<=$dias){
                                            if($c==1){
                                                echo "<td class='bordeareas' width='30' style='border-left:2px solid #000;'>&nbsp;</td>"; 
                                            }else{
                                                echo "<td class='bordes' >&nbsp;</td>";
                                            }
                                            $c++;
                                        }                                       
                                        $semanas--;
                                    }
                        echo        "<td class='bordes4' style='border-left:2px solid #000;'>&nbsp;</td>"; 
                        echo    "</tr>";
                    }
                }
            
            
        }
        else{
            $ProfesorUnitario=false;
        }
    }
        //fin de las filas 

?>




<script src="../../js/jquery1.11.min.js"></script>
    <script src="../../js/jquery.PrintArea.js"></script>
    <script type="text/javascript" src="../../js/jquery-ui.js"></script>
    
    <!-- Bootstrap , datatables y alertify -->
    <script src="../../js/bootstrap.min.js"></script>   