<?php
global $metode;
global $id;

$data = [
    'kode_kunci'       => '',
    'tujuan'           => '',
    'jenis_pekerjaan'  => '',
    'jenis_id'         => '',
    'no_id'            => '',
    'nm_peminjam'      => '',
    'no_telp_peminjam' => '',
    'email_peminjam'   => '',
    'perusahaan_id'    => '',
    'wkt_peminjaman'   => '',
    'wkt_selesai'      => '',
    'dibuat_oleh'      => '',
];

if ($metode == 'edit') {
    $sql = "SELECT * FROM pinjam_kunci WHERE id = $id";
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

// data perusahaan
$sql = 'SELECT * FROM perusahaan';
$data_perusahaan = $connectdb->query($sql);

?>
<div class="row">
    <div class="col-lg-6 col-md-8 col-xs-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Formulir Registrasi Peminjaman Kunci</h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <form action="" method="post">
            <div class="box-body">
                <div class="form-group">
                  <label>Perusahaan</label>
                  <select name="perusahaan_id" class="form-control">
                    <option value="">Pilih Perusahaan</option>
                    <?php if ($data_perusahaan->num_rows > 0): while ($perusahaan = $data_perusahaan->fetch_assoc()):?>
                        <option value="<?php echo $perusahaan['perusahaan_id']; ?>" <?php echo ($data['perusahaan_id'] == $perusahaan['perusahaan_id']) ? 'selected="selected"' : ''; ?>><?php echo $perusahaan['nama'].'( '.$perusahaan['no_telp'].')'; ?></option>
                    <?php endwhile; endif; ?>
                  </select>
                  <br>
                  <div class="callout callout-info">
                      <p>Jika data perusahaan tidak ada. Silahkan tambah data perusahaan di menu Registrasi Perusahaan atau klik <a href="<?php $config['base_url']; ?>/admin?lihat=registrasi_perusahaan">[link ini]</a></p>
                  </div>
                </div>
              <div class="form-group">
                <label for="kode_kunci">ID Kunci</label>
                <input type="text" name="kode_kunci" class="form-control" id="kode_kunci" placeholder="Masukan ID Kunci" value="<?php echo $data['kode_kunci']; ?>">
              </div>
              <div class="form-group">
                <label for="tujuan">Tujuan</label>
                <input type="text" name="tujuan" class="form-control" id="tujuan" placeholder="Masukan Tujuan" value="<?php echo $data['tujuan']; ?>">
              </div>
              <div class="form-group">
                <label>Jenis Pekerjaan</label>
                <select name="jenis_pekerjaan" class="form-control">
                  <option value="">Pilih Jenis Pekerjaan</option>
                  <option value="add_new" <?php echo ($data['jenis_pekerjaan'] == 'add_new') ? 'selected="selected"' : ''; ?>>Add New</option>
                  <option value="maintenance" <?php echo ($data['jenis_pekerjaan'] == 'maintenance') ? 'selected="selected"' : ''; ?>>Maintenance</option>
                  <option value="troubleshoot " <?php echo ($data['jenis_pekerjaan'] == 'troubleshoot') ? 'selected="selected"' : ''; ?>>Troubleshoot</option>
                </select>
              </div>
              <div class="form-group">
                <label>Jenis ID Peminjam</label>
                <select name="jenis_id" class="form-control">
                  <option value="">Pilih Jenis ID</option>
                  <option value="ktp" <?php echo ($data['jenis_id'] == 'ktp') ? 'selected="selected"' : ''; ?>>KTP</option>
                  <option value="sim" <?php echo ($data['jenis_id'] == 'sim') ? 'selected="selected"' : ''; ?>>SIM</option>
                </select>
              </div>
              <div class="form-group">
                <label for="no_id">Nomor ID Peminjam</label>
                <input type="text" name="no_id" class="form-control" id="no_id" placeholder="Masukan Email Peminjam" value="<?php echo $data['no_id']; ?>">
              </div>
              <div class="form-group">
                <label for="nm_peminjam">Nama Peminjam</label>
                <input type="text" name="nm_peminjam" class="form-control" id="nm_peminjam" placeholder="Masukan Nama Peminjam" value="<?php echo $data['nm_peminjam']; ?>">
              </div>
              <div class="form-group">
                <label for="no_telp_peminjam">No. Telp Peminjam</label>
                <input type="text" name="no_telp_peminjam" class="form-control" id="no_telp_peminjam" placeholder="Masukan No. Telepon Peminjam" value="<?php echo $data['no_telp_peminjam']; ?>">
              </div>
              <div class="form-group">
                <label for="email_peminjam">Email Peminjam</label>
                <input type="email" name="email_peminjam" class="form-control" id="email_peminjam" placeholder="Masukan Email Peminjam" value="<?php echo $data['email_peminjam']; ?>">
              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <?php if ($metode == 'edit') :?>
                    <a href="<?php echo $config['base_url']; ?>/admin?lihat=data_peminjaman_kunci" class="btn btn-primary">Kembali</a>
                    <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
                    <input type="hidden" name="metode2" value="<?php echo $metode; ?>" />
                <?php endif; ?>
                <button type="submit" class="btn btn-success">Simpan</button>
                <input type="hidden" name="metode" value="input_peminjaman_kunci" />
            </div>
          </form>
        </div>
        <!-- /.box -->
    </div>
</div>
