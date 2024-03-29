@extends('layouts.front', ['title' => $univ->univ_nama.' - MagangHub'])

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
        @if(empty($univ->univ_profile_pict))
        <i class="fas fa-university bg-white border p-2 shadow-sm" style="font-size: 130px"></i>
        @else
        <img src="{{ url('storage/univ/'.$univ->univ_profile_pict) }}" class="bg-white border p-2 shadow">
        @endif
    </div>
    <div class="profile-text col-lg-9 col-md-8 p-md-0 mb-2">
        <h3 class="m-0">{{ $univ->univ_nama }}</h3>
        @if(\App\Univ::getIsVerified($univ->univ_id))
            <small><i class="fas fa-check"></i> Terverifikasi</small>
        @elseif(\App\Univ::getIsBanned($univ->univ_id))
            <span class="badge badge-danger"><i class="fas fa-exclamation-triangle"></i> Kampus ini sedang dalam pengawasan</span>
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
        <li class="breadcrumb-item active" aria-current="page">Detail Kampus</li>
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

    <!-- detail info -->
    <h5 class="mb-2 p-0">
        Profil Kampus
        
        @if(Auth::check() && Auth::user()->user_email == $univ->univ_user_email)
        <a class="btn btn-outline-info p-1 float-right" href="{{ route('kampus.edit') }}">
            <small><i class="fas fa-edit"></i> Edit Detail Kampus</small>
        </a>
        @endif
    </h5>
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-5">
        <table class="table" cellspacing="0">
            <tr>
                <td class="greybox" width="100"><b>Akreditasi</b></td>
                <td>
                    <span class="font-20 fa fa-star {{ $univ->univ_akreditasi!='' && ord($univ->univ_akreditasi)-96<6 ? 'text-warning' : '' }}"></span>
                    <span class="font-20 fa fa-star {{ $univ->univ_akreditasi!='' && ord($univ->univ_akreditasi)-96<5 ? 'text-warning' : '' }}"></span>
                    <span class="font-20 fa fa-star {{ $univ->univ_akreditasi!='' && ord($univ->univ_akreditasi)-96<4 ? 'text-warning' : '' }}"></span>
                    <span class="font-20 fa fa-star {{ $univ->univ_akreditasi!='' && ord($univ->univ_akreditasi)-96<3 ? 'text-warning' : '' }}"></span>
                    <span class="font-20 fa fa-star {{ $univ->univ_akreditasi!='' && ord($univ->univ_akreditasi)-96<2 ? 'text-warning' : '' }}"></span>
                    <span class="font-20">({{ strtoupper($univ->univ_akreditasi) }})</span>
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>NPSN</b></td>
                <td>
                    {{ $univ->univ_npsn ? $univ->univ_npsn : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Tanggal Berdiri</b></td>
                <td>
                    {{ $univ->univ_tgl_berdiri ? $univ->univ_tgl_berdiri : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Telepon</b></td>
                <td>
                    {{ $univ->univ_no_tlp ? $univ->univ_no_tlp : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Website</b></td>
                <td>
                    <a href="{{ $univ->univ_website ? $univ->univ_website : '#' }}">{{ $univ->univ_website ? $univ->univ_website : '-' }}</a>
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Alamat</b></td>
                <td>
                    {{ $univ->univ_alamat ? $univ->univ_alamat : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Kota</b></td>
                <td>
                    {{ $univ->city_nama ? $univ->city_nama : '-' }}
                </td>
            </tr>
        </table>
    </div>

    <!-- prodi list -->
    <h5 class="mb-2 p-0">
        Program Studi
        
        @if(Auth::check() && Auth::user()->user_email == $univ->univ_user_email)
        <a class="btn btn-outline-info p-1 float-right" href="{{ route('prodi.manage') }}">
            <small><i class="fas fa-edit"></i> Kelola Program Studi</small>
        </a>
        @endif
    </h5>
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-5">
        
        <table class="table table-sm table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead class="greybox">
                <tr>
                    <th>#</th>
                    <th>Program Studi</th>
                    <th>Fakultas</th>
                    <th>Jenjang</th>
                    <th>Akreditasi</th>
                    <th>Pencari Magang</th>
                </tr>
            </thead>
            <tbody>
            @php ($num = 1)
            @foreach($prodis as $prodi)
                <tr>
                    <td>{{ $num }}</td>
                    <td>{{ $prodi->prodi_nama }}</td>
                    <td>{{ $prodi->prodi_fakultas!='' ? $prodi->prodi_fakultas : '-' }}</td>
                    <td>{{ $prodi->prodi_jenjang }}</td>
                    <td>{{ strtoupper($prodi->prodi_akreditasi) }}</td>
                    <td>
                        {{ \App\Mahasiswa::getCountPencariMagang($prodi->prodi_id) }}

                        @if(Auth::check() && Auth::user()->user_role=='perusahaan' && \App\Mahasiswa::getCountPencariMagang($prodi->prodi_id)>0)
                        <a class="btn btn-outline-info p-0 px-1 float-right broadcast-form" href="#" data-id="{{ $prodi->prodi_id }}">
                            <small>Broadcast Lowongan</small>
                        </a>
                        @endif
                    </td>
                </tr>
                @php ($num++)
            @endforeach
            </tbody>
        </table>

    </div>
    <!-- end prodi list -->
    
<form method="post" id="formbroadcast" action="{{ route('lowongan.broadcast') }}">
@csrf
    <!-- Broadcast Modal -->
    <div class="modal fade" id="broadcastModal">
        <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Broadcast Lowongan</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <p id="modal-message"></p>
                Silahkan pilih lowongan yang akan dilakukan broadcast:
                
                <input type="hidden" name="prodi_id" id="idProdi">
                <select id="selectLowongan" class="form-control selectLowongan" name="lowongan_id"
                    data-parsley-required
                    data-parsley-required-message="Pilih Lowongan">
                </select>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>

            <input  type="submit" class="btn btn-primary" id="sendsubmit" value="Kirim">
            </div>

        </div>
        </div>
    </div>
    <!-- End Broadcast Modal -->

</form>
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
        
        $('#dataTable').on('click', '.broadcast-form', function(){
            var id =  $(this).data('id');
            console.log(id);
            
            $.ajax({
                type: 'GET',
                url: '{{ url("prodi/detailjson") }}?id='+id,
                success: function(data)
                {
                    var result = JSON.parse(data);
                    // console.log(result);

                    $('#submitDelete').attr('href', '{{ route("lowongan.broadcast") }}?prodi_id='+id);
                    $('#idProdi').val(id);
                    $('#modal-message').html('Anda akan mengirim broadcast lowongan ke seluruh mahasiswa <b>'+ result.univ_nama +'</b> prodi <b>'+ result.prodi_nama +'</b> yang sedang melakukan pencarian magang.');
                    $('#broadcastModal').modal('show');
                },
                error:function() {
                    alert("Error!");
                }
            });
        });

    });
</script>

<!-- Auto Complete-->
<script src="{{ url('js/select2.min.js') }}"></script>
<script type="text/javascript">
    $('.selectLowongan').select2({
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
</script>

<!-- Parsley Form Validation -->
<script src="{{ url('js/parsley.min.js') }}"></script>
<script>
    $("#formbroadcast").parsley({
        errorClass: 'is-invalid text-danger',
        errorsWrapper: '<span class="form-text text-danger"></span>',
        errorTemplate: '<span></span>',
        trigger: 'change'
    })
</script>
@endsection