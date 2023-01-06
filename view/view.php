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


            /* CONFIGURACIÓN MATERIAS */

            select.select_areas{
                -webkit-appearance: menulist-button;
                height: 35px;
                width: 150px;
                text-align: center;
                background-color: #2E6AA0;
                border-radius: 5px;
                color: white;
                padding-left: 5px;

                margin-bottom: 20px;
            }

            select.select_areas > option{
                text-align: left;
                background-color: white;
                color: black;
                height: 20px;
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
                height: 35px !important;
            }

            section .name-pa-btn-area .btn-agregar-materia{
                background-color: #2E6AA0;
                color: white;
                height: 35px !important;
            }

            section .name-pa-btn-area .btn-agregar-materia:hover{
                color: white;
            }

            section .name-pa-btn-area .btn_add_materia
            {
                background-color: #2E6AA0;
                color: white;
            }

            section .name-pa-btn-area form{
                font-size: 15px;
            }

            section .name-pa-btn-area form label.label-input-text
            {
                width: 140px;
                padding: 10px 0px;
            }

            section .name-pa-btn-area form label.label-input-checkbox
            {
                padding: 10px 0px 0px !important;
            }

            /* CONTAINER FORM TABLE */
            .container-form-table{
                margin-top: 20px;
            }

            .container-form-table form table{
                width: 100%;
                font-size: 14px;
                border-top: 1px solid gray;
                border-bottom: 1px solid gray;
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
                width: 32%;
            }

            .container-form-table form table tr .field-2{
                width: 17%;
            }

            .container-form-table form table tr .field-3{
                width: 17%;
            }

            .container-form-table form table tr .field-4{
                width: 17%;
            }

            .container-form-table form table tr .field-5{
               text-align: center;
            }
            
            .container-form-table form table tr .field-5 input{
                
                transform: scale(1.5);
            }

            .container-form-table form input[type="submit"]
            {
                float: right; 
                clear: both;
                background-color: #2E6AA0;
                color: white;
                padding: 5px 25px;
            }

            /* END CONFIGURACIÓN MATERIAS */


            /* ELABORAR PREGUNTAS */

            section .container-main-content .name-area-preguntas
            {
                margin: 0px !important;
                padding: 0px !important;
            }

            section .name-area-preguntas .name-pa{
                margin: 0px !important;
                padding: 0px !important;
                display: block;
                text-align: center;
                background-color: #F4F3F8;
                font-weight: bold;
                margin-left: 15px !important;
                line-height: 35px;
                height: 35px !important;
            }


            .side-materias{
                border: 1px solid #ccc;
                padding: 0px !important;
                font-size: 15px;
            }

            .side-materias .header-side-materias{
                height: 50px;
                line-height: 50px;
                border: 1px solid green;
                text-align: center;
                font-weight: bold;
                background-color: #2C2E4A;
                color: white;
            }

            .side-materias ul.body-side-materias{
                height: 250px;
                overflow-y: scroll;
                list-style: none;
                padding: 0px !important;
            }

            .side-materias .body-side-materias li.element-materia{
                border-bottom: 1px solid #bbb;
            }

            .side-materias .body-side-materias li.element-materia a{
                width: 100%;
                text-decoration: none;
                height: 50px;
                color: black;
                
                line-height: 50px;
            }
            
            .side-materias .body-side-materias li.element-materia i.fa-check
            {
                display: inline-block !important;
                font-size: 15px;
                padding: 0px 7px 0px 15px !important;
                color: #009020;
            }
            
            .side-materias ul.body-side-materias li.element-materia p{
                display: inline-block !important;
                margin: 0px !important;
            }

            .side-preguntas{
                border: 1px solid #ddd;
                padding: 0px !important;
                padding-left: 10px !important;
            }

            .tabla_preguntas
            {
                width: 100%;
                border-top: 1px solid gray;
                border-bottom: 1px solid gray;
                font-size: 14px;
            }

            .side-preguntas table.tabla_preguntas tr th{
                background-color: #3F426A;
                color: white;
                text-align: center;
                height: 50px !important;
            }

            .side-preguntas table.tabla_preguntas tr > * {
                height: 40px;
            }
            
            .side-preguntas .tabla_preguntas .field-1{
                text-align: center;
                width: 15%;
            }

            .side-preguntas .tabla_preguntas .field-3{
                text-align: center;
                width: 15%;
            }

            .side-preguntas form.guardar_preguntas input{
                border: none;
                border-radius: 4px;
                margin: 15px 0px !important;
            }
            
            .side-preguntas .tabla_preguntas .btn-edit-pregunta{
                color: gray;
            }

            /* ----------- */
            .modal-editar-pregunta form{
                font-size: 15px;
            }


            .modal-editar-pregunta form .modal-body label{
                display: block;
                font-weight: bold;
                text-align: left;
                font-size: 15px;
                padding: 10px 0px;
            }

            .modal-editar-pregunta form .modal-body textarea.campo_pregunta{
                width: 100%;
                min-height: 70px;
                border-radius: 5px;
                padding: 3px 4px;
            }

            .modal-editar-pregunta form .modal-body table{
                background-color: white;
                border-top: 1px solid #bbb;
                border-bottom: 1px solid #bbb;
            }


            .modal-editar-pregunta form .modal-body table th.letra-alternativa{
                width: 10%;
                text-align: center;
                font-weight: normal;
                padding: 0px !important;
                margin: 0px !important;
            }

            .modal-editar-pregunta form .modal-body table th.input-alternativa{
                padding: 0px !important;
                margin: 0px !important;
            }

            .modal-editar-pregunta form .modal-body table th.input-alternativa input{
                width: 100%;
                border-radius: 4px;
                padding: 3px;
                border: 1px solid #aaa;
            }

            .modal-editar-pregunta form .modal-body table th.radio-respuesta{
                width: 15%;
                text-align: center;
            }

            .modal-editar-pregunta form .modal-body table tr th{
                background-color: white;
                color: black;
            }

            .modal-editar-pregunta form .modal-body table th.radio-respuesta input{
                transform: scale(1.5);
            }

            .modal-editar-pregunta form .btn-guardar_pregunta{
                background-color: #2E6AA0;
                color: #fff;
            }


            .even-row{
                
                background-color: #eee !important;
            }

            .even-row > *{
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
                        <li class="step-selected"><a href="#"><i class="fas fa-book"></i>Materias</a></li>
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

                            <p class="name-user">DEYVIS MAMANI LACUTA</p>
                            <div class="container-icon-user d-flex justify-content-center align-items-center">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                    </header>

                    <!-- CONFIGURACIÓN MATERIAS -->
                    <section class="d-flex flex-column">

                        <h3>Configuración de Materias</h3>

                        <hr>

                        <div class="container-main-content align-self-center">

                            <select name="areas" class="select_areas" id="areas" onchange="location = this.value;">
                                <option value="04_elaborar_examen.php?id_area=1 selected">Areas</option>
                                <option value="04_elaborar_examen.php?id_area=1">Nombre area</option>
                            </select>

                            <div class="row name-pa-btn-area">
                                <p class="col name-pa">Nombre area</p>

                                <!-- Button trigger modal -->
                                <button type="button" class="btn-agregar-materia col-auto btn btn-new-pa align-self-end" data-bs-toggle="modal" data-bs-target="#modal-container-form">
                                    Agregar materia
                                </button>

                                <!-- Modal btn: nuevo proceso de admisión -->
                                <div class="modal fade" id="modal-container-form" tabindex="-1" role="dialog" aria-labelledby="modal-container-form" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">

                                            <form action="../index.php?act=add_materia" method="POST">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Nueva materia</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <label class="label-input-text" for="nombre_materia">Materia: </label>
                                                    <input type="text" name="nombre_materia" id="nombre_materia"> <br/>
                                    
                                                    <label class="label-input-text" for="n_orden">Nro orden: </label>
                                                    <input type="number" name="n_orden" id="n_orden"> <br/>
                                                    
                                                    <label class="label-input-text" for="n_preguntas">Nro preguntas: </label>
                                                    <input type="number" name="n_preguntas" id="n_preguntas"> <br/>
                                    
                                                    <label class="label-input-text" for="puntaje_pregunta">Puntaje pregunta: </label>
                                                    <input type="number" min="0" max="5" step="0.5" name="puntaje_pregunta" id="puntaje_pregunta"> <br/>
                                                    
                                                    <input type="checkbox" id="scope" name="scope" value="1">
                                                    <label class="label-input-checkbox" for="scope">Mantener materia</label> <br/>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn_add_materia" name="btn_add_materia" data-bs-dismiss="modal">Crear materia</button>
                                                </div>
                                
                                            </form>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="container-form-table">
                                <form action="../index.php?act=guardar_config_materias" method="POST">
                                    <table col="3">
                                        <thead>
                                            <tr>
                                                <th class="field-1">Nombre</th>
                                                <th class="field-2">Nº orden</th>
                                                <th class="field-3">Nº preguntas</th>
                                                <th class="field-4">Puntaje</th>
                                                <th class="field-5">Participa</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="">
                                                <td class="field-1">Nombre sameple</td>
                                                <td class="field-2">Nombre sameple</td>
                                                <td class="field-3">Nombre sameple</td>
                                                <td class="field-4">Nombre sameple</td>
                                                <td class="field-5"><input type="checkbox" name="" id=""></td>
                                            </tr>
                                            <tr class="even-row">
                                                <td class="field-1">Nombre sameple</td>
                                                <td class="field-2">Nombre sameple</td>
                                                <td class="field-3">Nombre sameple</td>
                                                <td class="field-4">Nombre sameple</td>
                                                <td class="field-5"><input type="checkbox" name="" id=""></td>
                                            </tr>
                                            
                                        </tbody>
                                    </table> <br/>
                                    

                                    <input type="submit" value="Continuar" name="btn_guardar_config_materias" class="btn">
                                </form>
                            </div>

                        </div>
                    </section>
    

                    <!-- ELABORACIÓN PREGUNTAS -->
                    <section class="d-flex flex-column">

                        <h3>Registrar preguntas</h3>

                        <hr>

                        <div class="container-main-content align-self-center">

                            <div class="row name-area-preguntas">
                                <select name="areas" class="col-auto select_areas" id="areas" onchange="location = this.value;">
                                    <option value="04_elaborar_examen.php?id_area=1 selected">Areas</option>
                                    <option value="04_elaborar_examen.php?id_area=1">Nombre area</option>
                                </select>
                                
                                <p class="col name-pa">Nombre area</p>
                            </div>

                            <div class="row m-0 p-0 container-form-table">

                                <div class="col-4 side-materias">
                                    <div class="header-side-materias">
                                        Materias
                                    </div>
                                    <ul class="body-side-materias">
                                        <li class="element-materia d-flex align-items-center">
                                            <a href="">
                                                <i class="fas fa-check"></i>
                                                <p class="name-materia">Materia x</p>
                                            </a>
                                        </li>
                                        <li class="element-materia d-flex align-items-center even-row">
                                            <a href="">
                                                <i class="fas fa-check"></i>
                                                <p class="name-materia">Materia x</p>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-8 side-preguntas">
                                    <table col="3" class="tabla_preguntas">
                                        <thead>
                                            <tr>
                                                <th class="field-1">Nº</th>
                                                <th class="field-2">Pregunta</th>
                                                <th class="field-3">Editar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="">
                                                <td class="field-1">1</td>
                                                <td class="field-2">Nombre sameple</td>
                                                <td class="field-3">
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-edit-pregunta" data-bs-toggle="modal" data-bs-target="#modal-container-form1">
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    <!-- Modal btn: editar pregunta -->
                                                    <div class="modal fade modal-editar-pregunta" id="modal-container-form1" tabindex="-1" role="dialog" aria-labelledby="modal-container-form1" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">

                                                                <form action="../index.php?act=update_pregunta_alternativas" method="POST">
                                            
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLongTitle">Editar pregunta</h5>
                                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <label for="input_pregunta">Pregunta</label>
                                                                        <textarea class="campo_pregunta" name="pregunta" value="xd" id="input_pregunta">xdxd</textarea>
                                                                        
                                                                        <label for="input_pregunta">Alternativas</label>

                                                                        <table class="tabla-alternativas">
                                                                            <tr>
                                                                                <th class="letra-alternativa">
                                                                                    a)
                                                                                </th>
                                                                                <th class="input-alternativa">
                                                                                    <input type="text">
                                                                                </th>
                                                                                <th class="radio-respuesta">
                                                                                    <input type="radio" name="respuesta" id="">
                                                                                </th>
                                                                            </tr>

                                                                            <tr class="even-row">
                                                                                <th class="letra-alternativa">
                                                                                    b)
                                                                                </th>
                                                                                <th class="input-alternativa">
                                                                                    <input type="text">
                                                                                </th>
                                                                                <th class="radio-respuesta">
                                                                                    <input type="radio" name="respuesta" id="">
                                                                                </th>
                                                                            </tr>
                                                                        </table>
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                                        <button type="submit" class="btn btn-guardar_pregunta" name="btn_update_pregunta_alternativas" data-bs-dismiss="modal">Guardar</button>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="even-row">
                                                <td class="field-1">1</td>
                                                <td class="field-2">Nombre sameple</td>
                                                <td class="field-3">
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-edit-pregunta" data-bs-toggle="modal" data-bs-target="#modal-container-form1">
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    <!-- Modal btn: editar pregunta -->
                                                    <div class="modal fade modal-editar-pregunta" id="modal-container-form1" tabindex="-1" role="dialog" aria-labelledby="modal-container-form1" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">

                                                                <form action="../index.php?act=update_pregunta_alternativas" method="POST">
                                            
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLongTitle">Editar pregunta</h5>
                                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <label for="input_pregunta">Pregunta</label>
                                                                        <textarea class="campo_pregunta" name="pregunta" value="xd" id="input_pregunta">xdxd</textarea>
                                                                        
                                                                        <label for="input_pregunta">Alternativas</label>

                                                                        <table border="1" class="tabla-alternativas">
                                                                            <tr>
                                                                                <th class="letra-alternativa">
                                                                                    a)
                                                                                </th>
                                                                                <th class="input-alternativa">
                                                                                    <input type="text">
                                                                                </th>
                                                                                <th class="radio-respuesta">
                                                                                    <input type="radio" name="respuesta" id="">
                                                                                </th>
                                                                            </tr>

                                                                            <tr class="even-row">
                                                                                <th class="letra-alternativa">
                                                                                    b)
                                                                                </th>
                                                                                <th class="input-alternativa">
                                                                                    <input type="text">
                                                                                </th>
                                                                                <th class="radio-respuesta">
                                                                                    <input type="radio" name="respuesta" id="">
                                                                                </th>
                                                                            </tr>
                                                                        </table>
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                                        <button type="submit" class="btn btn-guardar_pregunta" name="btn_update_pregunta_alternativas" data-bs-dismiss="modal">Guardar</button>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>

                                    <form action="../index.php?act=guardar_preguntas" method="POST" class="guardar_preguntas">
                                        <input type="submit" value="Guardar" name="btn_guardar_preguntas">
                                    </form>
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