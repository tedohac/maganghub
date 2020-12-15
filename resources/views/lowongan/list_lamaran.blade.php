@extends('layouts.front', ['title' => 'Daftar Lamaran - MagangHub'])

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
        .longtext {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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
        <li class="breadcrumb-item active" aria-current="page">Daftar Lamaran</li>
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
        Daftar Lamaran Anda
    </h5>
    
    <!-- filter -->
    <div class="card mb-3 p-1">
        <div class="card-header p-1">
            
            <a class="btn btn-outline-primary p-1" data-toggle="collapse" href="#collapseSearchCon" role="button" aria-expanded="false" aria-controls="collapseSearchCon">    
                <i class="fas fa-filter"></i>
                Filter
            </a>

            @if($filter->status!="")
                <a href="{{ route('perekrutan.lamaranlist') }}"><span class="badge badge-danger">Clear</span></a>
            @endif
        </div>
        <div class="card-body collapse p-1" id="collapseSearchCon">
        <form method="get" id="formadd" action="{{ route('perekrutan.pelamar') }}">

            <div class="row">

                <div class="col-6">
                    <small>Status Pelamar</small><br>
                    <select class="form-control" name="filter_status">
                        <option value="" {{ ($filter->status=='') ? 'selected' : '' }}>-- Pilih status pelamar --</option>
                        <option value="melamar" {{ ($filter->status=='melamar') ? 'selected' : '' }}>Melamar</option>
                        <option value="melamartlk" {{ ($filter->status=='melamartlk') ? 'selected' : '' }}>Melamar Ditolak</option>
                        <option value="diundang" {{ ($filter->status=='diundang') ? 'selected' : '' }}>Diundang</option>
                        <option value="siap test" {{ ($filter->status=='siap test') ? 'selected' : '' }}>Siap Test</option>
                        <option value="tdklulus" {{ ($filter->status=='tdklulus') ? 'selected' : '' }}>Tidak Lulus</option>
                        <option value="lulus" {{ ($filter->status=='lulus') ? 'selected' : '' }}>Magang Berjalan</option>
                        <option value="finishmhs" {{ ($filter->status=='finishmhs') ? 'selected' : '' }}>Menunggu Rating</option>
                        <option value="finishprs" {{ ($filter->status=='finishmhs') ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <div class="col-12">
                    <input type="submit" formmethod="get" class="btn btn-primary btn-block h-100" value="Apply" formaction="#">
                </div>

            </div>

        </form>
        </div>
    </div>
    <!-- end filter -->

    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-3">
        <table class="table table-sm table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead class="greybox">
                <tr>
                    <th>#</th>
                    <th>Tgl Melamar</th>
                    <th>Lowongan</th>
                    <th>Perusahaan</th>
                    <th>Fungsi</th>
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
                    <td>{{ date('Y-m-d', strtotime($rekrut->rekrut_waktu_melamar)) }}</td>
                    <td>
                        <a href="{{ url('lowongan/detail/'.$rekrut->lowongan_id) }}">
                            {{ $rekrut->lowongan_judul }}
                        </a>
                    </td>
                    <td>{{ $rekrut->perusahaan_nama }}</td>
                    <td>{{ $rekrut->fungsi_nama }}</td>
                    <td>{{ $rekrut->mahasiswa_nama }}</td>
                    <td>
                        @if($rekrut->rekrut_status=='magang')
                            Sudah Magang
                        @elseif($rekrut->rekrut_status=="melamartlk")
                            Ditolak
                        @elseif($rekrut->rekrut_status=="tlkundang")
                            Undangan ditolak mahasiswa
                        @elseif($rekrut->rekrut_status=="finishmhs")
                            Menunggu Rating
                        @elseif($rekrut->rekrut_status=="finishprs")
                            Selesai
                        @else
                            {{ $rekrut->rekrut_status }}
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-outline-info p-1 edit-form" href="{{ url('perekrutan/detaillamaran/'.$rekrut->rekrut_id) }}" title="Undangan">
                            <small><i class="fas fa-ellipsis-h"></i></small>
                        </a>
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

        $('#dataTable').on('click', '.hapus-form', function(){
            var id =  $(this).data('id');
            console.log(id);
            
            $('#submitDelete').attr('href', '{{ route("lowongan.delete") }}?id='+id);
            $('.modal-body').html('Apakah anda yakin untuk menghapus lowongan terpilih ?');
            $('#deleteModal').modal('show');
        });
    });
</script>
@endsection