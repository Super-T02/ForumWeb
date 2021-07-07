<?php
require_once "../src/db/db.php";


echo '
<!Doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="include/style/mainStyle.css">
    <title>Food Talk</title>
</head>
<body>';

echo '
<form name="sendPicture" method="post" action="uploadImage.php.php" enctype="multipart/form-data">
    Select image to upload:
    <input type="hidden" name="ok" value="j">
  <input type="file" name="picture" id="picture" >
  <input type="submit" value="Upload Image" name="submit">   
</form>
</body>
';