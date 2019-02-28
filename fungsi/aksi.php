<?php

require_once 'fungsi_pengguna.php';

global $metode;
global $lihat;

/*
 * Input Perusahaan
 * ============================================================================
 */
if ($metode == 'input_perusahaan' || ($lihat == 'data_perusahaan' && $metode == 'edit' && isset($_POST['metode2']))) {
    // Validasi
    $fields = [
        'nama' => [
            'label' => 'Nama',
            'max'   => 80,
        ],
        'no_telp' => [
            'label' => 'No. Telepon',
            'max'   => 20,
        ],
        'alamat' => [
            'label' => 'Alamat',
            'max'   => 200,
        ],
    ];
    $error_text = [];
    foreach ($fields as $field => $validasi) {
        $label = $validasi['label'];

        if ($_POST[$field] == '') {
            $error_text[] = sprintf('Kolom %s tidak boleh kosong', $label);
        }

        if (isset($validasi['max']) && strlen($_POST[$field]) > $validasi['max']) {
            $error_text[] = sprintf('Kolom %s tidak boleh melebihi %s karakter', $label, $validasi['max']);
        }
    }

    $is_edit = isset($_POST['metode2']) && $_POST['metode2'] == 'edit';

    // periksa duplikasi
    if (empty($error_text)) {
        // cari nama yang sama
        $nama = $_POST['nama'];
        $sql = "SELECT * FROM perusahaan WHERE nama = '$nama'";

        // metode edit
        if ($is_edit) {
            $perusaahan_id = $_POST['id'];
            $sql .= " AND NOT perusahaan_id = '$perusaahan_id'";
        }

        $hasil = $connectdb->query($sql);
        if ($hasil->num_rows > 0) {
            $error_text[] = 'Data perusaahan dengan nama ini sudah ada!';
        }
    }

    // jika tidak ada error
    if (empty($error_text)) {
        $nama = $_POST['nama'];
        $no_telp = $_POST['no_telp'];
        $alamat = $_POST['alamat'];
        $tgl_dibuat = date('Y-m-d H:i:s');
        $dibuat_oleh = $_SESSION['pengguna_id'];

        if ($is_edit) {
            $perusahaan_id = $_POST['id'];
            $sql = "UPDATE perusahaan SET nama='$nama', no_telp='$no_telp', alamat='$alamat' WHERE perusahaan_id='$perusahaan_id'";
            $sukses_text[] = 'Berhasil menyimpan data perusahaan';
        } else {
            $sql = "INSERT INTO perusahaan (nama, no_telp, alamat, tgl_dibuat, dibuat_oleh) VALUES ('$nama', '$no_telp', '$alamat', '$tgl_dibuat', '$dibuat_oleh')";
            $sukses_text[] = 'Berhasil menambah data perusahaan';
        }

        if ($connectdb->query($sql) === true) {
            log_pengguna([
                'log'      => ($is_edit) ? 'Ubah data perusahaan' : 'Tambah data perusahaan',
                'log_data' => json_encode([
                    'nama'    => $nama,
                    'no_telp' => $no_telp,
                    'alamat'  => $alamat,
                ]),
            ]);
            $_SESSION['success_text'] = $sukses_text;
            header('Location:'.$config['base_url'].'/admin?lihat=data_perusahaan');
            exit();
        } else {
            $error_text[] = 'Data tidak bisa ditambah. Kegagalan sistem. Silahkan Coba lagi!';
        }
    }

    if (!empty($error_text)) {
        $_SESSION['error_text'] = $error_text;
    }
}

/*
 * Input Material
 * ============================================================================
 */
