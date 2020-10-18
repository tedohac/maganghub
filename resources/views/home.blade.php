@extends('layouts.app', ['title' => 'MagangHub - Pusat Magang Indonesia'])

@section('content')

  <!-- Header -->
  <header class="py-5 mb-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 col-10 mb-1">
          <img src="{{ url('img/ilustration-1.png') }}" alt="">
        </div>
        <div class="col-md-6">
          <b>MagangHub</b>
          <h3><b>Wadah Magang untuk Mahasiswa Terbaik dan Perusahaan Terbaik</b></h3>
          <p class="lead mb-5 text-secondary text-justify">MagangHub mempertemukan mahasiswa beragam skill yang siap magang, dengan perusahaan penyedia lapangan kerja magang dari berbagai jenis industri.</p>
        </div>
      </div>
    </div>
  </header>
  
  <!-- Services-->
  <section id="services" class="py-5">
      <div class="container">
          <div class="text-center">
              <h3 class="text-uppercase mb-0">Proses Magang Digital</h3>
              <p>Semua proses administrasi magang dilakukan secara digital</p>
          </div>
          <div class="row text-center">
              <div class="col-md-6">
                  <span class="fa-stack fa-3x">
                      <i class="fas fa-circle fa-stack-2x text-info"></i>
                      <i class="fas fa-user-check fa-stack-1x fa-inverse"></i>
                  </span>
                  <h4>Perekrutan</h4>
                  <p class="text-muted px-5">Mahasiswa cukup klik pada lowongan terbaik. Perekrut dapat meninjau portofolio pelamar, memilih pelamar untuk interview, dan memilih kandidat terbaik untuk mulai magang. Semuanya dilakukan di MagangHub.</p>
              </div>
              <div class="col-md-6">
                  <span class="fa-stack fa-3x">
                      <i class="fas fa-circle fa-stack-2x text-info"></i>
                      <i class="fas fa-file-pdf fa-stack-1x fa-inverse"></i>
                  </span>
                  <h4>Laporan Kegiatan</h4>
                  <p class="text-muted px-5">Mahasiswa dapat menulis laporan kegiatan harian magang dan penilaian oleh mentor magang. Semuanya dilakukan di MagangHub.</p>
              </div>
          </div>
      </div>
  </section>

  <!-- Kampus -->
  <section id="kampus" class="py-5 bg-abu" >
      <div class="container">
          <div class="text-center">
              <h3 class="text-uppercase mb-0">BUTUH TENAGA MAGANG?</h3>
              <p>Banyak mahasiswa dari kampus terbaik sedang menunggu lowongan magang dari perusahaan anda.</p>
          </div>
          <div class="row justify-content-around">
            <div class="col-md-2 col-sm-3 mb-2"><center><img src="{{ url('img/logo-ui.png') }}"></center></div>
            <div class="col-md-2 col-sm-3 mb-2"><center><img src="{{ url('img/logo-itb.png') }}"></center></div>
            <div class="col-md-2 col-sm-3 mb-2"><center><img src="{{ url('img/logo-ugm.png') }}"></center></div>
            <div class="col-md-2 col-sm-3 mb-2"><center><img src="{{ url('img/logo-umb.png') }}"></center></div>
            <div class="col-md-2 col-sm-3 mb-2"><center><img src="{{ url('img/logo-polman.png') }}"></center></div>
          </div>
          <div class="text-center">
            <a class="btn btn-info px-1 py-1 mt-2" href="#">Daftarkan lowongan anda sekarang</a>
          </div>
      </div>
  </section>

  <!-- Perusahaan -->
  <section id="kampus" class="py-5 bg-white" >
      <div class="container">
          <div class="text-center">
              <h3 class="text-uppercase mb-0">BUTUH LOWONGAN MAGANG?</h3>
              <p>Hubungi admin kampus anda untuk mendaftarkan kampus ke MagangHub. Banyak lowongan dari perusahaan terbaik membutuhkan tenaga magang.</p>
          </div>
          <div class="row justify-content-around">
            <div class="col-md-3 col-sm-6 mb-2"><center><img src="{{ url('img/logo-astra.png') }}"></center></div>
            <div class="col-md-3 col-sm-6 mb-2"><center><img src="{{ url('img/logo-telkom.png') }}"></center></div>
            <div class="col-md-3 col-sm-6 mb-2"><center><img src="{{ url('img/logo-adaro.png') }}"></center></div>
            <div class="col-md-3 col-sm-6 mb-2"><center><img src="{{ url('img/logo-icbp.png') }}"></center></div>
          </div>
          <div class="text-center">
            <a class="btn btn-info px-1 py-1 mt-2" href="{{ url('registkampus') }}">Anda admin kampus? Daftarkan kampus anda sekarang</a>
          </div>
      </div>
  </section>

@endsection