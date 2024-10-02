<?php

require_once 'AppController.php';

class SecurityController extends AppController { 

    private $repository;
    private const TABLE_NAME = "users";

    public function __construct(){
        parent::__construct();
        $this->repository = new Repository();
    }

    public function login() {

        if($this->isGet()) {
            return $this->render('login');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];


        $query = $this->repository->prepareQueryForSelect(SELF::TABLE_NAME, 'email');
        $users = $this->repository->executeQuery($query, SELF::TABLE_NAME, [$email]);
        
        if(empty($users)){
            return $this->render('login', 
                ["message" => "Nie ma takiego uzytkownika!"]);
        }
        
        if ($users[0] instanceof Users) {
            
            $user = $users[0];
            
            if (!password_verify($password, $user->getPassword())){
                return $this->render('login', 
                ["message" => "Niepoprawne haslo!"]);
            }

            $_SESSION['user'] = [
                'username' => $user->getName(),
                'role' => $user->getAccountType(),
                'id' => $user->getId()
            ];
            
            $url = "http://$_SERVER[HTTP_HOST]";

            if($_SESSION['user']['role'] == 'admin'){
                header("Location: {$url}/devicelist");
                exit();
            }
            
            header("Location: {$url}/userView");
            exit();
        } 
        exit();
    }

    public function logout() {
        session_unset();
        session_destroy();
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/login");
        exit();
    }
}