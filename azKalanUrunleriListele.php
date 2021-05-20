<?php
require "dbbaglanti.php";
if(!isset($_SESSION["personel"])){
    header("location:giris.php");
}

$urunSayisi = $_POST['urunSayisi'];

$data = array();

$durum = $dbbaglanti->prepare("SELECT * FROM urunler WHERE urunStok <= '$urunSayisi' AND urunDurum = 'A' ");

$durum -> execute();

$sonuc = $durum->fetchAll();

foreach($sonuc as $satir){
    $data[] = array(
        'urunId' => $satir["urunId"],
        'urunAdi' => $satir["urunAdi"],
        'urunRenk' => $satir["urunNumara"],
        'urunStok' => $satir["urunStok"]
    );
}

echo json_encode($data);