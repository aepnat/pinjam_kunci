<?php

$db['host'] = 'localhost';
$db['username'] = 'root';
$db['password'] = 'root';
$db['database_name'] = 'db_pinjam_kunci';

$connectdb = new mysqli($db['host'], $db['username'], $db['password'], $db['database_name']);

// Check connection
if ($connectdb->connect_error) {
    die("Connection failed: " . $connectdb->connect_error);
}
