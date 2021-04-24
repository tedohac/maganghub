
    <!-- Navigation -->
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-light border-bottom border-secondary shadow-sm">
        <div class="container">
        <a class="navbar-brand p-0 m-0 text-align-center" href="{{ route('/') }}">
            <img src="{{ url('img/maganghub.png') }}">
            <b class="text-dark">MagangHub</b>
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
                    <a class="btn btn-light btn-block px-1 py-0 text-left" href="{{ route('lowongan.list') }}">Cari Tempat Magang</a>
                </li>
                
                @if(Auth::check())

                <li class="nav-item ml-2 mb-1 dropdown">
                    <a class="btn btn-light btn-block px-1 py-0 dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bell"></i>
                        @if(count(auth()->user()->unreadNotifications))
                            <span class="badge badge-pill badge-danger" id="notifcount">{{ count(auth()->user()->unreadNotifications) }}</span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="navbarDropdown" id="notif">
                    
                        @if(count(auth()->user()->unreadNotifications))
                            @foreach(auth()->user()->notifications->sortBy(['read_at','created_at']) as $notification)
                                <a href="{{ $notification->data['url'] }}"><div class="dropdown-item longtext" tabindex="-1"><small>{!! $notification->data['text'] !!}</small></div></a>
                                <div class="dropdown-divider"></div>
                            @endforeach
                        @else
                            <div class="dropdown-item">Belum ada notifikasi</div>
                        @endif
                    </div>
                </li>

                <li class="nav-item ml-2 mb-1 dropdown">
                    <a class="btn btn-success btn-block px-1 py-0 dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="navbarDropdown">
                        @if(Auth::user()->user_role=='admin kampus')

                            @php ($univnb = \App\Univ::where('univ_user_email', Auth::user()->user_email )->first())
                            <a class="dropdown-item disabled longtext" href="#" tabindex="-1" aria-disabled="true"><small>{{ Auth::user()->user_role }} :<br>{{ $univnb->univ_nama }}</small></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('kampus/detail/'.$univnb->univ_id) }}">Lihat Kampus</a>
                            <div class="dropdown-divider"></div>

                        @elseif(Auth::user()->user_role=='mahasiswa')
                        
                            @php ($mahasiswa = \App\Mahasiswa::where('mahasiswa_user_email', Auth::user()->user_email )->first())
                            <a class="dropdown-item disabled longtext" href="#" tabindex="-1" aria-disabled="true"><small>{{ Auth::user()->user_role }} :<br>{{ $mahasiswa->mahasiswa_nim }}</small></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('mahasiswa/detail/'.$mahasiswa->mahasiswa_id) }}">Lihat Profile</a>
                            <div class="dropdown-divider"></div>

                        @elseif(Auth::user()->user_role=='perusahaan')
                        
                            @php ($perusahaan = \App\Perusahaan::where('perusahaan_user_email', Auth::user()->user_email )->first())
                            <a class="dropdown-item disabled longtext" href="#" tabindex="-1" aria-disabled="true"><small>{{ Auth::user()->user_role }} :<br>{{ $perusahaan->perusahaan_nib }}</small></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('perusahaan/detail/'.$perusahaan->perusahaan_id) }}">Lihat Profile</a>
                            <div class="dropdown-divider"></div>

                        @endif
                        
                        <a class="dropdown-item" href="{{ route('changepass') }}">Ubah Password</a>
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