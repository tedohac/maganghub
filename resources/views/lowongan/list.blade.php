@extends('layouts.front', ['title' => 'Lihat Lowongan - MagangHub'])

@section('head')
    
    <!-- SB Admin Template -->
    <link href="{{ asset('styles/sb-admin.css?v=').time() }}" rel="stylesheet">

    <!-- Auto complete -->
    <link href="{{ url('styles/select2.min.css') }}" rel="stylesheet" />

    <!-- Datepicker -->
    <link href="{{ url('styles/bootstrap-datepicker3.css') }}" rel="stylesheet">

    <style>
        .company-thumb img {
            max-width: 100%;
            display: block;
            margin: 0 auto;
        }
    </style>
@endsection

@section('banner-front')
<div class="py-3">
    <h3 class="">Lowongan Tersedia</h3>
    <p class="text-justify">
        Berbagai perusahaan terbaik telah membuka kesempatan dan siap menerima keahlian para mahasiswa. 
        Penempatan magang tersebar di banyak kota di Indonesia dan terbuka untuk berbagai jurusan.
        Tertarik untuk membuka lowongan juga? <a href="{{ route('registperusahaan') }}" class="text-light">Klik di sini</a> untuk mendaftar sebagai admin perusahaan.
    </p>
</div>
@endsection

