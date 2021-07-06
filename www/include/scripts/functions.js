function displaySnackBar() {
    let snackBar = document.getElementById("snackbar");
    snackBar.classList.add("display");

    setTimeout(function (){snackBar.classList.remove("display")}, 5900); //after 7 seconds remove Snackbar
}

/**
 * Send the user to the Article with the given themeID
 * @param themeID
 */
function linkToArticle(themeID){
    window.location = "article.php?themeID="+themeID;
}