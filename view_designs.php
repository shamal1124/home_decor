<?php
require_once 'config/db.php';

// Get all designers for the dropdown
$designerQuery = "SELECT id, name FROM users WHERE role = 'designer'";
$designerResult = $conn->query($designerQuery);

// If a designer is selected, fetch their designs
$selectedDesignerId = isset($_GET['designer_id']) ? $_GET['designer_id'] : null;

$sql = "SELECT d.id, d.title, d.description, d.image_url, u.name AS designer_name
        FROM designs d
        JOIN users u ON d.designer_id = u.id";
if ($selectedDesignerId) {
    $sql .= " WHERE d.designer_id = " . intval($selectedDesignerId);
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Designs - Home Decore</title>
    <!-- Optional -->
   
    <style>
        .design-card {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            max-width: 600px;
        }
        .design-card img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .design-card h3 {
            margin-top: 0;
        }
        .design-card form {
            margin-top: 10px;
        }
        .btn-request {
            background-color: purple;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn-request:hover {
            background-color: darkmagenta;
        }
        .filter-form {
            margin-bottom: 20px;
        }
        select {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <nav style="background-color: #b89a7e; padding: 1rem; color: white; display: flex; justify-content: space-between;">
    <h1 style="font-size: 1.25rem; font-weight: 600;">Home Decore - Client</h1>
    <a href="index.php" style="background-color: white; color: #b89a7e; padding: 0.25rem 0.75rem; border-radius: 0.25rem; text-decoration: none; height:30px;" >Back</a>
</nav>
    <header class="bg-purple-700 text-white py-4">
        <div class="max-w-screen-xl mx-auto flex justify-between items-center">
            <!-- <h1 class="text-3xl font-semibold">Home Decore</h1> -->
            <div>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="logout.php" class="bg-purple-500 px-4 py-2 rounded hover:bg-purple-600">Logout</a>
                <?php else: ?>
                    <!-- <a href="index.php" class="bg-purple-500 px-4 py-2 rounded hover:bg-purple-600">Back</a> -->
                <?php endif; ?>
            </div>
        </div>
    </header>

    <h2>Available Designs</h2>

    <!-- Designer Filter Dropdown -->
    <form class="filter-form" method="GET" action="">
        <label for="designer_select" class="text-lg font-semibold">Select Designer:</label>
        <select name="designer_id" id="designer_select" onchange="this.form.submit()">
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

    <?php
    // Display the designs based on the selected designer
    if ($result->num_rows > 0):
        while ($row = $result->fetch_assoc()):
    ?>
        <div class="design-card">
            <h3><?php echo htmlspecialchars($row['title']); ?></h3>
            <p><strong>Designer:</strong> <?php echo htmlspecialchars($row['designer_name']); ?></p>
            <p><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
            <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="Design Image">
            <form action="request_design.php" method="POST">
                <input type="hidden" name="design_id" value="<?php echo $row['id']; ?>">

            </form>
        </div>
    <?php
        endwhile;
    else:
        echo "<p>No designs available for the selected designer.</p>";
    endif;

    $conn->close();
    ?>

</body>
</html>