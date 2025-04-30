<?php
session_start();          // Start the session to access session variables
session_unset();          // Clear all session variables
session_destroy();        // Destroy the session completely
header("Location: index.php"); // Redirect the user to login page
exit;
