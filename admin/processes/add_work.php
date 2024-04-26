<?php
// Check if form is submitted
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    include('../includes/conn.php');

    // Get form data
    $workName = $_POST['workName'];
    $workDescription = $_POST['workDescription'];

    // File upload handling
    $targetDir = "../external/uploads/"; // Directory where files will be uploaded
    $targetFile = $targetDir . basename($_FILES["workPicture"]["name"]); // Path of the uploaded file
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION)); // File extension
    $file = basename($_FILES["workPicture"]["name"]);
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["workPicture"]["tmp_name"]);
    if ($check !== false) {
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }


    // Upload file if everything is ok
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["workPicture"]["tmp_name"], $targetFile)) {
            // Insert data into database
            $sql = "INSERT INTO works (name, image, description) VALUES (:name, :picture, :description)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $workName);
            $stmt->bindParam(':picture', $file);
            $stmt->bindParam(':description', $workDescription);
            $stmt->execute();
            $_SESSION['STATUS'] = "UPLOAD_SUCCESS";
            header("Location: ../index.php");
            echo "The file " . htmlspecialchars(basename($_FILES["workPicture"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
} else {
    // Redirect to form if accessed directly
}
?>