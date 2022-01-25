<?php 
	class controlNotas extends ConectarPDO{
        public function cargar($sede,$anho,$periodo){
            $sql1=mysql_query("SELECT axs.idAreaSede,axs.abreviatura,axs.nombre FROM areasxsedes axs WHERE axs.codsede='$sede' AND axs.ih<>0;");           
            $conteoAreas = 0;
            echo "<table id='sudoku' class='table sudoku' >";
            echo    "<thead>";
            echo        "<tr>";
            echo            "<th class='celdaTitulo' title='PROFESOR'>";
            echo                "PROFESORES";
            echo            "</th>";
            echo            "<th class='celdaTitulo'>CURSO</th>";            
                            while($area = mysql_fetch_array($sql1)){
                               $sqlAsig = mysql_query("SELECT Abreviatura,Nombre,IH,codAsig FROM asignaturas_sedes WHERE idArea = '$area[0]';"); //Verifico que asignatura coincide con el area

                                $numAsig = mysql_num_rows($sqlAsig);

                                if($numAsig > 0){
                                    while($asigReg=mysql_fetch_array($sqlAsig)){
                                        echo "<th title='".utf8_encode($area['2'])."-".utf8_encode($asigReg['1'])."' class='celdaTitulo'>".$asigReg['0']."</th>";     
                                        $conteoAreas++;
                                    }                                    
                                }elseif($numAsig == 0){
                                    echo "<th title='".utf8_encode($area['2'])."' class='celdaTitulo'>".$area['1']."</th>"; 
                                    $conteoAreas++;
                                }                                   
                            }
            echo        "</tr>";  
            echo    "</thead>";//encabezado 
            echo    "<tbody id='matrizAreas'>";//cuerpo de la matriz
            
            			$sqlProfes = mysql_query("SELECT idUsuario, Documento, PrimerNombre, SegundoNombre, PrimerApellido, SegundoApellido FROM profesores WHERE codSede = '$sede' ORDER BY PrimerApellido, SegundoApellido, PrimerNombre, SegundoNombre ASC;");
                        
                        $resultadoSql = mysql_num_rows($sqlProfes);
                        
                        if($resultadoSql == 0){
                            echo '<tr class="filaProfe">
                                    <td colspan="5">
                                        <div class="alert alert-danger alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            No hay Profesores asociados a la sede, por favor revise el módulo de Profesores para la Sede..
                                        </div>
                                    </td>
                                 </tr>'; 
                        }else{
                            //recorrer los profesores de la sede
                            while($prof = mysql_fetch_array($sqlProfes)){
                                // consulta los cursos en la sede
                                $sqlCursos = mysql_query("SELECT DISTINCT(c.codCurso), c.Codgrado, c.grupo FROM cursos c INNER JOIN cargaacademica ca ON ca.`codCurso` = c.`codCurso` WHERE c.`codSede` = '$sede' AND ca.`codProfesor` = '$prof[0]' ORDER BY c.Codgrado,c.grupo ASC;");

                                 $totalfilas = mysql_num_rows($sqlCursos)+1;
                                echo "<tr class='apuntado filaProfe'>";
                                echo 	"<td rowspan='".$totalfilas."'>".$prof[2]." ".$prof[3]." ".$prof[4]." ".$prof[5]."	 </td>";
                                
                                $cont = 1;
                                $tipo = '';
                                
                                if(($totalfilas-1) == 0){
                                    echo "<td class='celdaCuerpo'>";
                                    echo    "-";
                                    echo "</td>";
                                    echo "<td colspan='".($conteoAreas)."' class='celdaCuerpo'>";
                                    echo    "<div class='vacia'>";
                                    echo        "No existe distribución académica asignada al docente en estos momentos";
                                    echo    "</div>";
                                    echo "</td>";
                                }	

                                //recorro los cursos 
                                while($cur = mysql_fetch_array($sqlCursos)){
                                	
                                    if($cont == $totalfilas-1){                                        	
                                		$tipo = 2;
                                	}elseif($cont == 1){
                                		$tipo = 3;
                                	}else{
                                		$tipo = '';
                                	}

                                    $TotalEstudiantes = 0;
                                    
                                    //Consulta para contar el total de estudiantes en el curso
                                    $sqlEstudiantes = mysql_query("SELECT COUNT(est.documento) FROM estudiantes est INNER JOIN matriculas mt ON mt.`Documento` = est.`Documento` WHERE mt.codsede='".$sede."' AND mt.`Curso` = '".$cur[0]."' AND mt.`anho` = '$anho' AND mt.estado = 'Matriculado'");
                                    
                                    while($tEst = mysql_fetch_array($sqlEstudiantes)){
                                        $TotalEstudiantes = $tEst[0];
                                    }
                                    
                                    echo "<tr class='apuntado'>";
                                        if($cur[1] <= 11){                                    	
                                        	echo "<th class='celdaCuerpo$tipo'>".$cur[1]."°".$cur[2]." </th> ";
                                        }else{
                                            $nGrado = substr($cur[1], 1, 2);
                                            if($nGrado <= 19){
                                                $nGradoReal = substr($cur[1], 2, 1);
                                                echo "<th class='celdaCuerpo'>$cur[3] $nGradoReal"."°".$cur[2]."</th>"; 
                                            }elseif($nGrado == 20){
                                                echo "<th class='celdaCuerpo'>$cur[3] 10°".$cur[2]."</th>";
                                            }elseif($nGrado == 21){
                                                echo "<th class='celdaCuerpo'>$cur[3] 11°".$cur[2]."</th>";
                                            }                            
                                        } 

                                	//consulta nuevamente las areas y asignaturas de la sede
                                	$sql1=mysql_query("SELECT axs.idAreaSede,axs.abreviatura,axs.nombre FROM areasxsedes axs WHERE axs.codsede='$sede' AND axs.ih<>0;");
                                    	
                                	//recorro las areas y asignaturas
                                	while($area = mysql_fetch_array($sql1)){

                                    	$sqlAsig=mysql_query("SELECT codAsig, Abreviatura, Nombre, IH  FROM asignaturas_sedes WHERE idArea='$area[0]';");
                                        //Verifico que asignatura coincide con el area
                                        
                                    	$numAsig=mysql_num_rows($sqlAsig);

                                    	if($numAsig > 0){
                                        	while($asigReg=mysql_fetch_array($sqlAsig)){
                                            	$TotalEstNotas = 0;
                                                //Consulta para contar el total de notas ingresadas en el area, curso, periodo y año;

                                                $sqlTEN = mysql_query("SELECT COUNT(nts.idMatricula) FROM notasasignaturas nts INNER JOIN matriculas mt ON mt.`idMatricula` = nts.idMatricula WHERE mt.`codsede` = '".$sede."' AND nts.`curso` = '".$cur[0]."' AND nts.`anho` = '$anho' AND nts.periodo = '$periodo' AND nts.`codAsignatura` = '".$asigReg[0]."' AND mt.`estado` = 'Matriculado';");

                                                while($tan = mysql_fetch_array($sqlTEN)){
                                                    $TotalEstNotas = $tan[0];
                                                }
                                                
                                                //1. se verifica si este profesor ya tiene esa asignatura en ese curso
                                                $sqlCargaTipo1 = mysql_query("SELECT * FROM cargaacademica WHERE codProfesor='".$prof[0]."' AND codCurso='$cur[0]' AND `codAsignatura`='".$asigReg[0]."' AND anho='$anho';");
                                                
                                                $conteoReg = mysql_num_rows($sqlCargaTipo1);


                                                echo "<td class='celdaCuerpo$tipo' id='Cel$prof[0]$cur[0]$asigReg[0]'>"; 
                                                if($conteoReg == 0 || $TotalEstudiantes == 0){
                                                    //2. Si no la tiene se marca en gris                                                
                                                    echo "<div class='vacia'></div>";
                                                }else{
                                                    if($TotalEstNotas < $TotalEstudiantes){
                                                        echo "<div class='incompleta' title='".utf8_encode($asigReg[2])."'>";
                                                        echo "Faltan: <br>".($TotalEstudiantes - $TotalEstNotas);
                                                        echo "</div>";
                                                    }else{
                                                        echo "<div class='completa' title='$asigReg[2]'>";
                                                        echo "OK";
                                                        echo "</div>";
                                                    }
                                                }
                                                echo "</td>";
                                        	}                                    
                                    	}elseif($numAsig == 0){
                                            $TotalEstNotas = 0;
                                            //Consulta para contar el total de notas ingresadas en el area, curso, periodo y año;

                                            $sqlTEN = mysql_query("SELECT COUNT(nts.idMatricula) FROM notas nts INNER JOIN matriculas mt ON mt.`idMatricula` = nts.idMatricula WHERE mt.`codsede` = '".$sede."' AND nts.`curso` = '".$cur[0]."' AND nts.`anho` = '$anho' AND nts.periodo = '$periodo' AND nts.codArea = '".$area[0]."' AND mt.`estado` = 'Matriculado';");

                                            while($tan = mysql_fetch_array($sqlTEN)){
                                                $TotalEstNotas = $tan[0];
                                            }
                                    		
                                    		//1. se verifica si este profesor ya tiene esa area en ese curso
                                    		$sqlCargaTipo1 = mysql_query("SELECT * FROM cargaacademica WHERE codProfesor='".$prof[0]."' AND codCurso='".$cur[0]."' AND codArea='".$area[0]."' AND anho='$anho';");
                                    		$conteoReg = mysql_num_rows($sqlCargaTipo1);


                                        	echo "<td class='celdaCuerpo$tipo' id='Cel$prof[0]$cur[0]$area[0]'>"; 
                                    		if($conteoReg == 0 || $TotalEstudiantes == 0){
                                    			//2. Si no la tiene se marca en gris                                    			
	                                    		echo "<div class='vacia'></div>";
                                    		}else{
                                    			if($TotalEstNotas < $TotalEstudiantes){
                                                    echo "<div class='incompleta' title='".utf8_encode($area[2])."'>";
                                                    echo "Faltan: <br>".($TotalEstudiantes - $TotalEstNotas);
                                                    echo "</div>";
                                                }else{
                                                    echo "<div class='completa' title='$area[2]'>";
                                                    echo "OK";
                                                    echo "</div>";
                                                }
                                    		}
                                    		echo "</td>";
                                    	}
                                	} //Fin del recorrido de las areas y asignaturas de la sede 
                                    echo "</tr>";
                                    $cont = $cont + 1;
                                }//Fin del recorrido de los cursos de la sede
                                echo "</tr>";                                
                            }//Fin recorrido de los Profesores
                        }                        
              echo  "</tbody>"; 

            $sql1 = mysql_query("SELECT axs.idAreaSede,axs.abreviatura,axs.nombre FROM areasxsedes axs WHERE axs.codsede = '$sede' AND axs.ih<>0;");

            echo    "<tfoot>";
            echo        "<tr><th class='celdaTitulo'>PROFESORES</th><th class='celdaTitulo'>CURSO</th>";            
                            while($area=mysql_fetch_array($sql1)){
                               $sqlAsig=mysql_query("SELECT Abreviatura,Nombre,IH,codAsig FROM asignaturas_sedes WHERE idArea='$area[0]';");//Verifico que asignatura coincide con el area
                                $numAsig=mysql_num_rows($sqlAsig);
                                if($numAsig>0){
                                    while($asigReg=mysql_fetch_array($sqlAsig)){
                                        echo "<th title='".utf8_encode($area['2'])."-".utf8_encode($asigReg['1'])."' class='celdaTitulo'>".$asigReg['0']."</th>";     
                                    }                                    
                                }elseif($numAsig==0){
                                    echo "<th title='".utf8_encode($area['2'])."' class='celdaTitulo'>".$area['1']."</th>"; 
                                }                                   
                            }
            echo        "</tr>";  
            echo    "</tfoot>";//encabezado 
            echo "</table>";
        } 
    }

?>