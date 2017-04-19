@extends('layouts.app')
@section('content')
<div class="container container-fluid">
    <div class="row">
        <div class="content">
            <div class="title m-b-md">
                Konvertiere
            </div>
        </div>
            <div class="progress">
                <div id="bar" class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0;">
                    0%
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        var interval = setInterval(get_progress, 200);
        function get_progress() {
            var action = 'duration',
                    method = 'POST',
                    data = {duration: '9.3333333333333', file_name: '961aad17921c008d1a0ae24fd8315449'}
            $.ajax({
                url: action,
                type: method,
                data: data
            }).done(function (data) {
                if (data === 'error') {
                    document.location.href = '/error';
                } else {
                    $('#bar').width(data + '%').html(data + '%');
                    console.log(data);
                    if (data === '100') {
                        document.location.href = '/show/961aad17921c008d1a0ae24fd8315449';
                    }
                    if (data === '420') {
                        // hier wird alles wieder weggemacht wenns läuft
                        alert('Fehler beim konvertieren, ich arbeite gerade am fehler, versuchs mal im anderen format(z.b webm)');
                        clearInterval(interval);
                        document.location.href = '/';
                    }
                }
            });
        }
    });
</script>
@endsection