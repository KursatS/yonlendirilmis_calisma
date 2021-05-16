<?php
require "dbbaglanti.php";
if(!isset($_SESSION["personel"])){
    header("location:giris.php");
}

$data = array();

$durum = $dbbaglanti->prepare("SELECT * FROM olayveri ORDER BY eventId");

$durum -> execute();

$sonuc = $durum->fetchAll();

foreach($sonuc as $satir){
    $data[] = array(
        'id' => $satir["eventId"],
        'title' => $satir["title"],
        'start' => $satir["start_event"],
        'end' => $satir["end_event"]
    );
}

echo json_encode($data);
