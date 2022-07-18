<div class='ocultar'>
    La pagina Cargada es: <?php echo $pagina ?>.
    <form action='ctrlBoletin.php' method='post' style='float:left;'>
        <input type='hidden' name='sede' value='<?php echo $sede ?>' >
        <input type='hidden' name='curso' value='<?php echo $curso ?>' >
        <input type='hidden' name='anho' value='<?php echo $anho ?>' >
        <input type='hidden' name='periodo' value='<?php echo $periodoBol ?>' >
        <input type='hidden' name='tipoB' value='<?php echo $tipoBoletin ?>' >
        <input type='hidden' name='centro' value='<?php echo $centro ?>' >
        Pagina:<input type='number' name='Pg' value='<?php echo $pagina ?>' >
        Cantidad de Boletines:<input type='number' name='Cant' value='<?php echo $registros ?>' >
        <input type='submit' class='btn btn-primary' value='Ver Boletines' style='margin-left:20px;'>
    </form>
    <button class="btn btn-primary" onclick="javascript:window.print()" style="float:left;margin-left:20px;margin-right:20px;">
        <i class="fa fa-print"></i>Imprimir
    </button>
</div>