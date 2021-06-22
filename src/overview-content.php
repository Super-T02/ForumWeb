<?php
include_once "db/db.php";

    $connection = new DB_Connection();
    $connection->connect();

    try {
        $result = $connection->doQuery("SELECT * FROM themes"); //select all entrys in themes

        //if there are any results
        if ($result->num_rows > 0) {
            //gets the results of each row
            while($row = $result->fetch_assoc()) {
                echo '<tr class="entry-theme" onclick="test('.$row['ID'].')">
                        <td class="cell1">'.$row['headline'].'</td>
                        <td class="cell2">
                            <table class="stats">
                                <tr>
                                    <td>Antworten:</td>
                                    <td>'.$row['answers'].'</td>
                                </tr>
                                <tr>
                                    <td>Aufrufe:</td>
                                    <td>'.$row['views'].'</td>
                                </tr>
                            </table>
                        </td>
                        <td class="cell3">'.$row['lastChange'].'</td>
                    </tr>';
            }
        } else {
            //set standard answer
            echo  '<tr class="entry-theme">
                        <td class="cell1">Es sind bisher keine Einträge vorhanden!</td>
                        <td class="cell2">
                            <table class="stats">
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </td>
                        <td class="cell3"></td>
                    </tr>';
        }
    } catch (Exception $e) {
        echo '<tr class="entry-theme">
                        <td class="cell1">Daten konnten nicht geladen werden!</td>
                        <td class="cell2">
                            <table class="stats">
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </td>
                        <td class="cell3"></td>
                    </tr>';
    } finally {
        $connection->closeConnection();
    }
?>