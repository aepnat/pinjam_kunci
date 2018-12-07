<?php
require_once('fungsi_pengguna.php');

global $metode;
global $lihat;

/**
 * Input Perusahaan
 * ============================================================================
 */
if ($metode == 'input_perusahaan' || ($lihat == 'data_perusahaan' && $metode == 'edit' && isset($_POST['metode2']))) {
    // Validasi
    $fields = array(
        'nama' => array(
            'label' => 'Nama',
            'max' => 80
        ),
        'no_telp' => array(
            'label' => 'No. Telepon',
            'max' => 20
        ),
        'alamat' => array(
            'label' => 'Alamat',
            'max' => 200
        )
    );
    $error_text = array();
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
    if(empty($error_text)) {
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
        $tgl_dibuat = date("Y-m-d H:i:s");
        $dibuat_oleh = $_SESSION['pengguna_id'];

        if ($is_edit) {
            $perusahaan_id = $_POST['id'];
            $sql = "UPDATE perusahaan SET nama='$nama', no_telp='$no_telp', alamat='$alamat' WHERE perusahaan_id='$perusahaan_id'";
            $sukses_text[] = 'Berhasil menyimpan data perusahaan';
        } else {
            $sql = "INSERT INTO perusahaan (nama, no_telp, alamat, tgl_dibuat, dibuat_oleh) VALUES ('$nama', '$no_telp', '$alamat', '$tgl_dibuat', '$dibuat_oleh')";
            $sukses_text[] = 'Berhasil menambah data perusahaan';
        }

        if ($connectdb->query($sql) === TRUE) {
            log_pengguna(array(
                'log' => ($is_edit) ? 'Ubah data perusahaan' : 'Tambah data perusahaan',
                'log_data' => json_encode(array(
                    'nama' => $nama,
                    'no_telp' => $no_telp,
                    'alamat' => $alamat
                )),
            ));
            $_SESSION['success_text'] = $sukses_text;
            header('Location:' . $config['base_url'] . '/admin?lihat=data_perusahaan');
            exit();
        } else {
            $error_text[] = 'Data tidak bisa ditambah. Kegagalan sistem. Silahkan Coba lagi!';
        }
    }

    if (!empty($error_text)) {
        $_SESSION['error_text'] = $error_text;
    }
}

/**
 * Input Material
 * ============================================================================
 */
if ($metode == 'input_material' || ($lihat == 'data_material' && $metode == 'edit' && isset($_POST['metode2']))) {
    // Validasi
    $fields = array(
        'kode_material' => array(
            'label' => 'Kode Materials',
            'max' => 80
        ),
        'nm_material' => array(
            'label' => 'Nama Material',
            'max' => 120
        )
    );
    $error_text = array();
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
    if(empty($error_text)) {
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
        $tgl_dibuat = date("Y-m-d H:i:s");
        $dibuat_oleh = $_SESSION['pengguna_id'];

        if ($is_edit) {
            $id = $_POST['id'];
            $sql = "UPDATE material SET kode_material='$kode_material', nm_material='$nm_material' WHERE id='$id'";
            $sukses_text[] = 'Berhasil menyimpan data material';
        } else {
            $sql = "INSERT INTO material (kode_material, nm_material, tgl_dibuat, dibuat_oleh) VALUES ('$kode_material', '$nm_material', '$tgl_dibuat', '$dibuat_oleh')";
            $sukses_text[] = 'Berhasil menambah data material';
        }

        if ($connectdb->query($sql) === TRUE) {
            log_pengguna(array(
                'log' => ($is_edit) ? 'Ubah data material' : 'Tambah data material',
                'log_data' => json_encode(array(
                    'kode_material' => $kode_material,
                    'nm_material' => $nm_material
                )),
            ));
            $_SESSION['success_text'] = $sukses_text;
            header('Location:' . $config['base_url'] . '/admin?lihat=data_material');
            exit();
        } else {
            $error_text[] = 'Data tidak bisa ditambah. Kegagalan sistem. Silahkan Coba lagi!';
        }
    }

    if (!empty($error_text)) {
        $_SESSION['error_text'] = $error_text;
    }
}


