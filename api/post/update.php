<?php

    // headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type , Access-Control-Allow-Methods, Authorization, X-Requested-With");

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    // Instantiate DB and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $post = new Post($db);


    // GET raw posted data
    $data = json_decode(file_get_contents("php://input"));

    //SET ID TO UPDATE
    $post->id = $data->id;

    $post->title = $data->title;
    $post->body = $data->body;
    $post->author = $data->author;
    $post->category_id = $data->category_id;

    // create post
    if($post->update()) {
        echo json_encode(
            array("message" => "Post updated successfully.")
        );
    }else {
        echo json_encode(
            array("message" => "Post didn't updated successfully.")
        );
    };