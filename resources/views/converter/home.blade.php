@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="title m-b-md">
            mp4 Converter
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
                <form action="{{route('convert')}}" method="POST" id="form" enctype="multipart/form-data"></form>
                    <div class="slider">
                        <div class="slider-form slider-start">
                            <h2>Willkommen beim pr0verter, hier kannst du Videos für das pr0 hochladen und konvertieren lassen!</h2>
                            <button class="start next"><span class="glyphicon glyphicon-console"></span> Starten</button>
                        </div>
                        <div class="slider-form slider-ul">
                            <h2>Möchtest du ein Video zum pr0verter hochladen oder möchtest du eine URL zu einer externen Quelle angeben?</h2>
                            <div class="label-ctr">
                                <label class="radio">
                                    <input type="radio" value="url" name="ulchoice" id="ul">
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
                                    <input type="radio" value="file" name="ulchoice" id="dl">
                                    <div class="btn btn-file">
                                        <span class="glyphicon glyphicon-link"></span>
                                        URL
                                    </div>
                                </label>
                            </div>
                            <button class="ultype next" disabled="disabled">Weiter <span class="glyphicon glyphicon-chevron-right"></span></button>
                        </div>
                        <div class="slider-form slider-choose">
                            <h2>Zurzeit werden Videos des Typs: webm,mp4,mkv,mov,avi,wmv,flv,3gp,gif Supportet.</h2>
                            <div id="mydropzone" class="dropzone" style="display: none;">
                                <h2>Hier kannst du das gewünschte Video per drag and drop oder durch draufklicken auswählen</h2>
                                <div class="dropzone-previews">
                                </div>
                            </div>

                            <div id="formurl" class="form-group" style="display: none;">
                                <h2>Bitte eine URL zu einem Video hier angeben!</h2>
                                <input type="text" class="form-control" size=40 name="url" id="urlform" style="display: none;"/>
                            </div>

                            <button class="choose next" disabled="disabled">Weiter</button>
                        </div>

                        <div class="slider-form slider-size">
                            <h2>Bitte hier die Größe des fertigen Videos festlegen, ohne pr0mium 6MB, mit 12MB</h2>
                            <div class="form-group input-group row-group">
                                <div class="input-group-addon">1 - 30</div>
                                <input type="number" id="limit" name="limit" value="6" min="1" max="30" class="form-control"/>
                                <div class="input-group-addon">MB</div>
                            </div>
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
                            <button class="sound next">Weiter <span class="glyphicon glyphicon-chevron-right"></span></button>
                        </div>
                        <div class="slider-form slider-res">
                            <h2>Hier kannst du festlegen ob du die Origrinalauflösung beibehalten willst oder nicht.</h2>
                            <div class="label-ctr">
                                <label class="checkbox">
                                    <input type="checkbox" name="res" id="res">
                                    <div class="btn btn-check">
                                        <span class="glyphicon glyphicon-resize-full"></span>
                                        Auflösung anpassen!
                                    </div>
                                </label>
                            </div>
                            <button class="res next">Weiter <span class="glyphicon glyphicon-chevron-right"></span></button>
                        </div>
                        <div class="slider-form slider-clip">
                            CLIP + ENDE
                            <button class="clip next">Weiter <span class="glyphicon glyphicon-chevron-right"></span></button>
                        </div>



                    </div>
                </form>
            </div>
        </div>
@endsection
