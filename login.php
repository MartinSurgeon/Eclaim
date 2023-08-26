<?php
session_start();
require_once 'db_connection.php';

// Correct 
$username = $_POST['username'];
if(isset($username)) {
  // ...

        // use it 
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Retrieve the hashed password from the database for the given email
    $sql = "SELECT id, password FROM users WHERE email = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('sss',$username,$email,$password);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password']) && $user['is_admin'] == 0) {
        // User login successful, set the session and redirect to the User dashboard
        $_SESSION['user_id'] = $user['id'];
    
        header('Location: dashboard.php');
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
    <title>User Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="header-container">
        <h1 class="header-title">User Login</h1>
        <nav class="header-nav">
            <ul class="nav-list">
                <li><a href="login.php">Home</a></li>
                <li><a href="signup.php">Signup</a></li>
                <li><a href="logout.php">logout</a></li>
            </ul>
        </nav>
    </div>

    <div class="login-container">
        <form class="login-form" method="post">
            <h1>User Login</h1>
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <button type="submit">Log In</button>
            <button  type="forgetpassword"><a href=forgot_password.php>Forgot Password</a></button>
            </div>
        </form>

        <?php if (isset($loginError)) : ?>
            <p class="error"><?php echo $loginError; ?></p>
        <?php endif; ?>
    </div>
</body>

</html>
<?php include 'footer.php'; ?>