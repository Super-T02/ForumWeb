<?php
require_once "db/db.php";
require_once "Theme.php";
require_once "User.php";

class answer
{
    private $themeID;
    private $userID;
    private $date;
    private $text;
    private $id;

    /**
     * answer constructor.
     * @param int $themeID
     * @param int $userID
     * @param string $text
     * @param int $id
     * @param string $date
     */
    public function __construct(int $themeID, int $userID, string $text, int $id = -1, string $date = "")
    {
        $this->themeID = $themeID;
        $this->userID = $userID;
        $this->text = $text;
        $this->id = $id;

        if ($date == "") $this->date = date("d.m.Y", time());
        else $this->date = $date;

    }

    /**
     * Sends a new answer to the database and returns it ID.
     *
     * @return int
     * @throws Exception
     */
    public function sendToDB():int
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
                $connection->doQuery("INSERT INTO articles (text, userID, themeID, date) VALUES ('" . $this->text . "', " . $this->userID . ", " . $this->themeID . ", '" . $this->date . "')");
//                $_SESSION['successMessage'] = "Eine neue Antwort zum Thema " . $this->headline . " wurde erstellt"; TODO: auslagern
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
     * @return int
     */
    public function getThemeID(): int
    {
        return $this->themeID;
    }

    /**
     * @return int
     */
    public function getUserID(): int
    {
        return $this->userID;
    }

    /**
     * @return false|string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function __toString()
    {
        $text = '   <div id="answer-'.$this->id.'" class="article-entry">
                        <div class="information">Anwort von ';
        try {
            $text .= User::getUserByID($this->userID)->getName();
        } catch (Exception $e) {
            $text .= "UNBEKANNT";
        }

        $text .= ' - '.$this->date.'</div>
                        <div class="article-content">'.$this->text.'</div>
                    </div>';

        return $text;
    }


}