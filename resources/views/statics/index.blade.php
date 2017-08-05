@extends('layouts.app')

@section('content')
    <div class="container text-center">
        <div class="jumbotron">
            <div class="row">
                <h1>pr0verter</h1>
            </div>
            <div class="row">
                | <a href="{{ route('converter') }}">mp4 Converter</a> |
                <!-- <a href="{{ route('subtitle') }}">Subtitle Editor</a> | -->
                <a href="{{ route('faq') }}">FAQ</a> |
                <a href="{{ route('contact') }}">Kontakt</a> |
                <a href="{{ route('changelog') }}">Changelog</a> |
            </div>
        </div>
    </div>
@endsection
