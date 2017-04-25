<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-ui.structure.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-ui.theme.min.css') }}" rel="stylesheet">

    @if(Request::route()->getName() === 'progress')
    <link href="{{ asset('css/dark-snake.css')}}" rel="stylesheet">
    @endif
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li><a href="{{ url('converter') }}">mp4 Converter</a></li>
                        <li><a href="{{ url('faq') }}">FAQ</a></li>
                        <li><a href="{{ url('contact') }}">Kontakt</a></li>
                        <li><a href="{{ url('changelog') }}">Changelog</a></li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                    </ul>
                </div>
            </div>
        </nav>
        @yield('content')
    </div>
                <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>

    @if(Request::route()->getName() == 'converter')
    <script src="{{ asset('js/form.js') }}"></script>
    @endif

    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>

    @if(Request::route()->getName() == 'progress')
    <script src="{{ asset('js/progress.js') }}"></script>

    <script src="{{asset('js/snake.js')}}"></script>
    <script type="text/javascript">
        var mySnakeBoard = new SNAKE.Board(  {
            boardContainer: "game-area",
            fullScreen: false,
            width: 580,
            height:400
        });
    </script>
    @endif

    @if(Request::route()->getName() == 'show')
        <script src="{{ asset('js/copy.js') }}"></script>
    @endif



</body>
</html>
