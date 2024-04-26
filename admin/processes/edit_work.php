<?php
session_start();
try {
    if (isset($_POST['submit'])) {
        if (!empty($_POST['workName']) && !empty($_POST['workDescription']) && isset($_POST['workId'])) {
            $pdo = new PDO("mysql:host=localhost;dbname=antonni", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("UPDATE works SET name = :name, description = :description WHERE id = :id");
            $stmt->bindParam(':name', $_POST['workName']);
            $stmt->bindParam(':description', $_POST['workDescription']);
            $stmt->bindParam(':id', $_POST['workId']);
            $stmt->execute();
            $pdo = null;
            $_SESSION['STATUS'] = "EDIT_SUCCESS";
            header("Location: ../index.php");
            exit();
        } else {
            echo "All fields are required.";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
