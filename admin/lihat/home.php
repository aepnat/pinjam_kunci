<?php

$month = date('m');
$year = date('Y');

// Total Peminjam Kunci
$sql = 'SELECT count(*) as total FROM pinjam_kunci';
$hasil = $connectdb->query($sql);
$hasil = $hasil->fetch_assoc();
$total_peminjam_kunci = $hasil['total'];

// Total Peminjam Kunci per Bulan
$sql = "SELECT count(*) as total FROM pinjam_kunci WHERE YEAR(wkt_peminjaman) = $year AND MONTH(wkt_peminjaman) = $month";
$hasil = $connectdb->query($sql);
$hasil = $hasil->fetch_assoc();
$total_peminjam_kunci_per_bulan = $hasil['total'];

// Total Pengguna Material
$sql = 'SELECT count(*) as total FROM pengguna_material';
$hasil = $connectdb->query($sql);
$hasil = $hasil->fetch_assoc();
$total_pengguna_material = $hasil['total'];

// Total Peminjam Kunci per Bulan
$sql = "SELECT count(*) as total FROM pengguna_material WHERE YEAR(tgl_dibuat) = $year AND MONTH(tgl_dibuat) = $month";
$hasil = $connectdb->query($sql);
$hasil = $hasil->fetch_assoc();
$total_pengguna_material_per_bulan = $hasil['total'];

// Statisik per bulan di tahun ini
$sql = "SELECT YEAR(wkt_peminjaman) AS tahun,
           MONTH(wkt_peminjaman) AS bulan,
           COUNT(*) AS total
    FROM   pinjam_kunci
    WHERE  YEAR(wkt_peminjaman) = $year
    GROUP BY
           YEAR(wkt_peminjaman),
           MONTH(wkt_peminjaman)";
$hasil = $connectdb->query($sql);
$row = array();
while($data = $hasil->fetch_assoc()) {
    $row[$data['bulan']] = $data;
}

$statistik = array();
for($i=1;$i<=12;$i++){
    if (array_key_exists($i, $row)) {
        $statistik[] = array(
            'y' => sprintf('%s-%s', $row[$i]['tahun'], str_pad($row[$i]['bulan'], 2, 0, STR_PAD_LEFT)),
            'item1' => (int) $row[$i]['total'],
        );
    } else {
        $statistik[] = array(
            'y' => sprintf('%s-%s', $year, str_pad($i, 2, 0, STR_PAD_LEFT)),
            'item1' => 0,
        );
    }
}
$statistik = json_encode($statistik);
// echo '<pre>';
// print_r($statistik);
// echo '</pre>';exit();

?>
<!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3><?php echo $total_peminjam_kunci;?></h3>

        <p>Peminjaman Kunci</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
      <a href="<?php echo $config['base_url'];?>/admin?lihat=data_peminjaman_kunci" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-aqua">
      <div class="inner">
          <h3><?php echo $total_peminjam_kunci_per_bulan;?></h3>

        <p>Peminjaman Kunci (<?php echo bulan($month);?>)</p>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
      <a href="<?php echo $config['base_url'];?>/admin?lihat=data_peminjaman_kunci" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-green">
      <div class="inner">
          <h3><?php echo $total_pengguna_material;?></h3>

        <p>Penggunaan Material</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
      <a href="<?php echo $config['base_url'];?>/admin?lihat=data_penggunaan_material" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-green">
      <div class="inner">
          <h3><?php echo $total_pengguna_material_per_bulan;?></h3>

        <p>Pengunaan Material (September)</p>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
      <a href="<?php echo $config['base_url'];?>/admin?lihat=data_penggunaan_material" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
</div>

<div class="row">
    <section class="col-lg-12">
        <!-- solid sales graph -->
        <div class="box box-solid bg-light-blue-gradient">
          <div class="box-header">
            <i class="fa fa-th"></i>

            <h3 class="box-title">Statistik Peminjaman Kunci Tahun <?php echo date('Y');?></h3>
          </div>
          <div class="box-body border-radius-none">
            <div class="chart" id="line-chart" style="height: 400px;"></div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
</div>

<!-- Morris.js charts -->
<script src="../js/raphael.min.js"></script>
<script src="../js/morris.min.js"></script>

<script type="text/javascript">
$(function () {
    var line = new Morris.Line({
      element          : 'line-chart',
      resize           : true,
      data             : <?php echo $statistik;?>,
      xkey             : 'y',
      ykeys            : ['item1'],
      labels           : ['Peminjam Kunci'],
      lineColors       : ['#fff'],
      lineWidth        : 2,
      hideHover        : 'auto',
      gridTextColor    : '#fff',
      gridStrokeWidth  : 0.4,
      pointSize        : 4,
      pointStrokeColors: ['#fff'],
      gridLineColor    : '#fff',
      gridTextFamily   : 'Open Sans',
      gridTextColor    : '#fff',
      gridTextSize     : 10
    });
});
</script>
