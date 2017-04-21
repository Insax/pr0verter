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
                            <a href="{{route('delete')}}?guid={{$guid->guid}}" class="btn btn-danger">Delete</a>
                        @endforeach
                    @elseif(DB::table('data')->where([['user_id', '=', Auth::id()], ['deleted', '=', 0]])->value('guid'))
                        <a href="{{ route('show', ['guid' => $guids->guid]) }}" target=_blank>{{ substr(route('show', ['guid' => $guids->guid]), 0, 50)}}...</a>
                        <a href="{{route('delete')}}?guid={{$guids->guid}}" class="btn btn-danger">Delete</a>
                    @else
                        {{$guids}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
