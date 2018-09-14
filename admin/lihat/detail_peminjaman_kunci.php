<?php include "../config/config.php";?>
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
                <label for="id_kunci">ID Kunci</label>
                <p>003</p>
              </div>
              <div class="form-group">
                <label for="tujuan">Tujuan</label>
                <p>Jakarta Barat</p>
              </div>
              <div class="form-group">
                <label for="nm_peminjam">Nama Peminjam</label>
                <p>Adi Hermawan</p>
              </div>
              <div class="form-group">
                <label for="no_telp_peminjam">No. Telp Peminjam</label>
                <p>021943110</p>
              </div>
              <div class="form-group">
                <label for="email_peminjam">Email Peminjam</label>
                <p>adi.hermawan@gmail.com</p>
              </div>
              <div class="form-group">
                <label>Jenis ID Peminjam</label>
                <p>KTP</p>
              </div>
              <div class="form-group">
                <label for="no_id">Nomor ID Peminjam</label>
                <p>12398728937487234</p>
              </div>
              <div class="form-group">
                <label>Perusahaan</label>
                <p>PT. Huawei Indonesia</p>
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
