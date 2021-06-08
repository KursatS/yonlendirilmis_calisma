<?php
require "header.php";
$link = "markalar.php?durum=P";
$isim = "Tüm Markaları Göster";

if (isset($_GET["durum"])) {
  $sorgu = $dbbaglanti->prepare("SELECT * FROM markalar ORDER BY markaId");
  $sorgu->execute();
  $link = "markalar.php";
  $isim = "Aktif Markaları Göster";
} else {
  $sorgu = $dbbaglanti->prepare("SELECT * FROM markalar WHERE markaDurum=? ORDER BY markaId");
  $sorgu->execute(array(
    "A"
  ));
}
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<title>Markalar</title>


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
    <table id="markaTablosu" class="table table-bordered table-striped mb-0 personellerTablo">
      <thead class="thead-dark">
        <tr>
          <th scope="col" width="100px">ID</th>
          <th scope="col">Marka</th>
          <th scope="col">Durum</th>
          <th scope="col">Düzenle</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while ($satir = $sorgu->fetch(PDO::FETCH_ASSOC)) : ?>
          <tr>
            <th scope="row"><?php echo $satir["markaId"] ?></th>
            <td><?php echo $satir["markaAdi"] ?></td>
            <td><?php echo $satir["markaDurum"] ?></td>
            <td align="center"><a data-markaadi="<?php echo $satir["markaAdi"] ?>" data-markadurum="<?php echo $satir["markaDurum"] ?>" data-bs-toggle="modal" data-bs-target="#markaDuzenleModalCenter" class="modalaData" data-markaid="<?php echo $satir["markaId"] ?>"><i class="far fa-edit"></i></a></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

  </div>
  <div class="personelEkleButton">
    <button type="button" class="btn btn-light"><a href="<?= $link ?>"><?= $isim ?></a></button>&nbsp;&nbsp;&nbsp;
    <button type="button" class="btn btn-light"><a href="markalar.php">Markalar</a></button>&nbsp;&nbsp;&nbsp;
    <button type="button" class="btn btn-light"><a href="kategoriler.php">Kategoriler</a></button>&nbsp;&nbsp;&nbsp;
    <button type="button" class="btn btn-light"><a data-bs-toggle="modal" data-bs-target="#exampleModalCenter">Marka Ekle</a></button>&nbsp;&nbsp;&nbsp;
  </div>
</div>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Marka Ekleme </h5>
      </div>
      <div class="modal-body">
        <form action="" method="POST" class="markaForm">
          <input type="text" name="markaAdi" placeholder="Marka" id="markaAdiText" value="">
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
<div class="modal fade" id="markaDuzenleModalCenter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Marka Düzenleme </h5>
      </div>
      <div class="modal-body">
        <form action="" class="markaForm" method="POST">
          <input name="m1" type="hidden" id="markaId">
          <input name="m2" type="text" id="markaAdi">
          Aktif mi?
          <input name="m3" type="checkbox" id="markaDurum">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-red" data-bs-dismiss="modal">Kapat</button>
        <button class="btn btn-purple" type="submit" name="markaDegistirButon">Değiştir</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
if (isset($_POST["markaEkleButton"])) {
  if (strlen($_POST["markaAdi"]) >= 1) {
    $sorgu = $dbbaglanti->prepare("INSERT INTO markalar SET markaAdi = ?");
    $s = $sorgu->execute(array(
      $_POST["markaAdi"]
    ));
    if ($s) {
      header("location:markalar.php");
    }
  }
}
?>
<?php
if (isset($_POST["markaDegistirButon"])) {
  if (isset($_POST["m3"])) {
    $durum = "A";
  } else {
    $durum = "P";
  }
  $sorgu = $dbbaglanti->prepare("UPDATE markalar SET markaAdi=?, markaDurum=? WHERE markaId=?");
  $c = $sorgu->execute(array(
    $_POST["m2"], $durum, $_POST["m1"]
  ));
  if ($c) {
    header("location:markalar.php");
  }
}

?>

<script type="text/javascript">
  $("#markaTablosu").on('click', '.modalaData', function(e) {
    $("#markaDuzenleModalCenter").modal('show');
    var markaId = $(this).attr("data-markaid");
    var markaAdi = $(this).attr("data-markaadi");
    var markaDurum = $(this).attr("data-markadurum");

    $("#markaAdi").val(markaAdi);
    $("#markaId").val(markaId);
    if (markaDurum == 'A') {
      $("#markaDurum").prop('checked', true);
    }
  })



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
    $('#markaTablosu tbody').empty();
  }


  var aramaButonu = $("#aramaButonu").click(function() {
    var armt = $("#aramaTextFiltre").val();
    var aramaText = $("#aramaText").val();
    urunStokTemizle();
    $.ajax({
      url: "markaListeleme.php",
      type: "POST",
      data: {
        'armt': armt,
        'aramaText': aramaText
      },
      success: function(data) {
        data = JSON.parse(data);

        data.forEach(function(islem, index) {
          let satir = $("<tr>")
          let hucre2 = $("<td>").text(islem.markaId)
          let hucre3 = $("<td>").text(islem.markaAdi)
          let hucre4 = $("<td>").text(islem.markaDurum)
          let hucre5 = $("<td align='center'><a data-markaadi='" + islem.markaAdi + "' data-markadurum='" + islem.markaDurum + "' class='modalaData' data-markaid='" + islem.markaId + "'><i class='far fa-edit'></i></a></td>")

          satir.append(hucre2)
          satir.append(hucre3)
          satir.append(hucre4)
          satir.append(hucre5)


          $("#markaTablosu").append(satir)
        })
      }
    })

  });




  $(document).ready(function() {
    $('.modalaData').click(function() {
      var markaId = $(this).attr("data-markaid");
      var markaAdi = $(this).attr("data-markaadi");
      var markaDurum = $(this).attr("data-markadurum");

      $("#markaAdi").val(markaAdi);
      $("#markaId").val(markaId);
      if (markaDurum == 'A') {
        $("#markaDurum").prop('checked', true);
      }

    });
  });
</script>
</body>

</html>