<?php

class CarController
{
    private $connection;
    private $mileageTolerance = 20000; // adjust to your needs

    public function __construct($database)
    {
        $this->connection = $database->getConnection();
    }

    public function getCars($brandId, $model, $registration, $mileage, $fuelId, $rating)
    {
        $sql = "SELECT c.id, b.name as brand, c.model, c.initial_registration, c.description, c.mileage, c.price, f.name as fuel FROM cars c 
            LEFT JOIN brands b ON c.brand_id = b.id
            LEFT JOIN fuels f ON c.fuel_id = f.id
            WHERE b.id = :brandId";

        if ($model) {
            $sql .= " AND c.model = :model";
        }
        if ($registration) {
            $sql .= " AND c.initial_registration = :registration";
        }
        if ($mileage) {
            $sql .= " AND c.mileage BETWEEN :mileageToleranceLower AND :mileageToleranceUpper";
        }
        if ($fuelId) {
            $sql .= " AND f.id = :fuelId";
        }

        $sql .= " ORDER BY c.price ASC";

        $statement = $this->connection->prepare($sql);

        $statement->bindValue(":brandId", $brandId);
        if ($model) {
            $statement->bindValue(":model", $model);
        }
        if ($registration) {
            $statement->bindValue(":registration", $registration);
        }
        if ($mileage) {
            $statement->bindValue(":mileageToleranceLower", $mileage - $this->mileageTolerance / 2);
            $statement->bindValue(":mileageToleranceUpper", $mileage + $this->mileageTolerance / 2);
        }
        if ($fuelId) {
            $statement->bindValue(":fuelId", $fuelId);
        }

        $statement->execute();

        $data = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        $dataCount = count($data);

        if ($rating) {
            $minValue = $dataCount > 0 ? $data[0]['price'] : null;
            $maxValue = $minValue ? ($dataCount > 1 ? $data[$dataCount - 1]['price'] : $minValue) : null;

            echo json_encode([
                'data' => $data,
                'total' => $dataCount,
                'rating' => [
                    'minValue' => $minValue,
                    'maxValue' => $maxValue,
                ]
            ]);

            exit;
        }

        echo json_encode([
            'data' => $data,
            'total' => $dataCount,
        ]);
    }

    public function getModels($brandId)
    {
        $sql = "SELECT DISTINCT model FROM cars c
            WHERE c.brand_id = :brandId";

        $statement = $this->connection->prepare($sql);
        $statement->bindValue(":brandId", $brandId);
        $statement->execute();

        $data = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        echo json_encode($data);
    }

    public function getInitialRegistrations($brandId, $model)
    {
        $sql = "SELECT DISTINCT c.initial_registration FROM cars c
            WHERE c.brand_id = :brandId
            AND c.model = :model
            ORDER BY c.initial_registration DESC";

        $statement = $this->connection->prepare($sql);
        $statement->bindValue(":brandId", $brandId);
        $statement->bindValue(":model", $model);
        $statement->execute();

        $data = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        echo json_encode($data);
    }

    public function getFuels($brandId, $model, $registration)
    {
        $sql = "SELECT DISTINCT f.name FROM cars c
            LEFT JOIN fuels f ON c.fuel_id = f.id
            WHERE c.brand_id = :brandId
            AND c.model = :model
            AND c.initial_registration = :registration";

        $statement = $this->connection->prepare($sql);
        $statement->bindValue(":brandId", $brandId);
        $statement->bindValue(":model", $model);
        $statement->bindValue(":registration", $registration);
        $statement->execute();

        $data = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        echo json_encode($data);
    }
}
