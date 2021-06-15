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

</body>
</html>