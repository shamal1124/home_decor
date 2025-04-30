<?php
session_start();
require_once 'config/db.php'; // Make sure this file defines $conn (your DB connection)

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        // Prepare the SQL statement
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Check user and password
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            header("Location: {$user['role']}.php");
            exit;
        } else {
            $error = "Invalid credentials.";
        }
    } else {
        $error = "Email and password are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>Login - Home Decore</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">

    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-purple-700">Login to Home Decore</h2>

        <?php if ($error): ?>
            <p class="text-red-500 text-sm mb-4"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST">
            <input type="email" name="email" placeholder="Email" class="w-full mb-4 px-4 py-2 border rounded" required>
            <input type="password" name="password" placeholder="Password" class="w-full mb-4 px-4 py-2 border rounded" required>

            <button type="submit" class="w-full bg-purple-700 text-white py-2 rounded hover:bg-purple-800">Login</button>
        </form>

        <p class="mt-4 text-center text-sm">Don't have an account? <a href="signup.php" class="text-purple-600">Sign up</a></p>
    </div>

</body>
</html>
