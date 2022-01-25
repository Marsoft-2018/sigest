<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css" type="text/css">
        <link href="../css/bootstraps3.1.css" rel="stylesheet">
        <title>Boletin Final M1</title>
        <style>
            .ocultar{
                    width:100%;
                    height:50px;
                    padding:5px;
                    background-color:rgba(141, 127,140,0.5);
                    border-bottom: 1px solid rgba(240,230,150,0.5);
            }

            @media print{
                .ocultar{
                    display: none;
                    visibility:hidden;
                }
            }
             
        </style>

    <?php
        foreach ($objInst->cargar() as $key => $value) {
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

            //----INICIO DEL BOLETIN FINAL -------
            //Consulta para obtener los alumnos del curso a consultar
            
        $sqltodoslosalumnos = "";
        $sqlAreas = $objPensum->cargarPensum();
        $objEstudiantes->sede= $sede;
        $objEstudiantes->curso= $curso;
        $objEstudiantes->anho= $anho;
        $objEstudiantes->Rinicio= $Rinicio;
        $objEstudiantes->registros= $registros;

        if(isset($_POST['Estudiante'])){
            $listaEstudiantes = $_POST['Estudiante'];
            $sqltodoslosalumnos = $objEstudiantes->ConsultaEstudiantesEspecificos($listaEstudiantes,$Rinicio,$registros);
        }else{
            $sqltodoslosalumnos = $objEstudiantes->listar();
            //var_dump($sqltodoslosalumnos);
        }

        
        foreach ($sqltodoslosalumnos as $campo) {
           $idMatricula = $campo['idMatricula'];
           $noLista++;
           include("partes M1/encabezado.php");
           include("partes M1/pie.php");
        }
        ?> 
    </body>
</html>