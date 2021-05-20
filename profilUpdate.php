<?php
require "dbbaglanti.php";

if(isset($_POST)){
    $sorgu = $dbbaglanti->prepare("UPDATE personeller SET ad =?, soyad=?, email=?, telefon=?, personel_sifre=? WHERE id =?");
    $sorgu -> execute(array(
        $_POST["ad"],$_POST["soyad"],$_POST["email"],$_POST["telefon"],md5($_POST["psifre"]),$_POST["id"]
    ));
}
