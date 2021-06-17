@extends('layouts.front', ['title' => 'Kegiatan Magang Mahasiswa - MagangHub'])

@section('head')
    
    <!-- SB Admin Template -->
    <link href="{{ asset('styles/sb-admin.css?v=').time() }}" rel="stylesheet">

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
        <li class="breadcrumb-item"><a href="{{ url('perusahaan/detail/'.$rekrut->lowongan_perusahaan_id) }}">Profil Perusahaan</a></li>
        <li class="breadcrumb-item"><a href="{{ url('perekrutan/pelamar/'.$rekrut->lowongan_id) }}">Pelamar</a></li>
        <li class="breadcrumb-item active" aria-current="page">Kegiatan Magang</li>
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

    <!-- begin content -->
    <h5 class="mb-2 p-0">
        Kegiatan Magang Mahasiswa
    </h5>
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-3">
    
        @if(\App\Kegiatan::getCountById($rekrut->rekrut_id)>0 && $rekrut->rekrut_status=='lulus')
            @if(\App\Kegiatan::getCountUnverifById($rekrut->rekrut_id)>0)
            <div class="alert alert-info mb-2">
                Verifikasi semua kegiatan untuk menyelesaikan magang pada mahasiswa ini.
            </div>
            @else
                <input type="button" class="btn btn-outline-primary btn-block text-small mb-2" value="Selesaikan Magang & Beri Nilai" id="btnFinish">
            @endif
        @endif

        @php($firstDate = $filter->month.'-01')
        
        <div class="d-flex justify-content-between mb-2">
            <a class="btn btn-outline-info p-1 float-right" href="{{ url('kegiatan/mentorview/'.$rekrut->rekrut_id).'?filter_month='.date('Y-m', strtotime($firstDate.' -1 month')) }}">
                <small>{{ date('F Y', strtotime($firstDate." -1 month")) }}</small>
            </a>
            <a class="btn btn-outline-info p-1 float-right" href="{{ url('kegiatan/mentorview/'.$rekrut->rekrut_id).'?filter_month='.date('Y-m', strtotime($firstDate.' +1 month')) }}">
                <small>{{ date('F Y', strtotime($firstDate." +1 month")) }}</small>
            </a>
        </div>
        <h5 class="text-center">{{ date('F Y', strtotime($firstDate)) }}</h5>
        <table class="table table-bordered table-responsive table-100" cellspacing="0">
            <thead>
            <tr>
                <th class="bg-info text-white" width="114">Sun</th>
                <th class="bg-info text-white" width="114">Mon</th>
                <th class="bg-info text-white" width="114">Tue</th>
                <th class="bg-info text-white" width="114">Wed</th>
                <th class="bg-info text-white" width="114">Thu</th>
                <th class="bg-info text-white" width="114">Fri</th>
                <th class="bg-info text-white" width="114">Sat</th>
            </tr>
            </thead>
            @php($curYear = substr($filter->month,0,4))
            @php($curMonth = substr($filter->month,5))
            @php($firstDay = date('w',strtotime($firstDate)))
            @php($date=1)
            
            <tbody id="calendar-body">
            @for($i = 0; $i < 6; $i++)
                @if($date > cal_days_in_month(CAL_GREGORIAN,$curMonth,$curYear))
                    @break
                @endif
                <tr>
                @for($j = 0; $j < 7; $j++)
                    @if($i === 0 && $j < $firstDay)
                        <td class="greybox"></td>
                    @elseif($date > cal_days_in_month(CAL_GREGORIAN,$curMonth,$curYear))
                        <td class="greybox"></td>
                    @else
                        <td valign="top">
                            @php($thisDate = $filter->month.'-'.sprintf("%02d", $date))
                            <span class="badge badge-secondary">{{ $date }}</span>
                            @if(date('Y-m-d')==$thisDate)
                                <span class="badge badge-info">hari ini</span>
                            @endif
                            <br />
                            @php($info = \App\Kegiatan::getInfo($rekrut->rekrut_id,$thisDate))

                            @if(!empty($info))
                                @if($info->kegiatan_verify_mentor)
                                    <span class="badge badge-success w-100 mt-1">Terverifikasi</span>
                                @else
                                    <span class="badge badge-warning w-100 mt-1">Belum Verifikasi</span>
                                @endif
                                <a class="btn btn-outline-info p-0 mt-1 btn-block" href="{{ url('kegiatan/detail/'.$rekrut->rekrut_id.'/'.$thisDate) }}">
                                    <small>Kegiatan</small>
                                </a>
                            @endif
                        </td>
                        @php($date++)
                    @endif
                @endfor
                </tr>
            @endfor
            </tbody>
        </table>
    </div>
    <!-- end content -->
    
    @if($rekrut->rekrut_status=='finish')
    <!-- penilaian -->
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-3">
        <div class="py-1">Penilaian</div>
        
        @if($rekrut->rekrut_status=='finish')
            <div class="alert alert-info">
                Magang diselesaikan pada {{ date('d F Y', strtotime($rekrut->rekrut_finish)) }}.<br />
                <br />

                Feedback dari perusahaan:<br />
                    {{ $rekrut->rekrut_feedback }}
            </div>
            
            @if($rekrut->rekrut_ratingto_perusahaan=="")
            <div class="alert alert-warning">
                Menunggu mahasiswa memberikan rating untuk perusahaan.
            </div>
            @endif
        @endif

        <div class="row">
        
            <div class="col-6 mb-3 mr-0">
                <div class="card text-white bg-primary o-hidden h-100 shadow">
                    <div class="card-body p-1">
                        Rating Mahasiswa & Kampus: <b>{{ $rekrut->rekrut_ratingto_mahasiswa }}</b>
                    </div>
                </div>
            </div>

            <div class="col-6 mb-3">
                <div class="card text-white bg-primary o-hidden h-100 shadow">
                    <div class="card-body p-1">
                        Rating Perusahaan: <b>{{ empty($rekrut->rekrut_ratingto_perusahaan) ? "-" : $rekrut->rekrut_ratingto_perusahaan }}</b>
                    </div>
                </div>
            </div>
            
            <div class="col-4 mb-3">
                <div class="card text-white bg-primary o-hidden h-100 shadow">
                    <div class="card-body p-1">
                        Nilai Aspek Kedisiplinan: <b>{{ $rekrut->rekrut_aspek_kedisiplinan }}</b>
                    </div>
                </div>
            </div>
            
            <div class="col-4 mb-3">
                <div class="card text-white bg-primary o-hidden h-100 shadow">
                    <div class="card-body p-1">
                        Nilai Aspek Keterampilan: <b>{{ $rekrut->rekrut_aspek_keterampilan }}</b>
                    </div>
                </div>
            </div>
            
            <div class="col-4 mb-3">
                <div class="card text-white bg-primary o-hidden h-100 shadow">
                    <div class="card-body p-1">
                        Nilai Aspek Sikap/Perilaku: <b>{{ $rekrut->rekrut_aspek_sikap }}</b>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end penilaian -->
    @endif

    <!-- info mahasiswa -->
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-3">
        <div class="py-1">Informasi Mahasiswa Magang</div>
        <table class="table table-sm" cellspacing="0">
            <tr>
                <td class="greybox" width="10"><b>Kampus</b></td>
                <td>
                    <a href="{{ url('kampus/detail/'.$rekrut->univ_id) }}" class="text-dark">{{ $rekrut->univ_nama }}</a>
                    @if(\App\Univ::getIsBanned($rekrut->univ_id))
                        <span class="badge badge-danger"><i class="fas fa-exclamation-triangle"></i> Kampus ini sedang dalam pengawasan</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Dosen Pembimbing</b></td>
                <td>
                    {{ $rekrut->dospem_nama }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>E-Mail Dosen</b></td>
                <td>
                    {{ $rekrut->dospem_user_email }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>NIM</b></td>
                <td>
                    {{ $rekrut->mahasiswa_nim }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Mahasiswa</b></td>
                <td>
                    {{ $rekrut->mahasiswa_nama }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>TTL</b></td>
                <td>
                    {{ $rekrut->mahasiswa_tempat_lahir ? $rekrut->mahasiswa_tempat_lahir : '-' }}, {{ $rekrut->mahasiswa_tgl_lahir ? $rekrut->mahasiswa_tgl_lahir : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Telepon</b></td>
                <td>
                    {{ $rekrut->mahasiswa_no_tlp ? $rekrut->mahasiswa_no_tlp : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Domisili</b></td>
                <td>
                    {{ $rekrut->city_nama ? $rekrut->city_nama : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Alamat</b></td>
                <td>
                    {{ $rekrut->mahasiswa_alamat ? $rekrut->mahasiswa_alamat : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>CV</b></td>
                <td>
                    @if($rekrut->mahasiswa_cv)
                        <a class="btn btn-outline-success p-1" href="{{ url('storage/mahasiswa_cv/'.$rekrut->mahasiswa_cv) }}"> 
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
                    @if($rekrut->mahasiswa_khs)
                        <a class="btn btn-outline-success p-1" href="{{ url('storage/mahasiswa_khs/'.$rekrut->mahasiswa_khs) }}"> 
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
                    @foreach($skills as $skill)
                        <span class="badge badge-info p-1">{{ $skill->skill_nama }}</span>
                    @endforeach
                </td>
            </tr>
        </table>
    </div>
    <!-- end info mahasiswa -->
        
    <!-- info lowongan -->
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-5">
        <div class="py-1">Informasi Pekerjaan</div>
        <table class="table table-sm" cellspacing="0">
            <tr>
                <td class="greybox"><b>Perusahaan</b></td>
                <td>
                    <a href="{{ url('perusahaan/detail/'.$rekrut->perusahaan_id) }}">
                        {{ $rekrut->perusahaan_nama }}
                    </a>
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Judul Lowongan</b></td>
                <td>
                    {{ $rekrut->lowongan_judul }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Fungsi</b></td>
                <td>
                    {{ $rekrut->fungsi_nama }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Kota Penempatan</b></td>
                <td>
                    {{ $rekrut->city_nama }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Mulai Magang</b></td>
                <td>
                    {{ date('d F Y', strtotime($rekrut->lowongan_tgl_mulai)) }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Durasi</b></td>
                <td>
                    {{ $rekrut->lowongan_durasi }}
                </td>
            </tr>
        </table>
        <h5 class="mt-3 p-1 border-bottom">Job Desk</h5>
        {!! $rekrut->lowongan_jobdesk !!}
    </div>
    <!-- end info lowongan -->

<form action="{{ route('kegiatan.finish', ['id' => $rekrut->rekrut_id]) }}" method="post" id="finishform">
@csrf
<!-- Verify Modal -->
<div class="modal fade" id="finishModal">
    <div class="modal-dialog">
    <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
        <h4 class="modal-title">Selesaikan Magang & Beri Nilai</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            Mohon berikan penilaian untuk {{ $rekrut->mahasiswa_nama }} dari 3 aspek berikut:<br />

            Nilai Aspek Kedisiplinan:<br />
            <input class="form-control" placeholder="0-100" name="rekrut_aspek_kedisiplinan" required="required"
                data-parsley-required
                data-parsley-required-message="Masukan nilai aspek kedisiplinan"
                data-parsley-type="integer"
                data-parsley-type-message="Masukan nilai 1-100"
                data-parsley-range="[0, 100]"
                data-parsley-range-message="Masukan nilai 1-100"><br />
                
            Nilai Aspek Keterampilan:<br />
            <input class="form-control" placeholder="0-100" name="rekrut_aspek_keterampilan" required="required"
                data-parsley-required
                data-parsley-required-message="Masukan nilai aspek keterampilan"
                data-parsley-type="integer"
                data-parsley-type-message="Masukan nilai 1-100"
                data-parsley-range="[0, 100]"
                data-parsley-range-message="Masukan nilai 1-100"><br />
                
            Nilai Aspek Sikap/Perilaku:<br />
            <input class="form-control" placeholder="0-100" name="rekrut_aspek_sikap" required="required"
                data-parsley-required
                data-parsley-required-message="Masukan nilai aspek Sikap/Perilaku"
                data-parsley-type="integer"
                data-parsley-type-message="Masukan nilai 1-100"
                data-parsley-range="[0, 100]"
                data-parsley-range-message="Masukan nilai 1-100"><br />
                
            Rating Mahasiswa & Kampus:<br />
            
            <div class="stars">
                <input class="star star-5" id="star-10" type="radio" name="rekrut_ratingto_mahasiswa" value="10"
                    data-parsley-required
                    data-parsley-required-message="Pilih rating untuk mahasiswa & kampus"/>
                <label class="star star-5" for="star-10">10</label>
                <input class="star star-4" id="star-9" type="radio" name="rekrut_ratingto_mahasiswa" value="9"/>
                <label class="star star-4" for="star-9">9</label>
                <input class="star star-4" id="star-8" type="radio" name="rekrut_ratingto_mahasiswa" value="8"/>
                <label class="star star-4" for="star-8">8</label>
                <input class="star star-4" id="star-7" type="radio" name="rekrut_ratingto_mahasiswa" value="7"/>
                <label class="star star-4" for="star-7">7</label>
                <input class="star star-4" id="star-6" type="radio" name="rekrut_ratingto_mahasiswa" value="6"/>
                <label class="star star-4" for="star-6">6</label>
                <input class="star star-4" id="star-5" type="radio" name="rekrut_ratingto_mahasiswa" value="5"/>
                <label class="star star-4" for="star-5">5</label>
                <input class="star star-4" id="star-4" type="radio" name="rekrut_ratingto_mahasiswa" value="4"/>
                <label class="star star-4" for="star-4">4</label>
                <input class="star star-3" id="star-3" type="radio" name="rekrut_ratingto_mahasiswa" value="3"/>
                <label class="star star-3" for="star-3">3</label>
                <input class="star star-2" id="star-2" type="radio" name="rekrut_ratingto_mahasiswa" value="2"/>
                <label class="star star-2" for="star-2">2</label>
                <input class="star star-1" id="star-1" type="radio" name="rekrut_ratingto_mahasiswa" value="1"/>
                <label class="star star-1" for="star-1">1</label>
            </div><br />

            Feedback:<br />
            <textarea class="form-control" placeholder="Feedback" name="rekrut_feedback" required="required"
                data-parsley-required
                data-parsley-required-message="Isi feedback untuk mahasiswa"></textarea>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>

            <input  type="submit" class="btn btn-primary" id="sendsubmit" value="Selesaikan">
        </div>

    </div>
    </div>
</div>
<!-- End Verify Modal -->
</form>
@endsection

@section('bottom')
<!-- SB-Admin-->
<script src="{{ url('js/sb-admin.min.js') }}"></script>

<script>
    $(document).ready(function (){

        $('#btnFinish').click(function(){
            $('#finishModal').modal('show');
        });
    });
</script>

<!-- Parsley Form Validation -->
<script src="{{ url('js/parsley.min.js') }}"></script>
<script>
    $("#finishform").parsley({
        errorClass: 'is-invalid text-danger',
        errorsWrapper: '<span class="form-text text-danger"></span>',
        errorTemplate: '<span></span>',
        trigger: 'change'
    })
</script>

@endsection