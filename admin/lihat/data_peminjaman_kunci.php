<?php

$sql = 'SELECT pinjam_kunci.*, perusahaan.nama as nm_perusahaan FROM pinjam_kunci JOIN perusahaan ON perusahaan.perusahaan_id=pinjam_kunci.perusahaan_id';
$hasil = $connectdb->query($sql);
?>

<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Data</h3>

        <!-- <div class="box-tools">
          <div class="input-group input-group-sm" style="width: 150px;">
            <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

            <div class="input-group-btn">
              <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
            </div>
          </div>
        </div> -->
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <tr>
              <th>ID Kunci</th>
              <th>Tujuan</th>
              <th>Peminjam</th>
              <th>Perusahaan</th>
              <th>Waktu Pinjam</th>
              <th>Waktu Selesai</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          <?php if ($hasil->num_rows > 0): while($data = $hasil->fetch_assoc()):?>
              <tr>
                <td><?php echo $data['kode_kunci'];?></td>
                <td><?php echo $data['tujuan'];?></td>
                <td><?php echo $data['nm_peminjam'];?></td>
                <td><?php echo $data['nm_perusahaan'];?></td>
                <td><?php echo waktu_indo($data['wkt_peminjaman']);?></td>
                <td><?php echo ($data['wkt_selesai'] == null) ? '-' : waktu_indo($data['wkt_selesai']);?></td>
                <td><?php echo ($data['wkt_selesai'] == null) ? '<span class="label label-warning">Belum</span>' : '<span class="label label-success">Selesai</span>';?></td>
                <td>
                    <a class="btn btn-xs btn-primary" href="<?php echo $config['base_url'];?>/admin?lihat=data_peminjaman_kunci&metode=detail&id=<?php echo $data['id'];?>">Detail</a>
                    <a class="btn btn-xs btn-success" href="<?php echo $config['base_url'];?>/admin?lihat=data_peminjaman_kunci&metode=edit&id=<?php echo $data['id'];?>">Ubah</a>
                </td>
              </tr>
          <?php endwhile;else:?>
              <tr>
                  <td colspan="8">Data tidak ditemukan</td>
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
