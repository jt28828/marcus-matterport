<?php

//Include the Database Information
include 'db.php';

//Declaring data to be retrieved / input as well as success indicator;
$indicator;
$name;
$position;
$contact;
$website;
$agent_photo;

//Get the input data, filter for appropriate data types and illegal characters. 
//If wrong send back false
if (!empty($_POST['name'])) {
    $name = filter_input(INPUT_POST, 'name');
} else {
    finish(false);}

if (!empty($_POST['position'])) {
    $position = filter_input(INPUT_POST, 'position');
} else {
    finish(false);}

if (!empty($_POST['contact'])) {
    $contact = filter_input(INPUT_POST, 'contact', FILTER_SANITIZE_EMAIL);
} else {
    finish(false);}

if (!empty($_POST['website'])) {
    if ((strpos($_POST['website'], 'http://') === false) && (strpos($_POST['website'], 'https://') === false) {
        $website = 'http://' . $_POST['website'];
    } else {
        $website = $_POST['website'];
    } if (!filter_var($website, FILTER_VALIDATE_URL)) {
        finish(false);
    }
} else {
    finish(false);
}	

if (!empty($_POST['agent_photo'])) {
    $agent_photo = filter_input(INPUT_POST, 'agent_photo');
} else {
    finish(false);
}

if (!empty($_POST['company_logo'])) {
    $company_logo = filter_input(INPUT_POST, 'company_logo');
} else {
    finish(false);
}

/**
 * Insert the data into the database, and check if insert was successful.
 */
$insert = $db->prepare('INSERT INTO agents (name, position, contact, website, agent_photo, company_logo) VALUES (?,?,?,?,?,?)');
$insert->bind_param('ssssss', $name, $position, $contact, $website, $agent_photo, $company_logo);


if ($insert->execute()) {
    finish(true);
} else{
	die($insert->error);
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
