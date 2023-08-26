<?php
session_start();
require_once 'db_connection.php';

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch available claims from the database (Assuming you have a table called "claim_e08" and "invigilation_claims")
$sql_claim_e08 = "SELECT * FROM claim_e08";
$result_claim_e08 = $connection->query($sql_claim_e08);

$sql_invigilation_claims = "SELECT * FROM invigilation_claims";
$result_invigilation_claims = $connection->query($sql_invigilation_claims);
?>

<!-- Include the header -->
<?php include 'header.php'; ?>

<!-- Main content -->
<main>
    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
    <p>You have access to the dashboard. Here, you can view available claims.</p>

    <!-- Display the list of available claims from claim_e08 table -->
    <h3>Claim Type E08 - Extra Teaching Load Claims</h3>
    <div class="claim-tiles">
        <?php while ($row = $result_claim_e08->fetch_assoc()) : ?>
            <div class="claim-tile">
                <h3><?php echo $row['claim_name']; ?></h3>
                <p><?php echo $row['claim_description']; ?></p>
                <!-- You can add more details as needed based on your database structure -->
                <a href="view_claim.php?id=<?php echo $row['claim_id']; ?>">View Claim</a>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Display the list of available claims from invigilation_claims table -->
    <h3>Invigilation Claims</h3>
    <div class="claim-tiles">
        <?php while ($row = $result_invigilation_claims->fetch_assoc()) : ?>
            <div class="claim-tile">
                <h3><?php echo $row['claim_name']; ?></h3>
                <p><?php echo $row['claim_description']; ?></p>
                <!-- You can add more details as needed based on your database structure -->
                <a href="view_claim.php?id=<?php echo $row['claim_id']; ?>">View Claim</a>
            </div>
        <?php endwhile; ?>
    </div>
</main>

<!-- Include the footer -->
<?php include 'footer.php'; ?>
