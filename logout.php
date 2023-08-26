<?php
session_start();
// Clear the session and redirect to the login page
session_unset();
session_destroy();
header('Location: login.php');
exit;
?>
