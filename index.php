<?php

    require_once 'src/controllers/AppController.php';
    $controller = new AppController();

    // process U$L from client --? process request from client
    $path = trim($_SERVER['REQUEST_URI'], '/');
    $path = parse_url( $path, PHP_URL_PATH);
    $action = explode("/", $path)[0];


    $controller->render($action);
