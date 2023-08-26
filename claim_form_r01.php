<?php include 'header.php'; ?>

<!-- Content specific to the Claim Form R01 -->
<h1>R01 - CLAIM FORM FOR MEDICAL EXPENSES REFUND (R.1)</h1>

<!-- Part A - Details of Claimant -->
<h2>Part A - Details of Claimant</h2>
<form id="part_a_form">
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
        <label for="faculty_department">Faculty/Department/Section/Unit:</label>
        <input type="text" id="faculty_department" name="faculty_department" required>
    </div>
    <div>
        <label for="month_year">Month/Year:</label>
        <input type="text" id="month_year" name="month_year" required>
    </div>
</form>

<!-- Part B - Details of Claim -->
<h2>Part B - Details of Claim</h2>
<form id="part_b_form">
    <div>
        <label for="claimant_type">Claim is in respect of (Please tick only one, i.e., one Form per person):</label>
        <input type="radio" id="claimant_type_myself" name="claimant_type" value="myself" required>
        <label for="claimant_type_myself">Myself</label>
        <input type="radio" id="claimant_type_spouse" name="claimant_type" value="spouse" required>
        <label for="claimant_type_spouse">Spouse</label>
        <input type="radio" id="claimant_type_child_ward" name="claimant_type" value="child_ward" required>
        <label for="claimant_type_child_ward">Child/Ward</label>
    </div>
    <div>
        <label for="patient_name">Please state name of Patient if different from Claimant (one name only):</label>
        <input type="text" id="patient_name" name="patient_name" required>
    </div>
    
    <!-- Table for relevant medical items -->
    <table>
        <thead>
            <tr>
                <th>Please tick the relevant medical item(s) below</th>
                <th>Item</th>
                <th>Cost (GH¢)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input type="checkbox" name="medical_item[]" value="Consultation"></td>
                <td>Consultation</td>
                <td><input type="number" name="cost_consultation" step="0.01" min="0"></td>
            </tr>
            <!-- Add other medical items to the table -->
        </tbody>
    </table>
    
    <!-- Total amount -->
    <div>
        <label for="total_amount">Total:</label>
        <input type="number" id="total_amount" name="total_amount" step="0.01" min="0" required>
    </div>
</form>

<!-- Part C - Declaration by Claimant -->
<h2>Part C - Declaration by Claimant</h2>
<form id="part_c_form">
    <div>
        <p>I certify that the above medical expense(s) was/were incurred by me in respect of ( please underline only one as appropriate) myself/ husband/ wife/ child/ ward. Relevant referral note, prescription forms, and receipts are attached.</p>
    </div>
    <div>
        <label for="claimant_signature">Signature of Claimant:</label>
        <input type="text" id="claimant_signature" name="claimant_signature" required>
    </div>
    <div>
        <label for="claimant_date">Date (DD/MM/YYYY):</label>
        <input type="text" id="claimant_date" name="claimant_date" required>
    </div>
</form>

<!-- Add the rest of the sections (Parts D, E, and F) as needed -->
<!-- ... (previous code) ... -->

<!-- Part D - Declaration by Director of Health Services -->
<h2>Part D - Declaration by Director of Health Services</h2>
<form id="part_d_form">
    <div>
        <label for="director_name">Director, Health Services:</label>
        <input type="text" id="director_name" name="director_name" required>
    </div>
    <div>
        <label for="director_date">Date (DD/MM/YYYY):</label>
        <input type="text" id="director_date" name="director_date" required>
    </div>
</form>

<!-- Part E - Approving Officers -->
<h2>Part E - Approving Officers</h2>
<form id="part_e_form">
    <div>
        <label for="deputy_registrar_name">Deputy Registrar, Human Resource:</label>
        <input type="text" id="deputy_registrar_name" name="deputy_registrar_name" required>
    </div>
    <div>
        <label for="deputy_registrar_date">Date (DD/MM/YYYY):</label>
        <input type="text" id="deputy_registrar_date" name="deputy_registrar_date" required>
    </div>
    <div>
        <label for="registrar_name">Registrar:</label>
        <input type="text" id="registrar_name" name="registrar_name" required>
    </div>
    <div>
        <label for="registrar_date">Date (DD/MM/YYYY):</label>
        <input type="text" id="registrar_date" name="registrar_date" required>
    </div>
</form>

<!-- Part F - Authorising Officer -->
<h2>Part F - Authorising Officer</h2>
<form id="part_f_form">
    <div>
        <label for="finance_officer_name">Finance Officer:</label>
        <input type="text" id="finance_officer_name" name="finance_officer_name" required>
    </div>
    <div>
        <label for="finance_officer_date">Date (DD/MM/YYYY):</label>
        <input type="text" id="finance_officer_date" name="finance_officer_date" required>
    </div>
</form>

<!-- Part G - Claim Summary (For Accounts Officer's Use Only) -->
<h2>Part G - Claim Summary (For Accounts Officer's Use Only)</h2>
<form id="part_g_form">
    <div>
        <label for="total_amount_due">Total amount due to Claimant: GH¢</label>
        <input type="number" id="total_amount_due" name="total_amount_due" step="0.01" min="0" required>
    </div>
    <div>
        <label for="prepared_by">Prepared by:</label>
        <input type="text" id="prepared_by" name="prepared_by" required>
    </div>
    <div>
        <label for="prepared_date">Signature Date (DD/MM/YYYY):</label>
        <input type="text" id="prepared_date" name="prepared_date" required>
    </div>
</form>

<!-- Part H - Additional Notes -->
<h2>Part H - Additional Notes</h2>
<form id="part_h_form">
    <div>
        <p>This Form has been designed in accordance with Section 15.2.1 of the University's Financial and Stores Regulations. It is to be used only for the claim for which it is meant.</p>
    </div>
</form>

<!-- ... (rest of the code) ... -->
<style>
/* CSS for Claim Form (R01) */

/* General styles */
body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

h1, h2, h3 {
    margin: 0;
}

/* Form styles */
form {
    margin-bottom: 30px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-weight: bold;
}

.form-group input[type="text"],
.form-group input[type="number"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

/* Part B - Details of Claim */
.medical-items-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.medical-items-table th,
.medical-items-table td {
    border: 1px solid #ccc;
    padding: 10px;
}

/* Part C - Declaration by Claimant */
#part_c_form label {
    display: inline-block;
    margin-right: 20px;
}

/* Part D - Declaration by Director of Health Services */
#part_d_form label,
#part_d_form input[type="text"] {
    display: block;
}

/* Part E - Approving Officers */
#part_e_form label,
#part_e_form input[type="text"] {
    display: block;
}

/* Part F - Authorising Officer */
#part_f_form label,
#part_f_form input[type="text"] {
    display: block;
}

/* Part G - Claim Summary (For Accounts Officer's Use Only) */
#part_g_form label,
#part_g_form input[type="number"],
#part_g_form input[type="text"] {
    display: block;
}

/* Part H - Additional Notes */
#part_h_form p {
    font-style: italic;
}

/* Buttons */
.button-container {
    margin-top: 20px;
    text-align: center;
}

.button-container button {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.button-container button:hover {
    background-color: #0056b3;
}

</style>
<?php include 'footer.php'; ?>
