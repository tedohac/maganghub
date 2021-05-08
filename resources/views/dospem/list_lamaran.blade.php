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
        <li class="breadcrumb-item"><a href="{{ route('mahasiswa.pantau') }}">Daftar Mahasiswa</a></li>
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
        Detail Mahasiswa
    </h5>
    
    <!-- info mahasiswa -->
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-3">
        <div class="py-1">Informasi Mahasiswa Pelamar</div>
        <table class="table" cellspacing="0">
            <tr>
                <td class="greybox"><b>Kampus</b></td>
                <td>
                    <a href="{{ url('kampus/detail/'.$mahasiswa->univ_id) }}" class="text-dark">{{ $mahasiswa->univ_nama }}</a>
                    @if(\App\Univ::getIsBanned($mahasiswa->univ_id))
                        <span class="badge badge-danger"><i class="fas fa-exclamation-triangle"></i> Kampus ini sedang dalam pengawasan</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Prodi</b></td>
                <td>
                    {{ ($mahasiswa->prodi_fakultas!="") ? $mahasiswa->prodi_fakultas."-" : "" }} {{ $mahasiswa->prodi_nama }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>NIM</b></td>
                <td>
                    {{ $mahasiswa->mahasiswa_nim }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>TTL</b></td>
                <td>
                    {{ $mahasiswa->mahasiswa_tempat_lahir ? $mahasiswa->mahasiswa_tempat_lahir : '-' }}, {{ $mahasiswa->mahasiswa_tgl_lahir ? date('d F Y', strtotime($mahasiswa->mahasiswa_tgl_lahir)) : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Telepon</b></td>
                <td>
                    {{ $mahasiswa->mahasiswa_no_tlp ? $mahasiswa->mahasiswa_no_tlp : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Domisili</b></td>
                <td>
                    {{ $mahasiswa->city_nama ? $mahasiswa->city_nama : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Alamat</b></td>
                <td>
                    {{ $mahasiswa->mahasiswa_alamat ? $mahasiswa->mahasiswa_alamat : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>CV</b></td>
                <td>
                    @if($mahasiswa->mahasiswa_cv)
                        <a class="btn btn-outline-success p-1" href="{{ url('storage/mahasiswa_cv/'.$mahasiswa->mahasiswa_cv) }}"> 
                            <i class="fas fa-cloud-download-alt"></i>
                            Download CV
                        </a>
                    @else
                        <span class="badge badge-secondary p-1">Belum melengkapi CV</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>KHS</b></td>
                <td>
                    @if($mahasiswa->mahasiswa_khs)
                        <a class="btn btn-outline-success p-1" href="{{ url('storage/mahasiswa_khs/'.$mahasiswa->mahasiswa_khs) }}"> 
                            <i class="fas fa-cloud-download-alt"></i>
                            Download KHS
                        </a>
                    @else
                        <span class="badge badge-secondary p-1">Belum melengkapi KHS</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Skills</b></td>
                <td>
                    @if(count($skills))
                        @foreach($skills as $skill)
                            <span class="badge badge-info p-1">{{ $skill->skill_nama }}</span>
                        @endforeach
                    @else
                        <span class="badge badge-danger p-1">Belum menambahkan skill</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>
    <!-- end info mahasiswa -->
        
    <!-- filter -->
    <h5 class="mb-2 p-0">
        Daftar Lamaran Mahasiswa
    </h5>
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
                        <a class="btn btn-outline-info px-1 py-0 mt-1  edit-form" href="{{ url('dospem/detailpelamar-dospem/'.$rekrut->rekrut_id) }}" title="Undangan">
                            <small>Perekrutan</small>
                        </a>
                        @if($rekrut->rekrut_status=='lulus' || $rekrut->rekrut_status=='finishmhs' || $rekrut->rekrut_status=='finishprs')
                        <a class="btn btn-outline-info px-1 py-0 mt-1 edit-form" href="{{ url('dospem/kegiatan/'.$rekrut->rekrut_id) }}" title="Kegiatan">
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
@endsection