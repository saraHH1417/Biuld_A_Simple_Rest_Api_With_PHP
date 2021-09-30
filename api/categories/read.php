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

    // Blog post query
    $result = $category->read();
    // Get row count
    $num = $result->rowCount();

    // Check if any posts received
    if ($num > 0) {

        $result_arr = array();
        $result_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $category_item = array(
              'id'  => $id,
              'name' => $name,
              'created_at' => $created_at
            );

            array_push($result_arr['data'], $category_item);
        }

        echo json_encode($result_arr['data']);

    }else {
        echo "No categories found.";
    }