/**
 * Input Peminjaman Kunci
 * ============================================================================
 */
if ($metode == 'input_peminjaman_kunci' || ($lihat == 'data_peminjaman_kunci' && $metode == 'edit' && isset($_POST['metode2']))) {
    // Validasi
    $fields = array(
        'kode_kunci' => array(
            'label' => 'Kode Kunci',
            'max' => 15
        ),
        'tujuan' => array(
            'label' => 'Tujuan',
            'max' => 80
        ),
        'jenis_pekerjaan' => array(
            'label' => 'Jenis Pekerjaans',
            'max' => 30
        ),
        'jenis_id' => array(
            'label' => 'Jenis ID',
            'max' => 10
        ),
        'no_id' => array(
            'label' => 'Nomor ID',
            'max' => 30
        ),
        'nm_peminjam' => array(
            'label' => 'Nama Peminjam',
            'max' => 80
        ),
        'no_telp_peminjam' => array(
            'label' => 'No. Telp. Peminjam',
            'max' => 15
        ),
        'email_peminjam' => array(
            'label' => 'Email Peminjam',
            'max' => 30
        ),
        'perusahaan_id' => array(
            'label' => 'Perusahaan',
            'max' => 11
        ),
    );
    $error_text = array();
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
            $wkt_peminjaman = date("Y-m-d H:i:s");
            $dibuat_oleh = $_SESSION['pengguna_id'];
            $sql = "INSERT INTO pinjam_kunci (kode_kunci, tujuan, jenis_pekerjaan, jenis_id, no_id, nm_peminjam, no_telp_peminjam, email_peminjam, perusahaan_id, wkt_peminjaman, dibuat_oleh)
            VALUES ('$kode_kunci', '$tujuan', '$jenis_pekerjaan', '$jenis_id', '$no_id', '$nm_peminjam', '$no_telp_peminjam', '$email_peminjam', '$perusahaan_id', '$wkt_peminjaman', '$dibuat_oleh')";
            $sukses_text[] = 'Berhasil menambah data peminjaman kunci';
        }

        if ($connectdb->query($sql) === TRUE) {
            log_pengguna(array(
                'log' => ($is_edit) ? 'Ubah data peminjaman kunci' : 'Tambah data peminjaman kunci',
                'log_data' => json_encode(array(
                    'kode_kunci' => $kode_kunci,
                    'tujuan' => $tujuan,
                    'jenis_pekerjaan' => $jenis_pekerjaan,
                    'jenis_id' => $jenis_id,
                    'no_id' => $no_id,
                    'nm_peminjam' => $nm_peminjam,
                    'no_telp_peminjam' => $no_telp_peminjam,
                    'email_peminjam' => $email_peminjam,
                    'perusahaan_id' => $perusahaan_id,
                )),
            ));
            $_SESSION['success_text'] = $sukses_text;
            header('Location:' . $config['base_url'] . '/admin?lihat=data_peminjaman_kunci');
            exit();
        } else {
            error_log('Error menambah registrasi peminjaman kunci. ' . $connectdb->error);
            $error_text[] = 'Data tidak bisa ditambah. Kegagalan sistem. Silahkan Coba lagi!';
        }
    }

    if (!empty($error_text)) {
        $_SESSION['error_text'] = $error_text;
    }
}

/**
 * Input Pengunaan Material
 * ============================================================================
 */
