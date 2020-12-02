@extends('layouts.front', ['title' => 'Edit Profil Perusahaan - MagangHub'])

@section('head')
    
    <!-- SB Admin Template -->
    <link href="{{ asset('styles/sb-admin.css?v=').time() }}" rel="stylesheet">

    <!-- Profile -->
    <link href="{{ asset('styles/profile.css?v=').time() }}" rel="stylesheet">
    
    <!-- Auto complete -->
    <link href="{{ url('styles/select2.min.css') }}" rel="stylesheet" />
@endsection

@section('banner-front')
<div class="row m-0 mt-5 panel">
    <div class="profile-thumb col-lg-3 col-md-4 pr-md-0 text-center text-dark">
        @if(empty($perusahaan->perusahaan_profile_pict))
        <i class="fas fa-user-briefcase bg-white border p-2 shadow-sm" style="font-size: 130px"></i>
        @else
        <img src="{{ url('storage/perusahaan_profile/'.$perusahaan->perusahaan_profile_pict) }}" class="bg-white border p-2 shadow">
        @endif
    </div>
    <div class="profile-text col-lg-9 col-md-8 p-md-0 mb-2">
        <h3 class="m-0">{{ $perusahaan->perusahaan_nama }}</h3>
        <small>Menunggu kelengkapan profil untuk verifikasi</small>
    </div>
</div>
@endsection

@section('content')
    <ol class="breadcrumb p-1 ml-auto">
        <li class="breadcrumb-item ml-auto"><a href="{{ route('/') }}">MagangHub</a></li>
        <li class="breadcrumb-item"><a href="{{ url('perusahaan/detail/'.$perusahaan->perusahaan_id) }}">Profil Perusahaan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Profil Perusahaan</li>
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
    
<form action="{{ route('perusahaan.update') }}" method="post" id="registform" enctype="multipart/form-data">
@csrf

    <!-- detail info -->
    <h5 class="mb-2 p-0">
        Edit Profil Mahasiswa
    </h5>
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-5">
        <table class="table table-sm" cellspacing="0">
            <tr>
                <td valign="center" width="50" class="greybox"><b>Logo</b></td>
                <td>
                    <small>kosongkan jika tidak ingin merubah</small>
                    <div class="input-group w-50">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="profilepict" name="perusahaan_profile_pict" accept="image/*">
                            <label class="custom-file-label" for="profilepict">Pilih file</label>
                        </div>
                    </div>
                    <span id="errorprofilepict" class="form-text text-danger"></span>
                </td>
            </tr>
            <tr>
                <td valign="center" width="50" class="greybox"><b>Nama</b></td>
                <td>
                    <input id="namaPerusahaan" class="form-control" placeholder="Nama Perusahaan" name="perusahaan_nama" required="required" autofocus="autofocus" type="text"
                        value="{{ $perusahaan->perusahaan_nama }}"
                        data-parsley-required
                        data-parsley-required-message="Masukan Nama Perusahaan">
                    @error('perusahaan_nama')
                        <span class="form-text text-danger">
                            {{ $message }}
                        </span>    
                    @enderror
                </td>
            </tr>
            <tr>
                <td valign="center" width="50" class="greybox"><b>NIB</b></td>
                <td>
                    <input id="nibPerusahaan" class="form-control" placeholder="NIB" name="perusahaan_nib" required="required" type="text"
                        value="{{ $perusahaan->perusahaan_nib }}"
                        data-parsley-required
                        data-parsley-required-message="Masukan NIB Perusahaan">
                    @error('perusahaan_nib')
                        <span class="form-text text-danger">
                            {{ $message }}
                        </span>    
                    @enderror

                </td>
            </tr>
            <tr>
                <td valign="center" width="50" class="greybox"><b>No Telepon</b></td>
                <td>
                    <input id="tlpPerusahaan" class="form-control" placeholder="No Telepon" name="perusahaan_no_tlp" type="text"
                        value="{{ $perusahaan->perusahaan_no_tlp }}"
                        data-parsley-type="number"
                        data-parsley-type-message="Telepon hanya berupa nomor">
                    @error('perusahaan_no_tlp')
                        <span class="form-text text-danger">
                            {{ $message }}
                        </span>    
                    @enderror

                </td>
            </tr>
            <tr>
                <td valign="center" width="50" class="greybox"><b>Website</b></td>
                <td>
                    <input id="websitePerusahaan" class="form-control" placeholder="Website" name="perusahaan_website" type="text"
                        value="{{ $perusahaan->perusahaan_website }}"
                        data-parsley-type="url"
                        data-parsley-type-message="Format website tidak benar">
                    @error('perusahaan_website')
                        <span class="form-text text-danger">
                            {{ $message }}
                        </span>    
                    @enderror

                </td>
            </tr>
            <tr>
                <td valign="center" width="50" class="greybox"><b>Kota</b></td>
                <td>
                    <select class="form-control perusahaanCity" name="perusahaan_city_id">
                        @if($perusahaan->perusahaan_city_id!="")
                            <option value="{{ $perusahaan->perusahaan_city_id }}" selected>{{ $perusahaan->city_nama }}</option>
                        @endif
                    </select>
                </td>
            </tr>
            <tr>
                <td valign="center" width="50" class="greybox"><b>Alamat</b></td>
                <td>
                    <textarea id="alamatPerusahaan" class="form-control" placeholder="Alamat Perusahaan" name="perusahaan_alamat">{{ $perusahaan->perusahaan_alamat }}</textarea>
                    @error('perusahaan_alamat')
                        <span class="form-text text-danger">
                            {{ $message }}
                        </span>    
                    @enderror

                </td>
            </tr>
            <tr>
                <td valign="center" width="50" class="greybox"><b>Scan NIB</b></td>
                <td>
                    <small>kosongkan jika tidak ingin merubah</small>
                    <div class="input-group w-50">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="nibPerusahaan" name="perusahaan_nib_path" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps">
                            <label class="custom-file-label" for="nibPerusahaan">Pilih file</label>
                        </div>
                    </div>
                    <span id="errornibPerusahaan" class="form-text text-danger"></span>
                </td>
            </tr>
            <tr>
                <td valign="center" width="50" class="greybox"></td>
                <td>
                    <input type="button" class="btn btn-success btn-block" value="SIMPAN" id="btnsubmit" data-toggle="modal" data-target="#confirmModal">
                </td>
            </tr>
        </table>
    </div>
    <!-- end detail info -->

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
                Apakah anda yakin untuk mengubah detail profil?
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
@endsection

