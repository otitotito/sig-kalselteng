<?php
$hostname_mysql      = "10.29.254.216";
$username_mysql      = "root";
$password_mysql      = "GasanPian240";

$database_mysql = "gis";
$config_mysql   = mysqli_connect($hostname_mysql, $username_mysql, $password_mysql, $database_mysql);

if (mysqli_connect_errno()) {
    echo "Maria Gagal: " . mysqli_connect_error();
}

date_default_timezone_set('Asia/Jakarta');