if ($metode == 'input_material' || ($lihat == 'data_material' && $metode == 'edit' && isset($_POST['metode2']))) {
    // Validasi
    $fields = [
        'kode_material' => [
            'label' => 'Kode Materials',
            'max'   => 80,
        ],
        'nm_material' => [
            'label' => 'Nama Material',
            'max'   => 120,
        ],
        'kuantitas' => [
            'label' => 'Kuantitas',
            'max'   => 11,
        ],
    ];
    $error_text = [];
    foreach ($fields as $field => $validasi) {
        $label = $validasi['label'];

        if ($_POST[$field] == '') {
            $error_text[] = sprintf('Kolom %s tidak boleh kosong', $label);
        }

        if (isset($validasi['max']) && strlen($_POST[$field]) > $validasi['max']) {
            $error_text[] = sprintf('Kolom %s tidak boleh melebihi %s karakter', $label, $validasi['max']);
        }
    }

    $is_edit = isset($_POST['metode2']) && $_POST['metode2'] == 'edit';

    // periksa duplikasi
    if (empty($error_text)) {
        // cari nama yang sama
        $nama = $_POST['kode_material'];
        $sql = "SELECT * FROM material WHERE kode_material = '$nama'";

        // metode edit
        if ($is_edit) {
            $perusaahan_id = $_POST['id'];
            $sql .= " AND NOT id = '$perusaahan_id'";
        }

        $hasil = $connectdb->query($sql);
        if ($hasil->num_rows > 0) {
            $error_text[] = 'Data material dengan kode ini sudah ada!';
        }
    }

    // jika tidak ada error
    if (empty($error_text)) {
        $kode_material = $_POST['kode_material'];
        $nm_material = $_POST['nm_material'];
        $kuantitas = $_POST['kuantitas'];
        $tgl_dibuat = date('Y-m-d H:i:s');
        $dibuat_oleh = $_SESSION['pengguna_id'];

        if ($is_edit) {
            $id = $_POST['id'];
            $sql = "UPDATE material SET kode_material='$kode_material', nm_material='$nm_material', kuantitas='$kuantitas' WHERE id='$id'";
            $sukses_text[] = 'Berhasil menyimpan data material';
        } else {
            $sql = "INSERT INTO material (kode_material, nm_material, kuantitas, tgl_dibuat, dibuat_oleh) VALUES ('$kode_material', '$nm_material', '$kuantitas', '$tgl_dibuat', '$dibuat_oleh')";
            $sukses_text[] = 'Berhasil menambah data material';
        }

        if ($connectdb->query($sql) === true) {
            log_pengguna([
                'log'      => ($is_edit) ? 'Ubah data material' : 'Tambah data material',
                'log_data' => json_encode([
                    'kode_material' => $kode_material,
                    'nm_material'   => $nm_material,
                    'kuantitas'     => $kuantitas,
                ]),
            ]);
            $_SESSION['success_text'] = $sukses_text;
            header('Location:'.$config['base_url'].'/admin?lihat=data_material');
            exit();
        } else {
            $error_text[] = 'Data tidak bisa ditambah. Kegagalan sistem. Silahkan Coba lagi!';
        }
    }

    if (!empty($error_text)) {
        $_SESSION['error_text'] = $error_text;
    }
}

/*
 * Input Peminjaman Kunci
 * ============================================================================
 */
