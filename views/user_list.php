<?php
require_once __DIR__ . '/../controllers/UserController.php';

$userController = new UserController();
$users = $userController->getUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User List</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <h1 style="text-align:center;">User List</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>action</th>
        </tr>

        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']); ?></td>
                    <td><?= htmlspecialchars($user['name']); ?></td>
                    <td><?= htmlspecialchars($user['email']); ?></td>
                    <td><a href="delete.php">Delete</a></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="3" style="text-align:center;">No users found</td></tr>
        <?php endif; ?>
    </table>
    <a href="create.php">Add User</a>

</body>
</html>
