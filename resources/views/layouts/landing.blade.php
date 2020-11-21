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

    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v5.13.0/js/all.js" crossorigin="anonymous"></script>

    <title>{{ $title ?? config('app.name') }}</title>
    
    @yield('head')
</head>
<body>
    @include('layouts.navbar')
    @yield('content')
    
    <!-- Bootstrap core JavaScript -->
    <script src="{{ url('jquery/jquery.min.js') }}"></script>
    <script src="{{ url('bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        $(document).ready(function() {

            $(window).scroll(function () {
                checkScroll();
            });

            function checkScroll()
            {
                var startY = $('.navbar').height() * 2; //The point where the navbar changes in px

                if($(window).scrollTop() > startY){
                    $('.navbar').removeClass('bg-transparent').addClass('bg-light border-bottom border-secondary shadow-sm');
                }else{
                    $('.navbar').removeClass('bg-light border-bottom border-secondary shadow-sm').addClass('bg-transparent');
                }
            }
        });
    </script>

    @yield('bottom')
</body>