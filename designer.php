<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'designer') {
    header("Location: ../login.php");
    exit;
}

require_once 'config/db.php';

// Set status to NULL when Done button is clicked
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_id'])) {
    $requestId = intval($_POST['request_id']);
    $updateQuery = "UPDATE requests SET status = NULL WHERE id = $requestId";
    $conn->query($updateQuery);
    header("Location: designer.php");
    exit;
}

// Delete design if requested
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_design_id'])) {
    $designId = intval($_POST['delete_design_id']);
    $deleteQuery = "DELETE FROM designs WHERE id = $designId AND designer_id = {$_SESSION['user_id']}";
    $conn->query($deleteQuery);
    header("Location: designer.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Designer Dashboard - Home Decore</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">

<nav style="background-color: #b89a7e; padding: 16px; color: white; display: flex; justify-content: space-between;">
    <h1 style="font-size: 1.25rem; font-weight: 600;">Home Decore - Designer</h1>
    <a href="logout.php" style="background-color: white; color: #b89a7e; padding: 8px 12px; border-radius: 4px; text-decoration: none;">Logout</a>
</nav>

<main class="p-6">
    <h2 class="text-2xl font-bold mb-4">Your Uploaded Designs</h2>

    <a href="upload_design.php" style="color:white; display: inline-block; margin-bottom: 16px; background-color:#b89a7e; padding: 8px 16px; border-radius: 4px; text-decoration: none;">Upload New Design</a>

    <!-- Display Designs -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php
        $designerId = $_SESSION['user_id'];
        $result = $conn->query("SELECT * FROM designs WHERE designer_id = $designerId");
        while ($row = $result->fetch_assoc()):
        ?>
            <div class="bg-white shadow rounded p-4">
                <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="Design Image" class="w-full h-40 object-cover rounded mb-3">
                <h3 class="text-lg font-semibold text-purple-700"><?= htmlspecialchars($row['title']) ?></h3>
                <p class="text-sm text-gray-600"><?= htmlspecialchars($row['description']) ?></p>
                <p class="text-sm mt-1 mb-3">Room Type: <?= htmlspecialchars($row['room_type']) ?></p>

                <form method="POST" onsubmit="return confirm('Are you sure you want to delete this design?');">
                    <input type="hidden" name="delete_design_id" value="<?= $row['id'] ?>">
                    <button type="submit" class="bg-red-600 text-white px-4 py-1 rounded hover:bg-red-700">Delete</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Display Requests for Designer's Designs -->
    <h2 class="text-2xl font-bold mt-8 mb-4">Requests for Your Designs</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php
        $requests_result = $conn->query("SELECT r.id, c.name AS client_name, d.title AS design_title, d.image_url, r.status 
                                         FROM requests r 
                                         JOIN users c ON r.client_id = c.id 
                                         JOIN designs d ON r.design_id = d.id 
                                         WHERE r.designer_id = $designerId");

        if ($requests_result->num_rows > 0):
            while ($request = $requests_result->fetch_assoc()):
                $status = $request['status'] ?? 'completed';
        ?>
                <div class="bg-white shadow rounded p-4">
                    <img src="<?= htmlspecialchars($request['image_url']) ?>" alt="Design Image" class="w-full h-40 object-cover rounded mb-3">
                    <h3 class="text-lg font-semibold text-purple-700"><?= htmlspecialchars($request['design_title']) ?></h3>
                    <p class="text-sm text-gray-600"><strong>Client:</strong> <?= htmlspecialchars($request['client_name']) ?></p>
                    <p class="text-sm text-gray-600"><strong>Status:</strong> <?= htmlspecialchars($status) ?></p>

                    <!-- Done Button to reset status -->
                    <form action="" method="POST" class="mt-3">
                        <input type="hidden" name="request_id" value="<?= $request['id'] ?>">
                        <button type="submit" class="bg-green-600 text-white px-4 py-1 rounded hover:bg-green-700">
                            Done
                        </button>
                    </form>
                </div>
        <?php
            endwhile;
        else:
            echo '<p class="text-sm text-gray-600">No requests for your designs yet.</p>';
        endif;
        ?>
    </div>
</main>

</body>
</html>
