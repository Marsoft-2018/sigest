<!Doctype html>
<html>
    <head>
        <title>Reporte <?php echo $tipoB.' '.$anho; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" href="plantilla/css/estilo.css">
        <link rel="stylesheet" href="../../../font-awesome/css/font-awesome.min.css" type="text/css">
        <link href="../../../css/bootstraps3.1.css" rel="stylesheet">
        <link href="../../../css/listas.css" rel="stylesheet">
    </head>
    <body>
        <header style="font-family: Arial, sans-serif;
			width: 100%;">
        	<table style="font-family: Arial, sans-serif;  width: 100%;">
        		<tr>
        			<td id="logo" width="10%">
        				<img src="../../img/<?php echo $escudo ?>" style="width:30px;height:30px;">
        			</td>
        			<td  width="20%">
        				<div style="font-size:14px;">
        					<div style="font-size:14px;">
        						<strong>
        							<?php echo $nombreInstitucion ?>
        						</strong>
        					</div>  
        					<div style="font-size:9px;width:200px;">
        						<?php echo $ciudad ?>
        					</div>            
        				</div>			
        			</td>
        			<td style="width: 70%;"></td>
        		</tr>
        	</table>
        </header>
        <?php 
          include("cuerpo.php");
        ?>
    </body>
</html>