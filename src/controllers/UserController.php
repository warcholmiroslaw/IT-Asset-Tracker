<?php

require_once 'AppController.php';
require_once 'OwnershipController.php';
require_once __DIR__ . '/../models/Users.php';
require_once __DIR__ . '/../../Database.php';


class UserController extends AppController
{

    public function signUp()
    {
        if ($this->isPost()) {
            $managerName = $_POST["manager"];

            $managerId = $this->userRepository->ifUserExists($managerName);
            $uniqueUser = $this->userRepository->loginCheck($_POST['email']);
            if ($managerId) {
                $_POST['account_type'] = 'user';
            }
            else {
                $response['manager'] = "This manager doesn't exist!";
            }

            if (!$uniqueUser) {
                if($managerId) {
                    $_POST['manager'] = $managerId;
                    $this->userRepository->createUser($_POST);
                    $this->render('login', [
                        "title" => "Login",
                        "message" => "User created !"
                    ]);
                    exit();
                }
            }
            else{
                $response['email'] = "User with this email already exists!";
            }

            $this->render('signUp', [
                "title" => "Sign Up",
                "user" => new Users(),
                "errors" => $response
            ]);
            exit();
        }

        // if get
        $this->render('signUp', [
            "title" => "Sign Up",
            "user" => new Users()
        ]);
        exit();
    }

}
