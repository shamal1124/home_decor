<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    header("Location: ../login.php");
    exit;
}
require_once 'config/db.php';

// Get all designers for the dropdown
$designerQuery = "SELECT id, name FROM users WHERE role = 'designer'";
$designerResult = $conn->query($designerQuery);

// Get the selected designer ID from the GET request
$selectedDesignerId = isset($_GET['designer_id']) ? $_GET['designer_id'] : null;

// Modify SQL query to fetch designs based on selected designer
$sql = "SELECT d.*, u.name FROM designs d JOIN users u ON d.designer_id = u.id";
if ($selectedDesignerId) {
    $sql .= " WHERE d.designer_id = " . intval($selectedDesignerId);
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Dashboard - Home Decore</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">

    <nav class="bg-purple-700 p-4 text-white flex justify-between">
        <h1 class="text-xl font-semibold">Home Decore - Client</h1>
        <a href="logout.php" class="bg-white text-purple-700 px-3 py-1 rounded hover:bg-gray-100">Logout</a>
    </nav>

    <main class="p-6">
        <h2 class="text-2xl font-bold mb-4">Browse Designer Designs</h2>

        <!-- Designer Dropdown -->
        <form method="GET" action="" class="mb-6">
            <label for="designer_select" class="text-lg font-semibold">Select Designer:</label>
            <select name="designer_id" id="designer_select" onchange="this.form.submit()" class="ml-3 p-2 border rounded">
                <option value="">All Designers</option>
                <?php if ($designerResult->num_rows > 0): ?>
                    <?php while ($designer = $designerResult->fetch_assoc()): ?>
                        <option value="<?php echo $designer['id']; ?>" <?php echo ($selectedDesignerId == $designer['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($designer['name']); ?>
                        </option>
                    <?php endwhile; ?>
                <?php endif; ?>
            </select>
        </form>

        <!-- Display designs -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php
            if ($result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
            ?>
                <div class="bg-white shadow rounded p-4">
                    <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="Design Image" class="w-full h-40 object-cover rounded mb-3">
                    <h3 class="text-lg font-semibold text-purple-700"><?= htmlspecialchars($row['title']) ?></h3>
                    <p class="text-sm text-gray-600"><?= htmlspecialchars($row['description']) ?></p>
                    <p class="text-sm mt-2">By: <?= htmlspecialchars($row['name']) ?></p>
                    <form action="request_form.php" method="GET" class="mt-3">
                        <input type="hidden" name="design_id" value="<?= $row['id'] ?>">
                        <button type="submit" class="bg-purple-600 text-white px-4 py-1 rounded hover:bg-purple-700">
                            Request This Design
                        </button>
                    </form>
                </div>
            <?php endwhile; ?>
            <?php else: ?>
                <p>No designs available for the selected designer.</p>
            <?php endif; ?>
        </div>
    </main>

</body>
</html>
