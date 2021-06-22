function sendData(form) {
    let hedline = document.getElementById("theme-headline").value;
    let description = document.getElementById("theme-description").value;

    let dataString = "headline="+hedline+"&description="+description;
    $.ajax({
        url: 'src/db/newTheme.php',
        method:'post',
        data: dataString,
        success: function (r) {

            if(r == 'true')
            {
                closeModal("newEntry");
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