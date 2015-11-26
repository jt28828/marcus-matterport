<?php

//Include the Database Information
include 'db.php';

//Declare the results array
$results = array();

/**
 * Get all of the property ID's and associated addresses, in address order.
 */
$get = $db->prepare('SELECT id, address FROM properties ORDER BY address ASC');
$get->execute();

$result = $get->get_result();

while ($row = $result->fetch_assoc()){
	$data = array("id" => $row['id'],
            	  'address' => $row['address']);
	array_push($results, $data);
}

$results = json_encode($results);

//Return the results to the AJAX query
echo $results;