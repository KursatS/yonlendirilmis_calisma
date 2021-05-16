<?php
require "header.php";
$link = "markalar.php?durum=P";
$isim = "Tüm Markaları Göster";

if (isset($_GET["durum"])) {
  $sorgu = $dbbaglanti->prepare("SELECT * FROM markalar ORDER BY markaId");
  $sorgu->execute();
  $link = "markalar.php";
  $isim = "Aktif Markaları Göster";
} elseif (isset($_GET["aramaButon"])) {
  $ara = '%' . $_GET["aramaButon"] . '%';
  $sorgu = $dbbaglanti->prepare("SELECT * FROM markalar WHERE markaAdi LIKE ? OR markaId LIKE ?");
  $sorgu->execute(array(
    $ara, $ara
  ));
} else {
  $sorgu = $dbbaglanti->prepare("SELECT * FROM markalar WHERE markaDurum=? ORDER BY markaId");
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
  $sorgu = $dbbaglanti->prepare("INSERT INTO markalar SET markaAdi = ?");
  $s = $sorgu->execute(array(
    $_POST["markaAdi"]
  ));
  if ($s) {
    header("location:markalar.php");
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript">
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