<?php


//Include the Database Information
include 'db.php';

//Get the property ID to retrieve the data for. Remove possible dodgy characters
$propertyID = filter_input(INPUT_POST, 'property_id');

/**
 * Retrieve links, address and agent information based off house ID passed from the
 * end of the URL.
 * Parametise Query in case of unlikely event of SQL Injection.
 */
$get = $db->prepare('SELECT properties.address address, properties.matterport_link matterport_link, properties.realestate_link realestate_link, properties.googlemaps_link googlemaps_link, 
          agents.name agentName, agents.position agentPosition, agents.contact agentContact, agents.website agentWebsite, agents.company_logo agentCompany_logo, agents.agent_photo agent_photo
          FROM properties
          INNER JOIN agents
          ON properties.agent_id=agents.id 
          WHERE properties.id = ?');
$get->bind_param('s', $propertyID);
$get->execute();
$result = $get->get_result();
$row = $result->fetch_assoc();


//Put the URL's into an associative array to json encode later
$URLS = array(
    'matterport_link' => $row['matterport_link'],
    'realestate_link' => $row['realestate_link'],
	'agent_website' => $row['agentWebsite'],
    'googlemaps_link' => $row['googlemaps_link']
);

//Put the agent data into an associative array to json encode later
$agent = array(
    'name' => $row['agentName'],
    'position' => $row['agentPosition'],
    'contact' => $row['agentContact'],
    'company_logo' => $row['agentCompany_logo'],
    'agent_photo' => $row['agent_photo'],
);

/**
 * Put the two arrays into one multidimensional data array
 * so that it can be passed back to the AJAX query
 */
$multidimensional = array(
    'URLS' => $URLS,
    'agent' => $agent
);

/**
 * Encode the array into JSON form and overwrite the original
 * array with the new JSON one.
 * Then echo it so it can be passed back to the AJAX Query.
 */

$data = json_encode($multidimensional);
echo($data);