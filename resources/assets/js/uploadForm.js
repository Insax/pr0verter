$(function () {
    var bar = $('#upload_bar');
    var status = $('#status');


    $('#upload_form').ajaxForm({
        cache: false,
        dataType: 'json',
        beforeSend: function () {
            status.empty();
            var file = $('#file').val();
            var url = $('#url').val();
            var limit = parseInt($('#limit').val());
            if (file !== '' || url !== '') {
                if(file !== ''){
                    if(!is_supported(file)){
                        alert ("Format nicht unterstützt :/");
                        return;
                    }
                } else {
                    if(!is_supported(url)){
                        alert ("Format nicht unterstützt :/");
                        return;
                    }
                }

                if (Math.floor(limit) == limit && $.isNumeric(limit)) {
                    $('#full').fadeIn();
                } else {
                    return false;
                }
            }
        },
        uploadProgress: function (event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar.width(percentVal);
            bar.html(percentVal);
        },
        success: function(data)
        {
            var obj = data;
            if(obj.sucess === true)
                document.location.href = '/progress/' + obj.guid;
        },
        error: function(data)
        {
            $('#full').fadeOut();
            $.each(data, function(index, element) {
                if(typeof (element.url) !== 'undefined') {
                    $('#urlerror').attr('class', 'has-error');
                    $('#urlerrhelp').show().attr('class', 'help-block').html('<strong>' + element.url + '</strong>')
                }
            });
        }
    });
});


function is_supported(path) {
    if (path.includes('.')) {
        var url_array = path.split('.');
        var format = url_array[url_array.length - 1];
        var supported_formats = ["webm", "mp4", "mkv", "mov", "avi", "wmv", "flv", "3gp", "gif"];
        var supported = (supported_formats.indexOf(format.toLowerCase()) > -1);
        return supported;
    }
    return false;
}