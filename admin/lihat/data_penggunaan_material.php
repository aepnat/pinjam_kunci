<?php
require_once '../fungsi/paginator.class.php';

$query = 'SELECT pengguna_material.*, perusahaan.nama as nm_perusahaan, material.nm_material, material.kode_material FROM pengguna_material 
JOIN perusahaan ON perusahaan.perusahaan_id=pengguna_material.perusahaan_id
JOIN material ON material.id=pengguna_material.id_material';

$limit = (isset($_GET['limit'])) ? $_GET['limit'] : 20;
$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
$links = (isset($_GET['links'])) ? $_GET['links'] : 7;

$base_url = $config['base_url'].'/admin?lihat='.$_GET['lihat'];

$Paginator = new Paginator($connectdb, $query, $base_url);

$results = $Paginator->getData($limit, $page);
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
          <?php if (!empty($results->data)): foreach ($results->data as $data):?>
              <tr>
                <td><?php echo $data['nm_material']; ?></td>
                <td><?php echo $data['kode_material']; ?></td>
                <td><?php echo $data['nm_pengguna']; ?></td>
                <td><?php echo $data['nm_perusahaan']; ?></td>
                <td><?php echo waktu_indo($data['tgl_dibuat']); ?></td>
                <td>
                    <a class="btn btn-xs btn-primary" href="<?php echo $config['base_url']; ?>/admin?lihat=data_penggunaan_material&metode=detail&id=<?php echo $data['id']; ?>">Detail</a>
                    <a class="btn btn-xs btn-success" href="<?php echo $config['base_url']; ?>/admin?lihat=data_penggunaan_material&metode=edit&id=<?php echo $data['id']; ?>">Ubah</a>
                    <a class="btn btn-xs btn-danger" href="<?php echo $config['base_url']; ?>/admin?lihat=data_penggunaan_material&metode=hapus&id=<?php echo $data['id']; ?>" onclick="return confirm('Apakah anda yakin menghapus data ini?');">Hapus</a>
                </td>
              </tr>
          <?php endforeach; else:?>
              <tr>
                  <td colspan="6">Data tidak ditemukan</td>
              </tr>
          <?php endif; ?>
        </table>
      </div>
      <!-- /.box-body -->
      <div class="box-footer clearfix">
          <?php echo $Paginator->createLinks($links, 'pagination pagination-sm no-margin pull-right'); ?>
      </div>
    </div>
    <!-- /.box -->
  </div>
</div>
