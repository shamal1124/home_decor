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

<nav style="background-color: #b89a7e; padding: 16px; color: white; display: flex; justify-content: space-between;">
    <h1 style="font-size: 1.25rem; font-weight: 600;">Home Decore - Client</h1>
    <a href="logout.php" style="background-color: white; color: #b89a7e; padding: 8px 12px; border-radius: 4px; text-decoration: none;">Logout</a>
</nav>

<main class="p-6">
    <h2 class="text-2xl font-bold mb-4">Request Design</h2>

    <!-- Back to Browse Button -->
    <a href="client.php" style="display: inline-block; margin-bottom: 16px; background-color: #b89a7e; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none;">
        ← Back to Browse
    </a>

    <div class="bg-white shadow rounded p-6">
        <h3 class="text-lg font-semibold text-purple-700"><?= htmlspecialchars($design['title']) ?></h3>
        <p class="text-sm text-gray-600"><?= htmlspecialchars($design['description']) ?></p>
        <img src="<?= htmlspecialchars($design['image_url']) ?>" alt="Design Image" class="w-full h-64 object-cover rounded mb-3">
        <p><strong>Designer:</strong> <?= htmlspecialchars($design['designer_name']) ?></p>

        <form action="request_form.php" method="POST" class="mt-4">
            <input type="hidden" name="design_id" value="<?= $design_id ?>">
            <button type="submit" style="background-color: #b89a7e; color: white; padding: 8px 16px; border-radius: 4px; border: none; cursor: pointer;">
                Confirm Request
            </button>
        </form>
    </div>
</main>

</body>
</html>