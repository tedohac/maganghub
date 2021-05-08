@extends('layouts.front', ['title' => $univ->univ_nama.' - MagangHub'])

@section('head')
    
    <!-- SB Admin Template -->
    <link href="{{ asset('styles/sb-admin.css?v=').time() }}" rel="stylesheet">

    <!-- DataTable-->
    <link href="{{ url('datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">

    <!-- Profile -->
    <link href="{{ asset('styles/profile.css?v=').time() }}" rel="stylesheet">

    <style>
        .font-20 {
            font-size: 20px;
        }
    </style>
@endsection

@section('banner-front')
<div class="row m-0 mt-5 panel">
    <div class="profile-thumb col-lg-3 col-md-4 pr-md-0 text-center text-dark">
        @if(empty($univ->univ_profile_pict))
        <i class="fas fa-university bg-white border p-2 shadow-sm" style="font-size: 130px"></i>
        @else
        <img src="{{ url('storage/univ/'.$univ->univ_profile_pict) }}" class="bg-white border p-2 shadow">
        @endif
    </div>
    <div class="profile-text col-lg-9 col-md-8 p-md-0 mb-2">
        <h3 class="m-0">{{ $univ->univ_nama }}</h3>
        @if(\App\Univ::getIsVerified($univ->univ_id))
            <small><i class="fas fa-check"></i> Terverifikasi</small>
        @elseif(\App\Univ::getIsBanned($univ->univ_id))
            <span class="badge badge-danger"><i class="fas fa-exclamation-triangle"></i> Kampus ini sedang dalam pengawasan</span>
        @else
            <small>Menunggu kelengkapan profil untuk verifikasi</small>
        @endif
    </div>
</div>
@endsection


