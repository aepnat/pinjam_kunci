<?php
session_start();

include 'config/config.php';

session_destroy();

header('Location:' . $config['base_url']);
