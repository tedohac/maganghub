<div class="sidebar-maganghub bg-white shadow-sm mt-2 p-0">
    <div class="sidebar-profile-top w-100 p-2">
        <div class="text-center text-dark">
            <small>selamat datang</small>
        </div>
    </div>
    @if(Auth::check() && Auth::user()->role='admin kampus')

        @php ($univsb = \App\Univ::where('email', Auth::user()->email )->first())

        <div class="sidebar-profile-bot w-100 p-2">
            <div class="sidebar-profile-thumb">
                @if($univsb->profile_pict == "")
                <i class="fas fa-university bg-light border p-2 shadow-sm" style="font-size: 80px"></i>
                @else
                <img src="{{ url('storage/univ/'.$univ->profile_pict) }}" class="bg-light border p-2 shadow-sm mx-auto">
                @endif
            </div>
            <div class="sidebar-name text-center mx-2">
                <small>admin kampus</small><br>
                <b>{{ $univsb->nama }}</b>
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
                        <a class="btn btn-outline-info btn-block p-1 mb-3" href="{{ url('kampus/detail/'.$univsb->id) }}">
                            <small>PROFIL</small>
                        </a>
                    </td>
                </tr>
                <tr class="align-top">
                    <td>
                        <small>Program Studi</small><br />
                        <div class="text-primary">4</div>
                    </td>
                    <td class="text-right">
                        <a class="btn btn-outline-info btn-block p-1 mb-3" href="#">
                            <small>PRODI</small>
                        </a>
                    </td>
                </tr>
                <tr class="align-top">
                    <td>
                        <small>Dosen Pembimbing</small><br />
                        <div class="text-primary">10</div>
                    </td>
                    <td class="text-right">
                        <a class="btn btn-outline-info btn-block p-1 mb-3" href="#">
                            <small>DOSPEM</small>
                        </a>
                    </td>
                </tr>
                <tr class="align-top">
                    <td>
                        <small>Mahasiswa</small><br />
                        <div class="text-primary">57</div>
                    </td>
                    <td class="text-right">
                        <a class="btn btn-outline-info btn-block p-1 mb-3" href="#">
                            <small>Mahasiswa</small>
                        </a>
                    </td>
                </tr>
            </table>
        </div>

    @endif
</div>