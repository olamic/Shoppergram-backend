<?php

// Connect to database
$db = new PDO('mysql:host=localhost;dbname=api_auth', 'root', '');

// Get user input
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$email = $_POST['email'];
$phoneNumber = $_POST['phone_number'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['action']) && $data['action'] === 'register') {
        $username = $data['username'];
        $email = $data['email'];
        $password = $data['password'];
        $phoneNumber = isset($data['phone_number']) ? $data['phone_number'] : null; // Handle optional phone number

        // Validate username, email, and password (implement appropriate validation)

        // Perform username, email, and (if provided) phone number existence check
        $sql = "SELECT * FROM users WHERE username = ? OR email = ? OR phone_number = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $phoneNumber);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $response = array('error' => 'Username, email, or phone number already exists');
        } else {
            // Hash password and insert user data if no duplicates are found
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO users (username, email, password_hash, phone_number) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $username, $email, $hashedPassword, $phoneNumber);

            if ($stmt->execute()) {
                $response = array('message' => 'Registration successful!');
            } else {
                $response = array('error' => 'Registration failed: ' . $conn->error);
            }

            $stmt->close();
        }
    }

    // ... (code for other API endpoints)
}

?>