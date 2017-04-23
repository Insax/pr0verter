@extends('layouts.app')

@section('content')
    <div class="flex-center position-ref full-height">

    </div>
    <div class="content">
        <div class="title m-b-md">
            pr0verter
        </div>

        <div class="links">
            <a href="{{ route('converter') }}">mp4 Converter</a>
            <a href="{{ route('faq') }}">FAQ</a>
            <a href="{{ route('contact') }}">Kontakt</a>
            <a href="{{ route('changelog') }}">Changelog</a>
        </div>
    </div>
@endsection
