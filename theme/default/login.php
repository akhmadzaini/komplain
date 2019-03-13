<?php $this->load->view('umum/header') ?>

<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <b>Sisfo Komplain </b>Daring
  </div>
  <?php
  if($this->input->get('msg') == 'login_error'){
    echo '<div class="alert alert-danger">Login gagal, kombinasi ID dan Password tidak dikenali. Silahkan hubungi administrator untuk memeriksa ketersediaan akses</div>';
  }
  if($this->input->get('msg') == 'please_login'){
    echo '<div class="alert alert-warning">Silahkan login dengan akun yang sudah terdaftar.</div>';
  }
  ?>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Login untuk masuk ke sistem</p>

    <form action="<?=site_url('login/proses')?>" method="post">

      <div class="form-group has-feedback">
        <select name="jenis" class="form-control">
          <option value="doskar">Dosen/Karyawan</option>
          <option value="mhs">Mahasiswa</option>
        </select>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="login" placeholder="ID Pengguna">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
        <!-- /.col -->
      <div class="">
        <button type="submit" class="btn btn-primary btn-block btn-flat">Masuk</button>
      </div>

    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?=base_url()?>/theme/default/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url()?>/theme/default/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
