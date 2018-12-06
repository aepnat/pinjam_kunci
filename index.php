<?php
session_start();

include "config/config.php";
include "config/database.php";

require_once('fungsi/fungsi_pengguna.php');

// kalo sudah login redirect ke admin
if (isset($_SESSION['pengguna_id'])) {
    header('Location:' . $config['base_url'] . '/admin');
}

$error_text = array();

// periksa kalo ada request untuk login
if (isset($_POST['method']) && $_POST['method'] == 'login') {
    // periksa kalo email dan password tidak kosong
    if (isset($_POST['email']) && isset($_POST['password']) && $_POST['email'] != '' && $_POST['password'] != '') {
        $stmt = $connectdb->prepare("SELECT * FROM pengguna WHERE email = ? AND password = ?");
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();
        $hasil = $stmt->get_result();
        $pengguna = $hasil->fetch_object();

        // kalo pengguna ketemu
        if ($pengguna) {
            // simpan session semua data pengguna
            foreach ($pengguna as $k => $v) {
                $_SESSION[$k] = $v;
            }

            log_pengguna('Login ke Aplikasi');

            // redirect ke admin
            header('Location:' . $config['base_url'] . '/admin');
        } else {
            $error_text[] = 'Email atau Password salah.';
        }
    } else {
        $error_text[] = 'Email dan Password tidak boleh kosong';
    }
}

if (isset($_SESSION['error_text'])) {
    $error_text = array_merge($error_text, $_SESSION['error_text']);
    unset($_SESSION['error_text']);
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Aplikasi Peminjaman Kunci | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="index.php"><b>Aplikasi</b> Peminjaman Kunci</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
      <p class="login-box-msg">Masukkan email dan kata kunci untuk masuk.</p>
      <?php if (!empty($error_text)):?>
          <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h4><i class="icon fa fa-ban"></i> Alert!</h4>
              <?php echo implode('<br>', $error_text);?>
          </div>
      <?php endif;?>
      <?php if (isset($_SESSION['success_text'])): ?>
            <?php if(!empty($_SESSION['success_text'])):?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php echo implode('<br>', $_SESSION['success_text']);?>
            </div>
            <?php endif;?>
            <?php unset($_SESSION['success_text']);?>
      <?php endif;?>
    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="email" name="email" class="form-control" placeholder="Email" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Kata Kunci" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Masuk</button>
          <input type="hidden" name="method" value="login" />
        </div>
        <!-- /.col -->
      </div>
    </form>
    <br>
    <a href="forgot.php" class="text-center">Lupa Password</a>
    <br>
    <a href="register.php" class="text-center">Daftar baru</a>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

</body>
</html>
