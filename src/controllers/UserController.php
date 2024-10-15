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

            $response = [];

            $managerName = $_POST["manager"];

            $managerId = $this->userRepository->ifUserExists($managerName);
            if ($managerId) {
                $_POST['manager'] = $managerId;
                $uniqueUser = $this->userRepository->loginCheck($_POST['email']);

                $_POST['account_type'] = 'user';
                // if user doesn't exists add new user to database
                if (!$uniqueUser) {

                    $this->userRepository->createUser($_POST);
                } else {
                    $response['email'] = "User with this email already exists!";
                }

                $url = "http://$_SERVER[HTTP_HOST]";
                header("Location: {$url}/login");
                exit();
            } else {
                $response['manager'] = "This manager doesn't exist!";

                $this->render('signUp', [
                    "title" => "Sign Up",
                    "user" => new Users(),
                    "errors" => $response
                ]);
            }
            exit();
        }

        $this->render('signUp', [
            "title" => "Sign Up",
            "user" => new Users()
        ]);
        exit();
    }

}
