<?php
require "dbbaglanti.php";
if(isset($_GET["id"])){
    $sorgu = $dbbaglanti->prepare("UPDATE markalar SET markaDurum=? WHERE markaId=?");
    $sonuc=$sorgu->execute(array(
        "P",$_GET["id"]
    ));
    if($sonuc){
        header("location: markalar.php");
        exit();
    }
}
