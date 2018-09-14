<?php

$sql = 'SELECT pengguna_material.*, perusahaan.nama as nm_perusahaan FROM pengguna_material JOIN perusahaan ON perusahaan.perusahaan_id=pengguna_material.perusahaan_id';
$hasil = $connectdb->query($sql);
?>
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Data</h3>

        <div class="box-tools">
          <div class="input-group input-group-sm" style="width: 150px;">
            <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

            <div class="input-group-btn">
              <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
            </div>
          </div>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
          <tr>
            <th>Material</th>
            <th>Kode</th>
            <th>Pengguna</th>
            <th>Perusahaan</th>
            <th>Waktu Ambil</th>
            <th>Aksi</th>
          </tr>
          <?php if ($hasil->num_rows > 0): while($data = $hasil->fetch_assoc()):?>
              <tr>
                <td><?php echo $data['nm_material'];?></td>
                <td><?php echo $data['kode_material'];?></td>
                <td><?php echo $data['nm_pengguna'];?></td>
                <td><?php echo $data['nm_perusahaan'];?></td>
                <td><?php echo waktu_indo($data['tgl_dibuat']);?></td>
                <td>
                    <a class="btn btn-xs btn-primary" href="<?php echo $config['base_url'];?>/admin?lihat=data_penggunaan_material&metode=detail&id=<?php echo $data['id'];?>">Detail</a>
                    <a class="btn btn-xs btn-success" href="<?php echo $config['base_url'];?>/admin?lihat=data_penggunaan_material&metode=edit&id=<?php echo $data['id'];?>">Ubah</a>
                </td>
              </tr>
          <?php endwhile;else:?>
              <tr>
                  <td colspan="6">Data tidak ditemukan</td>
              </tr>
          <?php endif;?>
        </table>
      </div>
      <!-- /.box-body -->
      <div class="box-footer clearfix">
        <ul class="pagination pagination-sm no-margin pull-right">
          <li><a href="#">&laquo;</a></li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">&raquo;</a></li>
        </ul>
      </div>
    </div>
    <!-- /.box -->
  </div>
</div>
