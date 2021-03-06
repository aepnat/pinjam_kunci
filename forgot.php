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

// periksa kalo ada request untuk forgot
if (isset($_POST['method']) && $_POST['method'] == 'forgot') {
    // periksa kalo email dan password tidak kosong
    if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_confirm']) && isset($_POST['kode_verifikasi_administrator'])
    && $_POST['email'] != '' && $_POST['password'] != '' && $_POST['password_confirm'] != '' && $_POST['kode_verifikasi_administrator'] != '') {
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

        if (empty($error_text)) {
            $stmt = $connectdb->prepare('SELECT * FROM pengguna WHERE email = ?');
            $stmt->bind_param('s', $_POST['email']);
            $stmt->execute();
            $hasil = $stmt->get_result();
            $pengguna = $hasil->fetch_object();
            if (!$pengguna) {
                $error_text[] = 'Akun tidak ditemukkan.';
            }
        }

        // kalo pengguna ketemu
        if (empty($error_text)) {
            $pengguna_id = $pengguna->pengguna_id;
            $password = md5($_POST['password']);
            $sql = "UPDATE pengguna SET password='$password' WHERE pengguna_id='$pengguna_id'";

            if ($connectdb->query($sql) === true) {
                log_pengguna('Atur Ulang Password', $pengguna_id);
                $_SESSION['success_text'][] = 'Berhasil merubah password. Silahkan login dengan password baru.';
                header('Location:'.$config['base_url']);
                exit();
            } else {
                $error_text[] = 'Data tidak bisa ditambah. Kegagalan sistem. Silahkan Coba lagi!';
            }
        }
    } else {
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
  <link rel="stylesheet" href="css/style.css">

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
  <!-- /.login-logo -->
  <div class="login-box-body">
      <p class="login-box-msg">Masukkan email dan kata kunci baru untuk melakukan atur ulang password.</p>
      <?php if (!empty($error_text)):?>
          <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h4><i class="icon fa fa-ban"></i> Alert!</h4>
              <?php echo implode('<br>', $error_text); ?>
          </div>
      <?php endif; ?>
      <?php if (isset($_SESSION['success_text'])): ?>
            <?php if (!empty($_SESSION['success_text'])):?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php echo implode('<br>', $_SESSION['success_text']); ?>
            </div>
            <?php endif; ?>
            <?php unset($_SESSION['success_text']); ?>
      <?php endif; ?>
    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo (isset($_POST['email'])) ? $_POST['email'] : ''; ?>" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Kata Kunci Baru" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password_confirm" class="form-control" placeholder="Ketik Ulang Kata Kunci Baru" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="kode_verifikasi_administrator" class="form-control" placeholder="Kode Verifikasi Administrator" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-5">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Atur Ulang Password</button>
          <input type="hidden" name="method" value="forgot" />
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
