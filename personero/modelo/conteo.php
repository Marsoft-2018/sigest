<?php
    require("conBDT.php");
    class Conteo extends Conectar{
        function cargar(){
            echo "<table class='table table-striped' style='width:45%;margin:0 auto;'>";
	
            $consulta=mysql_query("SELECT * FROM candidatos");
            $total_candidatos=mysql_num_rows($consulta);
            $total_filas=ceil($total_candidatos/3);
            $cont=0;
            
            $totalg=0;	
            
            $consulta=mysql_query("SELECT ca.Id,al.`NOMBRE1`,al.`NOMBRE2`,al.`APELLIDO1`,al.`APELLIDO2`, COUNT(vt.Numero) AS 'Total Votos' 
            FROM  candidatos ca
            INNER JOIN alumnos al ON ca.`alumnos_CODEST`=al.`CODEST`
            LEFT JOIN registrovotos vt ON ca.`Id`=vt.`Numero`
            GROUP BY ca.`Id` ORDER BY 'Total Votos' DESC");
    
            echo    "<thead>";
            echo        "<tr>";
            echo            "<th colspan='4'><h1>TOTAL VOTOS POR CANDIDATO</h1></th>";
            echo        "</tr>";
            echo        "<tr class='TITULO'>";
            echo            "<th>No.</th>";
            echo            "<th>NOMBRE DEL CANDIDATO</th>";
            echo            "<th>TOTAL VOTOS</th>";
            echo        "</tr>";
            echo    "</thead>";
            echo    "<tbody>";
    
            while ($candidato=Mysql_fetch_array($consulta)){	
                echo "<tr> ";													
                if ($candidato[0]<=9){
                    echo "<TD class='centrar'>0".$candidato[0]."</TD>";
                }else{
                   echo "<TD class='centrar'>".$candidato[0]."</TD>";
                }
                   echo "<td class=''>".$candidato[1]." ".$candidato[2]." ".$candidato[3]." ".$candidato[4]."</td>
                         <td class='centrar'>".$candidato[5]."</td>";
                   $totalg=$totalg+$candidato[5];	            
                   echo "</td>";
                   $cont=$cont+1;
                   echo "</tr>";					
			}	
   
            echo    "</tbody>";
            echo    "<tfoot>";
            echo        '<tr style="background-color:rgba(101, 174, 217,0.5);color:#000;">';
            echo            "<td colspan='2' >TOTAL</td>";
            echo            "<td class='centrar'> $totalg </td>";
            echo        "</tr>";
            echo    "</tfoot>";
            echo    "</table>";
            
            //gráfico
            
            echo "<div style='height:200px; width:50%;margin:0 auto;padding:50px;margin-bottom:150px;'>";
            echo    "<div><h1>Gráficos Estadísticos</h1></div><br>";
    
            $consulta2=Mysql_query("SELECT ca.Id,al.`NOMBRE1`,al.`NOMBRE2`,al.`APELLIDO1`,al.`APELLIDO2`, COUNT(vt.Numero) AS 'Total Votos' 
            FROM  candidatos ca
            INNER JOIN alumnos al ON ca.`alumnos_CODEST`=al.`CODEST`
            LEFT JOIN registrovotos vt ON ca.`Id`=vt.`Numero`
            GROUP BY ca.`Id` ORDER BY 'Total Votos' DESC");

            while ($candidatog=Mysql_fetch_array($consulta2)){
                @$porcentaje=($candidatog[5]*100)/$totalg;
                echo "<table class='grafico'>";
                echo  "<tr>";
                echo	"<td class='barra2' width='200'><b>".$candidatog[1]." ".$candidatog[2]." ".$candidatog[3]." ".$candidatog[4]."</b></td>";
                echo	"<td class='barra3'  width='40'>".(round($porcentaje,2))." %&nbsp;</td>";
                echo	"<td width='".((round($porcentaje,0))*3)."'  class='barra1'>&nbsp;</td>
                    <td class='barraD'><i>$candidatog[5]</i></td>
                    </tr>
                    </table>";
                $cont=$cont+1;				
            }	
            echo "</div>";
        }        
    }

    class Abstencion extends Conectar{
        function cargar(){
            echo "<table class='table table-striped' style='width:45%;margin:0 auto;'>";
	
            $consulta=mysql_query("SELECT * FROM candidatos");
            $total_candidatos=mysql_num_rows($consulta);
            $total_filas=ceil($total_candidatos/3);
            $cont=0;
            
            $totalg=0;	
            
            $consulta=mysql_query("SELECT al.`SEXO`,COUNT(al.EST) AS 'Total Votos' 
            FROM  alumnos al 
            WHERE al.`EST`='No ha votado'
            GROUP BY al.`SEXO` ORDER BY al.SEXO DESC");
    
            echo    "<thead>";                    
            echo        "<tr>";
            echo            "<th colspan='2'><h1>TOTAL VOTOS FALTANTES</h1></th>";
            echo        "</tr>";
            echo        "<tr class='TITULO'>";
            echo            "<th>GENERO</th>";
            echo            "<th>TOTAL VOTOS</th>";
            echo        "</tr>";
            echo    "</thead>";
            echo    "<tbody>";
    
            while ($candidato=Mysql_fetch_array($consulta)){	
                echo "<tr> ";
                echo    "<td class='centrar'>".$candidato[0]."</td>";
                echo    "<td class=''>".$candidato[1]."</td>";
			             $totalg=$totalg+$candidato[1];	            
                echo    "</td>";	           
                echo "</tr>";
                $cont=$cont+1;
			}	
   
            echo    "</tbody>";
            echo    "<tfoot>";
            echo        '<tr style="background-color:rgba(101, 174, 217,0.5);color:#000;">';
            echo            "<td >TOTAL</td>";
            echo            "<td class='centrar'> $totalg </td>";
            echo        "</tr>";
            echo    "</tfoot>";
            echo    "</table>";
            
            //gráfico
            
            echo "<div style='height:200px; width:50%;margin:0 auto;padding:50px;margin-bottom:150px;'>";
            echo    "<div><h1>Gráficos Estadísticos</h1></div><br>";
    
            $consulta2=Mysql_query("SELECT al.`SEXO`,COUNT(al.EST) AS 'Total Votos' 
            FROM  alumnos al 
            WHERE al.`EST`='No ha votado'
            GROUP BY al.`SEXO` ORDER BY al.SEXO DESC");

            while ($candidatog=Mysql_fetch_array($consulta2)){
                $sexo;
                if($candidatog[0]=="M"){
                    $sexo="HOMBRES";
                }elseif($candidatog[0]=="F"){
                    $sexo="MUJERES";
                }
                $porcentaje=($candidatog[1]*100)/$totalg;
                echo "<table class='grafico'>";
                echo  "<tr>";
                echo	"<td class='barra2' width='200'><b>".$sexo."</b></td>";
                echo	"<td class='barra3'  width='40'>".(round($porcentaje,2))." %&nbsp;</td>";
                echo	"<td width='".((round($porcentaje,0))*3)."'  class='barra1'>&nbsp;</td>
                    <td class='barraD'><i>$candidatog[1]</i></td>
                    </tr>
                    </table>";
                $cont=$cont+1;				
            }	
            echo "</div>";
        }        
    }
?>