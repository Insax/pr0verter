@extends('layouts.app')
@section('content')
    <div class="container text-center">
        <div class="jumbotron">
            <div class="row">
                <h1>pr0verter</h1>
            </div>
        </div>
	<div class="container-steps slider-start-active">
            <div class="steps">
                <div class="step step-start">
                    <div class="liner"></div>
                    <span>Willkommen!</span>
                </div>
                <div class="step step-ul">
                    <div class="liner"></div>
                    <span>Upload Methode</span>
                </div>
                <div class="step step-choose">
                    <div class="liner"></div>
                    <span>Auswahl</span>
                </div>
                <div class="step step-size">
                    <div class="liner"></div>
                    <span>Videogröße</span>
                </div>
                <div class="step step-sound">
                    <div class="liner"></div>
                    <span>Ton</span>
                </div>
                <div class="step step-res">
                    <div class="liner"></div>
                    <span>Auflösung</span>
                </div>
                <div class="step step-clip">
                    <div class="liner"></div>
                    <span>Schneiden</span>
                </div>
            </div>
            <div class="line">
                <div class="dot-move"></div>
                <div class="dot start"></div>
                <div class="dot ul"></div>
                <div class="dot choose"></div>
                <div class="dot size"></div>
                <div class="dot sound"></div>
                <div class="dot res"></div>
                <div class="dot clip"></div>
            </div>

            <div class="slider-ctr">
                <div class="slider">
                    <form action="{{route('convert')}}" method="POST" id="form" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="slider-form slider-start">
                            <h2>Willkommen beim pr0verter, hier kannst du Videos für das pr0 hochladen und konvertieren lassen!</h2>
                            <button class="start next"><span class="glyphicon glyphicon-console"></span> Starten</button>
                        </div>
                        <div class="slider-form slider-ul">
                            <h2>Möchtest du ein Video zum pr0verter hochladen oder möchtest du eine URL zu einer externen Quelle angeben?</h2>
                            <div class="label-ctr">
                                <label class="radio">
                                    <input type="radio" name="choice" id="ul">
                                    <div class="btn btn-file">
                                        <span class="glyphicon glyphicon-cloud-upload"></span>
                                        Upload
                                    </div>
                                </label>
                                &nbsp;
                                &nbsp;
                                &nbsp;
                                &nbsp;
                                &nbsp;
                                <label class="radio col-xs-offset-4">
                                    <input type="radio" name="choice" id="dl">
                                    <div class="btn btn-file">
                                        <span class="glyphicon glyphicon-link"></span>
                                        URL
                                    </div>
                                </label>
                                &nbsp;
                                &nbsp;
                                <label class="radio">
                                    <input type="radio" name="choice" id="yt">
                                    <div class="btn btn-file">
                                        <span class="glyphicon glyphicon-floppy-save"></span>
                                        Youtube URL
                                    </div>
                                </label>
                            </div>
                            <button class="ultype next" disabled="disabled">Weiter <span class="glyphicon glyphicon-chevron-right"></span></button>
                        </div>
                        <div class="slider-form slider-choose">
                            <h2>Zurzeit werden Videos des Typs: webm,mp4,mkv,mov,avi,wmv,flv,3gp,gif Supportet.</h2>
                            <div id="mydropzone" style="display: none;">
                                <h2>Hier kannst du das gewünschte Video per drag and drop oder durch draufklicken auswählen</h2>

                                <div class="file-area" id="file-area">
                                    <input type="file" name="file" id="file" required="required"/>
                                    <div class="file-dummy">
                                        <span class="default">Bitte ein Video auswählen!</span>
                                        <span class="success">Video akzeptiert.</span>
                                    </div>
                                </div>
                            </div>
                            <div id="formurl" class="form-group" style="display: none;">
                                <h2>Bitte eine URL zu einem Video hier angeben!</h2>
                                <input type="text" class="form-control" size=40 name="url" id="urlform" style="display: none;"/>
                            </div>
                            <div id="youtubeform" class="form-group" style="display: none;">
                                <h2>Bitte eine URL zu einem Youtubevideo hier angeben!</h2>
                                <input type="text" class="form-control" size=40 name="youtube" id="youtube" style="display: none;"/>
                            </div>
                            <button class="choose back"><span class="glyphicon glyphicon-chevron-left"></span> Zurück</button>
                            <button class="choose next" disabled="disabled">Weiter <span class="glyphicon glyphicon-chevron-right"></span></button>
                        </div>

                        <div class="slider-form slider-size">
                            <h2>Bitte hier die Größe des fertigen Videos festlegen, ohne pr0mium 6MB, mit 12MB</h2>
                            <div class="form-group input-group row-group">
                                <div class="input-group-addon">1 - 30</div>
                                <input type="number" id="limit" name="limit" value="6" min="3" max="30" class="form-control"/>
                                <div class="input-group-addon">MB</div>
                            </div>
                            <button class="size back"><span class="glyphicon glyphicon-chevron-left"></span> Zurück</button>
                            <button class="size next">Weiter <span class="glyphicon glyphicon-chevron-right"></span></button>
                        </div>

                        <div class="slider-form slider-sound">
                            <label for="sound">
                                Hier kannst du entweder keinen Ton oder die Qualität des Tons festlegen. Bitte bedenke das eine höhere Tonqualität mehr Speicherplatz verbraucht.
                            </label>
                            <input type="text" id="sound" readonly style="background-color: #161618; border: 0px;">
                            <input type="hidden" id="refsound" name="sound">
                            <div id="slider">
                            </div>
                            <button class="sound back"><span class="glyphicon glyphicon-chevron-left"></span> Zurück</button>
                            <button class="sound next">Weiter <span class="glyphicon glyphicon-chevron-right"></span></button>
                        </div>
                        <div class="slider-form slider-res">
                            <h2>Hier kannst du festlegen ob du die Origrinalauflösung beibehalten willst oder nicht.</h2>
                            <div class="label-ctr">
                                <label class="checkbox">
                                    <input type="checkbox" name="autoResolution" id="res">
                                    <div class="btn btn-check">
                                        <span class="glyphicon glyphicon-resize-full"></span>
                                        Auflösung beibehalten!
                                    </div>
                                </label>
                            </div>
                            <button class="res back"><span class="glyphicon glyphicon-chevron-left">Zurück</span></button>
                            <button class="res next">Weiter <span class="glyphicon glyphicon-chevron-right"></span></button>
                        </div>
                        <div class="slider-form slider-clip">
                            <h2>Hier kannst du die Zeitstempel für den Schnitt angeben. Angabe in Sekunden.</h2>
                            <input placeholder="Startzeit" type="number" class="form-control" name="cutstart" id="cutstart"/>
                            <input placeholder="Endzeit" type="number" class="form-control" name="cutend" id="cutend"/>

                            <button class="clip back"><span class="glyphicon glyphicon-chevron-left">Zurück</span></button>
                            <input class="btn btn-danger clip next" type="submit" value="Konvertieren">
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
