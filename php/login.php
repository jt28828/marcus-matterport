<?php

include 'db.php';
session_start();

//Declaring Variables
$email;
$inputPassword;

/**
 * Check if fields are empty.
 * If not then save the values to a variable
 */
 

if (!empty($_POST['email'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
} else {
    finish(false);
}

if (!empty($_POST['password'])) {
    $inputPassword = filter_input(INPUT_POST, 'password');
} else {
    finish(false);
}

/**
 * Check the database for that username and retrieve their email
 */
$check = $db->prepare('SELECT email FROM users WHERE email LIKE ? AND password LIKE ?');
$check->bind_param('ss', $email, $inputPassword);
$check->execute();
$result = $check->get_result();

if (mysqli_num_rows($result) > 0) {
	$_SESSION['temporaryLogin'] = $email;
    finish(true);
} else {
    finish(false);
}

/**
 * Once validation and entry is complete, data is left blank, or invalid data is input,
 * return the indicator to show whether input was a success or not.
 */
function finish($indicator) {
    echo $indicator;
    exit();
}