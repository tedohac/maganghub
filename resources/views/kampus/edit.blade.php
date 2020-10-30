@extends('layouts.front', ['title' => 'Kampus - MagangHub'])

@section('head')
    
    <!-- SB Admin Template -->
    <link href="{{ asset('styles/sb-admin.css?v=').time() }}" rel="stylesheet">
    
    <!-- Datepicker -->
    <link href="{{ url('styles/bootstrap-datepicker3.css') }}" rel="stylesheet">

    <style rel="stylesheet">
      body {
        /* background-image: url("{{ url('img/bg2.png') }}");
        background-position: center top;
        background-repeat: no-repeat;
        background-size: 100% 400px; */
        background: linear-gradient(to bottom, #ffb4b0 33%, #6562cf 100%);
        background: linear-gradient(to bottom, rgba(255,144,139,1), rgba(255,144,139,0));
        background-repeat: no-repeat;
      }
      
      .navbar-nav .nav-item.dropdown .dropdown-toggle::after {}

      /* Rating */
        div.stars {
            display: inline-block;
        }

        input.star { display: none; }

        label.star {
            color: #444;
            float: right;
            padding: 5px;
            font-size: 18px;
        }

        input.star:checked ~ label.star {
            content: '\f005';
            color: #b99800;
        }

        input.star-5:checked ~ label.star {
            text-shadow: 0 0 20px #FE7;
        }

        input.star-1:checked ~ label.star { color: #F62; }

        label.star:before {
            content: '\f005';
            font-family: "Font Awesome 5 Free";
        }
      /* Rating */

      .profile-thumb {
        height: 140px;
      }
      .profile-thumb img {
        max-width: 180px;
        max-height: 140px;
      }
      
      @media (min-width: 768px)
      {
        .panel {
            height: 110px;
        }
        .profile-text {
            float: left;
            height: auto;
            margin-top: auto;
            /* position: relative; */
        }
        .profile-thumb {
            float: left;
            position: relative;
            height: 110px;
        }
        .profile-thumb img {
            position: absolute;
            bottom: -30px;
        }
      }
    </style>
@endsection

@section('content')
<form action="{{ route('kampus.update') }}" method="post" id="registform" enctype="multipart/form-data">
@csrf
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

    <div class="alert alert-warning">
        - Lengkapi data untuk mendapatkan verifikasi kampus dari MagangHub.<br>
        - Perubahan data kampus akan menunggu verifikasi ulang dari MagangHub.
    </div>

    <div class="row m-0 mt-5 panel">

        <div class="profile-thumb col-lg-3 col-md-4 pr-md-0">
            @if($univ->profile_pict == "")
            <i class="fas fa-university bg-light border p-2 shadow-sm" style="font-size: 130px"></i>
            @else
            <img src="{{ url('storage/univ/'.$univ->profile_pict) }}" class="bg-light border p-2 shadow-sm">
            @endif
        </div>
        <div class="profile-text col-lg-9 col-md-8 p-md-0 mb-2">
            <h3>Edit Detail Kampus</h3>
            <input id="namaKampus" class="form-control" placeholder="Nama Kampus" name="univ_nama" required="required" autofocus="autofocus" type="text"
                value="{{ $univ->nama }}"
                data-parsley-required
                data-parsley-required-message="Masukan nama kampus">
            @error('univ_nama')
                <span class="form-text text-danger">
                    {{ $message }}
                </span>    
            @enderror
        </div>
    </div>

    <div class="bg-white shadow-sm border px-2 px-lg-3 pt-5 pb-3">
        

        <table class="table table-sm" cellspacing="0">
            <tr>
                <td valign="center" width="50" class="greybox"><b>Logo</b></td>
                <td>
                    
                    <div class="input-group w-50">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="profilepict" name="univ_profilepict" accept="image/*">
                            <label class="custom-file-label" for="profilepict">Choose file</label>
                        </div>
                    </div>
                    <span id="errorprofilepict" class="form-text text-danger"></span>
                </td>
            </tr>
            <tr>
                <td valign="center" width="50" class="greybox"><b>Akreditasi</b></td>
                <td>
                    <div class="stars">
                        <input class="star star-5" id="star-5" type="radio" name="univ_akreditasi" value="a" {{ ($univ->akreditasi=='a') ? "checked" : "" }}/>
                        <label class="star star-5" for="star-5">A</label>
                        <input class="star star-4" id="star-4" type="radio" name="univ_akreditasi" value="b" {{ ($univ->akreditasi=='b') ? "checked" : "" }}/>
                        <label class="star star-4" for="star-4">B</label>
                        <input class="star star-3" id="star-3" type="radio" name="univ_akreditasi" value="c" {{ ($univ->akreditasi=='c') ? "checked" : "" }}/>
                        <label class="star star-3" for="star-3">C</label>
                        <input class="star star-2" id="star-2" type="radio" name="univ_akreditasi" value="d" {{ ($univ->akreditasi=='d') ? "checked" : "" }}/>
                        <label class="star star-2" for="star-2">D</label>
                        <input class="star star-1" id="star-1" type="radio" name="univ_akreditasi" value="e" {{ ($univ->akreditasi=='e') ? "checked" : "" }}/>
                        <label class="star star-1" for="star-1">E</label>
                    </div>

                </td>
            </tr>
            <tr>
                <td valign="center" width="50" class="greybox"><b>No. SKPT</b></td>
                <td>
                    <input id="noskptKampus" class="form-control" placeholder="No. SKPT" name="univ_noskpt" required="required" type="text"
                        value="{{ $univ->no_skpt }}"
                        data-parsley-required
                        data-parsley-required-message="Masukan No. SKPT">
                    @error('univ_noskpt')
                        <span class="form-text text-danger">
                            {{ $message }}
                        </span>    
                    @enderror

                </td>
            </tr>
            <tr>
                <td valign="center" width="100" class="greybox"><b>Tanggal SKPT</b></td>
                <td>
                    <input id="tglskptKampus" class="form-control" placeholder="Tanggal SKPT" name="univ_tglskpt" type="text"
                        value="{{ $univ->tgl_skpt }}"
                        data-parsley-type="date"
                        data-parsley-type-message="Format tanggal YYYY-MM-DD">
                    @error('univ_tglskpt')
                        <span class="form-text text-danger">
                            {{ $message }}
                        </span>    
                    @enderror

                </td>
            </tr>
            <tr>
                <td valign="center" width="50" class="greybox"><b>Tanggal Berdiri</b></td>
                <td>
                    <input id="tglberdiriKampus" class="form-control" placeholder="Tanggal Berdiri" name="univ_tglberdiri" type="text"
                        value="{{ $univ->tgl_berdiri }}"
                        data-parsley-type="date"
                        data-parsley-type-message="Format tanggal YYYY-MM-DD">
                    @error('univ_tglberdiri')
                        <span class="form-text text-danger">
                            {{ $message }}
                        </span>    
                    @enderror

                </td>
            </tr>
            <tr>
                <td valign="center" width="50" class="greybox"><b>Telepon</b></td>
                <td>
                    <input id="tlpKampus" class="form-control" placeholder="Telepon Kampus" name="univ_notlp" type="text"
                        value="{{ $univ->no_tlp }}"
                        data-parsley-type="number"
                        data-parsley-type-message="Telepon hanya berupa nomor">
                    @error('univ_notlp')
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
                        value="{{ $univ->website }}"
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
                    <textarea id="alamatKampus" class="form-control" placeholder="Alamat Kampus" name="univ_alamat">{{ $univ->alamat }}</textarea>
                    @error('univ_alamat')
                        <span class="form-text text-danger">
                            {{ $message }}
                        </span>    
                    @enderror

                </td>
            </tr>
            <tr>
                <td valign="center" width="50" class="greybox"></td>
                <td>
                    <input class="btn btn-success btn-block" value="SIMPAN" type="submit" id="btnsubmit">
                </td>
            </tr>
        </table>
    </div>
</form>
@endsection

@section('bottom')
    <!-- Datepicker-->
    <script src="{{ url('js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            var options={
                format: "yyyy-mm-dd",
                container: $(document.activeElement).parent(),
                todayHighlight: true,
                autoclose: true,
                orientation: "auto",
            };

            var uploaded=$('input[name="univ_tglskpt"]');
            uploaded.datepicker(options);
            
            var uploaded=$('input[name="univ_tglberdiri"]');
            uploaded.datepicker(options);
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
@endsection