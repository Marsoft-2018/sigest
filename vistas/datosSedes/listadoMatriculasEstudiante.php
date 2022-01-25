<?php 
    if(!isset($objMatricula)){
        require("../../Modelo/Conect.php");
        require("../../Modelo/matricula.php");

        $objMatricula = new Matricula();
        $objMatricula->Documento = $_POST['Documento'];
    }

?>


<table class='table table-striped' style='border: 1px solid #cecece;width:95%;margin:0px auto;'>
    <thead>
        <tr>
            <th style='border: 1px solid #cecece;padding:1px;text-align:center;'>
                Cod Matricula
            </th>
            <th style='border: 1px solid #cecece;padding:1px;text-align:center;'>
                Sede
            </th>
            <th style='border: 1px solid #cecece;padding:1px;text-align:center;'>
                Grado
            </th>
            <th style='border: 1px solid #cecece;padding:1px;text-align:center;'>
                Grupo
            </th>
            <th style='border: 1px solid #cecece;padding:1px;text-align:center;'>
                Jornada
            </th>
            <th style='border: 1px solid #cecece;padding:1px;text-align:center;'>
                Año
            </th>
            <th style='border: 1px solid #cecece;padding:1px;text-align:center;'>
                Estado
            </th>                        
            <th style='border: 1px solid #cecece;padding:1px;text-align:center;'></th>
        </tr>
    </thead>
    <tbody id='listadoMatriculas'>
    <?php 
        foreach ($objMatricula->listar() as $mt) { ?>
            <tr>
                <td style='border: 1px solid #cecece;padding:1px;'>
                    <?php echo $mt['idMatricula']; ?>
                </td>
                <td style='border: 1px solid #cecece;padding:1px;text-align:left;'>
                    <?php echo $mt['NOMSEDE']; ?>
                </td>
                <td style='border: 1px solid #cecece;padding:1px;'>
                    <?php echo $mt['CODGRADO']; ?>
                </td>
                <td style='border: 1px solid #cecece;padding:1px;'>
                    <?php echo $mt['grupo']; ?>
                </td>
                <td style='border: 1px solid #cecece;padding:1px;'>
                    <?php echo $mt['jornada']; ?>
                </td>
                <td style='border: 1px solid #cecece;padding:1px;'>
                    <?php echo $mt['anho']; ?>
                </td>
                <td style='border: 1px solid #cecece;padding:1px;'>
                    <?php echo $mt['estado']; ?>
                </td>
                <td style="border: 1px solid #cecece;padding:1px;width:90px;">
                    <button type="button" class="btn btn-warning" onclick="editarMatricula(<?php echo $mt['idMatricula']; ?>)" style="padding:1px;text-align:center;margin:1px;width:25px;height:25px;">
                        <i class="fa fa-pencil" ></i>
                    </button>
                    <button type="button" class="btn btn-danger" onclick="eliminarMatricula(<?php echo $mt['idMatricula']; ?>,<?php echo $_POST['Documento'] ?>)" style="padding:1px;text-align:center;margin:1px;width:25px;height:25px;">
                        <i class="fa fa-trash" ></i>
                    </button>
                </td>
            </tr>
    <?php } ?>
    </tbody>
</table>  