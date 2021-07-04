    </div>
    <div class="footer">&copy; Webseite von Maximilian Nagel und Tom Freudenmann</div>
</div>

<!--Script for making the navbar sticky-->
<script type="text/javascript">
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
<script type="text/javascript">
    function changeIconColor(path, id, myId) {
        let img = document.getElementById(id);
        let me = document.getElementById(myId);
        if(!me.classList.contains("active")) img.src = path;
    }
</script>


<script type="application/javascript" src="include/scripts/content-link.js"></script>
<script type="application/javascript" src="include/scripts/modal.js"></script>

</body>
</html>