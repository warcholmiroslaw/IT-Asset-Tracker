<?php

class Ownership extends Model {
        public $id;
        public $equipment_id;
        public $user_id;
        public $assigned_at;
        public $returned_at;
        public $status;

    public function __construct($equipment_id, $user_id, $assigned_at, $status = 'active') {
        $this->equipment_id = $equipment_id;
        $this->user_id = $user_id;
        $this->assigned_at = $assigned_at;
        $this->status = $status;
    }

    public function returnEquipment($returned_at = null) {
        $this->returned_at = $returned_at ?? date('Y-m-d H:i:s');
        $this->status = 'returned';
    }

    public function getColumnMapping(): array {
        return [
            'id' => 'Id',
            'equipment_id' => 'EquipmentId',
            'user_id' => 'UserId',
            'assigned_at' => 'AssignedAt',
            'returned_at' => 'ReturnedAt',
            'status' => 'Status'
        ];
    }

}