if ($metode == 'input_peminjaman_kunci' || ($lihat == 'data_peminjaman_kunci' && $metode == 'edit' && isset($_POST['metode2']))) {
    // Validasi
    $fields = [
        'kode_kunci' => [
            'label' => 'Kode Kunci',
            'max'   => 15,
        ],
        'tujuan' => [
            'label' => 'Tujuan',
            'max'   => 80,
        ],
        'jenis_pekerjaan' => [
            'label' => 'Jenis Pekerjaans',
            'max'   => 30,
        ],
        'jenis_id' => [
            'label' => 'Jenis ID',
            'max'   => 10,
        ],
        'no_id' => [
            'label' => 'Nomor ID',
            'max'   => 30,
        ],
        'nm_peminjam' => [
            'label' => 'Nama Peminjam',
            'max'   => 80,
        ],
        'no_telp_peminjam' => [
            'label' => 'No. Telp. Peminjam',
            'max'   => 15,
        ],
        'email_peminjam' => [
            'label' => 'Email Peminjam',
            'max'   => 30,
        ],
        'perusahaan_id' => [
            'label' => 'Perusahaan',
            'max'   => 11,
        ],
    ];
    $error_text = [];
    foreach ($fields as $field => $validasi) {
        $label = $validasi['label'];

        if ($_POST[$field] == '') {
            $error_text[] = sprintf('Kolom %s tidak boleh kosong', $label);
        }

        if (isset($validasi['max']) && strlen($_POST[$field]) > $validasi['max']) {
            $error_text[] = sprintf('Kolom %s tidak boleh melebihi %s karakter', $label, $validasi['max']);
        }
    }

    $is_edit = isset($_POST['metode2']) && $_POST['metode2'] == 'edit';

    // jika tidak ada error
    if (empty($error_text)) {
        $kode_kunci = $_POST['kode_kunci'];
        $tujuan = $_POST['tujuan'];
        $jenis_pekerjaan = $_POST['jenis_pekerjaan'];
        $jenis_id = $_POST['jenis_id'];
        $no_id = $_POST['no_id'];
        $nm_peminjam = $_POST['nm_peminjam'];
        $no_telp_peminjam = $_POST['no_telp_peminjam'];
        $email_peminjam = $_POST['email_peminjam'];
        $perusahaan_id = $_POST['perusahaan_id'];

        if ($is_edit) {
            $id = $_POST['id'];
            $sql = "UPDATE pinjam_kunci SET
                                    kode_kunci='$kode_kunci',
                                    tujuan='$tujuan',
                                    jenis_pekerjaan='$jenis_pekerjaan',
                                    jenis_id='$jenis_id',
                                    no_id='$no_id',
                                    nm_peminjam='$nm_peminjam',
                                    no_telp_peminjam='$no_telp_peminjam',
                                    email_peminjam='$email_peminjam',
                                    perusahaan_id='$perusahaan_id'
                    WHERE id='$id'";
            $sukses_text[] = 'Berhasil menyimpan data peminjaman kunci';
        } else {
            $wkt_peminjaman = date('Y-m-d H:i:s');
            $dibuat_oleh = $_SESSION['pengguna_id'];
            $sql = "INSERT INTO pinjam_kunci (kode_kunci, tujuan, jenis_pekerjaan, jenis_id, no_id, nm_peminjam, no_telp_peminjam, email_peminjam, perusahaan_id, wkt_peminjaman, dibuat_oleh)
            VALUES ('$kode_kunci', '$tujuan', '$jenis_pekerjaan', '$jenis_id', '$no_id', '$nm_peminjam', '$no_telp_peminjam', '$email_peminjam', '$perusahaan_id', '$wkt_peminjaman', '$dibuat_oleh')";
            $sukses_text[] = 'Berhasil menambah data peminjaman kunci';
        }

        if ($connectdb->query($sql) === true) {
            log_pengguna([
                'log'      => ($is_edit) ? 'Ubah data peminjaman kunci' : 'Tambah data peminjaman kunci',
                'log_data' => json_encode([
                    'kode_kunci'       => $kode_kunci,
                    'tujuan'           => $tujuan,
                    'jenis_pekerjaan'  => $jenis_pekerjaan,
                    'jenis_id'         => $jenis_id,
                    'no_id'            => $no_id,
                    'nm_peminjam'      => $nm_peminjam,
                    'no_telp_peminjam' => $no_telp_peminjam,
                    'email_peminjam'   => $email_peminjam,
                    'perusahaan_id'    => $perusahaan_id,
                ]),
            ]);
            $_SESSION['success_text'] = $sukses_text;
            header('Location:'.$config['base_url'].'/admin?lihat=data_peminjaman_kunci');
            exit();
        } else {
            error_log('Error menambah registrasi peminjaman kunci. '.$connectdb->error);
            $error_text[] = 'Data tidak bisa ditambah. Kegagalan sistem. Silahkan Coba lagi!';
        }
    }

    if (!empty($error_text)) {
        $_SESSION['error_text'] = $error_text;
    }
}

/*
 * Input Pengunaan Material
 * ============================================================================
 */
