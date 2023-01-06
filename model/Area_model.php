<?php

    class Area{
        public $nombre;
        public $scope;
        public $participa;
        public $creado;
        public $creador;

        public function __construct()
        {
            $this->nombre = $this->scope = $this->creado = $this->creador = "";
			$this->participa = false;
        }
    }

    class Area_model{
        
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
		public function insert_record($obj_area)
		{
			try
			{	
				$this->open_db();

				$query = $this->con_db->prepare("INSERT INTO areas VALUES (null, ?, ?, ?, null, ?)");
				$query->bind_param("siii", $obj_area->nombre, $obj_area->scope, $obj_area->participa, $obj_area->creador);
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

        public function get_records($id_area, $scope)
        {
            try
			{
				$this->open_db();
				
				if($id_area != 0)
				{
					$query = $this->con_db->prepare("SELECT * FROM areas WHERE id_area = ? ORDER BY id_area ASC");
					$query->bind_param("i", $id_area);
				}
				else if($scope != 0)
				{
					$query = $this->con_db->prepare("SELECT * FROM areas WHERE scope = ? ORDER BY id_area ASC");
					$query->bind_param("i", $scope);
				}
				else 
				{
					$query = $this->con_db->prepare("SELECT * FROM areas ORDER BY id_area ASC");
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

        public function get_id_by_name_scope($nombre, $scope)
        {
            try
			{
				$this->open_db();

				$query = $this->con_db->prepare("SELECT id_area FROM areas WHERE nombre = ? AND scope = ?");
                $query->bind_param("si", $nombre, $scope);
				$query->execute();
				$res= $query->get_result();
				$query->close();

				$this->close_db();

                $row = $res->fetch_array(MYSQLI_NUM);
				return $row[0];
			}
			catch (Exception $e) 
			{
				$this->close_db();	
            	throw $e;
        	}
        }
    }

    
?>