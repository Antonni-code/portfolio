<?php
session_start();

$dsn = "mysql:host=localhost;dbname=antonni";
$username = "root";
$password = "";
try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM user WHERE email = :email";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            if ($password === $user['password']) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['STATUS'] = "LOGIN_SUCCESS";
                header("Location: ../admin/index.php");
                exit();
            } else {
                header("Location: login.php?error=Invalid email or password");
                exit();
            }
        } else {
            header("Location: login.php?error=User not found");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage(); 
        exit();
    }
}
$pdo = null;
?>