if ($metode == 'input_penggunaan_material' || ($lihat == 'data_penggunaan_material' && $metode == 'edit' && isset($_POST['metode2']))) {
    // Validasi
    $fields = [
        'jenis_id' => [
            'label' => 'Jenis ID',
            'max'   => 10,
        ],
        'no_id' => [
            'label' => 'Nomor ID',
            'max'   => 30,
        ],
        'nm_pengguna' => [
            'label' => 'Nama Pengguna',
            'max'   => 80,
        ],
        'no_telp_pengguna' => [
            'label' => 'No. Telp. Pengguna',
            'max'   => 15,
        ],
        'email_pengguna' => [
            'label' => 'Email Pengguna',
            'max'   => 30,
        ],
        'perusahaan_id' => [
            'label' => 'Perusahaan',
            'max'   => 11,
        ],
        'id_material' => [
            'label' => 'Material',
            'max'   => 11,
        ],
        'kuantitas' => [
            'label' => 'Kuantitas Material',
            'max'   => 11,
        ],
    ];
    $error_text = [];
    foreach ($fields as $field => $validasi) {
        $label = $validasi['label'];

        if ($_POST[$field] == '') {
            $error_text[] = sprintf('Kolom %s tidak boleh kosong', $label);
        }

        if (isset($validasi['max']) && strlen($_POST[$field]) > $validasi['max']) {
            $error_text[] = sprintf('Kolom %s tidak boleh melebihi %s karakter', $label, $validasi['max']);
        }
    }

    // validasi kuantitas
    if (empty($error_text)) {
        $id_material = $_POST['id_material'];
        $kuantitas = $_POST['kuantitas'];
        $material = $connectdb->query("SELECT kuantitas FROM material WHERE id='$id_material'");
        if (! $material) {
            $error_text[] = 'Data material tidak ditemukkan. Silahkan coba lagi!';
        } else {
            $material = $material->fetch_assoc();
            if ($kuantitas > $material['kuantitas']) {
                $error_text[] = 'Kuantitas yang dimasukan melebihi kuantitas material yang tersedia. Kuantitas yang tersedia adalah ' . $material['kuantitas'];
            }
        }
    }

    $is_edit = isset($_POST['metode2']) && $_POST['metode2'] == 'edit';

    // jika tidak ada error
    if (empty($error_text)) {
        $jenis_id = $_POST['jenis_id'];
        $no_id = $_POST['no_id'];
        $nm_pengguna = $_POST['nm_pengguna'];
        $no_telp_pengguna = $_POST['no_telp_pengguna'];
        $email_pengguna = $_POST['email_pengguna'];
        $perusahaan_id = $_POST['perusahaan_id'];
        $id_material = $_POST['id_material'];
        $kuantitas = $_POST['kuantitas'];

        if ($is_edit) {
            $id = $_POST['id'];
            $sql = "UPDATE pengguna_material SET
                                    jenis_id='$jenis_id',
                                    no_id='$no_id',
                                    nm_pengguna='$nm_pengguna',
                                    no_telp_pengguna='$no_telp_pengguna',
                                    email_pengguna='$email_pengguna',
                                    perusahaan_id='$perusahaan_id',
                                    id_material='$id_material',
                                    kuantitas='$kuantitas'
                    WHERE id='$id'";
            $sukses_text[] = 'Berhasil menyimpan data penggunaan material';
        } else {
            $wkt_dibuat = date('Y-m-d H:i:s');
            $dibuat_oleh = $_SESSION['pengguna_id'];
            $sql = "INSERT INTO pengguna_material (jenis_id, no_id, nm_pengguna, no_telp_pengguna, email_pengguna, perusahaan_id, id_material, kuantitas, tgl_dibuat, dibuat_oleh)
            VALUES ('$jenis_id', '$no_id', '$nm_pengguna', '$no_telp_pengguna', '$email_pengguna', '$perusahaan_id', '$id_material', '$kuantitas', '$wkt_dibuat', '$dibuat_oleh')";
            $sukses_text[] = 'Berhasil menambah data penggunaan material';
        }

        if ($connectdb->query($sql) === true) {
            log_pengguna([
                'log'      => ($is_edit) ? 'Ubah data penggunaan material' : 'Tambah data penggunaan material',
                'log_data' => json_encode([
                    'jenis_id'         => $jenis_id,
                    'no_id'            => $no_id,
                    'nm_pengguna'      => $nm_pengguna,
                    'no_telp_pengguna' => $no_telp_pengguna,
                    'email_pengguna'   => $email_pengguna,
                    'perusahaan_id'    => $perusahaan_id,
                    'id_material'      => $id_material,
                    'kuantitas'        => $kuantitas,
                ]),
            ]);

            // kurangi kuantitas
            if (! $is_edit) {
                $connectdb->query("UPDATE material SET kuantitas = kuantitas - $kuantitas WHERE id='$id_material'");
            }

            // message
            $_SESSION['success_text'] = $sukses_text;

            // redirection
            header('Location:'.$config['base_url'].'/admin?lihat=data_penggunaan_material');
            exit();
        } else {
            error_log('Error registrasi penggunaan material. '.$connectdb->error);
            $error_text[] = 'Data tidak bisa ditambah. Kegagalan sistem. Silahkan Coba lagi!';
        }
    }

    if (!empty($error_text)) {
        $_SESSION['error_text'] = $error_text;
    }
}

/*
 * Download Data Peminjaman Kunci
 * ============================================================================
 */
