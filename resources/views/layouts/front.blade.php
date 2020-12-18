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

    <style>
        body {
            /* background: linear-gradient(to bottom, rgba(255,144,139,1), rgba(255,144,139,0));
            background-repeat: no-repeat; */
            background-color: #f9f9f9;
        }
        .banner-front {
            background-image: url("{{ url('img/bg-header.png') }}");
            background-position: center top;
            background-repeat: no-repeat;
            background-size: 100% 100%;
            margin-top: 80px;
            color: #fff;
        }
    </style>

    <title>{{ $title ?? config('app.name') }}</title>
    
    @yield('head')
</head>
<body>
    @include('layouts.navbar')
    
    <div class="banner-front container w-100 shadow-sm">
        @yield('banner-front')
    </div>

    <div class="container mt-0 px-0 mt-3">
        <div class="row mx-0">
            <div class="col-lg-9 col-md-8 px-0">
                @yield('content')
            </div>
            <div class="col-lg-3 col-md-4 pr-0">
                @include('layouts.sidebar')
            </div>
        </div>
    </div>
    
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