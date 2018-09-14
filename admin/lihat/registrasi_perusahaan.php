<?php
include '../config/config.php';
include '../config/database.php';

?>
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Formulir Registrasi Perusahaan</h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <form method="POST" action="">
            <div class="box-body">
              <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukan Nama Perusahaan" value="<?php echo isset($_POST['nama']) ? $_POST['nama'] : '';?>">
              </div>
              <div class="form-group">
                <label for="no_telp">No. Telepon</label>
                <input type="text" name="no_telp" class="form-control" id="no_telp" placeholder="Masukan Nomor Telepon Perusahaan" value="<?php echo isset($_POST['no_telp']) ? $_POST['no_telp'] : '';?>">
              </div>
              <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" class="form-control" id="alamat" placeholder="Masukan Alamat"><?php echo isset($_POST['alamat']) ? $_POST['alamat'] : '';?></textarea>
              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Simpan</button>
              <input type="hidden" name="metode" value="input_perusahaan" />
            </div>
          </form>
        </div>
        <!-- /.box -->
    </div>
</div>

<?php unset($_SESSION['error_text']);?>
