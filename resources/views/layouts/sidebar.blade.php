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
                    @if(\App\Univ::getIsVerified($univ->univ_id))
                        <small class="text-primary"><i class="fas fa-check"></i> Terverifikasi</small>
                    @else
                        <small class="text-primary">mohon lengkapi profil</small>
                    @endif
                </td>
                <td class="text-right">
                    <a class="btn btn-outline-info btn-block p-1 mb-3" href="{{ url('kampus/detail/'.$univsb->univ_id) }}">
                        <small><i class="fas fa-ellipsis-h"></i></small>
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
                        <small><i class="fas fa-ellipsis-h"></i></small>
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
                        <small><i class="fas fa-ellipsis-h"></i></small>
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
                        <small><i class="fas fa-ellipsis-h"></i></small>
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
    @php ($prodi = \App\Prodi::where('prodi_id', $univsb->dospem_prodi_id )->first())
    @php ($univ = \App\Univ::where('univ_id', $prodi->prodi_univ_id )->first())

    <div class="sidebar-profile-bot w-100 p-2">
        <div class="sidebar-profile-thumb text-center">
            <i class="fas fa-user bg-white border p-2 shadow-sm" style="font-size: 70px"></i>
        </div>
        <div class="sidebar-name text-center mx-2">
            <small>DOSPEM</small><br>
            <b>{{ $univsb->dospem_nik }}</b><br>
            {{ $univsb->dospem_nama }}<br>
            <small><i>{{ $prodi->prodi_nama }}</i></small><br>
            <small><i>{{ $univ->univ_nama }}</i></small>
        </div>
    </div>
    <div class="sidebar-profile-bot w-100 p-2">
        <table class="w-100">
            <tr class="align-top">
                <td>
                    <small>Mahasiswa</small><br />
                    <small class="text-primary">{{ \App\Mahasiswa::getCountByDospem($univsb->dospem_id) }}</small>
                </td>
                <td class="text-right">
                    <a class="btn btn-outline-info btn-block p-1 mb-3" href="{{ route('mahasiswa.pantau') }}">
                        <small><i class="fas fa-ellipsis-h"></i></small>
                    </a>
                </td>
            </tr>
        </table>
    </div>

</div>

@elseif(Auth::check() && Auth::user()->user_role=='mahasiswa')

<div class="sidebar-maganghub bg-white shadow-sm p-0">
    <div class="sidebar-profile-top w-100 p-2">
        <div class="text-center text-dark">
            <small>selamat datang</small>
        </div>
    </div>

    @php ($univsb = \App\Mahasiswa::where('mahasiswa_user_email', Auth::user()->user_email )->first())

    <div class="sidebar-profile-bot w-100 p-2">
        <div class="sidebar-profile-thumb text-center">
            @if($univsb->mahasiswa_profile_pict == "")
            <i class="fas fa-user-graduate bg-white border p-2 shadow-sm" style="font-size: 70px"></i>
            @else
            <img src="{{ url('storage/mahasiswa_profile/'.$univsb->mahasiswa_profile_pict) }}" class="bg-white border p-2 shadow-sm mx-auto">
            @endif
        </div>
        <div class="sidebar-name text-center mx-2">
            <small>Mahasiswa</small><br>
            <b>{{ $univsb->mahasiswa_nim }}</b><br>
            {{ $univsb->mahasiswa_nama }}
            
            @if(\App\Mahasiswa::getStatus()=='magang')
            <div class="alert alert-info p-1">
                <small>sedang magang</small>
            </div>
            @endif
        </div>
    </div>
    <div class="sidebar-profile-bot w-100 p-2">
        <table class="w-100">
            <tr class="align-top">
                <td>
                    <small>Profil</small><br />
                    <small class="text-primary">{{ $univsb->mahasiswa_nim }}</small>
                </td>
                <td class="text-right">
                    <a class="btn btn-outline-info btn-block p-1 mb-3" href="{{ url('mahasiswa/detail/'.$univsb->mahasiswa_id) }}">
                        <small><i class="fas fa-ellipsis-h"></i></small>
                    </a>
                </td>
            </tr>
        </table>
    </div>
    <div class="p-2">
        <table class="w-100">
            <tr class="align-top">
                <td>
                    <small>Riwayat Lamaran</small><br />
                    <div class="text-primary">{{ \App\Rekrut::getCountAll() }}</div>
                </td>
                <td class="text-right">
                    <a class="btn btn-outline-info btn-block p-1 mb-3" href="{{ route('perekrutan.lamaranlist') }}">
                        <small><i class="fas fa-ellipsis-h"></i></small>
                    </a>
                </td>
            </tr>
            @if(\App\Mahasiswa::getStatus()=='mencari')
            <tr class="align-top">
                <td>
                    <small>Lamaran Baru</small><br />
                    <div class="text-primary">{{ \App\Rekrut::getCount('melamar') }}</div>
                </td>
                <td class="text-right">
                    <a class="btn btn-outline-info btn-block p-1 mb-3" href="{{ route('perekrutan.lamaranlist').'?filter_status=melamar' }}">
                        <small><i class="fas fa-ellipsis-h"></i></small>
                    </a>
                </td>
            </tr>
            <tr class="align-top">
                <td>
                    <small>Undangan Test</small><br />
                    <div class="text-primary">{{ \App\Rekrut::getCount('diundang') }}</div>
                </td>
                <td class="text-right">
                    <a class="btn btn-outline-info btn-block p-1 mb-3" href="{{ route('perekrutan.lamaranlist').'?filter_status=diundang' }}">
                        <small><i class="fas fa-ellipsis-h"></i></small>
                    </a>
                </td>
            </tr>
            <tr class="align-top">
                <td>
                    <small>Siap Test</small><br />
                    <div class="text-primary">{{ \App\Rekrut::getCount('siap test') }}</div>
                </td>
                <td class="text-right">
                    <a class="btn btn-outline-info btn-block p-1 mb-3" href="{{ route('perekrutan.lamaranlist').'?filter_status=siap test' }}">
                        <small><i class="fas fa-ellipsis-h"></i></small>
                    </a>
                </td>
            </tr>
            @else
            <tr class="align-top">
                <td>
                    <small>Kegiatan Magang</small><br />
                    <div class="text-primary">{{ \App\Kegiatan::getCountAll() }}</div>
                </td>
                <td class="text-right">
                    <a class="btn btn-outline-info btn-block p-1 mb-3" href="{{ route('kegiatan.manage') }}">
                        <small><i class="fas fa-ellipsis-h"></i></small>
                    </a>
                </td>
            </tr>
            @endif
        </table>
    </div>

