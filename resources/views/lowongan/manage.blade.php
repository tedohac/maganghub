@extends('layouts.front', ['title' => 'Kelola Lowongan - MagangHub'])

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
<div class="row m-0 mt-5 py-4 panel">
</div>
@endsection

@section('content')
    <ol class="breadcrumb p-1 ml-auto">
        <li class="breadcrumb-item ml-auto"><a href="{{ route('/') }}">MagangHub</a></li>
        <li class="breadcrumb-item active" aria-current="page">Kelola Lowongan</li>
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

    <!-- prodi list -->
    <h5 class="mb-2 p-0">
        Kelola Lowongan
        
        <a class="btn btn-outline-info p-1 float-right" href="{{ route('lowongan.add') }}">
            <small><i class="fas fa-plus"></i> Tambah Lowongan</small>
        </a>
    </h5>
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-3">
    <div class="table-responsive">
        <table class="table table-sm table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead class="greybox">
                <tr>
                    <th>#</th>
                    <th>Lowongan</th>
                    <th>Fungsi</th>
                    <th>Penempatan</th>
                    <th>Tgl Mulai</th>
                    <th><small>Jlh<br />Dibutuhkan</small></th>
                    <th>Status</th>
                    <th>Pelamar</th>
                    <th width="50">Opsi</th>
                </tr>
            </thead>
            <tbody>
            @php ($num = 1)
            @foreach($lowongans as $lowongan)
                <tr>
                    <td>{{ $num }}</td>
                    <td>{{ $lowongan->lowongan_judul }}</td>
                    <td>{{ $lowongan->fungsi_nama }}</td>
                    <td>{{ $lowongan->city_nama }}</td>
                    <td>{{ $lowongan->lowongan_tgl_mulai }}</td>
                    <td>{{ $lowongan->lowongan_jlh_dibutuhkan }}</td>
                    <td>{{ $lowongan->lowongan_status }}</td>
                    <td>
                        <a class="btn btn-outline-info py-0 px-1" href="{{ url('perekrutan/pelamar/').'?filter_lowongan='.$lowongan->lowongan_id }}">
                            {{ $lowongan->total_pelamar }}
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-outline-info p-1 edit-form" href="{{ url('lowongan/edit/'.$lowongan->lowongan_id) }}" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        @if($lowongan->lowongan_status=='draft')
                            <a class="btn btn-outline-danger p-1 hapus-form" href="#" data-id="{{ $lowongan->lowongan_id }}" title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        @endif
                    </td>
                </tr>
                @php ($num++)
            @endforeach
            </tbody>
        </table>
    </div>
    </div>
    <!-- end prodi list -->
    
    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal">
        <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Konfirmasi</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>

            <a class="btn btn-primary" id="submitDelete" href="#">Ya</a>
            </div>

        </div>
        </div>
    </div>
    <!-- End Delete Modal -->

@endsection

@section('bottom')
<!-- DataTable-->
<script src="{{ url('datatables/jquery.dataTables.js') }}"></script>
<script src="{{ url('datatables/dataTables.bootstrap4.js') }}"></script>

<!-- SB-Admin-->
<script src="{{ url('js/sb-admin.min.js') }}"></script>

<!-- Parsley Form Validation -->
<script src="{{ url('js/parsley.min.js') }}"></script>
<script>
    $("#formadd").parsley({
        errorClass: 'is-invalid text-danger',
        errorsWrapper: '<span class="form-text text-danger"></span>',
        errorTemplate: '<span></span>',
        trigger: 'change'
    })
</script>

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

        $('#formadd').parsley().on('form:validate', function (formInstance) {
            var success = formInstance.isValid();
            
            if (!success) {
                $('#confirmModal').modal('hide');
            }
        });
    });
</script>
@endsection