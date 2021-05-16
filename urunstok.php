<?php
require "header.php";
$link = "urunstok.php?durum=P";
$isim = "Tüm Ürünleri Göster";

if (isset($_GET["durum"])) {
  $sorgu = $dbbaglanti->prepare("SELECT * FROM urunler ORDER BY urunId");
  $sorgu->execute();
  $link = "urunstok.php";
  $isim = "Aktif Ürünleri Göster";
} elseif (isset($_GET["aramaButon"])) {
  $ara = '%' . $_GET["aramaButon"] . '%';
  $sorgu = $dbbaglanti->prepare("SELECT * FROM urunler WHERE urunAdi LIKE ? OR urunMarka LIKE ? OR urunId LIKE ? OR urunKategoriId LIKE ?");
  $sorgu->execute(array(
    $ara, $ara, $ara, $ara
  ));
} else {
  $sorgu = $dbbaglanti->prepare("SELECT * FROM urunler WHERE urunDurum=? ORDER BY urunId");
  $sorgu->execute(array(
    "A"
  ));
}

function categoryConverter($id, $db)
{
  $sorgu = $db->prepare("SELECT * FROM kategori WHERE kategoriId=?");
  $sorgu->execute(array($id));
  $row = $sorgu->fetch(PDO::FETCH_ASSOC);
  return $row["kategoriAdi"];
}
function markaConverter($id, $db)
{
  $sorgu = $db->prepare("SELECT * FROM markalar WHERE markaId=?");
  $sorgu->execute(array($id));
  $row = $sorgu->fetch(PDO::FETCH_ASSOC);
  return $row["markaAdi"];
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
          <th scope="col">Ürün İsmi</th>
          <th scope="col">Marka</th>
          <th scope="col">Kategori</th>
          <th scope="col">Cinsiyet</th>
          <th scope="col">Stok</th>
          <th scope="col">Ayakkabı Numarası</th>
          <th scope="col">Renk</th>
          <th scope="col">Durum</th>
          <th scope="col">Düzenle</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while ($satir = $sorgu->fetch(PDO::FETCH_ASSOC)) : ?>
          <tr>
            <th scope="row"><?php echo $satir["urunId"] ?></th>
            <td><?php echo $satir["urunAdi"] ?></td>
            <td><?php echo markaConverter($satir["urunMarka"], $dbbaglanti) ?></td>
            <td><?php echo categoryConverter($satir["urunKategoriId"], $dbbaglanti) ?></td>
            <td><?php echo $satir["urunCinsiyet"] ?></td>
            <td><?php echo $satir["urunStok"] ?></td>
            <td><?php echo $satir["urunNumara"] ?></td>
            <td><?php echo $satir["urunRenk"] ?></td>
            <td><?php echo $satir["urunDurum"] ?></td>
            <td align="center"><a href="urunDuzenle.php?id=<?php echo $satir["urunId"] ?>"><i class="far fa-edit"></i></a></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

  </div>
  <div class="personelEkleButton">
    <button type="button" class="btn btn-light"><a href="<?= $link ?>"><?= $isim ?></a></button>&nbsp;&nbsp;&nbsp;
    <button type="button" class="btn btn-light"><a href="markalar.php">Markalar</a></button>&nbsp;&nbsp;&nbsp;
    <button type="button" class="btn btn-light"><a href="kategoriler.php">Kategoriler</a></button>&nbsp;&nbsp;&nbsp;
    <button type="button" class="btn btn-light"><a href="urunEkle.php">Ürün Ekle</a></button>&nbsp;&nbsp;&nbsp;
  </div>
</div>
</body>

</html>