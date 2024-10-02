<?php

require_once 'AppController.php';
require_once 'OwnershipController.php';
require_once __DIR__ . '/../repository/Repository.php';

class EquipmentController extends AppController { 

    //private $equipmentData;
    private $repository;
    private const TABLE_NAME = "equipment";

    public function __construct()
    {
        parent::__construct();
        $this->repository = new Repository();
    }

    public function deviceList($message = '') {

        // check if message exists, then if it exists assign to variable and delete it from session
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
        }

        // prepare query to get all devices saved in database and load on page
        $query = $this->repository->prepareQueryForSelectAll(SELF::TABLE_NAME);

        return $this->render('devicelist', [
            "title"=> "device List", 
            "items" => $this->repository->executeQuery($query, SELF::TABLE_NAME),
            "message" => $message
        ]);
    }

    public function addDevice() {
        return $this->render('addDevice');
    }

    public function userView() {
        $ownership = new OwnershipController();

        $queryResult = $ownership->getUserDevices();
        $devices = $ownership->calculateDates($queryResult);
        
        return $this->render('userView', [
            "title" => "Your equipment",
            "devices" => $devices
        ]);
    }

        // delete device from database
    public function deleteDevice() {
        if (isset($_GET['device'])) {
            
            $deviceId = $_GET['device'];
            
            $query = $this->repository->prepareQueryToDelete(SELF::TABLE_NAME, 'serial_number');
            $quantity = $this->repository->executeQuery($query, SELF::TABLE_NAME, [$deviceId]);
            
            // after delete redirect to /devicelist with confirmation message
            $_SESSION['message'] = "Pomyslnie sunieto urzadzenie, SN = " . $deviceId . " liczba usunietych rekordow = " . $quantity;
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/devicelist");
            exit();

        } else {
            echo "Can't remove this device !";
        }
    }

    // collect data and redirect to edit page
    public function editDevice() {
        if (isset($_GET['device'])) {
            
            $deviceId = $_GET['device'];
            
            $query = $this->repository->prepareQueryForSelect(SELF::TABLE_NAME, 'serial_number');
            $_SESSION['message'] = "Zaktualizowano dane urzadzenia SN = " . $deviceId;

            return $this->render('editDevice', [
                "title"=> "device List", 
                "items" => $this->repository->executeQuery($query, SELF::TABLE_NAME, [$deviceId]) 
            ]);
        } else {
            echo "Device not specified.";
        }
    }

    // edit data, change rows in database and then redirect to device list
    public function updateDevice() {
        if($this->isPost()) {
            $device = new Equipment();
            $device->loadData($_POST);

            if($this->repository->createOrUpdateRow("UPDATE", $device, 'id', $device->getId())){
                $url = "http://$_SERVER[HTTP_HOST]";
                header("Location: {$url}/devicelist");
                exit();
            }
        }
    }

    public function saveDevice() {
        if($this->isPost()) {

            $device = new Equipment();
            $device->loadData($_POST);

            $this->repository->createOrUpdateRow("CREATE", $device);

            session_start();
            $_SESSION['message'] = "Pomyslnie dodano urzadenie SN = " . $device->getSerialNumber();
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

                    $query = $this->repository->prepareQueryForSelectAll(SELF::TABLE_NAME, 'type');
                    echo json_encode($this->repository->executeQuery($query, SELF::TABLE_NAME));

                }   else {
                    $query = $this->repository->prepareQueryForSelect(SELF::TABLE_NAME, 'type');
                    echo json_encode($this->repository->executeQuery($query, SELF::TABLE_NAME, [$decoded['type']]));
                }
            } elseif (array_key_exists('search', $decoded)) {

                $query = $this->repository->prepareQueryForSelect(SELF::TABLE_NAME, 'serial_number');
                echo json_encode($this->repository->executeQuery($query, SELF::TABLE_NAME, [$decoded['search']]));
            }
        }
    }

}