<div id="newEntry" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times;</span>
            <h1>Neues Thema erstellen</h1>
        </div>

        <div class="modal-body">
            <form id="theme" action="include/newTheme.php" method="post" enctype="multipart/form-data">
                <div class="input-name">Themen Name:</div>
                <div class="theme-input"><input type="text" name="headline" id="theme-headline" placeholder="Themen Name" required></div>
                <div class="placeholder"></div>
                <div class="input-name">Beschreibung:</div>
                <div class="theme-input"><textarea name="description" id="theme-description" placeholder="Ihre Beschreibung..." required></textarea></div>
                <div class="input-name">Bild (optional): <input onchange="enablePic('theme-picture')" type="checkbox" name="hasPicture" value="true"></div>
                <div class="theme-input"><input type="file" name="picture" id="theme-picture" size="5000000" disabled></div>
                <div class="place-holder"></div>
                <div class="place-holder"></div>
                <div class="theme-input"><input type="submit" name="theme-submit" id="theme-submit" value="Thema erstellen"><?php
                    if (!isset($_SESSION['login']) or $_SESSION['login'] == false) echo "<span class='hint'>Hinweis: Du bist nicht angemeldet. Dein Thema wird als Gast gesendet!</span>";
                    else if (isset($_SESSION['username'])) echo "<span class='hint goodHint'>Du erstellst als ".$_SESSION['username']."</span>"
                    ?></div>
            </form>
        </div>
    </div>
</div>
