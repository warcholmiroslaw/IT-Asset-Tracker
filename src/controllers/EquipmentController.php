<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/ProjectRepository.php';

class EquipmentController extends AppController { 

    private $projectRepository;

    public function __construct()
    {
        parent::__construct();
        $this->projectRepository = new ProjectRepository();
    }

    public function deviceList() {
        return $this->render('deviceList', [
            "title"=> "device List", 
            "items" => $this->projectRepository->getEquipment()
        ]);
    }

    public function addDevice() {
        return $this->render('addDevice');
    }

    public function saveDevice() {
        if($this->isPost()) {

            $this->projectRepository->saveDevice($_POST);

            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/devicelist");
            return;
        }

        return $this->render('add-project', ["title"=> "ADD PROJECT | WDPAI"]);

    }

    public function search() {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';


        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            
            header('Content-type: application/json');
            http_response_code(200);

            if (array_key_exists('type', $decoded)) {

                echo json_encode($this->projectRepository->getEquipmentByType($decoded['type']));

            } elseif (array_key_exists('search', $decoded)) {

                echo json_encode($this->projectRepository->getEquipmentBySerialNumber($decoded['search']));
            }
        }
    }

}