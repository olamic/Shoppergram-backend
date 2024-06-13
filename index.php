<?php

// Connect to database
$db = new PDO('mysql:host=localhost;dbname=api_auth', 'root', '');

// Get user input
$username = $_POST['username'];
$password = $_POST['password'];

// Prepare and execute query
$stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);

// Check if user exists
if ($stmt->rowCount() > 0) {
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify password
    if (password_verify($password, $user['password'])) {
        // Generate token
        $token = bin2hex(sha1(8));

        // Update user record with token
        $db->prepare("UPDATE users SET token = :token WHERE id = :id")->execute(['token' => $token, 'id' => $user['id']]);

        // Return success response
        return json_encode(['success' => true, 'token' => $token]);
    } else {
        // Invalid password
        return json_encode(['success' => false, 'message' => 'Invalid password']);
    }
} else {
    // User not found
    return json_encode(['success' => false, 'message' => 'User not found']);
}

?>