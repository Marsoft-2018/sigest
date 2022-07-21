<?php
    session_start();
    require("../../Modelo/Conect.php");
    require("../../Modelo/logros.php");
    require("../../Modelo/criterios.php");

    $objCriterio = new Criterio();
    $objIndicador = new Logro(); 
    $objIndicador->codArea  = $_POST['area'];
    $objIndicador->periodo  = $_POST['periodo'];
    $objIndicador->codCurso = $_POST['curso'];
    

?>
<div class="row">
    <div class="col-md-6">
        <div class="clearfix"></div>
        <div class="x_panel">
            <div class="x_title">
                <h4>AGREGAR JUICIO VALORATIVO - (INDICADOR DE LOGRO)</h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content box-profile">
                <div class='row'>
                    <div class='col-md-12'>
                        <div class='row'>
                            <div class='col-md-3'> * CRITERIO:</div>
                            <div class='col-md-9'>
                                <select id='codCriterio' class='form form-control'>
                                    <option value=''>Seleccione...</option>
                                    <?php  
                                        foreach ($objCriterio->Listar() as $cr) {
                                            echo "<option value='".$cr['codCriterio']."'>".$cr['nomCriterio']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>* Por favor digite el INDICADOR en el sigiente campo en forma <strong>INFINITIVA</strong></h4>
                                <textarea class="form form-control" style='font-size:1.2em;padding:2px; text-align:left; min-height:120px; width:100%;' id='logroInfinitivo' placeholder="digite el indicador en este espacio" onkeyup="concatenarLogro(this.value)"></textarea>
                            </div>
                        </div>
                        <div class="row" style="padding: 15px 0px;">
                            <div class="col-md-4">
                                <button type='button' class='btn btn-success' id="btnAgregar" onclick='agregarLogro()' style='width:100%;' >Agregar a la lista</button>
                            </div>
                            <div class="col-md-4">
                                <button type='button' class='btn btn-warning' id="btnEditar" style='width:100%; display: none;'><i class="fa fa-floppy"></i>Guardar Cambios</button>
                            </div>
                            <div class="col-md-4">
                                <button type='button' class='btn btn-default' id="btnCancelar" style='width:100%; display: none;' onclick="cancelarEdicion()"><i class="fa fa-undo"></i>Cancelar</button>
                            </div>
                        </div>                    
                    </div>
                </div>                        
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="x_panel">
            <div class="x_title">
                <div class="clearfix"></div>
            </div>
            <div class="x_content box-profile">
                <div class="row">
                    <div class="col-md-12">
                        <div class='panel panel-success' style='font-size:1em;padding:2px;text-align:left;'>
                            <div class='panel-heading' id='logroSuperior'></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class='panel panel-primary' style='font-size:1em;padding:2px;text-align:left;'>
                            <div class='panel-heading' id='logroAlto'> </div>
                        </div>                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class='panel panel-warning' style='font-size:1em;padding:2px;text-align:left;'>
                            <div class='panel-heading' id='logroBasico'></div>
                        </div>                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class='panel panel-danger' style='font-size:1em;padding:2px;text-align:left;'>
                            <div class='panel-heading' id='logroBajo'> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
    <div class="x_panel">
        <div class="x_title">
            <h4>LISTA DE LOGROS RELACIONADOS</h4>
            <div class="clearfix"></div>
        </div>
        <div class="x_content box-profile" id='tablaLogros'>
        </div>
    </div>    
</div>
<!--                     }
                }else{

                    $sqlLogrosAsignatura=mysql_query("SELECT L.`CODIND`,ax.`abreviatura`,criterios.`nomCriterio`,L.`periodo`,L.INDICADOR,L.estado FROM logrosasignatura L
                    INNER JOIN asignaturas_sedes ax
                    ON L.`codAsignatura`=ax.`codAsig`
                    INNER JOIN criterios
                    ON L.`codCriterio`=criterios.`codCriterio`
                    WHERE L.`periodo`='$periodo' AND ax.`codAsig`='$area' AND L.codCurso='$curso'");
                    $resulLogroAsignaturas=mysql_num_rows($sqlLogrosAsignatura);
                    if($resulLogroAsignaturas>0){
                        while($log=mysql_fetch_array($sqlLogrosAsignatura)){
                            <tr>
                            <td>$log[0]</td>
                            <td>$log[2]</td>
                            <td>$log[1]</td>
                            <td>$log[3]</td>
                            <td style='font-size:10px;'>".utf8_encode(strtoupper($log[4]))."</td>
                            <td >
                            <span id='$log[0]' title='Editar Indicador' onclick='cargarEdicionLogro(this.id,2)' style='padding: 0px; text-align:center;font-size: 20px;color:blue;'><i class='fa fa-pencil'></i></span>
                        </td>
                        <td >
                            <span id='$log[0]' title='Eliminar Indicador' onclick='eliminarIndicador(this.id,2)' style='padding: 0px; text-align:center;font-size: 20px;color:red;'><i class='fa fa-trash'></i></span>
                        </td>
                            /*
                            <td style='color:#000000;margin:0px; padding: 0px; text-align:center;font-size: 11px; background-color:rgba(255,255,255,0.7);'>
                                <img src='IMAGENES/Iconos/editar1.png' id='$log[0]' width='15' height='15' class='iconosAcciones' title='Editar Indicador' onclick='cargarEdicionLogro(this.id,2)'></img>
                            </td>
                            <td style='margin:0px; padding: 0px; text-align:center;font-size: 11px; background-color:rgba(255,255,255,0.7);'>
                                <img src='IMAGENES/Iconos/eliminar.png' id='$log[0]' width='15' height='15' class='iconosAcciones' title='Eliminar Indicador' onclick='eliminarIndicador(this.id,2)'></img>
                            </td>*/
                                <td style='text-align:center;' id='estadoLogro$log[0]'>
                                    if ($log[5] == 1){
                                        <span  id='$log[0]' style='padding: 0px; text-align:center;font-size: 20px;color:green;' title='Logro Activo: El logro en este estado será utilizado en los desempeños calificados' onclick='cambiarEstadoLogro(this.id,0,2)'><i class='fa fa-check-circle-o'> </i></span>
                                    }elseif($log[5] == 0){
                                        <span id='$log[0]' style='padding: 0px; text-align:center;font-size: 20px;color:#505050;' title='Logro Inactivo: El logro en este estado no será tenido en cuenta en los desempeños calificados' onclick='cambiarEstadoLogro(this.id,1,2)'><i class='fa fa-times-circle-o'> </i></span>
                                    }
                                </td>
                            </tr>
                        }
                    }else{
                        echo '<div class="alert alert-warning alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            No existen indicadores para la materia hasta el momento, presione el boton <strong>"Nuevo Indicador"</strong> para agregar uno nuevo...
                        </div>';
                    }
                }    
                 -->