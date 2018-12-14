<?php
global $id;

$sql = "SELECT pengguna_material.*, perusahaan.nama as nm_perusahaan, perusahaan.no_telp as no_telp_perusahaan, material.nm_material, material.kode_material  
        FROM pengguna_material 
        JOIN perusahaan ON perusahaan.perusahaan_id=pengguna_material.perusahaan_id 
        JOIN material ON material.id=pengguna_material.id_material
        WHERE pengguna_material.id = $id";
$hasil = $connectdb->query($sql);
$data = ($hasil) ? $hasil->fetch_assoc() : array();

if (empty($data)) {
  // message
  $_SESSION['error_text'][] = 'Data penggunaan material tidak ditemukkan';
  ?>
  <script type="text/javascript">
    window.history.go(-1);
  </script>
  <?php
  exit();  
}
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
          <form action="" method="post">
            <div class="box-body">
              <div class="form-group">
                <label>Perusahaan</label>
                <p><?php echo $data['nm_perusahaan']; ?></p>
              </div>
              <div class="form-group">
                <label for="nm_material">Nama Material</label>
                <p><?php echo $data['nm_material']; ?></p>
              </div>
              <div class="form-group">
                <label for="kode_material">Kode Material</label>
                <p><?php echo $data['kode_material']; ?></p>
              </div>
              <div class="form-group">
                <label>Jenis ID</label>
                <p><?php echo strtoupper($data['jenis_id']); ?></p>
              </div>
              <div class="form-group">
                <label for="no_id">Nomor ID Pengguna</label>
                <p><?php echo $data['no_id']; ?></p>
              </div>
              <div class="form-group">
                <label for="nm_pengguna">Nama Pengguna</label>
                <p><?php echo $data['nm_pengguna']; ?></p>
              </div>
              <div class="form-group">
                <label for="no_telp_pengguna">No. Telp Pengguna</label>
                <p><?php echo $data['no_telp_pengguna']; ?></p>
              </div>
              <div class="form-group">
                <label for="email_pengguna">Email Pengguna</label>
                <p><?php echo $data['email_pengguna']; ?></p>
              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <a class="btn btn-primary" href="<?php echo $config['base_url']; ?>/admin?lihat=data_penggunaan_material">Kembali ke Data Penggunaan Material</a>
            </div>
          </form>
        </div>
        <!-- /.box -->
    </div>
</div>
