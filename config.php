<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "scam_and_run";

    $conn = mysqli_connect($servername, $username, $password, $database);

    if (!$conn) {
        die("Connection failed: ");
    }
?>