<?php
require "header.php";
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js" integrity="sha512-LGXaggshOkD/at6PFNcp2V2unf9LzFq6LE+sChH7ceMTDP0g2kn6Vxwgg7wkPP7AAtX+lmPqPdxB47A0Nz0cMQ==" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<title>Finans İşlemleri</title>



<div class="finansContainer">
    <div>
        <div class="sonAyinGelirGideri"><canvas class="chart-wrapper2" id="sonAyinGelirGideriChart"></canvas></div>
        <div class="birOncekiAyaGore" style="display: flex; flex-direction:column; justify-content:center;"><canvas id="birOncekiAyaGoreChart"></div>
    </div>
    <div class="finansIslemContainer">
        <div class="ayButonlari">
            <button onclick="ayVerileri(01)" class="btn-purple btn">OCAK</button>
            <button onclick="ayVerileri(02)" class="btn-purple btn">ŞUBAT</button>
            <button onclick="ayVerileri(03)" class="btn-purple btn">MART</button>
            <button onclick="ayVerileri(04)" class="btn-purple btn">NİSAN</button>
            <button onclick="ayVerileri(05)" class="btn-purple btn">MAYIS</button>
            <button onclick="ayVerileri(06)" class="btn-purple btn">HAZİRAN</button>
            <button onclick="ayVerileri(07)" class="btn-purple btn">TEMMUZ</button>
            <button onclick="ayVerileri(08)" class="btn-purple btn">AĞUSTOS</button>
            <button onclick="ayVerileri(09)" class="btn-purple btn">EYLÜL</button>
            <button onclick="ayVerileri(10)" class="btn-purple btn">EKİM</button>
            <button onclick="ayVerileri(11)" class="btn-purple btn">KASIM</button>
            <button onclick="ayVerileri(12)" class="btn-purple btn">ARALIK</button>
        </div>

        <div class="finansIslemBorder scrollable">
            <table id="finansIslemTablosu" class="table table-bordered table-striped mb-0 finansIslemTablo">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" width="100px">ID</th>
                        <th scope="col">İşlem Adı</th>
                        <th scope="col">İşlem Kategorisi</th>
                        <th scope="col">İşlem Türü</th>
                        <th scope="col">İşlem Miktarı</th>
                        <th scope="col">İşlem Tarihi</th>
                        <th scope="col">Düzenle</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div>
            <button style="position:absolute; margin:10px 0px 0px 10px;" onclick="finansIslemHepsi()" class="btn btn-purple" ;>Bütün Verileri Getir</button>
            <button style="position:absolute; margin:55px 0px 0px 10px;" onclick="pasifVerileriGetir()" class="btn btn-purple" ;>Pasif Verileri Getir</button>
            <button style="position:absolute; margin:100px 0px 0px 10px;" onclick="aktifVerileriGetir()" class="btn btn-purple" ;>Aktif Verileri Getir</button>
            <button style="position:absolute; margin:250px 0px 0px 10px;" onclick="document.location.reload(true)" class="btn btn-purple" ;>Gelir Gider Tablosunu Yenile</button>

        </div>

        <div class="finansIslemGirdi">
            <select class="form-select islemKategoriSelect" name="" id="islemKategoriSelect">
                <option value="Seciniz">Seçiniz</option>
                <option value="Urun">Ürün</option>
                <option value="Hizmet">Hizmet</option>
                <option value="Personel">Personel</option>
                <option value="Diger">Diğer</option>
            </select>
            <select class="form-select islemKategoriSelect" name="" id="islemTuru">
                <option value="Seciniz">Seçiniz</option>
                <option value="1">Gelir</option>
                <option value="0">Gider</option>
            </select>
            <input class="form-control islemKategoriSelect" style="display: none;" id="islemAdi" placeholder="İşlem Adı" type="text">
            <input class="form-control islemKategoriSelect" id="islemMiktar" placeholder="Miktar" type="text">
            <div>
                <input type="checkbox" id="bugunemiAit" checked>&nbsp;<label for="bugunemiAit"> Bugüne mi ait? </label>
            </div>
            <input style="display: none; width: 175px; height: 40px; border-radius:5px; border: 1px solid #778899;" type="date" id="dateCheckboxKontrol">
        </div>
        <button class="btn btn-purple finansKaydetButton" id="islemKaydet">Kaydet</button>
    </div>
