<?php

// headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type , Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once '../../config/Database.php';
include_once '../../models/Categories.php';

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$category= new Categories($db);


// GET raw posted data
$data = json_decode(file_get_contents("php://input"));


$category->id = $data->id;

// Delete post
try{
    $category->id = intval($category->id);
    if ($category->delete()) {
        echo json_encode(
            array("message" => "Category Deleted.")
        );
    } else {
        echo json_encode(
            array("message" => "Deleting category failed.")
        );
    }
}catch(Exception $e) {
    echo "Please enter a number for id " . $e->getMessage();
}