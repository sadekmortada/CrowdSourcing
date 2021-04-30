<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"/>
    @yield('css')
</head>
<body background="{{ asset('background.jpg') }}">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-secondary shadow-sm">
            <div class="container">
                <a class="navbar-brand text-white" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('getlogin') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('getregister'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('getregister') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('home') }}"><b>{{ __('Home') }}</b></a>
                        </li>
                        @if(auth()->user()->isMonitor())
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{route('createworkshop')}}"><b>{{ __('CreateWorkshop') }}</b></a>
                        </li>
                        @endif
                        @if(auth()->user()->isParticipant())
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{route('joinworkshop')}}"><b>{{ __('JoinWorkshop') }}</b></a>
                        </li>
                        @endif
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <b>{{ Auth::user()->name }} </b><span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                       {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-2 pb-5">
            <div class="col-md-12 text-center pb-5">
                @yield('content')
            </div>
        </main>
    </div>

<br><br>
<footer class="footer bg-secondary pt-1 p-0" style="position:absolute;bottom:0;width:100%">
    <div class="container text-center">
      <div class="row justify-content-center">
        <div class="col-md-6 mt-md-0 mt-3">
          <p class="text-white text-small">Proudly Done By:</p>
          <p class="text-light">Sadek Mortada | Majd Dhainy </p>
        </div>
      </div>
    </div>
    <div class="text-white bg-dark   text-center py-3">© 2020 Copyright:
      <a href="{{route('welcome')}}" class="font-weight-bold text-light">www.crowdsourcing.com.</a>
      All rights reserved...
    </div>
</footer>
@auth
@if(isset($workshop))
<script src="https://js.pusher.com/5.1/pusher.min.js"></script>
@if(auth()->user()->isParticipant())
    <script>
        // subscribe participants to channel specific to the workshop to receive notifications from monitor
        var pusher = new Pusher('1da76367e337a252dc04', {cluster: 'mt1'});
        var channel = pusher.subscribe('participants'+{!! json_encode($workshop->id) !!});
        channel.bind('my-event', function(data) {alert(JSON.stringify(data));});
        // subscribe each participant to private channel of his own id to receive notifications related to his projects(groups)
        var pusher = new Pusher('1da76367e337a252dc04', {cluster: 'mt1'});
        var channel = pusher.subscribe('participant'+{!! json_encode(auth()->user()->id) !!});
        channel.bind('my-event', function(data) {alert(JSON.stringify(data));});
    </script>
@endif
@if(auth()->user()->isMonitor())
<script>
    // subscribe monitor to channel specific to his workshop to recieve notification from participants
    var pusher = new Pusher('1da76367e337a252dc04', {cluster: 'mt1'});
    var channel = pusher.subscribe('monitor'+{!! json_encode($workshop->id) !!});
    channel.bind('my-event', function(data) {alert(JSON.stringify(data));});
</script>
@endif
@endif
@endauth
<script src="{{ asset('js/app.js') }}"></script>
{{-- for additional javascript --}}
@yield('scripts')
</body>
</html>
