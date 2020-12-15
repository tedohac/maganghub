@extends('layouts.front', ['title' => 'Kelola Mahasiswa - MagangHub'])

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
<div class="row m-0 mt-5 panel">
    <div class="profile-thumb col-lg-3 col-md-4 pr-md-0 text-center text-dark">
        @if($univ->univ_profile_pict == "")
        <i class="fas fa-university bg-white border p-2 shadow-sm" style="font-size: 130px"></i>
        @else
        <img src="{{ url('storage/univ/'.$univ->univ_profile_pict) }}" class="bg-white border p-2 shadow">
        @endif
    </div>
    <div class="profile-text col-lg-9 col-md-8 p-md-0 mb-2">
        <h3 class="m-0">{{ $univ->univ_nama }}</h3>
        @if(\App\Univ::getIsVerified($univ->univ_id))
            <small><i class="fas fa-check"></i> Terverifikasi</small>
        @else
            <small>Menunggu kelengkapan profil untuk verifikasi</small>
        @endif
    </div>
</div>
@endsection


@section('content')
    <ol class="breadcrumb p-1 ml-auto">
        <li class="breadcrumb-item ml-auto"><a href="{{ route('/') }}">MagangHub</a></li>
        <li class="breadcrumb-item"><a href="{{ route('kampus.list') }}">Cari Kampus</a></li>
        <li class="breadcrumb-item"><a href="{{ url('kampus/detail/'.$univ->univ_id) }}">Detail Kampus</a></li>
        <li class="breadcrumb-item active" aria-current="page">Kelola Mahasiswa</li>
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

    <!-- Mahasiswa list -->
    <h5 class="mb-2 p-0">
        Kelola Mahasiswa
    </h5>
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-3">
    <div class="table-responsive">
        <table class="table table-sm table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead class="greybox">
                <tr>
                    <th>#</th>
                    <th>NIM</th>
                    <th>PRODI</th>
                    <th>DOSPEM</th>
                    <th>Nama</th>
                    <th>E-Mail</th>
                    <th>Verifikasi</th>
                    <th><small>Status<br />Magang</small></th>
                    <th width="70">Opsi</th>
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
                    <td>
                        <a class="btn btn-outline-info p-1 verify-form mb-1" href="#" data-id="{{ $mahasiswa->mahasiswa_id }}" title="Verifikasi Ulang">
                            <i class="fas fa-envelope"></i>
                        </a>
                        <a class="btn btn-outline-info p-1 edit-form mb-1" href="#" data-id="{{ $mahasiswa->mahasiswa_id }}" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a class="btn btn-outline-danger p-1 hapus-form mb-1" href="#" data-id="{{ $mahasiswa->mahasiswa_id }}" title="Hapus">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                @php ($num++)
            @endforeach
            </tbody>
        </table>
    </div>
    </div>
    <!-- end mahasiswa list -->
    
