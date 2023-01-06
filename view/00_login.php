<?php
    // Turn off all error reporting
    error_reporting(0);

    require_once  '../controller/controller.php';

    unset($_SESSION);
?>

<!doctype html>
<html lang="es">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/ac9c34bb46.js" crossorigin="anonymous"></script>
        <title>01. PROCESOS DE ADMISION</title>

        <style>
            
            .main-container
            {
                background-color: #2C2E4A;
                height: 100vh;
                font-family: 'Roboto', sans-serif;
            }

            .panel
            {
                width: 900px;
                height: auto;

                background: #fff;

                box-shadow: 0px 10px 15px black;
            }

            .left-side
            {
                padding-left: 60px !important;
            }

            .left-side .logo-una
            {
                height: 90px;
            }
            
            .left-side .title-area
            {
                margin-top: 60px;
                font-size: 18px;
                font-weight: bold;
                margin-bottom: 10px !important;
            }

            .left-side form{
                width: 100%;
            }

            .left-side form > *{
                display: block;
                width: 100%;
            }
            
            .left-side form > label
            {
                font-size: 15px;
                padding: 13px 0px 7px;
                font-weight: 500;
            }

            .left-side form > input
            {
                
                padding: 7px 6px;
                border: 1px solid #aaa;
                border-radius: 3px;
                font-size: 15px;
            }
            
            .left-side form a
            {
                padding: 15px 0px;
                text-decoration: none;
                text-align: right;
                font-size: 13px;
                font-weight: bold;
                color: #2C2E4A;
            }

            .left-side form input[type="submit"]
            {
                background-color: #2C2E4A;
                color: #fff;
                font-size: 15px;
            }

            .right-side .img-container
            {
                padding: 20px !important;
                overflow: hidden;
            }

            .right-side .img-container img{
                width: 100%;
            }

        </style>
    </head>

    <body>

        <div class="container-fluid d-flex justify-content-center align-items-center main-container">

            <div class="row panel">
                <div class="col-5 left-side d-flex flex-column justify-content-center align-items-center">
                    <img class="logo-una" src="../resources/images/logo-una2.png" alt="">

                    <p class="title-area">
                        Iniciar sesión
                    </p>

                    <form action="../index.php?act=login" method="POST">
        
                        <label for="username">Usuario: </label>
                        <input type="text" id="username" name="username" placeholder="usuario">

                        <label for="password">Contraseña: </label>
                        <input type="password" id="password" name="password" placeholder="contraseña">
                        
                        <a href="#">¿Olvidaste tu contraseña?</a>

                        <input type="submit" value="Iniciar sesión" name="btn_login">
                    </form>

                </div>

                <div class="col-7 right-side d-flex justify-content-center align-items-center">
                    <div class="img-container d-flex justify-content-center align-items-center">
                        <img src="../resources/images/cca.png" alt="log una-puno">
                    </div>
                </div>
            </div>

        </div>

        

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>