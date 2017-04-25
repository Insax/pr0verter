@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="title m-b-md">
            pr0verter
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center">
                <video controls width="100%" height="100%">
                    <source src="{{$view}}" type="video/mp4" />
                </video>
                <br><br>
                <form>
                    <div class="input-group">
                        <input type="text" class="form-control"
                               value="{{$download}}" placeholder="Ein Döner bitte" id="copy-input">
                        <span class="input-group-btn">
                        <button class="btn btn-default" type="button" id="copy-button"
                                data-toggle="tooltip" data-placement="button"
                                title="Copy to Clipboard">
                            Copy
                        </button>
                    </span>
                    </div>
                </form>
                <br>
                <br>
                <a href="{{$download}}" class="btn btn-danger">DOWNLOAD</a>
                <br>
            </div>
        </div>
    </div>
@endsection