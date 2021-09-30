<?php

// headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type , Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once '../../config/Database.php';
include_once '../../models/Categories.php';

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$category = new Categories($db);


// GET raw posted data
$data = json_decode(file_get_contents("php://input"));

$category->name = $data->name;

// create post
if($category->create()) {
    echo json_encode(
        array("message" => "Category Created.")
    );
}else {
    echo json_encode(
        array("message" => "Category not created.")
    );
};

