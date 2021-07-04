<?php
require_once "db/db.php";


$connection = new DB_Connection();
$connection->connect();

$ID = $_GET['themeID'];
$answers = 0;
$views = 0;

//Query to get the theme
try {
    $result = $connection->doQuery("SELECT themes.ID, themes.headline, themes.description, themes.views, themes.answers, themes.lastChange, users.userName FROM themes JOIN users ON themes.userID = users.ID WHERE themes.ID = " . $ID);
} catch (Exception $e) {
    //set standard answer
    echo  '    <div id="question" class="article-entry">
                    Dieser Artikel ist nicht vorhanden!
                </div>
    ';
}

require_once "include/answerModal.php";

//if there are any results
if ($result->num_rows > 0) {

    //gets the results of each row and echos the theme header
    while($row = $result->fetch_assoc()) {
        echo '  <div id="question" class="article-entry theme">
                    <div class="headline">'.$row['headline'].'</div>
                    <hr>
                    <div class="information">'.$row['userName'].' - '.$row['lastChange'].'</div>
                    <div class="article-content">'.$row['description'].'</div>
                    <hr>
                    <button id="theme-'.$row['ID'].'" class="answer" onclick="createAnswer()">Antworten...</button>
                </div>';
    }

    //Query to get the answers of this theme
    try {
        $result = $connection->doQuery("SELECT articles.text, users.userName, articles.date FROM articles JOIN users ON articles.userID = users.ID WHERE articles.themeID = " . $ID);
    } catch (Exception $e) {
        //set standard answer
        echo  '    <div id="question" class="article-entry">
                   Bisher sind noch keine Antworten vorhanden!
                </div>
    ';
    }

    //echos the answers
    while ($row = $result->fetch_assoc()){
        echo '
        <div id="answer-0" class="article-entry">
            <div class="information">Anwort von '.$row['userName'].' - '.$row['date'].'</div>
            <div class="article-content">'.$row['text'].'</div>
        </div>
        ';
    }

    //increases Number of views
    try {
        $result = $connection->doQuery("SELECT themes.ID, themes.views FROM themes WHERE themes.ID = " . $ID);
    } catch (Exception $e) {
        echo $e->getTrace();
    }

    while ($row = $result->fetch_assoc()){
        $views = $row['views'];
    }

    $views ++;

    try {
        $result = $connection->doQuery("UPDATE themes SET views = ".$views." WHERE ID = " . $ID);
    } catch (Exception $e) {
        echo $e->getTrace();
    }

} else {
    //set standard answer
    echo  '    <div id="question" class="article-entry">
                    Dieser Artikel ist nicht vorhanden!
                </div>
    ';
}





$connection->closeConnection();