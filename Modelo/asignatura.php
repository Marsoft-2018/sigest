<?php
   // require ('Conect.php');
   class Asignatura extends ConectarPDO{
		public $codSede;
      public $idGrado;
		public $idArea;
		public $id;
		public $abreviatura;
		public $nombre;
		public $porcentaje;
		private $sql;

		public function cargar(){
			$this->sql = "SELECT asg.`id`,asg.`Abreviatura`,asg.`Nombre`,ih.`intensidad`,asg.`porcentaje` FROM asignaturas_intensidad ih INNER JOIN areas_asignaturas asg ON asg.`id` = ih.`idAsignatura` INNER JOIN areasxsedes_2 axs ON axs.`id` = asg.`idArea` WHERE asg.`id` ='".$this->id."'";
			try {
   			$stm = $this->Conexion->prepare($this->sql);
   			$stm->execute();
   			$reg = $stm->fetchAll(PDO::FETCH_ASSOC);  
   			return $reg; 				
			} catch (Exception $e) {
				echo "Error al consultar los datos. <br>".$e;
			}
		}

      public function listar(){
         $this->sql = "SELECT *, 'Asignatura' AS tipo FROM areas_asignaturas WHERE idArea = ? ORDER BY Nombre ASC";
         try {
            $stm = $this->Conexion->prepare($this->sql);
            $stm->bindparam(1,$this->idArea);
            $stm->execute();
            $reg = $stm->fetchAll(PDO::FETCH_ASSOC);  
            return $reg;            
         } catch (Exception $e) {
            echo "Error al consultar los datos. <br>".$e;
         }
      }

      public function intensidad(){
         $this->sql = "SELECT intensidad FROM asignaturas_intensidad WHERE idAsignatura = '".$this->id."' AND idGrado = '".$this->idGrado."';";
         try {
            $stm = $this->Conexion->prepare($this->sql);
            $stm->execute();
            $reg = $stm->fetchAll(PDO::FETCH_ASSOC);  
            foreach ($reg as $key => $value) {
               $reg = $value['intensidad'];
            }
            if(empty($reg)){ $reg = 0; }
            return $reg;            
         } catch (Exception $e) {
            echo "Error al consultar los datos. <br>".$e;
         }
      }

      public function agregar(){
         $this->sql = "INSERT INTO areas_asignaturas(idArea, Abreviatura, Nombre, porcentaje) VALUES(?,?,?,?)";
         try {
            $stm = $this->Conexion->prepare($this->sql);
            $stm->bindParam(1, $this->idArea);
            $stm->bindParam(2, $this->abreviatura);
            $stm->bindParam(3, $this->nombre);
            $stm->bindParam(4, $this->porcentaje);            
            $stm->execute();
            echo "Asignatura agregada con éxito";
         } catch (Exception $e) {
            echo "Ocurrio un error al insertar el area. <br>".$e;
         }
      }

      public function modificar(){
         $this->sql = "UPDATE areas_asignaturas SET Abreviatura = ?, Nombre = ?, porcentaje = ? WHERE id='".$this->id."'";
         try {
            $stm = $this->Conexion->prepare($this->sql);
            $stm->bindParam(1, $this->abreviatura);
            $stm->bindParam(2, $this->nombre);
            $stm->bindParam(3, $this->porcentaje);
            $stm->execute();
            echo "Datos actualizados con éxito";
         } catch (Exception $e) {
            echo "Ocurrio un error al insertar el area. <br>".$e;
         }
      }

      public function eliminar(){
         $this->sql = "DELETE FROM areas_asignaturas WHERE id='".$this->id."'";
         try {
            $stm = $this->Conexion->prepare($this->sql);
            $stm->execute();
         } catch (Exception $e) {
            echo "Ocurrio un error al insertar el area. <br>".$e;
         }
      }

      public function addIntensidad(){
         $this->sql = "INSERT INTO asignaturas_intensidad(idAsignatura, idGrado, intensidad) VALUES(?,?,?)";
         try {
            $stm = $this->Conexion->prepare($this->sql);
            $stm->bindParam(1, $this->id);
            $stm->bindParam(2, $this->idGrado);
            $stm->bindParam(3, $this->intensidad);
            $stm->execute();
         } catch (Exception $e) {
            echo "Ocurrio un error al insertar la intensidad horaria. <br>".$e;
         }
      }

      public function setIntensidad(){
         $this->sql = "UPDATE asignaturas_intensidad SET intensidad = ? WHERE idAsignatura = ? AND idGrado = ?";
         try {
            $stm = $this->Conexion->prepare($this->sql);
            $stm->bindParam(1, $this->intensidad);
            $stm->bindParam(2, $this->id);
            $stm->bindParam(3, $this->idGrado);
            $stm->execute();
            echo "Se modificó la intensidad horaria con éxito";
         } catch (Exception $e) {
            echo "Ocurrio un error al modificar la intensidad horaria. ".$e;
         }
      }

      public function totalAsignaturas(){
         $this->sql = "SELECT COUNT(ih.id) AS total FROM asignaturas_intensidad ih INNER JOIN areas_asignaturas asg ON asg.`id` = ih.`idAsignatura` INNER JOIN areasxsedes_2 axs ON axs.`id` = asg.`idArea` WHERE asg.`idArea` = ? AND ih.`intensidad` != 0 AND ih.idGrado= ? ORDER BY axs.Nombre ASC";
         try {
            $stm = $this->Conexion->prepare($this->sql);
            $stm->bindparam(1,$this->idArea);
            $stm->bindparam(2,$this->idGrado);
            $stm->execute();
            $total = $stm->fetchAll(PDO::FETCH_ASSOC);
              foreach ($total as $val) {
                  $total = $val['total'];
              }
              return $total;
          } catch (Exception $e) {
              
          }
      }

      public function totalHoras($grado){
         $this->sql = "SELECT SUM(intensidad) AS 'total' FROM (SELECT axs.`id`,axs.`Abreviatura`,axs.`Nombre`,ih.`intensidad` FROM areasxsedes_2 axs INNER JOIN areas_intensidad ih ON ih.`idArea` = axs.`id` INNER JOIN areas_anho ara ON ara.`idArea` = axs.`id` WHERE axs.`codsede` = ? AND ara.anho = ? AND ih.`idGrado`=?) AS horas";
         try {
            $stm = $this->Conexion->prepare($this->sql);
            $stm->bindparam(1,$this->codSede);
            $stm->bindparam(2,$this->anho);
            $stm->bindparam(3,$grado);
            $stm->execute();
            $reg = $stm->fetchAll(PDO::FETCH_ASSOC);  
            foreach ($reg as $key => $horas) {
               $reg = $horas['total'];
            }
            if (empty($reg)) {
               $reg = 0;
            }
            return $reg; 

         } catch (Exception $e) {
            echo "Error al consultar los datos. <br>".$e;
         }
      }

   }
         
?>
