function sendDataTheme(form) {
    let hedline = document.getElementById("theme-headline").value;
    let description = document.getElementById("theme-description").value;

    let dataString = "headline="+hedline+"&description="+description;
    let isNew = false;

    $.ajax({
        url: 'src/db/newTheme.php',
        method:'post',
        data: dataString,
        success: function (r) {

            if(r == 'true')
            {
                closeModal("newEntry");
                isNew = true;
            }
            else
            {
                alert("Daten konnten nicht gesendet werden");
            }
        },
        error: function (){

        }
    });

    if(isNew){
        $.ajax({
            url: 'src/db/getLastID.php',
            method: 'post',
            type: JSON,
            success: function (result)
            {
                result = JSON.parse(result);
                location.replace("article.php?themeID="+result.ID);
            },
            error: function (e){
                alert(e);
            }
        });
    }

}

function sendDataAnswer(form, themeID) {
    let answer = document.getElementById("answer-text").value;

    let dataString = "answer="+answer+"&themeID="+themeID;

    $.ajax({
        url: 'src/db/newAnswer.php',
        method:'post',
        data: dataString,
        success: function (r) {

            if(r == 'true')
            {
                alert("Neue Antwort wurde erstellt!");
                closeModal("answer");
            }
            else
            {
                alert("Daten konnten nicht gesendet werden");
            }
        },
        error: function (){

        }
    });
}

function closeModal(id){
    let modal = document.getElementById(id);
    modal.style.display = "none";
}