<?php
require_once 'Model.php';

class User {
    private $id;
    private $name;
    private $surname;
    private $account_type;
    private $job_title;
    private $department;
    private $manager;
    private $email;
    private $phone_number;
    private $password;
    private $created_at;

    public function __construct(){}

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function getAccountType() {
        return $this->account_type;
    }

    public function getJobTitle() {
        return $this->job_title;
    }

    public function getDepartment() {
        return $this->department;
    }

    public function getManager() {
        return $this->manager;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPhoneNumber() {
        return $this->phone_number;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

}