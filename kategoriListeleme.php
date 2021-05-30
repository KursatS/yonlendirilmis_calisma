<?php
require "dbbaglanti.php";
if (!isset($_SESSION["personel"])) {
    header("location:giris.php");
}

$aramaText = $_POST["aramaText"];

$armt = $_POST["armt"];

$data = array();

if (strlen($aramaText) >= 1) {
    if ($armt == 0) {
        $durum = $dbbaglanti->prepare("SELECT * FROM kategori WHERE kategoriDurum = 'A' and kategoriId = $aramaText ORDER BY kategoriId");
    } else if ($armt == 1) {
        $durum = $dbbaglanti->prepare("SELECT * FROM kategori WHERE kategoriAdi LIKE '%$aramaText%' AND kategoriDurum = 'A' ORDER BY kategoriId");
    }
} else {
    $durum = $dbbaglanti->prepare("SELECT * FROM kategori WHERE kategoriDurum = 'A' ORDER BY kategoriId");
}

$durum->execute();

$sonuc = $durum->fetchAll();

foreach ($sonuc as $satir) {
    $data[] = array(
        'kategoriId' => $satir["kategoriId"],
        'kategoriAdi' => $satir["kategoriAdi"],
        'kategoriDurum' => $satir["kategoriDurum"]
    );
}

echo json_encode($data);
