
<?php
  require("../modelo/usuarios.php");
  $institucionID=$_POST['Institucion'];
  $usuario=$_POST['usuario'];
  $sede;

  $us=new Usuario();  
  $us->Cargar();

?>
