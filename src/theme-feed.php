<?php
require_once "db/db.php";

$connection = new DB_Connection();
$connection->connect();

$ID = $_GET['themeID'];

try {
    $result = $connection->doQuery("SELECT themes.headline, themes.description, themes.views, themes.answers, themes.lastChange, users.userName FROM themes JOIN users ON themes.userID = users.ID WHERE themes.ID = " . $ID);
} catch (Exception $e) {
    //set standard answer
    echo  '    <div id="question" class="article-entry">
                    Dieser Artikel ist nicht vorhanden!
                </div>
    ';
}

//if there are any results
if ($result->num_rows > 0) {
    //gets the results of each row
    while($row = $result->fetch_assoc()) {
        echo '  <div id="question" class="article-entry">
                    <div class="headline">'.$row['headline'].'</div>
                    <hr>
                    <div class="information">'.$row['userName'].' - '.$row['lastChange'].'</div>
                    <div class="article-content">'.$row['description'].'</div>
                </div>';
    }
} else {
    //set standard answer
    echo  '    <div id="question" class="article-entry">
                    Dieser Artikel ist nicht vorhanden!
                </div>
    ';
}

$connection->closeConnection();


//
//<div id="answer-0" class="article-entry">
//                    <div class="information">Anwort von Tom - 19.06.2021</div>
//                    <div class="article-content">Heute ist das Tolle Fußballspiel</div>
//                </div>
