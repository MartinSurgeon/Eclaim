<?php
session_start();
require_once 'db_connection.php';

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userID = $_SESSION['user_id'];

// Retrieve the user's information from the database
$sql = "SELECT email FROM users WHERE id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param('i', $userID);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    // User not found in the database
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form is submitted
    $email = $_POST['email'];

    // Update the user's email in the database
    $sql = "UPDATE users SET email = ? WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('si', $email, $userID);

    if ($stmt->execute()) {
        // Update successful, refresh the user's information
        header('Location: user_profile.php');
        exit;
    } else {
        $updateError = "Error updating user information. Please try again.";
    }
}
?>

<?php include 'header.php'; ?>

<!-- Content specific to the User Profile Page -->
<h1>User Profile</h1>
<form id="profileForm" method="post">
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
    </div>
    <div>
        <button type="submit">Update Profile</button>
    </div>
</form>

<?php if (isset($updateError)) : ?>
    <p class="error"><?php echo $updateError; ?></p>
<?php endif; ?>

<?php include 'footer.php'; ?>
