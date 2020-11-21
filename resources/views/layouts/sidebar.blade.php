@if(Auth::check() && Auth::user()->user_role=='admin kampus')
<div class="sidebar-maganghub bg-white shadow-sm p-0">
    <div class="sidebar-profile-top w-100 p-2">
        <div class="text-center text-dark">
            <small>selamat datang</small>
        </div>
    </div>

    @php ($univsb = \App\Univ::where('univ_user_email', Auth::user()->user_email )->first())

    <div class="sidebar-profile-bot w-100 p-2">
        <div class="sidebar-profile-thumb text-center">
            @if($univsb->univ_profile_pict == "")
            <i class="fas fa-university bg-white border p-2 shadow-sm" style="font-size: 70px"></i>
            @else
            <img src="{{ url('storage/univ/'.$univsb->univ_profile_pict) }}" class="bg-white border p-2 shadow-sm mx-auto">
            @endif
        </div>
        <div class="sidebar-name text-center mx-2">
            <small>admin kampus</small><br>
            <b>{{ $univsb->univ_nama }}</b>
        </div>
    </div>
    <div class="p-2">
        <table class="w-100">
            <tr class="align-top">
                <td>
                    <small>Verifikasi Kampus</small><br />
                    <small class="text-primary">mohon lengkapi profil</small>
                </td>
                <td class="text-right">
                    <a class="btn btn-outline-info btn-block p-1 mb-3" href="{{ url('kampus/detail/'.$univsb->univ_id) }}">
                        <small>PROFIL</small>
                    </a>
                </td>
            </tr>
            <tr class="align-top">
                <td>
                    <small>Program Studi</small><br />
                    <div class="text-primary">{{ \App\Prodi::getCount() }}</div>
                </td>
                <td class="text-right">
                    <a class="btn btn-outline-info btn-block p-1 mb-3" href="{{ route('prodi.manage') }}">
                        <small>PRODI</small>
                    </a>
                </td>
            </tr>
            <tr class="align-top">
                <td>
                    <small>Dosen Pembimbing</small><br />
                    <div class="text-primary">{{ \App\Dospem::getCount() }}</div>
                </td>
                <td class="text-right">
                    <a class="btn btn-outline-info btn-block p-1 mb-3" href="{{ route('dospem.manage') }}">
                        <small>DOSPEM</small>
                    </a>
                </td>
            </tr>
            <tr class="align-top">
                <td>
                    <small>Mahasiswa</small><br />
                    <div class="text-primary">{{ \App\Mahasiswa::getCount() }}</div>
                </td>
                <td class="text-right">
                    <a class="btn btn-outline-info btn-block p-1 mb-3" href="{{ route('mahasiswa.manage') }}">
                        <small>Mahasiswa</small>
                    </a>
                </td>
            </tr>
        </table>
    </div>

</div>

@elseif(Auth::check() && Auth::user()->user_role=='dospem')

<div class="sidebar-maganghub bg-white shadow-sm p-0">
    <div class="sidebar-profile-top w-100 p-2">
        <div class="text-center text-dark">
            <small>selamat datang</small>
        </div>
    </div>

    @php ($univsb = \App\Dospem::where('dospem_user_email', Auth::user()->user_email )->first())

    <div class="sidebar-profile-bot w-100 p-2">
        <div class="sidebar-profile-thumb text-center">
            <i class="fas fa-user bg-white border p-2 shadow-sm" style="font-size: 70px"></i>
        </div>
        <div class="sidebar-name text-center mx-2">
            <small>DOSPEM</small><br>
            <b>{{ $univsb->dospem_nama }}</b>
        </div>
    </div>
    <div class="p-2">
    </div>

</div>

@else

<div class="sidebar-maganghub p-0">
    <a class="btn btn-info btn-block py-1 px-3 mb-3 shadow-sm" href="{{ url('registkampus') }}">
        <small>Registrasi Admin Kampus</small>
    </a>
    <a class="btn btn-info btn-block py-1 px-3 mb-3 shadow-sm" href="#">
        <small>Registrasi Admin Perusahaan</small>
    </a>
    <a class="btn btn-success btn-block py-1 px-3 mb-3 shadow-sm" href="{{ route('login') }}">
        <small>LOGIN</small>
    </a>
</div>

@endif

<div class="sidebar-maganghub bg-white shadow-sm mt-2 p-0">
    <div class="p-2">
        <table class="w-100">
            <tr class="align-top border-bottom">
                <td class="p-2">
                    <small>Mahasiswa Pencari Magang</small><br />
                </td>
                <td class="text-right p-2">
                    <small class="text-primary">99</small>
                </td>
            </tr>
            <tr class="align-top border-bottom">
                <td class="p-2">
                    <small>Lowongan Magang</small><br />
                </td>
                <td class="text-right p-2">
                    <small class="text-primary">99</small>
                </td>
            </tr>
            <tr class="align-top border-bottom">
                <td class="p-2">
                    <small>Mahasiswa Sedang Magang</small><br />
                </td>
                <td class="text-right p-2">
                    <small class="text-primary">99</small>
                </td>
            </tr>
        </table>
    </div>
</div>
