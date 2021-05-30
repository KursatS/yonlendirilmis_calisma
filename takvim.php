<?php
require "header.php";

$sorgu = $dbbaglanti->prepare("SELECT * FROM olaylar ORDER BY olayId");
$sorgu->execute();
$sorgu2 = $dbbaglanti->prepare("SELECT * FROM olaylar ORDER BY olayId");
$sorgu2->execute();
$sorgu3 = $dbbaglanti->prepare("SELECT * FROM olaylar ORDER BY olayId");
$sorgu3->execute();
?>

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js" integrity="sha512-LGXaggshOkD/at6PFNcp2V2unf9LzFq6LE+sChH7ceMTDP0g2kn6Vxwgg7wkPP7AAtX+lmPqPdxB47A0Nz0cMQ==" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.7.0/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.7.0/locales-all.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.7.0/main.min.css">

<title>Takvim</title>
<style>
  body {
    overflow-y: hidden;
  }
</style>
</head>

<body>
  <div class="tumTakvim">
    <div id="external-events">
      <?php
      while ($satir = $sorgu->fetch(PDO::FETCH_ASSOC)) : ?>
        <div class='fc-event fc-h-event olayTransfer'><?php echo $satir["olayBasligi"] ?></div>
      <?php endwhile; ?>
    </div>
    <div id="external-eventss" class="event-tablee" style="margin-top: 425px; height: 315px !important;">
      <button class="btn btn-purple" data-bs-toggle="modal" data-bs-target="#olayEkleModalCenter">Olay Ekle</button><br>
      <button class="btn btn-purple" data-bs-toggle="modal" data-bs-target="#olaySilModalCenter">Olay Sil</button><br>
      <button class="btn btn-purple" data-bs-toggle="modal" data-bs-target="#olayDuzenleModalCenter">Olay Düzenle</button><br>
    </div>
    <div class="takvim" id="calendar"></div>
  </div>
  <div class="modal fade" id="olayEkleModalCenter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Olay Ekle</h5>
        </div>
        <div class="modal-body">
          <form action="" class="markaForm" method="POST">
            <input name="olayId" type="hidden" id="olayId">
            <input name="olayBasligi" type="text" id="olayBasligi">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-red" data-bs-dismiss="modal">Kapat</button>
          <button class="btn btn-purple" type="submit" name="olayEkleButon">Ekle</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php
  if (isset($_POST["olayEkleButon"])) {
    $olayBasligi = $_POST["olayBasligi"];
    if (strlen($olayBasligi) >= 1 ){
    $sorgu = $dbbaglanti->prepare("INSERT INTO olaylar SET olayBasligi = ?");
    $s = $sorgu->execute(array(
      $_POST["olayBasligi"]
    ));
    if ($s) {
      header("location:takvim.php");
    }}
  }
  ?>
  <div class="modal fade" id="olaySilModalCenter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Olay Sil</h5>
        </div>
        <div class="modal-body">
          <form action="" class="markaForm" method="POST">
            <input name="olayId" type="hidden" id="olayId">
            <select name="olaylar" id="olaylar" class="form-select form-select-lg mb-3">
            <option value="">Seçiniz</option>
              <?php
              while ($satir2 = $sorgu2->fetch(PDO::FETCH_ASSOC)) : ?>
                <option value="<?php echo $satir2["olayId"] ?>"><?php echo $satir2["olayBasligi"] ?></option>
              <?php endwhile; ?>
            </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-red" data-bs-dismiss="modal">Kapat</button>
          <button class="btn btn-purple" type="submit" name="olaySilButon">Sil</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php
  if (isset($_POST["olaySilButon"])) {
    $sorgu = $dbbaglanti->prepare("DELETE FROM olaylar WHERE olayId = ?");
    $s = $sorgu->execute(array(
      $_POST["olaylar"]
    ));
    if ($s) {
      header("location:takvim.php");
    }
  }
  ?>
  ?>
  <div class="modal fade" id="olayDuzenleModalCenter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Olay Düzenle</h5>
        </div>
        <div class="modal-body">
          <form action="" class="markaForm" method="POST">
            <select name="olaylar" id="olaylar" class="form-select form-select-lg mb-3">
              <?php
              while ($satir3 = $sorgu3->fetch(PDO::FETCH_ASSOC)) : ?>
                <option value="<?php echo $satir3["olayId"] ?>"><?php echo $satir3["olayBasligi"] ?></option>
              <?php endwhile; ?>
            </select>
            <input placeholder="Yeni Olay Başlığı" name="olayBasligi" type="text" id="olayBasligi">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-red" data-bs-dismiss="modal">Kapat</button>
          <button onclick="olayDuzenle()" class="btn btn-purple" type="submit" name="olayDuzenleButon">Duzenle</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php
  if (isset($_POST["olayDuzenleButon"])) {
    $olayBasligi = $_POST["olayBasligi"];
    if (strlen($olayBasligi) >= 1 ){
    $sorgu = $dbbaglanti->prepare("UPDATE olaylar SET olayBasligi=? WHERE olayId = ?");
    $s = $sorgu->execute(array(
      $_POST["olayBasligi"], $_POST["olaylar"]
    ));
    if ($s) {
      header("location:takvim.php");
    }}
  }
  ?>

  <script>
    $("#takvimdenOlaySil").click(function() {
      var id1 = takvimdenOlaySil;
      $.ajax({
        url: "takvimDelete.php",
        type: "POST",
        data: {
          id1: id1
        },
        success: function() {
          calendar.refetchEvents();
        }
      })
    });

    document.addEventListener('DOMContentLoaded', function() {
      var containerEl = document.getElementById('external-events');
      var calendarEl = document.getElementById('calendar');
      var Draggable = FullCalendar.Draggable;
      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        editable: true,
        droppable: true,
        height: 749,
        eventColor: '#fffff',
        backgroundColor: '#fffff',
        locale: 'tr',
        selectable: false,
        timeFormat: 'H(:mm)',
        allDaySlot: false,
        firstDay: 1,
        titleFormat: {
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        },
        headerToolbar: {
          start: 'prevYear,prev,next,nextYear today',
          center: 'title',
          end: 'dayGridMonth,timeGridDay',
        },
        buttonText: {
          today: 'Bugün',
          dayGridMonth: 'Ay-Gün Görünümü',
          timeGridDay: 'Gün-Saat Görünümü'
        },
        displayEventEnd: true,
        events: 'takvimOlaylar.php',
        eventResize: function(info) {
          var start1 = moment(info.event.startStr).format('YYYY-MM-DD HH:mm:ss');
          var end1 = moment(info.event.endStr).format('YYYY-MM-DD HH:mm:ss');
          var id = info.event.id;
          $.ajax({
            url: "takvimUpdate.php",
            type: "POST",
            data: {
              start1: start1,
              end1: end1,
              id: id
            },
            success: function() {
              calendar.refetchEvents();
            }
          })
        },
        eventDrop: function(info) {
          var start1 = moment(info.event.startStr).format('YYYY-MM-DD HH:mm:ss');
          var end1 = moment(info.event.endStr).format('YYYY-MM-DD HH:mm:ss');
          var id = info.event.id;
          console.log("fşldgşklfd");
          $.ajax({
            url: "takvimUpdate.php",
            type: "POST",
            data: {
              start1: start1,
              end1: end1,
              id: id
            },
            success: function() {
              calendar.refetchEvents();
            }
          })
        },
        eventClick: function(info) {
          Swal.fire({
            title: 'Takvimden Olayı Sil !',
            text: "Takvimden Olayı Silmek İstediğinize Emin Misiniz?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#800080',
            cancelButtonColor: '#800080',
            confirmButtonText: 'Sil',
            cancelButtonText: 'İptal'
          }).then((result) => {
            if (result.isConfirmed) {
              var id1 = info.event.id;
              $.ajax({
                url: "takvimDelete.php",
                type: "POST",
                data: {
                  id1: id1
                },
                success: function() {
                  calendar.refetchEvents();
                }
              })
            }
          })
        },
        eventReceive: function(info) {
          var title = info.event.title;
          var start = moment(info.event.startStr).format('YYYY-MM-DD HH:mm:ss');
          var end = moment(info.event.endStr).format('YYYY-MM-DD HH:mm:ss');
          $.ajax({
            url: "takvimInsert.php",
            type: "POST",
            data: {
              title: title,
              start: start,
              end: end
            },
            success: function() {
              calendar.refetchEvents();
            }
          })
        }
      });
      calendar.render();

      new Draggable(containerEl, {
        itemSelector: '.fc-event',
        eventData: function(eventEl) {
          return {
            title: eventEl.innerText,
          };
        }
      });

    });
  </script>


  <script>
    moment.locale('tr');
    setInterval(bosOlaySil, 10);

    function bosOlaySil() {
      var bosOlaySil = document.querySelectorAll(".fc-daygrid-event-harness");
      bosOlaySil.forEach((element) => {
        var c = element.childNodes;
        var classes = c[0].className.split(" ");
        classes.forEach((classss) => {
          if (classss == "fc-daygrid-block-event") {
            element.style.display = "none";
          }
        });
      });
    }

    function olayDuzenle() {
      var x = document.getElementById("olaylar").value;
    }
  </script>
</body>

</html>