@section('content')
    <ol class="breadcrumb p-1 ml-auto">
        <li class="breadcrumb-item ml-auto"><a href="{{ route('/') }}">MagangHub</a></li>
        <li class="breadcrumb-item active" aria-current="page">Cari Kampus</li>
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

    <!-- filter -->
    <div class="card mb-3 p-1">
        <div class="card-header p-1">
            
            <a class="btn btn-outline-primary p-1" data-toggle="collapse" href="#collapseSearchCon" role="button" aria-expanded="false" aria-controls="collapseSearchCon">    
                <i class="fas fa-filter"></i>
                Filter
            </a>

            @if($filter->perusahaan!="" || !empty($filter->fungsi) || $filter->city!="")
                <a href="{{ route('lowongan.list') }}"><span class="badge badge-danger">Clear</span></a>
            @endif
        </div>
        <div class="card-body collapse p-1" id="collapseSearchCon">
        <form method="get" id="formadd" action="{{ route('lowongan.list') }}">

            <div class="row">
                <div class="col-6 mb-2">
                    <small>Perusahaan</small><br>
                    <input class="form-control" name="filter_perusahaan" value="{{ $filter->perusahaan }}">
                </div>
                
                <div class="col-6 mb-2">
                    <small>Fungsi Pekerjaan</small><br>
                    <select class="form-control fungsiFilter" name="filter_fungsi[]" multiple="multiple">
                        @foreach($fungsis as $fungsi)
                            @php ($selected = in_array($fungsi->fungsi_id, $filter->fungsi) ? "selected" : "")
                            <option value="{{ $fungsi->fungsi_id }}" {{ $selected }}>{{ $fungsi->fungsi_nama }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-6 mb-2">
                    <small>Filter Mulai Magang - Dari</small><br>
                    <input id="mulaidariFilter" class="form-control" placeholder="Dari" name="filter_mulaidari" type="text" value="{{ $filter->mulaidari }}">
                </div>
                
                <div class="col-6 mb-2">
                    <small>Filter Mulai Magang - Sampai</small><br>
                    <input id="mulaisampaiFilter" class="form-control" placeholder="Sampai" name="filter_mulaisampai" type="text" value="{{ $filter->mulaisampai }}">
                </div>

                <div class="col-6 mb-2">
                    <small>Kota Penempatan</small><br>
                    <select class="form-control cityFilter" name="filter_city">
                    @if($filter->city!="")
                        <option value="{{ $filter->city }}" selected>{{ $filter->city_nama }}</option>
                    @endif
                    </select>
                </div>

                <div class="col-12">
                    <input type="submit" class="btn btn-primary btn-block h-100" value="Apply">
                </div>

            </div>

        </form>
        </div>
    </div>
    <!-- end filter -->

    <!-- container -->
    {{ $lowongans->links() }}
    @foreach($lowongans as $lowongan)
        <div class="bg-white border py-2 m-0 mb-3 shadow-sm row">
            <div class="company-thumb text-center col-lg-2 col-4">
                @if(empty($lowongan->perusahaan_profile_pict))
                <i class="fas fa-briefcase" style="font-size: 100px"></i>
                @else
                <img src="{{ url('storage/perusahaan_profile/'.$lowongan->perusahaan_profile_pict) }}">
                @endif
            </div>
            <div class="row col-lg-10 col-8">
                
                <div class="col-12">
                    <h5 class="m-0 text-primary">{{ $lowongan->lowongan_judul }}</h5>
                </div>
                <div class="col-md-6 col-12">
                    <small>{{ $lowongan->fungsi_nama }}</small><br />
                    {{ $lowongan->perusahaan_nama }}<br />
                    
                    @if(\App\Perusahaan::getIsVerified($lowongan->perusahaan_id))
                        <small><i class="fas fa-check"></i> Terverifikasi</small>
                    @else
                        <small>Menunggu verifikasi MagangHub</small>
                    @endif
                    <br />
                    <small>Penempatan: {{ $lowongan->city_nama }}</small><br />
                </div>
                <div class="col-md-6 col-12 text-right">
                    <small>Mulai magang :</small> {{ $lowongan->lowongan_tgl_mulai }}<br />
                    <small>Durasi magang:</small> {{ $lowongan->lowongan_durasi }}<br />
                    <small>Jumlah dibutuhkan:</small> {{ $lowongan->lowongan_jlh_dibutuhkan }}<br />
                    <!-- <small>23 orang telah melamar</small> -->
                </div>
            </div>
            <div class="col-12">
                @if(Auth::check() && (Auth::user()->user_role=='mahasiswa' || Auth::user()->user_role=='dospem'))
                    <a class="btn btn-outline-info p-1" href="{{ url('lowongan/detail/'.$lowongan->lowongan_id) }}">
                        <small>Lihat Detail</small>
                    </a>
                @else
                    <small><i>Silahkan login sebagai mahasiswa atau DOSPEM untuk melihat detail dan melamar</i></small>
                @endif
            </div>
        </div>
    @endforeach
    {{ $lowongans->links() }}

@endsection

@section('bottom')
<!-- SB-Admin-->
<script src="{{ url('js/sb-admin.min.js') }}"></script>

<!-- Auto Complete-->
<script src="{{ url('js/select2.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('.cityFilter').select2({
        width: '100%',
        placeholder: '-- Pilih Kota Penempatan --',
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
        },
    });
    
    $('.fungsiFilter').select2({
        width: '100%'
    });
});
</script>

<!-- Datepicker-->
<script src="{{ url('js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $(document).ready(function(){

        var uploaded=$('input[name="filter_mulaidari"]');
        uploaded.datepicker({
            format: "yyyy-mm-dd",
            container: $('#mulaidariFilter').parent(),
            todayHighlight: true,
            autoclose: true,
            orientation: "auto",
        });
        
        var uploaded=$('input[name="filter_mulaisampai"]');
        uploaded.datepicker({
            format: "yyyy-mm-dd",
            container: $('#mulaisampaiFilter').parent(),
            todayHighlight: true,
            autoclose: true,
            orientation: "auto",
        });
        
        $("#mulaidariFilter").on('changeDate', function(selected) {
            var startDate = new Date(selected.date.valueOf());
            $("#mulaisampaiFilter").datepicker('setStartDate', startDate);
            if($("#mulaidariFilter").val() > $("#mulaisampaiFilter").val()){
            $("#mulaisampaiFilter").val($("#mulaidariFilter").val());
            }
        });
    })
</script>
@endsection