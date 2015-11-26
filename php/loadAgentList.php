<?php

//Include the Database Information
include 'db.php';

//Declare the results array
$results = array();

/**
 * Get all of the agent ID's and associated names, in name order.
 */
$get = $db->prepare('SELECT id, name FROM agents ORDER BY name ASC');
$get->execute();

$result = $get->get_result();

while ($row = $result->fetch_assoc()){
	$data = array("id" => $row['id'],
				  'name' => $row['name']);
	array_push($results, $data);
}

$results = json_encode($results);

//Return the results to the AJAX query
echo $results;