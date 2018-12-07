<?php
global $metode;
global $id;

$data = array(
    'kode_material' => '',
    'nm_material' => ''
);

if ($metode == 'edit') {
    $sql = "SELECT * FROM material WHERE id = $id";
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
            <h3 class="box-title">Formulir Registrasi Material</h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <form method="POST" action="">
            <div class="box-body">
              <div class="form-group">
                <label for="kode_material">Kode Material</label>
                <input type="text" name="kode_material" class="form-control" id="kode_material" placeholder="Masukan Kode Material" value="<?php echo $data['kode_material'];?>">
              </div>
              <div class="form-group">
                <label for="nm_material">Nama Material</label>
                <input type="text" name="nm_material" class="form-control" id="nm_material" placeholder="Masukan Nama Material" value="<?php echo $data['nm_material'];?>">
              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <?php if ($metode == 'edit') :?>
                    <a href="<?php echo $config['base_url'];?>/admin?lihat=data_material" class="btn btn-primary">Kembali</a>
                    <input type="hidden" name="id" value="<?php echo $data['id'];?>" />
                    <input type="hidden" name="metode2" value="<?php echo $metode;?>" />
                <?php endif;?>
                <button type="submit" class="btn btn-success">Simpan</button>
                <input type="hidden" name="metode" value="input_material" />
            </div>
          </form>
        </div>
        <!-- /.box -->
    </div>
</div>

<?php unset($_SESSION['error_text']);?>
