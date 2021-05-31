<?php
require "dbbaglanti.php";

if(isset($_POST)){
    $sorgu = $dbbaglanti->prepare("UPDATE personeller SET ad =?, soyad=?, email=?, telefon=? WHERE id =?");
    $sorgu -> execute(array(
        $_POST["ad"],$_POST["soyad"],$_POST["email"],$_POST["telefon"],$_POST["id"]
    ));
}
