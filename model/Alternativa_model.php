<?php

    class Alternativa
	{
        public $alternativa;
        public $respuesta;
        public $creado;
        public $creador;
        public $id_pregunta;

        public function __construct()
        {
            $this->alternativa = "";
            $this->respuesta = false;
            $this->creado = $this->creador = "";
            $this->id_pregunta = 0;
        }
    }

    class Alternativa_model
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
		public function insert_record($obj_alternativa)
		{
			try
			{	
				$this->open_db();

				$query = $this->con_db->prepare("INSERT INTO alternativas VALUES (null, ?, ?, null, ?, ?)");
				$query->bind_param("siii", $obj_alternativa->alternativa, $obj_alternativa->respuesta, $obj_alternativa->creador, $obj_alternativa->id_pregunta);
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