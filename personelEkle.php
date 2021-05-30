<?php
require "header.php"
?>

<section>
    <div class="personelEkle">
        <form action="" method="POST" class="personelForm">
            <div class="personelIsımler">
                <input type="text" name="ad" placeholder="Ad">
                <input type="text" name="soyad" placeholder="Soyad">
                <input type="text" name="email" placeholder="Email">
                <input type="text" name="telefon" placeholder="Telefon">
                <select name="cinsiyet">
                    <option value="">Cinsiyet Seçiniz</option>
                    <option value="E">Erkek</option>
                    <option value="K">Kadın</option>
                </select>
                <select name="yetki">
                    <option value="">Yetki Seçiniz</option>
                    <option value="A">Yönetici</option>
                    <option value="B">Muhasebe</option>
                    <option value="C">Satış Görevlisi</option>
                    <option value="D">Hizmetli</option>
                </select>
            </div>
            <div class="personelGiris">
                <input type="text" name="personel_adi" placeholder="Personel Giriş Adı">
                <input type="text" name="personel_sifre" placeholder="Personel Giriş Şifre">
                <input type="text" name="personel_sifre2" placeholder="Personel Şifre Tekrar">
                <button class="personelEkleKaydet" type="submit" name="personelEkleButton">Kaydet</button>
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
    }else{
        
    }
}
?>

</body>

</html>