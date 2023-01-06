<?php

    class Area_materia{
        public $id_area;
        public $id_materia;
        public $n_orden;
        public $n_preguntas;
        public $puntaje_pregunta;
        public $participa;
        public $creado;
        public $creador;

        public function __construct()
        {
            $this->id_area = $this->id_materia = "";
			$this->n_orden = $this->n_preguntas = $this->puntaje_pregunta =  0;
			$this->participa = false;
			$this->creado = $this->creador = "";
		}
    }

    class Area_materia_model{
        
        public $host;
        public $user;
        public $pass;
        public $db;
        public $con_db;

        // set database config for mysql
		function __construct($con_setup)
		{
			$this->host = $con_setup->host;
			$this->user = $con_setup->user;
			$this->pass =  $con_setup->pass;
			$this->db = $con_setup->db;            					
		}

        // open mysql data base
        public function open_db()
        {
            $this->con_db = new mysqli($this->host, $this->user, $this->pass, $this->db);
            if ($this->con_db->connect_error) 
            {
                die("Erron in connection: " . $this->con_db->connect_error);
            }
        }

        // close database
        public function close_db()
        {
            $this->con_db->close();
        }

        // insert record
		public function insert_record($obj_area_materia)
		{
			try
			{	
				$this->open_db();

				$query = $this->con_db->prepare("INSERT INTO areas_materias VALUES (?, ?, ?, ?, ?, ?, null, ?)");
				$query->bind_param("iiiidii", $obj_area_materia->id_area, $obj_area_materia->id_materia, $obj_area_materia->n_orden, $obj_area_materia->n_preguntas, $obj_area_materia->puntaje_pregunta, $obj_area_materia->participa, $obj_area_materia->creador);
				$query->execute();
				$res= $query->get_result();
				$last_id = $this->con_db->insert_id;
				$query->close();

				$this->close_db();
				return $last_id;
			}
			catch (Exception $e) 
			{
				$this->close_db();	
            	throw $e;
        	}
		}

        public function get_records($id_area, $id_materia, $scope_materia)
        {
            try
			{
				$this->open_db();
				
				if($id_area > 0)
				{
					if ($id_materia > 0)
					{
						$query = $this->con_db->prepare("SELECT A.*, M.*, AM.n_orden, AM.n_preguntas, AM.puntaje_pregunta, AM.participa  FROM areas_materias AM
														JOIN areas A
														ON (AM.id_area = A.id_area)
														JOIN materias M
														ON (AM.id_materia = M.id_materia)
														WHERE A.id_area = ? AND M.id_materia = ?
														ORDER BY AM.n_orden ASC");
						$query->bind_param("ii", $id_area, $id_materia);
					}
					elseif ($scope_materia != 0) 
					{
						$query = $this->con_db->prepare("SELECT A.*, M.*, AM.n_orden, AM.n_preguntas, AM.puntaje_pregunta, AM.participa  FROM areas_materias AM
														JOIN areas A
														ON (AM.id_area = A.id_area)
														JOIN materias M
														ON (AM.id_materia = M.id_materia)
														WHERE A.id_area = ? AND M.scope = ?
														ORDER BY AM.n_orden ASC");
						$query->bind_param("ii", $id_area, $scope_materia);
					}
					else
					{
						$query = $this->con_db->prepare("SELECT A.*, M.*, AM.n_orden, AM.n_preguntas, AM.puntaje_pregunta, AM.participa  FROM areas_materias AM
														JOIN areas A
														ON (AM.id_area = A.id_area)
														JOIN materias M
														ON (AM.id_materia = M.id_materia)
														WHERE A.id_area = ?
														ORDER BY AM.n_orden ASC");
						$query->bind_param("i", $id_area);
					}
				}
				else
				{
					$query = $this->con_db->prepare("SELECT A.*, M.*, AM.n_orden, AM.n_preguntas, AM.puntaje_pregunta, AM.participa  FROM areas_materias AM
														JOIN areas A
														ON (AM.id_area = A.id_area)
														JOIN materias M
														ON (AM.id_materia = M.id_materia)
														ORDER BY AM.n_orden ASC");
				}
				
				$query->execute();
				$res = $query->get_result();
				$query->close();

				$this->close_db();
				return $res;
			}
			catch (Exception $e) 
			{
				$this->close_db();	
            	throw $e;
        	}
        }

		/*
		public function get_areas($id_proceso_admision)
        {
            try
			{
				$this->open_db();

				$query = $this->con_db->prepare("SELECT areas.id_area, areas.nombre, pa_areas.configurado FROM pa_areas JOIN areas ON (pa_areas.id_area = areas.id_area) WHERE pa_areas.id_proceso_admision = ? ORDER BY areas.nombre ASC");
                $query->bind_param("i", $id_proceso_admision);
				$query->execute();
				$res= $query->get_result();
				$query->close();

				$this->close_db();
				return $res;
			}
			catch (Exception $e) 
			{
				$this->close_db();	
            	throw $e;
        	}
        }
		*/
    }

    
?>