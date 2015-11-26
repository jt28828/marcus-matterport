<?php

//Get the property ID from the select Box
$id = $_POST['id'];

echo('http://' . $_SERVER['HTTP_HOST'] . "?p=".$id);