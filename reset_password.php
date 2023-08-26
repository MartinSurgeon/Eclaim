<?php
session_start();

require_once 'db_connection.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token exists in the password_reset_tokens table and has not expired
    $currentTime = time();
    $sql = "SELECT user_id FROM password_reset_tokens WHERE token = ? AND expiration_timestamp > ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('si', $token, $currentTime);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        // Token is valid, show the password reset form
        $userId = $row['user_id'];
        $_SESSION['reset_user_id'] = $userId; // Save the user ID in the session for security

        // Handle the password reset form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newPassword = $_POST['new_password'];

            // Update the user's password in the database
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET password = ? WHERE id = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param('si', $hashedPassword, $userId);
            $stmt->execute();

            // Password reset successful, redirect the user to the main dashboard
            header('Location: dashboard.php');
            exit;
        }
    } else {
        // Token is invalid or has expired, show an error message
        $errorMessage = "Invalid or expired password reset token. Please request a new password reset link.";
    }
} else {
    // No token provided, redirect the user to the forgot password page
    header('Location: forgot_password.php');
    exit;
}
?>

<!-- HTML form for password reset -->
<form action="reset_password.php" method="post">
    <label for="new_password">New Password:</label>
    <input type="password" name="new_password" id="new_password" required>

    <label for="confirm_password">Confirm Password:</label>
    <input type="password" name="confirm_password" id="confirm_password" required>

    <input type="submit" value="Reset Password">
</form>

<?php if (isset($errorMessage)) : ?>
    <p class="error"><?php echo $errorMessage; ?></p>
<?php endif; ?>
