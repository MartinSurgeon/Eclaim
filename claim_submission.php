<?php
session_start();
require_once 'db_connection.php'; // Include the database connection code
?>

<?php include 'header.php'; ?>

<!-- Content specific to the Claim Submission Page -->
<h1>Claim Submission</h1>
<?php if (!isset($_SESSION['user_id'])) : ?>
    <p>Please You must be logged in to submit a claim. <a href="login.php">Login</a></p>
<?php else : ?>
    <form id="claimSubmissionForm" method="post">
        <!-- The dynamically rendered claim submission form will be added here -->
    </form>
<?php endif; ?>

<script>
    // Function to fetch claim types from the backend API
    function fetchClaimTypes() {
        fetch('api.php?action=get_claim_types')
            .then(response => response.json())
            .then(data => {
                const claimTypesList = document.getElementById('claimTypesList');
                data.forEach(claimType => {
                    const listItem = document.createElement('li');
                    listItem.textContent = claimType.name;
                    listItem.addEventListener('click', () => showClaimSubmissionForm(claimType.id));
                    claimTypesList.appendChild(listItem);
                });
            })
            .catch(error => console.error('Error fetching claim types:', error));
    }

    <!-- ... (existing code) -->

<script>
    // Function to submit the claim form
    function submitClaimForm() {
        const form = document.getElementById('claimSubmissionForm');
        const claimTypeId = /* Get the selected claim type ID */;
        const formData = new FormData(form);

        formData.append('claim_type_id', claimTypeId);

        fetch('api.php?action=submit_claim', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Claim submitted successfully.');
                    // Redirect to the main dashboard after successful submission
                    window.location.href = 'index.php';
                } else {
                    alert('Error submitting claim. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error submitting claim:', error);
                alert('Error submitting claim. Please try again.');
            });
    }
</script>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claim Submission</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Header -->
    <div class="header-container">
        <h1 class="header-title">Claim Submission</h1>
        <ul class="header-nav">
            <li><a href="#">Home</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <main>
        <h2>Submit Your Claim</h2>
        <form id="claimForm" method="post">
            <!-- Part A - Details of Claimant -->
            <fieldset>
                <legend>Part A - Details of Claimant</legend>
                <div>
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div>
                    <label for="designation">Designation:</label>
                    <input type="text" id="designation" name="designation" required>
                </div>
                <div>
                    <label for="staff_number">Staff Number:</label>
                    <input type="text" id="staff_number" name="staff_number" required>
                </div>
                <div>
                    <label for="telephone_number">Telephone Number:</label>
                    <input type="tel" id="telephone_number" name="telephone_number" required>
                </div>
                <div>
                    <label for="faculty">Faculty/Department/Section/Unit:</label>
                    <input type="text" id="faculty" name="faculty" required>
                </div>
                <div>
                    <label for="month_year">Month/Year:</label>
                    <input type="text" id="month_year" name="month_year" required>
                </div>
            </fieldset>

            <!-- Part B - Details of Claim -->
            <fieldset>
                <legend>Part B - Details of Claim</legend>
                <div>
                    <label>Claim is in respect of:</label>
                    <input type="radio" id="myself" name="claim_respect" value="myself" required>
                    <label for="myself">Myself</label>

                    <input type="radio" id="spouse" name="claim_respect" value="spouse">
                    <label for="spouse">Spouse</label>

                    <input type="radio" id="child_ward" name="claim_respect" value="child_ward">
                    <label for="child_ward">Child/Ward</label>
                </div>
                <div>
                    <label for="patient_name">Please state name of Patient if different from Claimant (one name only):</label>
                    <input type="text" id="patient_name" name="patient_name">
                </div>

                <!-- Add the relevant medical item checkboxes here -->
                <table>
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Cost (GH¢)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Consultation</td>
                            <td><input type="text" name="consultation_cost"></td>
                        </tr>
                        <!-- Add other medical items here -->
                    </tbody>
                </table>

                <!-- Add the Total Cost field here -->
                <div>
                    <label for="total_cost">Total:</label>
                    <input type="text" id="total_cost" name="total_cost" required>
                </div>
            </fieldset>

            <!-- Declaration by Claimant -->
            <fieldset>
                <legend>Declaration by Claimant</legend>
                <div>
                    <label for="declaration">I certify that the above medical expense(s) was/were incurred by me in respect of ( please underline only one as appropriate) myself/ husband/ wife/ child/ ward. Relevant referral note, prescription forms, and receipts are attached.</label>
                    <input type="checkbox" id="declaration" name="declaration" required>
                </div>
                <div>
                    <label for="claimant_signature">Signature of Claimant</label>
                    <input type="text" id="claimant_signature" name="claimant_signature" required>
                </div>
                <div>
                    <label for="claimant_date">Date (DD/MM/YYYY)</label>
                    <input type="text" id="claimant_date" name="claimant_date" required>
                </div>
            </fieldset>

            <!-- Declaration by Director of Health Services -->
            <fieldset>
                <legend>Declaration by Director of Health Services</legend>
                <!-- Add Director's declaration fields here -->
            </fieldset>

            <!-- Declaration by Approving Officers -->
            <fieldset>
                <legend>Declaration by Approving Officers</legend>
                <!-- Add Approving Officers' declaration fields here -->
            </fieldset>

            <!-- Declaration by Authorizing Officer -->
            <fieldset>
                <legend>Declaration by Authorizing Officer</legend>
                <!-- Add Authorizing Officer's declaration fields here -->
            </fieldset>

            <!-- Claim Summary (For Accounts Officer's Use Only) -->
            <fieldset>
                <legend>Claim Summary (For Accounts Officer's Use Only)</legend>
                <!-- Add Accounts Officer's claim summary fields here -->
            </fieldset>

            <button type="submit">Submit Claim</button>
        </form>
    </main>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

</html>


