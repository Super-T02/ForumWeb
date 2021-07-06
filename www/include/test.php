<?php
require_once "../src/db/db.php";

/* Connect to MySQL database */
//mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = new mysqli("db", "root", "test", "forum");

/* Set the desired charset after establishing a connection */
//$mysqli->set_charset("utf8mb4");

/* Retrieve random value */
$result = $mysqli-> query("SELECT * FROM themes");
$name = $result->fetch_row()[0];