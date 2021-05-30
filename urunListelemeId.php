<?php
require "dbbaglanti.php";
if (!isset($_SESSION["personel"])) {
    header("location:giris.php");
}

$aramaText = $_POST["aramaText"];
$armt = $_POST["armt"];

function categoryConverter($id, $db)
{
    $sorgu = $db->prepare("SELECT * FROM kategori WHERE kategoriId=?");
    $sorgu->execute(array($id));
    $row = $sorgu->fetch(PDO::FETCH_ASSOC);
    return $row["kategoriAdi"];
}
function markaConverter($id, $db)
{
    $sorgu = $db->prepare("SELECT * FROM markalar WHERE markaId=?");
    $sorgu->execute(array($id));
    $row = $sorgu->fetch(PDO::FETCH_ASSOC);
    return $row["markaAdi"];
}

$data = array();

if (strlen($aramaText) >= 1) {
    if ($armt == 0) {
        $durum = $dbbaglanti->prepare("SELECT * FROM urunler WHERE urunDurum = 'A' and urunId = $aramaText ORDER BY urunId");
    } else if ($armt == 1) {
        $durum = $dbbaglanti->prepare("SELECT * FROM urunler WHERE urunAdi LIKE '%$aramaText%' AND urunDurum = 'A' ORDER BY urunId");
    } else if ($armt == 2) {
        $durum = $dbbaglanti->prepare("SELECT * FROM urunler WHERE urunDurum = 'A' and urunMarka LIKE '$aramaText' ORDER BY urunId");
    } else if ($armt == 3) {
        $durum = $dbbaglanti->prepare("SELECT * FROM urunler WHERE urunDurum = 'A' and urunKategoriId LIKE '$aramaText' ORDER BY urunId");
    } else if ($armt == 4) {
        $durum = $dbbaglanti->prepare("SELECT * FROM urunler WHERE urunCinsiyet LIKE '$aramaText' and urunDurum = 'A' ORDER BY urunId");
    } else if ($armt == 5) {
        $durum = $dbbaglanti->prepare("SELECT * FROM urunler WHERE urunDurum = 'A' and urunNumara = '$aramaText' ORDER BY urunId");
    } else if ($armt == 6) {
        $durum = $dbbaglanti->prepare("SELECT * FROM urunler WHERE urunDurum = 'A' and urunRenk LIKE '%$aramaText%' ORDER BY urunId");
    }
} else {
    $durum = $dbbaglanti->prepare("SELECT * FROM urunler WHERE urunDurum = 'A' ORDER BY urunId");
}

$durum->execute();

$sonuc = $durum->fetchAll();

foreach ($sonuc as $satir) {
    $data[] = array(
        'urunId' => $satir["urunId"],
        'urunAdi' => $satir["urunAdi"],
        'urunKategoriId' => categoryConverter($satir["urunKategoriId"],$dbbaglanti),
        'urunDurum' => $satir["urunDurum"],
        'urunMarka' => markaConverter($satir["urunMarka"],$dbbaglanti),
        'urunNumara' => $satir["urunNumara"],
        'urunRenk' => $satir["urunRenk"],
        'urunStok' => $satir["urunStok"],
        'urunCinsiyet' => $satir["urunCinsiyet"]
    );
}

echo json_encode($data);
