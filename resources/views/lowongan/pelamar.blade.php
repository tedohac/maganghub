@extends('layouts.front', ['title' => 'Daftar Pelamar - MagangHub'])

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
        <li class="breadcrumb-item"><a href="{{ url('perusahaan/detail/'.$perusahaan->lowongan_perusahaan_id) }}">Profil Perusahaan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Daftar Pelamar</li>
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
        Daftar Pelamar
    </h5>
    
<form method="get" id="formadd">
@csrf
    <!-- filter -->
    <div class="card mb-3 p-1">
        <div class="card-header p-1">
            
            <a class="btn btn-outline-primary p-1" data-toggle="collapse" href="#collapseSearchCon" role="button" aria-expanded="false" aria-controls="collapseSearchCon">    
                <i class="fas fa-filter"></i>
                Filter
            </a>

            @if($filter->lowongan!="" || $filter->status!="")
                <a href="{{ route('perekrutan.pelamar') }}"><span class="badge badge-danger">Clear</span></a>
            @endif
            
            <input type="submit" formmethod="get" class="btn btn-outline-success float-right" value="Download" formaction="{{ route('perekrutan.pelamardownload') }}">
        </div>
        <div class="card-body collapse p-1" id="collapseSearchCon">

            <div class="row">
                <div class="col-6 mb-2">
                    <small>Lowongan</small><br>
                    <select class="form-control lowonganFilter" name="filter_lowongan">
                    @if($filter->lowongan!="")
                        <option value="{{ $filter->lowongan }}" selected>{{ $filter->lowongan_judul }}</option>
                    @endif
                    </select>
                </div>

                <div class="col-6">
                    <small>Status Pelamar</small><br>
                    <select class="form-control" name="filter_status">
                        <option value="" {{ ($filter->status=='') ? 'selected' : '' }}>-- Pilih status pelamar --</option>
                        <option value="melamar" {{ ($filter->status=='melamar') ? 'selected' : '' }}>Melamar</option>
                        <option value="melamartlk" {{ ($filter->status=='melamartlk') ? 'selected' : '' }}>Melamar Ditolak</option>
                        <option value="diundang" {{ ($filter->status=='diundang') ? 'selected' : '' }}>Diundang Test</option>
                        <option value="cnfrmtest" {{ ($filter->status=='cnfrmtest') ? 'selected' : '' }}>Konfirmasi Test</option>
                        <option value="tdklulus" {{ ($filter->status=='tdklulus') ? 'selected' : '' }}>Tidak Lulus</option>
                        <option value="lulus" {{ ($filter->status=='lulus') ? 'selected' : '' }}>Magang Berjalan</option>
                        <option value="finishmhs" {{ ($filter->status=='finishmhs') ? 'selected' : '' }}>Menunggu Rating</option>
                        <option value="finishprs" {{ ($filter->status=='finishmhs') ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <div class="col-12">
                    <input type="submit" formmethod="get" class="btn btn-primary btn-block h-100" value="Apply" formaction="{{ route('perekrutan.pelamar') }}">
                </div>

            </div>

        </div>
    </div>
    <!-- end filter -->
</form>

    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-3">
        <table class="table table-sm table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead class="greybox">
                <tr>
                    <th>#</th>
                    <th>Tgl Melamar</th>
                    <th>Lowongan</th>
                    <th>Kampus</th>
                    <th>Prodi</th>
                    <th>Mahasiswa</th>
                    <th>Status</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
            @php ($num = 1)
            @foreach($rekruts as $rekrut)
                <tr>
                    <td>{{ $num }}</td>
                    <td>{{ $rekrut->lowongan_judul }}</td>
                    <td>{{ date('Y-m-d', strtotime($rekrut->rekrut_waktu_melamar)) }}</td>
                    <td>{{ $rekrut->univ_nama }}</td>
                    <td>{{ $rekrut->prodi_nama }}</td>
                    <td>{{ $rekrut->mahasiswa_nama }}</td>
                    <td>
                        @if($rekrut->rekrut_status=='magang')
                            Sudah Magang
                        @elseif($rekrut->rekrut_status=="melamartlk")
                            Ditolak
                        @elseif($rekrut->rekrut_status=="tlkundang")
                            Undangan ditolak
                        @elseif($rekrut->rekrut_status=="cnfrmtest")
                            Undangan dikonfirmasi
                        @elseif($rekrut->rekrut_status=="tdklulus")
                            Tidak Lulus
                        @elseif($rekrut->rekrut_status=="finishmhs")
                            Menunggu Rating
                        @elseif($rekrut->rekrut_status=="finishprs")
                            Selesai
                        @else
                            {{ $rekrut->rekrut_status }}
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-outline-info p-1 edit-form" href="{{ url('perekrutan/detailpelamar/'.$rekrut->rekrut_id) }}" title="Detail">
                            <small><i class="fas fa-ellipsis-h"></i></small>
                        </a>
                        @if($rekrut->rekrut_status=='lulus' || $rekrut->rekrut_status=='finishmhs' || $rekrut->rekrut_status=='finishprs')
                        <a class="btn btn-outline-info px-1 py-0 mt-1 edit-form" href="{{ url('kegiatan/mentorview/'.$rekrut->rekrut_id) }}" title="Kegiatan">
                            <small>Kegiatan</small>
                        </a>
                        @endif
                    </td>
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