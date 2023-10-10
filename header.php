<?php
include "config.php";
session_start();
if(!isset($_SESSION['username'])){
	?>
<script>
window.location.assign("login.php")
</script>
<?php
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Sistem Pengambil Keputusan | SMART</title>
    <link href="css/metro.css" rel="stylesheet">
    <link href="css/metro-icons.css" rel="stylesheet">
    <link href="css/metro-schemes.css" rel="stylesheet">
    <link href="css/metro-responsive.css" rel="stylesheet">

    <script src="js/myjs.js"></script>
</head>

<body>
    <div class="app-bar">
        <a class="app-bar-element" href="index.php">SPK Metode SMART</a>
        <span class="app-bar-divider"></span>
        <ul class="app-bar-menu">
            <li><a href="kriteria.php">Kriteria</a></li>
            <li><a href="subkriteria.php">Sub Kriteria</a></li>
            <li><a href="alternatif.php">Alternatif</a></li>
            <li><a href="perangkingan.php">Perangkingan</a></li>
        </ul>
        <a href="logout.php" class="app-bar-element place-right">Logout</a>
    </div>

    <div style="padding:5px 20px;">
        <div class="grid">
            <div class="row cells5">
                <div class="cell">

                    <ul class="v-menu" style="border:1px solid blue">
                        <li class="menu-title">Dashboard</li>
                        <li><a href="index.php"><span class="mif-home icon"></span> Beranda</a></li>
                        <li class="divider"></li>
                        <li class="menu-title">Menu</li>
                        <li><a href="kriteria.php"><span class="mif-florist icon"></span> Kriteria</a></li>
                        <li><a href="subkriteria.php"><span class="mif-layers icon"></span> Sub Kriteria</a></li>
                        <li><a href="alternatif.php"><span class="mif-stack icon"></span> Alternatif</a></li>
                        <li><a href="perangkingan.php"><span class="mif-books icon"></span> Perangkingan</a></li>
                        <li class="divider"></li>
                        <li class="menu-title">Pengguna</li>
                        <li><a href="operator.php"><span class="mif-user icon"></span> Operator</a></li>
                        <li><a href="ubahpassword.php"><span class="mif-key icon"></span> Ubah Password</a></li>
                        <li><a href="logout.php"><span class="mif-cross icon"></span> Logout</a></li>
                    </ul>

                </div>
                <div class="cell colspan4">

                    <div style="padding:10px 15px;border:1px solid blue;background:white; min-height:50vh; position: relative;"
                        id="container">
                        <div style="background-color: #f0f0f0; width: 100%; height: 100%; position: absolute; top: 0; left: 0; z-index: 999; display:flex; justify-content:center; align-items:center; display: none;"
                            id="notificationDiv">
                            <div style="background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 8px; overflow: hidden; text-align: center; padding: 1rem 3rem; max-width: 400px; display: none;"
                                id="notificationCard">
                                <div style="margin: 0.5rem 0; font-size: 4rem;" id="notificationLogo"></div>
                                <div style="font-size: 1.2rem; font-weight: bold; margin: .8rem 1rem;"
                                    id="notificationText"></div>
                                <div style="margin: 0.5rem 1rem;" id="notificationDescription"></div>
                            </div>
                        </div>
                        <script>
                        showNotification("loading");
                        document.getElementById("container").style.overflow = "hidden";
                        document.getElementById("container").style.maxHeight = "50vh";
                        </script>