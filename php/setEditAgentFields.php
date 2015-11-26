<?php
//Include the Database Information
include 'db.php';
//Get the property ID to retrieve the data for. Remove possible dodgy characters
$agentID = filter_input(INPUT_POST, 'selectedAgent');;


/**
 * Retrieve links, address and agent information based off house ID passed from the
 * end of the URL.
 * Parametise Query in case of unlikely event of SQL Injection.
 */
$get = $db->prepare('SELECT name, position, contact, website, agent_photo FROM agents WHERE id = ?');
$get->bind_param('s', $agentID);		  
$get->execute();
$result = $get->get_result();
$row = $result->fetch_assoc();

//Put the URL's into an associative array to json encode later
$array = array(
    'name' => $row['name'],
    'position' => $row['position'],
    'contact' => $row['contact'],
    'website' => $row['website'],
    'agent_photo' => $row['agent_photo']
);

/**
 * Encode the array into JSON form and overwrite the original
 * array with the new JSON one.
 * Then echo it so it can be passed back to the AJAX Query.
 */
$data = json_encode($array);
echo($data);