<?php
function generateToken($length = 32) {
    
    return bin2hex(random_bytes($length));
}

function sendEmail($to, $subject, $message) {
    $headers = "From: no-reply@system.com\r\n";
    $headers .= "Content-type: text/html\r\n";
    return mail($to, $subject, $message, $headers);
}
?>