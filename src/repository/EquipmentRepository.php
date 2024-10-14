<?php

require_once __DIR__ . '/../../Database.php';
require_once __DIR__ . '/../models/Equipment.php';
class EquipmentRepository extends Database
{
    protected $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function addDevice($device){
        $statement = $this->database->connect()->prepare("INSERT INTO equipment 
                                (type, brand, model, serial_number, purchase_date)
                        VALUES (:type, :brand, :model, :serialNumber, :purchaseDate)
                        returning id;");

        $statement->bindParam(':type', $device['type']);
        $statement->bindParam(':brand', $device['brand']);
        $statement->bindParam(':model', $device['model']);
        $statement->bindParam(':serialNumber', $device['serial_number']);
        $statement->bindParam(':purchaseDate', $device['purchase_date']);
        $statement->execute();

        // return id of new device
        return $statement->fetchColumn();
    }

    public function getAllDevices(){
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
                JOIN public.users u ON u.id = o.user_id AND o.status = 'assigned'");

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, SELF::EQUIPMENT_TABLE);
    }

    public function getAllUserDevices($user_id){
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
                WHERE o.user_id = :user_id AND o.status = 'assigned';");
        $statement->bindParam(':user_id', $user_id);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, SELF::EQUIPMENT_TABLE);
    }

    // column should be from equipment table
    public function getDevicesByCondition($column, $value){
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
                WHERE e.$column = :value AND o.status = 'assigned';");

        $statement->bindParam(":value", $value);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, SELF::EQUIPMENT_TABLE);
    }
    public function getDeviceBySerialNumber($serialNumber){
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
                WHERE e.serial_number = :serialNumber AND
                      o.status = 'assigned';");


        $statement->bindParam(":serialNumber", $serialNumber);
        $statement->execute();

        return $statement->fetchObject(self::EQUIPMENT_TABLE);
    }

    public function deviceExists($serialNumber){
    }

    public function checkIfDeviceExists($serialNumber){
        $statement = $this->database->connect()->prepare("
        SELECT EXISTS (
            SELECT 1
                FROM equipment
            WHERE serial_number = :serialNumber);");

        $statement->bindParam(":serialNumber", $serialNumber);
        $statement->execute();

        // returns true/false if device exists or not
        return $statement->fetchColumn();
    }
    public function updateDevice($device){
        // update equipment table
        $statement = $this->database->connect()->prepare("
                        UPDATE equipment
                        SET brand = :brand,
                            model = :model,
                            serial_number = :serial_number,
                            purchase_date = :purchase_date
                        WHERE id = :id");

        $statement->bindParam(':brand', $device['brand']);
        $statement->bindParam(':model', $device['model']);
        $statement->bindParam(':serial_number', $device['serial_number']);
        $statement->bindParam(':purchase_date', $device['purchase_date']);
        $statement->bindParam(':id', $device['id']);
        $statement->execute();

        // if update was correct it will return number > 0
        return $statement->rowCount();
    }
    public function deleteDevice($serialNumber){
        $statement = $this->database->connect()->prepare("DELETE FROM ". self::EQUIPMENT_TABLE ." WHERE serial_number = :SerialNumber;");
        $statement->bindParam(":SerialNumber", $serialNumber);
        $statement->execute();
        $statement->rowCount();

        // if record was deleted it will return positive number
        if($statement->rowCount() > 0){
            return true;
        }
        return false;
    }

}