<?php
function sendMail($to, $subject, $message) {
    $from = "your_email@example.com"; // ✅ Change to your real email
    $fromName = "Home Decore";

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "From: $fromName <$from>\r\n";
    $headers .= "Reply-To: $from\r\n";

    return mail($to, $subject, $message, $headers);
}
?>
