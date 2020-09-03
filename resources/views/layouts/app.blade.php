<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    
    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    <style>
    
    #map {
            width: 100%;
            height: 400px;
            margin-top: 2rem;
        }
    </style>

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">

    <link rel="stylesheet" href="http://weareoutman.github.io/clockpicker/dist/jquery-clockpicker.min.css">

    <style>
        .btn > svg {
            width: 18px;
        }
    </style>
    @section('style')
    @show

    {{-- icon --}}
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
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
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
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

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    @section('js')
    @show

    <script>
        replacefeather();

        function replacefeather(){
            feather.replace();
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>
    <script src="http://weareoutman.github.io/clockpicker/dist/jquery-clockpicker.min.js" ></script>

    <script>
        dob();
        datepicker();
        clockpicker();
        function dob() {
            $('.dob').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd',
                endDate: new Date(),
            });
        }
        function datepicker() {
            $('.datepicker').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd',
            });
        }

        function clockpicker() {
            $('.clockpicker').clockpicker({
                autoclose: true,
            });
        }

        function setInputFilter(textbox, inputFilter) {
            ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
                textbox.addEventListener(event, function() {
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                } else {
                    this.value = "";
                }
                });
            });
        }

        setInputFilter(document.getElementById("intOnly2"), function(value) {
        return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 20); });

        setInputFilter(document.getElementById("intOnly2Anak"), function(value) {
        return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 15); });

        setInputFilter(document.getElementById("intOnly4"), function(value) {
        return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 2020); });

        setInputFilter(document.getElementById("intOnly6"), function(value) {
        return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 999999); });

        setInputFilter(document.getElementById("intOnly9"), function(value) {
        return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 999999999); });

        setInputFilter(document.getElementById("intOnly9Office"), function(value) {
        return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 999999999); });

        setInputFilter(document.getElementById("intOnly13"), function(value) {
        return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 9999999999999); });

        setInputFilter(document.getElementById("intOnly13Darurat"), function(value) {
        return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 9999999999999); });

        setInputFilter(document.getElementById("intOnly16"), function(value) {
        return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 9999999999999999); });
    </script>
    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
</body>
</html>
