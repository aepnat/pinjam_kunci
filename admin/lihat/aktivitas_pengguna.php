<?php
require_once '../fungsi/paginator.class.php';

$sql = "SELECT log_pengguna.*, pengguna.email, pengguna.nama_lengkap FROM log_pengguna JOIN pengguna ON pengguna.pengguna_id=log_pengguna.pengguna_id";

if (isset($_GET['metode']) && $_GET['metode'] == 'cari') {
    $q = $_GET['q'];
    $sql .= " WHERE pengguna.nama_lengkap LIKE '%$q%' OR pengguna.email LIKE '%$q%'";
}
$sql .= " ORDER BY time DESC";

$limit = (isset($_GET['limit'])) ? $_GET['limit'] : 10;
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
            <form action="" method="get">
            <div class="input-group input-group-sm" style="width: 150px;">
            <input type="text" name="q" class="form-control pull-right" value="<?php echo isset($_POST['q']) ? $_POST['q'] : ''; ?>" placeholder="Cari">

            <div class="input-group-btn">
              <input type="hidden" name="lihat" value="aktivitas_pengguna" />
              <input type="hidden" name="metode" value="cari" />
              <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
            </div>
          </div>
          </form>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive no-padding">
        <table class="table table-hover table-striped">
          <thead>
            <tr>
              <th>No.</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Waktu</th>
              <th>IP</th>
              <th>Aktivitas</th>
            </tr>
          </thead>
          <tbody>
            <?php $no=1; if (!empty($results->data)): foreach ($results->data as $data):?>
              <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $data['nama_lengkap']; ?></td>
                <td><?php echo $data['email']; ?></td>
                <td><?php echo date('d M Y H:i:s', $data['time']); ?></td>
                <td><?php echo $data['ip']; ?></td>
                <td><?php echo $data['log']; ?></td>
              </tr>
          <?php endforeach; else:?>
              <tr>
                  <td colspan="5">Data tidak ditemukan</td>
              </tr>
          <?php endif; ?>
          </tbody>
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
