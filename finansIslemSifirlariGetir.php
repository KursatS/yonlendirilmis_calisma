<?php
require "dbbaglanti.php";
if(!isset($_SESSION["personel"])){
    header("location:giris.php");
}

$data = array();

$durum = $dbbaglanti->prepare("SELECT * FROM finansalIslemler WHERE islemMiktari = 0 ORDER BY finansId");

$durum -> execute();

$sonuc = $durum->fetchAll();

foreach($sonuc as $satir){
    $data[] = array(
        'id' => $satir["finansId"],
        'islemAdi' => $satir["islemAdi"],
        'islemTarihi' => $satir["islemTarihi"],
        'islemTuru' => $satir["islemTuru"],
        'islemMiktari' => $satir["islemMiktari"],
        'islemKategori' => $satir["islemKategori"]
    );
}

echo json_encode($data);