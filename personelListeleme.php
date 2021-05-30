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
        $durum = $dbbaglanti->prepare("SELECT * FROM personeller WHERE durum = 'A' and id = $aramaText ORDER BY id");
    } else if ($armt == 1) {
        $durum = $dbbaglanti->prepare("SELECT * FROM personeller WHERE ad LIKE '%$aramaText%' AND durum = 'A' ORDER BY id");
    } else if ($armt == 2) {
        $durum = $dbbaglanti->prepare("SELECT * FROM personeller WHERE soyad LIKE '%$aramaText%' AND durum = 'A' ORDER BY id");
    } else if ($armt == 3) {
        $durum = $dbbaglanti->prepare("SELECT * FROM personeller WHERE email LIKE '%$aramaText%' AND durum = 'A' ORDER BY id");
    } else if ($armt == 4) {
        $durum = $dbbaglanti->prepare("SELECT * FROM personeller WHERE telefon LIKE '%$aramaText%' AND durum = 'A' ORDER BY id");
    } else if ($armt == 5) {
        $durum = $dbbaglanti->prepare("SELECT * FROM personeller WHERE cinsiyet LIKE '%$aramaText%' AND durum = 'A' ORDER BY id");
    }
} else {
    $durum = $dbbaglanti->prepare("SELECT * FROM personeller WHERE durum = 'A' ORDER BY id");
}

$durum->execute();

$sonuc = $durum->fetchAll();

foreach ($sonuc as $satir) {
    $data[] = array(
        'id' => $satir["id"],
        'ad' => $satir["ad"],
        'soyad' => $satir["soyad"],
        'email' => $satir["email"],
        'telefon' => $satir["telefon"],
        'yetki' => $satir["yetki"],
        'durum' => $satir["durum"],
    );
}

echo json_encode($data);
