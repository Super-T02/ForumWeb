<?php


class answer
{
    private $themeID;
    private $userID;
    private $date;
    private $text;
    private $id;

    /**
     * answer constructor.
     * @param $themeID
     * @param $userID
     * @param $text
     */
    public function __construct($themeID, $userID, $text)
    {
        $this->themeID = $themeID;
        $this->userID = $userID;
        $this->text = $text;
        $this->date = date("d.m.Y", time());
    }

    /**
     * @throws Exception
     */
    public function sendToDB()
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
     * @return mixed
     */
    public function getThemeID()
    {
        return $this->themeID;
    }

    /**
     * @return mixed
     */
    public function getUserID()
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
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


}