<?php
require "dbbaglanti.php";
if(isset($_GET["id"])){
    $sorgu = $dbbaglanti->prepare("UPDATE kategori SET kategoriDurum=? WHERE kategoriId=?");
    $sonuc=$sorgu->execute(array(
        "P",$_GET["id"]
    ));
    if($sonuc){
        header("location: kategoriler.php");
        exit();
    }
}
