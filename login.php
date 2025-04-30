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
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div >
        

        <?php if ($error): ?>
            <p class="text-red-500 text-sm mb-4"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <div class="login-container">
        <header>
            <img src="assets/images/logo_decora.jpg" alt="Logo" class="logo"> 
        </header>
        <h2>Welcome Back!</h2>

       
        <form method="post" action="">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="continue-btn">CONTINUE</button>

            <input type="hidden" name="page_action" value="login">
        </form>

        <div class="links">
            <a href="signup.php">Don't have an account? <span>Sign Up Here</span></a>
        </div>
    </div>

    </div>

</body>
</html>
