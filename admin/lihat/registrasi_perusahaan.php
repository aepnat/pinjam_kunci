<?php
global $metode;
global $id;

$data = array(
    'nama' => '',
    'no_telp' => '',
    'alamat' => ''
);

if ($metode == 'edit') {
    $sql = "SELECT * FROM perusahaan WHERE perusahaan_id = $id";
    $hasil = $connectdb->query($sql);
    $datadb = $hasil->fetch_assoc();
    $data = array_merge($data, $datadb);
}

// periksa post header
if (isset($_POST)) {
    foreach ($data as $k => $v) {
        if (array_key_exists($k, $_POST) && $_POST[$k] != '') {
            $data[$k] = $_POST[$k];
        }
    }
}
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
                <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukan Nama Perusahaan" value="<?php echo $data['nama'];?>">
              </div>
              <div class="form-group">
                <label for="no_telp">No. Telepon</label>
                <input type="text" name="no_telp" class="form-control" id="no_telp" placeholder="Masukan Nomor Telepon Perusahaan" value="<?php echo $data['no_telp'];?>">
              </div>
              <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" class="form-control" id="alamat" placeholder="Masukan Alamat"><?php echo $data['alamat'];?></textarea>
              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <?php if ($metode == 'edit') :?>
                    <a href="<?php echo $config['base_url'];?>/admin?lihat=data_perusahaan" class="btn btn-primary">Kembali</a>
                    <input type="hidden" name="id" value="<?php echo $data['perusahaan_id'];?>" />
                    <input type="hidden" name="metode2" value="<?php echo $metode;?>" />
                <?php endif;?>
                <button type="submit" class="btn btn-success">Simpan</button>
                <input type="hidden" name="metode" value="input_perusahaan" />
            </div>
          </form>
        </div>
        <!-- /.box -->
    </div>
</div>

<?php unset($_SESSION['error_text']);?>
