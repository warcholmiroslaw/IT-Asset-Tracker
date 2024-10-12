<?php

require_once 'AppController.php';

class SecurityController extends AppController { 

    public function __construct(){
        parent::__construct();
    }

    public function login() {

        if($this->isGet()) {
            $this->render('login');
            exit();
        }

        $email = $_POST['email'];
        $password = $_POST['password'];


        $user = $this->userRepository->loginCheck($email);
        
        if(empty($user)){
            $this->render('login',
                ["title" => "Login",
                "message" => "Nie ma takiego uzytkownika!"]);
            exit();
        }
        
        if ($user instanceof Users) {
            
            if (!password_verify($password, $user->getPassword())){

                $this->render('login',
                ["title" => "Login",
                "message" => "Niepoprawne haslo!"]);
                exit();
            }

            $_SESSION['user'] = [
                'username' => $user->getName(),
                'role' => $user->getAccountType(),
                'id' => $user->getId()
            ];
            
            $url = "http://$_SERVER[HTTP_HOST]";

            if($_SESSION['user']['role'] == 'admin'){
                header("Location: {$url}/deviceList");
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