<?php
session_start();
require_once 'db_connection.php';

// Check if the user is logged in and is an admin, if not, redirect to the admin login page
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: admin_login.php');
    exit;
}

// Handle the form submission to add a new user
if (isset($_POST['username'])) {
    // use $_POST['username']
  
  
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password for security
    $designation = $_POST['designation'];

    // Prepare and execute the SQL query to insert the new user into the database
    $sql = "INSERT INTO users (username, email, password, designation) VALUES (?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('ssss', $username, $email, $password, $designation);

    if ($stmt->execute()) {
        // User added successfully, redirect to the manage_users page
        header('Location: manage_users.php');
        exit;
    } else {
        $errorMessage = "Error adding user. Please try again.";
    }
}
?>

<?php include 'header.php'; ?>

<!-- Main Content -->
<main>
    <h2>Manage Users</h2>
    <p>Here, you can add new users to the system.</p>

    <!-- User Form -->
    <div class="user-form">
        <form method="post">
            <div>
                <label for="fullname">Full Name:</label>
                <input type="text" id="fullname" name="fullname" required>
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
                <label for="designation">Designation:</label>
                <input type="text" id="designation" name="designation" required>
            </div>
            <div>
                <button type="submit">Add User</button>
            </div>
        </form>

        <?php if (isset($errorMessage)) : ?>
            <p class="error"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
    </div>
</main>

<?php include 'footer.php'; ?>