if ($lihat == 'data_peminjaman_kunci' && $metode == 'download') {
    global $id;

    $sql = "SELECT pinjam_kunci.*, perusahaan.nama as nm_perusahaan, perusahaan.no_telp as no_telp_perusahaan FROM pinjam_kunci JOIN perusahaan ON perusahaan.perusahaan_id=pinjam_kunci.perusahaan_id WHERE id = $id";
    $hasil = $connectdb->query($sql);
    $data = $hasil->fetch_assoc();
    $is_selesai = ($data['wkt_selesai'] != null || $data['wkt_selesai'] != '') ? true : false;
        
    if (empty($data)) {
      // message
      $_SESSION['error_text'][] = 'Data peminjaman kunci tidak ditemukkan';
      ?>
      <script type="text/javascript">
        window.history.go(-1);
      </script>
      <?php
      exit();  
    }
    
    require_once("tcpdf/tcpdf.php");
// echo K_PATH_IMAGES;exit();
    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Aplikasi Peminjaman Kunci');
    $pdf->SetTitle('Data Peminjaman Kunci - ' . $data['nm_perusahaan']);
    $pdf->SetSubject('Aplikasi Peminjaman Kunci');
    $pdf->SetKeywords('peminjaman kunci, peminjaman material');

    // set default header data
    $logo = 'logo-huawei.png';
    $pdf->SetHeaderData($logo, PDF_HEADER_LOGO_WIDTH, 'Data Peminjaman Kunci', 'Aplikasi Peminjaman Kunci');
    // $pdf->setFooterData(array(0,0,0), array(0,0,0));

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    // $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    // ---------------------------------------------------------

    // set default font subsetting mode
    $pdf->setFontSubsetting(true);

    // Set font
    // dejavusans is a UTF-8 Unicode font, if you only need to
    // print standard ASCII chars, you can use core fonts like
    // helvetica or times to reduce file size.
    $pdf->SetFont('helvetica', '', 12, '', true);

    // Add a page
    // This method has several options, check the source code documentation for more information.
    $pdf->AddPage();

    // set text shadow effect
    // $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
foreach ($data as $k => $v) {
    if ($data[$k] == '') {
        $data[$k] = '-';
    }
}

$status = ($is_selesai) ? 'Selesai' : 'Belum';
$jenis_pekerjaan = ucwords(str_replace('_', ' ', $data['jenis_pekerjaan']));
$waktu_pinjam = waktu_indo($data['wkt_peminjaman']);
$waktu_selesai = (!$is_selesai) ? '-' : waktu_indo($data['wkt_selesai']);
$data['jenis_id'] = strtoupper($data['jenis_id']);
$html = <<<EOD
<p><strong>Status</strong><br>
{$status}</p>

<p><strong>Perusahaan</strong><br>
{$data['nm_perusahaan']} ({$data['no_telp_perusahaan']})</p>

<p><strong>ID Kunci</strong><br>
{$data['kode_kunci']}</p>

<p><strong>Tujuan</strong><br>
{$data['tujuan']}</p>

<p><strong>Nama Peminjam</strong><br>
{$data['nm_peminjam']}</p>

<p><strong>No. Telp Peminjam</strong><br>
{$data['no_telp_peminjam']}</p>

<p><strong>Email Peminjam</strong><br>
{$data['email_peminjam']}</p>

<p><strong>Jenis ID Peminjam</strong><br>
{$data['jenis_id']}</p>

<p><strong>Nomor ID Peminjam</strong><br>
{$data['no_id']}</p>

<p><strong>Jenis Pekerjaan</strong><br>
{$jenis_pekerjaan}</p>

<p><strong>Waktu Pinjam</strong><br>
{$waktu_pinjam}</p>

<p><strong>Waktu Selesai Pinjam</strong><br>
{$waktu_selesai}</p>

EOD;

    // Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

    // ---------------------------------------------------------

    // Close and output PDF document
    // This method has several options, check the source code documentation for more information.
    $pdf->Output('Data peminjaman kunci ' . $data['nm_perusahaan'] . '.pdf', 'D');
}

/*
 * Download Data Penggunaan Material
 * ============================================================================
 */
