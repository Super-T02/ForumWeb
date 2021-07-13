<div id="register-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="close" onclick="document.getElementById('register-modal').style.display = 'none'">&times;</span>
            <h1>Registrieren</h1>
        </div>

        <div class="modal-body">
            <form id="register" action="include/register.php" method="post">
                <div class="input-name">Benutzername:</div>
                <div class="theme-input"><input type="text" name="username" id="username-reg" placeholder="Benutzername"
                                                value="<?php
                                                    if (isset($_SESSION['username'])) echo $_SESSION['username'];
                                                ?>"
                                                required></div>
                <div class="placeholder"></div>
                <div class="input-name">Passwort:</div>
                <div class="theme-input"><input type="password" name="pass" id="pass-reg" placeholder="Passwort" required></div>
                <div class="placeholder"></div>
                <div class="theme-input"><input type="password" name="pass2" id="pass2-reg" placeholder="Passwort wiederholen" required></div>
                <div class="placeholder"></div>
                <div class="theme-input"><input type="submit" name="register-submit" id="register-submit" value="Registrieren"></div>
            </form>
        </div>
    </div>
</div>