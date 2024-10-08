<?php
require_once 'Model.php';

class Equipment extends Model{
    public $id;
    public $type;
    public $brand;
    public $model;
    public $serial_number;
    public $purchase_date;
    public $primary_user;

    
    private static $basePath = 'images/icons/';

    public function __construct(
        $id = null,
        $type = null,
        $brand = null,
        $model = null,
        $serial_number = null,
        $purchase_date = null,
        $primary_user = null
    ) {
        $this->id = $id;
        $this->type = $type;
        $this->brand = $brand;
        $this->model = $model;
        $this->serial_number = $serial_number;
        $this->purchase_date = $purchase_date;
        $this->primary_user = $primary_user;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'brand' => $this->brand,
            'model' => $this->model,
            'serial_number' => $this->serial_number,
            'purchase_date' => $this->purchase_date,
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
        'purchase_date' => 'PurchaseDate',
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

    public function getPurchaseDate() {
        return $this->purchase_date;
    }

    public function getImage() {
        return self::$basePath . $this->type . '.png';
    }

    public function getPrimaryUser() {
        return $this->primary_user;
    }
}