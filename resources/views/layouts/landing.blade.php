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

    <!-- favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
    
    <title>{{ $title ?? config('app.name') }}</title>
    
    @yield('head')
</head>
<body>
    @include('layouts.navbar')
    @yield('content')
    
    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2020 MagangHub</p>
        <ul class="list-inline">
            <li class="list-inline-item"><a href="https://www.instagram.com/n.iken/">Niken</a></li>
            <li class="list-inline-item"><a href="https://www.instagram.com/tedroit/">Tedo</a></li>
            <li class="list-inline-item"><a href="https://www.instagram.com/salsabilasol/">Sal Sabila</a></li>
        </ul>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="{{ url('jquery/jquery.min.js') }}"></script>
    <script src="{{ url('bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        $(document).ready(function() {

            checkScroll();

            $(window).scroll(function () {
                checkScroll();
            });

            function checkScroll()
            {
                var startY = $('.navbar').height(); //The point where the navbar changes in px

                if($(window).scrollTop() > startY){
                    $('.navbar').removeClass('bg-transparent').addClass('bg-light border-bottom border-secondary shadow-sm');
                }else{
                    $('.navbar').removeClass('bg-light border-bottom border-secondary shadow-sm').addClass('bg-transparent');
                }
            }
            
            $('.navbar-collapse').on('show.bs.collapse', function() {
                $('.navbar').removeClass('bg-transparent').addClass('bg-light border-bottom border-secondary shadow-sm');
            });
        });
    </script>

    @yield('bottom')
</body>