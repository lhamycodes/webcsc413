<?php

class ORM
{
    public function __construct()
    {
        include_once 'helper/db.php';
    }

    public function query($table, $params, $fields = "*", $errorMessage = null)
    {
        global $conn;

        $result = mysqli_query($conn, "SELECT $fields FROM `$table` WHERE $params");
        if (mysqli_num_rows($result) < 1 && $errorMessage != null) {
            return $this->sendResponse(status: 'error', data: $errorMessage);
        }

        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }

        return $this->sendResponse(status: 'success', data: $rows);
    }

    public function queryRelationship($table, $join, $fields, $params)
    {
        global $conn;

        $result = mysqli_query($conn, "SELECT $fields FROM $table INNER JOIN $join WHERE $params");

        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }

        return $this->sendResponse(status: 'success', data: $rows);
    }

    public function insert($table, $data, $errorMessage)
    {
        global $conn;

        $keys = array_keys($data);
        $values = array_values($data);

        $query = "INSERT INTO `$table` (`" . implode('`, `', $keys) . "`) VALUES ('" . implode("', '", $values) . "')";
        mysqli_query($conn, $query);

        if (mysqli_affected_rows($conn) < 1) {
            return $this->sendResponse(status: 'error', data: $errorMessage . " - " . mysqli_error($conn));
        }

        return $this->sendResponse(status: 'success', data: "Created new $table record successfully");
    }

    private function sendResponse($status, $data)
    {
        return [$status, $data];
    }
}
