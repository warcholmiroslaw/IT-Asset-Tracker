<?php

abstract class Model {

    const RULE_REQUIRED = 'required';
    const RULE_EMAIL = 'email';
    const RULE_UNIQUE = 'unique';
    const RULE_EXISTS = 'exists';

    abstract public function getColumnMapping();

    public function getAttributes(): array {
        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);
        $attributes = [];

        foreach ($properties as $property) {
    
            if (!$property->isStatic()) {
                $attributes[] = $property->getName();
            }
        }

        return $attributes;
    }

    public function loadData($data){
        foreach ($data as $key => $value){
            if (property_exists($this, $key)){
                $this->{$key} = $value;
            }
        }
    }
}