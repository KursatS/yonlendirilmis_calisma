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


</head>

<body>
    <header class="mainHeader">
        <div><i class="fas fa-user fa-7x"></i>
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
        <a href="anasayfa.php"><img src="images\Loginlogo.png" height="100px"></a>
    </header>
    <aside class="mainSidebar">
        <ul>
            <li><a href="urunstok.php"><i class="fas fa-boxes fa-2x"></i> &nbsp;&nbsp;&nbsp;Ürün/Stok &nbsp;&nbsp;&nbsp;Yönetimi</a></li>
            <li><a href="finans.php"><i class="fas fa-chart-line fa-2x"></i> &nbsp;&nbsp;&nbsp;&nbsp;Finansal &nbsp;&nbsp;&nbsp;&nbsp;İşlemler</a></li>
            <li><a href="takvim.php"><i class="far fa-calendar-alt fa-2x"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Takvim</a></li>
            <li><a href="personeller.php"><i class="fas fa-users fa-2x"></i> &nbsp;&nbsp;Personeller</a></li>
        </ul>
        <div>
            <a href="giris.php">&nbsp;&nbsp;<i class="fas fa-cog fa-2x"></i>&nbsp;&nbsp;&nbsp;&nbsp;Ayarlar</a>
        </div>
    </aside>

    <script>
    
    
    </script>