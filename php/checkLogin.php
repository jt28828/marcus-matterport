<?php
include 'db.php';
session_start();

if (isset($_SESSION['temporaryLogin'])) {
    $email = $_SESSION['temporaryLogin'];
    /**
     * Check the database for that username and retrieve their email
     */
    $check = $db->prepare('SELECT email FROM users WHERE email LIKE ?');
    $check->bind_param('s', $email);
    $check->execute();
    $result = $check->get_result();

    if (mysqli_num_rows($result) > 0) {
        header("Location: ../dashboard.php");
        exit();
    } else {
        header("Location: ../login.html");
        exit();
    }
} else {
	    header("Location: ../login.html");
        exit();
}