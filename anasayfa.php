<?php
require "header.php";
$ac = fopen("girisLoglari.txt", "a");
$ad = $_SESSION["personel"]["ad"];
$zaman = strval(date('d.m.Y H:i:s'));

$yaz = fwrite($ac, $_SESSION["personel"]["id"] . " -- ");
$yaz = fwrite($ac, $ad . " -- ");
$yaz = fwrite($ac, $_SESSION["personel"]["soyad"] . " -- ");
$yaz = fwrite($ac, $_SESSION["personel"]["telefon"] . " -- ");
$yaz = fwrite($ac, $zaman . "\n");
fclose($ac);
?>

<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>
<section class="kutucuk">
    <div class="kutucuklar yazi">

    </div>
    <div class="kutucuklar yazi"><canvas class="chart-wrapper" id="azKalanUrunlerChart"></canvas>
        <p style="position: absolute; right:130px; top:220px; font-size:25px">Az Kalan Ürünler</p>
        <div>
            <label style="position: absolute; right:225px; top:330px;" for="">Ürün Sayısını Girin</label>
            <input style="position: absolute; right:250px; top:370px; width:70px;" id="urunSayisi" class="form-control" type="text">
            <button style="position: absolute; right:130px; top:370px;" onclick="azKalanUrunleriGoster()" class="btn btn-purple">Göster</button>
        </div>
    </div>
    <div class="kutucuklar yazi">
        <p style="position: absolute; left: 630px; top:590px; font-size:25px;">Giriş Logları</p>
        <textarea style="resize: none; width: 100%; height: 90%; font-size: 25px; margin-top:30px;" name="" id="" cols="30" rows="10">
    <?php
    $oku = fopen("girisLoglari.txt", "r");
    while (!feof($oku)) {
        $satir = fgets($oku);
        echo $satir . "";
    }

    ?></textarea>
    </div>
    <div class="kutucuklar notKutucugu">
        <form action="" method="POST"><textarea name="notlar" id="notlar" placeholder=" Notlar"><?php print_r($_SESSION["personel"]["kullanici_not"]) ?></textarea><button type="submit" class="notlarKaydet btn-purple" name="notlarKaydet">Kaydet</button></form>
    </div>
</section>
<?php
if (isset($_POST["notlarKaydet"])) {
    $not = htmlspecialchars($_POST["notlar"]);
    $_SESSION["personel"]["kullanici_not"] = $not;
    $sorgu = $dbbaglanti->prepare("UPDATE personeller SET kullanici_not=? WHERE id=?");
    $sorgu->execute(array(
        $not, $_SESSION["personel"]["id"]
    ));
    header("location:anasayfa.php");
}
?>
</body>
<script>
    var azKalanUrunleriGoster = function() {
        var urunSayisi = $("#urunSayisi").val();
        $.ajax({
            type: "POST",
            url: "azKalanUrunleriListele.php",
            data: {
                "urunSayisi": urunSayisi
            },
            success: function(data) {
                data = JSON.parse(data);
                removeData(birinciChart);
                data.forEach((data) => {
                    addData(birinciChart, data.urunId + " " + data.urunAdi, data.urunStok);
                });
                console.log(data[0]);
            }
        })
    }

    function removeData(chart) {
        chart.data.labels.pop();
        chart.data.labels.pop();
        chart.data.labels.pop();
        chart.data.labels.pop();
        chart.data.labels.pop();
        chart.data.labels.pop();
        chart.data.datasets.forEach((dataset) => {
            dataset.data.pop();
            dataset.data.pop();
            dataset.data.pop();
            dataset.data.pop();
            dataset.data.pop();
            dataset.data.pop();
        });
        chart.update();
    }

    function addData(chart, label, data) {
        chart.data.labels.push(label);
        chart.data.datasets.forEach((dataset) => {
            dataset.data.push(data);
        });
        chart.update();
    }

    var birinciChart = new Chart(
        document.getElementById('azKalanUrunlerChart'),
        config = {
            type: 'pie',
            data: {
                labels: [],
                datasets: [{
                    label: '# of Votes',
                    data: [1],
                    backgroundColor: [
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)',
                        'rgba(75, 192, 192)',
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)',
                        'rgba(75, 192, 192)',
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {}
        }

    );

    birinciChart.options.plugins.legend.position = 'right';
    birinciChart.update();
</script>

</html>