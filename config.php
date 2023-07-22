<?php 
    define('DB_SERWER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'scam_and_run');

    $link = mysqli_connect(DB_SERWER, DB_USERNAME, DB_PASSWORD, DB_NAME,);

    if ($link === FALSE) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
?>