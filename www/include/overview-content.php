<?php
require_once "src/Theme.php";

try {
    $themes = Theme::loadAllThemes();

    foreach ($themes as $theme) {
        echo $theme->toStringForTable();
    }

} catch (Exception $e) {
    $_SESSION['err'] = "Daten konnten nicht geladen werden oder es sind keine Einträge vorhanden!";
    echo  '<div class="entry-theme">
                <div class="cell1">Daten konnten nicht geladen werden oder es sind keine Einträge vorhanden!</div>
                <div class="cell2">
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
                </div>
                <div class="cell3"></div>
            </div>';
}