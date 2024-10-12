<?php

require_once __DIR__ . '/../../Database.php';
class OwnershipRepository extends Database
{
    protected $database;


    public function __construct()
    {
        $this->database = new Database();
    }


    public function getDeviceOwner($equipmentId){
        $statement = $this->database->connect()->prepare("
            SELECT CONCAT(u.name, ' ', u.surname) as primary_user
            FROM " . self::OWNERSHIP_TABLE . "o" .
            "JOIN ". self::USERS_TABLE." u ON o.user_id = u.id
            WHERE o.equipment_id = :equipmentId");
        $statement->bindParam(":equipmentId", $equipmentId);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    public function addOwner($equipmentId, $userId){

        $statement = $this->database->connect()->prepare("
                        INSERT INTO ownership (equipment_id, user_id, assigned_at, status)
                        VALUES (:equipment_id, :user_id, CURRENT_TIMESTAMP, 'assigned');");
        $statement->bindParam(':user_id', $userId);
        $statement->bindParam(':equipment_id', $equipmentId);
        $statement->execute();

        return $statement->rowCount();
    }
    public function updateOwnership($equipmentId, $userId, $previousOwnerId){

        if ($previousOwnerId == $userId){
            return true;
        }

        // set return date to previous ownership
        $statement = $this->database->connect()->prepare("
                        UPDATE ownership
                        SET returned_at = CURRENT_TIMESTAMP,
                            status = 'returned'
                        WHERE equipment_id = :equipment_id");

        $statement->bindParam(':equipment_id', $equipmentId);
        $statement->execute();

        // set new ownership
        return $this->addOwner($equipmentId, $userId);
    }
}
