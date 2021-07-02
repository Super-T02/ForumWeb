<?php
require_once "db/db.php";

class Theme {
    private $headline;
    private $description;
    private $userID;
    private $date;
    private $id;
    private $views;
    private $answers;
    private $isInDB;

    /**
     * Theme constructor.
     * @param string $headline
     * @param string $description
     * @param int $userID default 2 for gast user
     * @param bool $isInDB
     */
    public function __construct(string $headline, string $description, int $userID = 2, bool $isInDB = False)
    {
        $this->headline = $headline;
        $this->description = $description;
        $this->userID = $userID;
        $this->date = date("d.m.Y", time());
        $this->isInDB = $isInDB;
    }

    /**
     * @throws Exception
     */
    public function alreadyInDB() : bool
    {
        if ($this->isInDB)
        {
            return true;
        }

        $connection = new DB_Connection();
        $connection->connect();

        try {
            $res = $connection->doQuery("SELECT * FROM themes WHERE headline = " . $this->headline . " and description = " . $this->description . " and userID = " . $this->userID . "and lastChange = " . $this->date);

            if($res->num_rows > 1){
                $this->isInDB = true;
                return true;
            }
        }
        catch (Exception $e) {
            throw new Exception("The Query gets the error: " . $e->getMessage()); //error description
        } finally {
            $connection->closeConnection();
        }

        return false;
    }

    /**
     * @throws Exception
     */
    public function sendToDB()
    {
        if(!$this->isInDB)
        {
            date_default_timezone_set("Europe/Berlin");
            $connection = new DB_Connection();
            $connection->connect();

            //security for unescaped strings
            $connection->getConn()->real_escape_string($this->headline);
            $connection->getConn()->real_escape_string($this->description);

            // Send Data to DB
            try {
                $connection->doQuery("INSERT INTO themes (headline, description, userID, views, answers, lastChange) VALUES ('" . $this->headline . "', '" . $this->description . "', " . $this->userID . ", 0, 0, '" . $this->date . "')");
//                $_SESSION['successMessage'] = "Ein neues Thema mit dem Namen " . $this->headline . " wurde erstellt"; TODO: auslagern
                $this->isInDB = true;
                $res = $connection->doQuery("SELECT ID FROM themes WHERE 1 ORDER BY ID DESC"); // Gets the last ID
                $this->id = $res->fetch_assoc()['ID'];

            } catch (Exception $e) {
                $connection->closeConnection();

                throw new Exception("The Query gets the error: " . $e->getMessage());//error description

            } finally {
                $connection->closeConnection();
            }
        }

    }

    /**
     * @return int
     * Returns -1 if no id isset
     */
    public function getId() : int
    {
        if (isset($this->id)) return $this->id;
        else return -1;
    }
}




