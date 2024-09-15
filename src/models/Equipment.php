<?php
require_once 'Model.php';

class Equipment extends Model{
    public $id;
    public $type;
    public $brand;
    public $model;
    public $serial_number;
    public $date_of_purchase;
    public $primary_user;

    
    private static $basePath = 'images/icons/';

    public function __construct(
        $id = null,
        $type = null,
        $brand = null,
        $model = null,
        $serial_number = null,
        $date_of_purchase = null,
        $primary_user = null
    ) {
        $this->id = $id;
        $this->type = $type;
        $this->brand = $brand;
        $this->model = $model;
        $this->serial_number = $serial_number;
        $this->date_of_purchase = $date_of_purchase;
        $this->primary_user = $primary_user;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'brand' => $this->brand,
            'model' => $this->model,
            'serial_number' => $this->serial_number,
            'date_of_purchase' => $this->date_of_purchase,
            'primary_user' => $this->primary_user
        ];
    }

    
    public function getColumnMapping(): array {
        return [
        'id' => 'Id',
        'type' => 'Type',
        'brand' => 'Brand',
        'model' => 'Model',
        'serial_number' => 'SerialNumber',
        'date_of_purchase' => 'DateOfPurchase',
        'primary_user' => 'PrimaryUser'  
        ];
    }

    // getters
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
        return self::$basePath . $this->type . '.png';
    }

    // setters
    // public function setId($id) {
    //     $this->id = $id;
    // }

    public function setType($type) {
        $this->type = $type;
    }

    public function setBrand($brand) {
        $this->brand = $brand;
    }

    public function setModel($model) {
        $this->model = $model;
    }

    public function setSerialNumber($serial_number) {
        $this->serial_number = $serial_number;
    }

    public function setDateOfPurchase($date_of_purchase) {
        $this->date_of_purchase = $date_of_purchase;
    }

    public function setPrimaryUser($primary_user) {
        $this->primary_user = $primary_user;
    }
}