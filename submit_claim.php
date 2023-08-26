<?php
session_start();
require_once 'db_connection.php';

// Check if the user is logged in and is authorized to submit claims
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin'])) {
    // Redirect to login page or unauthorized page
    header('Location: login.php');
    exit;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $claimant_name = $_POST['claimant_name'];
    $designation = $_POST['designation'];
    $staff_number = $_POST['staff_number'];
    $telephone_number = $_POST['telephone_number'];
    $faculty_department = $_POST['faculty_department'];
    $month_year = $_POST['month_year'];
    $claim_type = $_POST['claim_type'];
    $claim_items = $_POST['claim_items'];
    $total_cost = $_POST['total_cost'];
    $declaration_signature = $_POST['declaration_signature'];
    $declaration_date = $_POST['declaration_date'];

    // Prepare and execute the SQL query to insert the claim data into the database
    $sql = "INSERT INTO claims (claimant_name, designation, staff_number, telephone_number, faculty_department, month_year, claim_type, claim_items, total_cost, declaration_signature, declaration_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('sssssssssss', $claimant_name, $designation, $staff_number, $telephone_number, $faculty_department, $month_year, $claim_type, $claim_items, $total_cost, $declaration_signature, $declaration_date);

    if ($stmt->execute()) {
        // Claim data saved successfully, redirect to a success page or dashboard
        header('Location: dashboard.php?claim_success=1');
        exit;
    } else {
        // Error occurred while saving the claim data, handle the error (e.g., show an error message)
        $error_message = "Error occurred while submitting the claim. Please try again.";
    }
}

// If the form is not submitted or if there was an error, you can redirect back to the claim form page with an error message
header('Location: claim_form_r01.php?error=' . urlencode($error_message));
exit;
