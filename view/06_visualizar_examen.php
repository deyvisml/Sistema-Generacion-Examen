<?php
    // Turn off all error reporting
    error_reporting(0);

    require_once  '../controller/controller.php';

    if (!isset($_SESSION['id_usuario'])) 
    {
        header('Location: 00_login.php');
        die();
    }

    $controller = new controller();

    $usuario = $controller->get_records_from_usuarios($_SESSION['id_usuario'])[0];
    $nombre_usuario = $usuario[3]." ".$usuario[4];

    
    /// ---------- establecer area ---------- 

    if(isset($_GET['id_area']))
    {
        $_SESSION['id_area'] = $_GET['id_area'];
    }
    elseif (!isset($_SESSION['id_area'])) 
    {
        $temp = $controller->get_records_from_pa_areas($_SESSION['id_proceso_admision'], 0); // 0: de cualquier area
        $_SESSION['id_area'] = $temp[0][1]; // se seleciona por defecto al primer area
    }

    /// ---------- establecer tipo_examen ---------- 

    $examenes = $controller->get_records_from_examenes($_SESSION['id_proceso_admision'], $_SESSION['id_area'], ""); // "": de cualquier tipo de examen

    if(isset($_GET['tipo_examen']))
    {
        $_SESSION['tipo_examen'] = $_GET['tipo_examen'];
    }
    else
    {
        $_SESSION['tipo_examen'] = $examenes[0][2]; // se seleciona por defecto al tipo de examen
    }

    // -------------------------------------

    $pa_area = $controller->get_records_from_pa_areas($_SESSION['id_proceso_admision'], $_SESSION['id_area'])[0];
?>



