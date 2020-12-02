@extends('layouts.front', ['title' => 'Kelola Skills - MagangHub'])

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
        @if(empty($mahasiswa->mahasiswa_profile_pict))
        <i class="fas fa-user-graduate bg-white border p-2 shadow-sm" style="font-size: 130px"></i>
        @else
        <img src="{{ url('storage/mahasiswa_profile/'.$mahasiswa->mahasiswa_profile_pict) }}" class="bg-white border p-2 shadow">
        @endif
    </div>
    <div class="profile-text col-lg-9 col-md-8 p-md-0 mb-2">
        <h3 class="m-0">{{ $mahasiswa->mahasiswa_nama }}</h3>
        {{ $mahasiswa->mahasiswa_nim }} - <a href="{{ url('kampus/detail/'.$mahasiswa->univ_id) }}" class="text-white">{{ $mahasiswa->univ_nama }}</a>
    </div>
</div>
@endsection


@section('content')
    <ol class="breadcrumb p-1 ml-auto">
        <li class="breadcrumb-item ml-auto"><a href="{{ route('/') }}">MagangHub</a></li>
        <li class="breadcrumb-item"><a href="{{ url('mahasiswa/detail/'.$mahasiswa->mahasiswa_id) }}">Profil Mahasiswa</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Skills</li>
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


<form method="post" id="formadd" action="{{ route('skill.save') }}">
@csrf
    <!-- skill list -->
    <h5 class="mb-2 p-0">
        Kelola Skills
    </h5>
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-3">
        <table class="table table-sm table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead class="greybox">
                <tr>
                    <th>#</th>
                    <th>Skills</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
            @php ($num = 1)
            @foreach($skills as $skill)
                <tr>
                    <td>{{ $num }}</td>
                    <td>{{ $skill->skill_nama }}</td>
                    <td>
                        <a class="btn btn-outline-danger p-1 hapus-form" href="#" data-id="{{ $skill->skill_id }}" title="Hapus">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                @php ($num++)
            @endforeach
            </tbody>
        </table>
        
        <table class="table table-sm mt-3" cellspacing="0">
            <tr>
                <td valign="center" width="50" class="greybox"><b>Tambah Skill</b></td>
                <td>
                    <input id="namaSkill" class="form-control" placeholder="Nama Skill" name="skill_nama" required="required" autofocus="autofocus" type="text"
                        data-parsley-required
                        data-parsley-required-message="Masukan Nama Skill">
                    @error('skill_nama')
                        <span class="form-text text-danger">
                            {{ $message }}
                        </span>    
                    @enderror
                </td>
                <td>
                    <input type="button" class="btn btn-success btn-block" value="Tambah Skill" id="btnsubmit" data-toggle="modal" data-target="#confirmModal">
                </td>
            </tr>
        </table>
    </div>
    <!-- end skill list -->
    
    <!-- Confirm Modal -->
    <div class="modal fade" id="confirmModal">
        <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Konfirmasi</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                Apakah anda yakin untuk membuat skill Baru?
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>

            <input  type="submit" class="btn btn-primary" id="sendsubmit" value="Ya">
            </div>

        </div>
        </div>
    </div>
    <!-- End Confirm Modal -->
</form>

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
            
            $('#submitDelete').attr('href', '{{ route("skill.delete") }}?id='+id);
            $('.modal-body').html('Apakah anda yakin untuk menghapus skill terpilih ?');
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