</div>

@elseif(Auth::check() && Auth::user()->user_role=='perusahaan')

<div class="sidebar-maganghub bg-white shadow-sm p-0">
    <div class="sidebar-profile-top w-100 p-2">
        <div class="text-center text-dark">
            <small>selamat datang</small>
        </div>
    </div>

    @php ($univsb = \App\Perusahaan::where('perusahaan_user_email', Auth::user()->user_email )->first())

    <div class="sidebar-profile-bot w-100 p-2">
        <div class="sidebar-profile-thumb text-center">
            @if($univsb->perusahaan_profile_pict == "")
            <i class="fas fa-briefcase bg-white border p-2 shadow-sm" style="font-size: 70px"></i>
            @else
            <img src="{{ url('storage/perusahaan_profile/'.$univsb->perusahaan_profile_pict) }}" class="bg-white border p-2 shadow-sm mx-auto">
            @endif
        </div>
        <div class="sidebar-name text-center mx-2">
            <small>Perusahaan</small><br>
            <b>{{ $univsb->perusahaan_nib }}</b><br>
            {{ $univsb->perusahaan_nama }}
        </div>
    </div>
    <div class="sidebar-profile-bot w-100 p-2">
        <table class="w-100">
            <tr class="align-top">
                <td>
                    <small>Verifikasi Perusahaan</small><br />
                    @if(\App\Perusahaan::getIsVerified($univsb->perusahaan_id))
                        <small class="text-primary"><i class="fas fa-check"></i> Terverifikasi</small>
                    @else
                        <small class="text-primary">mohon lengkapi profil</small>
                    @endif
                </td>
                <td class="text-right">
                    <a class="btn btn-outline-info btn-block p-1 mb-3" href="{{ url('perusahaan/detail/'.$univsb->perusahaan_id) }}">
                        <small><i class="fas fa-ellipsis-h"></i></small>
                    </a>
                </td>
            </tr>
        </table>
    </div>
    <div class="sidebar-profile-bot w-100 p-2">
        <table class="w-100">
            <tr class="align-top">
                <td>
                    <small>Lowongan Diposting</small><br />
                    <div class="text-primary">{{ \App\Lowongan::getCountPosted() }}</div>
                </td>
                <td class="text-right">
                    <a class="btn btn-outline-info btn-block p-1 mb-3" href="{{ route('lowongan.manage') }}">
                        <small><i class="fas fa-ellipsis-h"></i></small>
                    </a>
                </td>
            </tr>
        </table>
    </div>
    <div class="sidebar-profile-bot w-100 p-2">
        <table class="w-100">
            <tr class="align-top">
                <td>
                    <small>Daftar Pelamar</small><br />
                    <div class="text-primary">{{ \App\Rekrut::getCountPerusahaanAll() }}</div>
                </td>
                <td class="text-right">
                    <a class="btn btn-outline-info btn-block p-1 mb-3" href="{{ route('perekrutan.pelamar') }}">
                        <small><i class="fas fa-ellipsis-h"></i></small>
                    </a>
                </td>
            </tr>
            <tr class="align-top">
                <td>
                    <small>Pelamar Baru</small><br />
                    <div class="text-primary">{{ \App\Rekrut::getCountPerusahaan('melamar') }}</div>
                </td>
                <td class="text-right">
                    <a class="btn btn-outline-info btn-block p-1 mb-3" href="{{ route('perekrutan.pelamar').'?filter_status=melamar' }}">
                        <small><i class="fas fa-ellipsis-h"></i></small>
                    </a>
                </td>
            </tr>
            <tr class="align-top">
                <td>
                    <small>Siap Test</small><br />
                    <div class="text-primary">{{ \App\Rekrut::getCountPerusahaan('siap test') }}</div>
                </td>
                <td class="text-right">
                    <a class="btn btn-outline-info btn-block p-1 mb-3" href="{{ route('perekrutan.pelamar').'?filter_status=siap test' }}">
                        <small><i class="fas fa-ellipsis-h"></i></small>
                    </a>
                </td>
            </tr>
            <tr class="align-top">
                <td>
                    <small>Magang Berjalan</small><br />
                    <div class="text-primary">{{ \App\Rekrut::getCountPerusahaan('lulus') }}</div>
                </td>
                <td class="text-right">
                    <a class="btn btn-outline-info btn-block p-1 mb-3" href="{{ route('perekrutan.pelamar').'?filter_status=lulus' }}">
                        <small><i class="fas fa-ellipsis-h"></i></small>
                    </a>
                </td>
            </tr>
        </table>
    </div>

