<?php
require "header.php";
$sorgu = $dbbaglanti->prepare("SELECT * FROM urunler WHERE urunId=?");
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
                    if (!empty($satir["urun_foto"])) {
                    ?>
                        <img style="object-fit: cover; border-radius:10px;" width="200px" height="200px" src="<?php echo  $satir["urun_foto"] ?>">
                    <?php
                    } else {
                    ?>
                        <i class="fas fa-file-upload fa-10x"></i>
                    <?php
                    }
                    ?>
                </label>
                <button name="profilResminiGuncelle" class="btn btn-purple" style="position: absolute; bottom:200px; left:435px;">Ürün Resmini Güncelle</button>
            </div>
        </form>
        <form action="" method="POST" class="personelForm">
            <div class="personelIsımler">
                <input id="urunAdiText" type="text" name="urunAdi" placeholder="Ürün Adı" value="<?php echo $satir["urunAdi"] ?>">
                <input id="urunAdiStok" type="number" name="urunStok" placeholder="Ürün Stok" value="<?php echo $satir["urunStok"] ?>">
                <select style="height: 50px; width:200px;" name="kategori">
                    <option value="">Kategori Seçiniz</option>
                    <?php
                    $sorgu2 = $dbbaglanti->prepare("SELECT * FROM kategori");
                    $sorgu2->execute();
                    while ($satir2 = $sorgu2->fetch(PDO::FETCH_ASSOC)) { ?>
                        <option value="<?= $satir2["kategoriId"] ?>" <?php if ($satir2["kategoriId"] == $satir["urunKategoriId"]) {
                                                                            echo "SELECTED";
                                                                        } ?>><?= $satir2["kategoriAdi"] ?></option>

                    <?php

                    }
                    ?>
                </select>
                <select style="height: 50px; width:200px;" name="marka">
                    <option value="">Marka Seçiniz</option>
                    <?php
                    $sorgu2 = $dbbaglanti->prepare("SELECT * FROM markalar");
                    $sorgu2->execute();
                    while ($satir2 = $sorgu2->fetch(PDO::FETCH_ASSOC)) { ?>
                        <option value="<?= $satir2["markaId"] ?>" <?php if ($satir2["markaId"] == $satir["urunMarka"]) {
                                                                        echo "SELECTED";
                                                                    } ?>><?= $satir2["markaAdi"] ?></option>

                    <?php

                    }
                    ?>
                </select>
                <select style="height: 50px; width:200px;" name="cinsiyet">
                    <option value="">Cinsiyet Seçiniz</option>
                    <option value="E" <?php if ($satir["urunCinsiyet"] == "E") {
                                            echo "SELECTED";
                                        } ?>>Erkek</option>
                    <option value="K" <?php if ($satir["urunCinsiyet"] == "K") {
                                            echo "SELECTED";
                                        } ?>>Kadın</option>
                </select>
                <select style="height: 50px; width:200px;" name="urunNumara">
                    <option value="">Numara Seçiniz</option>
                    <?php
                    for ($i = 35; $i <= 45; $i++) {
                    ?>
                        <option value="<?= $i ?>" <?php if ($satir["urunNumara"] == $i) {
                                                        echo "SELECTED";
                                                    } ?>><?= $i ?></option>
                    <?php
                    }

                    ?>
                </select>
                <select style="height: 50px; width:200px;" name="renk">
                    <option value="">Renk Seçiniz</option>
                    <?php
                    $renkler = array("Siyah", "Gri", "Beyaz", "Kırmızı", "Sarı", "Yeşil", "Mavi", "Mor", "Turuncu", "Pembe");
                    foreach ($renkler as $renk) { ?>
                        <option value="<?= $renk ?>" <?php if ($satir["urunRenk"] == $renk) {
                                                            echo "SELECTED";
                                                        } ?>><?= $renk ?></option>
                    <?php

                    }
                    ?>
                </select>
            </div>
            <div class="personelGiris">
                <button id="kaydetButonu" class="btn-duzenle btn btn-lightpurple" type="submit" name="personelEkleButton">Kaydet</button>
                <button class="btn-duzenle btn btn-red" onclick="" type="submit" style="padding:0px; margin: 10px 0 0 0;" name="personelSilButton"><a href="urunSil.php?id=<?php echo $_GET["id"] ?>"></a>Ürünü Sil</button>
            </div>
        </form>
    </div>
</section>

<?php
if (isset($_POST["profilResminiGuncelle"]) && strlen($_FILES["image"]["name"]) > 0) {
    unlink($satir["urun_foto"]);
    $img_path = "productImgs/" . $_FILES["image"]["name"];
    $sonuc = move_uploaded_file($_FILES["image"]["tmp_name"], $img_path);
    $sorgu = $dbbaglanti->prepare("UPDATE urunler SET urun_foto = ? WHERE urunId=?");
    $sonuc = $sorgu->execute(array(
        $img_path, $satir["urunId"]
    ));
    $sorgu = $dbbaglanti->prepare("SELECT * FROM urunler WHERE urunId=?");
    $sorgu->execute(array(
        $satir["urunId"]
    ));
    $satir2 = $sorgu->fetch(PDO::FETCH_ASSOC);
    $satir = $satir2;
    header("location:urunstok.php");
}


if (isset($_POST["personelEkleButton"])) {
    $sorgu = $dbbaglanti->prepare("UPDATE urunler SET urunAdi = ?, urunStok = ?, urunKategoriId = ?, urunMarka = ?, urunCinsiyet = ?, urunNumara = ?, urunRenk = ?, urunDurum = 'A' WHERE urunId=?");
    $sorgu->execute(array(
        $_POST["urunAdi"], $_POST["urunStok"], $_POST["kategori"], $_POST["marka"], $_POST["cinsiyet"], $_POST["urunNumara"], $_POST["renk"], $_GET["id"]
    ));
    header("location: urunstok.php");
}
?>

</body>
<script>
$("#urunAdiText").on("input", function() {
   if($("#urunAdiText").val().length < 2){
    document.getElementById("kaydetButonu").disabled = true;
   }else{
    document.getElementById("kaydetButonu").disabled = false;
   }
});
$("#urunAdiStok").on("input", function() {
   if($("#urunAdiStok").val().length < 1){
    document.getElementById("kaydetButonu").disabled = true;
   }else{
    document.getElementById("kaydetButonu").disabled = false;
   }
});

</script>
</html>