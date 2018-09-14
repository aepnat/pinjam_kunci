<?php
global $id;

$sql = "SELECT * FROM perusahaan WHERE perusahaan_id = $id";
$hasil = $connectdb->query($sql);
$data = $hasil->fetch_assoc();
?>
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Detail</h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <form method="POST" action="">
            <div class="box-body">
              <div class="form-group">
                <label for="nama">Nama</label>
                <p><?php echo $data['nama'];?></p>
              </div>
              <div class="form-group">
                <label for="no_telp">No. Telepon</label>
                <p><?php echo $data['no_telp'];?></p>
              </div>
              <div class="form-group">
                <label for="alamat">Alamat</label>
                <p><?php echo $data['alamat'];?></p>
              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <a href="<?php echo $config['base_url'];?>/admin?lihat=data_perusahaan" class="btn btn-primary">Kembali</a>
            </div>
          </form>
        </div>
        <!-- /.box -->
    </div>
</div>

<?php unset($_SESSION['error_text']);?>
