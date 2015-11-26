<?php

//Include the Database Information
include 'db.php';
//Get the property ID to retrieve the data for. Remove possible dodgy characters
$propertyID = filter_input(INPUT_POST, 'selectedProperty');

/**
 * Retrieve links, address and agent information based off house ID passed from the
 * end of the URL.
 * Parametise Query in case of unlikely event of SQL Injection.
 */
$get = $db->prepare('SELECT address, matterport_link, realestate_link, googlemaps_link, agent_id FROM properties WHERE id = ?' );
$get->bind_param('s', $propertyID);
$get->execute();
$result = $get->get_result();
$row = $result->fetch_assoc();

//Put the details into an associative array to json encode later
$array = array(
    'address' => $row['address'],
    'matterport_link' => $row['matterport_link'],
    'realestate_link' => $row['realestate_link'],
    'googlemaps_link' => $row['googlemaps_link'],
    'agent_id' => $row['agent_id']
);

/**
 * Encode the array into JSON form and overwrite the original
 * array with the new JSON one.
 * Then echo it so it can be passed back to the AJAX Query.
 */
$data = json_encode($array);
echo($data);