</div>

@elseif(Auth::check() && Auth::user()->user_role=='superadmin')

<div class="sidebar-maganghub bg-white shadow-sm p-0">
    <div class="sidebar-profile-top w-100 p-2">
        <div class="text-center text-dark">
            <small>selamat datang</small>
        </div>
    </div>

    <div class="sidebar-profile-bot w-100 p-2">
        <div class="sidebar-profile-thumb text-center">
            <i class="fas fa-user-lock bg-white border p-2 shadow-sm" style="font-size: 70px"></i>
        </div>
        <div class="sidebar-name text-center mx-2">
            <small>Administrator</small><br>
            <b>{{ Auth::user()->user_email }}</b><br>
        </div>
    </div>
    <div class="sidebar-profile-bot w-100 p-2">
        <table class="w-100">
            <tr class="align-top">
                <td>
                    <small>Verifikasi Kampus</small><br />
                    <small class="text-primary">{{ \App\Univ::getUnverified() }}</small>
                </td>
                <td class="text-right">
                    <a class="btn btn-outline-info btn-block p-1 mb-3" href="{{ route('admin.kampuslist') }}">
                        <small><i class="fas fa-ellipsis-h"></i></small>
                    </a>
                </td>
            </tr>
            <tr class="align-top">
                <td>
                    <small>Verifikasi Perusahaan</small><br />
                    <small class="text-primary">{{ \App\Perusahaan::getUnverified() }}</small>
                </td>
                <td class="text-right">
                    <a class="btn btn-outline-info btn-block p-1 mb-3" href="{{ route('admin.perusahaanlist') }}">
                        <small><i class="fas fa-ellipsis-h"></i></small>
                    </a>
                </td>
            </tr>
        </table>
    </div>
    <div class="sidebar-profile-bot w-100 p-2">
        <label class="border-bottom w-100">Data Pengguna</label>
        <table class="w-100">
            <tr class="align-top">
                <td>
                    <small>Admin Kampus</small><br />
                    <small class="text-primary">{{ \App\User::getCountAdmin('admin kampus') }}</small>
                </td>
                <td class="text-right">
                    <a class="btn btn-outline-info btn-block p-1 mb-3" href="#">
                        <small><i class="fas fa-ellipsis-h"></i></small>
                    </a>
                </td>
            </tr>
            <tr class="align-top">
                <td>
                    <small>Admin Perusahaan</small><br />
                    <small class="text-primary">{{ \App\User::getCountAdmin('perusahaan') }}</small>
                </td>
                <td class="text-right">
                    <a class="btn btn-outline-info btn-block p-1 mb-3" href="#">
                        <small><i class="fas fa-ellipsis-h"></i></small>
                    </a>
                </td>
            </tr>
            <tr class="align-top">
                <td>
                    <small>Dosen Pembimbing</small><br />
                    <small class="text-primary">{{ \App\User::getCountAdmin('dospem') }}</small>
                </td>
                <td class="text-right">
                    <a class="btn btn-outline-info btn-block p-1 mb-3" href="#">
                        <small><i class="fas fa-ellipsis-h"></i></small>
                    </a>
                </td>
            </tr>
            <tr class="align-top">
                <td>
                    <small>Mahasiswa</small><br />
                    <small class="text-primary">{{ \App\User::getCountAdmin('mahasiswa') }}</small>
                </td>
                <td class="text-right">
                    <a class="btn btn-outline-info btn-block p-1 mb-3" href="#">
                        <small><i class="fas fa-ellipsis-h"></i></small>
                    </a>
                </td>
            </tr>
        </table>
    </div>

</div>

@else

<div class="sidebar-maganghub p-0">
    <a class="btn btn-info btn-block py-1 px-3 mb-3 shadow-sm" href="{{ url('registkampus') }}">
        <small>Registrasi Admin Kampus</small>
    </a>
    <a class="btn btn-info btn-block py-1 px-3 mb-3 shadow-sm" href="{{ route('registperusahaan') }}">
        <small>Registrasi Admin Perusahaan</small>
    </a>
    <a class="btn btn-success btn-block py-1 px-3 mb-3 shadow-sm" href="{{ route('login') }}">
        <small>LOGIN</small>
    </a>
</div>

@endif
