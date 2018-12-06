<?php
if (! function_exists('log_pengguna')) {
    function log_pengguna($log, $pengguna_id = NULL)
    {
        global $connectdb;

        $time = time();

        if ($pengguna_id == NULL) {
            $pengguna_id = $_SESSION['pengguna_id'];
        }
        
        if ($pengguna_id == NULL) {
            return false;
        }

        $log_data = NULL;
        if (is_array($log)) {
            $log_data = $log['log_data'];
            $log = $log['log'];
        }

        $ip = $_SERVER['REMOTE_ADDR'];
        $browser = $_SERVER['HTTP_USER_AGENT'];
        $sql = "INSERT INTO `log_pengguna` (`pengguna_id`,`time`,`ip`,`browser`,`log`,`log_data`) VALUES ('$pengguna_id', '$time', '$ip', '$browser', '$log', '$log_data')";
        $connectdb->query($sql);
    }   
}