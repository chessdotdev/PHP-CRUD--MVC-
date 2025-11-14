<?php
require_once __DIR__ . '/../controllers/UserController.php';
$message = '';
if($_SERVER['REQUEST_METHOD'] === "POST")
{
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    
    $userController = new UserController();
    $users = $userController->createUser($name, $email);
    
   if($users){
     $message = "User added successfully";

   }else{
     $message = "Failed to add user";

   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add User</title>
</head>
<body>
    <h2>Add User</h2>
    <form action="" method="POST">
        <label>Name:</label><br>
        <input type="text" name="name" required><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <button type="submit">Save</button>

    </form>
    <?php if (!empty($message)): ?>
    <p><?= $message ?></p>
<?php endif; ?>
    <a href="index.php">User List</a>
</body>
</html>
