<?php

class Equipment {
    private $id;
    private $type;
    private $brand;
    private $model;
    private $serial_number;
    private $date_of_purchase;
    private $primary_user;

    public function __construct() {
        
    }

    public function getType() {
        return $this->type;
    }

    public function getId() {
        return $this->id;
    }

    public function getBrand() {
        return $this->brand;
    }

    public function getModel() {
        return $this->model;
    }

    public function getSerialNumber() {
        return $this->serial_number;
    }

    public function getDateOfPurchase() {
        return $this->date_of_purchase;
    }

    public function getPrimaryUser() {
        return $this->primary_user;
    }

    public function getImage() {
        switch($this->getType()) {
            case "Desktop":
                return 'images/icons/desktop.png';
            case "Laptop":
                return 'images/icons/laptop.png';
            case "Smartphone":
                return 'images/icons/phone.png';
            default:
                return '';
        }
    }
}