if ($metode == 'input_penggunaan_material' || ($lihat == 'data_penggunaan_material' && $metode == 'edit' && isset($_POST['metode2']))) {
    // Validasi
    $fields = array(
        'jenis_id' => array(
            'label' => 'Jenis ID',
            'max' => 10
        ),
        'no_id' => array(
            'label' => 'Nomor ID',
            'max' => 30
        ),
        'nm_pengguna' => array(
            'label' => 'Nama Pengguna',
            'max' => 80
        ),
        'no_telp_pengguna' => array(
            'label' => 'No. Telp. Pengguna',
            'max' => 15
        ),
        'email_pengguna' => array(
            'label' => 'Email Pengguna',
            'max' => 30
        ),
        'perusahaan_id' => array(
            'label' => 'Perusahaan',
            'max' => 11
        ),
        'id_material' => array(
            'label' => 'Material',
            'max' => 11
        ),
    );
    $error_text = array();
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
        $jenis_id = $_POST['jenis_id'];
        $no_id = $_POST['no_id'];
        $nm_pengguna = $_POST['nm_pengguna'];
        $no_telp_pengguna = $_POST['no_telp_pengguna'];
        $email_pengguna = $_POST['email_pengguna'];
        $perusahaan_id = $_POST['perusahaan_id'];
        $id_material = $_POST['id_material'];

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
                    WHERE id='$id'";
            $sukses_text[] = 'Berhasil menyimpan data penggunaan material';
        } else {
            $wkt_dibuat = date("Y-m-d H:i:s");
            $dibuat_oleh = $_SESSION['pengguna_id'];
            $sql = "INSERT INTO pengguna_material (jenis_id, no_id, nm_pengguna, no_telp_pengguna, email_pengguna, perusahaan_id, id_material, tgl_dibuat, dibuat_oleh)
            VALUES ('$jenis_id', '$no_id', '$nm_pengguna', '$no_telp_pengguna', '$email_pengguna', '$perusahaan_id', '$id_material', '$wkt_dibuat', '$dibuat_oleh')";
            $sukses_text[] = 'Berhasil menambah data penggunaan material';
        }

        if ($connectdb->query($sql) === TRUE) {
            log_pengguna(array(
                'log' => ($is_edit) ? 'Ubah data penggunaan material' : 'Tambah data penggunaan material',
                'log_data' => json_encode(array(
                    'jenis_id' => $jenis_id,
                    'no_id' => $no_id,
                    'nm_pengguna' => $nm_pengguna,
                    'no_telp_pengguna' => $no_telp_pengguna,
                    'email_pengguna' => $email_pengguna,
                    'perusahaan_id' => $perusahaan_id,
                    'id_material' => $id_material,
                )),
            ));
            $_SESSION['success_text'] = $sukses_text;
            header('Location:' . $config['base_url'] . '/admin?lihat=data_penggunaan_material');
            exit();
        } else {
            error_log('Error registrasi penggunaan material. ' . $connectdb->error);
            $error_text[] = 'Data tidak bisa ditambah. Kegagalan sistem. Silahkan Coba lagi!';
        }
    }

    if (!empty($error_text)) {
        $_SESSION['error_text'] = $error_text;
    }
}

/**
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
        $wkt_selesai = date("Y-m-d H:i:s");
        $sql = "UPDATE pinjam_kunci SET wkt_selesai='$wkt_selesai' WHERE id='$id'";

        if ($connectdb->query($sql) === TRUE) {
            $_SESSION['success_text'] = array('Data peminjaman kunci sudah diselesaikan');
        } else {
            error_log('Error selesai data peminjaman kunci. ' . $connectdb->error);
            $_SESSION['error_text'] = array('Data tidak bisa diselesaikan. Kegagalan sistem. Silahkan Coba lagi!');
        }
    } else {
        $_SESSION['error_text'] = array('Data Peminjaman Kunci tidak ditemukan.');
    }

    header('Location: ' . $config['base_url'] . '/admin?lihat=data_peminjaman_kunci');
    die();
}

/**
 * Hapus Data Perusahaan
 * ============================================================================
 */
