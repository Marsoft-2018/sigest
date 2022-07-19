<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="../css/certificaciones.css">
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css" type="text/css">
    <link href="../css/bootstraps3.1.css" rel="stylesheet">
    <style>
        .ocultar{
                display: flex;
                justify-content: flex-start;
                width:100%;
                height:50px;
                padding:5px;
                background-color:rgba(141, 127,140,0.5);
                border-radius: 0px;
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
</head>
<body>
    <?php 
        include("barra_superior.php"); 
        
        foreach ($objInst->cargar() as $value) {
            $nombreInstitucion = $value['nombre'];
            $ciudad = $value['ciudad'];
            $aprobacion = $value['membrete'];
            $escudo = $value['logo'];
            $rector = $value['rector'];
        }

        $meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
        $dia=date('d');
        $mes=$meses[date('m')-1];
        $annoAct=date('Y');

        $sqltodoslosalumnos = "";

        $sqlAreas = new Area();        
        $sqlAreas->codSede = $sede;
        $sqlAreas->anho = $anho;
        $sqlAreas->idGrado = $grado;
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
        }

        
        foreach ($sqltodoslosalumnos as $estudiante) {
            $promedioFinal = 0;
            $desPromedio = "";
            $areaNum = 0;
            $areasPerdidas = 0;
            $promedioP1 = 0;
            $promedioP2 = 0;
            $promedioP3 = 0;
            $promedioP4 = 0;
            $grado = 0;
            $nivel = "";
            
            $articulo='o';
            if($estudiante['sexo']=='F'){ $articulo='a'; }
            
            $objGrado = new Grado();
            $objGrado->CODGRADO = $estudiante['CODGRADO'];
            foreach ($objGrado->cargar() as $grado) {
                $objNivel = new Grado();
                $objNivel->CODNIVEL = $grado['CODNIVEL'];
                foreach ($objNivel->cargar() as $nivel) {
                    $nivel = $nivel['NOMBRE_NIVEL'];
                }
                $grado = $grado['NOMGRADO'];
            }

            $notaMinima = $objCalificacion->notaBaja();
            $notaMaxima = $objCalificacion->notaMaxima();
            
           $idMatricula = $estudiante['idMatricula'];
           //echo $idMatricula;
           $objEstado = new Calificacion();
           $estadoDelAnho = strtoupper($objEstado->estadoAnho($areasPerdidas,$areasPerder));
           if($estadoDelAnho=='APROBADO'){
                $estadoDelAnho='APROBÓ';
            }elseif($estadoDelAnho=='REPROBADO'){
                $estadoDelAnho='REPROBÓ';
            }elseif($estadoDelAnho=='APLAZADO'){
                $estadoDelAnho='APLAZÓ';
            }
           $noLista++; 
        ?>

        <header>
            <div style="font-size:12px;text-align:center;"><strong>REPUBLICA DE COLOMBIA</strong></div>
            <div id="logo">
                <img src='../vistas/img/<?php echo $escudo; ?>' alt='Descripción: MEMBRETE' style='width:70px;'>
            </div>
            <div style="font-size:14px;text-align:center;">
                <div style="font-size:14px;text-align:center;">
                    <strong>
                        <?php echo $nombreInstitucion; ?><br>
                        SEDE 
                        <?php
                            foreach ($objSede->reportes() as $sedeN) {
                                echo $sedeN['NOMSEDE'];
                            }
                        ?>
                    </strong>
                </div>  
                <div style="font-size:12px;text-align:center;">
                    <?php echo $aprobacion; ?>
                </div>            
            </div>
            <div class="banda">CONSTANCIA DE ESTUDIO</div>
        </header>
        <main>
            <div>
                <h4 style="text-align:center;margin:0px;">EL SUSCRITO RECTOR</h4>
                <h4 style="text-align:center;line-height:2.5em;">HACE CONSTAR</h4>
                <p>
                    Que, <stromg><i><?php echo $estudiante['PrimerNombre']." ".$estudiante['SegundoNombre']." ".$estudiante['PrimerApellido']." ".$estudiante['SegundoApellido'] ?></i></strong> identificad<?php echo $articulo; ?> 
                    con el <?php echo $estudiante['tipoDocumento'] ?> Nº <?php echo $estudiante['Documento']  ?> 
                    es estudiante de este Plantel Educativo y se encuentra matriculad<?php echo $articulo; ?> en el grado <?php echo $grado; ?> de Educación <?php echo $nivel; ?>, en el presente año lectivo <?php echo $anho ?>, en la Jornada de la <?php echo $estudiante['jornadaNombre'] ?>.
                </p>
                <br>
                <p>
                    Dado en <?php echo $ciudad ?> Bolívar a los <?php echo $dia ?> dias del mes de  <?php echo $mes ?> de <?php echo $annoAct ?>.
                </p>
                <br>
                <br>
                <br>
                <h4 style="margin:1px;"><?php echo $rector ?></h4>
                <h4 style="margin:1px;">Rector</h4>
            </div>
            

        </main>
        <?php  
        }
    ?>
</body>
</html>