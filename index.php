<?php

require_once 'src/controllers/AppController.php';
require_once 'src/controllers/EquipmentController.php';
require_once 'src/controllers/SecurityController.php';
require_once 'Database.php';

$routing = [
    'devicelist' => [
        'controller' => 'EquipmentController',
        'action' => 'deviceList',
        'access' => ['admin']
    ],

    'userView' => [
        'controller' => 'EquipmentController',
        'action' => 'userView',
        'access' => ['user', 'admin']
    ],

    'login' => [
        'controller' => 'SecurityController',
        'action' => 'login',
        'access' => ['admin', 'user']
    ],
    'logout' => [
        'controller' => 'SecurityController',
        'action' => 'logout',
        'access' => ['admin', 'user']
    ],
    'device' => [
        'controller' => 'EquipmentController',
        'action' => 'device',
        'access' => ['admin']
    ],

    'saveDevice' => [
        'controller' => 'EquipmentController',
        'action' => 'saveDevice',
        'access' => ['admin']
    ],

    'search' => [
        'controller' => 'EquipmentController',
        'action' => 'search',
        'access' => ['admin']
    ],

    'addDevice' => [
        'controller' => 'EquipmentController',
        'action' => 'addDevice',
        'access' => ['admin']
    ],
    
    'editDevice' => [
        'controller' => 'EquipmentController',
        'action' => 'editDevice',
        'access' => ['admin']
    ],
    'updateDevice' => [
        'controller' => 'EquipmentController',
        'action' => 'updateDevice',
        'access' => ['admin']
    ],
    'deleteDevice' => [
        'controller' => 'EquipmentController',
        'action' => 'deleteDevice',
        'access' => ['admin']
    ]
    ];

    // Function to check if user is authenticated
function isUserAuthenticated() {
    return isset($_SESSION['user']);
}

// Function to get the user's role
function getUserRole() {
    return isUserAuthenticated() ? $_SESSION['user']['role'] : null;
}

function hasAccess($action, $roles) {
    $userRole = getUserRole();
    return in_array($userRole, $roles);
}


$controller = new AppController();

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url( $path, PHP_URL_PATH);
$action = explode("/", $path)[0];
$action = $action == null ? 'login': $action;

switch($action){
    case "logout":
    case "login":
    case "devicelist":
    case "saveDevice":
    case "search":
    case "addDevice":
    case "editDevice":
    case "updateDevice":
    case "deleteDevice":
    case "userView":

    //    TODO check if user is authenticated and has access to system
        $roles = $routing[$action]['access'];
        
        session_start();

        if (isUserAuthenticated()) {      
            if(hasAccess($action, $roles)){   
                $controllerName = $routing[$action]['controller'];
                $actionName = $routing[$action]['action'];
                $controller = new $controllerName;
                $controller->$actionName();
                break;
            }
            else{
                $controller->render('accessDenied');
                break;
            }
        } else {
            $controller = new SecurityController();
            $controller->login();
            break;
        }
        break;
    default:
        $controller = new SecurityController();
        $controller->login();
        break;
}
