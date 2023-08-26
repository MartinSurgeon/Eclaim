<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form is submitted
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Save the admin data to the database
    $sql = "INSERT INTO admins (email, password) VALUES (?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('ss', $email, $hashedPassword);

    if ($stmt->execute()) {
        // Admin registration successful, redirect to the admin login page
        header('Location: admin_login.php');
        exit;
    } else {
        $signupError = "Error occurred during signup. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Signup</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <h1>Admin Signup</h1>
        <form id="signupForm" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Sign Up</button>
            </div>
        </form>

        <?php if (isset($signupError)) : ?>
            <p class="error"><?php echo $signupError; ?></p>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>
