<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    header("Location: login.php");
    exit;
}

require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['design_id'])) {
    // Form submitted
    $design_id = intval($_POST['design_id']);
    $client_id = $_SESSION['user_id'];

    // Fetch design, designer details
    $stmt = $conn->prepare("SELECT d.title, d.description, d.image_url, d.designer_id, u.name AS designer_name FROM designs d JOIN users u ON d.designer_id = u.id WHERE d.id = ?");
    $stmt->bind_param("i", $design_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $design = $result->fetch_assoc();

    if (!$design) {
        echo "Design not found.";
        exit;
    }

    $designer_id = $design['designer_id'];

    // Insert request into requests table
    $stmt = $conn->prepare("INSERT INTO requests (client_id, design_id, designer_id, status) VALUES (?, ?, ?, 'pending')");
    $stmt->bind_param("iii", $client_id, $design_id, $designer_id);

    if ($stmt->execute()) {
        header("Location: request_success.php");
        exit;
    } else {
        echo "Failed to insert request.";
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['design_id'])) {
    // Show form to confirm request
    $design_id = intval($_GET['design_id']);

    $stmt = $conn->prepare("SELECT d.title, d.description, d.image_url, u.name AS designer_name FROM designs d JOIN users u ON d.designer_id = u.id WHERE d.id = ?");
    $stmt->bind_param("i", $design_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $design = $result->fetch_assoc();

    if (!$design) {
        echo "Design not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Request Design - Home Decore</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">

<nav class="bg-purple-700 p-4 text-white flex justify-between">
    <h1 class="text-xl font-semibold">Home Decore - Client</h1>
    <a href="logout.php" class="bg-white text-purple-700 px-3 py-1 rounded hover:bg-gray-100">Logout</a>
</nav>

<main class="p-6">
    <h2 class="text-2xl font-bold mb-4">Request Design</h2>

    <div class="bg-white shadow rounded p-6">
        <h3 class="text-lg font-semibold text-purple-700"><?= htmlspecialchars($design['title']) ?></h3>
        <p class="text-sm text-gray-600"><?= htmlspecialchars($design['description']) ?></p>
        <img src="<?= htmlspecialchars($design['image_url']) ?>" alt="Design Image" class="w-full h-64 object-cover rounded mb-3">
        <p><strong>Designer:</strong> <?= htmlspecialchars($design['designer_name']) ?></p>

        <form action="request_form.php" method="POST" class="mt-4">
            <input type="hidden" name="design_id" value="<?= $design_id ?>">
            <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                Confirm Request
            </button>
        </form>
    </div>
</main>

</body>
</html>
