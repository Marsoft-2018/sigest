<html>

<head>
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin-top:0cm;
	margin-right:0cm;
	margin-bottom:10.0pt;
	margin-left:0cm;
	line-height:115%;
	font-size:11.0pt;
	font-family:'Calibri','sans-serif';}
a:link, span.MsoHyperlink
	{color:blue;
	text-decoration:underline;}
a:visited, span.MsoHyperlinkFollowed
	{color:purple;
	text-decoration:underline;}
.MsoChpDefault
	{font-family:'Calibri','sans-serif';}
.MsoPapDefault
	{margin-bottom:10.0pt;
	line-height:115%;}
@page WordSection1
	{size:612.1pt 792.1pt;
	margin:42.55pt 1.5cm 42.55pt 1.5cm;}
div.WordSection1
	{page:WordSection1;}
    
    
-->
</style>
<title>Boletin</title>
</head>
<?php

/*---------------------------------- CONSULTAS -------------------------------------*/
require("../conect.php");

//para pruebas
require("../class/planillaYnotasClass.php"); 

$sede=$_POST['sedeBol'];
$curso=$_POST['cursoBol'];
$anho=$_POST['anho'];
$periodoBol=$_POST['periodoBol'];
$centro=$_POST['centro'];

//echo "la sede es: $sede y el curso es: $curso el anho es: $anho<BR>";

