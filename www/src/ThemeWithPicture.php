<?php
require_once "Theme.php";


class ThemeWithPicture extends Theme
{
    private int $pictureID;

    // Constructor
    /**
     * ThemeWithPicture constructor.
     * @param string $headline
     * @param string $description
     * @param int $pictureID
     * @param int $userID
     * @param int $id
     * @param int $views
     * @param int $answers
     * @param string $date
     * @throws Exception
     */
    public function __construct(string $headline, string $description, int $pictureID, int $userID = 2, int $id = -1,
                                int $views = 0, int $answers = 0, string $date = "")
    {
        parent::__construct($headline, $description, $userID, $id, $views, $answers, $date);

        $this->pictureID = $pictureID;
    }

    // Other functions
    /**
     * @throws Exception
     */
    public function sendToDB()
    {
        date_default_timezone_set("Europe/Berlin");
        $connection = new DB_Connection();
        $connection->connect();

        //security for unescaped strings
        $connection->getConn()->real_escape_string($this->headline);
        $connection->getConn()->real_escape_string($this->description);

        // Send Data to DB
        try {
            $query = "INSERT INTO themes (headline, description, userID, views, answers, lastChange, pictureID)".
                "VALUES ('" . $this->headline . "', '" . $this->description . "', " . $this->userID . ", 0, 0, '"
                . $this->date .
                "', ".$this->pictureID.")";

            $connection->doQuery($query);

            $_SESSION['success'] = "Ein neues Thema mit dem Namen '" . $this->headline . "' wurde erstellt.";

            //Get the ID of this theme
            $res = $connection->doQuery("SELECT ID FROM themes WHERE 1 ORDER BY ID DESC"); // Gets the last ID
            $this->id = $res->fetch_assoc()['ID'];

        } catch (Exception $e) {
            $connection->closeConnection();

            throw new Exception("The Query gets the error: " . $e->getMessage());//error description

        } finally {
            $connection->closeConnection();
        }

    }

    /**
     * @throws Exception
     */
    public function __toString()
    {
        // If there is no article
        if ($this->id < 0) return '<div id="question" class="article-entry">
                                        Dieser Artikel ist nicht vorhanden!
                                   </div>';

        // Headline
        $text = '<div id="question" class="article-entry theme">
                        <div class="headline">' . $this->headline . '</div>
                        <hr>
                        <div class="information">';
        // Username
        try {
            $text .= User::getUserByID($this->userID)->getName();
        } catch (Exception $e) {
            $text .= "UNBEKANNT";
        }

        $text.= ' - ' . $this->date .'</div>';

        // Picture
        $text .= "<br>";
        $pic = Picture::loadByID($this->pictureID);
        $text .= $pic;

        // text
        $text .= '
                        <div class="article-content">' . nl2br($this->description) . '</div>
                        <hr>
                        <button id="theme-' . $this->id . '" class="answer" onclick="document.getElementById(\'answer\').style.display = \'block\';">Antworten...</button>
                    </div>
                    ';

        // Answers
        if ($this->answers > 0) {
            //Print the Answers
            foreach ($this->listOFAnswers as $answer) {
                $text .= $answer;
            }
        }
        // std answer
        else $text .= ' <div id="answer-0" class="article-entry">
                           Bisher sind noch keine Antworten vorhanden!
                        </div>';


        return $text;
    }


}