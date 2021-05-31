<?php
require "header.php";
$sorgu = $dbbaglanti->prepare("SELECT * FROM personeller WHERE id=?");
$sorgu->execute(array(
    $_GET["id"]
));
$satir = $sorgu->fetch(PDO::FETCH_ASSOC);
?>

<section>
    <div class="personelEkle background-photo">
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
                <input id="ad" type="text" name="ad" placeholder="Ad" value="<?php echo $satir["ad"] ?>">
                <input id="soyad" type="text" name="soyad" placeholder="Soyad" value="<?php echo $satir["soyad"] ?>">
                <input id="email" type="text" name="email" placeholder="Email" value="<?php echo $satir["email"] ?>">
                <input id="telefon" type="text" name="telefon" placeholder="Telefon" value="<?php echo $satir["telefon"] ?>">
                <select style="height: 50px; width:200px;" name="cinsiyet">
                    <option value="">Cinsiyet Seçiniz</option>
                    <option value="E" <?php if ($satir["cinsiyet"] == "E") {
                                            echo "SELECTED";
                                        } ?>>Erkek</option>
                    <option value="K" <?php if ($satir["cinsiyet"] == "K") {
                                            echo "SELECTED";
                                        } ?>>Kadın</option>
                </select>
                <select style="height: 50px; width:200px;" name="yetki">
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
                <input id="personelAdi" type="text" name="personel_adi" placeholder="Personel Giriş Adı" value="<?php echo $satir["personel_adi"] ?>">
                <button id="personelKaydetButon" class="btn-duzenle btn btn-lightpurple" style="margin: 10px 0 0 200px;" type="submit" name="personelEkleButton">Kaydet</button>
                <button class="btn-duzenle btn btn-red" style="padding:0px; margin: 10px 0 0 200px;" type="submit" name="personelSilButton"><a href="personelSil.php?id=<?php echo $_GET["id"] ?>"></a>Personeli Sil</button>
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
<script>
    $("#ad").on("input", function() {
        if ($("#ad").val().length < 2) {
            document.getElementById("personelKaydetButon").disabled = true;
        } else {
            document.getElementById("personelKaydetButon").disabled = false;
        }
    });
    $("#soyad").on("input", function() {
        if ($("#soyad").val().length < 2) {
            document.getElementById("personelKaydetButon").disabled = true;
        } else {
            document.getElementById("personelKaydetButon").disabled = false;
        }
    });
    $("#email").on("input", function() {
        if ($("#email").val().length < 6) {
            document.getElementById("personelKaydetButon").disabled = true;
        } else {
            document.getElementById("personelKaydetButon").disabled = false;
        }
    });
    $("#telefon").on("input", function() {
        if ($("#telefon").val().length < 10) {
            document.getElementById("personelKaydetButon").disabled = true;
        } else {
            document.getElementById("personelKaydetButon").disabled = false;
        }
    });
    $("#personelAdi").on("input", function() {
        if ($("#personelAdi").val().length < 6) {
            document.getElementById("personelKaydetButon").disabled = true;
        } else {
            document.getElementById("personelKaydetButon").disabled = false;
        }
    });
</script>

</html>