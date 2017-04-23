@extends('layouts.app')

@section('content')
    <div class="flex-center position-ref full-height">

    </div>
    <div class="content">
        <div class="title m-b-md">
            pr0verter
        </div>

        <div class="links">
            <a href="{{ url('converter') }}">mp4 Converter</a>
            <a href="{{ url('faq') }}">FAQ</a>
            <a href="{{ url('contact') }}">Kontakt</a>
            <a href="{{ url('changelog') }}">Changelog</a>
        </div>
    </div>
@endsection
