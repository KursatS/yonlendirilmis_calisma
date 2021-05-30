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
        <form action="" method="POST" style="margin-left: 100px;" enctype="multipart/form-data">
            <div class="personelResim">
                <input style="display: none;" type="file" name="image" id="upload-pp-btn">
                <label for="upload-pp-btn">
                    <?php
                    if (!empty($satir["profil_foto"])) {
                    ?>
                        <img style="object-fit: cover; border-radius:10px;" width="200px" height="200px" src="<?php echo  $satir["profil_foto"] ?>">
                    <?php
                    } else {
                    ?>
                        <i class="fas fa-file-upload fa-10x"></i>
                    <?php
                    }
                    ?>
                </label>
                <button name="profilResminiGuncelle" class="btn btn-purple" style="position: absolute; bottom:200px; left:435px;">Profil Resmini Güncelle</button>
            </div>
        </form>
        <form action="" method="POST" class="personelForm">
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
                <button class="personelEkleKaydet btn-purple" type="submit" name="personelEkleButton">Kaydet</button>
                <button class="personelSil btn-red" type="submit" name="personelSilButton"><a href="personelSil.php?id=<?php echo $_GET["id"] ?>">Personeli Sil</a></button>
            </div>
        </form>
    </div>
</section>
<?php
if (isset($_POST["profilResminiGuncelle"]) && strlen($_FILES["image"]["name"]) > 0) {
    unlink($satir["profil_foto"]);
    $img_path = "profileImgs/" . $_FILES["image"]["name"];
    $sonuc = move_uploaded_file($_FILES["image"]["tmp_name"], $img_path);
    $sorgu = $dbbaglanti->prepare("UPDATE personeller SET profil_foto = ? WHERE id=?");
    $sonuc = $sorgu->execute(array(
        $img_path, $satir["id"]
    ));
    $sorgu = $dbbaglanti->prepare("SELECT * FROM personeller WHERE id=?");
    $sorgu->execute(array(
        $satir["id"]
    ));
    $satir2 = $sorgu->fetch(PDO::FETCH_ASSOC);
    $satir = $satir2;
    header("location:personeller.php");
}

?>
<?php
if (isset($_POST["personelEkleButton"])) {
    $sorgu = $dbbaglanti->prepare("UPDATE personeller SET ad = ?, soyad = ?, email = ?, telefon = ?, cinsiyet = ?, yetki = ?, personel_adi = ?, durum='A' WHERE id=?");
    $sorgu->execute(array(
        $_POST["ad"], $_POST["soyad"], $_POST["email"], $_POST["telefon"], $_POST["cinsiyet"], $_POST["yetki"], $_POST["personel_adi"], $_GET["id"]
    ));
    header("location:personeller.php");
}
?>

</body>

</html>