<?php
require_once('../fungsi/paginator.class.php');

$table_name = 'pinjam_kunci';

$status = (isset($_GET['status'])) ? $_GET['status'] : 'semua';

$terhapus = ($status == 'dihapus') ? '1' : '0';
$query = "SELECT $table_name.*, perusahaan.nama as nm_perusahaan FROM $table_name JOIN perusahaan ON perusahaan.perusahaan_id=pinjam_kunci.perusahaan_id WHERE terhapus='$terhapus'";
$query .= ($status == 'selesai' && $status != 'belum') ? ' AND wkt_selesai IS NOT NULL' : '';
$query .= ($status == 'belum' && $status != 'selesai') ? ' AND wkt_selesai IS NULL' : '';

// tahun
if (isset($_GET['tahun']) && $_GET['tahun'] != '') {
    $tahun = $_GET['tahun'];
    $query .= " AND YEAR(wkt_peminjaman) = '$tahun'";
}

// bulan
if (isset($_GET['bulan']) && $_GET['bulan'] != '') {
    $bulan = $_GET['bulan'];
    $query .= " AND MONTH(wkt_peminjaman) = '$bulan'";
}

$limit      = ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 20;
$page       = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
$links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 7;

$base_url = $config['base_url'] . '/admin?lihat=' . $_GET['lihat'];

$Paginator  = new Paginator( $connectdb, $query, $base_url );

$results    = $Paginator->getData( $limit, $page );

// total data semua
$sql = "SELECT * FROM $table_name WHERE terhapus='0'";
$hasil = $connectdb->query($sql);
$total_semua = $hasil->num_rows;

// total data selesai
$sql = "SELECT * FROM $table_name WHERE terhapus='0' AND wkt_selesai IS NOT NULL";
$hasil = $connectdb->query($sql);
$total_selesai = $hasil->num_rows;

// total data selesai
$sql = "SELECT * FROM $table_name WHERE terhapus='0' AND wkt_selesai IS NULL";
$hasil = $connectdb->query($sql);
$total_belum_selesai = $hasil->num_rows;

// total data dihapus
$sql = "SELECT * FROM $table_name WHERE terhapus='1'";
$hasil = $connectdb->query($sql);
$total_dihapus = $hasil->num_rows;

// data tahun
$sql = "SELECT EXTRACT(YEAR FROM wkt_peminjaman) as tahun FROM $table_name GROUP BY tahun";
$data_tahun = $connectdb->query($sql);

// data bulan
$sql = "SELECT EXTRACT(MONTH FROM wkt_peminjaman) as bulan FROM $table_name GROUP BY bulan";
$data_bulan = $connectdb->query($sql);
?>

