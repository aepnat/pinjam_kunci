<?php
global $metode;
global $id;

$data = [
    'perusahaan_id'    => '',
    'id_material'      => '',
    'jenis_id'         => '',
    'no_id'            => '',
    'nm_pengguna'      => '',
    'no_telp_pengguna' => '',
    'email_pengguna'   => '',
];

if ($metode == 'edit') {
    $sql = "SELECT * FROM pengguna_material WHERE id = $id";
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

// data material
$sql = 'SELECT * FROM material';
$data_material = $connectdb->query($sql);

?>
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Formulir Registrasi Penggunaan Material</h3>
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
                <label>Material</label>
                <select name="id_material" class="form-control">
                  <option value="">Pilih Material</option>
                  <?php if ($data_material->num_rows > 0): while ($material = $data_material->fetch_assoc()):?>
                      <option value="<?php echo $material['id']; ?>" <?php echo ($data['id_material'] == $material['id']) ? 'selected="selected"' : ''; ?>><?php printf('%s - %s', $material['kode_material'], $material['nm_material']); ?></option>
                  <?php endwhile; endif; ?>
                </select>
                <br>
                <div class="callout callout-info">
                    <p>Jika data material tidak ada. Silahkan tambah data material di menu Registrasi Material atau klik <a href="<?php $config['base_url']; ?>/admin?lihat=registrasi_material">[link ini]</a></p>
                </div>
              </div>
              <div class="form-group">
                <label>Jenis ID</label>
                <select name="jenis_id" class="form-control">
                  <option value="">Pilih Jenis ID</option>
                  <option value="ktp" <?php echo ($data['jenis_id'] == 'ktp') ? 'selected="selected"' : ''; ?>>KTP</option>
                  <option value="sim" <?php echo ($data['jenis_id'] == 'sim') ? 'selected="selected"' : ''; ?>>SIM</option>
                </select>
              </div>
              <div class="form-group">
                <label for="no_id">Nomor ID Pengguna</label>
                <input type="text" name="no_id" class="form-control" id="no_id" placeholder="Masukan Nomor ID Pengguna" value="<?php echo $data['no_id']; ?>">
              </div>
              <div class="form-group">
                <label for="nm_pengguna">Nama Pengguna</label>
                <input type="text" name="nm_pengguna" class="form-control" id="nm_pengguna" placeholder="Masukan Nama Pengguna" value="<?php echo $data['nm_pengguna']; ?>">
              </div>
              <div class="form-group">
                <label for="no_telp_pengguna">No. Telp Pengguna</label>
                <input type="text" name="no_telp_pengguna" class="form-control" id="no_telp_pengguna" placeholder="Masukan No. Telp Pengguna" value="<?php echo $data['no_telp_pengguna']; ?>">
              </div>
              <div class="form-group">
                <label for="email_pengguna">Email Pengguna</label>
                <input type="text" name="email_pengguna" class="form-control" id="email_pengguna" placeholder="Masukan Email Pengguna" value="<?php echo $data['email_pengguna']; ?>">
              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <?php if ($metode == 'edit') :?>
                    <a href="<?php echo $config['base_url']; ?>/admin?lihat=data_penggunaan_material" class="btn btn-primary">Kembali</a>
                    <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
                    <input type="hidden" name="metode2" value="<?php echo $metode; ?>" />
                <?php endif; ?>
                <button type="submit" class="btn btn-success">Simpan</button>
                <input type="hidden" name="metode" value="input_penggunaan_material" />
            </div>
          </form>
        </div>
        <!-- /.box -->
    </div>
</div>
