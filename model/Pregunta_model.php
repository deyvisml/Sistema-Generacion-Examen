<?php

    class Pregunta{
        public $pregunta;
        public $n_orden;
        public $creado;
        public $creador;
        public $id_proceso_admision;
        public $id_area;
        public $id_materia;

        public function __construct()
        {
            $this->pregunta = "";
			$this->creado = $this->creador = "";
            $this->n_orden = $this->id_proceso_admision = $this->id_area = $this->id_materia = 0;
        }
    }

    class Pregunta_model{
        
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
		public function insert_record($obj_pregunta)
		{
			try
			{	
				$this->open_db();

				$query = $this->con_db->prepare("INSERT INTO preguntas VALUES (null, ?, ?, null, ?, ?, ?, ?)");
				$query->bind_param("siiiii", $obj_pregunta->pregunta, $obj_pregunta->n_orden, $obj_pregunta->creador, $obj_pregunta->id_proceso_admision, $obj_pregunta->id_area, $obj_pregunta->id_materia);
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

		public function get_records($id_pregunta)
        {
            try
			{
				$this->open_db();
				
				if($id_pregunta > 0)
				{
					$query = $this->con_db->prepare("SELECT * FROM preguntas WHERE id_pregunta = ? ORDER BY n_orden ASC");
					$query->bind_param("i", $id_pregunta);
				}
				else
				{
					$query = $this->con_db->prepare("SELECT * FROM preguntas ORDER BY n_orden ASC");
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

		public function get_records_by_pa_area_materia($id_proceso_admision, $id_area, $id_materia)
		{
			try
			{
				$this->open_db();

				if ($id_proceso_admision > 0) 
				{
					if ($id_area > 0)
					{
						if($id_materia > 0)
						{
							$query = $this->con_db->prepare("SELECT * FROM preguntas P 
												JOIN pa_areas_materias PAM
												ON CONCAT(P.id_proceso_admision, P.id_area, P.id_materia) = CONCAT(PAM.id_proceso_admision, PAM.id_area, PAM.id_materia)
												WHERE P.id_proceso_admision = ?
												AND P.id_area = ?
												AND P.id_materia = ?
												ORDER BY PAM.n_orden ASC");
							$query->bind_param("iii", $id_proceso_admision, $id_area, $id_materia);
						}	
						else
						{
							$query = $this->con_db->prepare("SELECT * FROM preguntas P 
												JOIN pa_areas_materias PAM
												ON CONCAT(P.id_proceso_admision, P.id_area, P.id_materia) = CONCAT(PAM.id_proceso_admision, PAM.id_area, PAM.id_materia)
												WHERE P.id_proceso_admision = ?
												AND P.id_area = ?
												ORDER BY PAM.n_orden ASC");
							$query->bind_param("ii", $id_proceso_admision, $id_area);
						}
					}
					else 
					{
						$query = $this->con_db->prepare("SELECT * FROM preguntas P 
												JOIN pa_areas_materias PAM
												ON CONCAT(P.id_proceso_admision, P.id_area, P.id_materia) = CONCAT(PAM.id_proceso_admision, PAM.id_area, PAM.id_materia)
												WHERE P.id_proceso_admision = ?
												ORDER BY PAM.n_orden ASC");
						$query->bind_param("i", $id_proceso_admision);
					}
				}
				else 
				{
					$query = $this->con_db->prepare("SELECT * FROM preguntas P 
												JOIN pa_areas_materias PAM
												ON CONCAT(P.id_proceso_admision, P.id_area, P.id_materia) = CONCAT(PAM.id_proceso_admision, PAM.id_area, PAM.id_materia)
												ORDER BY PAM.n_orden ASC");
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

		public function update_contenido_pregunta($id_pregunta, $pregunta)
		{
			try
			{
				$this->open_db();

				$query = $this->con_db->prepare("UPDATE preguntas
											SET pregunta = ?
											WHERE id_pregunta = ?");
                $query->bind_param("si", $pregunta, $id_pregunta);
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