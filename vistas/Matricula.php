<?php 
    require("../Modelo/Conect.php");
    require("../Modelo/sede.php");
    require("../Modelo/grado.php");
    require("../Modelo/matricula.php");

    $objSedes = new Sede();
    $objGrados = new Grados();
?> 

<h3>Estudiante: $this->estudiante."</h3>
<div class='panel panel-primary'>
    <div class='panel-heading' style='padding:2px;height:30px;'>
        <h4 style='padding:2px;margin: 0px;'>
            Matricula / Datos de Pertenencia
        </h4>
    </div>
    <div class='panel-body' id='editarMatricula'>
        <div class='row' style='text-align:center'>
            <div class='col-md-2'>
                <label for="">Año:</label>
                <input type='text' id='NewAnho' name='NewAnho' value='<?php echo date('Y') ?>' class='form-control'>
            </div>
            <div class='col-md-3' style='margin:0px;padding:0px;'>
                <label for="">Sede:</label>
                <select id="sede" name="sede" onchange="cargarCursos(this.value)" class="form-control" style="margin:0px; padding: 0px;" required>
                    <option value=''>Seleccione...</option>
                    <?php 
                        foreach ($objSedes->listar() as $sede) {
                             echo "<option value='".$sede['CODSEDE']."'>".$sede['NOMSEDE']."</option>";
                        }
                    ?>
                </select>                             
            </div>
            <div class="col-md-3">
                <label for="">Grado y Grupo</label>
                <select id='curso' name='curso' class='form-control' style='margin:0px; padding: 0px;width:80%;' required>
                </select>
            </div>
            <div class='col-md-3'>
                Fecha de Ingreso
                <input type='date' name='NewING' id='fechaIngreso' value='' class='form-control' title='Fecha de ingreso del estudiante a la institución'>
            </div>                                
        </div>
        <br>
        <div class='panel panel-default panel-group' id='accordion'>
            <div class='panel-heading' style='padding:1px;'>
                <h4 style='text-decoration:none;' title='De click en este titulo para agregar los datos del acudiente para el estudiante'>
                    <a data-toggle='collapse' data-parent='#accordion' href='#collapseOne'>Datos de Ubicación y Contacto del Acudiente</a>                                        
                </h4>
            </div>
            <div class='panel-body panel-collapse collapse' id='collapseOne'>            
                <div class='row'>
                    <div class='col-md-12'>
                        <label for="">Nombres y Apellidos:</label>
                        <input type='text' id='NOA' value='' class='form-control'>                                
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-3'>
                        <label for="">Barrio:</label>
                        <input type='Text' id='BAR' value='' class='form-control'>                                
                    </div>
                    <div class='col-md-3'>
                        <label for="">Dirección:</label>
                        <input type='text' id='DIR' value='' class='form-control'>
                    </div>
                    <div class='col-md-2'>
                        <label for="">Celular:</label>
                        <input type='text' id='CEL' value='' class='form-control'>
                    </div>
                    <div class='col-md-4'>
                        <label for="">Correo Electrónico:</label>
                        <input type='email' id='COR' value='' class='form-control'>
                    </div>
                </div>
            </div>
        </div>                 
    </div>
</div>

                    echo        "<div class='row' >";
                echo            "<div class='panel panel-default' style='margin:10px;'>";
                echo                "<div class='panel-heading' style='padding: 2px;'>";
                echo                    "<h4 style='margin: 2px;'>";
                echo                        "Listado de matriculas";
                echo                    "</h4>";
                echo                "</div>";
                echo                "<div class='panel-body' style='padding: 5px;padding-left:2px;overflow:auto;text-align:center;' id='listadoMatriculas'>";
                        $objMatricula = new Matricula();
                        $objMatricula->setEstudiante($this->estudiante);
                        $sqlMatriculas = $objMatricula->cargarListaEstudiante();
                        echo "<table class='table table-striped' style='border: 1px solid #cecece;width:95%;margin:0px auto;'>";
                        echo    "<thead>";
                            echo    "<tr>";
                            echo        "<th style='border: 1px solid #cecece;padding:1px;text-align:center;'>";
                            echo            "Cod Matricula";
                            echo        "</th>";
                            echo        "<th style='border: 1px solid #cecece;padding:1px;text-align:center;'>";
                            echo            "Sede";
                            echo        "</th>";
                            echo        "<th style='border: 1px solid #cecece;padding:1px;text-align:center;'>";
                            echo            "Grado";
                            echo        "</th>";
                            echo        "<th style='border: 1px solid #cecece;padding:1px;text-align:center;'>";
                            echo            "Grupo";
                            echo        "</th>";
                            echo        "<th style='border: 1px solid #cecece;padding:1px;text-align:center;'>";
                            echo            "Jornada";
                            echo        "</th>";
                            echo        "<th style='border: 1px solid #cecece;padding:1px;text-align:center;'>";
                            echo            "Año";
                            echo        "</th>";
                            echo        "<th style='border: 1px solid #cecece;padding:1px;text-align:center;'>";
                            echo            "Estado";
                            echo        "</th>"; 
                            echo    "</tr>";
                        echo    "</thead>";
                        echo    "<tbody >";
                                    while($mt=mysql_fetch_array($sqlMatriculas)){
                                        echo    "<tr>";
                                        echo        "<td style='border: 1px solid #cecece;padding:1px;'>";
                                        echo            $mt[0];
                                        echo        "</td>";
                                        echo        "<td style='border: 1px solid #cecece;padding:1px;text-align:left;'>";
                                        echo            $mt[1];
                                        echo        "</td>";
                                        echo        "<td style='border: 1px solid #cecece;padding:1px;'>";
                                        echo            $mt[2];
                                        echo        "</td>";
                                        echo        "<td style='border: 1px solid #cecece;padding:1px;'>";
                                        echo            $mt[3];
                                        echo        "</td>";
                                        echo        "<td style='border: 1px solid #cecece;padding:1px;'>";
                                        echo            $mt[4];
                                        echo        "</td>";
                                        echo        "<td style='border: 1px solid #cecece;padding:1px;'>";
                                        echo            $mt[5];
                                        echo        "</td>";
                                        echo        "<td style='border: 1px solid #cecece;padding:1px;'>";
                                        echo            $mt[6];
                                        echo        "</td>";
                                        echo    "</tr>";
                                    }
                         echo   "</tbody>";
                echo    "</table>";                        
                echo    "</div>";


                echo    "<div class='row'>
                        <div class='col-md-6'>
                            <iframe name='cuadroDeCarga' style='display:none'></iframe>
                            &nbsp;
                            <button id='$this->estudiante."' onclick = 'addMatricula(this.id)' class='btn btn-success'>Matricular</button>
                        </div>    
                        <div class='col-md-6' style='margin:0px;padding:0px;'>  
                            &nbsp;
                            <button id='botonCan' class='btn btn-warning' onclick='cancelar2()'> Finalizar</button>
                        </div>                        
                    </div>
                </div> 