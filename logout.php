<?php

session_start();

include 'config/config.php';
include 'config/database.php';
require_once 'fungsi/fungsi_pengguna.php';

log_pengguna('Logout dari Aplikasi');

session_destroy();

header('Location:'.$config['base_url']);
