
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent fixed-top">
        <div class="container">
        <a class="navbar-brand p-0 m-0 text-align-center" href="{{ route('/') }}">
            <img src="{{ url('img/maganghub.png') }}">
            <b>MagangHub</b>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item ml-2 mb-1">
                    <a class="btn btn-light btn-block px-1 py-0 text-left" href="{{ route('kampus.list') }}">Cari Kampus</a>
                </li>
                <li class="nav-item ml-2 mb-1">
                    <a class="btn btn-light btn-block px-1 py-0 text-left" href="#">Cari Tempat Magang</a>
                </li>
                
                @if(Auth::check() && Auth::user()->user_role=='admin kampus')

                <li class="nav-item ml-2 mb-1 dropdown">
                    <a class="btn btn-success btn-block px-1 py-0 dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        @php ($univnb = \App\Univ::where('univ_user_email', Auth::user()->user_email )->first())
                        <a class="dropdown-item disabled longtext" href="#" tabindex="-1" aria-disabled="true"><small>{{ Auth::user()->user_role }} :<br>{{ $univnb->univ_nama }}</small></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ url('kampus/detail/'.$univnb->univ_id) }}">Lihat Kampus</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                    </div>
                </li>
                
                @elseif(Auth::check() && Auth::user()->user_role=='dospem')

                <li class="nav-item ml-2 mb-1 dropdown">
                    <a class="btn btn-success btn-block px-1 py-0 dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        @php ($univnb = \App\Dospem::where('dospem_user_email', Auth::user()->user_email )->first())
                        <a class="dropdown-item disabled longtext" href="#" tabindex="-1" aria-disabled="true"><small>{{ Auth::user()->user_role }} :<br>{{ $univnb->dospem_nama }}</small></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ url('kampus/detail/'.$univnb->univ_id) }}">Lihat Profil</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                    </div>
                </li>
                
                @else
                
                <li class="nav-item ml-2 mb-1">
                    <a class="btn btn-success btn-block px-1 py-0" href="{{ route('login') }}">Login</a>
                </li>
                
                @endif
            </ul>
        </div>
        </div>
    </nav>