</div>
<div class="modal fade" id="finansIslemDuzenleModalCenter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Marka Düzenleme </h5>
            </div>
            <div class="modal-body">
                <form action="" class="markaForm islemFormGoruntu" method="POST">
                    <input name="i1" type="hidden" id="islemId">
                    <div>
                        <label style="min-width: 111px;" for="islemAdiText">İşlem Adı</label>
                        <input style="padding: 20px 0px;" name="i2" type="text" id="islemAdiText">
                    </div>
                    <div style="display: flex; height:40px;">
                        <label style="min-width: 111px; left:45px; position:absolute;" for="islemKategorisiText">İşlem Kategorisi</label>
                        <select style="width: 268px; right:59px; position:absolute;" class="form-select islemKategoriSelect" name="" id="islemKategorisiText">
                            <option value="Seciniz">Seçiniz</option>
                            <option value="Urun">Ürün</option>
                            <option value="Hizmet">Hizmet</option>
                            <option value="Personel">Personel</option>
                            <option value="Diger">Diğer</option>
                        </select>
                    </div>
                    <div style="display: flex; height:40px;">
                        <label style="min-width: 111px; left:45px; position:absolute;" for="islemTuruText">İşlem Türü</label>
                        <select style="width: 268px; right:59px; position:absolute;" class="form-select islemKategoriSelect" name="" id="islemTuruText">
                            <option value="Seciniz">Seçiniz</option>
                            <option value="1">Gelir</option>
                            <option value="0">Gider</option>
                        </select>
                    </div>
                    <div>
                        <label style="min-width: 111px; " for="islemMiktariText">İşlem Miktarı</label>
                        <input style="padding: 20px 0px;" name="i2" type="number" id="islemMiktariText">
                    </div>
                    <div>
                        <label style="min-width: 111px;" for="islemTarihiText">İşlem Tarihi</label>
                        <input style="padding: 20px 0px;" name="i2" type="text" id="islemTarihiText">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-red" data-bs-dismiss="modal">Kapat</button>
                <button id="finansIslemDuzenleModalButon" class="btn btn-purple" type="button" onclick="finansIslemDuzenleModal()">Değiştir</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    moment.locale("tr");
    var pasifVerileriGetir = function() {
        $.getJSON("finansIslemListele.php", function(data) {
            removeData(birinciChart);
            finansIslemTemizle();
            data.forEach(function(islem, index) {
                if (islem.islemMiktari == 0) {
                    let islemTuruDegistir = islem.islemTuru == 1 ? "Gelir" : "Gider"
                    let satir = $("<tr>")
                    let hucre2 = $("<td>").text(islem.id)
                    let hucre3 = $("<td>").text(islem.islemAdi)
                    let hucre4 = $("<td>").text(islem.islemKategori)
                    let hucre5 = $("<td>").text(islemTuruDegistir)
                    let hucre6 = $("<td>").text(islem.islemMiktari)
                    let hucre7 = $("<td>").text(islem.islemTarihi)
                    let hucre8 = $("<td align='center'><a href='javascript:void(0)' onclick ='finansIslemDuzenle(" + islem.id + ")'><i class='far fa-edit'></i></a></td>")


                    satir.append(hucre2)
                    satir.append(hucre3)
                    satir.append(hucre4)
                    satir.append(hucre5)
                    satir.append(hucre6)
                    satir.append(hucre7)
                    satir.append(hucre8)

                    $("#finansIslemTablosu").append(satir)
                }
            })
        })
    }
    var aktifVerileriGetir = function() {
        $.getJSON("finansIslemListele.php", function(data) {
            removeData(birinciChart);
            finansIslemTemizle();
            data.forEach(function(islem, index) {
                if (islem.islemMiktari != 0) {
                    let islemTuruDegistir = islem.islemTuru == 1 ? "Gelir" : "Gider"
                    let satir = $("<tr>")
                    let hucre2 = $("<td>").text(islem.id)
                    let hucre3 = $("<td>").text(islem.islemAdi)
                    let hucre4 = $("<td>").text(islem.islemKategori)
                    let hucre5 = $("<td>").text(islemTuruDegistir)
                    let hucre6 = $("<td>").text(islem.islemMiktari)
                    let hucre7 = $("<td>").text(islem.islemTarihi)
                    let hucre8 = $("<td align='center'><a href='javascript:void(0)' onclick ='finansIslemDuzenle(" + islem.id + ")'><i class='far fa-edit'></i></a></td>")


                    satir.append(hucre2)
                    satir.append(hucre3)
                    satir.append(hucre4)
                    satir.append(hucre5)
                    satir.append(hucre6)
                    satir.append(hucre7)
                    satir.append(hucre8)

                    $("#finansIslemTablosu").append(satir)
                }
            })
        })
    }
    var ayVerileri = function(ayVerisi) {
        ayVerisi2 = ayVerisi >= 10 ? ayVerisi : "0" + ayVerisi;
        document.getElementById("dateCheckboxKontrol").value = "2021-" + ayVerisi2 + "-01";
        $.ajax({
            type: "POST",
            url: "finansIslemListeleAyVerileri.php",
            data: ({
                "ayVerisi": ayVerisi
            }),
            success: function(data) {
                finansIslemTemizle();
                data = JSON.parse(data);

                var urunGelir = 0;
                var digerGelir = 0;
                var urunGider = 0;
                var hizmetGider = 0;
                var personelGider = 0;
                var digerGider = 0;

                removeData(birinciChart);

                data.forEach(function(islem, index) {
                    let islemTuruDegistir = islem.islemTuru == 1 ? "Gelir" : "Gider"

                    let satir = $("<tr>")
                    let hucre2 = $("<td>").text(islem.id)
                    let hucre3 = $("<td>").text(islem.islemAdi)
                    let hucre4 = $("<td>").text(islem.islemKategori)
                    let hucre5 = $("<td>").text(islemTuruDegistir)
                    let hucre6 = $("<td>").text(islem.islemMiktari)
                    let hucre7 = $("<td>").text(islem.islemTarihi)
                    let hucre8 = $("<td align='center'><a href='javascript:void(0)' onclick ='finansIslemDuzenle(" + islem.id + ")'><i class='far fa-edit'></i></a></td>")


                    satir.append(hucre2)
                    satir.append(hucre3)
                    satir.append(hucre4)
                    satir.append(hucre5)
                    satir.append(hucre6)
                    satir.append(hucre7)
                    satir.append(hucre8)

                    $("#finansIslemTablosu").append(satir);

                    if (islem.islemKategori == "Urun" && islem.islemTuru == 1) {
                        urunGelir += parseInt(islem.islemMiktari);
                        addData(birinciChart, islem.islemKategori + " " + "Gelir", urunGelir);
                    } else if (islem.islemKategori == "Diger" && islem.islemTuru == 1) {
                        digerGelir += parseInt(islem.islemMiktari);
                        addData(birinciChart, islem.islemKategori + " " + "Gelir", digerGelir);
                    } else if (islem.islemKategori == "Urun" && islem.islemTuru == 0) {
                        urunGider += parseInt(islem.islemMiktari);
                        addData(birinciChart, islem.islemKategori + " " + "Gider", urunGider);
                    } else if (islem.islemKategori == "Hizmet" && islem.islemTuru == 0) {
                        hizmetGider += parseInt(islem.islemMiktari);
                        addData(birinciChart, islem.islemKategori + " " + "Gider", hizmetGider);
                    } else if (islem.islemKategori == "Personel" && islem.islemTuru == 0) {
                        personelGider += parseInt(islem.islemMiktari);
                        addData(birinciChart, islem.islemKategori + " " + "Gider", personelGider);
                    } else if (islem.islemKategori == "Diger" && islem.islemTuru == 0) {
                        digerGider += parseInt(islem.islemMiktari);
                        addData(birinciChart, islem.islemKategori + " " + "Gider", digerGider);
                    }
                })

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

    $("#islemAdiText").on("input", function() {
        if ($("#islemAdiText").val().length < 2) {
            document.getElementById("finansIslemDuzenleModalButon").disabled = true;
        } else {
            document.getElementById("finansIslemDuzenleModalButon").disabled = false;
        }
    });
    $("#islemMiktariText").on("input", function() {
        if ($("#islemMiktariText").val().length < 1) {
            document.getElementById("finansIslemDuzenleModalButon").disabled = true;
        } else {
            document.getElementById("finansIslemDuzenleModalButon").disabled = false;
        }
    });
    $("#islemTarihiText").on("input", function() {
        if ($("#islemTarihiText").val().length < 10) {
            document.getElementById("finansIslemDuzenleModalButon").disabled = true;
        } else {
            document.getElementById("finansIslemDuzenleModalButon").disabled = false;
        }
    });

    var finansIslemDuzenleModal = function() {
        var islemId = $("#islemId").val();
        var islemAdi = $("#islemAdiText").val();
        var islemKategori = $("#islemKategorisiText").val();
        var islemTuru = $("#islemTuruText").val();
        var islemMiktari = $("#islemMiktariText").val();
        var islemTarihi = $("#islemTarihiText").val();
        removeData(birinciChart);

        $.ajax({
            type: "POST",
            url: "finansIslemUpdate.php",
            data: {
                "islemId": islemId,
                "islemAdi": islemAdi,
                "islemKategori": islemKategori,
                "islemTuru": islemTuru,
                "islemMiktari": islemMiktari,
                "islemTarihi": islemTarihi
            },
            success: function() {
                finansIslemTemizle();
                finansIslemListele();
                $("#finansIslemDuzenleModalCenter").modal("hide");
            }


        })
    }

    var finansIslemDuzenle = function(islemId) {
        $.ajax({
            type: "POST",
            url: "finansIslemModalListele.php",
            data: {
                "islemId": islemId
            },
            success: function(data) {
                let islemTuruDegistir = data.islemTuru == 1 ? "Gelir" : "Gider"
                data = JSON.parse(data);
                $('#finansIslemDuzenleModalCenter').modal('show');
                $("#islemId").val(data.islemId);
                $("#islemAdiText").val(data.islemAdi);
                $("#islemKategorisiText").val(data.islemKategori);
                $("#islemTuruText").val(islemTuruDegistir);
                $("#islemMiktariText").val(data.islemMiktari);
                $("#islemTarihiText").val(data.islemTarihi);
            }
        })

    }
    var finansIslemHepsi = function() {
        finansIslemTemizle();
        finansIslemListele();
        removeData(birinciChart);
        addData(birinciChart, "Donut Chart'ı görmek için lütfen bir aya tıklayın.", 1)
    }

    var finansIslemTemizle = function() {
        $('#finansIslemTablosu tbody').empty();
    }

    var finansIslemListele = function() {
        $.getJSON("finansIslemListele.php", function(data) {
            data.forEach(function(islem, index) {
                let islemTuruDegistir = islem.islemTuru == 1 ? "Gelir" : "Gider"
                let satir = $("<tr>")
                let hucre2 = $("<td>").text(islem.id)
                let hucre3 = $("<td>").text(islem.islemAdi)
                let hucre4 = $("<td>").text(islem.islemKategori)
                let hucre5 = $("<td>").text(islemTuruDegistir)
                let hucre6 = $("<td>").text(islem.islemMiktari)
                let hucre7 = $("<td>").text(islem.islemTarihi)
                let hucre8 = $("<td align='center'><a href='javascript:void(0)' onclick ='finansIslemDuzenle(" + islem.id + ")'><i class='far fa-edit'></i></a></td>")


                satir.append(hucre2)
                satir.append(hucre3)
                satir.append(hucre4)
                satir.append(hucre5)
                satir.append(hucre6)
                satir.append(hucre7)
                satir.append(hucre8)

                $("#finansIslemTablosu").append(satir)

            })
        })
    }


    $(document).ready(function() {
        finansIslemListele();
    });


    document.getElementById("bugunemiAit").addEventListener("click", function() {
        if (document.getElementById("bugunemiAit").checked) {
            document.getElementById("dateCheckboxKontrol").style.display = "none";
        } else {
            document.getElementById("dateCheckboxKontrol").style.display = "block";
        }

    });

    document.getElementById("islemKategoriSelect").addEventListener("change", function() {
        if (document.getElementById("islemKategoriSelect").selectedIndex != 4) {
            document.getElementById("islemAdi").style.display = "none";
        } else {
            document.getElementById("islemAdi").style.display = "block";
        }
    });

    document.getElementById("islemKaydet").addEventListener("click", function() {
        var islemKategori = $("#islemKategoriSelect").val();
        var islemTuru = $("#islemTuru").val();
        var islemAdi = $("#islemAdi").val();
        if (islemAdi == "") {
            islemAdi = $("#islemKategoriSelect").val();
        }
        var islemMiktar = $("#islemMiktar").val();
        removeData(birinciChart);
        addData(birinciChart, "Donut Chart'ı görmek için lütfen bir aya tıklayın.", 1);
        if (!document.getElementById("bugunemiAit").checked) {
            var islemTarih = $("#dateCheckboxKontrol").val();
        } else {
            var islemTarih = moment().format();
        }
        if (islemKategori != "Seciniz" && islemTuru != "Seciniz" && islemAdi != "" && islemMiktar != "") {

            $.ajax({
                url: "finansIslemInsert.php",
                type: "POST",
                data: {
                    islemKategori: islemKategori,
                    islemTuru: islemTuru,
                    islemAdi: islemAdi,
                    islemMiktar: islemMiktar,
                    islemTarih: islemTarih
                },
                success: function() {
                    $("#islemKategoriSelect").val("Seciniz");
                    $("#islemTuru").val("Seciniz");
                    $("#islemAdi").val("");
                    $("#islemMiktar").val("");
                    document.getElementById("bugunemiAit").checked = true;
                    document.getElementById("islemAdi").style.display = "none";
                    document.getElementById("dateCheckboxKontrol").style.display = "none";
                    finansIslemTemizle();
                    finansIslemListele();
                }
            });
        } else {
            Swal.fire({
                text: 'Girilen Bilgiler Eksik!',
                icon: 'warning',
                confirmButtonText: 'Tamam',
                confirmButtonColor: "#800080"
            })
        }
    });

    var birinciChart = new Chart(
        document.getElementById('sonAyinGelirGideriChart'),
        config = {
            type: 'doughnut',
            data: {
                labels: ["Donut Chart'ı görmek için lütfen bir aya tıklayın."],
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
    birinciChart.canvas.height = 400;
    birinciChart.canvas.width = 400;

    $.ajax({
        type: "POST",
        url: "ikinciChartVeri.php",
        data: {
            "birOncekiAy": moment().subtract(1, 'months').format('M'),
            "buAy": moment().format('M')
        },
        success: function(data) {
            data = JSON.parse(data);

            var giderleriTopla = 0;
            var gelirleriTopla = 0;
            data[0].forEach((element) => {
                if (element.islemTuru == 1) {
                    gelirleriTopla += parseInt(element.islemMiktari);
                } else {
                    giderleriTopla += parseInt(element.islemMiktari);
                }
            })
            var giderleriTopla2 = 0;
            var gelirleriTopla2 = 0;
            data[1].forEach((element) => {
                if (element.islemTuru == 1) {
                    gelirleriTopla2 += parseInt(element.islemMiktari);
                } else {
                    giderleriTopla2 += parseInt(element.islemMiktari);
                }
            })

            var ikinciChart = document.getElementById("birOncekiAyaGoreChart").getContext('2d');
            var ikinciChart = new Chart(ikinciChart, {
                type: 'bar',
                data: {
                    labels: [moment().subtract(1, 'months').format('MMMM'), moment().format('MMMM')],
                    options: {
                        responsive: true,
                    },
                    datasets: [{
                            label: "Giderler",
                            data: [giderleriTopla, giderleriTopla2],
                            backgroundColor: [
                                'rgba(255, 99, 132)',
                                'rgba(255, 99, 132)',
                            ],
                            borderColor: [
                                '#000000'
                            ]
                        },
                        {
                            label: "Gelirler",
                            data: [gelirleriTopla, gelirleriTopla2],
                            backgroundColor: [
                                'rgba(54, 162, 235)',
                                'rgba(54,162, 235)',
                            ]
                        }
                    ]
                }
            });
        }
    })
</script>