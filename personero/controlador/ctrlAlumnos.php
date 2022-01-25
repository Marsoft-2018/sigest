<?php
    require("../modelo/alumnos.php");
    if(isset($_POST['accion'])){
        $accion=$_POST['accion']; 
        
        if($accion=='cargar'){     
            $alu=new Alumno();	
            $alu->Cargar();
        }elseif($accion=='Eliminar'){            
            $alu=new Alumno();	
            $alu->eliminar($_POST['codEst']);
            $alu->Cargar();
        }elseif($accion=='Agregar'){ 
            $codEst= $_POST['codEst'];
            $nombre1= $_POST['nombre1'];
            $nombre2= $_POST['nombre2'];
            $apellido1= $_POST['apellido1'];
            $apellido2= $_POST['apellido2'];
            $grado= $_POST['grado'];
            $grupo= $_POST['grupo'];
            $sexo= $_POST['sexo'];
            $estado= $_POST['estado'];
            $institucion= $_POST['institucion'];
                
            $alu=new Alumno();	
            $alu->Guardar($codEst,$nombre1,$nombre2,$apellido1,$apellido2,$grado,$grupo,$sexo,$estado,$institucion);
            $alu->Cargar();
        }elseif( $accion == "ventanaNuevo"){
            echo '<div style="text-align:left;font-size:14px;line-height: 3em;padding:10px;width:95%;">'.
                    '<label>Código del Estudiante:</label>'.
                    '<input type="text" placeholder="Código del estudiante" id="codEst" value="" class="form form-control ancho" title="Recuerde que este código será el que utilizará el estudiante para ingresar al sistema para votar"/></br>' .
                    '<label>1er. Nombre:</label><input type="text" placeholder="Primer Nombre" id="nombre1" value="" class="form form-control ancho" /></br>' .
                    '<label>2do. Nombre:</label><input type="text" placeholder="Segundo Nombre" id="nombre2" value="" class="form form-control ancho" /></br>' .
                    '<label>1er. Apellido:</label><input type="text" placeholder="Primer Apellido" id="apellido1" value="" class="form form-control ancho" /></br>' .
                    '<label>2do. Apellido:</label><input type="text" placeholder="Segundo Apellido" id="apellido2" value="" class="form form-control ancho" /></br>' . 
                    '<div style="width:25%;float:left;margin:8px;">'.
                    '<label>Grado:</label>'.
                        '<select class="form form-control" name="grado" style="width:100px;" id="grado" required>'.
                            '<option value="">Seleccione..</option>'.
                            '<option value="1">1°</option>'.
                            '<option value="2">2°</option>'.
                            '<option value="3">3°</option>'.
                            '<option value="4">4°</option>'.
                            '<option value="5">5°</option>'.
                            '<option value="6">6°</option>'.
                            '<option value="7">7°</option>'.
                            '<option value="8">8°</option>'.
                            '<option value="9">9°</option>'.
                            '<option value="10">10°</option>'.
                            '<option value="11">11°</option>'.
                        '</select>' .
                    '</div>'.
                    '<div style="width:25%;float:left;margin:8px;">'.
                    '<label>Grupo:</label>'.
                        '<select class="form form-control" style="width:100px;" name="grupo" id="grupo" required>'.
                            '<option value="">Seleccione..</option>'.
                            '<option value="1">1</option>'.
                            '<option value="2">2</option>'.
                            '<option value="3">3</option>'.
                            '<option value="4">4</option>'.
                            '<option value="5">5</option>'.
                        '</select>' .
                    '</div>'.
                    '<div style="width:25%;float:left;margin:8px;">'.
                    '<label>Sexo:</label>'.
                        '<select class="form form-control" name="sexo" style="width:100px;" id="sexo" required>'.
                            '<option value="">Seleccione..</option>'.
                            '<option value="M">M</option>'.
                            '<option value="F">F</option>'.
                        '</select>' .
                    '</div>'.
                '</div>';
                echo "<button class='btn btn-primary' onclick = 'agregarAlumno()' style='padding: 10px 30px; margin-top: 20px; width: 90%'>Guardar</button>";
        }elseif( $accion == "ventanaEditar"){
            $codAlumno = $_POST['codigo'];
            $objEst = new alumno();
            $objEst->id = $codAlumno;
            $sql = $objEst->buscar();
            while($r = mysql_fetch_array($sql)){
                echo        "<div class='col-md-2'>";//Espacio para la foto                    
                echo            "<form id='cambioFoto' name='cambioFoto' enctype='multipart/form-data' method='post' target='resultadoEnvio' onSubmit='cambiarFoto2(this.id)'>";
                echo                "<div id='fotoVistaPrevia'>";                                   
                echo                    "<button href='#' id='elegirIMG' class='btn btn-default' onclick='elegirIMG(this)'>Cambiar Imágen</button>";
                
                                            $sqlFotoEstudiante = mysql_query("SELECT FOTO FROM candidatos WHERE alumnos_CODEST='$codAlumno';");
                                            $res = mysql_num_rows($sqlFotoEstudiante);
                
                                            if($res == 0){
                                               echo "<img src='IMG/silueta.jpg' id='fotoUs' style='margin:0px;height:130px;width:100px;box-shadow: 2px 5px 5px rgba(153,153,153,1);background-color:#ffffff;border-radius:10px;'>";
                                                echo "<input type='hidden' value='0' name='fotoAnterior'>";
                                            }else{
                                                while($foto=mysql_fetch_array($sqlFotoEstudiante)){
                                                    echo "<input type='hidden' value='$foto[0]' name='fotoAnterior'>";
                                                    echo "<img src='IMG/$foto[0]' id='fotoUs' style='margin:0px;height:130px;width:100px;box-shadow: 2px 5px 5px rgba(153,153,153,1);background-color:#ffffff;border-radius:10px;'>";
                                                }
                                            }                                        
                                echo "<input type='file' id='imgProfe' name='imgProfe' onchange='previsualizar(this)' />";
                                echo "</div>                            
                                        <iframe name='resultadoEnvio' style='display:none;'></iframe>
                                        <div id='mostrarMensajeImagen'></div>
                                        <input type='hidden' value='$codAlumno' name='idUsuario'>
                                        <input type='submit' value='Guardar Imágen' id='guardarIMG' class='btn btn-primary' style='margin-top:20px;display:none;width:98%;'>";
                        echo     "</form>";
                        echo   "</div>";
                        echo "<div class='row'>
                        <div class='col-md-6'>
                            <iframe name='cuadroDeCarga' style='display:none'></iframe>
                            
                        </div>";
            echo "</div>
            <script>
                $('#fotoVistaPrevia').hover(
                    function() {
                        $(this).find('#elegirIMG').fadeIn();
                    }, function() {
                        $(this).find('a').fadeOut();
                    }
                );
                $('#elegirIMG').on('click', function(e) {
                     e.preventDefault();
                    $('#imgProfe').click();
                });
                $('#guardarIMG').click(function(){
                    $('#guardarIMG').fadeOut();
                });
                
            </script>    
                ";      
            echo '<div style="text-align:left;font-size:14px;line-height: 3em;padding:10px;width:95%;">'.
                    '<label>Código del Estudiante:</label>'.
                    '<input type="text" placeholder="Código del estudiante" id="codEst" value="'.$r[0].'" class="form form-control ancho" title="Recuerde que este código será el que utilizará el estudiante para ingresar al sistema para votar"/></br>' .
                    '<label>1er. Nombre:</label><input type="text" placeholder="Primer Nombre" id="nombre1" value="'.$r[5].'" class="form form-control ancho" /></br>' .
                    '<label>2do. Nombre:</label><input type="text" placeholder="Segundo Nombre" id="nombre2" value="'.$r[6].'" class="form form-control ancho" /></br>' .
                    '<label>1er. Apellido:</label><input type="text" placeholder="Primer Apellido" id="apellido1" value="'.$r[3].'" class="form form-control ancho" /></br>' .
                    '<label>2do. Apellido:</label><input type="text" placeholder="Segundo Apellido" id="apellido2" value="'.$r[4].'" class="form form-control ancho" /></br>' . 
                    '<div style="width:25%;float:left;margin:8px;">'.
                    '<label>Grado:</label>'.
                        '<select class="form form-control" name="grado" style="width:100px;" id="grado" required>';
                            
                            for($i=1; $i<=11; $i++){
                                if($i == $r[1]){
                                   echo '<option value="'.$r[1].'" selected>'.$r[1].'°</option>';
                               }else{
                                   echo '<option value="'.$i.'">'.$i.'°</option>'; 
                               }
                            }
                            
                    echo    '</select>' .
                    '</div>'.
                    '<div style="width:25%;float:left;margin:8px;">'.
                    '<label>Grupo:</label>'.
                        '<select class="form form-control" style="width:100px;" name="grupo" id="grupo" required>';
                             for($j=1; $j<=5; $j++){
                                if($j == $r[2]){
                                   echo '<option value="'.$r[2].'" selected>'.$r[2].'</option>';
                               }else{
                                   echo '<option value="'.$j.'">'.$j.'</option>'; 
                               }
                            }
                        echo '</select>'.
                    '</div>'.
                    '<div style="width:25%;float:left;margin:8px;">'.
                    '<label>Sexo:</label>'.
                        '<select class="form form-control" name="sexo" style="width:100px;" id="sexo" required>';
                         if($r[9] == "M"){
                            echo '<option value="F">F</option>';
                         }else{
                            echo '<option value="M" >M</option>';
                         }
                            echo '<option value="'.$r[9].'" selected>'.$r[9].'</option>'.                           
                        '</select>' .
                    '</div>'.
                '</div>';
                echo "<button class='btn btn-success' onclick = 'modificarEstudiante()' style='padding: 10px 30px; margin-top: 20px; width: 90%'>Listo</button>";
            }
        }

    }else{
        echo "No se recibe una accion para ejecutar";
        $accion='nada';
    }

    
?>