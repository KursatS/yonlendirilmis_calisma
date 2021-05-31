<?php
require "dbbaglanti.php"
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş</title>
    <link rel="stylesheet" href="css\MYLogin.css">
    <style>
        body {
            background-image: url("images\\purplemountain.png");
        }
    </style>
</head>

<body>
    <div class="loginDiv" style="background-color: rgba(0,0,0,0.85); padding:70px; border-radius:10px;">
        <img style="margin-left: 100px;" src=" images\Loginlogo.png">
        <?php
        if (!isset($_GET["mail"]) or !isset($_GET["kod"])) :
        ?>
            <form action="" method="POST">
                <input name="aktivasyonMail" type="email" placeholder="E-Posta"><button name="aktivasyonGonder" class="suButton">Kodunu Gönder</button><br><br>
            </form><?php
                endif;
                if (isset($_POST["aktivasyonGonder"])) {
                    $sorgu = $dbbaglanti->prepare("SELECT * FROM personeller WHERE email =?");
                    $sorgu->execute(array(
                        $_POST["aktivasyonMail"]
                    ));
                    $sayi = $sorgu->rowCount();
                    if ($sayi == 1) {
                        $veriler = $sorgu->fetch(PDO::FETCH_ASSOC);
                    ?>
                <div id="aktivasyonYazi"><a href="<?php echo 'http://localhost/yonlendirilmis_calisma/sifremi_unuttum.php?mail=' . $veriler["email"] . '&kod=' . $veriler["aktivasyon_kodu"] . '' ?>">Aktivasyon Linkiniz</a></div>
            <?php
                    } else {
                        echo '<div id="aktivasyonHata">Böyle bir mail adresine sahip personel yok.</div>';
                    }
                }
                if (isset($_GET["mail"]) and isset($_GET["kod"])) :
                    $sorgu2 = $dbbaglanti->prepare("SELECT * FROM personeller WHERE email=?");
                    $sorgu2->execute(array(
                        $_GET["mail"]
                    ));
                    $sayi2 = $sorgu2->rowCount();
                    if ($sayi2 != 1) {
                        header("location:giris.php");
                        exit();
                    }
            ?>
            <form action="" method="POST">
                <input name="yeniSifre1" type="password" placeholder="Yeni Şifre"><br><br>
                <input name="yeniSifre2" type="password" placeholder="Yeni Şifre">
                <button name="sifreyiDegistir" class="suButton">Şifreyi Değiştir</button>
            </form>
        <?php
                endif;
                if (isset($_POST["sifreyiDegistir"])) {
                    $sifre1 = htmlspecialchars($_POST["yeniSifre1"]);
                    $sifre2 = htmlspecialchars($_POST["yeniSifre2"]);
                    $yeniAktivasyonKodu = substr(md5(uniqid()), 0, 6);
                    if ($sifre1 == $sifre2) {
                        $sifre1 = md5($sifre1);
                        $sorgu = $dbbaglanti->prepare("UPDATE personeller SET personel_sifre=?,aktivasyon_kodu=? WHERE email=? AND aktivasyon_kodu=?");
                        $sorgu->execute(array(
                            $sifre1, $yeniAktivasyonKodu, $_GET["mail"], $_GET["kod"]
                        ));
                        $sayi = $sorgu->rowCount();
                        if ($sayi == 1) {
                            echo '<div id="sifreEslesti">Şifreniz değişti! </div>';
                            header("location:giris.php");
                        }
                    } else {
                        echo '<div id="sifreEslesmedi"> Şifreler eşleşmedi! </div>';
                    }
                }

        ?>
    </div>
</body>

</html>