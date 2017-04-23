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
        var interval = setInterval(get_progress, 2000);
        function get_progress() {
            var action = '/duration',
                    method = 'GET',
                    data = {file_name: '{{$guid}}'};
            $.ajax({
                url: action,
                type: method,
                data: data
            }).done(function (data) {
                if (data === 'error') {
                    document.location.href = '/';
                } else {
                    $('#bar').width(data + '%').html(data + '%');
                    if (data === '100') {
                        document.location.href = '/show/{{$guid}}';
                    }
                }
            });
        }
    });
</script>
@endsection