<!doctype html>
<html lang="es">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <title>(-1) Index</title>

        <style>
            
            .main-container
            {
                background-color: #2C2E4A;
                height: 100vh;
                font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            }

            .panel
            {
                width: 900px;
                height: 500px;

                background: #fff;
                background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(255,255,255,1) 0%, rgba(93,95,239,0.6786064767703957) 100%, rgba(35,37,57,1) 100%);
                
                box-shadow: 0px 10px 15px black;

                position: relative;
                overflow: hidden;
            }
            
            .left-side .name-site
            {
                font-size: 30px;
                font-weight: bold;
                text-align: center;
            }

            .left-side .name-university
            {
                font-size: 40px;
                font-weight: bold;
                text-align: center;
            }

            .left-side a
            {
                margin-top: 50px;
                border-radius: 3px;
                padding: 6px 10px;
                color: #fff;
                background-color: #2C2E4A;
                text-decoration: none;
            }

            .right-side .img-container
            {
                width: 370px;
                height: 370px;
                border-radius: 50%;
                border: 3px solid #bbb;
                background-color: #fff;
            }

            .right-side .img-container img{
                height: 300;
            }

            .panel .circle
            {
                background-color: #5D5FEF;
                width: 150px;
                height: 150px;
                border-radius: 50%;
                position: absolute;
                left: 325px;
                bottom: -80px;
            }

        </style>
    </head>

    <body>

        <div class="container-fluid d-flex justify-content-center align-items-center main-container">

            <div class="row panel">
                <div class="col-5 left-side d-flex flex-column justify-content-center align-items-center">
                    <p class="name-site">
                        Comisión Central de Admisión
                    </p>
                    <p class="name-university">
                        UNA-PUNO
                    </p>
                    <a href="00_login.php">Iniciar sesión</a>
                </div>

                <div class="col-7 right-side d-flex justify-content-center align-items-center">
                    <div class="img-container d-flex justify-content-center align-items-center">
                        <img src="../resources/images/logo-una.png" alt="log una-puno">
                    </div>
                </div>

                <div class="circle">

                </div>
            </div>

        </div>

        

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>