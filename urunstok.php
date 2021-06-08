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
<title>Ürün/Stok Yönetimi</title>

<div class="personelListe">
  <div class="table-wrapper-scroll-y my-custom-scrollbar">
    <div style="margin:10px 0 10px 10px; display:flex; align-items:center;">
      <input style="width: 250px;" placeholder="ID'ye göre arama" type="text" class="form-control" id="aramaText">
      <button class="btn btn-purple" id="aramaButonu">
        <i class="fas fa-search">
        </i>
      </button>
      <select id="aramaTextFiltre" style="width: 100px; margin: 0 10px 0 10px;" class="form-control">
        <option value="0">ID</option>
        <option value="1">İsim</option>
        <option value="2">Marka</option>
        <option value="3">Kategori</option>
        <option value="4">Cinsiyet</option>
        <option value="5">Ayakkabı Numarası</option>
        <option value="6">Renk</option>
      </select>
    </div>
    <table id="urunStokTablosu" class="table table-bordered table-striped mb-0 personellerTablo">
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
<script>
  $("#aramaTextFiltre").change(function() {
    var armt = $("#aramaTextFiltre").val();
    if (armt == "0") {
      $("#aramaText").attr("placeholder", "IDye göre arama");
    } else if (armt == "1") {
      $("#aramaText").attr("placeholder", "İsime göre arama");
    } else if (armt == "2") {
      $("#aramaText").attr("placeholder", "Markaya göre arama");
    } else if (armt == "3") {
      $("#aramaText").attr("placeholder", "Kategoriye göre arama");
    } else if (armt == "4") {
      $("#aramaText").attr("placeholder", "Cinsiyete göre arama");
    } else if (armt == "5") {
      $("#aramaText").attr("placeholder", "Numaraya göre arama");
    } else if (armt == "6") {
      $("#aramaText").attr("placeholder", "Renk göre arama");
    }

    aramaButonu(armt);

  });


  var urunStokTemizle = function() {
    $('#urunStokTablosu tbody').empty();
  }


  var aramaButonu = $("#aramaButonu").click(function() {
    var armt = $("#aramaTextFiltre").val();
    var aramaText = $("#aramaText").val();
    urunStokTemizle();
    $.ajax({
      url: "urunListelemeId.php",
      type: "POST",
      data: {
        'armt': armt,
        'aramaText': aramaText
      },
      success: function(data) {

        data = JSON.parse(data);

        data.forEach(function(islem, index) {
          let satir = $("<tr>")
          let hucre2 = $("<td>").text(islem.urunId)
          let hucre3 = $("<td>").text(islem.urunAdi)
          let hucre4 = $("<td>").text(islem.urunMarka)
          let hucre5 = $("<td>").text(islem.urunKategoriId)
          let hucre6 = $("<td>").text(islem.urunCinsiyet)
          let hucre7 = $("<td>").text(islem.urunStok)
          let hucre8 = $("<td>").text(islem.urunNumara)
          let hucre9 = $("<td>").text(islem.urunRenk)
          let hucre10 = $("<td>").text(islem.urunDurum)
          let hucre11 = $("<td align='center'><a href=" + 'urunDuzenle.php?id=' + islem.urunId + "/ <i class='far fa-edit'></i></a></td>")

          satir.append(hucre2)
          satir.append(hucre3)
          satir.append(hucre4)
          satir.append(hucre5)
          satir.append(hucre6)
          satir.append(hucre7)
          satir.append(hucre8)
          satir.append(hucre9)
          satir.append(hucre10)
          satir.append(hucre11)

          $("#urunStokTablosu").append(satir)
        })
      }
    })

  });
</script>

</html>