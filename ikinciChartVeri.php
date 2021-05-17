<?php
require "dbbaglanti.php";
if(!isset($_SESSION["personel"])){
    header("location:giris.php");
}

$ayVerisi = $_POST['birOncekiAy'];
$ayVerisi2 = $_POST['buAy'];

$birOncekiAyVeri = "2021-$ayVerisi-00";
$birOncekiAySonuVeri = "2021-$ayVerisi-31";
$buAyVeri = "2021-$ayVerisi2-00";
$buAySonuVeri = "2021-$ayVerisi2-31";

$data = array();
$data2 = array();

$durum = $dbbaglanti->prepare("SELECT * FROM `finansalislemler` WHERE islemTarihi BETWEEN '$birOncekiAyVeri' AND '$birOncekiAySonuVeri'");

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

$durum = $dbbaglanti->prepare("SELECT * FROM `finansalislemler` WHERE islemTarihi BETWEEN '$buAyVeri' AND '$buAySonuVeri'");

$durum -> execute();

$sonuc = $durum->fetchAll();

foreach($sonuc as $satir){
    $data2[] = array(
        'id' => $satir["finansId"],
        'islemAdi' => $satir["islemAdi"],
        'islemTarihi' => $satir["islemTarihi"],
        'islemTuru' => $satir["islemTuru"],
        'islemMiktari' => $satir["islemMiktari"],
        'islemKategori' => $satir["islemKategori"]
    );
}

$yeniDizi = [$data,$data2];

echo json_encode($yeniDizi);