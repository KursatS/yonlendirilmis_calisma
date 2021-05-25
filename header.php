<?php
require "dbbaglanti.php";
if (!isset($_SESSION["personel"])) {
    header("location:giris.php");
}

?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AnaSayfa</title>
    <link rel="stylesheet" href="css\bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="css\MYMain.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js" integrity="sha512-LGXaggshOkD/at6PFNcp2V2unf9LzFq6LE+sChH7ceMTDP0g2kn6Vxwgg7wkPP7AAtX+lmPqPdxB47A0Nz0cMQ==" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script src="http://cdn.sobekrepository.org/includes/jquery-rotate/2.2/jquery-rotate.min.js"></script>
</head>

<style>
    body {
        overflow-y: hidden;
    }
</style>

<body>
    <header class="mainHeader">
        <div>
            <?php
            if (!empty($_SESSION["personel"]["profil_foto"])) {
            ?>
                <img style="object-fit: cover; border-radius:10px;" width="110px" height="110px" src="<?php echo  $_SESSION["personel"]["profil_foto"] ?>">
            <?php
            } else {
            ?>
                <i class="fas fa-user fa-7x">
                <?php
            }
                ?></i>
                <h2 style="margin-left: 5px;">
                    <?php
                    if ($_SESSION["personel"]["yetki"] == "A") {
                        $yetki = "Yönetici";
                    } elseif ($_SESSION["personel"]["yetki"] == "B") {
                        $yetki = "Muhasebe";
                    } elseif ($_SESSION["personel"]["yetki"] == "C") {
                        $yetki = "Satış Görevlisi";
                    } elseif ($_SESSION["personel"]["yetki"] == "D") {
                        $yetki = "Hizmetli";
                    }
                    echo $_SESSION["personel"]["ad"] . " " . $_SESSION["personel"]["soyad"] . "<br>" . $yetki;

                    ?>
                </h2>
        </div>
        <datetime style="font-size: 25px;" id="saat"></datetime>
        <a href="anasayfa.php"><img src="images\Loginlogo.png" height="100px"></a>
    </header>
    <aside class="mainSidebar">
        <ul>
            <?php if ($_SESSION["personel"]["yetki"] == "D") : ?>
                <li><a href="takvim.php"><i class="far fa-calendar-alt fa-2x"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Takvim</a></li>
            <?php endif ?>
            <?php if ($_SESSION["personel"]["yetki"] == "C") : ?>
                <li><a href="urunstok.php"><i class="fas fa-boxes fa-2x"></i> &nbsp;&nbsp;&nbsp;Ürün/Stok &nbsp;&nbsp;&nbsp;Yönetimi</a></li>
                <li><a href="takvim.php"><i class="far fa-calendar-alt fa-2x"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Takvim</a></li>
                <li><a href="personeller.php"><i class="fas fa-users fa-2x"></i> &nbsp;&nbsp;Personeller</a></li>
            <?php endif ?>
            <?php if ($_SESSION["personel"]["yetki"] == "B") : ?>
                <li><a href="urunstok.php"><i class="fas fa-boxes fa-2x"></i> &nbsp;&nbsp;&nbsp;Ürün/Stok &nbsp;&nbsp;&nbsp;Yönetimi</a></li>
                <li><a href="finans.php"><i class="fas fa-chart-line fa-2x"></i> &nbsp;&nbsp;&nbsp;&nbsp;Finansal &nbsp;&nbsp;&nbsp;&nbsp;İşlemler</a></li>
                <li><a href="takvim.php"><i class="far fa-calendar-alt fa-2x"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Takvim</a></li>
                <li><a href="personeller.php"><i class="fas fa-users fa-2x"></i> &nbsp;&nbsp;Personeller</a></li>
            <?php endif ?>
            <?php if ($_SESSION["personel"]["yetki"] == "A") : ?>
                <li><a id="urunstok" class="" href="urunstok.php"><i class="fas fa-boxes fa-2x"></i> &nbsp;&nbsp;&nbsp;Ürün/Stok &nbsp;&nbsp;&nbsp;Yönetimi</a></li>
                <li><a id="finans" class="" href="finans.php"><i class="fas fa-chart-line fa-2x"></i> &nbsp;&nbsp;&nbsp;&nbsp;Finansal &nbsp;&nbsp;&nbsp;&nbsp;İşlemler</a></li>
                <li><a id="personeller" class="" href="personeller.php"><i class="fas fa-users fa-2x"></i> &nbsp;&nbsp;Personeller</a></li>
                <li><a id="takvim" class="" href="takvim.php"><i class="far fa-calendar-alt fa-2x"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Takvim</a></li>
            <?php endif ?>

        </ul>
        <div id="animasyonAyarlar" style="position: absolute; bottom: 20px;">
            <a id="ayarlarButonu" href="javascript:void(0);" onclick="yukariCikar();">&nbsp;&nbsp;<i id="ayarlarButonuIcon" class="fas fa-cog fa-2x"></i>&nbsp;&nbsp;&nbsp;&nbsp;Ayarlar</a>
        </div>
        <div>
            <a href="profiliDuzenle.php" id="profilDuzenleButonu" style="display:none; left:57px; bottom:140px; position:absolute; font-size:20px;">&nbsp;&nbsp;<i class="fas fa-id-badge"></i>&nbsp;&nbsp;&nbsp;&nbsp;Profili Düzenle</a>
            <a href="giris.php" id="cikisButonu" style="display:none; left:57px; bottom:90px; position:absolute; font-size:20px;">&nbsp;&nbsp;<i class="fas fa-sign-out-alt"></i>&nbsp;&nbsp;&nbsp;&nbsp;Çıkış</a>
        </div>
    </aside>

    <script>
        moment.locale('tr');

        $(document).ready(function() {
            $("#profilDuzenleButonu").hide();
            $("#cikisButonu").hide();
        })

        setInterval(function() {
            $("#saat").html(moment().format('MMMM Do YYYY, h:mm:ss'));
        }, 100);

        function yukariCikar() {
            $("#animasyonAyarlar").animate({
                bottom: '200px'
            });
            document.getElementById("ayarlarButonu").setAttribute("onClick", "javascript: asagiIndir()");
            document.getElementById("ayarlarButonuIcon").setAttribute("class", "fas fa-cog fa-2x fa-spin");
            $("#profilDuzenleButonu").fadeIn(1500);
            $("#cikisButonu").fadeIn(1500);
        }

        function asagiIndir() {
            $("#animasyonAyarlar").animate({
                bottom: '20px'
            });
            document.getElementById("ayarlarButonu").setAttribute("onClick", "javascript: yukariCikar()");
            document.getElementById("ayarlarButonuIcon").setAttribute("class", "fas fa-cog fa-2x");
            $("#profilDuzenleButonu").fadeOut(100);
            $("#cikisButonu").fadeOut(100);
        }
    </script>