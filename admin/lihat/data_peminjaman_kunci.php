<?php
require_once('../fungsi/paginator.class.php');

$query = 'SELECT pinjam_kunci.*, perusahaan.nama as nm_perusahaan FROM pinjam_kunci JOIN perusahaan ON perusahaan.perusahaan_id=pinjam_kunci.perusahaan_id';

$limit      = ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 20;
$page       = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
$links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 7;

$base_url = $config['base_url'] . '/admin?lihat=' . $_GET['lihat'];

$Paginator  = new Paginator( $connectdb, $query, $base_url );

$results    = $Paginator->getData( $limit, $page );
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
