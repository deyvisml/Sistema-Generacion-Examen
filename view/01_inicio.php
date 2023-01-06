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


    $procesos_admision = $controller->get_records_from_procesos_admision(0); // 0: todos los procesos de admision

    $_SESSION['id_proceso_admision'] = null;
    $_SESSION['id_area'] = null;
    $_SESSION['id_materia'] = null;
?>

<!doctype html>
<html lang="es">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,800" rel="stylesheet">

        <!-- Font awesome -->
        <script src="https://kit.fontawesome.com/ac9c34bb46.js" crossorigin="anonymous"></script> 

        <title>01. PROCESOS DE ADMISION</title>

        <style>
            
            .main-container
            {
                height: 100vh;
                font-family: 'Roboto', sans-serif;
                padding: 0px !important;
                margin: 0px !important;
                background-color: #F1F1F1;
            }
            
            .container-header
            {
                padding: 0px !important;
                margin: 0px !important;
                height: 90px;
                background-color: #fff;
                border-bottom: 2px solid #ccc;
            }
            
            .header-content .logo-container img
            {
                height: 70px;
            }
            
            .header-content .user-container > *
            {
                display: block;
                margin: 0px !important;
                padding: 0px !important;
            }
            .header-content .user-container .name-user
            {
                font-size: 15px;
                margin-left: 7px !important;
            }

            .header-content .user-container .icon-user{
                border-radius: 50%;
                background-color: #3F426A;
                color:#fff;
                width: 50px;
                height: 50px;
                font-size: 25px;
                margin-left: 10px !important;
            }
            
            .header-content .user-container .leave-icon
            {
                text-decoration: none;
                font-size: 25px;
                color: #3F426A;
                padding-right: 7px !important;
                border-right: 1px solid #3F426A;
            }


            .container-body
            {
                padding: 0px !important;
                margin: 50px 0px !important;
                min-height: 400px;

                background-color: white;
            }

            .body-content
            {
                height: auto;
                padding: 0px !important;
                margin: 70px 0px;
            }

            .body-content .btn-new-pa
            {
                background-color: #2E6AA0;
                color: white;
                margin: 0px 0px 30px;
                font-size: 15px;
            }

            .body-content .modal-content .modal-body > label
            {
                font-size: 15px;
                font-weight: bold;
            }

            .body-content .modal-content .modal-body > input
            {
                font-size: 15px;
            }

            .body-content .container-table table
            {
                width: 100%;
                background-color: white;
                border-bottom: 1px solid black;
            }

            .body-content .container-table table  tr{
                
                font-size: 15px;
            }

            .body-content .container-table table  tr th{
                text-align: center;
                color: white !important;
                background-color: #3F426A;
                border-top: 1px solid black;
                border-bottom: 1px solid black;
            }

            .body-content .container-table table  tr > *{
                
                padding: 10px 4px;
                background-color: white;
            }

            .body-content .container-table table  tr .field-1{
                width: 10%;
                text-align: center;
            }

            .body-content .container-table table  tr .field-3{
                width: 25%;
            }

            .body-content .container-table table  tr .field-4, .body-content .container-table table  tr .field-5{
                width: 10%;
                text-align: center;
                text-decoration: none;
                color: #3F426A;
            }

            .body-content .container-table table  tr a{
                text-decoration: none;
                color: gray !important;
            }

            .even-row{
                
                background-color: #eee;
            }

            form .btn-create-pa{
                color: #fff;
                background-color: #2E6AA0;
            }

            form .btn-create-pa:hover{
                color: #fff;
            }

            .body-content h2{
                font-size: 30px;

            }

        </style>
    </head>

    <body>

        <div class="container-fluid main-container d-flex flex-column align-items-center">

            <div class="row container-fluid container-header d-flex justify-content-center">
                <div class="col-9 header-content d-flex justify-content-between align-items-center">
                        <div class="logo-container d-flex justify-content-center align-items-center">
                            <img src="../resources/images/logo-una2.png" alt="">
                        </div>

                        <div class="user-container d-flex flex-row justify-content-end align-items-center">
                            <a class="leave-icon" href="00_login.php"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>
                            <p class="name-user">
                                <?php echo $nombre_usuario; ?>
                            </p>
                            <p class="icon-user d-flex flex-row justify-content-center align-items-center">
                                <i class="fa-solid fa-user"></i>
                            </p>
                        </div>
                </div>
            </div>

            <div class="row container container-body d-flex justify-content-center">
                <div class="col-7 body-content d-flex flex-column">

                    <h2>Procesos de Admisión</h2>

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary btn-new-pa align-self-end" data-bs-toggle="modal" data-bs-target="#modal-container-form">
                        Crear nuevo PA
                    </button>

                    <!-- Modal btn: nuevo proceso de admisión -->
                    <div class="modal fade" id="modal-container-form" tabindex="-1" role="dialog" aria-labelledby="modal-container-form" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">

                                <form action="../index.php?act=add_pa" method="POST">
            
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Nuevo proceso de admisión</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <label for="nombre_pa">Nombre PA: </label>
                                        <input type="text" id="nombre_pa" name="nombre_pa" placeholder="Nombre proceso admision"> <br/>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-create-pa" name="btn_create_pa" data-bs-dismiss="modal">Crear</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                    <div class="container-table">
                        <table>
                            <tr>
                                <th class="field-1">#</th>
                                <th class="field-2">Nombre</th>
                                <th class="field-3">Creado</th>
                                <th class="field-4">Abrir</th>
                                <th class="field-5">Borrar</th>
                            </tr>

                            <?php
                                $i = 1;
                                foreach($procesos_admision as $proceso_admision)
                                {
                                    if($i % 2 == 0)
                                    {
                                        echo '<tr>';
                                    }
                                    else
                                    {
                                        echo '<tr class="even-row">';
                                    }

                                    echo '
                                            <td class="field-1">'.$i.'</td>
                                            <td class="field-2">'.$proceso_admision[1].'</td>
                                            <td class="field-3">'.$proceso_admision[3].'</td>
                                            <td class="field-4"><a href="02_configuracion_areas.php?pa='.$proceso_admision[0].'"><i class="fa-solid fa-arrow-up-right-from-square"></i></a> </td>
                                            <td class="field-5"><a href=""><i class="fa-solid fa-trash-can"></i></a> </td>
                                        </tr>';
                                    
                                    $i++;
                                }

                            ?>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>