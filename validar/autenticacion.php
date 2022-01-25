<?PHP
	 include ("../CONECT.php");
	 
	 
	 $usuario=$_GET["usu"];
	 $codigo=$_GET["pass"];
 	
 // 	$usuario = $_POST["usu"];
	// $codigo = $_POST["pass"];

	$busquedaE;
	$busquedaA;
	$busquedaUS;
	$consulta1;
	$consulta2;
	$consulta3;
	 
	//echo "la variable codest= ".$votante;
	 
	if (isset($usuario)){		
	 	$consulta1 = mysql_query("SELECT ad.`IDUsuario`, tr.`Tipo` FROM administrar ad INNER JOIN roles r
        ON r.`idUsuario`=ad.`IDUsuario` INNER JOIN tipoderol tr ON tr.`idRol` = r.`idRol` WHERE ad.IDUsuario='".$usuario."' AND ad.Password='".$codigo."' AND ad.estado='activo' AND tr.`Tipo`='Administrador'",$conexion); 
		$busquedaUS = mysql_num_rows($consulta1);
		if ($busquedaUS>0){
			echo "Administrar.php";
	 	}else{
	 		$consulta2=mysql_query("SELECT rol FROM profesores Where IDUsuario='".$usuario."' AND Password='".$codigo."' AND estado='activo'",$conexion); 
	 		$busquedaE=mysql_num_rows($consulta2);
			if ($busquedaE>0){
				while($reg=mysql_fetch_array($consulta2)){
	 		        if ($reg[0]=="Profesor"){
                        echo "mnuProfesores.php";
                    }else{
                        echo "ErrorRol.php";	 						 
	 				}
	 			}
			}else{
	 			$consulta3=mysql_query("SELECT rol FROM estudiantes Where IDUsuario='".$usuario."' AND Password='".$codigo."' AND estado='Matriculado'",$conexion); 
	 			$busquedaA=mysql_num_rows($consulta3);
				if ($busquedaA>0){
					while($reg=mysql_fetch_array($consulta3)){
                        if ($reg[0]=="Estudiante"){
                            echo "mnuEstudiante.php";
                        }else{
		 					echo "ErrorRol.php";	 						 
		 				}
		 	        }
                }else{	 			
	 			   echo "No_auto.php";	 				
	 			}			 			
	 		}
	   }
    }
?>
