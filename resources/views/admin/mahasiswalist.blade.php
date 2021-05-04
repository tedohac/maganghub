@extends('layouts.front', ['title' => 'Daftar Kampus - MagangHub'])

@section('head')
    
    <!-- SB Admin Template -->
    <link href="{{ asset('styles/sb-admin.css?v=').time() }}" rel="stylesheet">

    <!-- DataTable-->
    <link href="{{ url('datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">

    <!-- Profile -->
    <link href="{{ asset('styles/profile.css?v=').time() }}" rel="stylesheet">

    <!-- Auto complete -->
    <link href="{{ url('styles/select2.min.css') }}" rel="stylesheet" />

    <style>
        .font-20 {
            font-size: 20px;
        }
    </style>
@endsection

@section('banner-front')
<div class="row m-0 mt-5 py-4 panel">
</div>
@endsection

@section('content')
    <ol class="breadcrumb p-1 ml-auto">
        <li class="breadcrumb-item ml-auto"><a href="{{ route('/') }}">MagangHub</a></li>
        <li class="breadcrumb-item active" aria-current="page">Daftar Mahasiswa</li>
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

    <!-- detail lowongan -->
    <h5 class="mb-2 p-0">
        Daftar Mahasiswa
    </h5>
    
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-3">
        <table class="table table-sm table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead class="greybox">
                <tr>
                    <th>#</th>
                    <th>NIM</th>
                    <th>Program Studi</th>
                    <th>Dosen Pembimbing</th>
                    <th>Kampus</th>
                    <th>Nama</th>
                    <th>E-Mail</th>
                    <th>Verifikasi</th>
                    <th><small>Status<br />Magang</small></th>
                </tr>
            </thead>
            <tbody>
            @php ($num = 1)
            @foreach($mahasiswas as $mahasiswa)
                <tr>
                    <td>{{ $num }}</td>
                    <td>{{ $mahasiswa->mahasiswa_nim }}</td>
                    <td>({{ $mahasiswa->prodi_jenjang }}) {{ $mahasiswa->prodi_nama }}</td>
                    <td>{{ $mahasiswa->dospem_nama }}</td>
                    <td>{{ $mahasiswa->univ_nama }}</td>
                    <td>{{ $mahasiswa->mahasiswa_nama }}</td>
                    <td>{{ $mahasiswa->mahasiswa_user_email }}</td>
                    <td>
                        @if($mahasiswa->user_email_verified_at=="")
                            Belum
                        @else
                            Aktif
                        @endif
                    </td>
                    <td>{{ $mahasiswa->mahasiswa_status }}</td>
                </tr>
                @php ($num++)
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- end detail lowongan -->
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
    });
</script>

<!-- Auto Complete-->
<script src="{{ url('js/select2.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('.lowonganFilter').select2({
        width: '100%',
        placeholder: '-- Pilih Lowongan --',
        ajax: {
            url: '{{ url('lowonganautocom') }}',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
    });
    
    $('.fungsiFilter').select2({
        width: '100%'
    });
});
</script>
@endsection