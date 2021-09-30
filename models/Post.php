<?php

class Post
{
    // db stuff
    private $conn;
    private $table = 'posts';

    //Post properties
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    // Cunstructor with db
    public function __construct($db) {
        $this->conn = $db;
    }

    //Get posts
    public function read() {
        // Create query
        $query = 'SELECT 
            c.name as category_name,
            p.id,
            p.category_id,
            p.title,
            p.body,
            p.author,
            p.created_at
          FROM '
            . $this->table . ' p
          LEFT JOIN
             categories c ON p.category_id = c.id
          ORDER BY 
             p.created_at DESC';

        // prepare statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

       return $stmt;
    }

    // Get single post
    public function read_single() {
        // Create query
        $query = 'SELECT
            c.name as category_name,
            p.id,
            p.category_id,
            p.title,
            p.body,
            p.author,
            p.created_at
        FROM '
           . $this->table . ' p
           LEFT JOIN
            categories c ON p.category_id = c.id
          WHERE
            p.id = ?
          LIMIT 0,1';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind id
        $stmt->bindParam(1 , $this->id);
        
        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //Set Properties
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
    }

    // Create post
    public function create() {
        // Create query
        $query = 'INSERT INTO ' . $this->table . '
                    (category_id , title, body, author)
                  VALUES
                    (:category_id, :title, :body, :author)';

        // prepare statement
        $stmt = $this->conn->prepare($query);


        // clean data
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));

        if(!empty($this->category_id) && !empty($this->title) && !empty($this->body) && !empty($this->author)) {
            // Bind params
            $stmt->bindParam(':category_id', $this->category_id);
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':author', $this->author);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }else {
                printf("Error %s. \n ", $stmt->error);
                return false;
            }

        }else{
            printf("No Data received");
        }

    }


    // Update post
    public function update() {
        // Create query
        $query = 'UPDATE ' . $this->table . '
                    SET
                        title = :title,
                        body = :body,
                        author = :author,
                        category_id = :category_id
                    WHERE
                        id = :id';

        // prepare statement
        $stmt = $this->conn->prepare($query);


        // clean data
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->id = htmlspecialchars(strip_tags($this->id));

        if(!empty($this->category_id) && !empty($this->title) && !empty($this->body) && !empty($this->author)
                    && !empty($this->id) ) {
            // Bind params
            $stmt->bindParam(':category_id', $this->category_id);
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':id', $this->id);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }else {
                printf("Error %s. \n ", $stmt->error);
                return false;
            }

        }else{
            printf("No Data received");
        }

    }


    // Delete post
    public function delete()
    {
        // create query
        $query = 'DELETE FROM '
                    . $this->table .
                ' WHERE
                    id =:id ';

        // prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        if(!empty($this->id)) {
            // bind value
            $stmt->bindParam(':id', $this->id);

            // execute
            if ($stmt->execute()) {
                return true;
            } else {
                printf("Error %s \n.", $stmt->error);
                return false;
            }
        }else {
            echo "Please enter valid Id";
            die();
        }
    }

}