
<?php
  require("../modelo/candidatos.php");
  $institucionID=$_POST['Institucion'];
  $usuario=$_POST['usuario'];
  $sede;

  $cand=new Candidato();  
  $cand->Cargar();

?>
