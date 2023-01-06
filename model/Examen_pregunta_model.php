<?php

    class Examen_pregunta
	{
        public $id_proceso_admision;
        public $id_area;
        public $tipo_examen;
        public $id_pregunta;
        public $n_orden_general;
        public $letra_respuesta;
        public $creado;
        public $creador;

        public function __construct()
        {
            $this->id_proceso_admision = $this->id_area = $this->tipo_examen = $this->id_pregunta = "";
			$this->n_orden_general = $this->letra_respuesta = "";
			$this->creado = $this->creador = "";
		}
    }

    class Examen_pregunta_model
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
		public function insert_record($obj_examen_pregunta)
		{
			try
			{	
				$this->open_db();

				$query = $this->con_db->prepare("INSERT INTO examenes_preguntas VALUES (?, ?, ?, ?, ?, ?, null, ?)");
				$query->bind_param("iisiisi", $obj_examen_pregunta->id_proceso_admision, $obj_examen_pregunta->id_area, $obj_examen_pregunta->tipo_examen, $obj_examen_pregunta->id_pregunta, $obj_examen_pregunta->n_orden_general, $obj_examen_pregunta->letra_respuesta,  $obj_examen_pregunta->creador);
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

		public function get_records($id_proceso_admision, $id_area, $tipo_examen, $id_materia)
        {
            try
			{
				$this->open_db();
				
				if($id_proceso_admision > 0)
				{
					if ($id_area) 
					{
						if ($tipo_examen != "") {
							if ($id_materia > 0) 
							{
								$query = $this->con_db->prepare("SELECT * FROM examenes_preguntas EP
														JOIN preguntas P
														ON (EP.id_pregunta = P.id_pregunta)
														JOIN pa_areas_materias PAM
														ON CONCAT(P.id_proceso_admision, P.id_area, P.id_materia) = CONCAT(PAM.id_proceso_admision, PAM.id_area, PAM.id_materia)
														WHERE EP.id_proceso_admision = ? AND EP.id_area = ? AND EP.tipo_examen = ? AND PAM.id_materia = ?
														ORDER BY EP.n_orden_general ASC");
								$query->bind_param("iisi", $id_proceso_admision, $id_area, $tipo_examen, $id_materia);
							}
							else 
							{
								$query = $this->con_db->prepare("SELECT * FROM examenes_preguntas EP
														JOIN preguntas P
														ON (EP.id_pregunta = P.id_pregunta)
														JOIN pa_areas_materias PAM
														ON CONCAT(P.id_proceso_admision, P.id_area, P.id_materia) = CONCAT(PAM.id_proceso_admision, PAM.id_area, PAM.id_materia)
														WHERE EP.id_proceso_admision = ? AND EP.id_area = ? AND EP.tipo_examen = ?
														ORDER BY EP.n_orden_general ASC");
								$query->bind_param("iis", $id_proceso_admision, $id_area, $tipo_examen);
							}
						}
						else 
						{
							$query = $this->con_db->prepare("SELECT * FROM examenes_preguntas EP
														JOIN preguntas P
														ON (EP.id_pregunta = P.id_pregunta)
														JOIN pa_areas_materias PAM
														ON CONCAT(P.id_proceso_admision, P.id_area, P.id_materia) = CONCAT(PAM.id_proceso_admision, PAM.id_area, PAM.id_materia)
														WHERE EP.id_proceso_admision = ? AND EP.id_area = ?
														ORDER BY EP.n_orden_general ASC");
							$query->bind_param("iis", $id_proceso_admision, $id_area);
						}
					}
					else 
					{
						$query = $this->con_db->prepare("SELECT * FROM examenes_preguntas EP
														JOIN preguntas P
														ON (EP.id_pregunta = P.id_pregunta)
														JOIN pa_areas_materias PAM
														ON CONCAT(P.id_proceso_admision, P.id_area, P.id_materia) = CONCAT(PAM.id_proceso_admision, PAM.id_area, PAM.id_materia)
														WHERE EP.id_proceso_admision = ?
														ORDER BY EP.n_orden_general ASC");
						$query->bind_param("iis", $id_proceso_admision);
					}
				}
				else
				{
					$query = $this->con_db->prepare("SELECT * FROM examenes_preguntas EP
														JOIN preguntas P
														ON (EP.id_pregunta = P.id_pregunta)
														JOIN pa_areas_materias PAM
														ON CONCAT(P.id_proceso_admision, P.id_area, P.id_materia) = CONCAT(PAM.id_proceso_admision, PAM.id_area, PAM.id_materia)
														ORDER BY EP.n_orden_general ASC");
				}
				
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

		/*
		public function get_records_by_pregunta($id_pregunta)
        {
            try
			{
				$this->open_db();
				
				if($id_pregunta > 0)
				{
					$query = $this->con_db->prepare("SELECT * FROM alternativas WHERE id_pregunta = ? ORDER BY id_alternativa ASC");
					$query->bind_param("i", $id_pregunta);
				}
				else
				{
					$query = $this->con_db->prepare("SELECT * FROM alternativas ORDER BY id_alternativa ASC");
				}
				
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

		public function update_contenido_alternativa($id_alternativa, $alternativa)
		{
			try
			{
				$this->open_db();

				$query = $this->con_db->prepare("UPDATE alternativas
											SET alternativa = ?
											WHERE id_alternativa = ?");
                $query->bind_param("si", $alternativa, $id_alternativa);
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

		public function update_status_respuesta($id_alternativa, $respuesta)
		{
			try
			{
				$this->open_db();

				$query = $this->con_db->prepare("UPDATE alternativas
											SET respuesta = ?
											WHERE id_alternativa = ?");
                $query->bind_param("ii", $respuesta, $id_alternativa);
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

        /*public function get_records($id_proceso_admision)
        {
            try
			{
				$this->open_db();
				
				if($id_proceso_admision > 0)
				{
					$query = $this->con_db->prepare("SELECT * FROM procesos_admision WHERE id_proceso_admision = ? ORDER BY fecha ASC");
					$query->bind_param("i", $id_proceso_admision);
				}
				else
				{
					$query = $this->con_db->prepare("SELECT * FROM procesos_admision ORDER BY fecha ASC");
				}
				
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

		public function update_status_areas_configuradas($id_proceso_admision, $areas_configuradas)
		{
			try
			{
				$this->open_db();

				$query = $this->con_db->prepare("UPDATE procesos_admision
											SET areas_configuradas = ?
											WHERE id_proceso_admision = ?");
                $query->bind_param("ii", $areas_configuradas, $id_proceso_admision);
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
		*/
    }

    
?>