<?php
	session_unset();
	require_once  'controller/controller.php';		
    $controller = new controller();	
    $controller->mvcHandler();
?>