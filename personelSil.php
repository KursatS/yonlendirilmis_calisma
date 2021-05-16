<?php
require "dbbaglanti.php";
if(isset($_GET["id"])){
    $sorgu = $dbbaglanti->prepare("UPDATE personeller SET durum=? WHERE id=?");
    $sonuc=$sorgu->execute(array(
        "P",$_GET["id"]
    ));
    if($sonuc){
        header("location: personeller.php");
        exit();
    }
}
