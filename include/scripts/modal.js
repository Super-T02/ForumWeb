var modal = document.getElementById("newEntry");
var add = document.getElementById("add-link");
var close = document.getElementsByClassName("close")[0];

add.onclick = function() {
    modal.style.display = "block";
}

close.onclick = function() {
    modal.style.display = "none";
}