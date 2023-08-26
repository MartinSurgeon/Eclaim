<?php
require_once 'db_connection.php'

session_start();

// Check if the user is logged in and is an admin, otherwise redirect to the login page
if (!isset($_SESSION['user_email']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: login.php');
    exit;
}

// Function to retrieve a specific claim from the database (Replace 'your_db_host', 'your_db_user', 'your_db_password', and 'your_db_name' with your actual database credentials)
function getClaimById($claimId) {
    $connection = new mysqli('your_db_host', 'your_db_user', 'your_db_password', 'your_db_name');
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $sql = "SELECT * FROM submitted_claims WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $claimId);
    $stmt->execute();
    $result = $stmt->get_result();

    $claim = $result->fetch_assoc();

    $stmt->close();
    $connection->close();
    return $claim;
}

// Check if the claim ID is provided in the URL
if (!isset($_GET['id'])) {
    header('Location: admin_dashboard.php');
    exit;
}

$claimId = $_GET['id'];

// Get the claim details based on the claim ID
$claim = getClaimById($claimId);

// Check if the claim is a draft, otherwise redirect back to the admin dashboard
if ($claim['status'] !== 'Draft') {
    header('Location: admin_dashboard.php');
    exit;
}

// Handle claim update when the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // TODO: Update the claim details in the database
    $claimType = $_POST['claimType'];
    $claimantName = $_POST['claimantName'];
    $claimDetails = $_POST['claimDetails'];

    // Update the claim details in the database (Replace 'your_db_host', 'your_db_user', 'your_db_password', and 'your_db_name' with your actual database credentials)
    $connection = new mysqli('your_db_host', 'your_db_user', 'your_db_password', 'your_db_name');
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $sql = "UPDATE submitted_claims SET claim_type = ?, claimant_name = ?, claim_details = ? WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssi", $claimType, $claimantName, $claimDetails, $claimId);
    $stmt->execute();

    $stmt->close();
    $connection->close();

    $successMessage = "Claim details updated successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Claim</title>
    <!-- Add your CSS and meta tags here -->
</head>
<body>
    <h1>Edit Claim</h1>
    <?php if (isset($successMessage)) : ?>
        <p><?php echo $successMessage; ?></p>
    <?php endif; ?>
    <form method="post">
        <div>
            <label for="claimType">Claim Type:</label>
            <select id="claimType" name="claimType" required>
                <option value="Medical Expense" <?php echo $claim['claim_type'] === 'Medical Expense' ? 'selected' : ''; ?>>Medical Expense</option>
                <option value="Travel Expense" <?php echo $claim['claim_type'] === 'Travel Expense' ? 'selected' : ''; ?>>Travel Expense</option>
                <!-- Add more claim types here -->
            </select>
        </div>
        <div>
            <label for="claimantName">Claimant Name:</label>
            <input type="text" id="claimantName" name="claimantName" value="<?php echo $claim['claimant_name']; ?>" required>
        </div>
        <div>
            <label for="claimDetails">Claim Details:</label>
            <textarea id="claimDetails" name="claimDetails" required><?php echo $claim['claim_details']; ?></textarea>
        </div>
        <div>
            <button type="submit">Update Claim</button>
            <a href="admin_dashboard.php">Cancel</a>
        </div>
    </form>
</body>
</html>
