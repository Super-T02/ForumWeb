<div id="answer" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="close" onclick="document.getElementById('answer').style.display = 'none'">&times;</span>
            <h1>Neues Antwort erstellen</h1>
        </div>

        <div class="modal-body">
            <form id="answer-form" action="#" onsubmit="sendDataAnswer(this, <?=$ID?>)" method="post">
                <div class="input-name">Antwort:</div>
                <div class="theme-input"><textarea name="answer" id="answer-text" placeholder="Ihre Antwort..." required></textarea></div>
                <div class="place-holder"></div>
                <div class="theme-input"><input type="submit" name="theme-submit" id="theme-submit" value="Antwort senden"></div>
            </form>
        </div>
    </div>
</div>