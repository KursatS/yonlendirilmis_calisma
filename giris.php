<?php
require "dbbaglanti.php";
if (isset($_SESSION["personel"])) {
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoşgeldiniz</title>
    <link rel="stylesheet" href="css\MYLogin.css">
    <style>
        body {
            background-image: url("images\\purplemountain.png");
        }
    </style>
</head>

<body>
    <div class="loginDiv" style="background-color: rgba(0,0,0,0.85); padding:70px; border-radius:10px;">
        <img src="images\Loginlogo.png">
        <form action="" method="POST">
            <input type="text" placeholder="Personel Adı" name="personel_ad">
            <br><br>
            <input type="password" placeholder="Şifre" name="personel_sifre">
            <div class="gsInfo">
                <a id="sifremiUnuttum" href="sifremi_unuttum.php">Şifremi Unuttum</a>
                <button>Giriş</button>
            </div>
            <?php

            if (isset($_POST["personel_ad"])) {
                $sifre = md5($_POST["personel_sifre"]);

                $sorgu = $dbbaglanti->prepare("SELECT * FROM personeller WHERE personel_adi=? AND personel_sifre=?");
                $sorgu->execute(array(
                    $_POST["personel_ad"],
                    $sifre
                ));
                $sayi = $sorgu->rowCount();
                if ($sayi == 1) {
                    $veriler = $sorgu->fetch(PDO::FETCH_ASSOC);
                    $_SESSION["personel"] = $veriler;
                    header("location:anasayfa.php");
                } else {
            ?>
                    <div id="yanlis_sifre">Kullanıcı Adı veya Şifre Yanlış!</div>
            <?php
                }
            }

            ?>
        </form>
    </div>
</body>

</html>