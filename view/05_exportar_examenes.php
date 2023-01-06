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

    $pa_areas = $controller->get_records_from_pa_areas($_SESSION['id_proceso_admision'], 0); // 0: de cualquier area
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
                width: 800px;
                margin: 40px 0px;
            }

            /* CONTAINER FORM TABLE */
            .container-table{
                margin-top: 20px;
            }

            .container-table .table{
                display:table;

                width: 100%;
                font-size: 14px;
                border-top: 1px solid black;
                border-bottom: 1px solid black;
            }

            .container-table .table .tr{
                display: table-row;

                width: 100%;
            }

            .container-table .table .tr > * {
                display: table-cell;
                padding: 13px 10px;
            }

            .container-table .table .tr .th{
                background-color: #3F426A;
                color: white;
                text-align: center;
                font-weight: bold;
            }

            .container-table .table .tr .td input{
                margin: 0px !important;
                padding: 2px !important;
                border-radius: 5px;
                text-align: center;
                width: 130px;
            }

            .container-table .table .tr .field-1{
                width: 30%;
            }

            .container-table .table .tr .field-2{
                text-align: center;
                padding: 0px !important;
                width: 30%;
            }

            .container-table .table .tr .field-3{
                width: 20%;
                text-align: center;
            }

            .container-table .table .tr .field-4{
                width: 20%;
                text-align: center;
            }

            .container-table .table .tr .td.field-3
            {
                padding: 0px !important;
            }

            .container-table .table .tr .td.field-4
            {
                padding: 0px !important;
            }

            .container-table .table .tr .field-3 button{
                margin: 0px !important;
                padding: 0px 20px !important;
                border: none;
                font-size: 20px;
                color: gray;
            }

            .container-table .table .tr .field-4 a{
                margin: 0px !important;
                padding: 0px 20px !important;
                text-align: none;
                font-size: 20px;
                color: gray;
            }

            .disabled{
                pointer-events: none;
                cursor: default;
            }

            button.active{
                color: #2C2E4A !important;
            }

            a.show-exams.active{
                color: #2C2E4A !important;
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
                        <li class="step-selected"><a href="#"><i class="fa-solid fa-file-export"></i>Generar</a></li>
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

                        <div class="container-main-content align-self-center">

                            <div class="container-table">
                                <div class="table">
                                    <div class="tr">
                                        <span class="th field-1">Area</span>
                                        <span class="th field-2">Cantidad</span>
                                        <span class="th field-3">Exportar</span>
                                        <span class="th field-4">Visualizar</span>
                                    </div>

                                    <?php
                                        // obtener todas las areas del proceso de admision actual
                                        // obtener las materias para cada uno de los procesos de admision y areas
                                        // por cada area se verificara que todas sus materias tengan sus preguntas_guardadas = true
                                        // solo el area cumple la condicion se muestra el formulario

                                        $i = 1;
                                        foreach($pa_areas as $pa_area)
                                        {
                                            $id_area = $pa_area[7];
                                            $nombre_area = $pa_area[8];
                                            $examenes_generados = $pa_area[4];

                                            $pa_areas_materias = $controller->get_records_from_pa_areas_materias($_SESSION['id_proceso_admision'], $id_area, 0);
                                            
                                            $todas_areas_preguntas_guardadas = true;

                                            foreach($pa_areas_materias as $pa_areas_materias)
                                            {
                                                $materias_guardadas = $pa_areas_materias[6];

                                                if($materias_guardadas == false)
                                                {
                                                    $todas_areas_preguntas_guardadas = false;
                                                    break;
                                                }
                                            }
                                            
                                            if ($i%2 == 0) {
                                                echo '<form class="tr even-row" action="../index.php?act=add_examenes" method="POST">';
                                            }
                                            else
                                            {
                                                echo '<form class="tr" action="../index.php?act=add_examenes" method="POST">';
                                            }

                                                echo '
                                                    <span class="td field-1">'.$nombre_area.'</span>
                                                    <span class="td field-2"><input type="number" min="1" max="10" name="n_tipos_examenes" id="n_tipos_examenes"></span>

                                                    <input type="hidden" name="id_area" value="'.$id_area.'">';

                                                    if($todas_areas_preguntas_guardadas and !empty($pa_areas_materias))
                                                    {
                                                        echo '<span class="td field-3"><button class="active" type="submit" name="btn_add_examenes"><i class="fa-solid fa-cloud-arrow-down"></i></button> </span>';
                                                    }
                                                    else
                                                    {
                                                        echo '<span class="td field-3"><button class="" type="button" name="btn_add_examenes disabled"><i class="fa-solid fa-cloud-arrow-down"></i></button> </span>';
                                                    }

                                                    if($examenes_generados)
                                                    {
                                                        echo '<span class="td field-4"><a class="show-exams active" href="06_visualizar_examen.php?id_area='.$id_area.'"><i class="fa-solid fa-eye"></i></a> </span>';
                                                    }
                                                    else {
                                                        echo '<span class="td field-4"><a class="show-exams disabled" href="#"><i class="fa-solid fa-eye"></i></a> </span>';
                                                    }

                                            echo '</form>';

                                            $i++;
                                        }
                                    ?>
                                </div>
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