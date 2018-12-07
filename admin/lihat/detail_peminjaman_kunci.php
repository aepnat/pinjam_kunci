<?php
global $id;

$sql = "SELECT pinjam_kunci.*, perusahaan.nama as nm_perusahaan, perusahaan.no_telp as no_telp_perusahaan FROM pinjam_kunci JOIN perusahaan ON perusahaan.perusahaan_id=pinjam_kunci.perusahaan_id WHERE id = $id";
$hasil = $connectdb->query($sql);
$data = $hasil->fetch_assoc();
$is_selesai = ($data['wkt_selesai'] != null || $data['wkt_selesai'] != '') ? true : false;
?>
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Detail Registrasi Peminjaman Kunci</h3>
          </div>
          <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <label>Status</label>
                <p><?php echo (!$is_selesai) ? '<span class="label label-warning">Belum</span>' : '<span class="label label-success">Selesai</span>'; ?></p>
              </div>
              <div class="form-group">
                <label>Perusahaan</label>
                <p><?php echo $data['nm_perusahaan'].' ( '.$data['no_telp_perusahaan'].' ) '; ?></p>
              </div>
              <div class="form-group">
                <label for="id_kunci">ID Kunci</label>
                <p><?php echo $data['kode_kunci']; ?></p>
              </div>
              <div class="form-group">
                <label for="tujuan">Tujuan</label>
                <p><?php echo $data['tujuan']; ?></p>
              </div>
              <div class="form-group">
                <label for="nm_peminjam">Nama Peminjam</label>
                <p><?php echo $data['nm_peminjam']; ?></p>
              </div>
              <div class="form-group">
                <label for="no_telp_peminjam">No. Telp Peminjam</label>
                <p><?php echo $data['no_telp_peminjam']; ?></p>
              </div>
              <div class="form-group">
                <label for="email_peminjam">Email Peminjam</label>
                <p><?php echo $data['email_peminjam']; ?></p>
              </div>
              <div class="form-group">
                <label>Jenis ID Peminjam</label>
                <p><?php echo strtoupper($data['jenis_id']); ?></p>
              </div>
              <div class="form-group">
                <label for="no_id">Nomor ID Peminjam</label>
                <p><?php echo $data['no_id']; ?></p>
              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <a class="btn btn-primary" href="<?php echo $config['base_url'];?>/admin?lihat=data_peminjaman_kunci">Kembali ke Data Peminjaman Kunci</a>
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>
