<?php
session_start();

include 'config/config.php';
include 'config/database.php';

require_once 'fungsi/fungsi_pengguna.php';

// kalo sudah login redirect ke admin
if (isset($_SESSION['pengguna_id'])) {
    header('Location:'.$config['base_url'].'/admin');
}

$error_text = [];

// periksa kalo ada request untuk register
if (isset($_POST['method']) && $_POST['method'] == 'register') {
    // periksa kalo email dan password tidak kosong
    if (
        isset($_POST['nama']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_confirm']) && isset($_POST['kode_verifikasi_administrator'])
        && $_POST['nama'] != '' && $_POST['email'] != '' && $_POST['password'] != '' && $_POST['password_confirm'] != '' && $_POST['kode_verifikasi_administrator'] != '') {
        if ($_POST['password'] != $_POST['password_confirm']) {
            $error_text[] = 'Ketik Ulang Password harus sama dengan Password';
        }

        // periksa kode verifikasi administrator
        if (empty($error_text)) {
            $kode_verifikasi = md5($_POST['kode_verifikasi_administrator']);
            $stmt = $connectdb->prepare('SELECT * FROM pengguna WHERE email = ?');
            $email = $config['email_admin'];
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $hasil = $stmt->get_result();
            $admin_poldi = $hasil->fetch_object();
            if (! $admin_poldi || ($admin_poldi && $admin_poldi->password != $kode_verifikasi)) {
                $error_text[] = 'Kode Verifikasi Administrator Salah. Silahkan coba lagi!';
            }
        }

        // kalo pengguna ketemu
        if (empty($error_text)) {
            // Periksa pengguna sudah ada
            $stmt = $connectdb->prepare('SELECT * FROM pengguna WHERE email = ?');
            $email = $_POST['email'];
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $hasil = $stmt->get_result();
            $pengguna = $hasil->fetch_object();
            if ($pengguna) {
                $error_text[] = 'Email sudah terdaftar, Silahkan gunakan email yang lain.';
            }
        }

        if (empty($error_text)) {
            $email = $_POST['email'];
            $password = md5($_POST['password']);
            $nama = $_POST['nama'];
            $tgl_dibuat = date('Y-m-d H:i:s');
            $sql = "INSERT INTO pengguna (email, password, nama_lengkap, tgl_dibuat) VALUES ('$email', '$password', '$nama', '$tgl_dibuat')";

            if ($connectdb->query($sql) === true) {
                $pengguna_id = $connectdb->insert_id;
                log_pengguna('Daftar Baru', $pengguna_id);
                $_SESSION['success_text'][] = 'Berhasil membuat akun';
                header('Location:'.$config['base_url']);
                exit();
            } else {
                $error_text[] = 'Data tidak bisa ditambah. Kegagalan sistem. Silahkan Coba lagi!';
            }
        }
    } else {
        if (isset($_POST['nama']) && $_POST['nama'] == '') {
            $error_text[] = 'Nama tidak boleh kosong';
        }

        if (isset($_POST['email']) && $_POST['email'] == '') {
            $error_text[] = 'Email tidak boleh kosong';
        }

        if (isset($_POST['password']) && $_POST['password'] == '') {
            $error_text[] = 'Password tidak boleh kosong';
        }

        if (isset($_POST['password_confirm']) && $_POST['password_confirm'] == '') {
            $error_text[] = 'Ketik Ulang Password tidak boleh kosong';
        } else {
            if ($_POST['password'] !== $_POST['password_confirm']) {
                $error_text[] = 'Ketik Ulang Password harus sama dengan Password';
            }
        }

        if (isset($_POST['kode_verifikasi_administrator']) && $_POST['kode_verifikasi_administrator'] == '') {
            $error_text[] = 'Kode Verifikasi Administrator tidak boleh kosong';
        }

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
  <title>Aplikasi Peminjaman Kunci | Daftar</title>
  <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
  <link rel="icon" href="../favicon.ico" type="image/x-icon">
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
      <p class="login-box-msg">Isi kolom dibawah untuk mendaftar.</p>
      <?php if (!empty($error_text)):?>
          <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h4><i class="icon fa fa-ban"></i> Alert!</h4>
              <?php echo implode('<br>', $error_text); ?>
          </div>
      <?php endif; ?>
    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="nama" name="nama" class="form-control" placeholder="Nama Lengkap" value="<?php echo (isset($_POST['nama'])) ? $_POST['nama'] : ''; ?>" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo (isset($_POST['email'])) ? $_POST['email'] : ''; ?>" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Kata Kunci" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password_confirm" class="form-control" placeholder="Ketik Ulang Kata Kunci" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="kode_verifikasi_administrator" class="form-control" placeholder="Kode Verifikasi Administrator" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Daftar</button>
          <input type="hidden" name="method" value="register" />
        </div>
        <!-- /.col -->
      </div>
    </form>
    <br>
    <a href="index.php" class="text-center">Login</a>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

</body>
</html>
