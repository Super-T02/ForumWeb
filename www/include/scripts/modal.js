let modalNewEntry = document.getElementById("newEntry");
let add = document.getElementById("add-link");
let close = document.getElementsByClassName("close")[0];

add.onclick = function() {
    modalNewEntry.style.display = "block";
}

close.onclick = function() {
    modalNewEntry.style.display = "none";
}