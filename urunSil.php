<?php
require "dbbaglanti.php";
if (isset($_GET["id"])) {
    $sorgu = $dbbaglanti->prepare("UPDATE urunler SET urunDurum=? WHERE urunId=?");
    $sonuc = $sorgu->execute(array(
        "P", $_GET["id"]
    ));
    if ($sonuc) {
        header("location: urunstok.php");
        exit();
    }
}
