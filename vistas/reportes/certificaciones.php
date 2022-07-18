<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="plantilla/css/estilo.css">
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css" type="text/css">
    <link href="../css/bootstraps3.1.css" rel="stylesheet">
    <style>
        .ocultar{
                width:100%;
                height:50px;
                padding:5px;
                background-color:rgba(141, 127,140,0.5);
                border-radius:10px;
                border:1px solid rgba(240,230,150,0.5);
        }
     @media print
        {
            .ocultar{
                display: none;
                visibility:hidden;
            }
        }
    </style>

<?php

$tipoB      = $_POST['tipoB'];
    echo "<title>$tipoB $anho</title>";
/*---------------------------------- CONSULTAS -------------------------------------*/
/*require("../CONECT.php");
require("../../modelo/Conect.php");
//require("../class/planillaYnotasClass.php"); 
require("../class/notaFinal.php");
require("../class/Boletin.php");
$sede       = $_POST['sedeBol'];
$curso      = $_POST['cursoBol'];
$anho       = $_POST['anho'];
$periodoBol = $_POST['periodoBol'];
$centro     = $_POST['centro'];
$topeMinDeAreasEnBoletin = $_POST['topeMinDeAreasEnBoletin'];

if(isset($_POST['Pg'])){
    $pagina=$_POST['Pg'];
    $registros=$_POST['Cant'];
}else{
    $pagina=1;
    $registros=10;
}
$Rinicio;


    if(is_numeric($pagina)){
        $Rinicio=(($pagina-1)*$registros);
    }else{
        $Rinicio=0;
    }

    echo "</head>";

    
    
    echo "<body>";
    echo "<div class='ocultar'>";
    echo "La pagina Cargada es: $pagina.";
    echo "<form action='certificaciones.php' method='post' style='float:left;'>";
    echo "<input type='hidden' name='sedeBol' value='$sede' >";
    echo "<input type='hidden' name='cursoBol' value='$curso' >";
    echo "<input type='hidden' name='anho' value='$anho' >";
    echo "<input type='hidden' name='tipoB' value='$tipoB' >";
    echo "<input type='hidden' name='centro' value='$centro' >";
    echo "Pagina:<input type='number' name='Pg' value='$pagina' >";
    echo "Cantidad de certificados:<input type='number' name='Cant' value='$registros' >";
    echo "<input type='submit' class='btn btn-primary' value='Ver Certificado' style='margin-left:20px;'>";
    echo "</form>";
    echo '<button class="btn btn-primary" onclick="javascript:window.print()" style="float:left;margin-left:20px;margin-right:20px;"><i class="fa fa-print"></i>Imprimir</button>';
echo "</div>";
*/
//SAcado de boletin final

        foreach ($objInst->cargar() as $value) {
           $nombreInstitucion = $value['nombre'];
           $ciudad = $value['ciudad'];
           $aprobacion = $value['membrete'];
           $escudo = $value['logo'];
        }

    echo "</head>";
    echo "<body>";
    echo "<div class='ocultar'>";
    echo "La pagina Cargada es: $pagina.";
    echo "<form action='ctrlBoletin.php' method='post' style='float:left;'>";
        echo "<input type='hidden' name='sede' value='$sede' >";
        echo "<input type='hidden' name='curso' value='$curso' >";
        echo "<input type='hidden' name='anho' value='$anho' >";
        echo "<input type='hidden' name='periodo' value='$periodoBol' >";
        echo "<input type='hidden' name='tipoB' value='$tipoBoletin' >";
        echo "<input type='hidden' name='centro' value='$centro' >";
        echo "Pagina:<input type='number' name='Pg' value='$pagina' >";
        echo "Cantidad de Boletines:<input type='number' name='Cant' value='$registros' >";
        echo "<input type='submit' class='btn btn-primary' value='Ver Boletines' style='margin-left:20px;'>";
        echo "</form>";
        echo '<button class="btn btn-primary" onclick="javascript:window.print()" style="float:left;margin-left:20px;margin-right:20px;">
                <i class="fa fa-print"></i>Imprimir
                </button>';
        echo "</div>"; 
        //hasta aqui
    if($tipoB == 'Certificado'){
        
        $objEncabezado = new Boletin();
            //----INICIO DEL BOLETIN FINAL -------
        //Consulta para obtener los alumnos del curso a mostrar
        $sqltodoslosalumnos = "";
        if(isset($_POST['Estudiante'])){
            $listaEstudiantes = $_POST['Estudiante'];
            $sqltodoslosalumnos = $objEncabezado->ConsultaEstudiantesEspecificos($sede,$curso,$listaEstudiantes,$anho,$Rinicio,$registros);
        }else{
            $sqltodoslosalumnos = $objEncabezado->ConsultaEstudiantes($sede,$curso,$anho,$Rinicio,$registros);
        }

        while ($alumnoe=mysql_fetch_array($sqltodoslosalumnos)){
        
            $sqlconteo="SELECT COUNT(DISTINCTROW codArea)FROM notas WHERE idMatricula='$alumnoe[5]' AND Anho='$anho'";
            $rconteo =mysql_query($sqlconteo) OR DIE ("NO HAY MATERIAS PARA ESTE alumno");
            while ($regicont=mysql_fetch_array($rconteo)){
                
                if ($regicont[0] >= 2){                    
                    //------------------ CONSULTA ENCABEZADO DEL BOLETIN ---------------------------->       

                    $sqlbole = $objEncabezado->ConsultaEncabezado($centro,$sede,$curso,$anho,$alumnoe[5]);
                    while ($fila=mysql_fetch_array($sqlbole)){
                        
                        $articulo='o';
                        if($fila[28]=='F'){ $articulo='a'; }
                        $campo=0;
                        $sql_grado=mysql_query("SELECT gr.nomCampo FROM grados gr INNER JOIN cursos cr ON cr.`CODGRADO`=gr.`CODGRADO` WHERE cr.`codCurso`='$curso';");
                        while($ng=mysql_fetch_array($sql_grado)){
                            $campo=$ng[0];
                        }

                        $sqlAreas=mysql_query("SELECT axs.`idAreaSede`,axs.`Nombre`,axs.`formaDePromediar`,axs.`$campo` FROM areasxsedes axs WHERE axs.`codsede`='$sede' AND axs.`$campo`<>0;");
                        $meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
                        $dia=date('d');
                        $mes=$meses[date('m')-1];
                        $annoAct=date('Y');

            $objEstado = new estadoFinalAnho();
            $estadoDelAnho=$objEstado->cargar($centro,$sede,$campo,$anho,$fila[30]);
            
            
            if($estadoDelAnho=='APROBADO'){
                $estadoDelAnho='APROBÓ';
            }elseif($estadoDelAnho=='REPROBADO'){
                $estadoDelAnho='REPROBÓ';
            }elseif($estadoDelAnho=='APLAZADO'){
                $estadoDelAnho='APLAZÓ';
            }                        
        ?>

        <!----------- ENCABEZADO DEL BOLETIN --------------------------- // -->
                <header>
                      <div style="font-size:12px;text-align:center;"><strong>REPUBLICA DE COLOMBIA</strong></div>
                      <div id="logo">
                        <img src='../IMAGENES/<?php echo $fila[5]; ?>' alt='Descripción: MEMBRETE' style='width:70px;'>
                      </div>
                      <div style="font-size:14px;text-align:center;">
                        <div style="font-size:14px;text-align:center;"><strong><?php echo utf8_encode($fila[0]); ?><br>SEDE <?php echo $fila[6]; ?></strong></div>  
                        <div style="font-size:12px;text-align:center;"><?php echo utf8_encode($fila[27]); ?></div>            
                      </div>
                      <div class="banda">CERTIFICADO DE ESTUDIO</div>
                </header>
                    <main>
                        <div>
                            <h4 style="text-align:center;margin:0px;">EL SUSCRITO RECTOR</h4>
                            <h4 style="text-align:center;line-height:2.5em;">CERTIFICA</h4>
                            <p>
                                Que, <stromg><i><?php echo utf8_encode(strtoupper($fila[8]." ".$fila[9]." ".$fila[10]." ".$fila[11])); ?></i></strong> identificad<?php echo $articulo; ?> con el <?php echo $fila[29] ?> Nº <?php echo $fila[7] ?> cursó y <?php echo $estadoDelAnho ?>  el grado <?php echo utf8_encode($fila[12]); ?> de Educación <?php echo $fila[21]; ?> durante el año lectivo <?php echo $anho ?> de acuerdo con la Ley 715 del 2001, el Decreto 1290 de Abril  del 2009 y el Proyecto Educativo Institucional, con las siguientes valoraciones finales. 
                            </p>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th><strong>ÁREAS / ASIGNATURAS</strong></th>
                                        <th><strong>I.H</strong></th>
                                        <th><strong>VALORACIÓN INSTITUCIONAL<br>(Escala de 1 a 5)</strong></th>
                                        <th><strong>DESEMPEÑO ACADÉMICO</strong></th>
                                    </tr>                        
                                </thead>
                                <tbody>
                                    <?php 
                                        while($ar=mysql_fetch_array($sqlAreas)){
                                            echo '<tr>
                                                    <td style="text-align:left;padding: 5px;">'.utf8_encode($ar[1]).'</td>
                                                    <td>'.$ar[3].'</td>';
                                                            $objNota=new NotaFinal();
                                                            $nt=$objNota->cargar($ar[0],$campo,$anho,$centro,$fila[30],$ar[2]);
                                                            $objDes= new Desempenho();
                                                            $desempeno = $objDes->Cargar($nt,$centro);
                                            echo    '<td>'.number_format($nt,1,'.','').'</td>
                                                    <td>'.$desempeno.'</td>
                                                    </tr>';
                                        }
                                        
                                        $objNota=new NotaFinal();
                                        $promedio=$objNota->cargarPromedio($campo,$anho,$centro,$fila[30],$sede);
                                        $objDes= new Desempenho();
                                        $desempenoGen = $objDes->Cargar($promedio,$centro);
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2"><strong>PROMEDIO GENERAL: </strong></td>
                                        <td><?php echo number_format($promedio,2,'.','') ?></td>
                                        <td><?php echo $desempenoGen ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <p>
                                Dado en <?php echo utf8_encode($fila[25]) ?> Bolívar a los <?php echo $dia ?> dias del mes de  <?php echo $mes ?> de <?php echo $annoAct ?>.
                            </p>
                            <br>
                            <br>
                            <br>
                            <h4 style="margin:1px;"><?php echo $fila[26] ?></h4>
                            <h4 style="margin:1px;">Rector</h4>
                        </div>
                      

                    </main>
            <!--    </td>
            </tr>      
        </table>  
        </div> --> 
        <div style='page-break-after:always'>&nbsp;</div>
        <?php
                    }//FIN DEL RECORRIDO DE LOS DATOS DEL ENCABEZADO DEL BOLETIN                        
                }//FIN DE LA CONDICION PARA IMPRIMIR EL MIN DE AREAS EN EL BOLETIN
            }//FIN DEL CONTEO DE LAS AREAS EN LA TABLA NOTAS
        }// FIN RECORRIDO DE ALUMNOS
    }elseif($tipoB == 'Constancia'){
        $meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');

        $objEncabezado = new Boletin();
        //Consulta para obtener los alumnos del curso a consultar
        $sqlEst = "";
        if(isset($_POST['Estudiante'])){
            $listaEstudiantes = $_POST['Estudiante'];
            $sqlEst = $objEncabezado->ConsultaEstudiantesEspecificos($sede,$curso,$listaEstudiantes,$anho,$Rinicio,$registros);
        }else{
            $sqlEst = $objEncabezado->ConsultaEstudiantes($sede,$curso,$anho,$Rinicio,$registros);
        }
        //$sqlEst = $objEncabezado->ConsultaEstudiantes($sede,$curso,$anho,$Rinicio,$registros);

        while($r=mysql_fetch_array($sqlEst)){
            $sqlbole    = $objEncabezado->ConsultaEncabezado($centro,$sede,$curso,$anho,$r[5]);
            while($m = mysql_fetch_array($sqlbole)){
                $centro     =   utf8_encode($m[0]);
                $rector     =   $m[26];
                $logo       =   $m[5];
                $membrete   =   utf8_encode($m[27]);
                $grado      =   $m[14];
                $grupo      =   $m[15];
                $nivel      =   $m[21];
                $annLectivo =   $anho;
                $jornada    =   utf8_encode($m[16]);
            }

            $estudiante =   $r[3]." ".$r[4]." ".$r[1]." ".$r[2];
            $numDoc     =   $r[0]; 
            $sexo       =   $r[6];
            $tipoDoc    =   $r[7];
            /*$estCurso   =   $r[7];
            $centro     =   $r[8];
            $rector     =   $r[9];
            $membrete   =   utf8_encode($r[10]);
            $grado      =   $r[11];
            $grupo      =   $r[15];
            $nivel      =   $r[12];
            $annLectivo =   $r[13];
            $jornada    =   utf8_encode($r[14]);*/
            if($sexo == 'F' ){ 
                $articulo ='a' ; 
            }else{ 
                $articulo ='o'; 
            }
            $dia=date('d');
            $mes=$meses[date('m')-1];
            $annoAct=date('Y');
            $codHtml='
                <header class="clearfix">
                  <div id="logo" style="width:100%;text-align:center;">
                    <img src="../IMAGENES/'.$logo.'" style="width:100px;">
                  </div>
                  <div style="text-align:center">
                    <div style="font-size:14px;"><strong>'.$centro.'</strong></div>  
                    <div style="font-size:9px;width:60%;margin:0 auto;margin-bottom:20px;">'.$membrete.'</div>
                    <h4>CONSTANCIA DE ESTUDIO</h4>            
                  </div>
                  <br>
                </header>
                <main>
                    <div style="font-size:14px;text-align:justify;padding:20px;">
                        <h4 style="text-align:center;line-height:1.5em;">EL SUSCRITO RECTOR DE LA '.$centro.'</h4>
                        <h3 style="text-align:center;line-height:2.5em;">HACE CONSTAR </h3>
                        <p>
                            Que, <stromg><i>'.$estudiante.'</i></strong>. identificad'.$articulo.' con '.$tipoDoc.' No. '.$numDoc.' es estudiante de este Plantel Educativo y se encuentra matriculad'.$articulo.' en el grado '.$grado.'° '.$grupo.' de Educación '.$nivel.', en el presente año lectivo '.$annLectivo.', en la Jornada de la '.$jornada.'. 
                        </p>
                        <br>
                        <p>
                            Dado en El Carmen de Bolívar a los '.$dia.' dias del mes de  '.$mes.' de '.$annoAct.'.
                        </p>
                        <br>
                        <br>
                        <h4>'.$rector.'</h4>
                        <h4>Rector</h4>
                    </div>
            </main>'; 
            echo $codHtml;
            echo "<div style='page-break-after:always'>&nbsp;</div>";
        }        
    }    
?>
</body>
</html>