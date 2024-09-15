<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/EquipmentData.php';
require_once __DIR__ . '/../repository/Repository.php';


class EquipmentController extends AppController { 

    private $equipmentData;
    private $repository;

    public function __construct()
    {
        parent::__construct();
        $this->equipmentData = new EqipmentData();
        $this->repository = new Repository();
    }

    public function deviceList() {
        // prepare query to get all devices saved in database and load on page
        $query = $this->repository->prepareQueryForSelectAll('Equipment');

        return $this->render('devicelist', [
            "title"=> "device List", 
            "items" => $this->repository->executeQuery($query, 'Equipment')
        ]);
    }

    public function addDevice() {
        return $this->render('addDevice');
    }

    public function editDevice() {
        $query = $this->repository->prepareQueryForUpdate('Equipment', 'serial_number');
        return $this->render('editDevice', [
            "title"=> "device List", 
            "items" => $this->repository->executeQuery($query, 'Equipment')
        ]);
    }

    public function saveDevice() {
        if($this->isPost()) {

            $device = new Equipment();
            $device->loadData($_POST);

            $this->repository->createRow($device);

            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/devicelist");
            exit();
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

                if ($decoded['type'] === 'All devices'){

                    $query = $this->repository->prepareQueryForSelectAll('Equipment', 'type');
                    echo json_encode($this->repository->executeQuery($query, 'Equipment'));

                }   else {
                    $query = $this->repository->prepareQueryForSelect('Equipment', 'type');
                    echo json_encode($this->repository->executeQuery($query, 'Equipment', [$decoded['type']]));
                }
            } elseif (array_key_exists('search', $decoded)) {
                // echo json_encode($this->equipmentData->getEquipmentBySerialNumber($decoded['search']));
                $query = $this->repository->prepareQueryForSelect('Equipment', 'serial_number');
                echo json_encode($this->repository->executeQuery($query, 'Equipment', [$decoded['search']]));
            }
        }
    }

}