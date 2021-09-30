<?php

class Categories
{
    // db stuff
    private $conn;
    private $table = 'categories';

    //Post properties
    public $id;
    public $name;

    // Cunstructor with db
    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at desc";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function read_single() {
        $query = "SELECT * FROM " . $this->table. " WHERE id= ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        if(!empty($this->id)) {
            $stmt->bindParam(1, $this->id);
            if ($stmt->execute()) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->id = $result['id'];
                $this->name = $result['name'];
                $this->created_at = $result['created_at'];
            }else {
                printf("ERROR %s \n.", $stmt->error);
            }

        }else {
            die("Operation failed");
        }
    }

    public function create()
    {
        $query = 'DELETE FROM ' .
                     $this->table . '
                     (id ,name , created_at)
                VALUES
                    ("",:name , "")';


        $this->name = htmlspecialchars(strip_tags($this->name));

        if(!empty($this->name)) {
            $stmt = $this->conn->prepare($query);

            //Bind param
            $stmt->bindParam(":name", $this->name);

            if($stmt->execute()) {
                return true;
            }else {
                printf("Error %s \n", $stmt->error);
                return false;
            }
        }else {
            echo "Please enter valid name";
        }

    }

    public function delete()
    {
        $query = 'DELETE FROM ' .
            $this->table . '
                 WHERE 
                    id = :id';

        $this->id = htmlspecialchars(strip_tags($this->id));

        if(!empty($this->id)) {
            $stmt = $this->conn->prepare($query);

            //Bind param
            $stmt->bindParam(":id", $this->id);

            if($stmt->execute()) {
                return true;
            }else {
                printf("Error %s \n", $stmt->error);
                return false;
            }
        }else {
            echo "Please enter valid id";
        }


    }

    public function update()
    {
        $query = 'UPDATE ' .
                        $this->table . '
                SET
                    name = :name
                WHERE
                    id= :id';


        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->id = htmlspecialchars(strip_tags($this->id));

        if(!empty($this->name) && !empty($this->id)) {
            $stmt = $this->conn->prepare($query);

            //Bind param
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":id" , $this->id);

            if($stmt->execute()) {
                return true;
            }else {
                printf("Error %s \n", $stmt->error);
                return false;
            }
        }else {
            echo "Please enter valid name and id";
        }

    }

}