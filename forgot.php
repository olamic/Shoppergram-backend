<?php
// Connect to database
$db = new PDO('mysql:host=localhost;dbname=api_auth', 'root', '');

// Get user input
$email = $_POST['email'];

// Generate reset token
$reset_token = bin2hex(sha1(8));

// Set token expiry time
$reset_token_expiry = date('Y-m-d H:i:s', time() + 3600);

// Prepare and execute query
$stmt = $db->prepare("UPDATE users SET reset_token = :reset_token, reset_token_expiry = :reset_token_expiry WHERE email = :email");
$stmt->execute(['reset_token' => $reset_token, 'reset_token_expiry' => $reset_token_expiry, 'email' => $email]);

if ($stmt) {
// Return success response
    return json_encode(['success' => true]);
}
else{
    return json_encode(['error'=>'An issue occurred. Please try again.']);
}
?>