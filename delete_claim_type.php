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

// Check if the claim type ID is provided in the query parameter
if (isset($_GET['id'])) {
    $claimTypeID = $_GET['id'];

    // Delete the claim type from the database
    $sql = "DELETE FROM claim_types WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('i', $claimTypeID);

    if ($stmt->execute()) {
        // Claim type deleted successfully, redirect back to the admin dashboard
        header('Location: admin_dashboard.php');
        exit;
    } else {
        // If deletion fails, redirect back to the admin dashboard with an error message
        header('Location: admin_dashboard.php?error=delete_failed');
        exit;
    }
} else {
    // If the claim type ID is not provided in the query parameter, redirect to the admin dashboard
    header('Location: admin_dashboard.php');
    exit;
}
?>
