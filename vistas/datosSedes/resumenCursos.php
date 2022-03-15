<?php 
    require("../../Modelo/Conect.php");  
    require("../../Modelo/grado.php");  
    require("../../Modelo/matricula.php");  

    $objGrado = new Grado();
    $objGrado->sede = $_POST['sede'];
    $listaCursos = $objGrado->cargarCursos();
?>
<table class='table table-striped' style='border:1px solid rgba(190,220,240,0.4);margin:0px;'>        
    <tr>
        <th style='text-align:left;border:1px solid rgba(190,220,240,0.4);'>CURSOS</th>
        <?php 
            foreach ($listaCursos as $curso) { ?>
                <th style='text-align:center;width:35px;padding:0px;font-size:10px;border:1px solid rgba(190,220,240,0.4);vertical-align:middle;'>
                    <?php 
                        if($curso['CODGRADO'] <= 0){
                            echo $curso['nomCampo']; 
                        }else{
                            echo $curso['CODGRADO']."° ".$curso['grupo']; 
                        }
                    ?>
                </th>
        <?php
            }
        ?>
         <th>Total</th>
    </tr>        
    <tr style=''>
        <th style='text-align:left;font-size:11px;'>CANT. ESTUDIANTES</th>
        <?php 
            $total = 0;
            foreach ($listaCursos as $curso) {
                $objMatricula = new Matricula();
                $cantidad = $objMatricula->numeroEstudiantes($curso['codCurso'],$_POST['sede'],$_POST['anho']);
                echo "<td style='text-align:center;font-size:10px;border:1px solid rgba(190,220,240,0.4);vertical-align:middle;'>".$cantidad."</td>";
                $total += $cantidad;
            }
        ?>
        <th>
            <?php
                echo $total;
            ?>
        </th>
    </tr> 
</table>