<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap core CSS -->
    <link href="{{ url('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('styles/style.css?v=').time() }}" rel="stylesheet">

    <!-- Font -->
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">

    <!-- Custom fonts for this template-->
    <link href="{{ url('fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <title>{{ $title ?? config('app.name') }}</title>
    
    @yield('head')
</head>
<body>
    @include('layouts.navbar')

    <div class="container mt-5 px-0">
        <div class="row mx-0">
            <div class="col-lg-9 col-md-8 px-0">
                @yield('content')
            </div>
            <div class="col-lg-3 col-md-4">
                @include('layouts.sidebar')
            </div>
        </div>
    </div>
    
    <!-- Bootstrap core JavaScript -->
    <script src="{{ url('jquery/jquery.min.js') }}"></script>
    <script src="{{ url('bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var navbar = $('.navbar');
            var lastScrollTop = 0;

            $(window).scroll(function () {
                var st = $(this).scrollTop();

                if (st > lastScrollTop && st > 30) {
                    // navbar.fadeOut();
                    navbar.removeClass('navbar-dark bg-transparent').addClass('navbar-light bg-light border-bottom border-secondary');
                }
                else if (st < lastScrollTop && st < 30) {
                    navbar.removeClass('navbar-light bg-light border-bottom border-secondary').addClass('navbar-dark bg-transparent');
                }
                lastScrollTop = st;
            });
        });
    </script>

    @yield('bottom')
</body>