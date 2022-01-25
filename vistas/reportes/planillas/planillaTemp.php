<link rel="icon" href="../../IMAGENES/Iconos/Icono.ico" />   

    <!-- Estilos CSS -->
    <link href="../../css/bootstraps3.1.css" rel="stylesheet">
   

   <style type="text/css">
    .clearfix:after {
          content: "";
          display: table;
          clear: both;
        }

        header {
          padding: 0px 0;
          margin-bottom: 3px;
        }

        #logo {
          text-align: left;
          margin-bottom: 2px;
            width: 100%;
        }

        #logo img {
          width: 30px;
        }

        h1 {
          border-top: 1px solid  #5D6975;
          border-bottom: 1px solid  #5D6975;
          color: #5D6975;
          font-size: 1.4em;
          line-height: 1.4em;
          font-weight: normal;
          text-align: center;
            margin-bottom: 1px;
            margin-top: 1px;
          background: url(img/dimension.png);
        }
        p{
            line-height: 2em;
            font-size: 14px;
            text-align: justify;
        }

        #project {
          float: left;
        }

        #project span {
          color: #5D6975;
          text-align: right;
          width: 52px;
          margin-right: 10px;
          display: inline-block;
          font-size: 0.8em;
        }

        #company {
          float: left;
          text-align: center;
            font-size: 10px;
            padding: 2px;
        }

        #project div,
        #company div {
          white-space: nowrap;        
        }

        table {
          width: 100%;
          border-collapse: collapse;
          border-spacing: 0;
            border: 1px solid #000;
        }

        table tr:nth-child(2n-1) td {
          background: #F5F5F5;
        }

        table th,
        table td {
            border: 1px solid #000;
        }

        table th {
          padding: 1px 20px;
          color: #000;
          border-bottom: 1px solid #000;
          white-space: nowrap;        
          font-weight: normal;
        }

</style>
<?php
    require("../../CONECT.php");    
    require("../../class/Conect.php");
    require("../../class/planillaYnotasClass.php"); 
    require("../../class/notaFinal.php");
    require("../../class/Boletin.php");

    $semanas=4;
    $dias=5;
    $diasT=$semanas*5;
    $diasLetra=array('L','M','M','J','V');
    $curso=$_POST['cursoBol'];
    $tipoDatos=$_POST['tipoDatos'];
    $centro='';
    $membrete='';
    $sede='';
    $gradoGrupo=0;
    if(isset($_POST['sedeBol'])){
        $codSede=$_POST['sedeBol']; 
    }  
    
    $anho = date("Y")  ;
    
if($curso!="Todos"){
     //Consulta para membretear la hoja
        
    $sqlDatosMembrete=mysql_query("SELECT cen.`NOMBREINST`,cen.`RECTOR`,cen.`membrete`,cen.CODINST,sd.`NOMSEDE`,cr.`CODGRADO`,cr.`grupo`,cen.`LOGO`
    FROM  cursos cr 
    INNER JOIN grados gr ON cr.CODGRADO=gr.CODGRADO
    INNER JOIN niveles nv ON gr.`CODNIVEL`=nv.`CODNIVEL`
    INNER JOIN sedes sd ON cr.`codSede`=sd.`CODSEDE`
    INNER JOIN centroeducativo cen ON sd.`CODINST`=cen.`CODINST`
    WHERE cr.`codCurso`='$curso';");/**/
    
    while($dm=mysql_fetch_array($sqlDatosMembrete)){
        $centro=$dm[0];
        $membrete=$dm[2];
        $sede=$dm[4];
        $gradoGrupo=$dm[5]."°".$dm[6];  
        $logo=$dm[7];
    }  

    //-------------- Consulta para recorrer el listado de estudiantes en el curso ----------------//
		
    $sqlEst="SELECT est.`Documento`,est.`PrimerApellido`,est.`SegundoApellido`,est.`PrimerNombre`,est.`SegundoNombre`,mt.`idMatricula` FROM estudiantes est  INNER JOIN matriculas mt ON mt.`Documento` = est.`Documento` WHERE mt.`Curso`='$curso' AND mt.`anho`='$anho' ORDER BY est.`PrimerApellido`,est.`SegundoApellido`,est.`PrimerNombre`,est.`SegundoNombre` ASC;";

    $resultalum=mysql_query($sqlEst,$conexion) or die ("NO TRAJO LOS NOMBRES DE LOS ALUMNOS<BR>".mysql_error());

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
            echo    "<td colspan='2' style='border:0px;padding:5px;'><strong>DOCENTE:</strong>__________________________________________</td>";
            if($tipoDatos=='Notas'){
                echo    "<td colspan='2' style='border:0px;'>PERIODO: </td>";
                echo    "<td colspan='2' style='border:0px;'>AREA/ASIGNATURA: </td>";
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
            echo    "<td class='bordes' width='32' >Código</td>";
            echo    "<td class='bordes' width='80'>ESTUDIANTE</td>";
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
                echo        "<td class=bordes style='border-right:1.0pt solid black'>$gradoGrupo</td>";
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
                echo        "<td class='bordesnom' style='font-size:11px;padding:3px;'>".strtoupper($alumno[1])." ".strtoupper($alumno[2])." ".strtoupper( $alumno[3])." ".strtoupper($alumno[4])."</td>"; 
                echo        "<td class=bordes style='border-right:1.0pt solid black'>$gradoGrupo</td>";
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
        }

        }else{
    $ProfesorUnitario=false;
    
    //recorro los profesores asignados en la sede
    $consultaProfes=mysql_query("SELECT IDUsuario,PrimerNombre,SegundoNombre,PrimerApellido,SegundoApellido FROM profesores WHERE codSede='$codSede'");
    $numProfes=mysql_num_rows($consultaProfes);
    $CursosSede=mysql_query("SELECT codCurso FROM cursos WHERE codSede='$codSede'");
    $conteoCursosSede=mysql_num_rows($CursosSede);
    
    while($rp=mysql_fetch_array($consultaProfes)){        
        $CursosProfesor=mysql_query("SELECT codCurso FROM distribucionCursos WHERE codProfesor='$rp[0]'");        
        $conteoCursosProfesor=mysql_num_rows($CursosProfesor);
        
        //Se evalua si cumple con la condicion de ser docente de multiples grados
        if($conteoCursosProfesor==$conteoCursosSede or $numProfes==1){
            include("planillaTempMulti.php");            
        }
        else{
            $ProfesorUnitario=false;
        }
    }
    
    if(! $ProfesorUnitario){
        include("planillaTempUnica.php");
    }
    
     

    
}
        //fin de las filas 

?>




<script src="../../js/jquery1.11.min.js"></script>
    <script src="../../js/jquery.PrintArea.js"></script>
    <script type="text/javascript" src="../../js/jquery-ui.js"></script>
    
    <!-- Bootstrap , datatables y alertify -->
    <script src="../../js/bootstrap.min.js"></script>   