<?php
session_start();
require_once 'config/db.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    if (!empty($name) && !empty($email) && !empty($_POST['password']) && !empty($role)) {
        // Check for existing email
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $error = "Email already registered.";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $password, $role);
            if ($stmt->execute()) {
                $_SESSION['user_id'] = $stmt->insert_id;
                $_SESSION['role'] = $role;
                header("Location: {$role}.php");
                exit;
            } else {
                $error = "Registration failed. Try again.";
            }
        }
    } else {
        $error = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - Home Decore</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">

    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
    <img src="assets/images/logo_decora.jpg" alt="Logo" class="logo" style="width: 100px; height: 100px; margin-bottom: 20px; margin-left: 140px;"> 
        <h2 class="text-2xl font-bold mb-6 text-center" style="color: #b89a7e;">Sign Up for Home Decore</h2>

        <?php if ($error): ?>
            <p class="text-red-500 text-sm mb-4"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" class="w-full mb-4 px-4 py-2 border rounded" required>
            <input type="email" name="email" placeholder="Email" class="w-full mb-4 px-4 py-2 border rounded" required>
            <input type="password" name="password" placeholder="Password" class="w-full mb-4 px-4 py-2 border rounded" required>

            <select name="role" class="w-full mb-4 px-4 py-2 border rounded" required>
                <option value="">Select Role</option>
                <option value="client">Client</option>
                <option value="designer">Designer</option>
            </select>

            <button type="submit" class="w-full" style="background-color: #b89a7e; color: white; padding: 0.5rem; border-radius: 0.25rem; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#a07f63'" onmouseout="this.style.backgroundColor='#b89a7e'">Sign Up</button>
        </form>

        <p class="mt-4 text-center text-sm">Already have an account? <a href="login.php" class="text-purple-600">Login</a></p>
    </div>

</body>
</html>
