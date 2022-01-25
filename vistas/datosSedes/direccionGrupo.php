<?php 
    require("../../Modelo/curso.php");
    $objCursos = new Curso();
    $objCursos->codSede = $codsede; 
    $anho = date("Y");

 ?>

<h3 style='background-color:#cefece;text-align:center;border:1px solid #cecece;'>
    ELIJA EL O LOS CURSOS EN LOS CUALES SERA DIRECTOR DE GRUPO EL PROFESOR
</h3>  
<table class='table'>
    <thead>
        <tr>
            <?php 
                foreach ($objCursos->listaXsedes() as $curso) {
                    echo "<th class='thDist' style='font-size:10px; padding:1px; background-color:#cefece;'>".$curso['CODGRADO']."°".$curso['grupo']."</th>";
                }
            ?>
        </tr>
    </thead>
    <tbody id='matrizCursos'>
        <tr class='apuntado filaDelgada' style='text-align:center;border:1px solid #cecece;'>    
        <?php 
            foreach ($objCursos->listaXsedes() as $cur) {
                echo "<td style='color:#000000; margin:0px; padding: 0px; text-align:center; border-left: 1px solid #cecece; border-right:1px solid #cecece;'>
                <div id='".$cur['codCurso']."$objProfesor->IDUsuario'>";
                $cambio=0;
                $idDist;
                foreach ($objProfesor->direccionDeCurso($objProfesor->IDUsuario, $anho,$cur['codCurso']) as $res) {
                    if($res['codCurso'] == $cur['codCurso']){
                        $cambio = 1;
                    } 
                } 
                    
                if($cambio == 0){
                    echo "<input type='checkbox' name='cursos[]' value='".$cur['codCurso']."' style='margin:0 auto; padding: 0px;' title='".$cur['CODGRADO']."°". $cur['grupo']."' onclick='ponerDirCurso(this.name,this.value)'>";
                }else{
                    echo "<input type='checkbox' name='cursos[]' value='".$cur['codCurso']."' checked id='".$cur['codCurso']."' onclick='quitarDirCurso(this.name,this.id)' style='margin:0 auto; padding: 0px;' title='".$cur['CODGRADO']."°". $cur['grupo']."'>";
                }  
                echo "</div></td>";
            }
        ?>  
        </tr>       
    </tbody>                                                   
</table>
<div>
    <iframe name='cargaDistCurso' style='display:none;'></iframe>
        <div id='ResCargaDistCurso'>
        </div>
</div>