<div class="row">
 <div class="col-xs-3">
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">Status</h3>

            <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body no-padding">
            <?php $status = isset($_GET['status']) ? $_GET['status'] : 'semua';?>
            <?php $params = (isset($_GET)) ? $_GET : array();?>
            <?php
            if (isset($params['status'])) {
                unset($params['status']);
            }
            ?>
            <ul class="nav nav-pills nav-stacked">
                <li class="<?php echo ($status == 'semua') ? 'active' : '';?>"><a href="<?php echo $config['base_url'];?>/admin?<?php echo http_build_query($params);?>&status=semua"><i class="fa fa-inbox"></i> Semua <span class="label label-primary pull-right"><?php echo $total_semua;?></span></a></li>
                <li class="<?php echo ($status == 'selesai') ? 'active' : '';?>"><a href="<?php echo $config['base_url'];?>/admin?<?php echo http_build_query($params);?>&status=selesai"><i class="fa fa-envelope-o"></i> Selesai <span class="label label-primary pull-right"><?php echo $total_selesai;?></span></a></a></li>
                <li class="<?php echo ($status == 'belum') ? 'active' : '';?>"><a href="<?php echo $config['base_url'];?>/admin?<?php echo http_build_query($params);?>&status=belum"><i class="fa fa-file-text-o"></i> Belum Selesai <span class="label label-primary pull-right"><?php echo $total_belum_selesai;?></span></a></a></li>
                <li class="<?php echo ($status == 'dihapus') ? 'active' : '';?>"><a href="<?php echo $config['base_url'];?>/admin?<?php echo http_build_query($params);?>&status=dihapus"><i class="fa fa-trash-o"></i> Dihapus <span class="label label-primary pull-right"><?php echo $total_dihapus;?></span></a></a></li>
            </ul>
        </div>
        <!-- /.box-body -->
    </div>
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">Saring</h3>

            <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <form action="" method="GET">
                <?php $params = (isset($_GET)) ? $_GET : array();?>
                <?php foreach($params as $k => $v):
                    if (in_array($k, array('tahun', 'bulan'))) {
                        continue;
                    }
                    ?>
                    <input type="hidden" name="<?php echo $k;?>" value="<?php echo $v;?>" />
                <?php endforeach;?>
                <ul class="nav nav-pills nav-stacked">
                    <li>
                        <select name="tahun" class="form-control">
                            <option value="">Pilih Tahun</option>
                            <?php if ($data_tahun->num_rows > 0): while($data = $data_tahun->fetch_assoc()):?>
                                <option value="<?php echo $data['tahun'];?>" <?php echo (isset($_GET['tahun']) && $_GET['tahun'] == $data['tahun']) ? 'selected="selected"' : '';?>><?php echo $data['tahun'];?></option>
                            <?php endwhile;endif;?>
                        </select><br>
                    </li>
                    <li>
                        <select name="bulan" class="form-control">
                            <option value="">Pilih Bulan</option>
                            <?php if ($data_bulan->num_rows > 0): while($data = $data_bulan->fetch_assoc()):?>
                                <option value="<?php echo $data['bulan'];?>" <?php echo (isset($_GET['bulan']) && $_GET['bulan'] == $data['bulan']) ? 'selected="selected"' : '';?>><?php echo bulan($data['bulan']);?></option>
                            <?php endwhile;endif;?>
                        </select>
                    </li>
                </ul>
                <br />
                <button type="submit" class="btn btn-primary">Saring</button>
            </form>
        </div>
        <!-- /.box-body -->
    </div>

 </div>
  <div class="col-xs-9">
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
          <?php if (!empty($results->data)): foreach($results->data as $data):
              $is_selesai = ($data['wkt_selesai'] != null || $data['wkt_selesai'] != '') ? TRUE : FALSE;
              ?>
              <tr>
                <td><?php echo $data['kode_kunci'];?></td>
                <td><?php echo $data['tujuan'];?></td>
                <td><?php echo $data['nm_peminjam'];?></td>
                <td><?php echo $data['nm_perusahaan'];?></td>
                <td><?php echo waktu_indo($data['wkt_peminjaman']);?></td>
                <td><?php echo (! $is_selesai) ? '-' : waktu_indo($data['wkt_selesai']);?></td>
                <td><?php echo (! $is_selesai) ? '<span class="label label-warning">Belum</span>' : '<span class="label label-success">Selesai</span>';?></td>
                <td>
                    <?php if (! $is_selesai):?>
                        <a class="btn btn-xs btn-warning" href="<?php echo $config['base_url'];?>/admin?lihat=data_peminjaman_kunci&metode=selesai&id=<?php echo $data['id'];?>" onclick="return confirm('Apakah anda yakin menyelesaikan data ini?');">Selesai</a>
                    <?php endif;?>
                    <a class="btn btn-xs btn-primary" href="<?php echo $config['base_url'];?>/admin?lihat=data_peminjaman_kunci&metode=detail&id=<?php echo $data['id'];?>">Detail</a>
                    <a class="btn btn-xs btn-success" href="<?php echo $config['base_url'];?>/admin?lihat=data_peminjaman_kunci&metode=edit&id=<?php echo $data['id'];?>">Ubah</a>
                    <a class="btn btn-xs btn-danger" href="<?php echo $config['base_url'];?>/admin?lihat=data_peminjaman_kunci&metode=hapus&id=<?php echo $data['id'];?>" onclick="return confirm('Apakah anda yakin menghapus data ini?');">Hapus</a>
                </td>
              </tr>
          <?php endforeach;else:?>
              <tr>
                  <td colspan="8">Data tidak ditemukan</td>
              </tr>
          <?php endif;?>
        </table>
      </div>
      <!-- /.box-body -->
      <div class="box-footer clearfix">
          <?php echo $Paginator->createLinks( $links, 'pagination pagination-sm no-margin pull-right' ); ?>
      </div>
    </div>
    <!-- /.box -->
  </div>
</div>
