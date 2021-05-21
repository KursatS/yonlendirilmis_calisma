<?php
require "header.php";
$sorgu = $dbbaglanti->prepare("SELECT * FROM personeller WHERE id=?");
$sorgu->execute(array(
    $_SESSION["personel"]["id"]
));
$satir = $sorgu->fetch(PDO::FETCH_ASSOC);
$_SESSION["personel"] = $satir;
?>


<head>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="js/md5.js"></script>
</head>

<body>

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
            <div class="personelForm">
                <div style="" class="personelIsımler">
                    <input id="ad" type="text" name="ad" placeholder="Ad" readonly value="<?php echo $satir["ad"] ?>">
                    <input id="soyad" type="text" name="soyad" placeholder="Soyad" readonly value="<?php echo $satir["soyad"] ?>">
                    <input id="email" type="text" name="email" placeholder="Email" value="<?php echo $satir["email"] ?>">
                    <input id="telefon" type="text" name="telefon" placeholder="Telefon" value="<?php echo $satir["telefon"] ?>">
                </div>
                <div class="personelGiris">
                    <input id="personel_ad" type="text" name="personel_adi" placeholder="Personel Giriş Adı" readonly value="<?php echo $satir["personel_adi"] ?>">
                    <input id="eskiSifre" type="text" name="eskiSifre" placeholder="Eski Şifre">
                    <input id="personel_sifre" type="password" name="personel_sifre" placeholder="Personel Giriş Şifre">
                    <input id="personel_sifre2" type="password" name="personel_sifre2" placeholder="Şifre Tekrar">
                    <button class="personelEkleKaydet btn-purple" onclick="profilDuzenle()">Kaydet</button>
                </div>
            </div>
        </div>
    </section>
    <?php
    if (isset($_POST["profilResminiGuncelle"]) && strlen($_FILES["image"]["name"]) > 0) {
        unlink($_SESSION["personel"]["profil_foto"]);
        $img_path = "profileImgs/" . $_FILES["image"]["name"];
        $sonuc = move_uploaded_file($_FILES["image"]["tmp_name"], $img_path);
        $sorgu = $dbbaglanti->prepare("UPDATE personeller SET profil_foto = ? WHERE id=?");
        $sonuc = $sorgu->execute(array(
            $img_path, $_SESSION["personel"]["id"]
        ));
        $sorgu = $dbbaglanti->prepare("SELECT * FROM personeller WHERE id=?");
        $sorgu->execute(array(
            $_SESSION["personel"]["id"]
        ));
        $satir = $sorgu->fetch(PDO::FETCH_ASSOC);
        $_SESSION["personel"] = $satir;
        header("location:profiliDuzenle.php");
    }

    ?>

</body>

<script>
    var profilDuzenle = function() {
        var eskiSifre = "<?php echo $_SESSION["personel"]["personel_sifre"] ?>";
        var id = <?php echo $_SESSION["personel"]["id"] ?>;
        var ad = $("#ad").val();
        var soyad = $("#soyad").val();
        var email = $("#email").val();
        var telefon = $("#telefon").val();
        var psifre = $("#personel_sifre").val();
        var psifre2 = $("#personel_sifre2").val();

        if (psifre == psifre2 && psifre != "" && eskiSifre == md5($("#eskiSifre").val())) {

            $.ajax({
                type: "POST",
                url: "profilUpdate.php",
                data: {
                    "id": id,
                    "ad": ad,
                    "soyad": soyad,
                    "email": email,
                    "telefon": telefon,
                    "psifre": psifre,
                    "psifre2": psifre2

                },
                success: function() {
                    Swal.fire({
                        text: 'Başarıyla Güncellendi!',
                        icon: 'success',
                        confirmButtonText: 'Tamam',
                        confirmButtonColor: "#800080"
                    })
                    setTimeout(function() {
                        window.location.replace("giris.php");
                    }, 1500);

                }
            })
        } else {
            Swal.fire({
                text: 'Girilen Bilgiler Hatalı Veya Eksik!',
                icon: 'warning',
                confirmButtonText: 'Tamam',
                confirmButtonColor: "#800080",
            })
        }

    }
</script>

</html>