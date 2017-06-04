@extends('layouts.app')

@section('content')
    <div class="container text-center">
        <div class="jumbotron">
            <div class="row">
                <h1>pr0verter</h1>
            </div>
        </div>
    </div>
    <div class="container col-md-6 col-md-offset-3">
        @foreach($data as $d)
        <div class="panel panel-default">
            <div class="panel-heading">
                Commit: <a target="_blank" href="{{$d->html_url}}">{{substr($d->sha, 20)}}...</a> authored by: <a target="_blank" href="{{$d->author->html_url}}">{{$d->author->login}}</a> on: {{date("D, j.m.Y G:i:s", strtotime($d->commit->author->date))}}
            </div>
            <div class="panel-body">
                Message: {{$d->commit->message}}
            </div>
        </div>
        @endforeach
    </div>
@endsection
