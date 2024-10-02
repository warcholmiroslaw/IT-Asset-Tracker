<?php

require_once 'AppController.php';
require_once __DIR__."/../../Database.php";

class OwnershipController extends AppController{

    protected $repository;
    protected $phoneLifeCycle = 2;
    protected $desktopLifeCycle = 2;
    protected $laptopLifeCycle = 3;

    public function __construct(){
        parent::__construct();
        $this->repository = new Database();
    }


    public function getUserDevices(){
        $user_id = $_SESSION['user']['id'];
        $query ="Select u.name,
                    u.surname,
                    e.type, 
                    e.brand, 
                    e.model,
                    e.serial_number,
                    o.assigned_at,
                    e.date_of_purchase
                FROM ownership o
                    JOIN equipment e ON e.id = o.equipment_id
                    JOIN users u ON u.id = o.user_id
                where u.id = {$user_id}";

        $preparedQuery = $this->repository->connect()->prepare($query);

        if ($preparedQuery === false) {
            return false;
        }

        if (!$preparedQuery->execute()) {
            return false;
        }

        // If SELECT is on the front of query it will pass condition 
        return $preparedQuery->fetchAll(PDO::FETCH_ASSOC);
    }

    public function calculateDates ($devices) {
        foreach($devices as &$device){
            switch($device['type']){
                case "phone":
                    $amortizationPeriod = $this->phoneLifeCycle;
                case "laptop":
                    $amortizationPeriod = $this->laptopLifeCycle;
                case "desktop":
                    $amortizationPeriod = $this->desktopLifeCycle;         
            };



            $endOfAmortization = (new DateTime($device["date_of_purchase"]))->add(new DateInterval("P{$amortizationPeriod}Y"));
            $device["replacement_date"] = $endOfAmortization->format('Y-m-d');;
            
            if ($endOfAmortization < new DateTime()) {
                $device["time_to_replacement"] = 'Replace your device now !';
            } else {
                $device["time_to_replacement"] = (new DateTime())->diff($endOfAmortization)->days . " days";
            }
        }
        return $devices;
    }
}