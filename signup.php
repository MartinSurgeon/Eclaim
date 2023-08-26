<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form is submitted
    if(isset($_POST['username'])) {
        // use it
      }
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Save the user data to the database
    $sql = "INSERT INTO users (username, email, password) VALUES (?,?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('sss',$username, $email, $hashedPassword);

    if ($stmt->execute()) {
        // User registration successful, set the session and redirect to the main dashboard
        $_SESSION['user_id'] = $stmt->insert_id;
        header('Location: login.php');
        exit;
    } else {
        $signupError = "Error occurred during signup. Please try again.";
    }
}
?>

<?php include 'header.php'; ?>

<!-- Content specific to the Signup Page -->
<h1>User Sign Up</h1>
<form id="signupForm" method="post">
    <div>
        <label for="name">Name:</label>
        <input type="text" id="name" name="Username" required>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div>
        <button type="submit">Sign Up</button>
    </div>
</form>

<?php if (isset($signupError)) : ?>
    <p class="error"><?php echo $signupError; ?></p>
<?php endif; ?>

<?php include 'footer.php'; ?>
