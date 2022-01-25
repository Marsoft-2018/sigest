<!DOCTYPE html>
<html lang="es" xml:lang="es">
<head>
  <title>Inscripcion</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="title" content="Formulario de inscripción - Colegio San Rafael"/>
  <meta name="description" content="Formulario para el proceso de inscripción para serparte del colegio San Rafel el Carmen de Bolívar"/>
  <meta name="author" content="Ing. Jose Alfredo Tapia Arroyo"/>
  <!-- <link rel="shortcut icon" href="custom/img/Logo.jpg"> -->
  <link rel="stylesheet" href="custom/css/bootstrap.min.css">
  <link rel="stylesheet" href="custom/css/sweetalert.css">
  <link rel="stylesheet" href="custom/css/custom.css">
  <style>
    #fotoVistaPrevia {
        position: relative;
    }
    #fotoVistaPrevia a {
        position: absolute;
        bottom: 5px;
        left: 5px;
        right: 5px;
        display: none;
    }
    #foto {
        position: absolute;
      visibility: hidden;
      width: 0;
      z-index: -9999;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title seccion-cabecera">
              <h3 style="letter-spacing: 10px;font-weight:bold;margin:20px 0px; text-align: center;">FORMULARIO DE INSCRIPCION</h3>
              <div class="clearfix"></div>
          </div>
          <div class="x_content">  
                <form id='formularioEstudiante' enctype="multipart/form-data" method='post' onsubmit="return " target='cuadroDeCarga'>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 >Información general del estudiante</h4>
                                </div>
                                <div class="row">
                                  <div class="col-md-12 col-sm-12 ">
                                    <div class="x_panel">
                                      <div class="x_title">
                                        <div class="clearfix"></div>
                                      </div>
                                      <div class="x_content box-profile">
                                        <div class="col-md-3 col-sm-3  profile_left">
                                          <div class="profile_img">
                                            <!-- <div id="crop-avatar">
                                                <form id='cambioFotoProfe' enctype='multipart/form-data' method='post' target='resultadoEnvio' onsubmit="cambiarFotoUsuario('Profesor')">
                                                    <div id='fotoVistaPrevia' >                                    
                                                        <a href='#' id='elegirIMG' class='btn btn-default' onclick='elegirIMG(this)'>Cambiar Imágen</a>
                                                        <img id='fotoUs' class="img-responsive avatar-view" src="vistas/img/Usuarios/" width="250" alt="Foto" title="Cambiar Foto">                            
                                                        <input type='hidden' value='0' name='fotoAnterior'>                                               
                                                        <input type='file' id='foto' name='foto' onchange='previsualizar(this)' />
                                                    </div>                            
                                                    <iframe name='resultadoEnvio' style='display:none;'></iframe>
                                                    <div id='mostrarMensajeImagen'></div>
                                                    <input type='hidden' value='$registro[1]' name='idUsuario'>
                                                    <input type='submit' value='Guardar Imágen' id='guardarIMG' class='btn btn-primary' style='margin-top:20px;display:none;width:98%;'>
                                                </form>
                                            </div> -->
                                          </div>
                                          <h3></h3>
                                          <div class="clearfix"></div>
                                          <ul class="list-unstyled user_data">
                                            <li><i class="fa fa-map-marker user-profile-icon"></i></li>
                                            <li><i class="fa fa-briefcase user-profile-icon"></i></li>
                                            <li class="m-top-xs"><i class="fa  fa-envelope-o user-profile-icon"></i><a href="#"></a></li>
                                            <li><i class="fa fa-calendar"></i><span></span></li>
                                          </ul>
                                        </div>
                                          <form action="" method="post" id="formPerfil" onsubmit="return actualizarPerfilProfesor()">
                                            <div class="col-md-9 col-sm-9 ">
                                              <div class="profile_title row">            </div>
                                              <div id="graph_bar" style="width:100%;">
                                                  <div class="x_content">
                                                    <hr>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-3 col-sm-3 ">Primer Nombre</label>
                                                      <div class="col-md-9 col-sm-9 ">                           
                                                        <input type="text" id="PrimerNombre" name="PrimerNombre" value="" class="form-control"  required>
                                                      </div>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-3 col-sm-3 ">Segundo Nombre</label>
                                                      <div class="col-md-9 col-sm-9 ">                           
                                                        <input type="text" id="SegundoNombre" name="SegundoNombre" value="" class="form-control">
                                                      </div>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-3 col-sm-3 ">Primer Apellido</label>
                                                      <div class="col-md-9 col-sm-9 ">                           
                                                        <input type="text" id="PrimerApellido" name="PrimerApellido" value="" class="form-control"  required>
                                                      </div>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-3 col-sm-3 ">Segundo Apellido</label>
                                                      <div class="col-md-9 col-sm-9 ">                           
                                                        <input type="text" id="SegundoApellido" name="SegundoApellido" value="" class="form-control" >
                                                      </div>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-3 col-sm-3 ">Tipo Documento</label>
                                                      <div class="col-md-3 col-sm-3 ">                           
                                                        <select name="tipoDocumento" id="tipoDocumento" required class="form-control">
                                                            <option value="" >Seleccione...</option>                                      
                                                            <option value="RC">RC</option>
                                                            <option value="TI">TI</option>
                                                            <option value="CC">CC</option>                                               
                                                        </select>
                                                      </div>
                                                      <label class="control-label col-md-3 col-sm-3 " style="text-align: right;">No. de Documento</label>
                                                      <div class="col-md-3 col-sm-3 ">                           
                                                        <input type="number" id="documento" name="documento" value="" class="form-control"  required>
                                                      </div>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-3 col-sm-3 ">Sexo</label>
                                                      <div class="col-md-2 col-sm-2 ">                           
                                                        <select id="SEX" name="sexo" class='form-control' required>
                                                            <option value="M">M</option>
                                                            <option value="F">F</option>
                                                        </select>
                                                      </div>
                                                      <label class="control-label col-md-3 col-sm-3" style="text-align: right;">Fecha Nacimiento</label>
                                                      <div class="col-md-3 col-sm-3 ">                           
                                                        <input type='date' name="fechaNacimiento" id="fechaNacimiento" size="10" value="" class="form-control" onchange="calcularEdad(this.value);" title="Ingrese la fecha de nacimiento del estudiante" required>
                                                        <input type="text" id="edad" value="0"  class="form-control" readonly="true">
                                                      </div>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-3 col-sm-3 ">Lugar de nacimiento</label>
                                                      <div class="col-md-9 col-sm-9 ">
                                                        <input type="text" id="lugarnacimiento" name="lugarnacimiento" value="" class="form-control" placeholder="" require>
                                                      </div>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-3 col-sm-3 ">Dirección de residencia</label>
                                                      <div class="col-md-9 col-sm-9 ">
                                                        <input type="text" id="direccion" name="direccion" value="" class="form-control">
                                                      </div>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-3 col-sm-3 ">Teléfono</label>
                                                      <div class="col-md-9 col-sm-9 ">
                                                        <input type="text" id="telefono" name="telefono" value="" class="form-control" placeholder="" require>
                                                      </div>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group row">
                                                      <h4>Antecedentes Escolares</h4>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-3 col-sm-3 ">Grado al que aspira</label>
                                                      <div class="col-md-9 col-sm-9 ">
                                                        <select name="grado" id="grado" required class="form-control">
                                                            <option value="" >Seleccione...</option>                                      
                                                            <option value="0">Prescolar</option>
                                                            <option value="A">A</option>
                                                            <option value="B">B</option>                                               
                                                            <option value="1" >1°</option>                                               
                                                            <option value="2" >2°</option>                                               
                                                            <option value="3" >3°</option>                                               
                                                            <option value="4" >4°</option>                                               
                                                            <option value="5" >5°</option>                                               
                                                            <option value="6" >6°</option>                                               
                                                            <option value="7" >7°</option>                                               
                                                            <option value="8" >8°</option>                                               
                                                            <option value="9" >9°</option>                                               
                                                            <option value="10" >10°</option>                                               
                                                            <option value="11" >11°</option>
                                                        </select>
                                                      </div>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-3 col-sm-3 ">Colegio de procedencia</label>
                                                      <div class="col-md-9 col-sm-9 ">
                                                        <input type="text" id="colegio" name="colegio" value="" class="form-control" placeholder="" require>
                                                      </div>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-3 col-sm-3 ">Dirección</label>
                                                      <div class="col-md-9 col-sm-9 ">
                                                        <input type="text" id="direccionColegio" name="direccionColegio" value="" class="form-control" placeholder="" require>
                                                      </div>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-3 col-sm-3 ">Teléfono</label>
                                                      <div class="col-md-9 col-sm-9 ">
                                                        <input type="text" id="telColegio" name="telColegio" value="" class="form-control" placeholder="" require>
                                                      </div>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-9 col-sm-9 ">Tiene hermanos en el Colegio San Rafael?</label>
                                                      <div class="col-md-3 col-sm-3 ">
                                                        <select id="hermanos" name="hermanos" class='form-control'>
                                                            <option value="">Seleccione</option>
                                                            <option value="SI">SI</option>
                                                            <option value="NO">NO</option>
                                                        </select>
                                                      </div>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-9 col-sm-9 ">Tiene familiares exalumnos del Colegio San Rafael?</label>
                                                      <div class="col-md-3 col-sm-3 ">
                                                        <select id="exalumnos" name="exalumnos" class='form-control'>
                                                            <option value="">Seleccione</option>
                                                            <option value="Padre">Padre</option>
                                                            <option value="Madre">Madre</option>
                                                            <option value="Hermanos">Hermanos</option>
                                                            <option value="No tiene">No tiene</option>
                                                        </select>
                                                      </div>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-9 col-sm-9 ">Ha participado en actividades extracurriculares en el colegio de procedencia?</label>
                                                      <div class="col-md-3 col-sm-3 ">
                                                        <select id="actividadesExtra" name="actividadesExtra" class='form-control'>
                                                            <option value="">Seleccione</option>
                                                            <option value="SI">SI</option>
                                                            <option value="NO">NO</option>
                                                        </select>
                                                      </div>
                                                    </div>
                                                    <div class="form-group row" id="cuales">
                                                      <label class="control-label col-md-3 col-sm-3 ">Cuáles?</label>
                                                      <div class="col-md-9 col-sm-9 ">
                                                        <textarea name="cuales" class="form-control"></textarea>
                                                      </div>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group row">
                                                      <h3>INFORMACION GENERAL DE LOS PADRES DEL ESTUDIANTE</h3>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group row">
                                                      <h4>Información del Padre</h4>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-3 col-sm-3 ">Nombres y Apellidos</label>
                                                      <div class="col-md-9 col-sm-9 ">
                                                        <input type="text" id="nombrePadre" name="nombrePadre" value="" class="form-control" placeholder="" require>
                                                      </div>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-3 col-sm-3 ">Edad</label>
                                                      <div class="col-md-3 col-sm-3 ">
                                                        <input type="text" id="edadPadre" name="edadPadre" value="" class="form-control" placeholder="" require>
                                                      </div>
                                                      <label class="control-label col-md-3 col-sm-3 ">No. Documento</label>
                                                      <div class="col-md-3 col-sm-3 ">
                                                        <input type="text" id="documentoPadre" name="documentoPadre" value="" class="form-control" placeholder="" require>
                                                      </div>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-3 col-sm-3 ">Profesión</label>
                                                      <div class="col-md-9 col-sm-9 ">
                                                        <input type="text" id="profesionPadre" name="profesionPadre" value="" class="form-control" placeholder="" require>
                                                      </div>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-3 col-sm-3 ">Teléfono</label>
                                                      <div class="col-md-9 col-sm-9 ">
                                                        <input type="text" id="telefonoPadre" name="telefonoPadre" value="" class="form-control" placeholder="" require>
                                                      </div>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-3 col-sm-3 ">Cargo</label>
                                                      <div class="col-md-9 col-sm-9 ">
                                                        <input type="text" id="cargoPadre" name="cargoPadre" value="" class="form-control" placeholder="" require>
                                                      </div>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-3 col-sm-3 ">Estado Cívil</label>
                                                      <div class="col-md-9 col-sm-9 ">
                                                        <select id="estadoCivilPadre" name="estadoCivilPadre" class='form-control'>
                                                            <option value="">Seleccione</option>
                                                            <option value="Casado">Casado</option>
                                                            <option value="Separado">Separado</option>
                                                            <option value="Soltero">Soltero</option>
                                                            <option value="Unión Libre">Unión Libre</option>
                                                            <option value="Viudo">Viudo</option>
                                                        </select>
                                                      </div>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-3 col-sm-3 ">Dirección Residencial</label>
                                                      <div class="col-md-9 col-sm-9 ">
                                                        <input type="text" id="direccionPadre" name="direccionPadre" value="" class="form-control" placeholder="" require>
                                                      </div>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-3 col-sm-3 ">Barrio</label>
                                                      <div class="col-md-9 col-sm-9 ">
                                                        <input type="text" id="barrioPadre" name="barrioPadre" value="" class="form-control" placeholder="" require>
                                                      </div>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group row">
                                                      <h4>Información del Madre</h4>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-3 col-sm-3 ">Nombres y Apellidos</label>
                                                      <div class="col-md-9 col-sm-9 ">
                                                        <input type="text" id="nombreMadre" name="nombreMadre" value="" class="form-control" placeholder="" require>
                                                      </div>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-3 col-sm-3 ">Edad</label>
                                                      <div class="col-md-3 col-sm-3 ">
                                                        <input type="text" id="edadMadre" name="edadMadre" value="" class="form-control" placeholder="" require>
                                                      </div>
                                                      <label class="control-label col-md-3 col-sm-3 ">No. Documento</label>
                                                      <div class="col-md-3 col-sm-3 ">
                                                        <input type="text" id="documentoMadre" name="documentoMadre" value="" class="form-control" placeholder="" require>
                                                      </div>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-3 col-sm-3 ">Profesión</label>
                                                      <div class="col-md-9 col-sm-9 ">
                                                        <input type="text" id="profesionMadre" name="profesionMadre" value="" class="form-control" placeholder="" require>
                                                      </div>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-3 col-sm-3 ">Teléfono</label>
                                                      <div class="col-md-9 col-sm-9 ">
                                                        <input type="text" id="telefonoMadre" name="telefonoMadre" value="" class="form-control" placeholder="" require>
                                                      </div>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-3 col-sm-3 ">Cargo</label>
                                                      <div class="col-md-9 col-sm-9 ">
                                                        <input type="text" id="cargoMadre" name="cargoMadre" value="" class="form-control" placeholder="" require>
                                                      </div>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-3 col-sm-3 ">Estado Cívil</label>
                                                      <div class="col-md-9 col-sm-9 ">
                                                        <select id="estadoCivilMadre" name="estadoCivilMadre" class='form-control'>
                                                            <option value="">Seleccione</option>
                                                            <option value="Casado">Casado</option>
                                                            <option value="Separado">Separado</option>
                                                            <option value="Soltero">Soltero</option>
                                                            <option value="Unión Libre">Unión Libre</option>
                                                            <option value="Viudo">Viudo</option>
                                                        </select>
                                                      </div>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-3 col-sm-3 ">Dirección Residencial</label>
                                                      <div class="col-md-9 col-sm-9 ">
                                                        <input type="text" id="direccionMadre" name="direccionMadre" value="" class="form-control" placeholder="" require>
                                                      </div>
                                                    </div>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-3 col-sm-3 ">Barrio</label>
                                                      <div class="col-md-9 col-sm-9 ">
                                                        <input type="text" id="barrioMadre" name="barrioMadre" value="" class="form-control" placeholder="" require>
                                                      </div>
                                                    </div>
                                                    <hr>                                                    
                                                    <div class="form-group row">
                                                      <h3>INFORMACIÓN DEL ACUDIENTE</h3>
                                                    </div> 
                                                    <hr>
                                                    <div class="form-group row">
                                                      <label class="control-label col-md-7 col-sm-7 ">Seleccione quien será el acudiente del estudiante</label>
                                                      <div class="col-md-5 col-sm-5 ">                                                        
                                                        <select id="acudiente" name="acudiente" class='form-control' required>
                                                            <option value="">Seleccione</option>
                                                            <option value="Madre">Madre</option>
                                                            <option value="Padre">Padre</option>
                                                            <option value="Otro">Otro</option>
                                                        </select>
                                                      </div>
                                                    </div> 
                                                    <div id="acudiente">                                                 
                                                      <div class="form-group row">
                                                        <h5>(En caso de que el estudiante no vaya a vivir con sus padres y/o este acargo de terceros)</h5>
                                                      </div>
                                                      <div class="form-group row">
                                                        <label class="control-label col-md-3 col-sm-3 ">Nombres y Apellidos</label>
                                                        <div class="col-md-9 col-sm-9 ">
                                                          <input type="text" id="nombreAcudiente" name="nombreAcudiente" value="" class="form-control" placeholder="" require>
                                                        </div>
                                                      </div>
                                                      <div class="form-group row">
                                                        <label class="control-label col-md-3 col-sm-3 ">Edad</label>
                                                        <div class="col-md-3 col-sm-3 ">
                                                          <input type="text" id="edadAcudiente" name="edadAcudiente" value="" class="form-control" placeholder="" require>
                                                        </div>
                                                        <label class="control-label col-md-3 col-sm-3 ">No. Documento</label>
                                                        <div class="col-md-3 col-sm-3 ">
                                                          <input type="text" id="documentoAcudiente" name="documentoAcudiente" value="" class="form-control" placeholder="" require>
                                                        </div>
                                                      </div>
                                                      <div class="form-group row">
                                                        <label class="control-label col-md-3 col-sm-3 ">Profesión</label>
                                                        <div class="col-md-9 col-sm-9 ">
                                                          <input type="text" id="profesionAcudiente" name="profesionAcudiente" value="" class="form-control" placeholder="" require>
                                                        </div>
                                                      </div>
                                                      <div class="form-group row">
                                                        <label class="control-label col-md-3 col-sm-3 ">Teléfono</label>
                                                        <div class="col-md-9 col-sm-9 ">
                                                          <input type="text" id="telefonoAcudiente" name="telefonoAcudiente" value="" class="form-control" placeholder="" require>
                                                        </div>
                                                      </div>
                                                      <div class="form-group row">
                                                        <label class="control-label col-md-3 col-sm-3 ">Cargo</label>
                                                        <div class="col-md-9 col-sm-9 ">
                                                          <input type="text" id="cargoAcudiente" name="cargoAcudiente" value="" class="form-control" placeholder="" require>
                                                        </div>
                                                      </div>
                                                      <div class="form-group row">
                                                        <label class="control-label col-md-3 col-sm-3 ">Estado Cívil</label>
                                                        <div class="col-md-9 col-sm-9 ">
                                                          <select id="estadoCivilAcudiente" name="estadoCivilAcudiente" class='form-control'>
                                                              <option value="">Seleccione</option>
                                                              <option value="Casado">Casado</option>
                                                              <option value="Separado">Separado</option>
                                                              <option value="Soltero">Soltero</option>
                                                              <option value="Unión Libre">Unión Libre</option>
                                                              <option value="Viudo">Viudo</option>
                                                          </select>
                                                        </div>
                                                      </div>
                                                      <div class="form-group row">
                                                        <label class="control-label col-md-3 col-sm-3 ">Dirección Residencial</label>
                                                        <div class="col-md-9 col-sm-9 ">
                                                          <input type="text" id="direccionAcudiente" name="direccionAcudiente" value="" class="form-control" placeholder="" require>
                                                        </div>
                                                      </div>
                                                      <div class="form-group row">
                                                        <label class="control-label col-md-3 col-sm-3 ">Barrio</label>
                                                        <div class="col-md-9 col-sm-9 ">
                                                          <input type="text" id="barrioAcudiente" name="barrioAcudiente" value="" class="form-control" placeholder="" require>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div><!--  fin del marco -->
                                            </div>
                                            <div class="row"> 
                                            <div class="col-md-4">              
                                                <button type="submit" class="btn btn-success" style="width: 100%;">
                                                    <i class="fa fa-save m-left-xs"></i> Inscribir
                                                </button>                    
                                            </div>     
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form> 
            <div id="pruebaGuardado"></div>
            <div class='panel-foot'><span id="resultadoAct"></span></div>   
            <div id="PRUEBAS" ></div>
          </div>                        
        </div>
      </div>
    </div>      
  </div>


  <script src="custom/js/jquery.min.js"></script>
  <script src="custom/js/bootstrap.min.js"></script>
  <script src="custom/js/sweetalert.js"></script>
  <script src="custom/js/alertifyjs/alertify.js"></script>
  <script src="custom/app/camara.js"></script>
  <script src="custom/app/inserta.js"></script>
  <script>
    $('#fotoVistaPrevia').hover(
        function() {
            $(this).find('a').fadeIn();
        }, function() {
            $(this).find('a').fadeOut();
        }
    );
    $('#').on('click', function elegirIMG(e) {
         e.preventDefault();
        $('#foto').click();
    });
    $('#guardarIMG').click(function(){
        $('#guardarIMG').fadeOut();
    });
    
    $('#documento').keyup(function () {
        var texto = $(this).val();
        $('#usuario').val(texto);
    });
  </script>
  <script type="text/javascript">
  //Código tomado de http://www.lawebdelprogramador.com/codigo/JavaScript/2380-Calcular-la-edad-desde-una-fecha-dada-en-HTML5.html    
      
  /**
   * Funcion que devuelve true o false dependiendo de si la fecha es correcta.
   * Tiene que recibir el dia, mes y año
   */
  function isValidDate(day,month,year)
  {
      var dteDate;
   
      // En javascript, el mes empieza en la posicion 0 y termina en la 11 
      //   siendo 0 el mes de enero
      // Por esta razon, tenemos que restar 1 al mes
      month = month-1;
      // Establecemos un objeto Data con los valore recibidos
      // Los parametros son: año, mes, dia, hora, minuto y segundos
      // getDate(); devuelve el dia como un entero entre 1 y 31
      // getDay(); devuelve un num del 0 al 6 indicando siel dia es lunes,
      //   martes, miercoles ...
      // getHours(); Devuelve la hora
      // getMinutes(); Devuelve los minutos
      // getMonth(); devuelve el mes como un numero de 0 a 11
      // getTime(); Devuelve el tiempo transcurrido en milisegundos desde el 1
      //   de enero de 1970 hasta el momento definido en el objeto date
      // setTime(); Establece una fecha pasandole en milisegundos el valor de esta.
      // getYear(); devuelve el año
      // getFullYear(); devuelve el año
      dteDate = new Date(year,month,day);
   
      //Devuelva true o false...
      return ((day==dteDate.getDate()) && (month==dteDate.getMonth()) && (year==dteDate.getFullYear()));
  }
   
  /**
   * Funcion para validar una fecha
   * Tiene que recibir:
   *  La fecha en formato ingles yyyy-mm-dd
   * Devuelve:
   *  true-Fecha correcta
   *  false-Fecha Incorrecta
   */
  function validate_fecha(fecha)
  {
      var patron=new RegExp("^(19|20)+([0-9]{2})([-])([0-9]{1,2})([-])([0-9]{1,2})$");
   
      if(fecha.search(patron)==0)
      {
          var values=fecha.split("-");
          if(isValidDate(values[2],values[1],values[0]))
          {
              return true;
          }
      }
      return false;
  }
   
  /**
   * Esta función calcula la edad de una persona y los meses
   * La fecha la tiene que tener el formato yyyy-mm-dd que es
   * metodo que por defecto lo devuelve el <input type="date">
   */
  function calcularEdad(fecha)
  {
      if(validate_fecha(fecha)==true)
      {
          // Si la fecha es correcta, calculamos la edad
          var values=fecha.split("-");
          var dia = values[2];
          var mes = values[1];
          var ano = values[0];
   
          // cogemos los valores actuales
          var fecha_hoy = new Date();
          var ahora_ano = fecha_hoy.getYear();
          var ahora_mes = fecha_hoy.getMonth()+1;
          var ahora_dia = fecha_hoy.getDate();
   
          // realizamos el calculo
          var edad = (ahora_ano + 1900) - ano;
          if ( ahora_mes < mes )
          {
              edad--;
          }
          if ((mes == ahora_mes) && (ahora_dia < dia))
          {
              edad--;
          }
          if (edad > 1900)
          {
              edad -= 1900;
          }
   
          // calculamos los meses
          var meses=0;
          if(ahora_mes>mes)
              meses=ahora_mes-mes;
          if(ahora_mes<mes)
              meses=12-(mes-ahora_mes);
          if(ahora_mes==mes && dia>ahora_dia)
              meses=11;
   
          // calculamos los dias
          var dias=0;
          if(ahora_dia>dia)
              dias=ahora_dia-dia;
          if(ahora_dia<dia)
          {
              ultimoDiaMes=new Date(ahora_ano, ahora_mes, 0);
              dias=ultimoDiaMes.getDate()-(dia-ahora_dia);
          }
   
          document.getElementById("edad").value=edad+" años";
      }else{
          document.getElementById("edad").value="La fecha es incorrecta";
      }
  }

  function previsualizar(input) {
        
        var archivo = document.getElementById("foto").files;
        var tamanho=archivo[0].size;
        var tipo=archivo[0].type;
        var nombre=archivo[0].name;
        if(tamanho>1024*1024){
            alertify.error("El archivo supera el limite del tamaño máximo permitido de 1Mb");
            $('#fotoUs').attr('src', 'vistas/img/Usuarios/silueta.jpg');
            archivo.wrap('<form>').closest('formFoto').get(0).reset();
            archivo.unwrap();
        }else if(tipo!="image/jpg" && tipo!="image/jpeg" && tipo!="image/png" ){
            $('#fotoUs').attr('src', 'vistas/img/Usuarios/silueta.jpg');
            alertify.error("Este tipo de archivo no es permitido");
            archivo.wrap('<form>').closest('formFoto').get(0).reset();
            archivo.unwrap();
        }else{
           if (input.files && input.files[0]) {
                var reader = new FileReader();            
                reader.onload = function (e) {
                    $('#fotoUs').attr('src', e.target.result);
                    $('#guardarIMG').fadeIn();
                }            
                reader.readAsDataURL(input.files[0]);
            } 
        }        
    }

  </script>
</body>
</html>



