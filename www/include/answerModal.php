<div id="answer" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="close" onclick="document.getElementById('answer').style.display = 'none'">&times;</span>
            <h1>Neues Antwort erstellen</h1>
        </div>

        <div class="modal-body">
            <form id="answer-form" action="include/newAnswer.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="ID" value="<?=$ID?>">
                <div class="input-name">Antwort:</div>
                <div class="theme-input"><textarea name="answer" id="answer-text" placeholder="Ihre Antwort..." required></textarea></div>
                <div class="input-name">Bild (optional): <input onchange="enablePic('answer-picture')" type="checkbox" name="hasPicture" value="true"></div>
                <div class="theme-input"><input type="file" name="picture" id="answer-picture" size="5000000" disabled></div>
                <div class="place-holder"></div>
                <div class="place-holder"></div>
                <div class="theme-input"><input type="submit" name="theme-submit" id="answer-submit" value="Antwort senden"></div>
            </form>
        </div>
    </div>
</div>