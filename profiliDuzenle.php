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
    <title>Profili Düzenle</title>
</head>

<body>

    <section>
        <div class="personelEkle background-photo">
            <div class="personelForm">
                <form action="" method="POST" style="margin-left: 100px;" enctype="multipart/form-data">
                    <div class="personelResim">
                        <input style="display: none;" type="file" name="image" id="upload-pp-btn">
                        <label for="upload-pp-btn">
                            <?php
                            if (!empty($satir["profil_foto"])) {
                            ?>
                                <img style="object-fit: cover; border-radius:10px;" width="300px" height="300px" src="<?php echo  $satir["profil_foto"] ?>">
                            <?php
                            } else {
                            ?>
                                <i class="fas fa-file-upload fa-10x"></i>
                            <?php
                            }
                            ?>
                        </label>
                        <button name="profilResminiGuncelle" class="btn btn-purple" style="margin: 20px 0 0 50px">Profil Resmini Güncelle</button>
                    </div>
                </form>
                <div class="personelIsımler">
                    <input id="ad" type="text" name="ad" placeholder="Ad" readonly value="<?php echo $satir["ad"] ?>">
                    <input id="soyad" type="text" name="soyad" placeholder="Soyad" readonly value="<?php echo $satir["soyad"] ?>">
                    <input id="email" class="kaydetButonKontrol" type="text" name="email" placeholder="Email" value="<?php echo $satir["email"] ?>">
                    <input id="telefon" class="kaydetButonKontrol" type="text" name="telefon" placeholder="Telefon" value="<?php echo $satir["telefon"] ?>">
                </div>
                <div class="personelGiris">
                    <input id="personel_ad" type="text" name="personel_adi" placeholder="Personel Giriş Adı" readonly value="<?php echo $satir["personel_adi"] ?>">
                    <input id="eskiSifre" type="text" name="eskiSifre" placeholder="Şifreniz">
                    <button id="personelKaydetButon" class="personelEkleKaydet btn-purple" style="margin-right:10px" onclick="profilDuzenle()">Kaydet</button>
                </div>
                <div>
                    <button style="margin: 500px 0 0 0" onclick="$('#sifreDegistirModalCenter').modal('show');" class="btn btn-purple"> Şifre Değiştir </button>
                </div>
            </div>

        </div>
        <div class="modal fade" id="sifreDegistirModalCenter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Şifre Değiştir</h5>
                    </div>
                    <div class="modal-body">
                        <input style="margin-bottom: 10px; background-color:purple; color:white;" class="form-control" placeholder="Şifreniz" type="text" id="sifre1">
                        <input style="margin-bottom: 10px; background-color:purple; color:white;" class="form-control" placeholder="Yeni Şifre" type="text" id="sifre2">
                        <input style="margin-bottom: 10px; background-color:purple; color:white;" class="form-control" placeholder="Yeni Şifre Tekrar" type="text" id="sifre3">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-red" data-bs-dismiss="modal">Kapat</button>
                        <button onclick="sifreDegistir();" class="btn btn-purple" type="submit" name="kategoriDegistirButon">Şifreyi Değiştir</button>
                    </div>
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
    var sifreDegistir = function() {
        var eskiSifre = "<?php echo $_SESSION["personel"]["personel_sifre"] ?>";
        var id = <?php echo $_SESSION["personel"]["id"] ?>;
        var sifre2 = $("#sifre2").val();
        if (md5($("#sifre1").val()) == eskiSifre && $("#sifre2").val() == $("#sifre3").val() && $("#sifre2").val().length > 5 && $("#sifre3").val().length > 5) {
            $.ajax({
                type: "POST",
                url: "profilSifreUpdate.php",
                data: {
                    "id": id,
                    "sifre2": sifre2

                },
                success: function() {
                    Swal.fire({
                        text: 'Başarıyla Güncellendi!',
                        icon: 'success',
                        confirmButtonText: 'Tamam',
                        confirmButtonColor: "#800080",
                    })
                    setTimeout(function() {
                        window.location.replace("giris.php");
                    }, 1500)

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


    document.getElementById("personelKaydetButon").disabled = true;
    $(".kaydetButonKontrol").on("input", function() {
        if ($("#email").val().length < 6) {
            document.getElementById("personelKaydetButon").disabled = true;
        } else if ($("#telefon").val().length < 10) {
            document.getElementById("personelKaydetButon").disabled = true;
        } else{
            document.getElementById("personelKaydetButon").disabled = false;
        }
    });

    var profilDuzenle = function() {
        var eskiSifre = "<?php echo $_SESSION["personel"]["personel_sifre"] ?>";
        var id = <?php echo $_SESSION["personel"]["id"] ?>;
        var ad = $("#ad").val();
        var soyad = $("#soyad").val();
        var email = $("#email").val();
        var telefon = $("#telefon").val();

        if (eskiSifre == md5($("#eskiSifre").val())) {

            $.ajax({
                type: "POST",
                url: "profilUpdate.php",
                data: {
                    "id": id,
                    "ad": ad,
                    "soyad": soyad,
                    "email": email,
                    "telefon": telefon

                },
                success: function() {
                    $("#eskiSifre").val("");
                    Swal.fire({
                        text: 'Başarıyla Güncellendi!',
                        icon: 'success',
                        confirmButtonText: 'Tamam',
                        confirmButtonColor: "#800080"
                    })
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