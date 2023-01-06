<?php

    class Examen
	{
        public $id_proceso_admision;
        public $id_area;
        public $tipo_examen;
        public $creado;
        public $creador;

        public function __construct()
        {
            $this->id_proceso_admision = $this->id_area = $this->tipo_examen = "";
			$this->creado = $this->creador = "";
        }
    }

    class Examen_model
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
		public function insert_record($obj_examen)
		{
			try
			{	
				$this->open_db();

				$query = $this->con_db->prepare("INSERT INTO examenes VALUES (?, ?, ?, null, ?)");
				$query->bind_param("iisi", $obj_examen->id_proceso_admision, $obj_examen->id_area, $obj_examen->tipo_examen, $obj_examen->creador);
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

		public function get_records($id_proceso_admision, $id_area, $tipo_examen)
        {
            try
			{
				$this->open_db();
				
				if($id_proceso_admision > 0)
				{
					if ($id_area) 
					{
						if ($tipo_examen != "") {
							$query = $this->con_db->prepare("SELECT * FROM examenes 
															WHERE id_proceso_admision = ? 
															AND id_area = ?
															AND tipo_examen = ?
															ORDER BY creado ASC");
							$query->bind_param("iis", $id_proceso_admision, $id_area, $tipo_examen);
						}
						else 
						{
							$query = $this->con_db->prepare("SELECT * FROM examenes 
															WHERE id_proceso_admision = ? 
															AND id_area = ?
															ORDER BY creado ASC");
							$query->bind_param("ii", $id_proceso_admision, $id_area);
						}
					}
					else 
					{
						$query = $this->con_db->prepare("SELECT * FROM examenes 
														WHERE id_proceso_admision = ?
														ORDER BY creado ASC");
						$query->bind_param("i", $id_proceso_admision);
					}
				}
				else
				{
					$query = $this->con_db->prepare("SELECT * FROM examenes
													ORDER BY creado ASC");
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