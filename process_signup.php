<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form is submitted
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate inputs (you can add more validation checks here)

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the database
    $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('ss', $email, $hashedPassword);

    if ($stmt->execute()) {
        // Registration successful, redirect to login page with a success message
        header('Location: login.php?registration=success');
        exit;
    } else {
        // Registration failed, redirect back to the signup page with an error message
        header('Location: signup.php?error=registration_failed');
        exit;
    }
}
?>
