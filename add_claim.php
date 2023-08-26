<?php
session_start();
require_once 'db_connection.php';

// Check if the user is logged in and is an admin, if not, redirect to the admin login page
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: admin_login.php');
    exit;
}

// Handle the form submission to add a new claim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $claimType = $_POST['claimType'];
    // Add more fields as needed based on your claim form

    // Add the claim to the database
    $sql = "INSERT INTO claims (claim_type) VALUES (?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('s', $claimType);

    if ($stmt->execute()) {
        // Claim added successfully, redirect to the admin_dashboard page
        header('Location: admin_dashboard.php');
        exit;
    } else {
        $errorMessage = "Error adding claim. Please try again.";
    }
}
?>

<?php include 'header.php'; ?>

<!-- Main Content -->
<main>
    <h2>Add New Claim</h2>
    <p>Please fill out the form below to add a new claim:</p>

    <!-- Claim Form -->
    <div class="claim-form">
        <form method="post">
            <div>
                <label for="claimType">Claim Type:</label>
                <input type="text" id="claimType" name="claimType" required>
            </div>
            <!-- Add more fields as needed based on your claim form -->
            <!-- Claim Form -->
<div class="claim-form">
    <form method="post">
        <div>
            <label for="claimType">Claim Type:</label>
            <input type="text" id="claimType" name="claimType" required>
        </div>

        <!-- Add more fields based on your claim form -->
        <div>
            <label for="month">Month:</label>
            <input type="text" id="month" name="month" required>
        </div>

        <div>
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>
        </div>

        <div>
            <label for="time">Time:</label>
            <input type="time" id="time" name="time" required>
        </div>

        <div>
            <label for="courseCode">Course Code:</label>
            <input type="text" id="courseCode" name="courseCode" required>
        </div>

        <div>
            <label for="contactHrs">Number of Contact Hrs:</label>
            <input type="number" id="contactHrs" name="contactHrs" required>
        </div>

        <!-- End of additional fields -->

      

    <?php if (isset($errorMessage)) : ?>
        <p class="error"><?php echo $errorMessage; ?></p>
    <?php endif; ?>
</div>

            <div>
                <button type="submit">Add Claim</button>
            </div>
        </form>

        <?php if (isset($errorMessage)) : ?>
            <p class="error"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
    </div>
</main>

<?php include 'footer.php'; ?>
