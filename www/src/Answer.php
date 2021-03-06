<?php
require_once "db/db.php";

require_once "DbElement.php";

class Answer implements DbElement
{
    protected int $themeID;
    protected int $userID;
    protected string $date;
    protected string $text;
    protected int $id;


    // Constructor
    /**
     * answer constructor.
     * @param int $themeID
     * @param int $userID
     * @param string $text
     * @param int $id
     * @param string $date
     */
    public function __construct(int $themeID, int $userID, string $text, int $id = -1,
                                string $date = "")
    {
        $this->themeID = $themeID;
        $this->userID = $userID;
        $this->text = $text;
        $this->id = $id;

        if ($date == "") $this->date = date("d.m.Y", time());
        else $this->date = $date;

    }

    // Static functions
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
                $connection->doQuery("INSERT INTO articles (text, userID, themeID, date) VALUES ('"
                    . $this->text . "', " . $this->userID . ", " . $this->themeID . ", '" . $this->date . "')");

                $_SESSION['success'] = "Eine neue Antwort zum Thema '" . Theme::loadByID($this->themeID)->getHeadline()
                    . "' wurde erstellt";

                $res = $connection->doQuery("SELECT ID FROM articles WHERE 1 ORDER BY ID DESC"); // Gets the last ID

                $this->id = $res->fetch_assoc()['ID'];
                $connection->closeConnection();

                return $this->id;
            } catch (Exception $e) {
                $connection->closeConnection();

                throw new Exception("Ein Fehler in der ??bermittlung ist aufgetreten.");//error description

            }
        }
        else
        {
            throw new Exception("Diese Antwort ist bereits in der Dabenbank registriert");
        }

    }

    /**
     * @param int $id
     * @return dbElement
     */
    public static function loadByID(int $id): dbElement
    {
        return new Answer();
    }

    // Getters
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


    // Other functions
    public function __toString()
    {
        // Headline
        $text = '   <div id="answer-'.$this->id.'" class="article-entry">
                        <div class="information">Anwort von ';

        // Username
        try {
            $text .= User::loadByID($this->userID)->getName();
        } catch (Exception $e) {
            $text .= "UNBEKANNT";
        }

        // Date
        $text .= ' - '.$this->date.'</div>';

        // Content
        $text .= '<div class="article-content">'. nl2br($this->text).'</div>
                    </div>';

        return $text;
    }

}

require_once "Theme.php";
require_once "User.php";
require_once "AnswerWithPicture.php";