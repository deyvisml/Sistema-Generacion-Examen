<?php

    class PA_area{
        public $id_proceso_admision;
        public $id_area;
        public $materias_configuradas;
        public $n_tipos_examenes;
        public $examenes_generados;

        public function __construct()
        {
            $this->id_proceso_admision = $this->id_area = "";
			$this->materias_configuradas = $this->examenes_generados = false;
			$this->n_tipos_examenes = 0;
        }
    }

    class PA_area_model{
        
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
		public function insert_record($obj_pa_area)
		{
			try
			{	
				$this->open_db();

				$query = $this->con_db->prepare("INSERT INTO pa_areas VALUES (?, ?, ?, ?, ?, null, ?)");
				$query->bind_param("iiiiii", $obj_pa_area->id_proceso_admision, $obj_pa_area->id_area, $obj_pa_area->materias_configuradas, $obj_pa_area->n_tipos_examenes, $obj_pa_area->examenes_generados, $obj_pa_area->creador);
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

        public function get_records($id_proceso_admision, $id_area)
        {
            try
			{
				$this->open_db();
				
				if($id_proceso_admision > 0)
				{
					if ($id_area > 0)
					{
						$query = $this->con_db->prepare("SELECT * FROM pa_areas JOIN areas ON (pa_areas.id_area = areas.id_area) WHERE pa_areas.id_proceso_admision = ? AND areas.id_area = ? ORDER BY areas.nombre ASC");
						$query->bind_param("ii", $id_proceso_admision, $id_area);
					}
					else
					{
						$query = $this->con_db->prepare("SELECT * FROM pa_areas JOIN areas ON (pa_areas.id_area = areas.id_area) WHERE pa_areas.id_proceso_admision = ? ORDER BY areas.nombre ASC");
						$query->bind_param("i", $id_proceso_admision);
					}
				}
				else
				{
					$query = $this->con_db->prepare("SELECT * FROM pa_areas JOIN areas ON (pa_areas.id_area = areas.id_area) ORDER BY areas.nombre ASC");
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

		public function update_status_materias_configuradas($id_proceso_admision, $id_area, $materias_configuradas)
		{
			try
			{
				$this->open_db();

				$query = $this->con_db->prepare("UPDATE pa_areas
											SET materias_configuradas = ?
											WHERE id_proceso_admision = ? AND id_area = ?");
                $query->bind_param("iii", $materias_configuradas, $id_proceso_admision, $id_area);
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

		public function update_status_examenes_generados($id_proceso_admision, $id_area, $examenes_generados)
		{
			try
			{
				$this->open_db();

				$query = $this->con_db->prepare("UPDATE pa_areas
											SET examenes_generados = ?
											WHERE id_proceso_admision = ? AND id_area = ?");
                $query->bind_param("iii", $examenes_generados, $id_proceso_admision, $id_area);
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

		public function get_areas($id_proceso_admision)
        {
            try
			{
				$this->open_db();

				$query = $this->con_db->prepare("SELECT areas.id_area, areas.nombre, pa_areas.materias_configuradas FROM pa_areas JOIN areas ON (pa_areas.id_area = areas.id_area) WHERE pa_areas.id_proceso_admision = ? ORDER BY areas.nombre ASC");
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
    }

    
?>