<?php
require_once "db/db.php";
require_once "DbElement.php";


class Theme implements DbElement {
    protected string $headline;
    protected string $description;
    protected int $userID;
    protected string $date;
    protected int $id;
    protected int $views;
    protected int $answers;
    protected array $listOFAnswers;


    // Constructor
    /**
     * Theme constructor. If the ID is -1 or the default value, it will be added to the database.
     * @param string $headline
     * @param string $description
     * @param  $pictureID
     * @param int $userID default 2 for gast user
     * @param int $id
     * @param int $views
     * @param int $answers
     * @param string $date
     * @throws Exception
     */
    public function __construct(string $headline, string $description, int $userID = 2, int $id = -1, int $views = 0,
                                int $answers = 0, string $date = "")
    {
        if($id == -1) if (Theme::checkDB($headline, $description))
            throw new Exception("Dieses Thema wurde bereits erstellt!");

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
            $this->id = $id;
            $this->loadAllAnswers();
            $this->answers = count($this->listOFAnswers);
        }
    }



    //static functions
    /**
     * @param int $id
     * @return Theme
     * @throws Exception
     *
     * Loads a single theme with the ID passed in and returns this theme.
     * It throws a exception if there is no theme with this ID.
     */
    public static function loadByID(int $id): Theme
    {
        $connection = new DB_Connection();
        $connection->connect();

        // Send Data to DB
        try {
            $res = $connection->doQuery("SELECT * FROM themes WHERE ID = ". $id); // Gets the last ID
            $row = $res->fetch_assoc();

            if ($row == null) throw new Exception("Dieser Artikel existiert nicht!");

            // it is a the with picture
            if (isset($row['pictureID']))
                return new ThemeWithPicture($row['headline'], $row['description'],
                    $row['pictureID'], intval($row['userID']), intval($row['ID']), intval($row['views']),
                    intval($row['answers']), $row['lastChange']);

            // default theme
            else return new Theme($row['headline'], $row['description'], intval($row['userID']),
                intval($row['ID']), intval($row['views']), intval($row['answers']), $row['lastChange']);

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

        while ($row = $res->fetch_assoc()){
            // it is a the with picture
            if (isset($row['pictureID']))
                $theme =  new ThemeWithPicture($row['headline'], $row['description'],
                    $row['pictureID'], intval($row['userID']), intval($row['ID']), intval($row['views']),
                    intval($row['answers']), $row['lastChange']);

            // default theme
            else $theme = new Theme($row['headline'], $row['description'], intval($row['userID']),
                intval($row['ID']), intval($row['views']), intval($row['answers']), $row['lastChange']);

            // add the generated theme to the array
            array_push($listOfAllThemes, $theme);
        }

        $connection->closeConnection();

        return $listOfAllThemes;
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
     * @return int
     */
    public function getViews(): int
    {
        return $this->views;
    }

    /**
     * @return int
     */
    public function getAnswers(): int
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



    // Other functions
    /**
     * @throws Exception
     */
    protected function loadAllAnswers()
    {
        if($this->id > -1)
        {
            $connection = new DB_Connection();
            $connection->connect();


            // Get Data to DB
            try {
                $res = $connection->doQuery("SELECT * FROM articles WHERE themeID = ". $this->id);
                while ($row = $res->fetch_assoc())
                {
                    $answer = new Answer(intval($row['themeID']), intval($row['userID']), $row['text'], $row['pictureID'],
                        intval($row['ID']), $row['date']);

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

            $query = "INSERT INTO themes (headline, description, userID, views, answers, lastChange)".
                "VALUES ('" . $this->headline . "', '" . $this->description . "', " . $this->userID . ", 0, 0, '"
                . $this->date ."')";

            $connection->doQuery($query);

            //Get the ID of this theme
            $_SESSION['success'] = "Ein neues Thema mit dem Namen '" . $this->headline . "' wurde erstellt.";

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

    /**
     * @throws Exception
     */
    public function increaseViews()
    {
        if ($this->id != -1) {
            $this->views++;
            $connection = new DB_Connection();
            $connection->connect();

            $connection->doQuery("UPDATE themes SET views = ".$this->views." WHERE ID = ". $this->id);

            $connection->closeConnection();
        }
    }

    /**
     * Returns the Theme as a String for using in overview Tables.
     *
     * @return string
     */
    public function toStringForTable(): string
    {

        return '<div class="entry-theme" onclick="linkToArticle('.$this->id.')">
                        <div class="cell1"><div class="middle">'.$this->headline.'</div></div>
                        <div class="cell2"><div class="middle">
                            <table class="stats">
                                <tr>
                                    <td>Antworten:</td>
                                    <td>'.$this->answers.'</td>
                                </tr>
                                <tr>
                                    <td>Aufrufe:</td>
                                    <td>'.$this->views.'</td>
                                </tr>
                            </table>
                            </div>
                        </div>
                        <div class="cell3"><div class="middle">'.$this->date.'</div></div>
                    </div>';
    }

    /**
     * @throws Exception
     */
    public function deleteFromDB(){
        if ($this->id == -1) throw new Exception("Dieses Thema ist nicht in der Datenbank");

        $conn = new DB_Connection();
        $conn->connect();

        $conn->doQuery("DELETE FROM themes WHERE ID = ". $this->id);

        $this->id = -1;
    }

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


        // text
        $text .= '
                        <div class="article-content">' . $this->description . '</div>
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

require_once "Answer.php";
require_once "User.php";
require_once "Picture.php";
require_once "ThemeWithPicture.php";