<!doctype html>
<html lang="es">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <!-- Font awesome -->
        <script src="https://kit.fontawesome.com/ac9c34bb46.js" crossorigin="anonymous"></script>

        <title>02. Configuracion areas</title>

        <style>
            .container-fluid{
                font-family: 'Roboto', sans-serif;
                background-color: #eee;
            }

            .main-container{
                border: 1px solid black;
                min-height: 100vh;
            }

            /* ASIDE */
            aside{
                background-color: #2C2E4A;
                color: white;
                margin: 0px !important;
                padding: 0px !important;
            }

            aside .logo-container{
                height: 80px;
                margin: 30px 0px 30px;
            }

            .logo-container img{
                height: 80px;
            }

            ul.steps-container{
                width: 100%;
                list-style: none;
                font-size: 14px;
                padding: 0px !important;
            }
            
            ul.steps-container *{
                color: #ccc;
            }

            .step-selected{
                background-color: #3F426A;
            }

            .step-selected *{
                color: #fff !important;
            }

            ul.steps-container li a{
                padding: 20px 10px !important;
                display: block;
                text-decoration: none;
                color: #fff;
            }

            ul.steps-container li:hover{
                background-color: #3F426A;
            }

            ul.steps-container li:hover *{
                color: white;
            }

            ul.steps-container li a i{
                width: 20px;
                margin: 0px 15px 0px 3px !important;
                font-size: 20px;
            }
            

            /* HEADER */
            .main-container .main{
                margin: 0px !important;
                padding: 0px !important;
            }

            header{
                background-color: white;
                height: 90px;
                border-bottom: 3px solid #ccc;
                margin: 0px !important;
                padding: 0px !important;
            }

            header .container-btn-home{
                font-size: 30px;
                margin-left: 30px !important;
            }

            header .container-btn-home *{
                color: #2C2E4A;
            }

            header .container-data-user{
                margin-right: 30px !important;
            }
            
            header .container-data-user > *{
                display: block;
                margin: 0px !important;
                padding: 0px !important;
            }

            header .container-data-user .name-user{
                color: #3F426A;
                font-weight: bold;
                font-size: 13px;
                padding-left: 10px !important;
            }

            header .container-data-user .container-icon-user{
                width: 50px;
                height: 50px;
                border-radius: 50%;
                border: 1px solid #ccc;
                background-color: #3F426A;
                color: white;
                margin-left: 10px !important;
                font-size: 20px;
                text-align: center;
            }
            
            header .container-leave-icon{
                color: #3F426A;
                font-size: 20px;
                padding: 0px 10px !important;
                border-right: 1px solid #3F426A;
            }

            /* SECTION */

            section{
                margin: 30px !important;
                padding: 30px !important;
                background-color: white;
            }

            section h3{
                font-size: 22px;
            }

            section .container-main-content{
                margin: 40px 80px;
            }


            .container-tipos-examenes{
                list-style: none;
                margin: 0px !important;
                padding: 0px !important;
            }

            .container-tipos-examenes li{
                margin: 15px 0px;
                width: 120px !important;
            }

            .container-tipos-examenes li a{
                font-weight: bold;
                text-decoration: none;
                color: white;
                background-color: #3F426A;
                display: block;
                padding: 10px 0px;
                text-align: center;
                border-radius: 5px;
            }

            .container-preguntas-alternativas{
                margin: 0px !important;
                padding: 0px !important;
            }

            .container-preguntas-alternativas .pregunta-alternativa{
                padding: 0px !important;
                margin: 0px !important;
                margin-top: 15px !important;
                margin-bottom: 15px !important;
            }

            .pregunta-alternativa .container-pregunta{
                padding: 10px !important;
                background-color: #F4F3F8;
            }

            .container-pregunta .titulo-pregunta{
                font-weight: bold;
            }

            ol.container-alternativa{
                list-style-position: inside !important;
                background-color: #F4F3F8;
                border-left: 15px solid white;
                padding: 0px !important;
                margin: 0px !important;
            }

            ol.container-alternativa li{

                padding: 8px !important;
            }

            .nombre-area{
                display: block;
                padding: 10px;
                margin-bottom: 30px;
                font-weight: bold;
                background-color: #eee;
                text-align: center;
            }

            .nombre-materia{
                display: block;
                width: 100% !important;
                padding: 8px 0px !important;
                margin: 20px 0px 0px !important;
                font-weight: bold;
                border: 2px dashed gray;
                text-align: center;
            }

            .selected-exam{
                background-color: #2E6AA0 !important;
            }

            .correct-answer
            {
                background-color: #fff3b0 !important;
            }

            .even-row{
                
                background-color: #eee !important;
            }

        </style>
    </head>

    <body>

        <div class="container-fluid">
            <div class="row main-container">
                <aside class="col-2 aside d-flex flex-column align-items-center">
                    <div class="logo-container">
                        <img src="../resources/images/logo-una3.png" alt="logo una">
                    </div>

                    <ul class="steps-container">
                        <li class=""><a href="#"><i class="fa-solid fa-layer-group"></i>Areas</a></li>
                        <li class=""><a href="04_elaborar_examen.php"><i class="fas fa-book"></i>Materias</a></li>
                        <li class=""><a href="04_elaborar_examen.php"><i class="fas fa-question-circle"></i>Preguntas</a></li>
                        <li class=""><a href="05_exportar_examenes.php"><i class="fa-solid fa-file-export"></i>Generar</a></li>
                        <li class="step-selected"><a href="#"><i class="fa-solid fa-eye"></i>Visualizar</a></li>
                    </ul>
                </aside>

                <div class="col main">
                    <header class="d-flex justify-content-between align-items-center">

                        <div class="container-btn-home">
                            <a href="03_proceso_admision.php"><i class="fas fa-home"></i></a>
                        </div>

                        <div class="container-data-user d-flex justify-content-end align-items-center">
                            <a class="container-leave-icon" href="00_login.php"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>

                            <p class="name-user">
                                <?php echo $nombre_usuario; ?>
                            </p>
                            <div class="container-icon-user d-flex justify-content-center align-items-center">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                    </header>

                    <section class="d-flex flex-column">
                        <h3>Tipos de examenes</h3>

                        <hr>

                        <div class="row container-main-content d-flex justify-content-center align-items-center">

                            <p class="row nombre-area"><?php echo $pa_area[8]; ?></p>

                            <ul class="col-2 container-tipos-examenes align-self-start d-flex flex-column align-items-start ">
                                
                                <?php
                                    // 0. Listar los tipos de examenes para esta area y proceso de admision
                                    // 1. Obtener las materias por el area y proceso de admision
                                    // 2. Obtener las preguntas por la materia
                                    // 3. Obtener las alternativas por la pregunta (acomodar la respuesta en la letra correcta de alternativa)
                                    
                                    foreach($examenes as $examen)
                                    {
                                        $nombre_tipo = $examen[2];

                                        if($nombre_tipo == $_SESSION['tipo_examen'])
                                        {
                                            echo '<li>
                                                    <a class="selected-exam" href="06_visualizar_examen.php?tipo_examen='.$nombre_tipo.'">'.$nombre_tipo.'</a>
                                                </li>';
                                        }
                                        else {
                                            echo '<li>
                                                    <a href="06_visualizar_examen.php?tipo_examen='.$nombre_tipo.'">'.$nombre_tipo.'</a>
                                                </li>';
                                        }
                                    }
                                ?>
                            </ul>
                            <div class="col-10 container-preguntas-alternativas">
                                
                                <?php
                                    $materias = $controller->get_records_from_pa_areas_materias($_SESSION['id_proceso_admision'], $_SESSION['id_area'], 0);

                                    foreach($materias as $materia)
                                    {
                                        $id_materia = $materia[16];
                                        $nombre_materia = $materia[17];

                                        echo '<p class="nombre-materia">Materia: '.$nombre_materia.'</p>';
                                        
                                        // mostrando preguntas
                                        $examenes_preguntas = $controller->get_records_from_examenes_preguntas($_SESSION['id_proceso_admision'], $_SESSION['id_area'], $_SESSION['tipo_examen'], $id_materia);
                                        $n_orden_general = $examenes_preguntas[0][4];

                                        foreach($examenes_preguntas as $examen_pregunta)
                                        {
                                            $id_pregunta = $examen_pregunta[3];
                                            $n_orden_general = $examen_pregunta[4];
                                            $letra_respuesta = $examen_pregunta[5];
                                            $pregunta = $examen_pregunta[9];
                                            
                                            echo '<div class="row pregunta-alternativa">';

                                            echo '<div class="col-8 container-pregunta">
                                                    <p class="titulo-pregunta">
                                                        Pregunta '.$n_orden_general.':
                                                    </p>
                                                    <p class="contenido-pregunta">
                                                        '.$pregunta.'
                                                    </p>
                                                </div>';

                                            // mostrando alternativas

                                            $letras_numeros = ["a" => 0, "b" => 1, "c" => 2, "d" => 3, "e" => 4];
                                            

                                            $posicion_respuesta = $letras_numeros[$letra_respuesta];
                                            
                                            $alternativas_ordenado = [];
                                            $alternativas = $controller->get_records_from_alternativas_by_pregunta($id_pregunta);
                                            
                                            for ($i=0, $j=0; $j < count($alternativas); $i++, $j++) 
                                            {
                                                $alternativa = $alternativas[$j];
                                                $contenido_alternativa = $alternativa[1];
                                                $respuesta_correcta = $alternativa[2];

                                                if ($posicion_respuesta == $i) 
                                                {
                                                    if ($respuesta_correcta) {
                                                        $alternativas_ordenado[$i] = $contenido_alternativa;
                                                    }
                                                    else 
                                                    {
                                                        $j--;
                                                    }
                                                }
                                                elseif ($respuesta_correcta) 
                                                {
                                                    $alternativas_ordenado[$posicion_respuesta] = $contenido_alternativa;
                                                    $i--;
                                                }
                                                else 
                                                {
                                                    $alternativas_ordenado[$i] = $contenido_alternativa;
                                                }
                                            }

                                            echo '<ol type="a" class="col-4 container-alternativa">';
                                            for ($i=0; $i < count($alternativas_ordenado); $i++) { 
                                                if($i == $posicion_respuesta)
                                                {
                                                    echo '<li class=correct-answer>'.$alternativas_ordenado[$i].'</li>';
                                                }
                                                else {
                                                    echo '<li>'.$alternativas_ordenado[$i].'</li>';
                                                }
                                            }
                                            echo '</ol>';

                                            echo '</div>';
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>