$sqltodoslosalumnos=mysql_query("SELECT DISTINCTROW notas.idUsuario FROM notas INNER JOIN estudiantes est ON notas.`IDUsuario`=est.`IDUsuario`
                                WHERE notas.curso=$curso AND notas.Anho='$anho' ORDER BY est.`PrimerApellido`,est.`SegundoApellido`,est.`PrimerNombre`,est.`SegundoNombre` DESC;") or die ("NO HAY ESTUDIANTES CON NOTAS PARA ESTE CURSO");





while ($alumnoe=mysql_fetch_array($sqltodoslosalumnos))
	{
		$sqlconteo="SELECT COUNT(DISTINCTROW codArea)FROM notas WHERE IDUsuario='$alumnoe[0]' AND periodo=$periodoBol AND Anho='$anho';";
		$rconteo =mysql_query($sqlconteo) OR DIE ("NO HAY MATERIAS PARA ESTE alumno");
		while ($regicont=mysql_fetch_array($rconteo))
		{
			if ($regicont[0]>=5)
			{
			
				/*---------------- CONSULTA ENCABEZADO DEL BOLETIN --------------------------*/
					
                    $sqlbole="SELECT DISTINCTROW                        cent.`NOMBREINST`,cent.regdane,cent.nit,cent.direccion,cent.tel,cent.Logo,sedes.nomsede,alum.`IDUsuario`,alum.`PrimerNombre`,alum.`SegundoNombre`,alum.`PrimerApellido`,alum.`SegundoApellido`,grados.`NOMGRADO`,cursos.`codCurso`,cursos.`CODGRADO`,cursos.`grupo`,jornadas.`Nombre`,prof.`PrimerNombre`,prof.`SegundoNombre`,prof.`PrimerApellido`,prof.`SegundoApellido`,niveles.`NOMBRE_NIVEL`,
                    cent.ICFES,cent.RESOLUCION,cent.CORREO,cent.CIUDAD,cent.RECTOR,cent.membrete  
                    FROM estudiantes alum
                    INNER JOIN cursos
                    ON cursos.`codCurso`=alum.`Curso`
                    INNER JOIN jornadas
                    ON jornadas.`idJornada`=cursos.`idJornada`
                    INNER JOIN grados
                    ON grados.`CODGRADO`=cursos.`CODGRADO`
                    INNER JOIN niveles
                    ON niveles.`CODNIVEL`=grados.`CODNIVEL`
                    INNER JOIN sedes
                    ON sedes.`CODSEDE`=alum.`codsede`
                    INNER JOIN centroeducativo cent
                    ON sedes.`CODINST`=cent.`CODINST`
                    INNER JOIN direccioncursos dirc
                    ON dirc.codCurso=cursos.`codCurso`
                    INNER JOIN profesores prof
                    ON prof.`IDUsuario`=dirc.codProfesor
                    WHERE cent.codinst='$centro'
                    AND sedes.codsede='$sede' 
                    AND alum.`Curso`='$curso'
                    AND alum.`estado`='Matriculado'
                    AND alum.`IDUsuario`='$alumnoe[0]'";
                    
                    $resultbole=mysql_query($sqlbole,$conexion) or die ("No trajo Datos para el encabezado");
                  
					
				while ($fila=mysql_fetch_array($resultbole))
				{
					
					
					
					/*------------ Consulta para el promedio de alumnos por periodo -----------------------*/
					$sqlprom="SELECT AVG(notas.NOTA) 
                                FROM notas
                                INNER JOIN areasxsedes axs
                                ON axs.`idAreaSede`=notas.`codArea`
                                INNER JOIN estudiantes est
                                ON est.IDUsuario=notas.`IDUsuario`
                                WHERE est.IDUsuario='$fila[7]'
                                AND NOTAS.curso='$curso' 
                                AND notas.periodo=$periodoBol;";
					$resultprom=mysql_query($sqlprom,$conexion) or die ("No trajo Promedios");		
					/*------------ Consulta para LAS FALTAS ACUMULADAS ----------------------- OJO
					$SQLFALTAST="SELECT SUM(notas.FALTAS) 
					FROM notas
					WHERE notas.codest='$fila[7]'
					AND notas.periodo=1";
					$SQLFALTAS2P="SELECT DISTINCTROW SUM(notas.FALTAS) 
					FROM notas
					WHERE notas.codest='$fila[7]'
					AND NOT notas.periodo=3 AND NOT periodo=4;";
					$SQLFALTAS3P="SELECT DISTINCTROW SUM(notas.FALTAS) 
					FROM notas
					WHERE notas.codest='$fila[7]'
					AND NOT periodo=4;";
					$SQLFALTAS4P="SELECT DISTINCTROW SUM(notas.FALTAS) 
					FROM notas
					WHERE notas.codest='$fila[7]';";
					$resultfaltas=mysql_query($SQLFALTAST,$conexion) or die ("No trajo las faltas");
					
					/*------------ Consulta para el promedio de curso en el periodo-----------------------*/
					$sqlpcur="SELECT AVG(notas.NOTA) 
                                FROM notas
                                INNER JOIN areasxsedes axs
                                ON axs.`idAreaSede`=notas.`codArea`
                                INNER JOIN estudiantes est
                                ON est.IDUsuario=notas.`IDUsuario`
                                WHERE NOTAS.curso='$curso' 
                                AND notas.periodo=$periodoBol;";	
					$resultpcur=mysql_query($sqlpcur,$conexion) or die ("No trajo Promedios");
					/*--------------------------------- Consultas para Logro CONVIVENCIA SOCIAL------------------------------------------------------------------- OJO
							$sqllogro="SELECT logros.logro FROM alumnos,CONVIVENCIA,logros ,sedes 
							WHERE sedes.CODINST=logros.CODINST
							AND alumnos.CODSEDE=sedes.CODSEDE
							AND alumnos.codest='$fila[7]'	AND CONVIVENCIA.codest =alumnos.codest 
							AND CONVIVENCIA.PERIODO='$periodoBol' 
							AND logros.codind=CONVIVENCIA.CODIND";
					$resultlogros=mysql_query($sqllogro,$conexion) or die ("No trajo Logros de convivencia");
					
					/* CONSULTA PARA PUESTOS  EN EL PERIODO*/		
					$sqlpuesto="SELECT DISTINCTROW notas.`IDUsuario`, AVG(notas.nota) AS promedio 
                                FROM notas
                                INNER JOIN estudiantes est
                                ON notas.`IDUsuario`=est.`IDUsuario`
                                WHERE notas.periodo=$periodoBol
                                AND NOTAS.curso='$curso'
                                AND est.CODSEDE='$sede'
                                GROUP BY notas.`IDUsuario` 
                                ORDER BY PROMEDIO DESC,notas.`IDUsuario`;";
					$resultpuesto=mysql_query($sqlpuesto,$conexion) or die ("Error al mostrar los puestos");
					
					/*--------------------------------- the end -------------------------------------------------------------------*/	
					
				/*-------------------------------- FIN CONSULTAS ---------------------------------*/
				/* --------- ENCABEZADO DEL BOLETIN --------------------------- */
				echo
				"<body>
				<div class=WordSection1>";
				echo "<TABLE WIDTH='100%' STYLE='BORDER-COLLAPSE:COLLAPSE;'>";
			echo "<TR>";
				echo "<TD align='center'>
				<table cellspacing=0 cellpadding=0 style='width:100.16%;margin:0 auto;border-collapse:collapse;border:1px'>
				 <tr>
				  <td width='6%' rowspan=7 valign=top style='width:6.52%;border:solid windowtext 1.5pt;border-left:solid windowtext 1.5pt; border-right:none;padding:3px>
                  
				  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal;padding:2px;'>
					
						<img src='../IMAGENES/".$fila[5]."' alt='Descripción: MEMBRETE' style='position:relative;z-index:251700224; width:90%;height:50px'>
				  </p>
                  
				  </td>
				  <td width='25%' rowspan=7 style='width:25.88%;border:solid windowtext 1.5pt; border-left:none;padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal'>
						<b>
						<span lang=ES-AR style='font-size:6.0pt;font-family:'Arial','sans-serif''>
							REPÚBLICA DE COLOMBIA
						</span>
						</b>
					</p>
				  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal'>
						<span lang=ES-AR style='font-size:5.0pt'>
							<b>$fila[0]</b><br>
						</span>
						<span lang=ES-AR style='font-size:5.0pt'> 
							".utf8_encode($fila[27]).".
					  
					  </span>
					</p>
				  </td>
				  <td width='7%' valign=top style='width:7.02%;border-top:solid windowtext 1.5pt; border-left:none;border-bottom:none;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
				  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal'>
					<span lang=ES-AR style='font-size:9.0pt'>
						Sede: 
					</span>
				  </p>
				  </td>
				  <td width='15%' colspan=3 
                        style='width:15.56%;
                               border-top:solid windowtext 1.5pt; 
                               border-left:none;
                               border-bottom:solid windowtext 1.0pt;
                               border-right:solid windowtext 1.0pt;
                               padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal'>
						<span lang=ES-AR style='font-size:9.0pt'>
							"/*SEDE */ .$fila[6]."
						</span>
					</p>
				  </td>
				  <td width='11%' style='width:11.98%;border-top:solid windowtext 1.5pt;border-left:none;border-bottom:none;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'>
						<span lang=ES-AR style='font-size:9.0pt'>
							Código:
						</span>
					</p>
				  </td>
				  <td width='6%' valign=top style='width:6.0%;
				  border-top:solid windowtext 1.5pt;
				  border-left:none;
				  border-bottom:solid windowtext 1.0pt;
				  border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal'>
						<span lang=ES-AR style='font-size:9.0pt'>
							"/*CODIGO DEL ESTUDIANTE */ .$fila[7]."
						</span>
					</p>
				  </td>
				  <td width='6%' colspan=2 style='width:6.44%;border-top:solid windowtext 1.5pt;border-left:none;border-bottom:none;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'>
						<span lang=ES-AR style='font-size:9.0pt'>
							Curso:
						</span>
					</p>
				  </td>
				  <td width='4%' valign=top style='width:4.46%;border-top:solid windowtext 1.5pt;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'>
						<span lang=ES-AR style='font-size:9.0pt'>
							"/*CURSO DEL ESTUDIANTE */ .$fila[14]."°$fila[15]
						</span>
					</p>
				  </td>
                  <td width='4%' valign=top style='width:4.46%;border-top:solid windowtext 1.5pt;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'>
						<span lang=ES-AR style='font-size:9.0pt'>
							"/*JORNADA */ .utf8_encode($fila[16])."
						</span>
					</p>
				  </td>
				  <td width='4%' style='width:4.82%;border-top:solid windowtext 1.5pt; border-left:none;border-bottom:none;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal align=right style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:right;line-height:normal'>
						<span lang=ES-AR style='font-size:9.0pt'>
							Año:
						</span>
					</p>
				  </td>
				  <td width='11%' colspan=2 valign=top style='width:11.32%;border-top:solid windowtext 1.5pt;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal'>
						<b>
							<span lang=ES-AR style='font-size:9.0pt'>
								"//Año lectivo
								.$anho."
							</span>
						</b>
					</p>
				  </td>
				 </tr>
				 <tr>
				  <td width='67%' colspan=13 valign=top style='width:67.6%;border:none;border-right:solid windowtext 1.5pt;padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'>
						<span lang=ES-AR style='font-size:2.0pt'>
							&nbsp;
						</span>
					</p>
				  </td>
				 </tr>
				 <tr>
				  <td width='9%' colspan=2 style='width:9.82%;border:none;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'>
						<span lang=ES-AR style='font-size:9.0pt'>
							Estudiante:
						</span>
					</p>
				  </td>
				  <td width='33%' colspan=5 valign=top style='width:33.94%; 
				  border-top:solid windowtext 1.0pt; 
				  border-left:solid windowtext 1.0pt; 
				  border-bottom:solid windowtext 1.0pt; 
				  border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal'>
						<span lang=ES-AR style='font-size:9.0pt'>
							"/*ESTUDIANTE*/.utf8_encode(strtoupper($fila[8]." ".$fila[9]." ".$fila[10]." ".$fila[11]))."
						</span>
					</p>
				  </td>
				  <td width='7%' colspan=2 valign=top style='width:7.72%;border:none;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'>
						<span lang=ES-AR style='font-size:9.0pt'>
							Nivel:
						</span>
					</p>
				  </td>
				  <td width='16%' colspan=4 valign=top style='width:16.14%;
				  border-top:solid windowtext 1.0pt;
				  border-left:solid windowtext 1.0pt;
				  border-bottom:solid windowtext 1.0pt;
				  border-right:solid windowtext 1.5pt;padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'>
						<span lang=ES-AR style='font-size:8.0pt'>
							".$fila[21]."
						</span>
					</p>
				  </td>
				 </tr>
				 <tr>
				  <td width='67%' colspan=13 valign=top style='width:67.6%;border:none;border-right:solid windowtext 1.5pt;padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'>
						<span lang=ES-AR style='font-size:2.0pt'>
							&nbsp;
						</span>
					</p>
				  </td>
				 </tr>
				 <tr>
				  <td width='11%' colspan=3 valign=top style='width:11.0%;border:none;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'>
						<span lang=ES-AR style='font-size:8.0pt'>
							Dir. De Grupo:
						</span>
					</p>
				  </td>
				  <td width='41%' colspan=7 valign=top style='width:41.18%;
				  border-top:solid windowtext 1.0pt;
				  border-left:solid windowtext 1.0pt;
				  border-bottom:solid windowtext 1.0pt;
				  border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'>
						<span lang=ES-AR style='font-size:9.0pt'>
							"/* DIRECTOR DE GRUPO */.utf8_encode($fila[17]." ".$fila[18]." ".$fila[19]." ".$fila[20])."
						</span>
					</p>
				  </td>
				  <td width='8%' colspan=2 valign=top style='width:8.9%;border:none;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal align=right style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:right;line-height:normal'>
						<span lang=ES-AR style='font-size:9.0pt'>
							PERIODO
						</span>
					</p>
				  </td>
				  <td width='6%' valign=top style='width:6.52%;border-top:solid windowtext 1.0pt;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt; padding:0cm 25.4pt 0cm 0.4pt'>
					<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
						<span lang=ES-AR style='font-size:9.0pt'>
							"/*PERIODO */.$periodoBol."
						</span>
					</p>
				  </td>
				 </tr>
				 <tr>
				  <td width='67%' colspan=13 valign=top style='width:67.6%;border-top:none; border-left:none;border-bottom:solid black 1.0pt;border-right:solid windowtext 1.5pt;padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'>
						<span lang=ES-AR style='font-size:1.0pt'>
							&nbsp;
						</span>
					</p>
				  </td>
				 </tr>
				 <tr>
				  <td width='67%' colspan=13 valign=top style='width:67.6%;border-top:none; border-left:none;border-bottom:solid windowtext 1.5pt;border-right:solid windowtext 1.5pt;background:#D9D9D9;padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal'>
						<i>
							<span lang=ES-AR style='font-size:7.0pt'>";
							echo "Escala de valoración:&nbsp;&nbsp;";
							$sqlconceptos=mysql_query("SELECT limiteinf,limitesup,CONCEPT FROM desempenos WHERE codinst=$centro ORDER BY limiteInf ASC;");
                            while ($registro=Mysql_fetch_array($sqlconceptos)){

                                echo "$registro[2]: de $registro[0] hasta $registro[1]&nbsp;&nbsp;-&nbsp;&nbsp;";

                            }	
								//Escala de valoración: Superior: 4.5 – 5.0   Alto: 4.0 – 4.4      Básico: 3.0 - 3.9    Bajo: 1.0 – 2.9 
					  echo "</span>
						</i>
					</p>
				  </td>
				 </tr>
				</table>
				<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'>
					<span lang=ES-AR style='font-size:3.0pt'>
						&nbsp;
					</span>
				</p>
</TD>
</TR>
<TR>
<TD align='center'>
				<table border=1 cellspacing=0 cellpadding=0 width='100%' style='width:100.16%;margin:0 auto;border-collapse:collapse;border:none'>
				 <tr>
				  <td width=120 rowspan=3 style='width:90.1pt;border-top:windowtext;border-left: windowtext;border-bottom:black;border-right:black;border-style:solid; border-width:1.5pt;padding:0cm 5.4pt 0cm 15.4pt'>
					<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'>
						<span lang=ES style='font-size:12.0pt'>
							AREAS/ ASIGNATURAS
						</span>
					</p>
				  </td>
				  <td rowspan=3 style='width:10.05pt;border-top:solid windowtext 1.5pt; border-left:none;border-bottom:solid black 1.5pt;border-right:solid windowtext 1.5pt;'>
					<p class=MsoNormal align=center style='margin-top:0cm;margin-right:5.65pt;margin-bottom:0cm;margin-left:5.65pt;margin-bottom:.0001pt;text-align:center;line-height:normal'>
						<b>
							<span lang=ES-AR style='font-size:8.0pt;font-family:'Arial','sans-serif''>
								I.H.
							</span>
						</b>
					</p>
				  </td>
				  <td width=569 colspan=6 style='width:426.55pt;border-top:solid black 1.5pt;border-left:none;border-bottom:solid windowtext 1.5pt;border-right:solid windowtext 1.5pt;padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
						<b>
							<i>
								<span lang=ES-AR style='font-size:12.0pt'>
									DESEMPEÑO ACADÉMICO
								</span>
							</i>
						</b>
					</p>
				  </td>
				 </tr>
				 <tr>
				  <td colspan=3 style='width:118.7pt;border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid windowtext 1.5pt;padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
						<span lang=ES-AR style='font-size:12.0pt'>
							PERIODO ".$periodoBol."
						</span>
					</p>
				  </td>
				  <td rowspan='2' style='width:460.85pt;border-top:none;border-left:none;border-bottom:solid black 1.5pt;border-right:solid black 1.5pt;padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:center;line-height:normal'>
						<span lang=ES-AR>
							FORTALEZAS
						</span>
					</p>
				  </td>
				 </tr>
				 <tr>
				  <td style='width:10pt;border-top:none;border-left:none; border-bottom:solid black 1.5pt;border-right:solid black 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:center;line-height:normal'>
						<span lang=ES-AR style='font-size:10.0pt'>
							NOTA
						</span>
					</p>
				  </td>
				  <td style='width:40pt;border-top:none;border-left:none;border-bottom:solid black 1.5pt;border-right:solid black 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
						<span lang=ES-AR style='font-size:8.0pt'>
							DESEMPEÑO ACADÉMICO
						</span>
					</p>
				  </td>
				  <td style='width:10pt;border-top:none;border-left:none;border-bottom:solid black 1.5pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
						<span lang=ES-AR style='font-size:8.0pt'>
							INA.
						</span>
					</p>
				  </td>
				  
				 </tr>";
				 
				 /* ------------------------------------ FIN DEL ENCABEZADO ------------------------------------------*/
                 /*------------------------------------- INICIO DEL CUERPO DEL BOLETIN ----------------------------------------*/   
                $cuerpo=new Boletin();
                $cuerpo->bloqueAreas($anho,$periodoBol,$alumnoe[0],$centro,$curso,$sede);
                 /*------------------------------------- FIN DEL CUERPO DEL BOLETIN ----------------------------------------*/   
				/*------------------------------------- PIE DEL BOLETIN  ----------------------------------------*/
				 echo
				 "
				<table class=MsoTableGrid cellspacing=0 cellpadding=0  style='margin:0 auto;border-collapse:collapse;border:none;width:100%'>
				 <tr style='border:solid windowtext 0.5pt;margin:0px;'>
				  <td width='29%' colspan=2 valign=top style='width:29.34%;border-left:solid windowtext 1.5pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
					  <p class=MsoNormal align=right style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:right;line-height:normal'>
						  <span lang=ES-AR>
							PROMEDIO DEL ESTUDIANTE 
						  </span>
					  </p>
				  </td> 
				  <td width='5%' style='width:5.32%;border:solid windowtext 1.0pt;border-left:none;padding:0cm 5.4pt 0cm 5.4pt'>
						<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
							<span lang=ES-AR style='font-size:12.0pt'>";
							     /*-------------------- PROMEDIO DEL ESTUDIANTE -----------------------*/
                                    /*while ($fila32=mysql_fetch_array($resultprom)){
                                        echo  round($fila32[0],1);																			
                                    }*/
                                    $promedioEstudiante = new Boletin();
                                    $promedioEstudiante->promedioEstudiante($centro,$sede,$anho,$periodoBol,$alumnoe[0]);
                                    //----- FIN DEL PROMEDIO DEL ESTUDIANTE -----------------------------///
					echo "	</span>
						</p>
				  </td>
				  <td width='26%' style='width:26.62%;border:none;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal align=right style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:right;line-height:normal'>
						<span lang=ES-AR style='font-size:10.0pt'>
							PUESTO EN EL PERIODO
						</span>
					</p>
				  </td>
				  <td width='6%' style='width:6.64%;border:solid windowtext 1.0pt;border-left:none;padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
						<span lang=ES-AR style='font-size:12.0pt'>";
						//-- BLOQUE PARA COLOCAR EL PUESTO DEL ESTUDIANTE SEGUN EL PROMEDIO
							/*$t=1;
							while ($filapuesto=mysql_fetch_array($resultpuesto)){
								if ($filapuesto[0]==$fila[7]) {
									echo $t;
								}
								$t++;	
							}	*/			
						      $puesto = new Boletin();
                              $puesto->puestoEstudiante($centro,$sede,$anho,$periodoBol,$curso,$alumnoe[0]);
					echo "</span>
					</p>
				  </td>
				  <td width='23%' style='width:23.98%;border:none;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal align=right style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:right;line-height:normal'>
						<span lang=ES-AR>
							PROMEDIO GRUPO
						</span>
					</p>
				  </td>
				  <td width='8%' style='width:8.1%;border:solid windowtext 1.0pt;border-left:none;border-right:solid windowtext 1.5pt;padding:0cm 20.4pt 0cm 5.4pt'>
					<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:center;line-height:normal'>
						<span lang=ES-AR style='font-size:12.0pt;text-align:center;'>";
						//PROMEDIO DEL GRUPO POR PERIODO
                        //espacio para colocar el promedio del grupo
				           /* $SQLPRO ="SELECT DISTINCTROW AVG(notas.nota) AS promedio 
                            FROM notas
                            WHERE notas.periodo='$periodoBol'
                            AND notas.curso='$curso'
                            GROUP BY notas.`periodo`;";
                            $resulsqlpro=mysql_query($SQLPRO);
                            while ($progrupo=mysql_fetch_array($resulsqlpro)){
                                echo round($progrupo[0],2);
                            }	*/	
                            $promedioGrupo = new Boletin();
                            $promedioGrupo->promedioGrupo($centro,$sede,$anho,$periodoBol);
					echo "</span>
					</p>
				  </td>
				 </tr>
				 
				 ";
                    //ESPACIO PARA LA CONVIVENCIA SOCIAL O COMPORTAMIENTO
                    /*
				 $conslcov=mysql_query("SELECT COUNT(DISTINCTROW CODEST,CODIND) FROM CONVIVENCIA WHERE CODEST='$fila[7]' AND PERIODO=$periodoBol AND anho='$anho';");
				  while ($filaconv=mysql_fetch_array($conslcov)){
				  if ($filaconv[0]!=0){		*/	
                        
					  echo "<tr>
					  <td style='width:23.58%;border-top:1.5pt;border-left:1.5pt;border-bottom:1.0pt;border-right:1.0pt;border-color:windowtext;border-style:solid;padding:0cm 5.4pt 0cm 5.4pt'>
						<p class=MsoNormal align=right style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:right;line-height:normal'>
							<span lang=ES-AR>
								COMPORTAMIENTO SOCIAL
							</span>
						</p>
					  </td>
					  <td colspan=6 style='width:76.42%;border-top:solid windowtext 1.5pt;border-left:none;border-bottom:none;border-right:solid windowtext 1.5pt;padding:0cm 5.4pt 0cm 5.4pt'>
						<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal;font-size:8.0pt;'>
							<span lang=ES-AR>";
							// -----------   CONVIVENCIA SOCIAL 
							/*while ($fila12=mysql_fetch_array($resultlogros)){
								echo $fila12[0]."<br>";
							
							}*/echo "";
						echo "</span>
						</p>
						<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal'>
							<span lang=ES-AR style='font-size:6.0pt'>
								&nbsp;
							</span>
						</p>
					  </td>
					 </tr>";
				 //}
				 //}
				 echo "
				 <tr>
				  <td valign=top style='width:23.58%;border-top:solid windowtext 1.5pt;border-left:solid windowtext 1.5pt;border-bottom:solid windowtext 0.0pt;border-right: solid windowtext 0.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal align=right style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:left;line-height:normal'>
						<span lang=ES-AR>
							OBSERVACIONES:
						</span>
					</p>
				  </td>
				  <td colspan=6 style='width:76.42%;border-top:solid windowtext 1.5pt;border-left:none;border-bottom:none;border-right:solid windowtext 1.5pt;padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'><span lang=ES-AR style='font-size:6.0pt'>&nbsp;</span></p>
				  </td>
				 </tr>
				 <tr>
				  <td width='100%' colspan=7 valign=top style='width:100.0%;border:solid windowtext 1.5pt;border-top:none;padding:0cm 5.4pt 0cm 5.4pt'>
					<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'><span lang=ES-AR style='font-size:6.0pt'>&nbsp;</span></p>
					<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'><span lang=ES-AR style='font-size:6.0pt'>&nbsp;</span></p>
					<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'><span lang=ES-AR style='font-size:6.0pt'>&nbsp;</span></p>
					<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'><span lang=ES-AR style='font-size:6.0pt'>&nbsp;</span></p>
					<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'><span lang=ES-AR style='font-size:6.0pt'>&nbsp;</span></p>
					<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'><span lang=ES-AR style='font-size:6.0pt'>&nbsp;</span></p>
					
				  </td>
				 </tr>
				</table>
				</td>
						</tr>
					</table>
                    <br><br>
					<table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 style='border-collapse:collapse;border:none'>
						<tr>							
							<td width=273 valign=top style='width:204.5pt;padding:0cm 5.4pt 0cm 5.4pt'>
								<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:left;line-height:normal'>
									<b>
										<span lang=ES-AR>
											".utf8_encode(strtoupper($fila[17]." ".$fila[18]." ".$fila[19]." ".$fila[20]))/*Director de grupo */.
											"
										</span>
									</b>
								</p>
								<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:left;line-height:normal'>
									<span lang=ES-AR>
										Dir. De Grupo
									</span>
								</p>
							</td>
						</tr>
					</table>";
                    echo "";
					echo "<h1 style='page-break-after:always'>
						</h1>";
										
				}						
			}
		}
	}
?>
</body>
</html>