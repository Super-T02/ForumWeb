<?php
require_once "sessionHeader.php";
require_once "../src/db/db.php";
require_once "../src/User.php";


// Checkout
unset($_SESSION['userID']);
unset($_SESSION['username']);
unset($_SESSION['login']);

$_SESSION['success'] = "Erfolgreich abgemeldet";
header("Location: ../index.php");
