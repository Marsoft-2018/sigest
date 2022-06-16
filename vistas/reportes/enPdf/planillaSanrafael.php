<?php 
    $objEstudiantes->sede = $sede;
    $objEstudiantes->curso = $curso;
    $objEstudiantes->anho = $anho;
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Planilla por periodo</title>
    <link rel="stylesheet" href="plantilla/css/estilo.css">
    <link rel="stylesheet" href="../../../font-awesome/css/font-awesome.min.css" type="text/css">
    <link href="../../../css/bootstraps3.1.css" rel="stylesheet">
    <link href="../../../css/listas.css" rel="stylesheet">	
</head>
<body>
 <?php 
	$objAreas = new Area();
	$objAreas->curso = $_POST['curso'];
	$objAreas->anho = $_POST['anho'];

	foreach ($objAreas->cargarTodasLasAreas() as $campo) {
	    $profesor = "";
        $objProfe = new cargaAcademica();
        $objProfe->codCurso = $curso;
        $objProfe->codigoA = $campo['id'];
        $objProfe->anho = $anho;
        
        foreach($objProfe->cargarCelda() as $pro){
            $profesor = $pro['nombre'];
        }
	
	?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th colspan="13">					
					<div id="logo">
						<img src="../../img/<?php echo $escudo ?>"  style="width:40px; height:40px; margin:0px;">
						<h1 style="padding: 0px; margin: 2px;">COLEGIO SAN RAFAEL</h1>
					</div>
				</th>
			</tr>
			<tr>
				<th colspan="13">
					<h3 style="padding: 0px; margin: 2px;">PLANILLA DE CALIFICACIONES</h3>
				</th>
			</tr>
			<tr>
				<th colspan="3">AREA/ASIGNATURA: <strong><?php echo strtoupper($campo['Nombre']) ?></strong></th>
				<th>PERIODO: <?php echo $_POST['periodo'] ?></th>
				<th colspan="5">DOCENTE: <?php echo $profesor ?></th>
				<th colspan="4">GRADO: <strong><?php echo strtoupper($nombreGrado) ?></strong></th>
			</tr>
			<tr>
				<th colspan="4">ESTUDIANTES</th>
				<th colspan="7">CALIFICACIONES</th>
			</tr>
			<tr>
				<th>No.</th>
				<th colspan="2">APELLIDOS</th>
				<th>NOMBRES</th>
				<?php 
                    $nt = 1;
                    
                    $objCriterios = new Criterio();
                    $objCriteriosT = new Criterio();
                    $numCriterios = $objCriteriosT->conteoCriterios();
                    foreach ($objCriteriosT->Listar() as $value) {
                        echo "<th> ";
                        /*if($value['nomCriterio'] != "PRUEBA PERIODO"){
                            echo "C$nt</th>";
                        }else{
                            echo "EV. PER</th>";
                        }*/
                        echo "C$nt</th>";
                        $nt++;
                    }
                ?>
				<th>J. VAL</th>
				<th>INAS</th>
				<th>CALIF</th>
			</tr>
		</thead>
		<tbody>
		    <?php 
		$No = 1;
		foreach ($objEstudiantes->Listar() as $value) { 
            $notaPeriodo = 0;
            $suma = 0;
            $definitiva = 0;
            ?>
			<tr>
    		    <td style="width: 10px; padding: 2px;"><?php echo $No ?></td>
    		    <td style="width: 130px; padding: 2px;"><?php echo $value['PrimerApellido'] ?></td>
    		    <td style="width: 130px; padding: 2px;"><?php echo $value['SegundoApellido'] ?></td>
    		    <td style="width: 200px; padding: 2px;"><?php echo $value['PrimerNombre'].' '.$value['SegundoNombre'] ?></td>
    		    <!---  CODIGO DE LA PLANILLA DE CRITERIOS -->    		    
                    <?php                       
                        foreach ($objCriterios->Listar() as $crit) { ?>
                            <td style='padding: 0px; text-align: center;'> 
                            <?php 
                                $notaCriterio = 0;
                                $objNotaCriterio = new Calificacion();
                                $objNotaCriterio->periodo = $_POST['periodo'];
                                $objNotaCriterio->idMatricula = $value['idMatricula'];
                                $objNotaCriterio->codArea = $campo['id'];
                                $objNotaCriterio->Anho = $_POST['anho'];
                                $objNotaCriterio->curso = $_POST['curso'];
                                $objNotaCriterio->tabla = "Area";
                                $objNotaCriterio->idCriterio = $crit['codCriterio'];

                                $notaCriterio = $objNotaCriterio->cargarPorCriterio();
                                if($crit['nomCriterio'] == "PRUEBA PERIODO"){
                                    $notaPeriodo = $notaCriterio;
                                }else{
                                    if(is_numeric($notaCriterio)){
                                        @$suma += $notaCriterio;
                                    }
                                }
                                
                                if(is_numeric($notaCriterio)){
                                    echo $objNotaCriterio->formato_notas($notaCriterio); 
                                }
                                
                            ?>
                            </td>
                         <?php 
                        }
                        $ochentaProciento = (($suma / ($numCriterios-1) ) * 0.8);
                        if(is_numeric($notaPeriodo)){
                            @$notaPeriodo = ($notaPeriodo * 0.2);
                            $definitiva = $ochentaProciento + $notaPeriodo;
                        }
                        ?>
                    <td style="padding: 0px; margin: 0px; text-align: center;">
                        <?php 
                            $objLogros = new Logro();
                            $objLogros->periodo = $_POST['periodo'];
                            $objLogros->codCurso = $_POST['curso'];
                            $objLogros->codArea = $campo['id'];
                            $objLogros->tabla = "Area";
                           if($definitiva != 0){
                            foreach($objLogros->cargarLista() as $log){
                                if($log['estado'] != 0){
                                    echo $log['CODIND']. " ";
                                }
                            }
                           }
                        ?> 
                    </td>
                    <td  style='padding: 0px; width: 50px; height: 20px; margin: 0px; text-align: center;'>
                        <?php 
                        
                            $faltas = 0;
                            $objCalificacion = new Calificacion();
                            $objCalificacion->periodo = $_POST['periodo'];
                            $objCalificacion->idMatricula = $value['idMatricula'];
                            $objCalificacion->codArea = $campo['id'];
                            $objCalificacion->Anho = $_POST['anho'];
                            $objCalificacion->curso = $_POST['curso'];
                            $objCalificacion->tabla = "Area";
                            
                            //var_dump($objCalificacion);

                            foreach ($objCalificacion->cargar() as $notaArea) {
                                $faltas =  $notaArea['Faltas'];
                            }
                             echo $faltas;
                        ?>
                    </td>
                    <td  style='padding: 0px; width: 50px; text-align: center;'>
                        <!-- Nota definitiva -->
                        <?php 
                            //echo round($definitiva,1);
                            echo $objNotaCriterio->formato_notas(round($definitiva,1)); 
                        ?>
                    </td>
    		    
    		    <!---- FIN DEL CODIGO DE LA PLANILLA DE CRITERIOS -->
    		<?php 
    		    $No ++; 
    			}
			?>		  
		</tbody>
	</table>
	
    <h1 style='page-break-after:always'></h1>
	<?php } ?>
	</body>
</html>