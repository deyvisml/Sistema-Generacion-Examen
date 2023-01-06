<?php
    // Turn off all error reporting
    error_reporting(0);

    require_once  '../controller/controller.php';

    if (!isset($_SESSION['id_usuario'])) 
    {
        header('Location: 00_login.php');
        die();
    }

    if(isset($_GET['pa']))
    {
        $_SESSION['id_proceso_admision'] = $_GET['pa'];
    }
    elseif (!isset($_SESSION['id_proceso_admision'])) 
    {
        header('Location: 01_inicio.php');
    }

    $controller = new controller();

    $usuario = $controller->get_records_from_usuarios($_SESSION['id_usuario'])[0];
    $nombre_usuario = $usuario[3]." ".$usuario[4];

    //------------
    $proceso_admision = $controller->get_records_from_procesos_admision($_SESSION["id_proceso_admision"])[0];

    //print_r($proceso_admision);

    $nombre_proceso_admision = $proceso_admision[1];
    $areas_configuradas = $proceso_admision[2];

    if($areas_configuradas)
    {
        echo "redireccionar a la siguiente etapa xd";
        header('Location: 03_proceso_admision.php');
    }
    else 
    {
        $areas_scope_global = $controller->get_areas_by_scope(-1);
        $areas_scope_pa = $controller->get_areas_by_scope($proceso_admision[0]);

        //print_r($areas_scope_global);
    }
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
                height: 100vh;
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

            section .container-main-content .name-pa-btn-area
            {
                margin: 0px !important;
                padding: 0px !important;
            }

            section .name-pa-btn-area .name-pa{
                margin: 0px !important;
                padding: 0px !important;
                display: block;
                text-align: center;
                background-color: #F4F3F8;
                font-weight: bold;
                margin-right: 15px !important;
                line-height: 35px;
            }

            section .name-pa-btn-area .btn-agregar-area{
                background-color: #2E6AA0;
                color: white;
            }

            section .name-pa-btn-area .btn-agregar-area:hover{
                color: white;
            }

            section .name-pa-btn-area .btn_create_area
            {
                background-color: #2E6AA0;
                color: white;
            }

            section .name-pa-btn-area form label[for="nombre_area"]{
                font-weight: bold;
                margin: 15px 0px !important;
            }


            /* CONTAINER FORM TABLE */
            .container-form-table{
                margin-top: 20px;
            }

            .container-form-table form table{
                width: 100%;
                font-size: 14px;
                border-top: 1px solid black;
                border-bottom: 1px solid black;
            }

            .container-form-table form table tr th{
                background-color: #3F426A;
                color: white;
                text-align: center;
            }

            .container-form-table form table tr > * {
                padding: 13px 10px;
            }

            .container-form-table form table tr .field-1{
                width: 80%;
            }

            .container-form-table form table tr .field-2{
               text-align: center;
            }

            .container-form-table form table tr td.field-2
            {
                transform: scale(1.5);
            }

            .even-row{
                
                background-color: #eee;
            }

            .container-form-table form input[type="submit"]
            {
                float: right; 
                clear: both;
                background-color: #2E6AA0;
                color: white;
                padding: 5px 25px;
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
                        <li class="step-selected"><a href="#"><i class="fa-solid fa-layer-group"></i>Areas</a></li>
                        <li class=""><a href="#"><i class="fas fa-book"></i>Materias</a></li>
                        <li class=""><a href="#"><i class="fas fa-question-circle"></i>Preguntas</a></li>
                        <li class=""><a href="#"><i class="fa-solid fa-file-export"></i>Generar</a></li>
                    </ul>
                </aside>

                <div class="col main">
                    <header class="d-flex justify-content-between align-items-center">

                        <div class="container-btn-home">
                            <a href=""><i class="fas fa-home"></i></a>
                        </div>

                        <div class="container-data-user d-flex justify-content-end align-items-center">
                            <a class="container-leave-icon" href="#"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>

                            <p class="name-user">
                                <?php echo $nombre_usuario; ?>
                            </p>
                            <div class="container-icon-user d-flex justify-content-center align-items-center">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                    </header>

                    <section class="d-flex flex-column">
                        <h3>Configuración de Areas</h3>

                        <hr>

                        <div class="container-main-content align-self-center">
                            <div class="row name-pa-btn-area">
                                <p class="col name-pa"><?php echo $nombre_proceso_admision; ?></p>

                                <!-- Button trigger modal -->
                                <button type="button" class="btn-agregar-area col-auto btn btn-new-pa align-self-end" data-bs-toggle="modal" data-bs-target="#modal-container-form">
                                    Agregar area
                                </button>

                                <!-- Modal btn: nuevo proceso de admisión -->
                                <div class="modal fade" id="modal-container-form" tabindex="-1" role="dialog" aria-labelledby="modal-container-form" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">

                                            <form action="../index.php?act=add_area" method="POST">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Nueva area</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <label for="nombre_area">Nombre area: </label>
                                                    <input type="text" name="nombre_area" id="nombre_area"> <br/>

                                                    <input type="checkbox" name="scope" value="1" id="scope">
                                                    <label for="scope">Mantener area</label> <br/>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn_create_area" name="btn_add_area" data-bs-dismiss="modal">Crear</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="container-form-table">
                                <form action="../index.php?act=guardar_config_areas" method="POST">
                                    <table col="3">
                                        <thead>
                                            <tr>
                                                <th class="field-1">Nombre</th>
                                                <th class="field-2">Participa</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                                $i = 1;
                                                // Lista de todas las areas con scope global (-1) o con scope igual al id del algual proceso de admision, y las que tengan el valor de participa en true ya se muestran seleccionadas)
                                                while($row = mysqli_fetch_array($areas_scope_global))
                                                {
                                                    if($i%2 == 0)
                                                    {
                                                        echo '<tr class="even-row">';
                                                    }
                                                    else {
                                                        echo '<tr>';
                                                    }
                                                    echo'
                                                            <td class="field-1">'.$row[1].'</td>
                                                            <td class="field-2"><input type="checkbox" name="areas_seleccionadas[]" value="'.$row[0].'" id="" ';
                                                            if($row[3]==true)
                                                                echo "checked";
                                                    echo '></td>
                                                        </tr>';

                                                    $i++;
                                                }

                                                while($row = mysqli_fetch_array($areas_scope_pa))
                                                {
                                                    if($i%2 == 0)
                                                    {
                                                        echo '<tr class="even-row">';
                                                    }
                                                    else {
                                                        echo '<tr>';
                                                    }
                                                    echo'
                                                            <td class="field-1">'.$row[1].'</td>
                                                            <td class="field-2"><input type="checkbox" name="areas_seleccionadas[]" value="'.$row[0].'" id="" ';
                                                            if($row[3]==true)
                                                                echo "checked";
                                                    echo '></td>
                                                        </tr>';
                                                    
                                                    $i++;
                                                }
                                            ?>
                                            
                                        </tbody>
                                    </table> <br/>
                                    
                                    <input type="submit" value="Continuar" name="btn_guardar_config_areas" class="btn">
                                </form>
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