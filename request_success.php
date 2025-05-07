<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Request Success - Home Decore</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">

<nav style="background-color: #b89a7e; padding: 1rem; color: white; display: flex; justify-content: space-between;">
    <h1 style="font-size: 1.25rem; font-weight: 600;">Home Decore - Client</h1>
    <a href="logout.php" style="background-color: white; color: #b89a7e; padding: 0.25rem 0.75rem; border-radius: 0.25rem; text-decoration: none;">Logout</a>
</nav>

<main class="p-6">
    <h2 class="text-2xl font-bold mb-4">Request Submitted Successfully!</h2>

    <div class="bg-white shadow rounded p-6">
        <h3 style="font-size: 1.125rem; font-weight: 600; color: #b89a7e;">Thank you for your request.</h3>
        <p class="text-sm text-gray-600">The designer will get back to you shortly. Please check your dashboard for updates on your request.</p>
        <p class="mt-4"><strong>What happens next:</strong></p>
        <ul class="list-disc pl-6">
            <li>The designer will review your request.</li>
            <li>You will receive an update in your dashboard.</li>
        </ul>
        <a href="client.php" style="margin-top: 1rem; display: inline-block; background-color: #b89a7e; color: white; padding: 0.5rem 1rem; border-radius: 0.25rem; text-decoration: none;">Go Back to Dashboard</a>
    </div>
</main>

</body>
</html>