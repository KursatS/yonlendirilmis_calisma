<?php
require "dbbaglanti.php";

if(isset($_POST["islemKategori"])){
    $sorgu = $dbbaglanti->prepare("INSERT INTO finansalIslemler SET islemAdi =?, islemTarihi=?, islemTuru=?, islemMiktari=?, islemKategori=?");
    $sorgu -> execute(array(
        $_POST["islemAdi"],$_POST["islemTarih"],$_POST["islemTuru"],$_POST["islemMiktar"],$_POST["islemKategori"]
    ));
}
