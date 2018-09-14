<?php
global $metode;
global $lihat;

// input perusahaan
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
