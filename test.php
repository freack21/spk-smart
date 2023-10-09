<?php

require_once("config.php");

$id = isset($_GET["id"]) ? $_GET["id"] : 1;
$stmt5 = $db->prepare("SELECT MAX(nilai_sub_kriteria) AS max_sub, MIN(nilai_sub_kriteria) AS min_sub FROM smart_sub_kriteria WHERE id_kriteria = ? GROUP BY id_kriteria");
$stmt5->bindParam(1, $id);
$stmt5->execute();

$rowMaxMinSub = $stmt5->fetch(PDO::FETCH_ASSOC);

var_dump($rowMaxMinSub);