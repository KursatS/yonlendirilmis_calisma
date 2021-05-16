<?php
require "header.php";
$sorgu = $dbbaglanti->prepare("SELECT * FROM personeller WHERE id=?");
$sorgu->execute(array(
    $_GET["id"]
));
$satir = $sorgu->fetch(PDO::FETCH_ASSOC);
?>

<section>
    <div class="personelEkle">
        <form action="" method="POST" class="personelForm">
            <div class="personelResim"><i class="fas fa-file-upload fa-10x"></i></div>
            <div class="personelIsımler">
                <input type="text" name="ad" placeholder="Ad" value="<?php echo $satir["ad"] ?>">
                <input type="text" name="soyad" placeholder="Soyad" value="<?php echo $satir["soyad"] ?>">
                <input type="text" name="email" placeholder="Email" value="<?php echo $satir["email"] ?>">
                <input type="text" name="telefon" placeholder="Telefon" value="<?php echo $satir["telefon"] ?>">
                <select name="cinsiyet">
                    <option value="">Cinsiyet Seçiniz</option>
                    <option value="E" <?php if ($satir["cinsiyet"] == "E") {
                                            echo "SELECTED";
                                        } ?>>Erkek</option>
                    <option value="K" <?php if ($satir["cinsiyet"] == "K") {
                                            echo "SELECTED";
                                        } ?>>Kadın</option>
                </select>
                <select name="yetki">
                    <option value="">Yetki Seçiniz</option>
                    <option value="A" <?php if ($satir["yetki"] == "A") {
                                            echo "SELECTED";
                                        } ?>>Yönetici</option>
                    <option value="B" <?php if ($satir["yetki"] == "B") {
                                            echo "SELECTED";
                                        } ?>>Muhasebe</option>
                    <option value="C" <?php if ($satir["yetki"] == "C") {
                                            echo "SELECTED";
                                        } ?>>Satış Görevlisi</option>
                    <option value="D" <?php if ($satir["yetki"] == "D") {
                                            echo "SELECTED";
                                        } ?>>Hizmetli</option>
                </select>
            </div>
            <div class="personelGiris">
                <input type="text" name="personel_adi" placeholder="Personel Giriş Adı" value="<?php echo $satir["personel_adi"] ?>">
                <input type="text" name="personel_sifre" placeholder="Personel Giriş Şifre">
                <button class="personelEkleKaydet btn-purple" type="submit" name="personelEkleButton">Kaydet</button>
                <button class="personelSil btn-red" type="submit" name="personelSilButton"><a href="personelSil.php?id=<?php echo $_GET["id"] ?>">Personeli Sil</a></button>
            </div>
        </form>
    </div>
</section>
<?php
if (isset($_POST["personelEkleButton"])) {
    $sorgu = $dbbaglanti->prepare("UPDATE personeller SET ad = ?, soyad = ?, email = ?, telefon = ?, cinsiyet = ?, yetki = ?, personel_adi = ?, personel_sifre = ? WHERE id=?");
    $sorgu->execute(array(
        $_POST["ad"], $_POST["soyad"], $_POST["email"], $_POST["telefon"], $_POST["cinsiyet"], $_POST["yetki"], $_POST["personel_adi"], md5($_POST["personel_sifre"]), $_GET["id"]
    ));
}
?>

</body>

</html>