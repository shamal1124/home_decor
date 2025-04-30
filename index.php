<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Decore</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">

    <!-- Header -->
    <header class="bg-purple-700 text-white py-4">
        <div class="max-w-screen-xl mx-auto flex justify-between items-center">
            <h1 class="text-3xl font-semibold">Home Decore</h1>
            <div>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="logout.php" class="bg-purple-500 px-4 py-2 rounded hover:bg-purple-600">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="bg-purple-500 px-4 py-2 rounded hover:bg-purple-600">Login</a>
                    <a href="signup.php" class="ml-4 bg-purple-500 px-4 py-2 rounded hover:bg-purple-600">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="py-16">
        <div class="max-w-screen-xl mx-auto text-center">
            <h2 class="text-4xl font-bold text-purple-700 mb-8">Find the Best Interior Designs for Your Space</h2>
            <p class="text-xl text-gray-700 mb-12">Browse a variety of styles for your home and office and request designs from top interior designers.</p>
            <div class="flex justify-center gap-12">
                <a href="view_designs.php" class="bg-purple-700 text-white px-6 py-3 rounded-lg text-lg hover:bg-purple-800">Browse Designs</a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-screen-xl mx-auto text-center">
            <p>&copy; 2025 Home Decore. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>
