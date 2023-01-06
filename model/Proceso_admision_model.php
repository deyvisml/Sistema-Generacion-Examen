<?php

    class Proceso_admision{
        public $nombre;
        public $areas_configuradas;
        public $creado;

        public function __construct()
        {
            $this->nombre = $this->creado = "";
            $this->areas_configuradas = false;
        }
    }

    class Proceso_admision_model{
        
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
		public function insert_record($obj_proceso_admision)
		{
			try
			{	
				$this->open_db();

				$query = $this->con_db->prepare("INSERT INTO procesos_admision VALUES (null, ?, ?, null, ?)");
				$query->bind_param("sis", $obj_proceso_admision->nombre, $obj_proceso_admision->areas_configuradas, $obj_proceso_admision->creador);
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

        public function get_records($id_proceso_admision)
        {
            try
			{
				$this->open_db();
				
				if($id_proceso_admision > 0)
				{
					$query = $this->con_db->prepare("SELECT * FROM procesos_admision WHERE id_proceso_admision = ? ORDER BY creado ASC");
					$query->bind_param("i", $id_proceso_admision);
				}
				else
				{
					$query = $this->con_db->prepare("SELECT * FROM procesos_admision ORDER BY creado ASC");
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

        
    }

    
?>