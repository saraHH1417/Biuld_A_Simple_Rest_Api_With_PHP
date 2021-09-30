<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once("../../config/Database.php");
include_once("../../models/Categories.php");

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$category = new Categories($db);

$category->id = isset($_GET['id']) ? $_GET['id'] : die('Please enter ID');
// Blog post query
$result = $category->read_single();


// Check if any posts received

$category_item = array(
    'id'  => $category->id,
    'name' => $category->name,
    'created_at' => $category->created_at
);
echo json_encode($category_item);