<form method="post" id="formadd" action="{{ route('mahasiswa.save') }}">
@csrf
    <!-- add form -->
    <div class="card mb-3 p-1">
        <div class="card-header p-1" id="formHeader">
            
            <a class="btn btn-outline-primary p-1" data-toggle="collapse" href="#collapseSearchCon" role="button" aria-expanded="false" aria-controls="collapseSearchCon" id="addTogle">    
                <i class="fas fa-plus"></i>
                Tambah Mahasiswa
            </a>

            <a class="btn btn-outline-success p-1 float-right" href="{{ route('mahasiswa.import') }}">    
                <i class="fas fa-cloud-upload-alt"></i>
                Import Mahasiswa
            </a>
        </div>
        <div class="card-body collapse p-1" id="collapseSearchCon">
            <input type="hidden" name="edit_id" id="idEdit">
            <table class="table table-sm" cellspacing="0">
                <tr>
                    <td valign="center" width="50" class="greybox"><b>NIM Mahasiswa</b></td>
                    <td>
                        <input id="nimMahasiswa" class="form-control" placeholder="" name="mahasiswa_nim" required="required" autofocus="autofocus" type="text" value="{{ old('mahasiswa_nim') }}"
                            data-parsley-required
                            data-parsley-required-message="Masukan NIM Mahasiswa">
                        @error('mahasiswa_nim')
                            <span class="form-text text-danger">
                                {{ $message }}
                            </span>    
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td valign="center" width="50" class="greybox"><b>Nama Mahasiswa</b></td>
                    <td>
                        <input id="namaMahasiswa" class="form-control" placeholder="" name="mahasiswa_nama" required="required" autofocus="autofocus" type="text" value="{{ old('mahasiswa_nama') }}"
                            data-parsley-required
                            data-parsley-required-message="Masukan nama Nama Mahasiswa">
                        @error('mahasiswa_nama')
                            <span class="form-text text-danger">
                                {{ $message }}
                            </span>    
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td valign="center" width="50" class="greybox"><b>Dosen Pembimbing</b></td>
                    <td>
                        <select id="dospemMahasiswa" class="form-control dospemMahasiswa" required="required" name="mahasiswa_dospem_id"
                            data-parsley-required
                            data-parsley-required-message="Pilih Dosen Pembimbing">
                        </select>
                        @error('mahasiswa_dospem_id')
                            <span class="form-text text-danger">
                                {{ $message }}
                            </span>    
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td valign="center" width="50" class="greybox"><b>E-Mail Mahasiswa</b></td>
                    <td>
                        <input id="emailMahasiswa" class="form-control" placeholder="" name="mahasiswa_user_email" required="required" autofocus="autofocus" type="text" value="{{ old('mahasiswa_user_email') }}"
                            data-parsley-required
                            data-parsley-type="email"
                            data-parsley-required-message="Masukan e-mail Dosen Pembimbing"
                            data-parsley-type-message="Format e-mail tidak valid">
                        @error('mahasiswa_user_email')
                            <span class="form-text text-danger">
                                {{ $message }}
                            </span>    
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td valign="center" width="50" class="greybox"></td>
                    <td>
                        <input type="button" class="btn btn-success btn-block" value="Tambah Mahasiswa" id="btnsubmit" data-toggle="modal" data-target="#confirmModal">
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <!-- end add form -->

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
                Apakah anda yakin untuk membuat Mahasiswa Baru?
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
    $(document).ready(function ()
    {
        var table = $('#dataTable').DataTable();

        $('#dataTable').on('click', '.edit-form', function(){
            var id =  $(this).data('id');
            console.log('{{ url("mahasiswa/detailjson") }}?id='+id);
            $.ajax({
                type: 'GET',
                url: '{{ url("mahasiswa/detailjson") }}?id='+id,
                success: function(data)
                {
                    var result = JSON.parse(data);
                    // console.log(result);

                    $('#addTogle').html('<i class="fas fa-edit"></i> Edit Mahasiswa');
                    $('.modal-body').html('Apakah anda yakin untuk mengubah Mahasiswa <br> ['+ result.mahasiswa_nim +'] '+result.mahasiswa_nama+' ?');
                    $('#btnsubmit').val('Edit Mahasiswa');
                    $('#formadd').attr('action', '{{ route("mahasiswa.update") }}');
                    $(".alert").remove();
                    $('#formHeader').append('<div class="alert alert-warning">Edit Mahasiswa: ['+ result.mahasiswa_nim +'] '+result.mahasiswa_nama+'</div>')
                    $("#collapseSearchCon").collapse('show');
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#addTogle").offset().top
                    }, 2000);

                    $('#idEdit').val(result.mahasiswa_id);
                    $('#nimMahasiswa').val(result.mahasiswa_nim);
                    $('#namaMahasiswa').val(result.mahasiswa_nama);
                    $('#dospemMahasiswa').append('<option value="'+result.mahasiswa_dospem_id+'">['+result.prodi_nama+'] ('+result.dospem_nik+') '+result.dospem_nama+'</option>');
                    $('#emailMahasiswa').val(result.mahasiswa_user_email);
                },
                error:function() {
                    alert("Error!");
                }
            });
        });

        $('#dataTable').on('click', '.hapus-form', function(){
            var id =  $(this).data('id');
            console.log(id);
            
            $.ajax({
                type: 'GET',
                url: '{{ url("mahasiswa/detailjson") }}?id='+id,
                success: function(data)
                {
                    var result = JSON.parse(data);
                    // console.log(result);

                    $('#submitDelete').attr('href', '{{ route("mahasiswa.delete") }}?id='+id);
                    $('.modal-body').html('Apakah anda yakin untuk menghapus Mahasiswa <br> ['+ result.mahasiswa_nim +'] '+result.mahasiswa_nama+' ?');
                    $('#deleteModal').modal('show');
                },
                error:function() {
                    alert("Error!");
                }
            });
        });

        $('#dataTable').on('click', '.verify-form', function(){
            var id =  $(this).data('id');
            console.log(id);
            
            $.ajax({
                type: 'GET',
                url: '{{ url("mahasiswa/detailjson") }}?id='+id,
                success: function(data)
                {
                    var result = JSON.parse(data);
                    // console.log(result);

                    $('#submitDelete').attr('href', '{{ route("mahasiswa.reverify") }}?id='+id);
                    $('.modal-body').html('Apakah anda yakin untuk kirim ulang e-mail verifikasi Mahasiswa: <br> ['+ result.mahasiswa_nim +'] '+result.mahasiswa_nama+' <br> Proses ini juga akan mengatur ulang password Mahasiswa. Akun Mahasiswa tidak dapat digunakan sebelum Mahasiswa tersebut melakukan verifikasi.');
                    $('#deleteModal').modal('show');
                },
                error:function() {
                    alert("Error!");
                }
            });
        });


        $('#formadd').parsley().on('form:validate', function (formInstance) {
            var success = formInstance.isValid();
            
            if (!success) {
                $('#confirmModal').modal('hide');
            }
        });
    });
</script>

<!-- Auto Complete-->
<script src="{{ url('js/select2.min.js') }}"></script>
<script type="text/javascript">
    $('.dospemMahasiswa').select2({
        width: '100%',
        placeholder: '-- Pilih Dosen Pembimbing --',
        ajax: {
            url: "{{ url('dospemautocom').'?univid='.$univ->univ_id }}",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });
</script>
@endsection