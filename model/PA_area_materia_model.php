<?php

    class PA_area_materia
	{
        public $id_proceso_admision;
        public $id_area;
        public $id_materia;
        public $n_orden;
        public $n_preguntas;
        public $puntaje_pregunta;
        public $preguntas_guardadas;
        public $creado;
        public $creador;

        public function __construct()
        {
            $this->id_proceso_admision = $this->id_area = $this->id_materia = "";
			$this->n_orden = $this->n_preguntas = $this->puntaje_pregunta = 0;
			$this->preguntas_guardadas = false;
			$this->creado = $this->creador = "";
        }
    }

    class PA_area_materia_model
	{
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
		public function insert_record($obj_pa_area_materia)
		{
			try
			{	
				$this->open_db();

				$query = $this->con_db->prepare("INSERT INTO pa_areas_materias VALUES (?, ?, ?, ?, ?, ?, ?, null, ?)");
				$query->bind_param("iiiiidii", $obj_pa_area_materia->id_proceso_admision, $obj_pa_area_materia->id_area, $obj_pa_area_materia->id_materia, $obj_pa_area_materia->n_orden, $obj_pa_area_materia->n_preguntas, $obj_pa_area_materia->puntaje_pregunta, $obj_pa_area_materia->preguntas_guardadas, $obj_pa_area_materia->creador);
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

        public function get_records($id_proceso_admision, $id_area, $id_materia)
        {
            try
			{
				$this->open_db();
				
				if($id_proceso_admision > 0)
				{
					if ($id_area > 0)
					{
						if ($id_materia > 0) 
						{
							$query = $this->con_db->prepare("SELECT * FROM pa_areas_materias PAM
															JOIN pa_areas PA
															ON CONCAT(PAM.id_proceso_admision, PAM.id_area) = CONCAT(PA.id_proceso_admision, PA.id_area)
															JOIN materias M
															ON PAM.id_materia = M.id_materia
															WHERE PAM.id_proceso_admision = ? AND PAM.id_area = ? AND PAM.id_materia = ? 
															ORDER BY PAM.n_orden ASC");
							$query->bind_param("iii", $id_proceso_admision, $id_area, $id_materia);
						}
						else 
						{
							$query = $this->con_db->prepare("SELECT * FROM pa_areas_materias PAM
															JOIN pa_areas PA
															ON CONCAT(PAM.id_proceso_admision, PAM.id_area) = CONCAT(PA.id_proceso_admision, PA.id_area)
															JOIN materias M
															ON PAM.id_materia = M.id_materia
															WHERE PAM.id_proceso_admision = ? AND PAM.id_area = ?
															ORDER BY PAM.n_orden ASC");
							$query->bind_param("ii", $id_proceso_admision, $id_area);
						}
					}
					else
					{
						$query = $this->con_db->prepare("SELECT * FROM pa_areas_materias PAM
															JOIN pa_areas PA
															ON CONCAT(PAM.id_proceso_admision, PAM.id_area) = CONCAT(PA.id_proceso_admision, PA.id_area)
															JOIN materias M
															ON PAM.id_materia = M.id_materia
															WHERE PAM.id_proceso_admision = ?
															ORDER BY PAM.n_orden ASC");
						$query->bind_param("i", $id_proceso_admision);
					}
				}
				else
				{
					$query = $this->con_db->prepare("SELECT * FROM pa_areas_materias PAM
															JOIN pa_areas PA
															ON CONCAT(PAM.id_proceso_admision, PAM.id_area) = CONCAT(PA.id_proceso_admision, PA.id_area)
															JOIN materias M
															ON PAM.id_materia = M.id_materia");
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

		public function update_status_preguntas_guardadas($id_proceso_admision, $id_area, $id_materia, $preguntas_guardadas)
		{
			try
			{
				$this->open_db();

				$query = $this->con_db->prepare("UPDATE pa_areas_materias
											SET preguntas_guardadas = ?
											WHERE id_proceso_admision = ? AND id_area = ? AND id_materia = ?");
                $query->bind_param("iiii", $preguntas_guardadas, $id_proceso_admision, $id_area, $id_materia);
				$query->execute();
				$res= $query->get_result();
				$query->close();

				$this->close_db();
				return true;
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