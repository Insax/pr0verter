@extends('layouts.app')
@section('content')
<script>
    $( function() {
        var text = 'Kein Ton';
        $( "#slider" ).slider({
            value: {{ old('sound') ? old('sound') : 0 }},
            min: 0,
            max: 3,
            step: 1,
            slide: function( event, ui ) {
                switch(ui.value) {
                    case 0:
                        text = 'Kein Ton';
                        break;
                    case 1:
                        text = 'Schlechte Qualität';
                        break;
                    case 2:
                        text = 'Mittle Qualität';
                        break;
                    case 3:
                        text = 'Hohe Qualität';
                        break;
                }
                $( "#sound" ).val( text );
                $( "#refsound" ).val(ui.value);
            }
        });
        switch($( "#slider" ).slider( "value" )) {
            case 0:
                text = 'Kein Ton';
                break;
            case 1:
                text = 'Schlechte Qualität';
                break;
            case 2:
                text = 'Mittle Qualität';
                break;
            case 3:
                text = 'Hohe Qualität';
                break;
        }
        $( "#sound" ).val( text );
        $( "#refsound" ).val( $( "#slider" ).slider( "value" ) );
    } );
</script>
    <div class="content">
        <div class="title m-b-md">
            mp4 Converter
        </div>

        <p>
            Wandelt Videos ins mp4 Format um.
            Maximale Videogröße 100MB. Maximale Länge 180 Sekunden. <br>
            Die Konvertierung kann je nach Videolänge bis zu einer Minute Dauern ¯\_(ツ)_/¯
        </p>
        <div class="container">
            <form action="{{ url('convert') }}" method="POST" id="upload_form" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-5">
                        <div class="panel panel-default">
                            <div class="panel-heading">Fileupload:</div>
                            <div class="panel-body">
                                <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                                    <label class="btn btn-default btn-file">
                                        Video Auswählen <input type="file" class="form-control" value="{{ old('file') }}" name="file" id="file" style="display: none;" />
                                    </label>
                                    @if ($errors->has('file'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('file') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        ODER
                    </div>
                    <div class="col-md-5">
                        <div class="panel panel-default">
                            <div class="panel-heading">URL:</div>
                            <div class="panel-body">
                                <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                                    <input type="text" class="form-control" size=30 name="url" id="url" value="{{ old('url') }}"/>
                                </div>
                                @if ($errors->has('url'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('url') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">Größe des Videos am Ende:</div>
                            <div class="panel-body">
                                <div class="form-group input-group row-group col-xs-4 col-xs-offset-4 {{ $errors->has('limit') ? ' has-error' : '' }}">
                                    <div class="input-group-addon">1 - 30</div>
                                    <input type="number" id="limit" name="limit" min="1" max="30" value="{{ $errors->has('limit') ? old('url') : '6'}}" class="form-control"/>
                                    <div class="input-group-addon">MB</div>
                                </div>
                                @if ($errors->has('limit'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('limit') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">Zusatzinfos:</div>
                            <div class="panel-body">
                                <div class="form-group>
                                        <label for="sound">Ton:</label>
                                        <input type="text" id="sound" value="{{ old('sound') }}" readonly style="background-color: #161618; border: 0px;">
                                        <input type="hidden" id="refsound" name="sound" value="{{ old('sound') }}">
                                    <div id="slider" class="col-xs-6 col-xs-offset-3"></div>
                                    <br/>
                                    <br/>
                                    <div class="checkbox row">
                                        <label>
                                            <input name="autoResolution" type="checkbox" {{ old('autoResolution') ? 'checked' : '' }}> Auflösung beibehalten
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <input class="btn btn-danger" type="submit" value="Konvertieren">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="container-fluid" id="full">
            <div class="row">
                <div class="col-md-6 col-md-offset-3 text-center" id="progress">
                    <h2>lade hoch ...</h2>
                    <br>
                    <div class="progress">
                        <div id="upload_bar" class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0;">
                            0%
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="status" style="display: none;"></div>
@endsection
