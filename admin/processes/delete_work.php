<?php
include('../includes/conn.php');
session_start();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $stmt = $conn->prepare("DELETE FROM works WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $_SESSION['STATUS'] = "DEL_SUCCESS";
            header("Location: ../index.php");
        } else {
            echo "No artwork found with ID $id.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No ID parameter provided.";
}

$conn = null;
?>