if ($lihat == 'data_penggunaan_material' && $metode == 'download') {
    global $id;

    $sql = "SELECT pengguna_material.*, perusahaan.nama as nm_perusahaan, perusahaan.no_telp as no_telp_perusahaan, material.nm_material, material.kode_material  
            FROM pengguna_material 
            JOIN perusahaan ON perusahaan.perusahaan_id=pengguna_material.perusahaan_id 
            JOIN material ON material.id=pengguna_material.id_material
            WHERE pengguna_material.id = $id";
    $hasil = $connectdb->query($sql);
    $data = ($hasil) ? $hasil->fetch_assoc() : array();
    
    if (empty($data)) {
      // message
      $_SESSION['error_text'][] = 'Data penggunaan material tidak ditemukkan';
      ?>
      <script type="text/javascript">
        window.history.go(-1);
      </script>
      <?php
      exit();  
    }
    
    require_once("tcpdf/tcpdf.php");
// echo K_PATH_IMAGES;exit();
    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Aplikasi Peminjaman Kunci');
    $pdf->SetTitle('Data Pengguna Material - ' . $data['nm_perusahaan']);
    $pdf->SetSubject('Aplikasi Peminjaman Kunci');
    $pdf->SetKeywords('penggunaan material, peminjaman material');

    // set default header data
    $logo = 'logo-huawei.png';
    $pdf->SetHeaderData($logo, PDF_HEADER_LOGO_WIDTH, 'Data Penggunaan Material', 'Aplikasi Peminjaman Kunci');
    // $pdf->setFooterData(array(0,0,0), array(0,0,0));

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    // $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    // ---------------------------------------------------------

    // set default font subsetting mode
    $pdf->setFontSubsetting(true);

    // Set font
    // dejavusans is a UTF-8 Unicode font, if you only need to
    // print standard ASCII chars, you can use core fonts like
    // helvetica or times to reduce file size.
    $pdf->SetFont('helvetica', '', 12, '', true);

    // Add a page
    // This method has several options, check the source code documentation for more information.
    $pdf->AddPage();

    // set text shadow effect
    // $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
foreach ($data as $k => $v) {
    if ($data[$k] == '') {
        $data[$k] = '-';
    }
}

$data['jenis_id'] = strtoupper($data['jenis_id']);
$html = <<<EOD
<p><strong>Perusahaan</strong><br>
{$data['nm_perusahaan']}</p>

<p><strong>Nama Material</strong><br>
{$data['nm_material']}</p>

<p><strong>Kode Material</strong><br>
{$data['kode_material']}</p>

<p><strong>Jenis ID</strong><br>
{$data['jenis_id']}</p>

<p><strong>Nomor ID Pengguna</strong><br>
{$data['no_id']}</p>

<p><strong>Nama Pengguna</strong><br>
{$data['nm_pengguna']}</p>

<p><strong>No. Telp Pengguna</strong><br>
{$data['no_telp_pengguna']}</p>

<p><strong>Email Pengguna</strong><br>
{$data['email_pengguna']}</p>
EOD;

    // Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

    // ---------------------------------------------------------

    // Close and output PDF document
    // This method has several options, check the source code documentation for more information.
    $pdf->Output('Data penggunaan material ' . $data['nm_perusahaan'] . '.pdf', 'D');
}

/*
 * Selesai Data Peminjaman Kunci
 * ============================================================================
 */
if ($lihat == 'data_peminjaman_kunci' && $metode == 'selesai') {
    global $id;

    // check exists
    $sql = "SELECT * FROM pinjam_kunci WHERE id='$id'";
    $hasil = $connectdb->query($sql);
    if ($hasil->num_rows > 0) {
        // update
        $wkt_selesai = date('Y-m-d H:i:s');
        $sql = "UPDATE pinjam_kunci SET wkt_selesai='$wkt_selesai' WHERE id='$id'";

        if ($connectdb->query($sql) === true) {
            $_SESSION['success_text'] = ['Data peminjaman kunci sudah diselesaikan'];
        } else {
            error_log('Error selesai data peminjaman kunci. '.$connectdb->error);
            $_SESSION['error_text'] = ['Data tidak bisa diselesaikan. Kegagalan sistem. Silahkan Coba lagi!'];
        }
    } else {
        $_SESSION['error_text'] = ['Data Peminjaman Kunci tidak ditemukan.'];
    }

    header('Location: '.$config['base_url'].'/admin?lihat=data_peminjaman_kunci');
    die();
}

/*
 * Hapus Data Perusahaan
 * ============================================================================
 */
