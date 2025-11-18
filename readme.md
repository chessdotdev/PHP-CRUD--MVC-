1️⃣ Directory Structure (refactored)
php-crud/
│
├── config/
│   └── database.php       # Database connection
│
├── controllers/
│   └── UserController.php # Handles logic
│
├── models/
│   └── User.php           # Database interactions
│
├── views/
│   ├── user_create.php    # Display add user form
│   └── user_list.php      # Display list of users
│
├── public/                # All requests go through here
│   ├── index.php          # User list page
│   └── create.php         # Add user page
│   └── css/
│       └── style.css

2️⃣ Model (unchanged, just minor fixes)

models/User.php:

<?php
require_once __DIR__ . '/../config/database.php';

class User
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function create($name, $email)
    {
        $sql = "INSERT INTO users(name, email) VALUES(:name, :email)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);

        return $stmt->execute();
    }

    public function read()
    {
        $sql = "SELECT * FROM users";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // fixed typo fetchALl → fetchAll
    }
}


✅ Improvement: Fix fetchALl typo → fetchAll.

3️⃣ Controller

controllers/UserController.php:

<?php
require_once __DIR__ . '/../models/User.php';

class UserController
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function createUser($name, $email)
    {
        return $this->user->create($name, $email);
    }

    public function getUsers()
    {
        return $this->user->read();
    }
}


✅ Improvement: Instantiate the model once in the constructor. Cleaner and avoids multiple instances.

4️⃣ Public Files (handles requests)
public/index.php (User list)
<?php
require_once __DIR__ . '/../controllers/UserController.php';

$controller = new UserController();
$users = $controller->getUsers();

require_once __DIR__ . '/../views/user_list.php';

public/create.php (Add user)
<?php
require_once __DIR__ . '/../controllers/UserController.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    $controller = new UserController();
    $success = $controller->createUser($name, $email);

    $message = $success ? 'User added successfully' : 'Failed to add user';
}

require_once __DIR__ . '/../views/user_create.php';


✅ Improvement: Public files handle requests and pass data to views. Views never call controllers.

5️⃣ Views
views/user_list.php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User List</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1 style="text-align:center;">User List</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" style="text-align:center;">No users found</td>
            </tr>
        <?php endif; ?>
    </table>
    <a href="create.php">Add User</a>
</body>
</html>

views/user_create.php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add User</title>
    <link rel="stylesheet" href="css/style.css">
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


✅ Improvement: Views never call controllers, only use the data passed by public files.