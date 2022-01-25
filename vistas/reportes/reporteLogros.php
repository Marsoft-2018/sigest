<?php 
    session_start();
    require("../../Modelo/Conect.php");
    require("../../Modelo/Institucion.php");    
    require("../../Modelo/sede.php");
    require("../../Modelo/curso.php");
    require("../../Modelo/profesores.php");
    require("../../Modelo/areas.php");
    require("../../Modelo/logros.php");
    $anho = date("Y");
    $nombreSede = "";
    $objInstitucion = new Institucion();
    $objSede = new Sede();
    $objCurso = new Curso();
    $totalSedes = $objSede->totalSedes();

    foreach ($objInstitucion->cargar() as $dato) {
        $institucion = $dato['nombre'];
        $logo = $dato['logo'];
    }

    foreach ($objSede->cargar() as $sede) {
        $nombreSede = $sede['NOMSEDE'];
    }

 ?>
 <div class="row">
     <div class="col-md-12">
         <table border='0' cellpadding=0 cellspacing=0 class='bordes2' style='border-collapse:collapse;table-layout:fixed;width:100%'>
            <tr height=17 style='height:5.75pt'>       
                <td colspan='7' style='width:805pt;text-align:center;padding:1px;'>     
                   <img src='vistas/img/<?php echo $logo ?>' alt='Descripción: MEMBRETE' style='width:70px;height:70px;margin 0 auto;'>
                   <h3 style='text-align:center;padding:0px;margin:0px;'><?php echo $institucion ?></h3>
                   <h2 style='text-align:center;padding:0px;margin:0px;'> REPORTE DE LOGROS </h2>
                   <?php if($totalSedes > 1){ ?>
                    
                    <?php } ?>
                    <h5 style='text-align:center;padding:0px;margin:0px;' >Fecha: <?php echo date("Y-m-d"); ?></h5>
                </td>
            </tr>
        </table> 
        <table class="table table-striped" id= "tablaDatos" style="position:relative;border:1px solid #000; border-collapse:collapse;">
            <thead>
            <tr>
                <th style="border:1px solid #000; text-align:center; width:5px;" >Grado</th>
                <?php if($_SESSION['rol']=='Administrador'){ ?>
                <th style="border:1px solid #000; text-align:center; width:20%;" >Profesor</th>
                <th style="border:1px solid #000; text-align:center; width:8px;" >Área</th>
                <?php }else{ ?>                
                <th style="border:1px solid #000; text-align:center; width:20%;" >Área</th>
                <?php } ?>
                <th style="border:1px solid #000; text-align:center; width:8px;" >Periodo</th>
                <th style="border:1px solid #000; text-align:center; width:10px;" >Criterio</th>
                <th style="border:1px solid #000; text-align:center; width:5px;" >Código</th>
                <th style="border:1px solid #000; text-align:center; width:65%;">INDICADOR</th>
            </tr>                
            </thead>
            <tbody>
                <?php 
                $objRepor = new Logro();
                foreach ($objRepor->reporte() as $dato) { ?>
                    <tr>
                        <td style="border: 1px solid #000;margin:0px;padding: 1px;text-align: center;"><?php echo $dato['curso'] ?></td>
                        <?php if($_SESSION['rol']=='Administrador'){ ?>
                        <td style="border: 1px solid #000;margin:0px;padding: 1px;">
                            <?php echo $dato['profesor'] ?>                                
                        </td>
                        <?php } ?>

                        <td style="border: 1px solid #000;margin:0px;padding: 1px;"><?php echo $dato['area'] ?></td>
                        <td style="border: 1px solid #000;margin:0px;padding: 1px; text-align: center;"><?php echo $dato['periodo'] ?></td>
                        <td style="border: 1px solid #000;margin:0px;padding: 1px;"><?php echo $dato['nomCriterio'] ?></td>
                        <td style="border: 1px solid #000;margin:0px;padding: 1px; text-align: right;"><?php echo $dato['CODIND'] ?></td>
                        <td style="border: 1px solid #000;margin:0px;padding: 1px; text-align: justify;"><?php echo $dato['INDICADOR'] ?></td>
                    </tr>       
                <?php } ?>
            </tbody>
            
        </table>
     </div>
 </div>

<script src="complementos/DataTables/datatables.js"></script>
