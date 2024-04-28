<?php

require_once 'src/controllers/AppController.php';
require_once 'src/models/Projects.php';

$controller = new AppController();

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url( $path, PHP_URL_PATH);
$action = explode("/", $path)[0];
$action = $action == null ? 'login': $action;

switch($action) {
    case "dashboard":
        $projectA = new Project("A", "Sample desc", "https://picsum.photos/300/200");
        $projectB = new Project("Project B", "Sample desc", "https://picsum.photos/300/200");
        $projectc = new Project("Project C", "Sample desc", "https://picsum.photos/300/200");

        $projects = [$projectA, $projectB, $projectc, $projectA];

        $controller->render($action, [ "projects" => $projects, "title" =>  "DASHBOARD | WDPAI"]);
        break;
    case "projects":
        $controller->render($action);
        break;
    case "userView":
        $controller->render($action);
        break;
    case "deviceList":
        $controller->render($action);
        break;
    deafult:
        $controller->render($action);
}