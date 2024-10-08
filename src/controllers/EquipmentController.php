<?php

require_once 'AppController.php';
require_once 'OwnershipController.php';
require_once __DIR__ . '/../models/Users.php';
require_once __DIR__ . '/../repository/Repository.php';
require_once __DIR__ . '/../../Database.php';


class EquipmentController extends AppController { 

    //private $equipmentData;
    private $repository;
    private const TABLE_NAME = "equipment";
    private $database;

    public function __construct()
    {
        parent::__construct();
        $this->repository = new Repository();
        $this->database = new Database();
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
            
            $serialNumber = $_GET['device'];
            
            $query = $this->repository->prepareQueryToDelete(SELF::TABLE_NAME, 'serial_number');
            $quantity = $this->repository->executeQuery($query, SELF::TABLE_NAME, [$serialNumber]);
            
            // after delete redirect to /devicelist with confirmation message
            $_SESSION['message'] = "Device " . $serialNumber  . " deleted !";
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
            
            $serialNumber = $_GET['device'];
        
            // $query 
            $statement = $this->database->connect()->prepare("
            SELECT  e.id, 
                e.type, 
                e.brand, 
                e.model, 
                e.serial_number, 
                e.purchase_date,
                CONCAT(u.name, ' ', u.surname) as primary_user
                FROM public.equipment e
                JOIN public.ownership o ON o.equipment_id = e.id
                JOIN public.users u ON u.id = o.user_id
                WHERE e.serial_number = :serialNumber");
         
            $statement->bindValue(":serialNumber", $serialNumber, PDO::PARAM_STR);
            $statement->execute();

            $result = $statement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, SELF::TABLE_NAME);

            return $this->render('editDevice', [
                "title"=> "edit device", 
                "items" => $result 
            ]);
        } else {
            echo "Device not specified.";
        }
    }

    // edit data, change rows in database and then redirect to device list
    public function updateDevice() {
        if($this->isPost()) {

            // check if user exists
            $user_data = $_POST['primary_user'];
            $user = new  Users();

            // validation
            $user_id = $user->ifUserExists($user_data);

            if ($user_id) {
                try {
                    // start transaction
                    $pdo = $this->database->connect();
                    $pdo->beginTransaction();
                    
                    // update equipment table
                    $statement = $pdo->prepare("
                        UPDATE equipment
                        SET brand = :brand,
                            model = :model,
                            serial_number = :serial_number,
                            purchase_date = :purchase_date
                        WHERE id = :id");
                    
                    $statement->bindParam(':brand', $_POST['brand']);
                    $statement->bindParam(':model', $_POST['model']);
                    $statement->bindParam(':serial_number', $_POST['serial_number']);
                    $statement->bindParam(':purchase_date', $_POST['purchase_date']);
                    $statement->bindParam(':id', $_POST['id']);
                    $statement->execute();

                    // update owhnership table
                    $statement = $pdo->prepare("
                        UPDATE ownership
                        SET user_id = :user_id
                        WHERE equipment_id = :equipment_id");
            
                    $statement->bindParam(':user_id', $user_id);
                    $statement->bindParam(':equipment_id', $_POST['id']);
                    $statement->execute();
                    
                    
                    $pdo->commit();
            
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
            header("Location: {$url}/devicelist");
            exit();
        }
    }

    public function saveDevice() {
        if($this->isPost()) {

             // check if user exists
             $user_data = $_POST['primary_user'];
             $user = new  Users();
 
             // validation
             $user_id = $user->ifUserExists($user_data);
 
             if ($user_id) {
                try {
                    // start transaction
                    $pdo = $this->database->connect();
                    $pdo->beginTransaction();
                    
                    // insert into equipment table
                    $statement = $pdo->prepare("
                        INSERT INTO equipment (type, brand, model, serial_number, purchase_date)
                        VALUES (:type, :model, :brand, :serial_number, :purchase_date);");
                    
                    $statement->bindParam(':type', $_POST['type']);
                    $statement->bindParam(':brand', $_POST['brand']);
                    $statement->bindParam(':model', $_POST['model']);
                    $statement->bindParam(':serial_number', $_POST['serial_number']);
                    $statement->bindParam(':purchase_date', $_POST['purchase_date']);
                    $statement->execute();

                    // insert into owhnership table
                    $statement = $pdo->prepare("
                        INSERT INTO ownership (user_id, equipment_id, status)
                        VALUES (:user_id, :equipment_id, 'assigned');");
            
                    $statement->bindParam(':user_id', $user_id);
                    $statement->bindParam(':equipment_id', $_POST['id']);
                    $statement->execute();
                    
                    
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
                $_SESSION['message'] = "User doesn't exists! Try again ";
             }
            

            // session_start();
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