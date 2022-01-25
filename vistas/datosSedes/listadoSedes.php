<?php 
	if(isset($_POST['accion'])){
		session_start();
	    require("../../Modelo/Conect.php");
	    require("../../Modelo/sede.php");
	    $objSedes = new Sede();
	}
?>

<table class="table table-striped">
	<thead>
	  <tr style="background-color: #29666F;color:#fff;">                       
	      <th style='width:20%;text-align:center;'>DANE SEDE</th>
	      <th >NOMBRE</th>
	      <th >Acciones</th>                    
	  </tr>
	</thead>
	<tbody>
	  <?php
	  foreach ($objSedes->listar() as $key => $sede) {
	    ?>
	    <tr>                        
	       <td >
	            <?php echo $sede['CODSEDE'] ?>
	       </td>
	       <td style="color:#000000; margin:0px; padding: 0px; text-align:left;">
	         <input type="text" class="form form-control" id="sedeED<?php echo $sede['CODSEDE'] ?>" title="sedeED<?php echo $sede['CODSEDE'] ?>" required value="<?php echo $sede['NOMSEDE'] ?>">
	       </td>
	       <td style="text-align:center,vertical-align:middle; font-size:20px; padding:0px;" >
	          <button type="button" class="btn btn-success" onclick="ajustes(5,1,<?php echo $sede['CODSEDE'] ?>)" title="Guardar cambios en la sede <?php echo $sede['CODSEDE'] ?>">
	            <i class="fa fa-save"></i>
	          </button>

	          <button type="button" class="btn btn-danger" onclick="ajustes(5,3,<?php echo $sede['CODSEDE'] ?>)" title="Eliminar la sede <?php echo $sede['CODSEDE'] ?>">
	            <i class="fa fa-trash"></i>
	          </button>                                 
	       </td>   
	    </tr>
	    <?php 
	  }
	  ?>
	</tbody>
</table>