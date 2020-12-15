@extends('layouts.front', ['title' => 'Edit Kampus - MagangHub'])

@section('head')
    
    <!-- SB Admin Template -->
    <link href="{{ asset('styles/sb-admin.css?v=').time() }}" rel="stylesheet">
    
    <!-- Datepicker -->
    <link href="{{ url('styles/bootstrap-datepicker3.css') }}" rel="stylesheet">

    <!-- Profile -->
    <link href="{{ asset('styles/profile.css?v=').time() }}" rel="stylesheet">
    
    <!-- Auto complete -->
    <link href="{{ url('styles/select2.min.css') }}" rel="stylesheet" />
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
        <li class="breadcrumb-item active" aria-current="page">Edit Kampus</li>
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
    
<form action="{{ route('kampus.update') }}" method="post" id="registform" enctype="multipart/form-data">
@csrf

    <div class="alert alert-warning">
        - Lengkapi data untuk mendapatkan verifikasi kampus dari MagangHub.<br>
        - Perubahan data kampus akan menunggu verifikasi ulang dari MagangHub.
    </div>

    <!-- detail info -->
    <h5 class="mb-2 p-0">
        Edit Kampus
    </h5>
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-5">
        <table class="table table-sm" cellspacing="0">
            <tr>
                <td valign="center" width="50" class="greybox"><b>Nama</b></td>
                <td>
                    <input id="namaKampus" class="form-control" placeholder="Nama Kampus" name="univ_nama" required="required" autofocus="autofocus" type="text"
                        value="{{ $univ->univ_nama }}"
                        data-parsley-required
                        data-parsley-required-message="Masukan nama kampus">
                    @error('univ_nama')
                        <span class="form-text text-danger">
                            {{ $message }}
                        </span>    
                    @enderror
                </td>
            </tr>
            <tr>
                <td valign="center" width="50" class="greybox"><b>Logo</b></td>
                <td>
                    <small>kosongkan jika tidak ingin merubah</small>
                    <div class="input-group w-50">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="profilepict" name="univ_profile_pict" accept="image/*">
                            <label class="custom-file-label" for="profilepict">Pilih file</label>
                        </div>
                    </div>
                    <span id="errorprofilepict" class="form-text text-danger"></span>
                </td>
            </tr>
            <tr>
                <td valign="center" width="50" class="greybox"><b>Akreditasi</b></td>
                <td>
                    <div class="stars">
                        <input class="star star-5" id="star-5" type="radio" name="univ_akreditasi" value="a" {{ ($univ->univ_akreditasi=='a') ? "checked" : "" }}/>
                        <label class="star star-5" for="star-5">A</label>
                        <input class="star star-4" id="star-4" type="radio" name="univ_akreditasi" value="b" {{ ($univ->univ_akreditasi=='b') ? "checked" : "" }}/>
                        <label class="star star-4" for="star-4">B</label>
                        <input class="star star-3" id="star-3" type="radio" name="univ_akreditasi" value="c" {{ ($univ->univ_akreditasi=='c') ? "checked" : "" }}/>
                        <label class="star star-3" for="star-3">C</label>
                        <input class="star star-2" id="star-2" type="radio" name="univ_akreditasi" value="d" {{ ($univ->univ_akreditasi=='d') ? "checked" : "" }}/>
                        <label class="star star-2" for="star-2">D</label>
                        <input class="star star-1" id="star-1" type="radio" name="univ_akreditasi" value="e" {{ ($univ->univ_akreditasi=='e') ? "checked" : "" }}/>
                        <label class="star star-1" for="star-1">E</label>
                    </div>

                </td>
            </tr>
            <tr>
                <td valign="center" width="50" class="greybox"><b>NPSN</b></td>
                <td>
                    <input id="npsnKampus" class="form-control" placeholder="NPSN" name="univ_npsn" required="required" type="text"
                        value="{{ $univ->univ_npsn }}"
                        data-parsley-required
                        data-parsley-required-message="Masukan NPSN kampus">
                    @error('univ_npsn')
                        <span class="form-text text-danger">
                            {{ $message }}
                        </span>    
                    @enderror

                </td>
            </tr>
            <tr>
                <td valign="center" width="50" class="greybox"><b>Tanggal Berdiri</b></td>
                <td class="position-relative">
                    <input id="tglberdiriKampus" class="form-control" placeholder="Tanggal Berdiri" name="univ_tgl_berdiri" type="text"
                        value="{{ $univ->univ_tgl_berdiri }}"
                        data-parsley-type="date"
                        data-parsley-type-message="Format tanggal YYYY-MM-DD">
                    @error('univ_tgl_berdiri')
                        <span class="form-text text-danger">
                            {{ $message }}
                        </span>    
                    @enderror

                </td>
            </tr>
            <tr>
                <td valign="center" width="50" class="greybox"><b>Telepon</b></td>
                <td>
                    <input id="tlpKampus" class="form-control" placeholder="Telepon Kampus" name="univ_no_tlp" type="text"
                        value="{{ $univ->univ_no_tlp }}"
                        data-parsley-type="number"
                        data-parsley-type-message="Telepon hanya berupa nomor">
                    @error('univ_no_tlp')
                        <span class="form-text text-danger">
                            {{ $message }}
                        </span>    
                    @enderror

                </td>
            </tr>
            <tr>
                <td valign="center" width="50" class="greybox"><b>Website</b></td>
                <td>
                    <input id="websiteKampus" class="form-control" placeholder="Website Kampus" name="univ_website" type="text"
                        value="{{ $univ->univ_website }}"
                        data-parsley-type="url"
                        data-parsley-type-message="Format website tidak benar">
                    @error('univ_website')
                        <span class="form-text text-danger">
                            {{ $message }}
                        </span>    
                    @enderror

                </td>
            </tr>
            <tr>
                <td valign="center" width="50" class="greybox"><b>Alamat</b></td>
                <td>
                    <textarea id="alamatKampus" class="form-control" placeholder="Alamat Kampus" name="univ_alamat">{{ $univ->univ_alamat }}</textarea>
                    @error('univ_alamat')
                        <span class="form-text text-danger">
                            {{ $message }}
                        </span>    
                    @enderror

                </td>
            </tr>
            <tr>
                <td valign="center" width="50" class="greybox"><b>Kota</b></td>
                <td>
                    <select class="form-control univCity" name="univ_city_id">
                        @if($univ->univ_city_id!="")
                            <option value="{{ $univ->univ_city_id }}" selected>{{ $univ->city_nama }}</option>
                        @endif
                    </select>
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
    <!-- Datepicker-->
    <script src="{{ url('js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $(document).ready(function(){

            var uploaded=$('input[name="univ_tgl_berdiri"]');
            uploaded.datepicker({
                format: "yyyy-mm-dd",
                container: $('#tglberdiriKampus').parent(),
                todayHighlight: true,
                autoclose: true,
                orientation: "auto",
            });
        })
    </script>
    
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
        $('.univCity').select2({
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