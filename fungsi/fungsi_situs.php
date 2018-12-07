<?php

require_once '../config/config.php';

$file_konten = 'home.php';
$halaman_judul = 'Home';
$menu_aktif = 'home';
$halaman_deskripsi = 'Selamat Datang';

global $lihat;
$lihat = (isset($_GET['lihat'])) ? $_GET['lihat'] : '';
$lihat = (isset($_POST['lihat']) && $lihat == '') ? $_POST['lihat'] : $lihat;

global $metode;
$metode = (isset($_GET['metode'])) ? $_GET['metode'] : '';
$metode = (isset($_POST['metode']) && $metode == '') ? $_POST['metode'] : $metode;

global $id;
$id = (isset($_GET['id'])) ? $_GET['id'] : '';
$id = (isset($_POST['id']) && $id == '') ? $_POST['id'] : $id;

// Data Peminjaman Kunci
if ($lihat == 'data_peminjaman_kunci') {
    $file_konten = 'data_peminjaman_kunci.php';
    $halaman_judul = 'Data Peminjaman Kunci';
    $menu_aktif = 'data_peminjaman_kunci';
    $halaman_deskripsi = 'Mengelola data peminjaman kunci';

    if ($metode == 'detail' && $id != '') {
        $file_konten = 'detail_peminjaman_kunci.php';
        $halaman_judul = 'Detail Peminjaman Kunci';
        $halaman_deskripsi = 'Melihat detail data peminjaman kunci';
    }

    if ($metode == 'edit' && $id != '') {
        $file_konten = 'registrasi_peminjaman_kunci.php';
        $halaman_judul = 'Ubah Peminjaman Kunci';
        $halaman_deskripsi = 'Mengubah data peminjaman kunci';
    }

    // Data Penggunaan Material
} elseif ($lihat == 'data_penggunaan_material') {
    $file_konten = 'data_penggunaan_material.php';
    $halaman_judul = 'Data Penggunaan Material';
    $menu_aktif = 'data_penggunaan_material';
    $halaman_deskripsi = 'Mengelola data penggunaan material';

    if ($metode == 'detail' && $id != '') {
        $file_konten = 'detail_penggunaan_material.php';
        $halaman_judul = 'Detail Penggunaan Material';
        $halaman_deskripsi = 'Melihat detail data penggunaan material';
    }

    if ($metode == 'edit' && $id != '') {
        $file_konten = 'registrasi_penggunaan_material.php';
        $halaman_judul = 'Ubah Penggunaan Material';
        $halaman_deskripsi = 'Mengubah data penggunaan material';
    }

    // Data Perusahaan
} elseif ($lihat == 'data_perusahaan') {
    $file_konten = 'data_perusahaan.php';
    $halaman_judul = 'Data Perusahaan';
    $menu_aktif = 'data_perusahaan';
    $halaman_deskripsi = 'Mengelola data perusahaan';

    if ($metode == 'edit' && $id != '') {
        $file_konten = 'registrasi_perusahaan.php';
        $halaman_judul = 'Ubah Perusahaan';
        $halaman_deskripsi = 'Mengubah data perusahaan';
    }

    // Data Material
} elseif ($lihat == 'data_material') {
    $file_konten = 'data_material.php';
    $halaman_judul = 'Data Material';
    $menu_aktif = 'data_material';
    $halaman_deskripsi = 'Mengelola data material';

    if ($metode == 'edit' && $id != '') {
        $file_konten = 'registrasi_material.php';
        $halaman_judul = 'Ubah Material';
        $halaman_deskripsi = 'Mengubah data material';
    }

    // Registrasi Peminjaman Kunci
} elseif ($lihat == 'registrasi_peminjaman_kunci') {
    $file_konten = 'registrasi_peminjaman_kunci.php';
    $halaman_judul = 'Registrasi Peminjaman Kunci';
    $menu_aktif = 'registrasi_peminjaman_kunci';
    $halaman_deskripsi = 'Melakukan entri data peminjaman kunci';

// Registrasi Penggunaan Material
} elseif ($lihat == 'registrasi_penggunaan_material') {
    $file_konten = 'registrasi_penggunaan_material.php';
    $halaman_judul = 'Registrasi Penggunaan Material';
    $menu_aktif = 'registrasi_penggunaan_material';
    $halaman_deskripsi = 'Melakukan entri data pengunaan material';

// Registrasi Perusahaan
} elseif ($lihat == 'registrasi_perusahaan') {
    $file_konten = 'registrasi_perusahaan.php';
    $halaman_judul = 'Registrasi Perusahaan';
    $menu_aktif = 'registrasi_perusahaan';
    $halaman_deskripsi = 'Melakukan entri data perusahaan';

// Registrasi Material
} elseif ($lihat == 'registrasi_material') {
    $file_konten = 'registrasi_material.php';
    $halaman_judul = 'Registrasi Material';
    $menu_aktif = 'registrasi_material';
    $halaman_deskripsi = 'Melakukan entri data material';
}
$file_konten = 'lihat/'.$file_konten;

