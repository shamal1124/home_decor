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
    header("Location: designer.php"); // Refresh the page to reflect changes
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

    <nav class="bg-purple-700 p-4 text-white flex justify-between">
        <h1 class="text-xl font-semibold">Home Decore - Designer</h1>
        <a href="logout.php" class="bg-white text-purple-700 px-3 py-1 rounded hover:bg-gray-100">Logout</a>
    </nav>

    <main class="p-6">
        <h2 class="text-2xl font-bold mb-4">Your Uploaded Designs</h2>

        <a href="upload_design.php" class="mb-4 inline-block bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">Upload New Design</a>

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
                    <p class="text-sm mt-1">Room Type: <?= htmlspecialchars($row['room_type']) ?></p>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Display Requests for Designer's Designs -->
        <h2 class="text-2xl font-bold mt-8 mb-4">Requests for Your Designs</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php
            // Fetch requests made for this designer's designs
            $requests_result = $conn->query("SELECT r.id, c.name AS client_name, d.title AS design_title, r.status FROM requests r JOIN users c ON r.client_id = c.id JOIN designs d ON r.design_id = d.id WHERE r.designer_id = $designerId");

            if ($requests_result->num_rows > 0):
                while ($request = $requests_result->fetch_assoc()):
                    // Handle NULL status, and display a default status if it's NULL
                    $status = $request['status'] ?? 'completed';
            ?>
                    <div class="bg-white shadow rounded p-4">
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
