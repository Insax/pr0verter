$(function () {
    var interval = setInterval(get_progress, 2000);
    function get_progress() {
        var action = '/converter/duration',
            method = 'GET',
            data = {file_name: location.href.substr(location.href.lastIndexOf('/') + 1)};
        $.ajax({
            url: action,
            type: method,
            data: data
        }).done(function (data) {
            if (data === 'error') {
                document.location.href = '/';
            } else if(data === '420') {
                document.location.href = '/error?type=vid';
            } else if(data === '421') {
                document.location.href = '/error?type=yt';
            } else {
                $('#bar').width(data + '%').html(data + '%');
                if (data === '100') {
                    document.location.href = '/converter/show/' + location.href.substr(location.href.lastIndexOf('/') + 1);
                }
            }
        });
    }
});