$menus = [
    'home' => [
        'label'  => 'Home',
        'url'    => 'admin',
        'active' => ($menu_aktif == 'home'),
        'icon'   => 'dashboard',
    ],
    'peminjaman_kunci' => [
        'label'    => 'Peminjaman Kunci',
        'url'      => '#',
        'active'   => (in_array($menu_aktif, ['data_peminjaman_kunci', 'registrasi_peminjaman_kunci'])),
        'open'     => true,
        'icon'     => 'table',
        'submenus' => [
            'data' => [
                'label'  => 'Data',
                'icon'   => 'table',
                'url'    => 'admin?lihat=data_peminjaman_kunci',
                'active' => ($menu_aktif == 'data_peminjaman_kunci'),
            ],
            'add' => [
                'label'  => 'Registrasi',
                'icon'   => 'plus',
                'url'    => 'admin?lihat=registrasi_peminjaman_kunci',
                'active' => ($menu_aktif == 'registrasi_peminjaman_kunci'),
            ],
        ],
    ],
    'data_penggunaan_material' => [
        'label'    => 'Penggunaan Material',
        'url'      => '#',
        'active'   => (in_array($menu_aktif, ['data_penggunaan_material', 'registrasi_penggunaan_material'])),
        'open'     => true,
        'icon'     => 'table',
        'submenus' => [
            'data' => [
                'label'  => 'Data',
                'icon'   => 'table',
                'url'    => 'admin?lihat=data_penggunaan_material',
                'active' => ($menu_aktif == 'data_penggunaan_material'),
            ],
            'add' => [
                'label'  => 'Registrasi',
                'icon'   => 'plus',
                'url'    => 'admin?lihat=registrasi_penggunaan_material',
                'active' => ($menu_aktif == 'registrasi_penggunaan_material'),
            ],
        ],
    ],
    'data_material' => [
        'label'    => 'Data Material',
        'url'      => '#',
        'active'   => (in_array($menu_aktif, ['data_material', 'registrasi_material'])),
        'open'     => true,
        'icon'     => 'table',
        'submenus' => [
            'data' => [
                'label'  => 'Data',
                'icon'   => 'table',
                'url'    => 'admin?lihat=data_material',
                'active' => ($menu_aktif == 'data_material'),
            ],
            'add' => [
                'label'  => 'Registrasi',
                'icon'   => 'plus',
                'url'    => 'admin?lihat=registrasi_material',
                'active' => ($menu_aktif == 'registrasi_material'),
            ],
        ],
    ],
    'data_perusahaan' => [
        'label'    => 'Data Perusahaan',
        'url'      => '#',
        'active'   => (in_array($menu_aktif, ['data_perusahaan', 'registrasi_perusahaan'])),
        'open'     => true,
        'icon'     => 'table',
        'submenus' => [
            'data' => [
                'label'  => 'Data',
                'icon'   => 'table',
                'url'    => 'admin?lihat=data_perusahaan',
                'active' => ($menu_aktif == 'data_perusahaan'),
            ],
            'add' => [
                'label'  => 'Registrasi',
                'icon'   => 'plus',
                'url'    => 'admin?lihat=registrasi_perusahaan',
                'active' => ($menu_aktif == 'registrasi_perusahaan'),
            ],
        ],
    ],
];

// Build Menu
$menu_items = [];
foreach ($menus as $key => $menu) {
    $default_args_menu = [
        'label'    => '',
        'url'      => '',
        'active'   => false,
        'open'     => false,
        'icon'     => 'dashboard',
        'submenus' => [],
    ];
    // merge with default args
    $menu = array_merge($default_args_menu, $menu);

    // Build class
    $class = [];
    if (!empty($menu['submenus'])) {
        $class[] = 'treeview';
    }
    if ($menu['active']) {
        $class[] = 'active';
    }
    $class = implode(' ', $class);

    $link = sprintf('%s/%s', $config['base_url'], $menu['url']);

    // Build Submenus
    $submenus = '';
    if (!empty($menu['submenus'])) {
        $submenu_items = [];
        foreach ($menu['submenus'] as $submenu) {
            $default_args_submenu = [
                'label'    => '',
                'url'      => '',
                'active'   => false,
                'open'     => false,
                'icon'     => 'circle-o',
                'submenus' => [],
            ];
            // merge with default args
            $submenu = array_merge($default_args_submenu, $submenu);

            // Build class
            $class_submenu = [];
            $class_submenu[] = ($submenu['active']) ? ' active' : '';
            $class_submenu = implode(' ', $class_submenu);

            $link_submenu = sprintf('%s/%s', $config['base_url'], $submenu['url']);

            $submenu_items[] = sprintf('<li class="%s"><a href="%s"><i class="fa fa-%s"></i> <span>%s</span></a></li>', $class_submenu, $link_submenu, $submenu['icon'], $submenu['label']);
        }
        $submenus = sprintf('<ul class="treeview-menu">%s</ul>', implode('', $submenu_items));
    }
    // END Build Submenu

    $menu_items[] = sprintf('<li class="%s"><a href="%s"><i class="fa fa-%s"></i> <span>%s</span></a>%s</li>', $class, $link, $menu['icon'], $menu['label'], $submenus);
}
