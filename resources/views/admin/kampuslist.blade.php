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
        <li class="breadcrumb-item active" aria-current="page">Daftar Kampus</li>
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
        Daftar Kampus
    </h5>
    
    <!-- filter -->
    <div class="card mb-3 p-1">
        <div class="card-header p-1">
            
            <a class="btn btn-outline-primary p-1" data-toggle="collapse" href="#collapseSearchCon" role="button" aria-expanded="false" aria-controls="collapseSearchCon">    
                <i class="fas fa-filter"></i>
                Filter
            </a>

            @if($filter->status!="")
                <a href="{{ route('admin.kampuslist') }}"><span class="badge badge-danger">Clear</span></a>
            @endif
        </div>
        <div class="card-body collapse p-1" id="collapseSearchCon">
        <form method="get" id="formadd" action="{{ route('perekrutan.pelamar') }}">

            <div class="row">
                <div class="col-6">
                    <small>Status Pelamar</small><br>
                    <select class="form-control" name="filter_status">
                        <option value="" {{ ($filter->status=='') ? 'selected' : '' }}>-- Pilih status verifikasi --</option>
                        <option value="unverified" {{ ($filter->status=='unverified') ? 'selected' : '' }}>Sudah Verifikasi</option>
                        <option value="verified" {{ ($filter->status=='verified') ? 'selected' : '' }}>Belum Verifikasi</option>
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
                    <th>Nama Kampus</th>
                    <th>E-mail</th>
                    <th>NPSN</th>
                    <th>Website</th>
                    <th>Verifikasi Email</th>
                    <th>Verifikasi MagangHub</th>
                    <th>Status</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
            @php ($num = 1)
            @foreach($univs as $univ)
                <tr>
                    <td>{{ $num }}</td>
                    <td>{{ $univ->univ_nama }}</td>
                    <td>{{ $univ->univ_user_email }}</td>
                    <td>{{ $univ->univ_npsn }}</td>
                    <td><a href="{{ $univ->univ_website }}">{{ $univ->univ_website }}</a></td>
                    <td>
                        @if($univ->user_email_verified_at=='')
                            Belum
                        @else
                            {{ $univ->user_email_verified_at }}
                        @endif
                    </td>
                    <td>
                        @if($univ->univ_verified=='')
                            Belum
                        @else
                            {{ $univ->univ_verified }}
                        @endif
                    </td>
                    <td>
                        @if($univ->user_status=='1')
                            Aktif
                        @elseif($univ->user_status=='0')
                            Diawasi
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-outline-info p-1 edit-form" href="{{ url('admin/kampusdetail/'.$univ->univ_id) }}" title="Detail">
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