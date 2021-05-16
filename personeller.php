<?php
require "header.php";
$link = "personeller.php?durum=P";
$isim = "Tüm Personelleri Göster";

if (isset($_GET["durum"])) {
  $sorgu = $dbbaglanti->prepare("SELECT * FROM personeller ORDER BY id");
  $sorgu->execute();
  $link = "personeller.php";
  $isim = "Aktif Personelleri Göster";
} elseif (isset($_GET["aramaButon"])) {
  $ara = '%' . $_GET["aramaButon"] . '%';
  $sorgu = $dbbaglanti->prepare("SELECT * FROM personeller WHERE ad LIKE ? OR soyad LIKE ? OR id LIKE ?");
  $sorgu->execute(array(
    $ara, $ara, $ara
  ));
} else {
  $sorgu = $dbbaglanti->prepare("SELECT * FROM personeller WHERE durum=? ORDER BY id");
  $sorgu->execute(array(
    "A"
  ));
}

?>



<div class="personelListe">
  <div class="table-wrapper-scroll-y my-custom-scrollbar">
    <div class="aramaKutucugu">
      <form action="" method="GET"><input type="text" name="aramaButon" id=""><button class="aramaKutucuguButon" type="submit"><i class="fas fa-search"></i></button></form>
    </div>
    <table class="table table-bordered table-striped mb-0 personellerTablo">
      <thead class="thead-dark">
        <tr>
          <th scope="col" width="100px">ID</th>
          <th scope="col">İsim</th>
          <th scope="col">Soyisim</th>
          <th scope="col">Telefon Numarası</th>
          <th scope="col">Mail Adresi</th>
          <th scope="col">Yetki</th>
          <th scope="col">Durum</th>
          <th scope="col">Düzenle</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while ($satir = $sorgu->fetch(PDO::FETCH_ASSOC)) : ?>
          <tr>
            <th scope="row"><?php echo $satir["id"] ?></th>
            <td><?php echo $satir["ad"] ?></td>
            <td><?php echo $satir["soyad"] ?></td>
            <td><?php echo $satir["telefon"] ?></td>
            <td><?php echo $satir["email"] ?></td>
            <td><?php echo $satir["yetki"] ?></td>
            <td><?php echo $satir["durum"] ?></td>
            <td align="center"><a href="personelDuzenle.php?id=<?php echo $satir["id"] ?>"><i class="far fa-edit"></i></a></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

  </div>
  <div class="personelEkleButton">
    <button type="button" class="btn btn-light"><a href="<?= $link ?>"><?= $isim ?></a></button>&nbsp;&nbsp;&nbsp;
    <button type="button" class="btn btn-light"><a href="personelEkle.php">Personel Ekle</a></button>
  </div>
</div>


</body>

</html>