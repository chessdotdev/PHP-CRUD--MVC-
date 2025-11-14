<?php
include_once('../models/user.php');

class UserController
{
    // private $user;

    // public function __construct($user){
    //     $this->user = new User;
    // }
   


    public function createUser($name, $email)
    {
        $user = new User;
        return $user->create($name, $email);
    }

    public function getUsers()
    {
        $user = new User();
        return $user->read();
    }

    public function updateUser($id, $name, $email)
    {
        $user = new User();
        return $user->update($id, $name, $email);
    }

    public function deleteUser($id)
    {
        $user = new User();
        return $user->delete($id);
    }

}

// $userController = new UserController();

// $userController->getUser();