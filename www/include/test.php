<?php
require_once "sessionHeader.php";
require_once "../src/db/db.php";
require_once "../src/Picture.php";

Picture::loadByURL();
