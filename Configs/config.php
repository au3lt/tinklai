<?php

include '../Models/Database.php';

$database = new Database();
$conn = $database->connect();

$tableUsers = "users";

function runQuery($sql) {
    global $conn;
    if(!$conn->query($sql))
        die();
}

?>
