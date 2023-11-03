<?php

class BrandController
{
    private $connection;

    public function __construct($database)
    {
        $this->connection = $database->getConnection();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM brands";
        $statement = $this->connection->query($sql);

        $data = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        echo json_encode($data);
    }
}
