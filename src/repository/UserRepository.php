<?php

require_once __DIR__ . '/../../Database.php';
class UserRepository extends Database
{
    protected $database;


    public function __construct()
    {
        $this->database = new Database();
    }

    // return userID if user exists or false
    public function ifUserExists($fullName){
        list($name, $surname) =  explode(' ', $fullName, 2);
        $statement = $this->database->connect()->prepare("SELECT * FROM ". self::USERS_TABLE." WHERE name = :name AND surname = :surname");
        $statement->bindValue(":name", $name, PDO::PARAM_STR);
        $statement->bindValue(":surname", $surname, PDO::PARAM_STR);

        $statement->execute();
        $user = $statement->fetchObject( self::USERS_TABLE);

        if ($user) {
            return $user->getId();
        }
        return false;

}
    public function loginCheck($email){
        $statement = $this->database->connect()->prepare("SELECT * FROM ". self::USERS_TABLE." WHERE email = :email;");
        $statement->bindValue(":email", $email, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchObject( self::USERS_TABLE);
    }

    public function createUser($newUser){
        $statement = $this->database->connect()->prepare("
            INSERT INTO users (name, surname, account_type, job_title, department, manager, phone_number, email, password)
            VALUES (:name, :surname, :account_type, :job_title, :department, :manager, :phone_number, :email, :password)
        ");
        $newUser['password'] = $this->hashPassword($newUser['password']);

//        echo $newUser;
        $statement->bindParam(':name', $newUser['name']);
        $statement->bindParam(':surname', $newUser['surname']);
        $statement->bindParam(':account_type', $newUser['account_type']);
        $statement->bindParam(':job_title', $newUser['job_title']);
        $statement->bindParam(':department', $newUser['department']);
        $statement->bindParam(':manager', $newUser['manager']);
        $statement->bindParam(':phone_number', $newUser['phone_number']);
        $statement->bindParam(':email', $newUser['email']);
        $statement->bindParam(':password', $newUser['password']);
        $statement->execute();
    }

    private function hashPassword($password){
        return password_hash($password, PASSWORD_DEFAULT);
    }

}