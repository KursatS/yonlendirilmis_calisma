<?php
require "header.php";
$link = "kategoriler.php?durum=P";
$isim = "Tüm Kategorileri Göster";

if (isset($_GET["durum"])) {
  $sorgu = $dbbaglanti->prepare("SELECT * FROM kategori ORDER BY kategoriId");
  $sorgu->execute();
  $link = "kategoriler.php";
  $isim = "Aktif Kategorileri Göster";
} elseif (isset($_GET["aramaButon"])) {
  $ara = '%' . $_GET["aramaButon"] . '%';
  $sorgu = $dbbaglanti->prepare("SELECT * FROM kategori WHERE kategoriAdi LIKE ? OR kategoriId LIKE ?");
  $sorgu->execute(array(
    $ara, $ara
  ));
} else {
  $sorgu = $dbbaglanti->prepare("SELECT * FROM kategori WHERE kategoriDurum=? ORDER BY kategoriId");
  $sorgu->execute(array(
    "A"
  ));
}
?>
<title>Kategoriler</title>


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
      </select>
    </div>
    <table id="kategorilerTablosu" class="table table-bordered table-striped mb-0 personellerTablo">
      <thead class="thead-dark">
        <tr>
          <th scope="col" width="100px">ID</th>
          <th scope="col">Kategori</th>
          <th scope="col">Durum</th>
          <th scope="col">Düzenle</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while ($satir = $sorgu->fetch(PDO::FETCH_ASSOC)) : ?>
          <tr>
            <th scope="row"><?php echo $satir["kategoriId"] ?></th>
            <td><?php echo $satir["kategoriAdi"] ?></td>
            <td><?php echo $satir["kategoriDurum"] ?></td>
            <td align="center"><a id='modalaVeriGonder' data-kategoriadi="<?php echo $satir["kategoriAdi"] ?>" data-kategoridurum="<?php echo $satir["kategoriDurum"] ?>" data-bs-toggle="modal" data-bs-target="#kategoriDuzenleModalCenter" class="modalaData" data-kategoriid="<?php echo $satir["kategoriId"] ?>"><i class="far fa-edit"></i></a></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

  </div>
  <div class="personelEkleButton">
    <button type="button" class="btn btn-light"><a href="<?= $link ?>"><?= $isim ?></a></button>&nbsp;&nbsp;&nbsp;
    <button type="button" class="btn btn-light"><a href="markalar.php">Markalar</a></button>&nbsp;&nbsp;&nbsp;
    <button type="button" class="btn btn-light"><a href="kategoriler.php">Kategoriler</a></button>&nbsp;&nbsp;&nbsp;
    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><a>Kategori Ekle</a></button>&nbsp;&nbsp;&nbsp;
  </div>
</div>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Kategori Ekleme </h5>
      </div>
      <div class="modal-body">
        <form action="" method="POST" class="markaForm">
          <input type="text" name="markaAdi" placeholder="Kategori" value="">
      </div>
      <div class="personelGiris">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-red" data-bs-dismiss="modal">Kapat</button>
        <button class="btn btn-purple" type="submit" name="markaEkleButton">Ekle</button>
      </div>
    </div>
  </div>
</div>
</form>
<div class="modal fade" id="kategoriDuzenleModalCenter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Kategori Düzenleme </h5>
      </div>
      <div class="modal-body">
        <form action="" class="markaForm" method="POST">
          <input name="k1" type="hidden" id="kategoriId">
          <input name="k2" type="text" id="kategoriAdi">
          Aktif mi?
          <input name="k3" type="checkbox" id="kategoriDurum">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-red" data-bs-dismiss="modal">Kapat</button>
        <button class="btn btn-purple" type="submit" name="kategoriDegistirButon">Değiştir</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
if (isset($_POST["markaEkleButton"])) {
  if (strlen($_POST["kategoriAdi"]) >= 1) {
    $sorgu = $dbbaglanti->prepare("INSERT INTO kategori SET kategoriAdi = ?");
    $s = $sorgu->execute(array(
      $_POST["markaAdi"]
    ));
    if ($s) {
      header("location:kategoriler.php");
    }
  }
}
?>
<?php
if (isset($_POST["kategoriDegistirButon"])) {
  if (isset($_POST["k3"])) {
    $durum = "A";
  } else {
    $durum = "P";
  }
  $sorgu = $dbbaglanti->prepare("UPDATE kategori SET kategoriAdi=?, kategoriDurum=? WHERE kategoriId=?");
  $c = $sorgu->execute(array(
    $_POST["k2"], $durum, $_POST["k1"]
  ));
  if ($c) {
    header("location:kategoriler.php");
  }
}

?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript">
  $("#aramaTextFiltre").change(function() {
    var armt = $("#aramaTextFiltre").val();
    if (armt == "0") {
      $("#aramaText").attr("placeholder", "IDye göre arama");
    } else if (armt == "1") {
      $("#aramaText").attr("placeholder", "İsime göre arama");
    }

    aramaButonu(armt);

  });


  var urunStokTemizle = function() {
    $('#kategorilerTablosu tbody').empty();
  }


  var aramaButonu = $("#aramaButonu").click(function() {
    var armt = $("#aramaTextFiltre").val();
    var aramaText = $("#aramaText").val();
    urunStokTemizle();
    $.ajax({
      url: "kategoriListeleme.php",
      type: "POST",
      data: {
        'armt': armt,
        'aramaText': aramaText
      },
      success: function(data) {
        data = JSON.parse(data);

        data.forEach(function(islem, index) {
          let satir = $("<tr>")
          let hucre2 = $("<td>").text(islem.kategoriId)
          let hucre3 = $("<td>").text(islem.kategoriAdi)
          let hucre4 = $("<td>").text(islem.kategoriDurum)
          let hucre5 = $("<td align='center'><a data-kategoriadi= '" + islem.kategoriAdi + "' data-kategoridurum= '" + islem.kategoriDurum + "' class='modalaData' data-kategoriid= '" + islem.kategoriId + "' ><i class='far fa-edit'></i></a></td>")

          satir.append(hucre2)
          satir.append(hucre3)
          satir.append(hucre4)
          satir.append(hucre5)

          $("#kategorilerTablosu").append(satir)

        })
      }
    })

  });

  $("#kategorilerTablosu").on('click', '.modalaData', function(e) {
    $("#kategoriDuzenleModalCenter").modal('show');
    var kategoriId = $(this).attr("data-kategoriid");
    var kategoriAdi = $(this).attr("data-kategoriadi");
    var kategoriDurum = $(this).attr("data-kategoridurum");
    $("#kategoriAdi").val(kategoriAdi);
    $("#kategoriId").val(kategoriId);
    if (kategoriDurum == 'A') {
      $("#kategoriDurum").prop('checked', true);
    }
  })




  $(document).ready(function() {
    $('.modalaData').click(function() {
      var kategoriId = $(this).attr("data-kategoriid");
      var kategoriAdi = $(this).attr("data-kategoriadi");
      var kategoriDurum = $(this).attr("data-kategoridurum");
      $("#kategoriAdi").val(kategoriAdi);
      $("#kategoriId").val(kategoriId);
      if (kategoriDurum == 'A') {
        $("#kategoriDurum").prop('checked', true);
      }

    });
  });
</script>
</body>

</html>