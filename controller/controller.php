<?php
    session_start();

    try {
        require_once 'config.php';
        require 'model/Proceso_admision_model.php';
        require 'model/Area_model.php';
        require 'model/PA_area_model.php';
        require 'model/Materia_model.php';
        require 'model/Area_materia_model.php';
        require 'model/PA_area_materia_model.php';
        require 'model/Pregunta_model.php';
        require 'model/Alternativa_model.php';
        require 'model/Examen_model.php';
        require 'model/Examen_pregunta_model.php';
        require 'model/Usuario_model.php';
    } catch (\Throwable $th) {
        require_once '../config.php';
        require '../model/Proceso_admision_model.php';
        require '../model/Area_model.php';
        require '../model/PA_area_model.php';
        require '../model/Materia_model.php';
        require '../model/Area_materia_model.php';
        require '../model/PA_area_materia_model.php';
        require '../model/Pregunta_model.php';
        require '../model/Alternativa_model.php';
        require '../model/Examen_model.php';
        require '../model/Examen_pregunta_model.php';
        require '../model/Usuario_model.php';
    }
    

    session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();
    
	class controller 
	{

 		function __construct() 
		{          
			$this->objconfig = new config();
			$this->obj_pam =  new Proceso_admision_model($this->objconfig);
			$this->obj_am =  new Area_model($this->objconfig);
			$this->obj_paam =  new PA_area_model($this->objconfig);
			$this->obj_mm =  new Materia_model($this->objconfig);
			$this->obj_amm =  new Area_materia_model($this->objconfig);
			$this->obj_amm =  new Area_materia_model($this->objconfig);
			$this->obj_paamm =  new PA_area_materia_model($this->objconfig);
			$this->obj_pm =  new Pregunta_model($this->objconfig);
			$this->obj_alternativa_m =  new Alternativa_model($this->objconfig);
			$this->obj_em =  new Examen_model($this->objconfig);
			$this->obj_epm =  new Examen_pregunta_model($this->objconfig);
			$this->obj_um =  new Usuario_model($this->objconfig);
		}
        // mvc handler request
		public function mvcHandler() 
		{
			$act = isset($_GET['act']) ? $_GET['act'] : NULL;
            echo $act;

			switch ($act) 
			{
                case 'login' :                    
					$this->login();
                    break;
                case 'add_pa' :                    
					$this->add_proceso_admision();
                    break;
                case 'add_area' :                    
                    $this->add_area();
                    break;
                case 'guardar_config_areas' :                    
                    $this->guardar_config_areas();
                    break;
                case 'elaborar_examen' :                    
                    $this->page_redirect("view/04_elaborar_examen.php");
                    break;
                case 'add_materia' :                    
                    $this->add_materia();
                    break;
                case 'guardar_config_materias' :                    
                    $this->guardar_config_materias();
                    break;
                case 'guardar_preguntas' :                    
                    $this->guardar_preguntas();
                    break;
                case 'update_pregunta_alternativas' :                    
                    $this->update_pregunta_alternativas();
                    break;
                case 'add_examenes' :                    
                    $this->add_examenes();
                    break;

				default:
                    $this->page_redirect("view/00_index.php");
			}
		}
        // page redirection
		public function page_redirect($url)
		{
			header('Location:'.$url);
		}

        public function login()
        {
            try{

                if (isset($_POST['btn_login'])) 
                {
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $result = $this->obj_um->get_record_by_username_password($username, $password);
                    
                    $filas_afectadas = mysqli_num_rows($result); //muy importante, para saber cuantas filas fueron afectadas al ejecutar la sentencia y asi saber si existe el usuario o no

                    if($filas_afectadas == 1)
                    {
                        $row = mysqli_fetch_array($result);
                        $_SESSION['id_usuario'] = $row['id_usuario'];
                        $this->page_redirect("view/01_inicio.php");
                    }
                    else
                    {
                        echo "Somthing is wrong..., try again.";
                        $this->page_redirect("view/00_login.php");
                    }
                }
                else 
                {
                    $this->page_redirect("view/00_login.php");
                }
            }
            catch (Exception $e) 
            {
                //$this->close_db();
                $this->objsm->close_db();
                throw $e;
            }
        }
        
        public function add_proceso_admision()
        {
            try{
                $obj_proceso_admision = new Proceso_admision();

                if (isset($_POST['btn_create_pa'])) 
                {   
                    $obj_proceso_admision->nombre = trim($_POST['nombre_pa']);
                    $obj_proceso_admision->creador = $_SESSION['id_usuario'];
                    //date_default_timezone_set('America/Lima');
                    //$obj_proceso_admision->fecha = date('Y-m-d H:i:s');
                    
                    $id_inserted_record = $this->obj_pam->insert_record($obj_proceso_admision);

                    if($id_inserted_record>0)
                    {
                        $_SESSION["id_proceso_admision"] = $id_inserted_record;
                        $this->page_redirect("view/02_configuracion_areas.php");
                    }else{
                        echo "Somthing is wrong..., try again.";
                    }
                }
                else 
                {
                    $this->page_redirect("view/01_inicio.php");
                }
            }catch (Exception $e) 
            {
                //$this->close_db();
                $this->objsm->close_db();
                throw $e;
            }
        }

        public function add_area()
        {
            try{
                $obj_area = new Area();

                if (isset($_POST['btn_add_area']) and trim($_POST['nombre_area']) != "")
                {
                    $nombre_area = trim($_POST['nombre_area']);

                    // verificar que no exista un area con el NOMBRE ingresado que tenga un scope global (-1) o con un scope igual al id del proceso de admision creado
                    $areas_scope_global = $this->get_areas_by_scope(-1);
                    $areas_scope_pa = $this->get_areas_by_scope($_SESSION["id_proceso_admision"]);

                    $nombre_areas = [];

                    while($row = mysqli_fetch_array($areas_scope_global))
                    {
                        $nombre_areas[] = $row[1];
                    }
                    while($row = mysqli_fetch_array($areas_scope_pa))
                    {
                        $nombre_areas[] = $row[1];
                    }

                    if (!in_array($nombre_area, $nombre_areas)) 
                    {
                        $obj_area->nombre = $nombre_area;
                        $obj_area->participa = true;
                        $obj_area->creador = $_SESSION['id_usuario'];
                        
                        $scope = "";
                        if (isset($_POST['scope']) and $_POST['scope'] == 1) 
                        {
                            $scope = -1; // scope general
                        }
                        else
                        {
                            $scope = $_SESSION["id_proceso_admision"];
                        }
                        $obj_area->scope = $scope;
                        
                        $id_inserted_record = $this->obj_am->insert_record($obj_area);

                        if($id_inserted_record > 0)
                        {
                            $this->page_redirect("view/02_configuracion_areas.php");
                        }
                        else
                        {
                            echo "Somthing is wrong..., try again.";
                        }
                    }
                    else 
                    {
                        echo "El nombre del area ingresado ya existe";
                    }
                }
                else 
                {
                    $this->page_redirect("view/02_configuracion_areas.php");
                }
            }catch (Exception $e) 
            {
                throw $e;
            }
        }

        public function guardar_config_areas()
        {
            try
            {
                $obj_pa_area = new PA_area();

                if (isset($_POST['btn_guardar_config_areas']) and isset($_POST["areas_seleccionadas"])) 
                {
                    $id_areas_seleccionadas = $_POST["areas_seleccionadas"];

                    print_r($id_areas_seleccionadas);

                    $obj_pa_area->id_proceso_admision = $_SESSION["id_proceso_admision"];
                    $obj_pa_area->creador = $_SESSION['id_usuario'];


                    foreach($id_areas_seleccionadas as $id_area_seleccionada)
                    {
                        $obj_pa_area->id_area = $id_area_seleccionada;
                        $this->obj_paam->insert_record($obj_pa_area);
                    }

                    $this->obj_pam->update_status_areas_configuradas($_SESSION["id_proceso_admision"], true);

                    $this->page_redirect("view/03_proceso_admision.php"); // successfull
                }
                else 
                {
                    $this->page_redirect("view/02_configuracion_areas.php");
                }
            }
            catch (Exception $e) 
            {
                throw $e;
            }
        }

        public function guardar_config_materias()
        {
            try{
                $obj_pa_area_materia = new PA_area_materia();

                if (isset($_POST['btn_guardar_config_materias']) and isset($_POST["materias_seleccionadas"]))
                {
                    $id_materias_seleccionadas = $_POST["materias_seleccionadas"];

                    $obj_pa_area_materia->id_proceso_admision = $_SESSION["id_proceso_admision"];
                    $obj_pa_area_materia->id_area = $_SESSION["id_area"];
                    $obj_pa_area_materia->creador = $_SESSION['id_usuario'];

                    foreach($id_materias_seleccionadas as $id_materia_seleccionada)
                    {
                        $obj_pa_area_materia->id_materia = $id_materia_seleccionada;
                        
                        $row_area_materia = $this->get_records_from_areas_materias($_SESSION["id_area"], $id_materia_seleccionada, 0)[0];

                        $obj_pa_area_materia->n_orden = $row_area_materia[11];
                        $obj_pa_area_materia->n_preguntas = $row_area_materia[12];
                        $obj_pa_area_materia->puntaje_pregunta = $row_area_materia[13];

                        // aqui ya se puede resetear los valores de la tabla "areas_materias" para esta area y materia especifica (optional)

                        $this->obj_paamm->insert_record($obj_pa_area_materia);
                    }

                    // cambiar el valor de pa_areas.materias_configuradas a true para proseguir con la siguiente etapa (preguntas y respuestas)
                    $this->obj_paam->update_status_materias_configuradas($_SESSION["id_proceso_admision"], $_SESSION["id_area"], true);

                    // ============================================
                    // Crear la cantidad de preguntas (y sus respectivas respuestas) para el actual pa_areas_materias
                    
                    // 1. crear las preguntas segun el orden de pa_areas_materias.n_orden
                    // 2. crear la cantidad de preguntas segun pa_areas_materias.n_preguntas
                    // 3. cada pregunta tendra 5 alternativas

                    $pa_areas_materias = $this->get_records_from_pa_areas_materias($_SESSION["id_proceso_admision"], $_SESSION["id_area"], 0);

                    foreach($pa_areas_materias AS $pa_area_materia)
                    {
                        $id_materia = $pa_area_materia[2];
                        $n_preguntas = $pa_area_materia[4];
                        
                        $obj_pregunta = new Pregunta();

                        // creando las preguntas
                        $obj_pregunta->id_proceso_admision = $_SESSION["id_proceso_admision"];
                        $obj_pregunta->id_area = $_SESSION["id_area"];
                        $obj_pregunta->creador = $_SESSION['id_usuario'];

                        $n_pregunta = 1;
                        while ($n_pregunta <= $n_preguntas) 
                        {   
                            $obj_pregunta->n_orden = $n_pregunta;
                            $obj_pregunta->id_materia = $id_materia;

                            $id_inserted_record = $this->obj_pm->insert_record($obj_pregunta);

                            // creando las alternativas
                            
                            $obj_alternativa = new Alternativa();
                            $obj_alternativa->id_pregunta = $id_inserted_record;
                            $obj_alternativa->creador = $_SESSION['id_usuario'];
                            
                            $n_alternativa = 1;
                            while ($n_alternativa <= 5)
                            {
                                if ($n_alternativa == 1) // se marcara la primera alternativa como la respuesta (no influye mucho pero es importante tener una alternativa como respuesta)
                                {
                                    $obj_alternativa->respuesta = true;
                                }
                                else 
                                {
                                    $obj_alternativa->respuesta = false;
                                }

                                $this->obj_alternativa_m->insert_record($obj_alternativa);

                                $n_alternativa = $n_alternativa + 1;
                            }

                            $n_pregunta = $n_pregunta + 1;
                        }
                    }

                    $this->page_redirect("view/04_elaborar_examen.php");
                }
                else 
                {
                    $this->page_redirect("view/04_elaborar_examen.php");
                }
            }
            catch (Exception $e) 
            {
                throw $e;
            }
        }

        public function guardar_preguntas()
        {
            try{

                if (isset($_POST['btn_guardar_preguntas']))
                {
                    $this->obj_paamm->update_status_preguntas_guardadas($_SESSION["id_proceso_admision"], $_SESSION["id_area"], $_SESSION["id_materia"], true);
                    
                    $this->page_redirect("view/04_elaborar_examen.php");
                }
                else 
                {
                    $this->page_redirect("view/04_elaborar_examen.php");
                }
            }
            catch (Exception $e) 
            {
                throw $e;
            }
        }

        public function update_pregunta_alternativas()
        {
            try
            {
                if (isset($_POST['btn_update_pregunta_alternativas']))
                {
                    $pregunta = $_POST['pregunta'];

                    // actualizando el contenido de la pregunta
                    $this->obj_pm->update_contenido_pregunta($_POST["id_pregunta"], $pregunta);

                    $id_alternativa_respuesta = $_POST['respuesta'];
                    
                    // actualizando el contenido de las alternativas (tambien el estado de la espuesta correcta)
                    $alternativas = $this->get_records_from_alternativas_by_pregunta($_POST["id_pregunta"]);
                    foreach($alternativas as $alternativa)
                    {
                        $id_alternativa = $alternativa[0];

                        if ($id_alternativa == $id_alternativa_respuesta)
                        {
                            $this->obj_alternativa_m->update_status_respuesta($id_alternativa, true);
                        }
                        else 
                        {
                            $this->obj_alternativa_m->update_status_respuesta($id_alternativa, false);
                        }
                        
                        $this->obj_alternativa_m->update_contenido_alternativa($alternativa[0], $_POST["alternativa_".$alternativa[0]]);
                    }
                    
                    //echo "*** SUCCESSFUL XD ***";
                    $this->page_redirect("view/04_elaborar_examen.php");
                }
                else 
                {
                    $this->page_redirect("view/04_elaborar_examen.php");
                }
            }
            catch (Exception $e) 
            {
                throw $e;
            }
        }

        public function add_examenes()
        {
            try{
                $obj_examen = new Examen();
                $obj_examen_pregunta = new Examen_pregunta();

                if (isset($_POST['btn_add_examenes']))
                {
                    // 1. con un bucle crear la cantidad n de examenes
                    // 2. conocer cuales son las preguntas que corresponde a un proceso de admision y area especficamente
                    // 3. para cada examen crea un registro en examenes_preguntas, para enlazar las preguntas con los examenes

                    $n_tipos_examenes = $_POST['n_tipos_examenes'];
                    $id_area = $_POST['id_area'];

                    $obj_examen->id_proceso_admision = $_SESSION["id_proceso_admision"];
                    $obj_examen->id_area = $id_area;
                    $obj_examen->creador = $_SESSION['id_usuario'];

                    $obj_examen_pregunta->id_proceso_admision = $_SESSION["id_proceso_admision"];
                    $obj_examen_pregunta->id_area = $id_area;
                    $obj_examen_pregunta->creador = $_SESSION['id_usuario'];

                    $preguntas = $this->get_records_from_preguntas_by_pa_area_materia($_SESSION["id_proceso_admision"], $id_area, 0);

                    $tipos_examen = ["P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y"];
                    $letras_alternativas = ["a", "b", "c", "d", "e"];

                    $i = 0;
                    while($i < $n_tipos_examenes)
                    {
                        $obj_examen->tipo_examen = $tipos_examen[$i];

                        $obj_examen_pregunta->tipo_examen = $tipos_examen[$i];

                        $this->obj_em->insert_record($obj_examen);

                        // enlazar examen con preguntas
                        $n_orden_general = 1; // el orden final de todas las preguntas del examen de un area
                        foreach($preguntas as $pregunta)
                        {
                            $obj_examen_pregunta->id_pregunta = $pregunta[0];
                            $obj_examen_pregunta->n_orden_general = $n_orden_general;
                            // obtener la letra respuesta de una pregunta por id
                            if($i == 0) // solo el primer examen tendra como alternativa respuesta la que eligio, para los otros examenes esto sera aleatorio
                            {
                                $obj_examen_pregunta->letra_respuesta = $this->get_letra_respuesta_from_pregunta($pregunta[0]);
                            }
                            else {
                                $obj_examen_pregunta->letra_respuesta = $letras_alternativas[rand(0,4)];
                            }

                            $this->obj_epm->insert_record($obj_examen_pregunta);

                            $n_orden_general = $n_orden_general + 1;
                        }

                        $i = $i + 1;
                    }

                    // actualizar estado pa_areas.examenes_generados a TRUE
                    $this->obj_paam->update_status_examenes_generados($_SESSION["id_proceso_admision"], $id_area, true);
                    
                    $this->page_redirect("view/05_exportar_examenes.php");
                }
                else 
                {
                    $this->page_redirect("view/04_elaborar_examen.php");
                }
            }catch (Exception $e) 
            {
                throw $e;
            }
        }

        public function get_letra_respuesta_from_pregunta($id_pregunta)
        {
            $result = $this->obj_alternativa_m->get_records_by_pregunta($id_pregunta);
            
            $letras_alternativas = ["a", "b", "c", "d", "e"];

            $letra_respuesta = "";
            $i = 0;
            while($row = mysqli_fetch_array($result))
            {
                $respuesta = $row[2];
                if ($respuesta == true)
                {
                    $letra_respuesta = $letras_alternativas[$i];
                    break;
                }

                $i = $i + 1;
            }

            return $letra_respuesta;
        }

        public function add_materia()
        {
            try{
                $obj_materia = new Materia();
                $obj_area_materia = new Area_materia();

                if (isset($_POST['btn_add_materia']) and trim($_POST['nombre_materia']) != "")
                {
                    $nombre_materia = trim($_POST['nombre_materia']);

                    // verificar que no exista un area con el NOMBRE ingresado que tenga un scope global (-1) o con un scope igual al id del proceso de admision creado DENTRO de este area
                    $materias_scope_global = $this->obj_amm->get_records($_SESSION['id_area'], 0, -1);
                    $materias_scope_pa = $this->obj_amm->get_records($_SESSION['id_area'], 0, $_SESSION["id_proceso_admision"]);

                    $nombre_materias = [];

                    while($row = mysqli_fetch_array($materias_scope_global))
                    {
                        $nombre_materias[] = $row[7];
                    }
                    while($row = mysqli_fetch_array($materias_scope_pa))
                    {
                        $nombre_materias[] = $row[7];
                    }

                    if (!in_array($nombre_materia, $nombre_materias)) 
                    {
                        $obj_materia->nombre = $nombre_materia;
                        $obj_materia->creador = $_SESSION['id_usuario'];
                        
                        $scope = "";
                        if (isset($_POST['scope']) and $_POST['scope'] == 1) 
                        {
                            $scope = -1; // scope general
                        }
                        else
                        {
                            $scope = $_SESSION["id_proceso_admision"];
                        }
                        $obj_materia->scope = $scope;
                        
                        $id_inserted_record = $this->obj_mm->insert_record($obj_materia);

                        if($id_inserted_record > 0)
                        {
                            // insertar materia creada a "areas_materias" 

                            $obj_area_materia->id_area = $_SESSION['id_area'];
                            $obj_area_materia->id_materia = $id_inserted_record;
                            $obj_area_materia->n_orden = $_POST['n_orden'];
                            $obj_area_materia->n_preguntas = $_POST['n_preguntas'];
                            echo "-> puntaje pregunta: ".$_POST['puntaje_pregunta'];
                            $obj_area_materia->puntaje_pregunta = $_POST['puntaje_pregunta'];
                            echo "<br>-> puntaje pregunta: ".$obj_area_materia->puntaje_pregunta;
                            $obj_area_materia->participa = true;
                            $obj_area_materia->creador = $_SESSION['id_usuario'];

                            echo "<br>".$obj_area_materia->n_preguntas." *** ".$_POST['n_preguntas']."<br>";

                            $id_inserted_record = $this->obj_amm->insert_record($obj_area_materia);

                            $this->page_redirect("view/04_elaborar_examen.php");
                        }
                        else
                        {
                            echo "Somthing is wrong..., try again.";
                        }
                    }
                    else 
                    {
                        // El nombre del area ingresado ya existe
                        $this->page_redirect("view/04_elaborar_examen.php");
                    }
                }
                else 
                {
                    // no se ingreso nada en el nombre
                    $this->page_redirect("view/04_elaborar_examen.php");
                }
            }catch (Exception $e) 
            {
                throw $e;
            }
        }

        public function get_records_from_procesos_admision($id_proceso_admision)
        {
            $result = $this->obj_pam->get_records($id_proceso_admision);
            
            $procesos_admision = [];

            while($row = mysqli_fetch_array($result))
            {
                $procesos_admision[] = $row;
            }

            return $procesos_admision;
        }

        public function get_records_from_pa_areas($id_proceso_admision, $id_area)
        {
            $result = $this->obj_paam->get_records($id_proceso_admision, $id_area);
            
            $pa_areas = [];

            while ($row = $result->fetch_array(MYSQLI_NUM))
            {
                $pa_areas[] = $row;
            }

            return $pa_areas;
        }

        public function get_records_from_usuarios($id_usuario)
        {
            $result = $this->obj_um->get_records($id_usuario);
            
            $usuarios = [];

            while ($row = $result->fetch_array(MYSQLI_NUM))
            {
                $usuarios[] = $row;
            }

            return $usuarios;
        }

        public function get_records_from_areas_materias($id_area, $id_materia, $scope_materia)
        {
            $result = $this->obj_amm->get_records($id_area, $id_materia, $scope_materia);
            
            $areas_materias = [];

            while ($row = $result->fetch_array(MYSQLI_NUM))
            {
                $areas_materias[] = $row;
            }

            return $areas_materias;
        }

        public function get_records_from_pa_areas_materias($id_proceso_admision, $id_area, $id_materia)
        {
            $result = $this->obj_paamm->get_records($id_proceso_admision, $id_area, $id_materia);
            
            $pa_areas_materias = [];

            while ($row = $result->fetch_array(MYSQLI_NUM))
            {
                $pa_areas_materias[] = $row;
            }

            return $pa_areas_materias;
        }

        public function get_records_from_preguntas($id_pregunta)
        {
            $result = $this->obj_pm->get_records($id_pregunta);
            
            $preguntas = [];

            while ($row = $result->fetch_array(MYSQLI_NUM))
            {
                $preguntas[] = $row;
            }

            return $preguntas;
        }

        public function get_records_from_examenes_preguntas($id_proceso_admision, $id_area, $tipo_examen, $id_materia)
        {
            $result = $this->obj_epm->get_records($id_proceso_admision, $id_area, $tipo_examen, $id_materia);
            
            $examenes_preguntas = [];

            while($row = mysqli_fetch_array($result))
            {
                $examenes_preguntas[] = $row;
            }

            return $examenes_preguntas;
        }

        public function get_records_from_preguntas_by_pa_area_materia($id_proceso_admision, $id_area, $id_materia)
        {
            $result = $this->obj_pm->get_records_by_pa_area_materia($id_proceso_admision, $id_area, $id_materia);
            
            $preguntas = [];

            while ($row = $result->fetch_array(MYSQLI_NUM))
            {
                $preguntas[] = $row;
            }

            return $preguntas;
        }

        public function get_records_from_alternativas_by_pregunta($id_pregunta)
        {
            $result = $this->obj_alternativa_m->get_records_by_pregunta($id_pregunta);
            
            $alternativas = [];

            while ($row = $result->fetch_array(MYSQLI_NUM))
            {
                $alternativas[] = $row;
            }

            return $alternativas;
        }

        public function get_area_by_id($id_area)
        {
            $result = $this->obj_am->get_records($id_area, 0); // el cero no importa (significa scope cualquiera)
            
            $result = $result->fetch_array(MYSQLI_NUM);

            return $result;
        }

        public function get_areas_by_scope($scope)
        {
            $result = $this->obj_am->get_records(0, $scope); // el cero no importa (significa id cualquiera)

            return $result;
        }

        public function get_materias_by_scope($scope)
        {
            $result = $this->obj_mm->get_records(0, $scope); // el cero no importa (significa id cualquiera)

            return $result;
        }

        public function get_records_from_examenes($id_proceso_admision, $id_area, $tipo_examen)
        {
            $result = $this->obj_em->get_records($id_proceso_admision, $id_area, $tipo_examen);
            
            $examenes = [];

            while($row = mysqli_fetch_array($result))
            {
                $examenes[] = $row;
            }

            return $examenes;
        }
    }


?>