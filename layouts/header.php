<?php
// session_start();

// include_once('config/koneksi.php');
// require_once('config/base_url.php');

// $waktu_akses = date('Y-m-d H:i:s');
// if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '') {
//     $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
// } else {
//     $ip_address = $_SERVER['REMOTE_ADDR'];
// }

// $_SESSION['last_activity'] = $waktu_akses;

// if ($ip_address != '10.29.254.234') {
//     $query_log = mysqli_prepare($config_mysql, "INSERT INTO log_akses (waktu_akses, ip_address) VALUES (?, ?)");
//     mysqli_stmt_bind_param($query_log, "ss", $waktu_akses, $ip_address);
//     mysqli_stmt_execute($query_log);
//     mysqli_stmt_close($query_log);
// }

// mysqli_close($config_mysql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIG | Kalselteng</title>

    <!-- css bootstrap -->
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/bootstrap.css" />
    <!-- css custom -->
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/style.css" />
    <!-- css leaflet -->
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/leaflet.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/leaflet-autocomplete.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/leaflet-control.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/leaflet-coordinates.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/leaflet-fullscreen.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/leaflet-layergroup.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/leaflet-loader.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/leaflet-minimap.css" />
    <!-- <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/leaflet-panel-layers.css" /> -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">


    <!-- js bootstrap -->
    <script src="<?= base_url(); ?>/assets/js/bootstrap.js"></script>
    <!-- js sweetalert2 -->
    <script src="<?= base_url(); ?>/assets/js/sweetalert2.js"></script>
    <!-- js leaflet -->
    <script src="<?= base_url(); ?>/assets/js/leaflet.js"></script>
    <script src="<?= base_url(); ?>/assets/js/leaflet-autocomplete.js"></script>
    <script src="<?= base_url(); ?>/assets/js/leaflet-control.js"></script>
    <script src="<?= base_url(); ?>/assets/js/leaflet-coordinates.js"></script>
    <script src="<?= base_url(); ?>/assets/js/leaflet-fullscreen.js"></script>
    <script src="<?= base_url(); ?>/assets/js/leaflet-layergroup.js"></script>
    <script src="<?= base_url(); ?>/assets/js/leaflet-loader.js"></script>
    <script src="<?= base_url(); ?>/assets/js/leaflet-minimap.js"></script>
    <!-- <script src="<?= base_url(); ?>/assets/js/leaflet-panel-layers.js"></script> -->
</head>

<body>
