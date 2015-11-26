<?php

//Include the Database Information
include 'db.php';

//Declaring data to be retrieved / input as well as success indicator;
$indicator;
$characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
$id = '';
$address;
$matterport_link;
$realestate_link;
$googlemaps_link;
$agent_id;

//Get the input data, filter for appropriate data types and illegal characters. 
//If wrong send back false

//Generate a random 6 character id string
for ($i = 0; $i < 6; $i++) {
    $id .= $characters[rand(0, strlen($characters) - 1)];
}

if (!empty($_POST['address'])) {
    $address = filter_input(INPUT_POST, 'address');
} else {
    $indicator = false;
    finish($indicator);
}

if (!empty($_POST['matterport_link'])) {
    if ((strpos($_POST['matterport_link'], 'http://') === false) && (strpos($_POST['matterport_link'], 'https://') {
        $matterport_link = 'http://' . $_POST['matterport_link'];
    } else {
        $matterport_link = $_POST['matterport_link'];
    } if (!filter_var($matterport_link, FILTER_VALIDATE_URL)) {
        finish(false);
    }
} else {
    finish(false);
}

    
if (!empty($_POST['realestate_link'])) {
    if ((strpos($_POST['realestate_link'], 'http://') === false) && (strpos($_POST['realestate_link'], 'https://') {
        $realestate_link = 'http://' . $_POST['realestate_link'];
    } else {
        $realestate_link = $_POST['realestate_link'];
    } if (!filter_var($realestate_link, FILTER_VALIDATE_URL)) {
        finish(false);
    }
} else {
    finish(false);
}


if (!empty($_POST['googlemaps_link'])) {
    if ((strpos($_POST['googlemaps_link'], 'http://') === false) && (strpos($_POST['googlemaps_link'], 'https://') {
        $googlemaps_link = 'http://' . $_POST['googlemaps_link'];
    } else {
        $googlemaps_link = $_POST['googlemaps_link'];
    } if (!filter_var($googlemaps_link, FILTER_VALIDATE_URL)) {
        finish(false);
    }
} else {
    finish(false);
}

if (!empty($_POST['agent_id'])) {
    $agent_id = filter_input(INPUT_POST, 'agent_id');
} else {
    $indicator = false;
    finish($indicator);
}

/**
 * Insert the data into the database, and check if insert was successful.
 */
$insert = $db->prepare('INSERT INTO properties (id, address, matterport_link, realestate_link, googlemaps_link, agent_id) values(?,?,?,?,?,?)');
$insert->bind_param('sssssi', $id, $address, $matterport_link, $realestate_link, $googlemaps_link, $agent_id);
if ($insert->execute()){
	$indicator = true;
	finish($indicator);
}




/**
 * Once validation and entry is complete, data is left blank, or invalid data is input,
 * return the indicator to show whether input was a success or not.
 */
function finish($indicator) {
    echo $indicator;
    exit();
}
