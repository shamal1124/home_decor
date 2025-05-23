<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    header("Location: ../login.php");
    exit;
}
require_once 'config/db.php';

$clientId = $_SESSION['user_id'];
$view = isset($_GET['view']) && $_GET['view'] === 'history' ? 'history' : 'browse';

// Get all designers for the dropdown
$designerQuery = "SELECT id, name FROM users WHERE role = 'designer'";
$designerResult = $conn->query($designerQuery);

// Get distinct room types (categories)
$categoryQuery = "SELECT DISTINCT room_type FROM designs";
$categoryResult = $conn->query($categoryQuery);

if ($view === 'browse') {
    // Get selected filters
    $selectedDesignerId = isset($_GET['designer_id']) ? intval($_GET['designer_id']) : null;
    $selectedCategory = isset($_GET['category']) ? $_GET['category'] : null;

    // Fetch designs based on filters
    $sql = "SELECT d.*, u.name FROM designs d JOIN users u ON d.designer_id = u.id WHERE 1";

    if ($selectedDesignerId) {
        $sql .= " AND d.designer_id = $selectedDesignerId";
    }

    if (!empty($selectedCategory)) {
        $sql .= " AND d.room_type = '" . $conn->real_escape_string($selectedCategory) . "'";
    }

    $result = $conn->query($sql);
} else {
    // Fetch client request history
    $historyQuery = "SELECT r.*, d.title AS design_title, d.image_url, u.name AS designer_name 
                     FROM requests r 
                     JOIN designs d ON r.design_id = d.id 
                     JOIN users u ON r.designer_id = u.id 
                     WHERE r.client_id = $clientId";
    $historyResult = $conn->query($historyQuery);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Dashboard - Home Decore</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">

<nav style="background-color: #b89a7e; padding: 1rem; color: white; display: flex; justify-content: space-between; align-items: center;">
    <h1 class="text-xl font-semibold">Home Decore - Client</h1>
    <div style="display: flex; gap: 1rem;">
        <a href="client.php?view=history" style="background-color: white; color: #b89a7e; padding: 0.25rem 0.75rem; border-radius: 0.25rem; text-decoration: none;" onmouseover="this.style.backgroundColor='#f5f5f5';" onmouseout="this.style.backgroundColor='white';">History</a>
        <a href="logout.php" style="color: #b89a7e; padding: 0.25rem 0.75rem; border-radius: 0.25rem; background-color: white; text-decoration: none;" onmouseover="this.style.backgroundColor='#f5f5f5';" onmouseout="this.style.backgroundColor='white';">Logout</a>
    </div>
</nav>

<main class="p-6">
    <?php if ($view === 'browse'): ?>
        <h2 class="text-2xl font-bold mb-4">Browse Designer Designs</h2>

        <!-- Filter Form -->
        <form method="GET" action="" class="mb-6 flex flex-col md:flex-row gap-4">
            <input type="hidden" name="view" value="browse">

            <!-- Designer Dropdown -->
            <div>
                <label for="designer_select" class="block text-lg font-semibold">Select Designer:</label>
                <select name="designer_id" id="designer_select" class="mt-1 p-2 border rounded w-full" onchange="this.form.submit()">
                    <option value="">All Designers</option>
                    <?php if ($designerResult->num_rows > 0): ?>
                        <?php while ($designer = $designerResult->fetch_assoc()): ?>
                            <option value="<?= $designer['id'] ?>" <?= ($selectedDesignerId == $designer['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($designer['name']) ?>
                            </option>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </select>
            </div>

            <!-- Room Type Dropdown -->
            <div>
                <label for="category_select" class="block text-lg font-semibold">Select Room Type:</label>
                <select name="category" id="category_select" class="mt-1 p-2 border rounded w-full" onchange="this.form.submit()">
                    <option value="">All Room Types</option>
                    <?php if ($categoryResult->num_rows > 0): ?>
                        <?php while ($categoryRow = $categoryResult->fetch_assoc()): ?>
                            <option value="<?= htmlspecialchars($categoryRow['room_type']) ?>" <?= ($selectedCategory === $categoryRow['room_type']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars(ucfirst($categoryRow['room_type'])) ?>
                            </option>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </select>
            </div>
        </form>

        <!-- Display designs -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php if ($result->num_rows > 0): while ($row = $result->fetch_assoc()): ?>
                <div class="bg-white shadow rounded p-4">
                    <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="Design Image" class="w-full h-40 object-cover rounded mb-3">
                    <h3 class="text-lg font-semibold text-purple-700"><?= htmlspecialchars($row['title']) ?></h3>
                    <p class="text-sm text-gray-600"><?= htmlspecialchars($row['description']) ?></p>
                    <p class="text-sm mt-2">By: <?= htmlspecialchars($row['name']) ?></p>
                    <p class="text-sm italic">Room: <?= htmlspecialchars(ucfirst($row['room_type'])) ?></p>
                    <form action="request_form.php" method="GET" class="mt-3">
                        <input type="hidden" name="design_id" value="<?= $row['id'] ?>">
                        <button type="submit" style="background-color: #b89a7e; color: white; padding: 0.25rem 0.75rem; border-radius: 0.25rem; border: none; cursor: pointer;" onmouseover="this.style.backgroundColor='#a07f6b';" onmouseout="this.style.backgroundColor='#b89a7e';">
                            Request This Design
                        </button>
                    </form>
                </div>
            <?php endwhile; else: ?>
                <p>No designs available for the selected filters.</p>
            <?php endif; ?>
        </div>

    <?php else: ?>
        <h2 class="text-2xl font-bold mb-6">Your Request History</h2>

        <a href="client.php" class="inline-block mb-4 bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
            ← Back to Browse
        </a>

        <?php if ($historyResult->num_rows > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php while ($request = $historyResult->fetch_assoc()): ?>
                    <div class="bg-white shadow p-4 rounded">
                        <img src="<?= htmlspecialchars($request['image_url']) ?>" alt="Design Image" class="w-full h-40 object-cover rounded mb-3">
                        <h3 class="text-lg font-semibold text-purple-700">Design: <?= htmlspecialchars($request['design_title']) ?></h3>
                        <p class="text-sm"><strong>Designer:</strong> <?= htmlspecialchars($request['designer_name']) ?></p>
                        <p class="text-sm"><strong>Status:</strong> <?= htmlspecialchars($request['status'] ?? 'completed') ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-600">You haven't made any requests yet.</p>
        <?php endif; ?>
    <?php endif; ?>
</main>

</body>
</html>
