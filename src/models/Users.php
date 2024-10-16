<?php
require_once 'Model.php';
require_Once __DIR__.'/../../Database.php';

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

    private $confirm_password;
    private $created_at;

    public function __construct(){
        
    }

    public function getColumnMapping(): array {
        return [
        'id' => 'Id',
        'name' => 'Name',
        'surname' => 'Surname',
        'account_type' => 'Account Type',
        'job_title' => 'Job Title',
        'department' => 'Department',
        'manager' => 'Manager',
        'email' => 'Email',
        'phone_number' => 'Phone Number',
        'password' => 'Password',
        'confirm_password' => 'Confirm Password',
        'created_at' => 'Created At'
        ];
    }

    public function getClassName() {
        return static::class;
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