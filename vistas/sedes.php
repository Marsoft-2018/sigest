<?php
    session_start();
    require("../Modelo/Conect.php");
    require("../Modelo/sede.php");
    $objSedes = new Sede();

    
?>

<form method ='post'>
  <div id='ContenedorV' style="margin:0 auto; width: 97%;">
      <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title seccion-cabecera">
              <h3>MODULO PARA LA ORGANIZACION DE LAS SEDES QUE CONFORMAN A LA INSTITUCIÓN</h3>
              <div class="clearfix"></div>
          </div>
          <div class="x_content box-profile">  
            <div class="row">
                <div class="col-md-12">
                    <div class="bs-example" data-example-id="table-within-panel">
                        <div title='Ayuda sobre la creacion, eliminacion y configuración de Sedes' style='color:#000000;padding: 10px; text-align:left;font-size: 11px; float:left;background-color:rgba(255,255,255,0.7);width: 48%;'>
                              <p>
                                  <b>UNA SEDE NUEVA</b><br><br>
                                  1- Escriba los datos en los campos de abajo para agregar una Sede nueva<br>

                                  * Los campos con asteriscos son obligatorios<br>
                                  * El código para la nueva sede corresponde al código DANE o cualquier otro que disponga el usuario
                              </p>
                          </div> 
                          <div title='Ayuda sobre las Sedes' style='color:#000000;padding: 10px; text-align:left;font-size: 11px; float:left;background-color:rgba(255,255,255,0.7);width: 48%;'>
                              <p>
                                  <b>EDITAR O ELIMINAR UNA SEDE</b><br><br>
                                  1- Modifique los datos de la sede que desea Actualizar o Eliminar.<br>
                                          * Solo se debería eliminar una sede si esta no tiene alumnos matriculados
                                          * En caso de continuar con el proceso de eliminación se borraran todos los datos relacionados con esa Sede
                              </p>
                          </div>
                              <span id='resultado'></span> 
                              <div class="row">
                                  <div class="col-md-12">
                                      <h4>Nueva Sede</h4>
                                         <div class="row">
                                             <div class="col-md-5">
                                                <div class="form-group input-group">
                                                    <span class="input-group-addon">*</span>
                                                    <input type='text' class='form-control' style='margin:0px; padding: 0px;' id='codSedeNueva' required value='' placeholder='Código Dane de la sede'>
                                                </div>
                                             </div>
                                             <div class="col-md-5">
                                                 <div class="form-group input-group">
                                                      <span class="input-group-addon">*</span>
                                                      <input type='text' class='form-control' id='nombreSedeNueva' style='margin:0px; padding: 0px;'  required value='' placeholder='Nombre de la sede'>
                                                  </div>
                                             </div>
                                             <div class="col-md-1">
                                                  <button type='button' class='btn btn-primary' title='Agregar Nueva SEDE' onclick='ajustes(5,2)'>
                                                      <i class='fa fa-plus'> Agregar</i>
                                                  </button>
                                             </div>
                                         </div>
                                  </div>
                              </div>
                          <div id="listaSedes">
                            <?php include("datosSedes/listadoSedes.php") ?>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</form>
