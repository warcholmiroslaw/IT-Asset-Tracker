<?php

require_once __DIR__.'/../../Database.php';
require_once __DIR__.'/../models/Equipment.php';
require_once __DIR__.'/../models/Users.php';

class Repository {
    protected $database;

    public function __construct()
    {
        $this->database = new Database();
    }


    public function createOrUpdateRow(string $action, $object, $key = null, $param = null)
    {   
        $tableName = strtolower(get_class($object));
        $attributes = $object->getAttributes();

        $columnMapping = $object->getColumnMapping(); // ex. serial_number -> SerialNumber

        $columns = [];
        $placeholders = [];
        $values = [];

        foreach ($attributes as $attribute) {
            
            $getterMethod = 'get' . $columnMapping[$attribute];

            $value = $object->$getterMethod();
            
            if ($value !== null) {
                $columns[] = $attribute;
                $placeholders[] = '?';
                $values[] = $value;
            }
        }
        $columnsString = implode(", ", $columns);

        $placeholdersString = implode(", ", $placeholders);
        if($action == "UPDATE"){
            $sql = "UPDATE public.{$tableName} SET ({$columnsString}) = ($placeholdersString) WHERE {$key} = $param";
        }
        else if ($action == "CREATE"){
            $sql = "INSERT INTO $tableName ($columnsString) VALUES ($placeholdersString)";
        }
        return $this->executeQuery($sql, $tableName, $values);
    }


    public function prepareQueryForSelectAll(string $object){
        return "SELECT * FROM public.{$object}";
    }

    public function prepareQueryForSelect(string $object, string $attribute): string {
        return "SELECT * FROM public.{$object} WHERE {$attribute} = :value";
    }

    public function prepareQueryToDelete(string $object, string $attribute)
    {
        return "DELETE FROM public.{$object} WHERE {$attribute} = :value";
    }



    public function executeQuery(string $query, string $object, array $params = []) 
    {

        $preparedQuery = $this->database->connect()->prepare($query);

        if ($preparedQuery === false) {
            return false;
        }

        if (!$preparedQuery->execute($params)) {
            return false;
        }

        if (stripos($query, 'SELECT') === 0) {
            // If SELECT is on the front of query it will pass condition 
            return $preparedQuery->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $object);
        } else {
            // FOR UPDATE DELETE and INSERT
            return $preparedQuery->rowCount();
        }
    }

}
