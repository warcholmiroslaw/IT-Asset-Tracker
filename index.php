<?php

require_once 'src/controllers/AppController.php';
require_once 'src/controllers/EquipmentController.php';
require_once 'src/controllers/SecurityController.php';
require_once 'src/repository/ProjectRepository.php';
require_once 'src/models/Project.php';
require_once 'Database.php';

$routing = [
    'devicelist' => [
        'controller' => 'EquipmentController',
        'action' => 'deviceList',
        'access' => []
    ],
    'login' => [
        'controller' => 'SecurityController',
        'action' => 'login',
        'access' => []
    ],
    'device' => [
        'controller' => 'EquipmentController',
        'action' => 'device',
        'access' => []
    ],

    'saveDevice' => [
        'controller' => 'EquipmentController',
        'action' => 'saveDevice',
        'access' => []
    ],

    'search' => [
        'controller' => 'EquipmentController',
        'action' => 'search',
        'access' => [ ]
    ],

    'addDevice' => [
        'controller' => 'EquipmentController',
        'action' => 'addDevice',
        'access' => [ ]
    ]
    
    ];

$controller = new AppController();

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url( $path, PHP_URL_PATH);
$action = explode("/", $path)[0];
$action = $action == null ? 'login': $action;

switch($action){
    case "devicelist":
    case "saveDevice":
    case "search":
    case "login":
    case "addDevice":
        //TODO check if user is authenticated and has access to system
        $controllerName = $routing[$action]['controller'];
        $actionName = $routing[$action]['action'];
        $controller = new $controllerName;
        $controller->$actionName();
        break;
    default:
        $controller->render($action);
        break;
}
