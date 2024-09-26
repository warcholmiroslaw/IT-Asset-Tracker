<?php
require_once 'Model.php';

class Users extends Model{
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

    public function __construct(){
        
    }

    public function getColumnMapping(): array {
        return [
        'id' => 'Id',
        'name' => 'Name',
        'surname' => 'Surname',
        'account_type' => 'AccountType',
        'job_title' => 'JobTitle',
        'department' => 'Department',
        'manager' => 'Manager',
        'email' => 'Email',
        'phone_number' => 'PhoneNumber',
        'password' => 'Password',
        'created_at' => 'CreatedAt'
        ];
    }


    public function findUserByEmail ($email) {

    }
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