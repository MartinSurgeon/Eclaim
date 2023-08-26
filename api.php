<?php
// Include the database connection code
require_once 'db_connection.php';

// Set the response header as JSON
header('Content-Type: application/json');


// Handle claim submission form data
if ($action === 'submit_claim') {
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        http_response_code(403);
        echo json_encode(['error' => 'Authentication required']);
        exit;
    }

    // Get the claim type ID and form fields data from the request
    $claimTypeId = $_POST['claim_type_id'];
    $formData = $_POST['form_data'];

    // Validate form data (you can add specific validation rules here based on the field types)

    // Save the submitted claim to the database
    $userId = $_SESSION['user_id'];
    $submissionDate = date('Y-m-d H:i:s');

    $stmt = $connection->prepare("INSERT INTO submitted_claims (user_id, claim_type_id, form_data, submission_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('iiss', $userId, $claimTypeId, $formData, $submissionDate);
    $stmt->execute();
    $stmt->close();

    echo json_encode(['success' => true]);
    exit;
}
