$(document).ready(function () {
    var copyTextareaBtn = document.getElementById("copy-button");
    copyTextareaBtn.addEventListener('click', function (event) {
        var copyTextarea = document.getElementById("copy-input");
        copyTextarea.select();
        try {
            document.execCommand('copy');
            window.getSelection().removeAllRanges();
        } catch (err) {
            console.log('Ohhh... uhhhhh... clipboard funtzt nicht');
        }
    });
});