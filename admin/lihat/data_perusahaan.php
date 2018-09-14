<?php

// Total Peminjam Kunci
$sql = 'SELECT * FROM perusahaan';

if (isset($_POST['metode']) && $_POST['metode'] == 'cari') {
    $q = $_POST['q'];
    $sql .= " WHERE nama LIKE '%$q%'";
}

$hasil = $connectdb->query($sql);
?>
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Data</h3>

        <div class="box-tools">
            <form action="" method="post">
            <div class="input-group input-group-sm" style="width: 150px;">
            <input type="text" name="q" class="form-control pull-right" value="<?php echo isset($_POST['q']) ? $_POST['q'] : '';?>" placeholder="Cari">

            <div class="input-group-btn">
              <input type="hidden" name="lihat" value="data_perusahaan" />
              <input type="hidden" name="metode" value="cari" />
              <input type="submit" class="btn btn-default"><i class="fa fa-search"></i></input>
            </div>
          </div>
          </form>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
          <tr>
            <th>Nama</th>
            <th>No. Telepon</th>
            <th>Alamat</th>
            <th>Aksi</th>
          </tr>
          <?php if ($hasil->num_rows > 0): while($data = $hasil->fetch_assoc()):?>
              <tr>
                <td><?php echo $data['nama'];?></td>
                <td><?php echo $data['no_telp'];?></td>
                <td><?php echo $data['alamat'];?></td>
                <td>
                    <a class="btn btn-xs btn-success" href="<?php echo $config['base_url'];?>/admin?lihat=data_perusahaan&metode=edit&id=<?php echo $data['perusahaan_id'];?>">Edit</a>
                </td>
              </tr>
          <?php endwhile; else:?>
              <tr>
                  <td colspan="4">Data tidak ditemukan</td>
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
