<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Formulir Registrasi Peminjaman Kunci</h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <form role="form">
            <div class="box-body">
              <div class="form-group">
                <label for="id_kunci">ID Kunci</label>
                <input type="text" name="id_kunci" class="form-control" id="id_kunci" placeholder="Masukan ID Kunci">
              </div>
              <div class="form-group">
                <label for="tujuan">Tujuan</label>
                <input type="text" name="tujuan" class="form-control" id="tujuan" placeholder="Masukan Tujuan">
              </div>
              <div class="form-group">
                <label for="nm_peminjam">Nama Peminjam</label>
                <input type="text" name="nm_peminjam" class="form-control" id="nm_peminjam" placeholder="Masukan Nama Peminjam">
              </div>
              <div class="form-group">
                <label for="no_telp_peminjam">No. Telp Peminjam</label>
                <input type="text" name="no_telp_peminjam" class="form-control" id="no_telp_peminjam" placeholder="Masukan No. Telepon Peminjam">
              </div>
              <div class="form-group">
                <label for="email_peminjam">Email Peminjam</label>
                <input type="text" name="email_peminjam" class="form-control" id="email_peminjam" placeholder="Masukan Email Peminjam">
              </div>
              <div class="form-group">
                <label>Jenis ID</label>
                <select name="jenis_id" class="form-control">
                  <option value="">Pilih Jenis ID</option>
                  <option value="ktp">KTP</option>
                  <option value="sim">SIM</option>
                </select>
              </div>
              <div class="form-group">
                <label>Perusahaan</label>
                <select name="id_perusahaan" class="form-control">
                  <option value="">Pilih Perusahaan</option>
                  <option value="1">PT. Huawei Indonesia</option>
                </select>
              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
        <!-- /.box -->
    </div>
</div>
