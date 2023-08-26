<?php
session_start();
require_once 'db_connection.php';

// Check if the user is logged in and is an admin, if not, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userID = $_SESSION['user_id'];

// Retrieve the user's information from the database
$sql = "SELECT email, is_admin FROM users WHERE id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param('i', $userID);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user || !$user['is_admin']) {
    // User not found in the database or not an admin
    header('Location: login.php');
    exit;
}

// Retrieve the claim type information from the database based on the ID in the query parameter
if (isset($_GET['id'])) {
    $claimTypeID = $_GET['id'];

    $sql = "SELECT id, name FROM claim_types WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('i', $claimTypeID);
    $stmt->execute();
    $result = $stmt->get_result();
    $claimType = $result->fetch_assoc();

    if (!$claimType) {
        // Claim type not found in the database
        header('Location: admin_dashboard.php');
        exit;
    }
} else {
    // If the claim type ID is not provided in the query parameter, redirect to the admin dashboard
    header('Location: admin_dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form is submitted
    $newClaimTypeName = $_POST['claim_type_name'];

    // Update the claim type in the database
    $sql = "UPDATE claim_types SET name = ? WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('si', $newClaimTypeName, $claimTypeID);

    if ($stmt->execute()) {
        // Claim type updated successfully, redirect back to the admin dashboard
        header('Location: admin_dashboard.php');
        exit;
    } else {
        $editClaimTypeError = "Error occurred while updating the claim type. Please try again.";
    }
}
?>

<?php include 'header.php'; ?>

<!-- Content specific to the Edit Claim Type Page -->
<h1>Edit Claim Type</h1>
<form id="editClaimTypeForm" method="post">
    <div>
        <label for="claim_type_name">Claim Type Name:</label>
        <input type="text" id="claim_type_name" name="claim_type_name" value="<?php echo $claimType['name']; ?>" required>
    </div>
    <div>
        <button type="submit">Update Claim Type</button>
    </div>
</form>

<?php if (isset($editClaimTypeError)) : ?>
    <p class="error"><?php echo $editClaimTypeError; ?></p>
<?php endif; ?>

<?php include 'footer.php'; ?>
