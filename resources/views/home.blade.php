@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Deine Hochgeladenen Videos:</div>

                <div class="panel-body">
                    @if($guids)
                        @foreach($guids as $guid)
                            <a href="{{route('show', ['guid' => $guid->guid])}}" target=_blank>{{ substr(route('show', ['guid' => $guid->guid]), 0, 50)}}...</a>
                            <a href="{{route('delete')}}?guid={{$guid->guid}}" class="btn btn-danger pull-right">Delete</a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
