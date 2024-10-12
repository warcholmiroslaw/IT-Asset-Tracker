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
}