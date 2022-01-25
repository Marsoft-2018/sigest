<?php
    session_start();
    require("../Modelo/Conect.php");
    require("../Modelo/curso.php");
    // require("../Modelo/Estudiante.php");
    require("../Modelo/areas.php");
    require("../Modelo/asignatura.php");
    require("../Modelo/Calificacion.php");
    require("../Modelo/traslados.php");

    
    $accion;
    
    if(isset($_POST['accion'])){
        $accion = $_POST['accion'];        
    }elseif(isset($_GET['accion'])){
        $accion = $_GET['accion'];        
    }

    switch ($accion) {
        case 'VerificarCurso':
            $datos = array();
            $grado1 = 0;
            $grado2 = 0;
            $obj1 = new Curso();
            $obj1->curso = $_POST['cursoActual'];            
            foreach ($obj1->consultarGrado() as $value) {
                $grado1 = $value['CODGRADO'];
            }

            $obj2 = new Curso();
            $obj2->curso = $_POST['cursoDestino'];            
            foreach ($obj2->consultarGrado() as $value) {
                $grado2 = $value['CODGRADO'];
            }

            if ($grado1 < $grado2) {
                $men = "El grado seleccionado es más alto que el  grado actual del estudiante";
                $datos['mensaje'] = [$men];
                $datos['estado'] = [2];
            }elseif($grado1 > $grado2){
                $men = "El grado seleccionado es más bajo que el grado actual del estudiante";
                $datos['mensaje'] = [$men];
                $datos['estado'] = [2];
            }else{
                $datos['mensaje'] = ["OK"];
                $datos['estado'] = [1];
            }
            echo json_encode($datos);

            break;
        case 'Trasladar':
            $grado1 = 0;
            $grado2 = 0;
            $obj1 = new Curso();
            $obj1->curso = $_POST['cursoActual'];            
            foreach ($obj1->consultarGrado() as $value) {
                $grado1 = $value['CODGRADO'];
            }

            $obj2 = new Curso();
            $obj2->curso = $_POST['cursoDestino'];            
            foreach ($obj2->consultarGrado() as $value) {
                $grado2 = $value['CODGRADO'];
            }
            $estudiantes = $_POST['Estudiante'];
            for($i = 0;$i < sizeof($estudiantes); $i++ ){
                //echo "<br>estudiante = '$estudiantes[$i]'";             
                $objAreaActual = new Area();
                $objAreaActual->codSede = $_POST['sedeActual'];
                $objAreaActual->idGrado = $grado1;
                $objAreaActual->anho = $_POST['anho'];

                foreach ($objAreaActual->cargarPensum() as $value) {
                    // echo "<br>Area origen: ".$value["id"];
                    $objAreaDestino = new Traslado();
                    $objAreaDestino->codSede = $_POST['sedeDestino'];
                    $objAreaDestino->idGrado = $grado2;
                    $objAreaDestino->anho = $_POST['anho'];
                    $objAreaDestino->abreviatura = $value['Abreviatura'];
                    $objAreaDestino->nombre = $value['Nombre'];
                    foreach ($objAreaDestino->areasSedeDestino() as $areaDes) {
                        // echo " | Area destino: ".$areaDes['id'];
                        $objTras = new Traslado();
                        $objTras->areaDestino   = $areaDes['id'];
                        $objTras->cursoDestino  = $_POST['cursoDestino'];
                        $objTras->idMatricula   = $estudiantes[$i];
                        $objTras->areaOrigen    = $value["id"];
                        $objTras->cursoOrigen   = $_POST['cursoActual'];
                        $objTras->anho  = $_POST['anho'];
                        $objTras->codSedeDestino  = $_POST['sedeDestino'];
                        $objTras->cambiarCalificaciones();

                    }
                }  
                $objTraslado = new Traslado();
                $objTraslado->cursoDestino  = $_POST['cursoDestino'];
                $objTraslado->idMatricula   = $estudiantes[$i];
                $objTraslado->codSedeDestino  = $_POST['sedeDestino'];
                $objTraslado->finalizar();             
            }




            break;
        default:
            # code...
            break;
    }

    
?>