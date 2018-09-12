<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Formulir Registrasi Penggunaan Material</h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <form role="form">
            <div class="box-body">
              <div class="form-group">
                <label for="nm_material">Nama Material</label>
                <input type="text" name="nm_material" class="form-control" id="nm_material" placeholder="Masukan Nama Material">
              </div>
              <div class="form-group">
                <label for="kode_material">Kode Material</label>
                <input type="text" name="kode_material" class="form-control" id="kode_material" placeholder="Masukan Kode Material">
              </div>
              <div class="form-group">
                <label for="nm_pengguna">Nama Pengguna</label>
                <input type="text" name="nm_pengguna" class="form-control" id="nm_pengguna" placeholder="Masukan Nama Pengguna">
              </div>
              <div class="form-group">
                <label for="no_telp">No. Telp Pengguna</label>
                <input type="text" name="no_telp" class="form-control" id="no_telp" placeholder="Masukan No. Telp Pengguna">
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
                <label for="no_id">Nomor ID Pengguna</label>
                <input type="text" name="no_id" class="form-control" id="no_id" placeholder="Masukan Nomor ID Pengguna">
              </div>
              <div class="form-group">
                <label>Perusahaan</label>
                <select name="perusahaan_id" class="form-control">
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
