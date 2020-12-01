<?php
define("SITE_PATH", getcwd());
$termid = 0;
if( isset($_COOKIE["tid"]) ) {
    $termid = $_COOKIE["tid"];
} else {
    $termid = date("His") . "0";
    setcookie("tid",$termid,time()+3600*24*365);
}
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>KRONA | Gestione Magazzino</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
<!--    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">-->
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap4-toggle.css">
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!--    <link rel="stylesheet" href="dist/css/pulldelete.css">-->

    <?php include_once(SITE_PATH . '/libs/apiObj.php'); ?>
    <?php include_once(SITE_PATH . '/config/global_config.php'); ?>

    <?php include_once "scripts.php"; ?>
    <?php include_once "plugins\php-barcode-generator-master\BarcodeGenerator.php"; ?>
    <?php include_once "plugins\php-barcode-generator-master\BarcodeGeneratorHTML.php"; ?>
    <?php include_once "plugins\php-barcode-generator-master\BarcodeGeneratorJPG.php"; ?>
    <?php include_once "plugins\php-barcode-generator-master\BarcodeGeneratorPNG.php"; ?>
    <?php include_once "plugins\php-barcode-generator-master\BarcodeGeneratorSVG.php"; ?>
</head>