if ($lihat == 'data_perusahaan' && $metode == 'hapus') {
    global $id;

    $location_header = 'Location: '.$config['base_url'].'/admin?lihat=data_perusahaan';

    // check exists
    $sql = "SELECT * FROM perusahaan WHERE perusahaan_id='$id'";
    $hasil = $connectdb->query($sql);
    $perusahaan = $hasil->fetch_array(MYSQLI_ASSOC);
    if ($hasil->num_rows < 1) {
        $_SESSION['error_text'] = ['Data perusahaan tidak ditemukan.'];
        header($location_header);
        die();
    }

    // check sudah dipakai oleh peminjaman kunci
    $sql = "SELECT * FROM pinjam_kunci WHERE perusahaan_id='$id'";
    $hasil = $connectdb->query($sql);
    if ($hasil->num_rows > 0) {
        $_SESSION['error_text'] = ['Data gagal dihapus.<br>Data perusahaan sudah dipakai data peminjaman kunci. Anda hanya bisa merubah data ini atau menghapus data peminjaman kunci perusahaan ini.'];
        header($location_header);
        die();
    }

    // check sudah dipakai oleh penggunaan material
    $sql = "SELECT * FROM pengguna_material WHERE perusahaan_id='$id'";
    $hasil = $connectdb->query($sql);
    if ($hasil->num_rows > 0) {
        $_SESSION['error_text'] = ['Data gagal dihapus.<br>Data perusahaan sudah dipakai data penggunaan material. Anda hanya bisa merubah data ini atau menghapus data penggunaan material perusahaan ini.'];
        header($location_header);
        die();
    }

    // delete
    $sql = "DELETE FROM perusahaan WHERE perusahaan_id='$id'";
    if ($connectdb->query($sql) === true) {
        $nama = $perusahaan->nama;
        $no_telp = $perusahaan->no_telp;
        $alamat = $perusahaan->alamat;
        log_pengguna([
            'log'      => 'Hapus data perusahaan',
            'log_data' => json_encode([
                'nama'    => $nama,
                'no_telp' => $no_telp,
                'alamat'  => $alamat,
            ]),
        ]);

        $_SESSION['success_text'] = ['Data perusahaan berhasil dihapus.'];
    } else {
        $_SESSION['error_text'] = ['Data tidak bisa dihapus. Kegagalan sistem. Silahkan Coba lagi!'];
    }

    header($location_header);
    die();
}

/*
 * Hapus Data Material
 * ============================================================================
 */
if ($lihat == 'data_material' && $metode == 'hapus') {
    global $id;

    $location_header = 'Location: '.$config['base_url'].'/admin?lihat=data_material';

    // check exists
    $sql = "SELECT * FROM material WHERE id='$id'";
    $hasil = $connectdb->query($sql);
    $material = $hasil->fetch_array(MYSQLI_ASSOC);
    if ($hasil->num_rows < 1) {
        $_SESSION['error_text'] = ['Data material tidak ditemukan.'];
        header($location_header);
        die();
    }

    // check sudah dipakai oleh penggunaan material
    $sql = "SELECT * FROM pengguna_material WHERE id_material='$id'";
    $hasil = $connectdb->query($sql);
    if ($hasil->num_rows > 0) {
        $_SESSION['error_text'] = ['Data gagal dihapus.<br>Data material sudah dipakai data penggunaan material. Anda hanya bisa merubah data ini atau menghapus data penggunaan material pengguna material ini.'];
        header($location_header);
        die();
    }

    // delete
    $sql = "DELETE FROM material WHERE id='$id'";
    if ($connectdb->query($sql) === true) {
        $kode_material = $material->kode_material;
        $nm_material = $material->nm_material;
        log_pengguna([
            'log'      => 'Hapus data material',
            'log_data' => json_encode([
                'kode_material' => $kode_material,
                'nm_material'   => $nm_material,
            ]),
        ]);

        $_SESSION['success_text'] = ['Data material berhasil dihapus.'];
    } else {
        $_SESSION['error_text'] = ['Data tidak bisa dihapus. Kegagalan sistem. Silahkan Coba lagi!'];
    }

    header($location_header);
    die();
}

/*
 * Hapus Data Peminjaman Kunci
 * ============================================================================
 */
