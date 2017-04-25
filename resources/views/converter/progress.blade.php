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
    <div class="col-md-6 col-md-offset-3">
        <div id="mode-wrapper">Schwierigkeitsgrad auswählen<br />
            <button id="Easy">Einfach</button><br />
            <button id="Medium">Mittel</button><br />
            <button id="Difficult">Schwer</button><br />
            <button id="high-score">Für deinen Highscore hier klicken!</button>
        </div>

        <div id="game-area" tabindex="0">
        </div>
    </div>
</div>

@endsection