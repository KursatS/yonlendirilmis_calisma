<?php
require "header.php"
?>
<section class="kutucuk">
    <div class="kutucuklar yazi">Giriş Logları</div>
    <div class="kutucuklar yazi">Az Kalan Ürünler</div>
    <div class="kutucuklar yazi">En Son Yapılan İşlemler</div>
    <div class="kutucuklar notKutucugu">
        <form action="" method="POST"><textarea name="notlar" id="notlar" placeholder=" Notlar"><?php print_r($_SESSION["personel"]["kullanici_not"]) ?></textarea><button type="submit" class="notlarKaydet btn-purple" name="notlarKaydet">Kaydet</button></form>
    </div>
</section>
<?php
if (isset($_POST["notlarKaydet"])) {
    $not = htmlspecialchars($_POST["notlar"]);
    $_SESSION["personel"]["kullanici_not"] = $not;
    $sorgu = $dbbaglanti->prepare("UPDATE personeller SET kullanici_not=? WHERE id=?");
    $sorgu->execute(array(
        $not, $_SESSION["personel"]["id"]
    ));
    header("location:anasayfa.php");
}
?>
</body>

</html>