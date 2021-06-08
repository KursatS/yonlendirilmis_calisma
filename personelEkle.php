<?php
require "header.php"
?>

<section>
    <div class="personelEkle">
        <form action="" method="POST" class="personelForm">
            <div class="personelIsımler">
                <input id="ad" type="text" name="ad" placeholder="Ad">
                <input id="soyad" type="text" name="soyad" placeholder="Soyad">
                <input id="email" type="text" name="email" placeholder="Email">
                <input id="telefon" type="text" name="telefon" placeholder="Telefon">
                <select id="cinsiyet" name="cinsiyet">
                    <option value="P">Cinsiyet Seçiniz</option>
                    <option value="E">Erkek</option>
                    <option value="K">Kadın</option>
                </select>
                <select id="yetki" name="yetki">
                    <option value="P">Yetki Seçiniz</option>
                    <option value="A">Yönetici</option>
                    <option value="B">Muhasebe</option>
                    <option value="C">Satış Görevlisi</option>
                    <option value="D">Hizmetli</option>
                </select>
            </div>
            <div class="personelGiris">
                <input id="personelAdi" type="text" name="personel_adi" placeholder="Personel Giriş Adı">
                <input id="personelSifre" type="text" name="personel_sifre" placeholder="Personel Giriş Şifre">
                <input id="personelSifre2" type="text" name="personel_sifre2" placeholder="Personel Şifre Tekrar">
                <button id="personelKaydetButon" class="personelEkleKaydet btn btn-purple" type="submit" name="personelEkleButton">Kaydet</button>
            </div>
        </form>
    </div>
</section>
<?php
if (isset($_POST["personelEkleButton"])) {
    if ($_POST["personel_sifre"] == $_POST["personel_sifre2"]) {
        $sorgu = $dbbaglanti->prepare("INSERT INTO personeller SET ad = ?, soyad = ?, email = ?, telefon = ?, cinsiyet = ?, yetki = ?, personel_adi = ?, personel_sifre = ?");
        $sorgu->execute(array(
            $_POST["ad"], $_POST["soyad"], $_POST["email"], $_POST["telefon"], $_POST["cinsiyet"], $_POST["yetki"], $_POST["personel_adi"], md5($_POST["personel_sifre"])
        ));
        header("location:personeller.php");
    } else {
    }
}
?>

</body>
<title>Personel</title>

<script>
    var kontrol = function() {
        if ($("#ad").val().length < 2) {
            document.getElementById("personelKaydetButon").disabled = true;
        } else if ($("#soyad").val().length < 2) {
            document.getElementById("personelKaydetButon").disabled = true;
        } else if ($("#email").val().length < 6) {
            document.getElementById("personelKaydetButon").disabled = true;
        } else if ($("#telefon").val().length < 10) {
            document.getElementById("personelKaydetButon").disabled = true;
        } else if ($("#cinsiyet").val() == "P") {
            document.getElementById("personelKaydetButon").disabled = true;
        } else if ($("#yetki").val() == "P") {
            document.getElementById("personelKaydetButon").disabled = true;
        } else if ($("#personelAdi").val().length < 6) {
            document.getElementById("personelKaydetButon").disabled = true;
        } else if ($("#personelSifre").val().length < 6 || $("#personelSifre").val() != $("#personelSifre2").val()) {
            document.getElementById("personelKaydetButon").disabled = true;
        } else if ($("#personelSifre2").val().length < 6 || $("#personelSifre").val() != $("#personelSifre2").val()) {
            document.getElementById("personelKaydetButon").disabled = true;
        } else {
            document.getElementById("personelKaydetButon").disabled = false;
        }
    }

    document.getElementById("personelKaydetButon").disabled = true;
    $("#ad").on("input", function() {
        kontrol();
    });
    $("#soyad").on("input", function() {
        kontrol();
    });
    $("#email").on("input", function() {
        kontrol();
    });
    $("#telefon").on("input", function() {
        kontrol();
    });
    $("#cinsiyet").on("input", function() {
        kontrol();
    });
    $("#yetki").on("input", function() {
        kontrol();
    });
    $("#personelAdi").on("input", function() {
        kontrol();
    });
    $("#personelSifre").on("input", function() {
        kontrol();
    });
    $("#personelSifre2").on("input", function() {
        kontrol();
    });
</script>

</html>