<?php
require "dbbaglanti.php";
if(!isset($_SESSION["personel"])){
    header("location:giris.php");
}

$data = array();

$durum = $dbbaglanti->prepare("SELECT * FROM finansalIslemler WHERE finansId = ?");

$sonuc=$durum->execute(array(
    $_POST["islemId"]
));

$durum -> execute();

$sonuc = $durum->fetchAll();

foreach($sonuc as $satir){
    $data[] = array(
        'islemId' => $satir["finansId"],
        'islemAdi' => $satir["islemAdi"],
        'islemTarihi' => $satir["islemTarihi"],
        'islemTuru' => $satir["islemTuru"],
        'islemMiktari' => $satir["islemMiktari"],
        'islemKategori' => $satir["islemKategori"]
    );
}

echo json_encode($data[0]);