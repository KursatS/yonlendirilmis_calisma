<?php
require "dbbaglanti.php";
if(!isset($_SESSION["personel"])){
    header("location:giris.php");
}

$ayVerisi = $_POST['ayVerisi'];

$ilkVeri = "2021-$ayVerisi-00";
$sonVeri = "2021-$ayVerisi-31";

$data = array();

$durum = $dbbaglanti->prepare("SELECT * FROM `finansalislemler` WHERE islemTarihi BETWEEN '$ilkVeri' AND '$sonVeri'");

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