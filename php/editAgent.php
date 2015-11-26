<?php

//Include the Database Information
include 'db.php';

//Declaring data to be retrieved / input as well as success indicator;
$urlString = array('http://','https://');
$indicator;
$id;
$name;
$position;
$contact;
$website;
$agent_photo;

//Get the input data, filter for appropriate data types and illegal characters. 
//If wrong send back false
if (!empty($_POST['id'])) {
    $id = filter_input(INPUT_POST, 'id');
} else {
    finish(false);
}

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
    if ((strpos($_POST['website'], 'http://') === false) && (strpos($_POST['website'], 'https://') === false))  {
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
	    $photo = true;
} else {
    $photo = false;
}

if (!empty($_POST['company_logo'])) {
    $company_logo = filter_input(INPUT_POST, 'company_logo');
	    $logo = true;
} else {
    $logo = false;
}

/**
 * Check which combination of images the user has input.
 * Either one, both or none.
 * Only input what the user changed into the database
 */
if ($photo == false || $logo == false) {

    if ($photo == false && $logo == false) {
        $insert = $db->prepare('UPDATE agents SET name = ?, position = ?, contact = ?, 
                        website = ?
                        WHERE id = ?');
        $insert->bind_param('ssssi', $name, $position, $contact, $website, $id);
    } elseif ($photo == false) {
        $insert = $db->prepare('UPDATE agents SET name = ?, position = ?, contact = ?, 
                        website = ?, company_logo = ?
                        WHERE id = ?');
        $insert->bind_param('sssssi', $name, $position, $contact, $website, $company_logo, $id);
    } else {
        $insert = $db->prepare('UPDATE agents SET name = ?, position = ?, contact = ?, 
                        website = ?, agent_photo = ?
                        WHERE id = ?');
        $insert->bind_param('sssssi', $name, $position, $contact, $website, $agent_photo, $id);
    }
} else {
    $insert = $db->prepare('UPDATE agents SET name = ?, position = ?, contact = ?, 
                        website = ?, agent_photo = ?, company_logo = ?
                        WHERE id = ?');
    $insert->bind_param('ssssssi', $name, $position, $contact, $website, $agent_photo, $company_logo, $id);
}

/**
 * Insert the data into the database, and check if insert was successful.
 */
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
