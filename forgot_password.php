<?php
session_start();

require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Generate a unique token and set the expiration time (e.g., 1 hour from now)
        $token = bin2hex(random_bytes(32));
        $expirationTime = time() + 3600; // 1 hour from now

        // Insert the token into the password_reset_tokens table
        $sql = "INSERT INTO password_reset_tokens (user_id, token, expiration_timestamp) VALUES (?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('iss', $user['id'], $token, $expirationTime);
        $stmt->execute();

        // Send the password reset link to the user's email
        $resetLink = "http://example.com/reset_password.php?token=$token";
        // Replace 'example.com' with your website URL

        // Send the email using PHPMailer or Swift Mailer
        // Example using PHPMailer:
        /*
        require 'vendor/autoload.php'; // Include PHPMailer library
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->setFrom('noreply@example.com', 'Your Website Name');
        $mail->addAddress($email);
        $mail->Subject = 'Password Reset Link';
        $mail->Body = "Click the following link to reset your password: $resetLink";
        if ($mail->send()) {
            // Email sent successfully, show a success message to the user
            $message = "Password reset link has been sent to your email.";
        } else {
            // Error sending email, show an error message to the user
            $errorMessage = "Error sending password reset email. Please try again later.";
        }
        */
    } else {
        $errorMessage = "Email not found. Please enter a valid email address.";
    }
}
?>
    <link rel="stylesheet" href="style.css">

<!-- HTML form for password reset request -->
<form action="forgot_password.php" method="post">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
    <input type="submit" value="Reset Password">
</form>

<?php if (isset($message)) : ?>
    <p class="success"><?php echo $message; ?></p>
<?php endif; ?>

<?php if (isset($errorMessage)) : ?>
    <p class="error"><?php echo $errorMessage; ?></p>
<?php endif; ?>
