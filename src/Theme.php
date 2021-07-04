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
    private $listOFAnswers;

    //static functions
    /**
     * @param int $id
     * @return Theme
     * @throws Exception
     *
     * Loads a single theme with the ID passed in and returns this theme.
     * It throws a exception if there is no theme with this ID.
     */
    public static function load(int $id): Theme
    {
        $connection = new DB_Connection();
        $connection->connect();

        // Send Data to DB
        try {
            $res = $connection->doQuery("SELECT * FROM themes WHERE ID = ". $id); // Gets the last ID
            $row = $res->fetch_assoc();
            return new Theme($row['headline'], $row['description'], $row['userID'], $row['ID'], $row['views'], $row['answers'], $row['lastChange']);
        } catch (Exception $e) {
            $connection->closeConnection();

            throw new Exception("The Query gets the error: " . $e->getMessage());//error description

        } finally {
            $connection->closeConnection();
        }
    }

    /**
     * @param string $headline
     * @param string $description
     * @return bool
     * @throws Exception
     *
     * Checks if there is any theme with the same headline or description and returns a bool value.
     */
    public static function checkDB(string $headline, string $description):bool
    {
        $connection = new DB_Connection();
        $connection->connect();

        try {
            $res = $connection->doQuery("SELECT * FROM themes WHERE headline = " . $headline . " and description = " . $description);

            if($res->num_rows > 0){
                return true;
            }
            else
            {
                return false;
            }
        }
        catch (Exception $e) {
            if($e->getMessage() == "Query returned false")
            {
                return false;
            }
            else{
                throw new Exception("In the Query went something wrong");
            }
        } finally {
            $connection->closeConnection();
        }
    }

    /**
     * @return array
     * @throws Exception
     */
    public static function loadAllThemes(): array
    {
        $listOfAllThemes = array();

        $connection = new DB_Connection();
        $connection->connect();
        $res = $connection->doQuery("SELECT * FROM themes");

        foreach ($res->fetch_assoc() as $row)
        {
            array_push($listOfAllThemes, new Theme($row['headline'], $row['description'], $row['userID'], $row['ID'], $row['views'], $row['answers'], $row['lastChange']));
        }

        $connection->closeConnection();

        return $listOfAllThemes;
    }


    //Constructor
    /**
     * Theme constructor.
     * @param string $headline
     * @param string $description
     * @param int $userID default 2 for gast user
     * @param int $id
     * @param int $views
     * @param int $answers
     * @param string $date
     * @throws Exception
     */
    public function __construct(string $headline, string $description, int $userID = 2, int $id = -1, int $views = 0, int $answers = 0, string $date = "")
    {
        if (Theme::checkDB($headline, $description)) throw new Exception("Dieses Thema wurde bereits erstellt!");

        $this->headline = $headline;
        $this->description = $description;
        $this->userID = $userID;

        if ($date == "") $this->date = date("d.m.Y", time());
        else $this->date = $date;

        $this->answers = $answers;
        $this->views = $views;

        $this->listOFAnswers = array();

        if($id == -1) {
            try {
                //send this theme to db
                $this->sendToDB();
            }
            catch (Exception $exception){
                $this->id = -1;
                throw new Exception($exception->getMessage());
            }
        } else {
            $this->loadAllAnswers();
            $this->answers = count($this->listOFAnswers);
        }
    }

    // Getters
    /**
     * @return string
     */
    public function getHeadline(): string
    {
        return $this->headline;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * @return mixed
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @return array
     */
    public function getListOFAnswers(): array
    {
        return $this->listOFAnswers;
    }



    //Own written functions

    private function loadAllAnswers()
    {
        if($this->id != -1)
        {
            $connection = new DB_Connection();
            $connection->connect();


            // Get Data to DB
            try {
                $res = $connection->doQuery("SELECT articles.text, articles.userID, articles.date FROM articles WHERE articles.themeID = ". $this->id);
                foreach ($res->fetch_assoc() as $row)
                {
                    $answer = new Answer($row['themeID'], $row['userID'], $row['text']);
                    array_push($this->listOFAnswers, $answer);
                }
            } catch (Exception $e) {
                $connection->closeConnection();

                throw new Exception("The Query gets the error: " . $e->getMessage());//error description

            } finally {
                $connection->closeConnection();
            }
        }
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
        $connection->getConn()->real_escape_string($this->headline);
        $connection->getConn()->real_escape_string($this->description);

        // Send Data to DB
        try {
            $connection->doQuery("INSERT INTO themes (headline, description, userID, views, answers, lastChange) VALUES ('" . $this->headline . "', '" . $this->description . "', " . $this->userID . ", 0, 0, '" . $this->date . "')");
//                $_SESSION['successMessage'] = "Ein neues Thema mit dem Namen " . $this->headline . " wurde erstellt"; TODO: auslagern
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
    public function addAnswer($userID, $text)
    {
        if ($this->id == -1) throw new Exception("Die Antwort konnet nicht erstellt werden, da das Thema nicht existiert");

        $answer = new Answer($this->id, $userID, $text);
        $answer->sendToDB();
        array_push($this->listOFAnswers, $answer);
        $this->answers ++;
    }





}




