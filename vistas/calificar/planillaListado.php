<?php 
    require("../../Modelo/tipoPlanilla.php");
    require("../../Modelo/areas.php");
    require("../../Modelo/criterios.php");
    $objTipoPlanilla = new tipoPlanilla();
    $objTipoPlanilla->anho = $anho;
    $tipo = "";
    $cantNotas = "";
    $tipoPromedio = "";
    foreach ($objTipoPlanilla->cargar() as $value) {
        $tipo = $value['tipo'];
        $cantNotas = $value['cantidad_notas'];
        $tipoPromedio = $value['tipo_promedio'];
    }

    switch ($tipo) {
        case 'Unica':
            include("planillaUnica.php");
            break;
        case 'Varias':
            include("planillaVarias.php");
            break;
        case 'Criterios':
            include("planillaCriterios.php");
            break;
        default:
            echo "seleccione la forma de calificación en el menú institución/ periodos/estilo de calificación";
            break;
    }
?>

