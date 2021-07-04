<?php
require_once "src/Theme.php";

try {
    $themes = Theme::loadAllThemes();

    foreach ($themes as $theme) {
        echo $theme->toStringForTable();
    }

} catch (Exception $e) {
    echo  '<tr class="entry-theme">
                <td class="cell1">Daten konnten nicht geladen werden oder es sind keine Einträge vorhanden!</td>
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