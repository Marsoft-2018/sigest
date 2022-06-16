<?php 
	$calP1 = "";
	$desmP1 = "";
	$acumP1 = "";
	$inaP1 = "";

	$calP2 = "";
	$desmP2 = "";
	$acumP2 = "";
	$inaP2 = "";

	$calP3 = "";
	$desmP3 = "";
	$acumP3 = "";
	$inaP3 = "";

	$calP4 = "";
	$desmP4 = "";
	$acumP4 = ""; 
	$inaP4 = "";

	$acumFinal = 0;
	$desmFinal = "";
	$inasFinal = 0;

	$objCalificacion->idMatricula = $idMatricula;
	$objCalificacion->codArea =  $area['id'];
	$objCalificacion->grado = $area['idGrado'];
	$objCalificacion->tipoPromedio = $area['formaDePromediar'];

	
		if( $periodoBol >= 1){
			$objCalificacion->periodo = 1;
			$objPeriodo->periodo = 1;
			$vP = 0;
			foreach ($objCalificacion->cargar() as $calif) {
				$calP1 = $calif['NOTA'];
				$inaP1 = $calif['Faltas'];
				$objCalificacion->nota = $calif['NOTA'];
				$objD->nota = $calP1;
				$desmP1 = $objD->cargar();
				foreach ($objPeriodo->valorPeriodo() as $value) {
					$vP = $value['valorPeriodo'];
					$objCalificacion->porPeriodo = $vP;
				}
				$acumP1 = $objCalificacion->acumulado();
				$acumFinal += $objCalificacion->acumulado();
				$objD->nota = $acumFinal;
				$desmFinal = $objD->cargar();
				$inasFinal = $inaP1;
			}
		}
			
		if($periodoBol >= 2){
			$objCalificacion->periodo = 2;
			$objPeriodo->periodo = 2;
			$vP = 0;
			
			foreach ($objCalificacion->cargar() as $key => $calif) {
				$calP2 = $calif['NOTA'];
				$inaP2 = $calif['Faltas'];
				$objCalificacion->nota = $calif['NOTA'];
				$objD->nota = $calP2;
				$desmP2 = $objD->cargar();
				foreach ($objPeriodo->valorPeriodo() as $key => $value) {
					$vP = $value['valorPeriodo'];
					$objCalificacion->porPeriodo = $vP;
				}
				$acumP2 = $objCalificacion->acumulado();
				$acumFinal += $objCalificacion->acumulado();
				$objD->nota = $acumFinal;
				$desmFinal = $objD->cargar();
				$inasFinal += $inaP2;
			}
			
		}

		if($periodoBol >= 3){
			$objCalificacion->periodo = 3;
			$objPeriodo->periodo = 3;
			$vP = 0;
			
			foreach ($objCalificacion->cargar() as $key => $calif) {
				$calP3 = $calif['NOTA'];
				$inaP3 = $calif['Faltas'];
				$objCalificacion->nota = $calif['NOTA'];
				$objD->nota = $calP3;
				$desmP3 = $objD->cargar();
				foreach ($objPeriodo->valorPeriodo() as $key => $value) {
					$vP = $value['valorPeriodo'];
					$objCalificacion->porPeriodo = $vP;
				}
				$acumP3 = $objCalificacion->acumulado();
				$acumFinal += $objCalificacion->acumulado();
				$objD->nota = $acumFinal;
				$desmFinal = $objD->cargar();
				$inasFinal += $inaP3;
			}
		}

		if($periodoBol >= 4){
			$objCalificacion->periodo = 4;
			$objPeriodo->periodo = 4;
			$vP = 0;
			
			foreach ($objCalificacion->cargar() as $calif) {
				$calP4 = $calif['NOTA'];
				$inaP4 = $calif['Faltas'];
				$objCalificacion->nota = $calif['NOTA'];
				$objD->nota = $calP4;
				$desmP4 = $objD->cargar();
				foreach ($objPeriodo->valorPeriodo() as $key => $value) {
					$vP = $value['valorPeriodo'];
					$objCalificacion->porPeriodo = $vP;
				}
				$acumP4 = $objCalificacion->acumulado();
				$acumFinal += $objCalificacion->acumulado();
				if($acumFinal >= 3.45 and $acumFinal < 3.5){
					$acumFinal = 3.5;
				}
				$objD->nota = $acumFinal;
				$desmFinal = $objD->cargar();
				$inasFinal += $inaP4;
			}
		}
