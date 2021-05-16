<?php
require "dbbaglanti.php";

if(isset($_POST)){
    $sorgu = $dbbaglanti->prepare("UPDATE finansalIslemler SET islemAdi =?, islemTarihi=?, islemTuru=?, islemMiktari=?, islemKategori=? WHERE finansId=?");
    $sorgu -> execute(array(
        $_POST["islemAdi"],$_POST["islemTarihi"],$_POST["islemTuru"],$_POST["islemMiktari"],$_POST["islemKategori"],$_POST["islemId"]
    ));
}
