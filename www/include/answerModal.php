<div id="answer" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="close" onclick="document.getElementById('answer').style.display = 'none'">&times;</span>
            <h1>Neues Antwort erstellen</h1>
        </div>

        <div class="modal-body">
            <form id="answer-form" action="include/newAnswer.php" method="post">
                <input type="hidden" name="ID" value="<?=$ID?>">
                <div class="input-name">Antwort:</div>
                <div class="theme-input"><textarea name="answer" id="answer-text" placeholder="Ihre Antwort..." required></textarea></div>
                <div class="place-holder"></div>
                <div class="theme-input"><input type="submit" name="theme-submit" id="answer-submit" value="Antwort senden"></div>
            </form>
        </div>
    </div>
</div>