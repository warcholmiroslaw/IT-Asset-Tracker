<?php

require_once 'AppController.php';
require_once 'OwnershipController.php';
require_once __DIR__ . '/../models/Users.php';
require_once __DIR__ . '/../../Database.php';


class EquipmentController extends AppController { 

    private $database;
    private $previousOwnerId;

    public function __construct()
    {
        parent::__construct();
        $this->database = new Database();
    }

    public function deviceList($message = '') {

        // check if message exists, then if it exists assign to variable and delete it from session
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
        }

        $this->render('deviceList', [
            "title"=> "Device List",
            "items" => $this->equipmentRepository->getAllDevices(),
            "message" => $message
        ]);
    }

    public function addDevice() {
        $deviceSchema = new Equipment();

        $this->render('addDevice', [
            "title" => "Add Device",
            "device" => $deviceSchema]);
    }

    public function deviceView() {
        // TODO move database query to repository
        if (isset($_GET['device'])) {

            $serialNumber = $_GET['device'];

            $device = $this->equipmentRepository->getDeviceBySerialNumber($serialNumber);

            $this->render('deviceView', [
                "title" => "Device properties",
                "device" => $device
            ]);
        } else {
            echo "Device not specified.";
        }
            
    }

    //TODO edit structure of this funciton
    public function userView() {

        $devices = $this->equipmentRepository->getAllUserDevices($_SESSION['user']['id']);

        $this->render('userView', [
            "title" => "Your equipment",
            "devices" => $devices
        ]);
        exit();
    }

    // delete device from database
    public function deleteDevice() {
        if (isset($_GET['device'])) {
            
            $serialNumber = $_GET['device'];

            if ($this->equipmentRepository->deleteDevice($serialNumber)) {
                $_SESSION['message'] = "Device " . $serialNumber  . " deleted !";
            }
            else {
                $_SESSION['message'] = "Device " . $serialNumber . " not deleted !";
            }
            
            // after delete redirect to /deviceList with confirmation message
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/deviceList");
            exit();
        } else {
            echo "Can't remove this device !";
        }
    }

    // collect data and redirect to edit page
    public function editDevice() {

        if (isset($_GET['device'])) {

            // get all info about device that we want to edit and store previous owner for validation in updates
            $serialNumber = $_GET['device'];
            $device = $this->equipmentRepository->getDeviceBySerialNumber($serialNumber);
            $this->previousOwnerId = $device->getPrimaryUser();

            $this->render('editDevice', [
                "title"=> "edit device", 
                "device" => $device,
            ]);
            exit();

        } else {
            echo "Device not specified.";
        }
    }

    // edit data, change rows in database and then redirect to device list
    public function updateDevice() {
        if($this->isPost()) {

            $euqipmentId = $_POST['id'];

            // check if user exists
            $fullName = $_POST['primary_user'];
            $userId = $this->userRepository->ifUserExists($fullName);

            // validation
            if ($userId) {
                try {
                    // start transaction
                    $pdo = $this->database->connect();
                    $pdo->beginTransaction();
                    
                    // update data in equipment and owner table
                    if($this->equipmentRepository->updateDevice($_POST, $userId) && $this->ownershipRepository->updateOwnership($euqipmentId, $userId, $this->previousOwnerId))
                    {
                        // if both updates are correct commit changes
                        $pdo->commit();
                    }
            
                } catch (Exception $e) {

                    if (isset($pdo) && $pdo->inTransaction()) {
                        $pdo->rollBack();
                    }
                    throw $e;
                }
                $_SESSION['message'] = "Device " . $_POST['serial_number'] . " updated !";

            }
            else {
                // if user doesn't exist
                $_SESSION['message'] = "User doesn't exists! Try again ";
            }
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/deviceList");
            exit();
        }
    }

    public function createDevice() {
        if($this->isPost()) {

             // check if user exists
            $userData = $_POST['primary_user'];
            $userId = $this->userRepository->ifUserExists($userData);

             // check if device is not in our database
            $serialNumber = $_POST['serial_number'];
            $uniqueDevice = $this->equipmentRepository->checkIfDeviceExists($serialNumber);

            // validation
            if ($userId) {
                if (!$uniqueDevice) {
                    try {
                        // start transaction
                        $pdo = $this->database->connect();
                        $pdo->beginTransaction();

                        // insert new device into equipment table
                        $newDeviceId = $this->equipmentRepository->addDevice($_POST);

                        // insert device ID and user ID into owhnership table
                        $this->ownershipRepository->addOwner($newDeviceId, $userId);
                        // commit changes
                        $pdo->commit();

                     } catch (Exception $e) {

                         if (isset($pdo) && $pdo->inTransaction()) {
                             $pdo->rollBack();
                         }
                         throw $e;
                     }
                    $_SESSION['message'] = "Device " . $_POST['serial_number'] . " added";
                 }
                 else {
                     $_SESSION['message'] = "Device already exists !";
                 }
             }
             else {
                $_SESSION['message'] = "User doesn't exists! Try again ";
             }

            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/deviceList");
            exit();
        }
    }

    // search devices with by type or serial number
    public function search() {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';


        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            if (array_key_exists('type', $decoded)) {

                if ($decoded['type'] === 'All devices'){

                    echo json_encode($this->equipmentRepository->getAllDevices());
                }
                else {

                    echo json_encode($this->equipmentRepository->getDevicesByCondition('type', $decoded['type']));
                }
            } elseif (array_key_exists('search', $decoded)) {

                echo json_encode($this->equipmentRepository->getDevicesByCondition('serial_number', $decoded['search']));
            }
        }
    }

}