if ($lihat == 'data_perusahaan' && $metode == 'hapus') {
    global $id;

    $location_header = 'Location: ' . $config['base_url'] . '/admin?lihat=data_perusahaan';

    // check exists
    $sql = "SELECT * FROM perusahaan WHERE perusahaan_id='$id'";
    $hasil = $connectdb->query($sql);
    $perusahaan = $hasil->fetch_array(MYSQLI_ASSOC);
    if ($hasil->num_rows < 1) {
        $_SESSION['error_text'] = array('Data perusahaan tidak ditemukan.');
        header($location_header);
        die();
    }

    // check sudah dipakai oleh peminjaman kunci
    $sql = "SELECT * FROM pinjam_kunci WHERE perusahaan_id='$id'";
    $hasil = $connectdb->query($sql);
    if ($hasil->num_rows > 0) {
        $_SESSION['error_text'] = array('Data gagal dihapus.<br>Data perusahaan sudah dipakai data peminjaman kunci. Anda hanya bisa merubah data ini atau menghapus data peminjaman kunci perusahaan ini.');
        header($location_header);
        die();
    }

    // check sudah dipakai oleh penggunaan material
    $sql = "SELECT * FROM pengguna_material WHERE perusahaan_id='$id'";
    $hasil = $connectdb->query($sql);
    if ($hasil->num_rows > 0) {
        $_SESSION['error_text'] = array('Data gagal dihapus.<br>Data perusahaan sudah dipakai data penggunaan material. Anda hanya bisa merubah data ini atau menghapus data penggunaan material perusahaan ini.');
        header($location_header);
        die();
    }

    // delete
    $sql = "DELETE FROM perusahaan WHERE perusahaan_id='$id'";
    if ($connectdb->query($sql) === TRUE) {
        $nama = $perusahaan->nama;
        $no_telp = $perusahaan->no_telp;
        $alamat = $perusahaan->alamat;
        log_pengguna(array(
            'log' => 'Hapus data perusahaan',
            'log_data' => json_encode(array(
                'nama' => $nama,
                'no_telp' => $no_telp,
                'alamat' => $alamat,
            )),
        ));

        $_SESSION['success_text'] = array('Data perusahaan berhasil dihapus.');
    } else {
        $_SESSION['error_text'] = array('Data tidak bisa dihapus. Kegagalan sistem. Silahkan Coba lagi!');
    }

    header($location_header);
    die();
}

/**
 * Hapus Data Material
 * ============================================================================
 */
if ($lihat == 'data_material' && $metode == 'hapus') {
    global $id;

    $location_header = 'Location: ' . $config['base_url'] . '/admin?lihat=data_material';

    // check exists
    $sql = "SELECT * FROM material WHERE id='$id'";
    $hasil = $connectdb->query($sql);
    $material = $hasil->fetch_array(MYSQLI_ASSOC);
    if ($hasil->num_rows < 1) {
        $_SESSION['error_text'] = array('Data material tidak ditemukan.');
        header($location_header);
        die();
    }

    // check sudah dipakai oleh penggunaan material
    $sql = "SELECT * FROM pengguna_material WHERE id_material='$id'";
    $hasil = $connectdb->query($sql);
    if ($hasil->num_rows > 0) {
        $_SESSION['error_text'] = array('Data gagal dihapus.<br>Data material sudah dipakai data penggunaan material. Anda hanya bisa merubah data ini atau menghapus data penggunaan material pengguna material ini.');
        header($location_header);
        die();
    }

    // delete
    $sql = "DELETE FROM material WHERE id='$id'";
    if ($connectdb->query($sql) === TRUE) {
        $kode_material = $material->kode_material;
        $nm_material = $material->nm_material;
        log_pengguna(array(
            'log' => 'Hapus data material',
            'log_data' => json_encode(array(
                'kode_material' => $kode_material,
                'nm_material' => $nm_material,
            )),
        ));

        $_SESSION['success_text'] = array('Data material berhasil dihapus.');
    } else {
        $_SESSION['error_text'] = array('Data tidak bisa dihapus. Kegagalan sistem. Silahkan Coba lagi!');
    }

    header($location_header);
    die();
}

/**
 * Hapus Data Peminjaman Kunci
 * ============================================================================
 */
if ($lihat == 'data_peminjaman_kunci' && $metode == 'hapus') {
    global $id;

    $location_header = 'Location: ' . $config['base_url'] . '/admin?lihat=data_peminjaman_kunci';

    // check exists
    $sql = "SELECT * FROM pinjam_kunci WHERE id='$id'";
    $hasil = $connectdb->query($sql);
    if ($hasil->num_rows < 1) {
        $_SESSION['error_text'] = array('Data peminjaman kunci tidak ditemukan.');
        header($location_header);
        die();
    }

    // delete
    $sql = "UPDATE pinjam_kunci SET terhapus='1' WHERE id='$id'";
    if ($connectdb->query($sql) === TRUE) {
        $_SESSION['success_text'] = array('Data peminjaman kunci berhasil dihapus. Data masih tersimpan dengan status dihapus.');
    } else {
        error_log('Error hapus data peminjaman kunci. ' . $connectdb->error);
        $_SESSION['error_text'] = array('Data tidak bisa dihapus. Kegagalan sistem. Silahkan Coba lagi!');
    }

    header($location_header);
    die();
}

