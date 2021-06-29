<div id="newEntry" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times;</span>
            <h1>Neues Thema erstellen</h1>
        </div>

        <div class="modal-body">
            <form id="theme" action="#" onsubmit="sendDataTheme(this);" method="post">
                <div class="input-name">Themen Name:</div>
                <div class="theme-input"><input type="text" name="headline" id="theme-headline" placeholder="Themen Name" required></div>
                <div class="placeholder"></div>
                <div class="input-name">Beschreibung:</div>
                <div class="theme-input"><textarea name="description" id="theme-description" placeholder="Ihre Beschreibung..." required></textarea></div>
                <div class="place-holder"></div>
                <div class="theme-input"><input type="submit" name="theme-submit" id="theme-submit" value="Thema erstellen"></div>
            </form>
        </div>
    </div>
</div>