@section('bottom')
    
    <!-- Parsley Form Validation -->
    <script src="{{ url('js/parsley.min.js') }}"></script>
	<script>
        $("#registform").parsley({
            errorClass: 'is-invalid text-danger',
            errorsWrapper: '<span class="form-text text-danger"></span>',
            errorTemplate: '<span></span>',
            trigger: 'change'
        }) /* If you want to validate fields right after page loading, just add this here : .validate()*/ ;
        
        // Parsley full doc is avalailable here : https://github.com/guillaumepotier/Parsley.js/
	</script>

    <!-- Preview Profile Pict -->
    <script>
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        $("#profilepict").change(function()
        {
            if (this.files && this.files[0]) {
                var reader = new FileReader();

                var fileName = this.value,
                    idxDot = fileName.lastIndexOf(".") + 1,
                    extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
             
                if (extFile!="jpg" && extFile!="jpeg" && extFile!="png")
                {
                    $("#profilepict").addClass("is-invalid text-danger");
                    $("#btnsubmit").prop('disabled', true);
                    return;
                }
                
                $(".profile-thumb").empty();

                $("#btnsubmit").prop('disabled', false);
                reader.onload = function(e) {
                    $(".profile-thumb").append('<img id="previewpict" class="bg-light border p-2 shadow-sm">');
                    $('#previewpict').attr('src', e.target.result);
                }
                
                reader.readAsDataURL(this.files[0]); // convert to base64 string
            }
        });
    </script>
    
    <!-- Auto Complete-->
    <script src="{{ url('js/select2.min.js') }}"></script>
    <script type="text/javascript">
        $('.perusahaanCity').select2({
            placeholder: '-- Pilih Kota --',
            ajax: {
            url: '{{ url('cityautocom') }}',
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