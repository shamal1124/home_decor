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

<nav class="bg-purple-700 p-4 text-white flex justify-between">
    <h1 class="text-xl font-semibold">Home Decore - Client</h1>
    <a href="logout.php" class="bg-white text-purple-700 px-3 py-1 rounded hover:bg-gray-100">Logout</a>
</nav>

<main class="p-6">
    <h2 class="text-2xl font-bold mb-4">Request Submitted Successfully!</h2>

    <div class="bg-white shadow rounded p-6">
        <h3 class="text-lg font-semibold text-purple-700">Thank you for your request.</h3>
        <p class="text-sm text-gray-600">The designer will get back to you shortly. Please check your dashboard for updates on your request.</p>
        <p class="mt-4"><strong>What happens next:</strong></p>
        <ul class="list-disc pl-6">
            <li>The designer will review your request.</li>
            <li>You will receive an update in your dashboard.</li>
        </ul>
        <a href="client.php" class="mt-4 inline-block bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">Go Back to Dashboard</a>
    </div>
</main>

</body>
</html>