@section('content')
    <ol class="breadcrumb p-1 ml-auto">
        <li class="breadcrumb-item ml-auto"><a href="{{ route('/') }}">MagangHub</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.kampuslist') }}">Daftar Kampus</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail Kampus</li>
    </ol>

    @if(session('errors'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif
    @if (Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
        </div>
    @endif

    <!-- detail info -->
    <h5 class="mb-2 p-0">
        Profil Kampus
    </h5>
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-5">
        <table class="table" cellspacing="0">
            <tr>
                <td class="greybox" width="100"><b>Akreditasi</b></td>
                <td>
                    <span class="font-20 fa fa-star {{ $univ->univ_akreditasi!='' && ord($univ->univ_akreditasi)-96<6 ? 'text-warning' : '' }}"></span>
                    <span class="font-20 fa fa-star {{ $univ->univ_akreditasi!='' && ord($univ->univ_akreditasi)-96<5 ? 'text-warning' : '' }}"></span>
                    <span class="font-20 fa fa-star {{ $univ->univ_akreditasi!='' && ord($univ->univ_akreditasi)-96<4 ? 'text-warning' : '' }}"></span>
                    <span class="font-20 fa fa-star {{ $univ->univ_akreditasi!='' && ord($univ->univ_akreditasi)-96<3 ? 'text-warning' : '' }}"></span>
                    <span class="font-20 fa fa-star {{ $univ->univ_akreditasi!='' && ord($univ->univ_akreditasi)-96<2 ? 'text-warning' : '' }}"></span>
                    <span class="font-20">({{ strtoupper($univ->univ_akreditasi) }})</span>
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>NPSN</b></td>
                <td>
                    {{ $univ->univ_npsn ? $univ->univ_npsn : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Tanggal Berdiri</b></td>
                <td>
                    {{ $univ->univ_tgl_berdiri ? $univ->univ_tgl_berdiri : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Telepon</b></td>
                <td>
                    {{ $univ->univ_no_tlp ? $univ->univ_no_tlp : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Website</b></td>
                <td>
                    <a href="{{ $univ->univ_website ? $univ->univ_website : '#' }}">{{ $univ->univ_website ? $univ->univ_website : '-' }}</a>
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Alamat</b></td>
                <td>
                    {{ $univ->univ_alamat ? $univ->univ_alamat : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Kota</b></td>
                <td>
                    {{ $univ->city_nama ? $univ->city_nama : '-' }}
                </td>
            </tr>
        </table>
        <div class="row">
            <div class="col-6 mb-2">
                @if(empty($univ->univ_verified))
                    <input type="button" class="btn btn-primary btn-block py-1" value="Verifikasi" id="btnVerify">
                @else
                    Kampus sudah diverifikasi pada {{ date('d F Y', strtotime($univ->univ_verified)) }}
                @endif
            </div>

            @if($univ->user_status==1)
            <div class="col-6 mb-2">
                <input type="button" class="btn btn-danger btn-block py-1" value="Awasi" id="btnAwasi">
            </div>
            @endif

            @if(\App\Prodi::getCountByUniv($univ->univ_id)==0)
            <div class="col-6 mb-2">
                <input type="button" class="btn btn-danger btn-block py-1" value="Hapus" id="btnHapus">
            </div>
            @endif
        </div>
    </div>

    <!-- prodi list -->
    <h5 class="mb-2 p-0">
        Program Studi
        
        @if(Auth::check() && Auth::user()->user_email == $univ->univ_user_email)
        <a class="btn btn-outline-info p-1 float-right" href="{{ route('prodi.manage') }}">
            <small><i class="fas fa-edit"></i> Kelola Program Studi</small>
        </a>
        @endif
    </h5>
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-5">
        
        <table class="table table-sm table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead class="greybox">
                <tr>
                    <th>#</th>
                    <th>Program Studi</th>
                    <th>Fakultas</th>
                    <th>Jenjang</th>
                    <th>Akreditasi</th>
                    <th>DOSPEM</th>
                    <th>Mahasiswa</th>
                </tr>
            </thead>
            <tbody>
            @php ($num = 1)
            @foreach($prodis as $prodi)
                <tr>
                    <td>{{ $num }}</td>
                    <td>{{ $prodi->prodi_nama }}</td>
                    <td>{{ $prodi->prodi_fakultas!='' ? $prodi->prodi_fakultas : '-' }}</td>
                    <td>{{ $prodi->prodi_jenjang }}</td>
                    <td>{{ strtoupper($prodi->prodi_akreditasi) }}</td>
                    <td>{{ \App\Dospem::getCountByProdi($prodi->prodi_id) }}</td>
                    <td>{{ \App\Mahasiswa::getCountByProdi($prodi->prodi_id) }}</td>
                </tr>
                @php ($num++)
            @endforeach
            </tbody>
        </table>

    </div>
    <!-- end prodi list -->
    
<!-- Verify Modal -->
<div class="modal fade" id="verifyModal">
    <div class="modal-dialog">
    <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
        <h4 class="modal-title">Verifikasi Kampus</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            Apakah anda yakin untuk memverifikasi kampus ini ?
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>

            <a class="btn btn-primary" href="{{ url('admin/kampusverify/'.$univ->univ_id) }}">Ya</a>
        </div>

    </div>
    </div>
</div>
<!-- End Verify Modal -->

<!-- Awasi Modal -->
<div class="modal fade" id="awasiModal">
    <div class="modal-dialog">
    <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
        <h4 class="modal-title">Awasi Kampus</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            Apakah anda yakin untuk mengawasi kampus ini ?<br />
            Saat diawasi, kampus tidak dapat dicari oleh public, memiliki label khusus, dan tidak dapat login ke MagangHub.
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>

            <a class="btn btn-primary" href="{{ url('admin/kampusawasi/'.$univ->univ_id) }}">Ya</a>
        </div>

    </div>
    </div>
</div>
<!-- End Awasi Modal -->
@endsection

@section('bottom')
<!-- DataTable-->
<script src="{{ url('datatables/jquery.dataTables.js') }}"></script>
<script src="{{ url('datatables/dataTables.bootstrap4.js') }}"></script>

<!-- SB-Admin-->
<script src="{{ url('js/sb-admin.min.js') }}"></script>

<script>
    $(document).ready(function (){
        var table = $('#dataTable').DataTable();
        
        $('#btnVerify').click(function(){
            $('#verifyModal').modal('show');
        });
        
        $('#btnAwasi').click(function(){
            $('#awasiModal').modal('show');
        });
    });
</script>
@endsection