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
        $durum = $dbbaglanti->prepare("SELECT * FROM markalar WHERE markaDurum = 'A' and markaId = $aramaText ORDER BY markaId");
    } else if ($armt == 1) {
        $durum = $dbbaglanti->prepare("SELECT * FROM markalar WHERE markaAdi LIKE '%$aramaText%' AND markaDurum = 'A' ORDER BY markaId");
    }
} else {
    $durum = $dbbaglanti->prepare("SELECT * FROM markalar WHERE markaDurum = 'A' ORDER BY markaId");
}

$durum->execute();

$sonuc = $durum->fetchAll();

foreach ($sonuc as $satir) {
    $data[] = array(
        'markaId' => $satir["markaId"],
        'markaAdi' => $satir["markaAdi"],
        'markaDurum' => $satir["markaDurum"]
    );
}

echo json_encode($data);
