<?php

    class Usuario
	{
        public $username;
        public $password;
        public $nombre;
        public $apellidos;
        public $telefono;
        public $creado;

        public function __construct()
        {
            $this->username = "";
            $this->password = "";
            $this->nombre = "";
            $this->apellidos = "";
            $this->telefono = "";
            $this->creado = "";
        }
    }

    class Usuario_model
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
		public function insert_record($obj_usuario)
		{
			try
			{	
				$this->open_db();

				$query = $this->con_db->prepare("INSERT INTO usuarios VALUES (null, ?, ?, ?, ?, ?, ?)");
				$query->bind_param("sii", $obj_usuario->username, $obj_usuario->passwor, $obj_usuario->nombre, $obj_usuario->apellidos, $obj_usuario->telefono, $obj_usuario->creado);
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

		public function get_records($id_usuario)
        {
            try
			{
				$this->open_db();
				
				if($id_usuario > 0)
				{
					$query = $this->con_db->prepare("SELECT * FROM usuarios WHERE id_usuario = ? ORDER BY creado ASC");
					$query->bind_param("i", $id_usuario);
				}
				else
				{
					$query = $this->con_db->prepare("SELECT * FROM usuarios ORDER BY creado ASC");
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

		public function get_record_by_username_password($username, $password)
        {
            try
			{
				$this->open_db();
				
				$query = $this->con_db->prepare("SELECT * FROM usuarios WHERE username = ? AND password = ?");
				$query->bind_param("ss", $username, $password);
				
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

        public function get_records($id_proceso_admision)
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