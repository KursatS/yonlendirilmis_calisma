<?php
require "header.php";
$link = "personeller.php?durum=P";
$isim = "Tüm Personelleri Göster";

if (isset($_GET["durum"])) {
  $sorgu = $dbbaglanti->prepare("SELECT * FROM personeller ORDER BY id");
  $sorgu->execute();
  $link = "personeller.php";
  $isim = "Aktif Personelleri Göster";
} else {
  $sorgu = $dbbaglanti->prepare("SELECT * FROM personeller WHERE durum=? ORDER BY id");
  $sorgu->execute(array(
    "A"
  ));
}

?>

<title>Personeller</title>



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
        <option value="2">Soyisim</option>
        <option value="3">E-Posta</option>
        <option value="4">Telefon</option>
        <option value="5">Cinsiyet</option>
      </select>
    </div>
    <table id="personelTablo" class="table table-bordered table-striped mb-0 personellerTablo">
      <thead class="thead-dark">
        <tr>
          <?php if ($_SESSION["personel"]["yetki"] == "D") : ?>
            <th scope="col" width="100px">ID</th>
            <th scope="col">İsim</th>
            <th scope="col">Soyisim</th>
            <th scope="col">Telefon Numarası</th>
            <th scope="col">Mail Adresi</th>
            <th scope="col">Yetki</th>
            <th scope="col">Durum</th>
          <?php endif ?>
          <?php if ($_SESSION["personel"]["yetki"] == "C") : ?>
            <th scope="col" width="100px">ID</th>
            <th scope="col">İsim</th>
            <th scope="col">Soyisim</th>
            <th scope="col">Telefon Numarası</th>
            <th scope="col">Mail Adresi</th>
            <th scope="col">Yetki</th>
            <th scope="col">Durum</th>
          <?php endif ?>
          <?php if ($_SESSION["personel"]["yetki"] == "B") : ?>
            <th scope="col" width="100px">ID</th>
            <th scope="col">İsim</th>
            <th scope="col">Soyisim</th>
            <th scope="col">Telefon Numarası</th>
            <th scope="col">Mail Adresi</th>
            <th scope="col">Yetki</th>
            <th scope="col">Durum</th>
            <th scope="col">Düzenle</th>
          <?php endif ?>
          <?php if ($_SESSION["personel"]["yetki"] == "A") : ?>
            <th scope="col" width="100px">ID</th>
            <th scope="col">İsim</th>
            <th scope="col">Soyisim</th>
            <th scope="col">Telefon Numarası</th>
            <th scope="col">Mail Adresi</th>
            <th scope="col">Yetki</th>
            <th scope="col">Durum</th>
            <th scope="col">Düzenle</th>
          <?php endif ?>
        </tr>
      </thead>
      <tbody>
        <?php if ($_SESSION["personel"]["yetki"] == "A") : ?>
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
        <?php endif ?>
        <?php if ($_SESSION["personel"]["yetki"] == "B") : ?>
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
        <?php endif ?>
        <?php if ($_SESSION["personel"]["yetki"] == "C") : ?>
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
            </tr>
          <?php endwhile; ?>
        <?php endif ?>

      </tbody>
    </table>

  </div>
  <?php if ($_SESSION["personel"]["yetki"] == "A") : ?>
    <div class="personelEkleButton">
      <button type="button" class="btn btn-light"><a href="<?= $link ?>"><?= $isim ?></a></button>&nbsp;&nbsp;&nbsp;
      <button type="button" class="btn btn-light"><a href="personelEkle.php">Personel Ekle</a></button>
    </div>
  <?php endif ?>
  <?php if ($_SESSION["personel"]["yetki"] == "B") : ?>
    <div class="personelEkleButton">
      <button type="button" class="btn btn-light"><a href="<?= $link ?>"><?= $isim ?></a></button>&nbsp;&nbsp;&nbsp;
      <button type="button" class="btn btn-light"><a href="personelEkle.php">Personel Ekle</a></button>
    </div>
  <?php endif ?>

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
      $("#aramaText").attr("placeholder", "Soyisime göre arama");
    } else if (armt == "3") {
      $("#aramaText").attr("placeholder", "E-Postaya göre arama");
    } else if (armt == "4") {
      $("#aramaText").attr("placeholder", "Telefona göre arama");
    } else if (armt == "5") {
      $("#aramaText").attr("placeholder", "Cinsiyete göre arama");
    }

    aramaButonu(armt);

  });


  var urunStokTemizle = function() {
    $('#personelTablo tbody').empty();
  }


  var aramaButonu = $("#aramaButonu").click(function() {
    var armt = $("#aramaTextFiltre").val();
    var aramaText = $("#aramaText").val();
    urunStokTemizle();
    $.ajax({
      url: "personelListeleme.php",
      type: "POST",
      data: {
        'armt': armt,
        'aramaText': aramaText
      },
      success: function(data) {
        data = JSON.parse(data);

        data.forEach(function(islem, index) {
          let satir = $("<tr>")
          let hucre1 = $("<td>").text(islem.id)
          let hucre2 = $("<td>").text(islem.ad)
          let hucre3 = $("<td>").text(islem.soyad)
          let hucre4 = $("<td>").text(islem.telefon)
          let hucre5 = $("<td>").text(islem.email)
          let hucre6 = $("<td>").text(islem.yetki)
          let hucre7 = $("<td>").text(islem.durum)
          let hucre8 = $("<td align='center'><a href=" + 'personelDuzenle.php?id=' + islem.id + "/ <i class='far fa-edit'></i></a></td>")

          satir.append(hucre1)
          satir.append(hucre2)
          satir.append(hucre3)
          satir.append(hucre4)
          satir.append(hucre5)
          satir.append(hucre6)
          satir.append(hucre7)
          satir.append(hucre8)

          $("#personelTablo").append(satir)
        })
      }
    })

  });
</script>

</html>