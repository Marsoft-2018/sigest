<?php
    require ('../class/areas115.php');
    /*$codInst=$_POST['codInst'];
    $nombre=$_POST['nombre'];
    $intensidadHoras=$_POST['IH'];
    $accion=$_POST['accion'];
    $tipo=$_POST['tipo'];
    $codigoArea=$_POST['codigoArea'];
    //echo "El codigo de la institucion es: ".$codInst."<br>";
    if ($tipo=='Area'){
        
        $objArea=new Area($codInst,$codigoArea,$nombre,$intensidadHoras);
        if ($accion=='Agregar'){
            $agregarArea=$objArea->Agregar();
        }elseif($accion='Mostrar'){
            
        }elseif($accion=='Eliminar'){
            
        }elseif($accion=='Modificar'){
            
        }
    }elseif($tipo=='Asignatura'){
        $codigoAsig=$_POST['codigoAsig'];
        if($accion=='Agregar'){
            echo "<tr>
                    <td>$codigoAsig</td>
                    <td>$nombre</td>
                    <td>$intensidadHoras</td>
                    <td><a href='#'>eliminar</a></td>
                </tr>";
        }elseif($accion=='Eliminar'){
            
        }elseif($accion=='Modificar'){
            
        }
    }
    */
    $accion=$_POST['accion'];
    if ($accion=='Agregar'){
        $tipo=$_POST['tipo'];
        $abr=$_POST['abr'];
        $nombre=$_POST['nombre'];
        //echo    "Los valores en el archivo areasAsignaturas son: ($tipo,$abr,$nombre,$ih)";
        $objareas115=new Areas115();
        $objareas115->agregar($tipo,$abr,$nombre);
        $objareas115->cargar();
    }
    if ($accion=='Agregar2'){
        $inst=$_POST['inst'];
        $tipo=$_POST['tipo'];
        $abr=$_POST['abr'];
        $nombre=$_POST['nombre'];
        //echo    "Los valores en el archivo areasAsignaturas son: ($tipo,$abr,$nombre,$ih)";
        $objArea=new asignaturas();
        $objArea->agregar($inst,$tipo,$abr,$nombre);
        $objArea->cargar($inst);
    }
    

    if($accion=='Eliminar'){
        $abr=$_POST['clave'];
        $tabla=$_POST['tabla'];
        
        if($tabla=='A1'){
           $objareas115=new Areas115();
            $objareas115->Eliminar($abr);
            $objareas115->cargar(); 
        }
        if($tabla=='A2'){
            $inst=$_POST['inst'];
            //echo    "Los valores en el archivo areasAsignaturas son: (Tabla: $tabla, Clave: $abr)";
            $objAsig=new Areas115();
            $objAsig->Eliminar($abr);
            $objAsig->cargar($inst); 
        }
        
    }
    if($accion=='modificaArea'){
        $clave=$_POST['clave'];
        $ih=$_POST['ih']; 
        $grado=$_POST['grado'];
        //echo "Los datos son  Nivel: $nivel - Clave: $clave - IH: $ih";
        $objAreas=new asignaturas();
        $objAreas->modificarArea($clave,$ih,$grado);
    }
    if($accion=='modificaAsig'){
        $clave=$_POST['clave'];
        $campo=$_POST['campo'];
        $valor=$_POST['valor']; 
        $grado=$_POST['grado'];
        $objareas115=new asignaturas();
        $objareas115->modificarAsig($clave,$campo,$valor,$grado);
    }
    if($accion=='modificaArea115'){
        $abr=$_POST['abr'];
        $ih=$_POST['ih']; 
        $grado=$_POST['grado'];
        $objareas115=new Areas115();
        $objareas115->modificarArea($abr,$ih,$grado);
    }
    if($accion=='modificaAsig115'){
        $clave=$_POST['clave'];
        $campo=$_POST['campo'];
        $valor=$_POST['valor']; 
        $grado=$_POST['grado'];
        $objareas115=new Areas115();
        $objareas115->modificarAsig($clave,$campo,$valor,$grado);
    }
    
    if($accion=='Finalizar'){
        $inst=$_POST['inst'];
        $objareas115=new Areas115();
        $objareas115->Trasladar($inst);
        $objAsignatura=new asignaturas();
        $objAsignatura->cargar($inst);
    }

?>


