function displaySnackBar() {
    let snackBar = document.getElementById("snackbar");
    snackBar.classList.add("display");

    setTimeout(function (){snackBar.classList.remove("display")}, 5900); //after 7 seconds remove Snackbar
}