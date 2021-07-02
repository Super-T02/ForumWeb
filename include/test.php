<?php
require "../src/db/db.php";

$connection = new DB_Connection();
$connection->connect();

try {
    $res = $connection->doQuery("SELECT * FROM themes WHERE headline = 'qwertz' and description = 'qwertz' and userID = 1 and lastChange = '0000'");
    if($res->num_rows > 1){

    }
}
catch (Exception $e) {
    $_SESSION['err'] = "The Query gets the error: " . $e->getMessage(); //error description
} finally {
    $connection->closeConnection();
}