/**
 * Hapus Selamanya Data Peminjaman Kunci
 * ============================================================================
 */
if ($lihat == 'data_peminjaman_kunci' && $metode == 'hapus_selamanya') {
    global $id;

    $location_header = 'Location: ' . $config['base_url'] . '/admin?lihat=data_peminjaman_kunci';

    // check exists
    $sql = "SELECT * FROM pinjam_kunci WHERE id='$id'";
    $hasil = $connectdb->query($sql);
    if ($hasil->num_rows < 1) {
        $_SESSION['error_text'] = array('Data peminjaman kunci tidak ditemukan.');
        header($location_header);
        die();
    }

    // delete
    $sql = "DELETE FROM pinjam_kunci WHERE id='$id'";
    if ($connectdb->query($sql) === TRUE) {
        $_SESSION['success_text'] = array('Data peminjaman kunci berhasil dihapus selamanya.');
    } else {
        error_log('Error hapus data peminjaman kunci. ' . $connectdb->error);
        $_SESSION['error_text'] = array('Data tidak bisa dihapus. Kegagalan sistem. Silahkan Coba lagi!');
    }

    header($location_header);
    die();
}

/**
 * Hapus Selamanya Data Peminjaman Kunci
 * ============================================================================
 */
if ($lihat == 'data_peminjaman_kunci' && $metode == 'aktifkan') {
    global $id;

    $location_header = 'Location: ' . $config['base_url'] . '/admin?lihat=data_peminjaman_kunci';

    // check exists
    $sql = "SELECT * FROM pinjam_kunci WHERE id='$id'";
    $hasil = $connectdb->query($sql);
    if ($hasil->num_rows < 1) {
        $_SESSION['error_text'] = array('Data peminjaman kunci tidak ditemukan.');
        header($location_header);
        die();
    }

    // update
    $sql = "UPDATE pinjam_kunci SET terhapus='0' WHERE id='$id'";
    if ($connectdb->query($sql) === TRUE) {
        $_SESSION['success_text'] = array('Data peminjaman kunci berhasil diaktifkan kembali.');
    } else {
        error_log('Error hapus data peminjaman kunci. ' . $connectdb->error);
        $_SESSION['error_text'] = array('Data tidak bisa dihapus. Kegagalan sistem. Silahkan Coba lagi!');
    }

    header($location_header);
    die();
}

/**
 * Hapus Data Pengunaan Material
 * ============================================================================
 */
if ($lihat == 'data_penggunaan_material' && $metode == 'hapus') {
    global $id;

    $location_header = 'Location: ' . $config['base_url'] . '/admin?lihat=data_penggunaan_material';

    // check exists
    $sql = "SELECT * FROM pengguna_material WHERE id='$id'";
    $hasil = $connectdb->query($sql);
    if ($hasil->num_rows < 1) {
        $_SESSION['error_text'] = array('Data pengunaan material tidak ditemukan.');
        header($location_header);
        die();
    }

    // delete
    $sql = "DELETE FROM pengguna_material WHERE id='$id'";
    if ($connectdb->query($sql) === TRUE) {
        $pengguna_material = $hasil->fetch_array(MYSQLI_ASSOC);
        unset($pengguna_material['tgl_dibuat']);
        unset($pengguna_material['dibuat_oleh']);
        log_pengguna(array(
            'log' => 'Hapus data penggunaan material',
            'log_data' => json_encode($pengguna_material),
        ));
        $_SESSION['success_text'] = array('Data pengunaan material berhasil dihapus.');
    } else {
        error_log('Error hapus data pengunaan material. ' . $connectdb->error);
        $_SESSION['error_text'] = array('Data tidak bisa dihapus. Kegagalan sistem. Silahkan Coba lagi!');
    }

    header($location_header);
    die();
}
