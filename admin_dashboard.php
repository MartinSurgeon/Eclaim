<?php
session_start();
require_once 'db_connection.php';

// Check if the user is logged in and is an admin, if not, redirect to the admin login page
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: admin_login.php');
    exit;
}
?>

<?php include 'header.php'; ?>

<!-- Main Content -->
<main>
    <h2>Welcome, Admin!</h2>
    <p>You have access to the admin dashboard. Here, you can manage users, add and delete claims, and other settings.</p>

    <h3>Manage Users</h3>
    <p><a href="manage_users.php">Manage Users</a></p>

    <h3>Add New Claim</h3>
    <p><a href="add_claim.php">Add New Claim</a></p>

    <h3>Claim List</h3>
    <div class="claim-tiles">
        <?php
        // Fetch claims data from the database and display them as tiles
        $sql = "SELECT * FROM claim_e08";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="claim-tile">';
                echo '<h4>' . $row['claim_type'] . '</h4>';
                echo '<p>' . $row['description'] . '</p>';
                echo '<a href="claim_form.php?claim_id=' . $row['claim_id'] . '">View Details</a>';
                echo '</div>';
            }
        } else {
            echo '<p>No claims available.</p>';
        }
        ?>
    </div>

</main>

<?php include 'footer.php'; ?>
