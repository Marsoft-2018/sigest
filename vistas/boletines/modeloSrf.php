<!Doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css" type="text/css">
        <link href="../css/bootstraps3.1.css" rel="stylesheet">
        <link rel='stylesheet' href='../css/boletinesPreescolar.css' type='text/css'/>    
        <style>
            .ocultar{
                    width:100%;
                    height:50px;
                    padding:5px;
                    background-color:rgba(141, 127,140,0.5);
                    border:1px solid rgba(240,230,150,0.5);
            }

            @media print
            {
                .ocultar{
                    display: none;
                    visibility:hidden;
                }
            }
            .bloq-areas td{
                border:1px solid #000;
                font-size: 10px;
            }
            .c{
                text-align: center;
            }

            .l{
                text-align: left;
            }

            .r{
                text-align: right;
            }

            .cn{
                text-align: center;
                font-weight: bold;
            }

            .ln{
                text-align: left;
                font-weight: bold;
            }

            .rn{
                text-align: right;
                font-weight: bold;
            }
        </style>
    </head>
    <body>

        <?php if (!isset($_POST['boletinEstudiante'])) { ?>
            <div class='ocultar'>
                <form action='../Controladores/ctrlBoletin.php' method='post'  style='float:left;'>
                    <input type='hidden' name='sede' value='<?php echo $sede ?>' >
                    <input type='hidden' name='curso' value='<?php echo $curso ?>' >
                    <input type='hidden' name='tipoB' value='<?php echo $tipoBoletin ?>' >
                    <input type='hidden' name='topeMinDeAreasEnBoletin' value='<?php echo $topeMinDeAreasEnBoletin ?>' >
                    <input type='hidden' name='anho' value='<?php echo $anho ?>' >
                    <input type='hidden' name='periodo' value='<?php echo $periodoBol ?>' >
                    <input type='hidden' name='centro' value='<?php echo $centro ?>' >
                    Pagina:</label><input type='number' name='Pg' value='<?php echo $pagina ?>'>
                    Cantidad de Boletines:</label><input type='number' name='Cant' value='<?php echo $registros ?>'>
                   <input type='submit' class='btn btn-primary' value='Ver Boletines' style='margin-left:20px;'>
                </form>
                <button class="btn btn-primary" onclick="javascript:window.print()" style="float:left; margin-left:20px; margin-right:20px; ">
                    <i class="fa fa-print"></i>Imprimir
                </button>
                <p>La pagina Cargada es la No. <?php echo $pagina ?></p>
            </div>
        <?php  
        } else{
            echo "Falta colocar opciones para descarga e imprimir el boletin";
        }
        ?>
        <?php   
            
        foreach ($objInst->cargar() as $key => $value) {
           $nombreInstitucion = $value['nombre'];
           $ciudad = $value['ciudad'];
           $aprobacion = $value['membrete'];
           if (!isset($_POST['boletinEstudiante'])) {
               $escudo = "../vistas/img/".$value['logo'];
           }else{
                $escudo = "vistas/img/".$value['logo']; 
           }
        }
        if($periodoBol != 'Final'){//Verifico cual periodo se quiere consultar si es diferente del final se imprime el periodo    correspondiente
            //echo "la sede es: $sede y el curso es: $curso el anho es: $anho<BR>";


            $sqltodoslosalumnos = "";
            $sqlAreas = $objPensum->cargarPensum();
            $objEstudiantes->sede= $sede;
            $objEstudiantes->curso= $curso;
            $objEstudiantes->anho= $anho;
            $objEstudiantes->Rinicio= $Rinicio;
            $objEstudiantes->registros= $registros;
            if(isset($_POST['Estudiante'])){
                if (!isset($_POST['boletinEstudiante'])) { 
                    $listaEstudiantes = $_POST['Estudiante'];
                    $sqltodoslosalumnos = $objEstudiantes->ConsultaEstudiantesEspecificos($listaEstudiantes, $Rinicio, $registros);
                }else{
                    $sqltodoslosalumnos = $objEstudiantes->cargarEstudiante($_POST['Estudiante'], 1, 1);
                }
            }else{
                $sqltodoslosalumnos = $objEstudiantes->listar();
                //var_dump($sqltodoslosalumnos);
            }

        
            foreach ($sqltodoslosalumnos as $campo) {
               $idMatricula = $campo['idMatricula']; 
                if($grado <= 0 ){
                    include("preescolar/encabezado.php");
                    foreach ($sqlAreas as $key => $area) {
                        include("preescolar/bloqueAreas.php");
                    }                        
                }else{
            ?>            
            <div >
                <?php
                    include("encabezadoM2.php");
                    foreach ($sqlAreas as $key => $area) {
                        include("../vistas/boletines/bloqueAreas-M2.php");
                    ?>             
                        <div style="width: 100%; height: 20px;"></div>
                        <?php 
                    }
                ?>  

                <?php 
                    include("pieM2.php"); 
                    }
                ?>
                        
            <table class="MsoTableGrid" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; border:none; margin-top: 40px;">
                <tr>                            
                    <td valign="top" style="width: 40%; padding:0cm 5.4pt 0cm 5.4pt">
                        <p class=MsoNormal align=center style='margin-bottom:0cm; margin-bottom:.0001pt; text-align:left;line-height:normal'>
                            <b>
                                <span lang=ES-AR><?php echo $directorGrupo; ?></span>
                            </b>
                        </p>
                        <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:left;line-height:normal'>
                            <span lang=ES-AR>
                                Dir. De Grupo
                            </span>
                        </p>
                    </td>
                </tr>
            </table>
        </div>
        <h1 style='page-break-after:always'></h1>

    <?php 
    }
    } ?>
</body>
</html>