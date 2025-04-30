<?php
require '../config/db.php';
require 'cloudinary_config.php';

use Cloudinary\Api\Upload\UploadApi;

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $room_type = $_POST['room_type'];
    $designer_id = $_SESSION['user_id'];

    // Cloudinary upload
    $imageTmpPath = $_FILES['design_image']['tmp_name'];

    try {
        $response = (new UploadApi())->upload($imageTmpPath, [
            'folder' => 'home_decore/designs'
        ]);

        $imageUrl = $response['secure_url'];

        // Insert into database
        $stmt = $pdo->prepare("INSERT INTO designs (designer_id, image_path, title, description, room_type) 
                               VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$designer_id, $imageUrl, $title, $desc, $room_type]);

        header("Location: ../designer_dashboard.php?upload=success");
    } catch (Exception $e) {
        echo "Upload failed: " . $e->getMessage();
    }
}
?>
