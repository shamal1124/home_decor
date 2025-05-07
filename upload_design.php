<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'designer') {
    header("Location: ../login.php");
    exit;
}

// Include Cloudinary config and DB connection
require_once __DIR__ . '/logic/cloudinary_config.php';
require_once __DIR__ . '/config/db.php'; // Adjust if your DB config path differs

use Cloudinary\Api\Upload\UploadApi;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $room_type = $_POST['room_type'];
    $designer_id = $_SESSION['user_id'];
    $image = $_FILES['image'];

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($image['type'], $allowedTypes)) {
        $error = "Only JPG, PNG, and GIF images are allowed.";
    } else {
        try {
            $uploadedImage = (new UploadApi())->upload($image['tmp_name'], [
                'folder' => 'home_decore/designs',
                'public_id' => uniqid()
            ]);

            $imageUrl = $uploadedImage['secure_url'];

            $stmt = $conn->prepare("INSERT INTO designs (title, description, room_type, designer_id, image_url) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssis", $title, $description, $room_type, $designer_id, $imageUrl);
            
            if ($stmt->execute()) {
                $success = "Design uploaded successfully!";
            } else {
                $error = "Error uploading design. Please try again.";
            }
        } catch (Exception $e) {
            $error = "Cloudinary upload failed: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Design - Home Decore</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">

<nav class="bg-purple-700 p-4 text-white flex justify-between" style="background-color: #b89a7e;">
    <h1 class="text-xl font-semibold">Home Decore - Designer</h1>

    <a href="logout.php" class="bg-white text-purple-700 px-3 py-1 rounded hover:bg-gray-100">Logout</a>
</nav>
<br>
<a href="designer.php" class="bg-white text-purple-700 px-3 py-1 rounded hover:bg-gray-100">Back</a>
<main class="p-6">
    <h2 class="text-2xl font-bold mb-4">Upload a New Design</h2>

    <?php if (isset($error)): ?>
        <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php elseif (isset($success)): ?>
        <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <form action="upload_design.php" method="POST" enctype="multipart/form-data">
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Design Title</label>
            <input type="text" id="title" name="title" class="w-full p-3 border border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea id="description" name="description" class="w-full p-3 border border-gray-300 rounded" rows="4" required></textarea>
        </div>

        <div class="mb-4">
            <label for="room_type" class="block text-sm font-medium text-gray-700">Room Type</label>
            <select id="room_type" name="room_type" class="w-full p-3 border border-gray-300 rounded" required>
                <option value="kitchen">Kitchen</option>
                <option value="hall">Hall</option>
                <option value="bedroom">Bedroom</option>
                <option value="living_room">Living Room</option>
                <option value="bathroom">Bathroom</option>
                <option value="office">Office</option>
                <option value="other">Other</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-gray-700">Design Image</label>
            <input type="file" id="image" name="image" class="w-full p-3 border border-gray-300 rounded" required>
        </div>

        <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded hover:bg-purple-700" style="background-color: #b89a7e;">Upload Design</button>
    </form>
</main>

</body>
</html>
