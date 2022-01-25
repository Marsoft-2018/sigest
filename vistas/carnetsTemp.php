<link rel="stylesheet" href="../estilosCSS/carnets.css">
<?php
    require("../class/Conect.php");
    require("../class/carnet.php");
    $curso     = $_POST['curso'];
    $tipoDatos = $_POST['tipoDatos'];
    $anho      = $_POST['anho'];

    $orientacion = 'marco'.substr($tipoDatos,8,1);
    $modelo      = substr($tipoDatos,6,1);
    $centro      = '';
    $membrete    = '';
    $sede        = '';
    $gradoGrupo  = 0;
    $logo        = "Colombia.png";

    $objCarnet = new Carnet();
    //Consulta para membretear 

    $sqlDatosMembrete = $objCarnet->consultaMembrete($curso);
    
    while($dm = mysql_fetch_array($sqlDatosMembrete)){
        $centro     = $dm[0];
        $membrete   = $dm[2];
        $sede       = $dm[4];
        $gradoGrupo = $dm[5]."° ".$dm[6];        
        $codSede    = $dm[7];
        $logo       = $dm[8];
    }    
        
    //-------------- Consulta para recorrer el listado de estudiantes en el curso ----------------//

    $sqlEst = $objCarnet->consultaEstudiantes($codSede,$curso,$anho,0);

    /*
    echo $curso."<br>";
    echo $tipoDatos."<br>";
    echo $anho      ."<br>";

    echo $orientacion ."<br>";
    echo $modelo ."<br>";
    echo $centro."<br>";    
    echo $membrete ."<br>"; 
    echo $sede ."<br>";     
    echo $gradoGrupo."<br>";
    */

    //$resultalum=mysql_query($sqlEst,$conexion) or die ("NO TRAJO LOS NOMBRE DE LOS ALUMNOS<BR>".mysql_error());
    
 
    //Registros por estudiantes
    while ($alumno=mysql_fetch_array($sqlEst)){	
            $foto = "silueta.png";
            echo    "<div class='".$orientacion."' id='".$orientacion."' style='background: url(../IMAGENES/Carnets/".$tipoDatos.".png);background-repeat:no-repeat;'>";
            if($modelo == 1 or $modelo == 3 or $modelo == 4){                
                echo    "<table class='tipo1' id='tipo1'>";
                echo        "<tr>";
                echo            "<td colspan='4'>";
                echo                "<div class='institucion color".$modelo."'>".strtoupper(utf8_encode($centro))."</div>";
                echo            "</td>";
                echo            "<td rowspan='4' width='10%' height='20'>";
                echo                "<div class='escudo1'><img src='../IMAGENES/$logo'></div>";
                echo            "</td>";
                echo        "</tr>";                
                echo        "<tr>";
                echo            "<td colspan='4' >";
                echo                "<div class='membrete'>".utf8_encode($membrete)."</div>";
                echo            "</td>";
                echo        "</tr>";
                
                echo        "<tr>";
                echo            "<td colspan='4' >";
                echo                "<div class='sede color".$modelo."'>SEDE ".strtoupper($sede)."</div>";
                echo            "</td>";
                echo        "</tr>";
                
                echo        "<tr>";
                echo            "<td rowspan='4'>";
                ///espacio para la foto
                echo                "<div class='foto1' >";
                                        $sqlFotoEstudiante=mysql_query("SELECT * FROM fotoestudiantes WHERE IDUsuario='$alumno[0]';");
                                        $res=mysql_num_rows($sqlFotoEstudiante);
                                        if($res==0){
                                            echo "<img src='../IMAGENES/Usuarios/$foto' id='fotoUs'>";
                                        }else{
                                            while($foto=mysql_fetch_array($sqlFotoEstudiante)){
                                                echo "<img src='../IMAGENES/Usuarios/$foto[2]' id='fotoUs'>";
                                            }
                                        }                                        
                echo                "</div>";
                echo                "<div class='codigo'>$alumno[0]</div>";
                echo            "</td>";
                echo            "<td colspan='3'>";
                echo                "<div class='sede color".$modelo."'>DATOS DEL ESTUDIANTE</div>";
                echo            "</td>";
                echo        "</tr>";
                
                echo        "<tr>";
                echo            "<td colspan='4' >";
                echo                "<div class='dato'>".strtoupper(utf8_encode($alumno[3])." ".utf8_encode($alumno[4]))."</div>";
                echo            "</td>";
                echo        "</tr>";
                
                echo        "<tr>";
                echo            "<td colspan='4' >";
                echo                "<div class='dato'>".strtoupper(utf8_encode($alumno[1])." ".utf8_encode($alumno[2]))."</div>";
                echo            "</td>";
                echo        "</tr>";
                
                echo        "<tr>";
                echo            "<td colspan='2' >";
                echo                "<div class='dato2'>SEXO:  $alumno[5] &nbsp;&nbsp;&nbsp;&nbsp;CURSO: $gradoGrupo &nbsp;&nbsp; AÑO: $anho</div>";
                echo            "</td>";
                echo            "<td colspan='2' >";
                
                echo            "</td>";
                echo        "</tr>";
                
                echo        "<tr>";
                echo            "<td>";
                echo            "</td>";
                echo            "<td colspan='4'>&nbsp;";
                echo            "</td>";
                echo        "</tr>";                
                echo    "</table>";
                
            }elseif($modelo==2){
                echo    "<table class='tipo1'>";
                echo        "<tr>";
                echo            "<td>";
                echo                "<div class='escudo2'><img src='../IMAGENES/$logo'></div>";
                echo            "</td>";
                echo            "<td colspan='3' >";
                echo                "<div class='institucion color".$modelo."' style='margin-top:-10px; display:block; text-align:left;'>";
                echo                    utf8_encode($centro);
                echo                "</div>";
                echo                "<div class='sede color".$modelo."' style='text-align:left;'>SEDE $sede</div>";
                echo            "</td>";
                echo        "</tr>"; 
                
                echo        "<tr>";
                echo            "<td rowspan='4' style='width:20%;'>";
                ///espacio para la foto
                echo                "<div class='foto1' >";
                                        $sqlFotoEstudiante=mysql_query("SELECT * FROM fotoestudiantes WHERE IDUsuario='$alumno[0]';");
                                        $res=mysql_num_rows($sqlFotoEstudiante);
                                        if($res==0){
                                            echo "<img src='../IMAGENES/Usuarios/$foto' id='fotoUs'>";
                                        }else{
                                            while($foto=mysql_fetch_array($sqlFotoEstudiante)){
                                                echo "<img src='../IMAGENES/Usuarios/$foto[2]' id='fotoUs'>";
                                            }
                                        }                                        
                echo                "</div>";
                echo                "<div class='codigo'>$alumno[0]</div>";
                echo            "</td>";
                echo            "<td colspan='3'>";
                echo                "<div class='sede color".$modelo."'>DATOS DEL ESTUDIANTE</div>";
                echo            "</td>";
                echo        "</tr>";
                
                echo        "<tr>";
                echo            "<td colspan='4' >";
                echo                "<div class='dato' style='margin:0px;margin-left:20px;'>".strtoupper(utf8_encode($alumno[3])." ".utf8_encode($alumno[4]))."</div>";
                echo            "</td>";
                echo        "</tr>";
                
                echo        "<tr>";
                echo            "<td colspan='4' >";
                echo                "<div class='dato' style='margin:0px;margin-left:20px;'>".strtoupper(utf8_encode($alumno[1])." ".utf8_encode($alumno[2]))."</div>";
                echo            "</td>";
                echo        "</tr>";
                
                echo        "<tr>";
                echo            "<td colspan='2' >";
                echo                "<div class='dato2' style='margin:0px;margin-left:20px;width:50%;'>SEXO:  $alumno[5] &nbsp;&nbsp;&nbsp;&nbsp;CURSO: $gradoGrupo &nbsp;&nbsp;AÑO: $anho</div>";
                echo            "</td>";
                echo            "<td colspan='2' >&nbsp;";
                echo            "</td>";
                echo        "</tr>";
                
                    
                echo        "<tr>";
                echo            "<td colspan='2'>";
                echo            "</td>";
                echo            "<td colspan='2'>";
                
                echo            "</td>";
                echo        "</tr>";                
                echo    "</table>";
            }
        
            if($modelo>4){
                echo    "<table class='tipo2'>";
                echo        "<tr>";
                echo            "<td>";
                echo                "<div class='escudo3'><img src='../IMAGENES/$logo'></div>";
                echo            "</td>";
                echo        "</tr>"; 
                
                echo        "<tr>";
                echo            "<td>";
                                if($modelo==5 or $modelo==8 ){
                echo                "<div class='institucionV color".($modelo-4)."'>".strtoupper(utf8_encode($centro))."</div>";
                                }else{
                echo                "<div class='institucionV color".($modelo-4)."'>".strtoupper(utf8_encode($centro))."</div>";
                                }
                echo            "</td>";
                echo        "</tr>";                
                echo        "<tr>";
                echo            "<td>";
                ///espacio para la foto
                echo                "<div class='foto1'>";
                                        $sqlFotoEstudiante=mysql_query("SELECT * FROM fotoestudiantes WHERE IDUsuario='$alumno[0]';");
                                        $res=mysql_num_rows($sqlFotoEstudiante);
                                        if($res==0){
                                            echo "<img src='../IMAGENES/Usuarios/$foto' id='fotoUs'>";
                                        }else{
                                            while($foto=mysql_fetch_array($sqlFotoEstudiante)){
                                                echo "<img src='../IMAGENES/Usuarios/$foto[2]' id='fotoUs'>";
                                            }
                                        }                                        
                echo                "</div>";
                echo            "</td>";
                echo        "</tr>";
                
                echo        "<tr>";
                echo            "<td >";
                echo                "<div class='datoV1'><strong>".strtoupper(utf8_encode($alumno[3])." ".utf8_encode($alumno[4]))."</strong></div>";
                echo            "</td>";
                echo        "</tr>";
                
                echo        "<tr>";
                echo            "<td>";
                echo                "<div class='datoV1'><strong>".strtoupper(utf8_encode($alumno[1])." ".utf8_encode($alumno[2]))."</strong></div>";
                echo            "</td>";
                echo        "</tr>";
                
                echo        "<tr>";
                echo            "<td>";
                echo                "<div class='datoV1 datoV2'>SEXO: $alumno[5] &nbsp;&nbsp;&nbsp;&nbsp;CURSO: $gradoGrupo &nbsp;&nbsp;AÑO: $anho</div>";
                echo            "</td>";
                echo        "</tr>";
                
                echo        "<tr>";
                echo            "<td align='center'>";
                echo                "<div class='sede color".($modelo-4)."' style='text-align:center;'>SEDE ".strtoupper($sede)."</div>";
                echo            "</td>";
                echo        "</tr>";
                                
                echo        "<tr>";
                echo            "<td>";
                echo                "<div class='codigoV'>$alumno[0]</div>";
                echo            "</td>";
                echo        "</tr>";                  
                
                echo        "<tr>";
                echo            "<td>";
                echo            "</td>";
                echo        "</tr>";
                echo    "</table>";
            }
        echo    "</div>";
    }       
//fin de las filas 
?>