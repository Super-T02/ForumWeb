<?php
require_once "Answer.php";


class AnswerWithPicture extends Answer
{
    private int $pictureID;

    /**
     * answer constructor.
     * @param int $themeID
     * @param int $userID
     * @param string $text
     * @param int $pictureID
     * @param int $id
     * @param string $date
     */
    public function __construct(int $themeID, int $userID, string $text, int $pictureID, int $id = -1, string $date = "")
    {
        parent::__construct($themeID, $userID, $text, $id, $date);

        $this->pictureID = $pictureID;
    }

    /**
     * Sends a new answer to the database and returns it ID.
     *
     * @return int
     * @throws Exception
     */
    public function sendToDB(): int
    {
        if ($this->id == -1)
        {
            date_default_timezone_set("Europe/Berlin");
            $connection = new DB_Connection();
            $connection->connect();

            //security for unescaped strings
            $connection->getConn()->real_escape_string($this->text);

            // Send Data to DB
            try {
                $connection->doQuery("INSERT INTO articles (text, userID, themeID, date, pictureID) VALUES ('"
                    . $this->text . "', " . $this->userID . ", " . $this->themeID . ", '" . $this->date . "', "
                    .$this->pictureID.")");

                $_SESSION['success'] = "Eine neue Antwort zum Thema '" . Theme::loadByID($this->themeID)->getHeadline()
                    . "' wurde erstellt";

                $res = $connection->doQuery("SELECT ID FROM articles WHERE 1 ORDER BY ID DESC"); // Gets the last ID

                $this->id = $res->fetch_assoc()['ID'];

                $connection->closeConnection();

                return $this->id;
            } catch (Exception $e) {
                $connection->closeConnection();

                throw new Exception("Ein Fehler in der Übermittlung ist aufgetreten.");//error description

            }
        }
        else
        {
            throw new Exception("Diese Antwort ist bereits in der Dabenbank registriert");
        }
    }

    /**
     * @throws Exception
     */
    public function __toString()
    {
        // Headline
        $text = '   <div id="answer-'.$this->id.'" class="article-entry">
                        <div class="information">Anwort von ';

        // Username
        try {
            $text .= User::getUserByID($this->userID)->getName();
        } catch (Exception $e) {
            $text .= "UNBEKANNT";
        }

        // Date
        $text .= ' - '.$this->date.'</div>';

        // Picture
        $text .= "<br>";
        $pic = Picture::loadByID($this->pictureID);
        $text .= $pic;

        // Content
        $text .= '<div class="article-content">'.nl2br($this->text).'</div>
                    </div>';

        return $text;
    }


}

