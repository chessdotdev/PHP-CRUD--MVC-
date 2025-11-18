<?php 
require_once __DIR__ . '/../controllers/UserController.php';

$userController = new UserController();
$users = $userController->deleteUser($id);
// var_dump($users);