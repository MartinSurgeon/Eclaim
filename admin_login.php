<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form is submitted
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the email and password match the admin credentials in the database
    $sql = "SELECT id, password FROM admins WHERE email = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && password_verify($password, $admin['password'])) {
        // Admin login successful, set the session and redirect to the admin dashboard
        $_SESSION['user_id'] = $admin['id'];
        $_SESSION['is_admin'] = true; // Set the admin session variable
        header('Location: admin_dashboard.php');
        exit;
    } else {
        $loginError = "Invalid email or password. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <h1>Admin Login</h1>
        <form id="loginForm" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Log In</button>
            </div>
        </form>

        <?php if (isset($loginError)) : ?>
            <p class="error"><?php echo $loginError; ?></p>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>
