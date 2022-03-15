<?php
  require("../modelo/conteo.php");
  $institucionID=$_POST['Institucion'];
  $usuario=$_POST['usuario'];
  $sede;

  $conteo=new Conteo();  
  $conteo->Cargar();

?>