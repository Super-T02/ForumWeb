    <!--Snackbar for sending messages to the user-->
    <div id="snackbar"></div>

    </div>
    <div class="footer">&copy; Webseite von Maximilian Nagel und Tom Freudenmann</div>
</div>



<!--Script for making the navbar sticky-->
<script type="application/javascript">
    let navbar = document.getElementById("nav");
    let sticky = navbar.offsetTop;

    window.onscroll = function () {
        if(window.pageYOffset >= sticky){
            navbar.classList.add("sticky");
        }
        else {
            navbar.classList.remove("sticky");
        }
    };
</script>

<!--Skript changing the iconcolor-->
<script type="application/javascript">
    function changeIconColor(path, id, myId) {
        let img = document.getElementById(id);
        let me = document.getElementById(myId);
        if(!me.classList.contains("active")) img.src = path;
    }
</script>

<script type="application/javascript" src="include/scripts/modal.js"></script>
<script type="application/javascript" src="include/scripts/functions.js"></script>

<?php //Display Javascript for success or failure message

checkForMessage("err", true);
checkForMessage("err_form", true);
checkForMessage("success", false);

/**
 * @param $name
 * @param $isBad
 */
function checkForMessage($name, $isBad)
{
    if (isset($_SESSION[$name]) and is_string($_SESSION[$name]))
    {
        if ($isBad) echo '      <script type="application/javascript">
                                    let snackBar = document.getElementById("snackbar");
                                    snackBar.classList.add("badNews");
                                    snackBar.innerText = "'.$_SESSION[$name].'";
                                    displaySnackBar();
                                </script>';
        else echo '             <script type="application/javascript">
                                    let snackBar = document.getElementById("snackbar");
                                    snackBar.classList.add("goodNews");
                                    snackBar.innerText = "'.$_SESSION[$name].'";
                                    displaySnackBar();
                                </script>';
        unset($_SESSION[$name]);
    }
}
?>

</body>
</html>