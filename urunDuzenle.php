<?php
require "header.php";
$sorgu = $dbbaglanti->prepare("SELECT * FROM urunler WHERE urunId=?");
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
                <input type="text" name="urunAdi" placeholder="Ürün Adı" value="<?php echo $satir["urunAdi"] ?>">
                <input type="text" name="urunStok" placeholder="Ürün Stok" value="<?php echo $satir["urunStok"] ?>">
                <select name="kategori">
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
                <select name="marka">
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
                <select name="cinsiyet">
                    <option value="">Cinsiyet Seçiniz</option>
                    <option value="E" <?php if ($satir["urunCinsiyet"] == "E") {
                                            echo "SELECTED";
                                        } ?>>Erkek</option>
                    <option value="K" <?php if ($satir["urunCinsiyet"] == "K") {
                                            echo "SELECTED";
                                        } ?>>Kadın</option>
                </select>
                <select name="urunNumara">
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
                <select name="renk">
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
                <button class="personelEkleKaydet btn-purple" type="submit" name="personelEkleButton">Kaydet</button>
                <button class="personelSil btn-red" onclick="" type="submit" name="personelSilButton"><a href="urunSil.php?id=<?php echo $_GET["id"] ?>">Ürünü Sil</a></button>
            </div>
        </form>
    </div>
</section>
<?php
if (isset($_POST["personelEkleButton"])) {
    $sorgu = $dbbaglanti->prepare("UPDATE urunler SET urunAdi = ?, urunStok = ?, urunKategoriId = ?, urunMarka = ?, urunCinsiyet = ?, urunNumara = ?, urunRenk = ? WHERE urunId=?");
    $sorgu->execute(array(
        $_POST["urunAdi"], $_POST["urunStok"], $_POST["kategori"], $_POST["marka"], $_POST["cinsiyet"], $_POST["urunNumara"], $_POST["renk"], $_GET["id"]
    ));
}
?>

</body>

</html>