if ($lihat == 'data_peminjaman_kunci' && $metode == 'hapus') {
    global $id;

    $location_header = 'Location: '.$config['base_url'].'/admin?lihat=data_peminjaman_kunci';

    // check exists
    $sql = "SELECT * FROM pinjam_kunci WHERE id='$id'";
    $hasil = $connectdb->query($sql);
    if ($hasil->num_rows < 1) {
        $_SESSION['error_text'] = ['Data peminjaman kunci tidak ditemukan.'];
        header($location_header);
        die();
    }

    // delete
    $sql = "UPDATE pinjam_kunci SET terhapus='1' WHERE id='$id'";
    if ($connectdb->query($sql) === true) {
        $_SESSION['success_text'] = ['Data peminjaman kunci berhasil dihapus. Data masih tersimpan dengan status dihapus.'];
    } else {
        error_log('Error hapus data peminjaman kunci. '.$connectdb->error);
        $_SESSION['error_text'] = ['Data tidak bisa dihapus. Kegagalan sistem. Silahkan Coba lagi!'];
    }

    header($location_header);
    die();
}

/*
 * Hapus Selamanya Data Peminjaman Kunci
 * ============================================================================
 */
if ($lihat == 'data_peminjaman_kunci' && $metode == 'hapus_selamanya') {
    global $id;

    $location_header = 'Location: '.$config['base_url'].'/admin?lihat=data_peminjaman_kunci';

    // check exists
    $sql = "SELECT * FROM pinjam_kunci WHERE id='$id'";
    $hasil = $connectdb->query($sql);
    if ($hasil->num_rows < 1) {
        $_SESSION['error_text'] = ['Data peminjaman kunci tidak ditemukan.'];
        header($location_header);
        die();
    }

    // delete
    $sql = "DELETE FROM pinjam_kunci WHERE id='$id'";
    if ($connectdb->query($sql) === true) {
        $_SESSION['success_text'] = ['Data peminjaman kunci berhasil dihapus selamanya.'];
    } else {
        error_log('Error hapus data peminjaman kunci. '.$connectdb->error);
        $_SESSION['error_text'] = ['Data tidak bisa dihapus. Kegagalan sistem. Silahkan Coba lagi!'];
    }

    header($location_header);
    die();
}

/*
 * Hapus Selamanya Data Peminjaman Kunci
 * ============================================================================
 */
if ($lihat == 'data_peminjaman_kunci' && $metode == 'aktifkan') {
    global $id;

    $location_header = 'Location: '.$config['base_url'].'/admin?lihat=data_peminjaman_kunci';

    // check exists
    $sql = "SELECT * FROM pinjam_kunci WHERE id='$id'";
    $hasil = $connectdb->query($sql);
    if ($hasil->num_rows < 1) {
        $_SESSION['error_text'] = ['Data peminjaman kunci tidak ditemukan.'];
        header($location_header);
        die();
    }

    // update
    $sql = "UPDATE pinjam_kunci SET terhapus='0' WHERE id='$id'";
    if ($connectdb->query($sql) === true) {
        $_SESSION['success_text'] = ['Data peminjaman kunci berhasil diaktifkan kembali.'];
    } else {
        error_log('Error hapus data peminjaman kunci. '.$connectdb->error);
        $_SESSION['error_text'] = ['Data tidak bisa dihapus. Kegagalan sistem. Silahkan Coba lagi!'];
    }

    header($location_header);
    die();
}

/*
 * Hapus Data Pengunaan Material
 * ============================================================================
 */
if ($lihat == 'data_penggunaan_material' && $metode == 'hapus') {
    global $id;

    $location_header = 'Location: '.$config['base_url'].'/admin?lihat=data_penggunaan_material';

    // check exists
    $sql = "SELECT * FROM pengguna_material WHERE id='$id'";
    $hasil = $connectdb->query($sql);
    if ($hasil->num_rows < 1) {
        $_SESSION['error_text'] = ['Data pengunaan material tidak ditemukan.'];
        header($location_header);
        die();
    }

    // delete
    $sql = "DELETE FROM pengguna_material WHERE id='$id'";
    if ($connectdb->query($sql) === true) {
        $pengguna_material = $hasil->fetch_array(MYSQLI_ASSOC);
        unset($pengguna_material['tgl_dibuat']);
        unset($pengguna_material['dibuat_oleh']);
        log_pengguna([
            'log'      => 'Hapus data penggunaan material',
            'log_data' => json_encode($pengguna_material),
        ]);
        $_SESSION['success_text'] = ['Data pengunaan material berhasil dihapus.'];
    } else {
        error_log('Error hapus data pengunaan material. '.$connectdb->error);
        $_SESSION['error_text'] = ['Data tidak bisa dihapus. Kegagalan sistem. Silahkan Coba lagi!'];
    }

    header($location_header);
    die();
}
