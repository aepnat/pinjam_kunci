<?php
require_once '../fungsi/paginator.class.php';

$sql = 'SELECT * FROM perusahaan';

if (isset($_POST['metode']) && $_POST['metode'] == 'cari') {
    $q = $_POST['q'];
    $sql .= " WHERE nama LIKE '%$q%'";
}

$limit = (isset($_GET['limit'])) ? $_GET['limit'] : 20;
$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
$links = (isset($_GET['links'])) ? $_GET['links'] : 7;

$base_url = $config['base_url'].'/admin?lihat='.$_GET['lihat'];

$Paginator = new Paginator($connectdb, $sql, $base_url);

$results = $Paginator->getData($limit, $page);
?>
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Data</h3>

        <div class="box-tools">
            <form action="" method="post">
            <div class="input-group input-group-sm" style="width: 150px;">
            <input type="text" name="q" class="form-control pull-right" value="<?php echo isset($_POST['q']) ? $_POST['q'] : ''; ?>" placeholder="Cari">

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
          <?php if (!empty($results->data)): foreach ($results->data as $data):?>
              <tr>
                <td><?php echo $data['nama']; ?></td>
                <td><?php echo $data['no_telp']; ?></td>
                <td><?php echo $data['alamat']; ?></td>
                <td>
                    <a class="btn btn-xs btn-success" href="<?php echo $config['base_url']; ?>/admin?lihat=data_perusahaan&metode=edit&id=<?php echo $data['perusahaan_id']; ?>">Ubah</a>
                    <a class="btn btn-xs btn-danger" href="<?php echo $config['base_url']; ?>/admin?lihat=data_perusahaan&metode=hapus&id=<?php echo $data['perusahaan_id']; ?>" onclick="return confirm('Apakah anda yakin menghapus data ini?');">Hapus</a>
                </td>
              </tr>
          <?php endforeach; else:?>
              <tr>
                  <td colspan="4">Data tidak ditemukan</td>
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
