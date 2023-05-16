<?php
session_start(); // Start the session

if (isset($_POST['buttonSK'])) {
    $_SESSION['lang'] = "SK"; // Set the session variable
    // Perform other actions as needed
}

if (isset($_POST['buttonEN'])) {
    $_SESSION['lang'] = "EN"; // Set the session variable
    // Perform other actions as needed
}

// Redirect to the page where the form was submitted from
$referer = $_SERVER['HTTP_REFERER'];
header("Location: $referer");
exit();