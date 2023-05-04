<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>siTepat - Aplikasi Test Paling Aman Terpercaya</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('adminv') }}/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('adminv') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('adminv') }}/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <img src="https://www.smksangkuriang1cimahi.sch.id/storage/app/public/imgweb/logo.png" width="100px">
      <div>Aplikasi Surat Kelulusan</div>
      <div class="mb-2"><i>by Indra Batara, S.Pd</i></div>
      
      <div id="timer"></div>
    </div>
    <div class="card-body">
        @if (session('status'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
            {{ session('status') }}
          </div>
    @endif
        @if (session('gagal'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-times"></i> Warning!</h5>
            {{ session('gagal') }}
          </div>
    @endif

      <form action="{{ route('sklproses') }}" method="post">
        @csrf
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Masukan NIS" name="nis" {{strtotime(now()) <= strtotime('2023-05-05 08:00:00') ? 'disabled' : '' }}>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Masukan Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row justify-content-center">

          <!-- /.col -->
          
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Cek Kelulusan</button>
          </div>
          </form>
        
          <!-- /.col -->
        </div>


    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('adminv') }}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('adminv') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminv') }}/dist/js/adminlte.min.js"></script>
<script>
    // Mengatur waktu akhir countdown (dalam detik)
    var examStartTime = new Date("{{ strtotime('2023-05-05 08:00:00') }}" * 1000);
    var countDownDate = new Date(examStartTime.getTime());

// Memperbarui hitungan mundur setiap 1 detik
var x = setInterval(function() {

  // Mendapatkan waktu saat ini
  var now = new Date().getTime()
  // Menghitung selisih waktu antara waktu akhir dan waktu saat ini
  var distance = countDownDate - now;
  // Menghitung waktu dalam format menit dan detik
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Menampilkan waktu dalam elemen HTML yang ditentukan
  document.getElementById("timer").innerHTML = "<h1>"+hours + ":" + minutes + ":" + seconds+"</h1>";
    
  // Jika waktu hitung mundur berakhir, tampilkan pesan
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("timer").innerHTML = "Jika NIS belum bisa di isi silakan reload";
  }
}, 1000);

</script>
</body>
</html>
