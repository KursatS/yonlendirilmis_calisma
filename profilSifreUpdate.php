<?php
require "dbbaglanti.php";

if(isset($_POST)){
    $sorgu = $dbbaglanti->prepare("UPDATE personeller SET personel_sifre = ? WHERE id =?");
    $sorgu -> execute(array(
        md5($_POST["sifre2"]),$_POST["id"]
    ));
}
