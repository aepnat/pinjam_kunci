<?php

function ambil_data_situs()
{
    $file_konten = 'home.php';
    $halaman_judul = 'Home';
    $menu_aktif = 'home';
    $halaman_deskripsi = 'Selamat Datang';

    $lihat = (isset($_GET['lihat'])) ? $_GET['lihat'] : '';

    if ($lihat == 'data_peminjaman_kunci') {

        $file_konten = "data_peminjaman_kunci.php";
        $halaman_judul = 'Data Peminjaman Kunci';
        $menu_aktif = 'data_peminjaman_kunci';
        $halaman_deskripsi = 'Mengelola data peminjaman kunci';

    } elseif ($lihat == 'data_penggunaan_material') {

        $file_konten =  "data_penggunaan_material.php";
        $halaman_judul = 'Data Penggunaan Material';
        $menu_aktif = 'data_penggunaan_material';
        $halaman_deskripsi = 'Mengelola data penggunaan material';

    } elseif ($lihat == 'data_perusahaan') {

        $file_konten =  "data_perusahaan.php";
        $halaman_judul = 'Data Perusahaan';
        $menu_aktif = 'data_perusahaan';
        $halaman_deskripsi = 'Mengelola data perusahaan';

    } elseif ($lihat == 'registrasi_peminjaman_kunci') {

        $file_konten =  "registrasi_peminjaman_kunci.php";
        $halaman_judul = 'Registrasi Peminjaman Kunci';
        $menu_aktif = 'registrasi_peminjaman_kunci';
        $halaman_deskripsi = 'Melakukan entri data peminjaman kunci';

    } elseif ($lihat == 'registrasi_penggunaan_material') {

        $file_konten =  "registrasi_penggunaan_material.php";
        $halaman_judul = 'Registrasi Penggunaan Material';
        $menu_aktif = 'registrasi_penggunaan_material';
        $halaman_deskripsi = 'Melakukan entri data pengunaan material';

    } elseif ($lihat == 'registrasi_perusahaan') {

        $file_konten =  "registrasi_perusahaan.php";
        $halaman_judul = 'Registrasi Perusahaan';
        $menu_aktif = 'registrasi_perusahaan';
        $halaman_deskripsi = 'Melakukan entri data perusahaan';

    }
    $file_konten = 'lihat/' . $file_konten;

    return array(
        'file_konten' => $file_konten,
        'halaman_judul' => $halaman_judul,
        'halaman_deskripsi' => $halaman_deskripsi,
        'menu_aktif' => $menu_aktif
    );
}
