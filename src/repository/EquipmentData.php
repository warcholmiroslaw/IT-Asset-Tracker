<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Equipment.php';

class EqipmentData extends Repository {

    public function init() {
        $SQL = $this->createTables();
        $statement = $this->database->connect()->prepare($SQL);
        $statement->execute();
    }

    public function createTables() {

        return "CREATE TABLE IF NOT EXISTS users (
            id SERIAL PRIMARY KEY,
            name VARCHAR(50) NOT NULL,
            surname VARCHAR(50) NOT NULL,
            account_type VARCHAR(50) NOT NULL CHECK (account_type IN ('admin', 'user')),
            position VARCHAR(50) NOT NULL,
            department VARCHAR(50) NOT NULL,
            manager VARCHAR(50) NOT NULL,
            email VARCHAR(50) UNIQUE,
            phone_number VARCHAR(20) UNIQUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
        
        CREATE TABLE IF NOT EXISTS equipment (
            id SERIAL PRIMARY KEY,
            type VARCHAR(100) NOT NULL,
            brand VARCHAR(100) NOT NULL,
            model VARCHAR(100) NOT NULL,
            serial_number VARCHAR(100) UNIQUE NOT NULL,
            date_of_purchase DATE,
            primary_user INT REFERENCES users(id)
        );
        
        CREATE TABLE IF NOT EXISTS ownership(
            user_id INT REFERENCES users(id),
            eqipment_id INT REFERENCES equipment(id), 
            start_date DATE NOT NULL,
            end_date DATE
        );";
    } 

    public function prepare(string $query): PDOStatement|false
    {
        return $this->database->connect()->prepare($query);
    }

    public function executeQueries(PDOStatement $preparedQuery): bool
    {
        return $preparedQuery->execute();
    }   

    public function getEquipment() {
        $query = $this->database->connect()->prepare('
            SELECT * FROM public.equipment;
        ');
        $query->execute();

        return $query->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Equipment');
    }

    public function getEquipmentByType(string $type) {
        if($type == 'All devices'){
                $query = $this->database->connect()->prepare("
                SELECT * FROM public.equipment
            ");

            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        $query = $this->database->connect()->prepare('
            SELECT * FROM public.equipment WHERE type = :search
        ');
        $query->bindParam(':search', $type, PDO::PARAM_STR);
        $query->execute();
        

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEquipmentBySerialNumber(string $serialNumber) {

        $query = $this->database->connect()->prepare("
            SELECT * FROM public.equipment WHERE serial_number = :search
        ");
        $query->bindParam(':search', $serialNumber, PDO::PARAM_STR);
        $query->execute();
        

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveDevice($data) {
        $query = $this->database->connect()->prepare("
            INSERT INTO public.equipment (type, brand, model, serial_number, date_of_purchase, primary_user)
            VALUES (?, ?, ?, ?, ?, ?);
        ");
    
        $query->execute([
            $data["type"],
            $data["brand"],
            $data["model"],
            $data["serial_number"],
            $data["date_of_purchase"],
            $data["primary_user"]
        ]);

        error_log("Dane zostaly dodane do bazy !");
        return;
    }
}