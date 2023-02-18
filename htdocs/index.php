<?php include "header.php"; ?>

<!-- start banner Area -->
<section class="banner-area relative">
    <div class="overlay overlay-bg"></div>
    <div class="container">
        <div class="row fullscreen align-items-center justify-content-between">
            <div class="col-lg-6 col-md-6 banner-left">
                <h6 class="text-white">SISTEM INFORMASI GEOGRAFIS ALAT</h6>
                <h1 class="text-white">PENDETEKSI DINI BANJIR</h1>
                <p class="text-white">
                    Sistem informasi ini merupakan aplikasi pemetaan geografis tempat alat pendeteksi dini banjir
                    dipasang.
                    Aplikasi ini memuat informasi dan lokasi dari Alat.
                </p>
                <a href="#peta_alat" class="primary-btn text-uppercase">Lihat Detail</a>
            </div>

        </div>
    </div>
    </div>
</section>
<!-- End banner Area -->

<main id="main">


    <!-- Start about-info Area -->
    <section class="price-area section-gap ">
        <section id="peta_alat" class="about-info-area section-gap">
            <div class="container col-xl-8">

                <div class="title text-center">
                    <h1 class="mb-10">Peta Lokasi Alat</h1>
                    <br>
                </div>
                <div class="col-xl-12">
                    <div class="card ">
                        <div class="card-body ">
                            <div id="map" style="width:100%;height:680px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End about-info Area -->


        <!-- Start price Area -->

        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="menu-content pb-70 col-lg-8">
                    <div class="title text-center">
                        <h1 class="mb-10">Jangkauan Peta</h1>
                        <p>Aplikasi pemetaan geografis Alat Pendeteksi Dini Banjir ini memuat informasi dan lokasi dari
                            Alat Pendeteksi Dini Banjir. Pemetaan diambil dari data lokasi Google Maps. Aplikasi ini
                            memuat sejumlah informasi
                            mengenai :
                        </p>
                    </div>
                </div>
            </div>

            <!-- End other-issue Area -->

        </div>
        <!-- ======= Counts Section ======= -->
        <section id="counts">
            <div class="container">
                <div class="title text-center">
                    <h1 class="mb-10">Jumlah Alat Terpasang</h1>
                    <br>
                </div>
                <div class="row d-flex justify-content-center">


                    <?php
                    include_once "countalat.php";
                    $obj = json_decode($data);
                    $jmlhalat = "";
                    foreach ($obj->results as $item) {
                        $jmlhalat .= $item->alatcount;
                    }
                    ?>

                    <div class="text-center">
                        <h1><span data-toggle="counter-up"><?php echo $jmlhalat; ?></span></h1>
                        <br>
                    </div>
                </div>

            </div>
        </section><!-- End Counts Section -->
    </section>
    <!-- End testimonial Area -->

</main>

<?php include "footer.php"; ?>

<link rel="stylesheet" href="assets/leaflet/leaflet.css" />
    <script src="assets/leaflet/leaflet.js"></script>
<link rel="stylesheet" href="js/LeafletLegend/src/leaflet.legend.css">
<script src="js/LeafletLegend/src/leaflet.legend.js"> </script>


<script type="text/javascript">
navigator.geolocation.getCurrentPosition(function(location) {
    var latlng = new L.LatLng(location.coords.latitude, location.coords.longitude);


    var map = L.map('map').setView([-7.782793615552607, 110.36728950566525], 13);
    // Tambahkan layer base map dari Google Maps
            L.tileLayer('http://{s}.google.com/vt?lyrs=s,h&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }).addTo(map);

    const legend = L.control.Legend({
        title: "Status Icon",
        position: "bottomright",
        collapsed: false,
        symbolWidth: 30,
        opacity: 1,
        column: 2,
        legends: [{
            label: "Bahaya",
            type: "image",
            url: "img/bahaya.png",
        }, {
            label: "Awas",
            type: "image",
            url: "img/awas.png"
        }, {
            label: "Aman",
            type: "image",
            url: "img/aman.png"
        }]
    }).addTo(map);


           // Fungsi untuk memuat data dari file ambildata.php
        function loadData() {
            // Menggunakan AJAX untuk mengambil data dari file ambildata.php
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Mengubah data menjadi objek JavaScript
                    var data = JSON.parse(this.responseText);

                    // Membuat array kosong untuk menampung data lokasi alat
                    var deviceLocations = [];

                    // Menambahkan setiap lokasi alat ke dalam array
                    for (var i = 0; i < data.results.length; i++) {
                        var item = data.results[i];
                        deviceLocations.push({
                            id: item.id_alat,
                            name: item.nama_alat,
                            address: item.alamat,
                            distance: item.jarak,
                            rainfall: item.hujan,
                            longitude: item.longitude,
                            latitude: item.latitude
                        });
                    }

                    // Memanggil fungsi untuk menampilkan marker di peta
                    showMarkers(deviceLocations);
                }
            };
            xhttp.open("GET", "https://sig-banjir.epizy.com/ambildata.php", true);
            xhttp.send();
        }

        // Fungsi untuk menampilkan marker di peta
        function showMarkers(deviceLocations) {
            // Membuat loop untuk setiap lokasi alat
            for (var i = 0; i < deviceLocations.length; i++) {
                var deviceLocation = deviceLocations[i];

                // Memeriksa status hujan dan jarak air
                if (deviceLocation.distance <= 10) {
                    // Menentukan ikon marker dan konten popup
                    var iconUrl = 'img/bahaya.png';
                    var status = 'Bahaya';
                } else if (deviceLocation.distance <= 25) {
                    var iconUrl = 'img/awas.png';
                    var status = 'Awas';
                } else {
                    var iconUrl = 'img/aman.png';
                    var status = 'Aman';
                }

                // Membuat marker di peta
                var marker = L.marker([deviceLocation.latitude, deviceLocation.longitude], {
                    title: deviceLocation.name,
                    icon: L.icon({
                        iconUrl: iconUrl,
                        iconSize: [30, 45], // ukuran ikon
                        popupAnchor: [-1, -20]
                    })
                });

                // Menambahkan popup ke marker
                marker.bindPopup("<h6> Nama Alat: " + deviceLocation.name + "</h6> <h6><p> Status: " + status + "</p></h6>" +
                    "<div class='waktu' id='waktu'></div>" + "</br>" +
                    "<br>" +
                    "<h6>Jarak Air: " + deviceLocation.distance + " cm" + "</h6></br>" +
                    "<a class='btn btn-success btn-sm' href='detail.php?id_alat=" + deviceLocation.id + "'> Info Detail </a>" +
                    "<a class='btn btn-warning btn-sm' target='_blank' href='https://www.google.com/maps/dir/?api=1&origin=" + location.coords.latitude + "," + location.coords.longitude +
                    "&destination=" + deviceLocation.latitude + "," + deviceLocation.longitude +
                    "'>Rute</a>");

                // Menambahkan marker ke peta
                marker.addTo(map);
            }
        }

        // Memanggil fungsi loadData() saat halaman dimuat
        loadData();
});

function tampilkanWaktu() {
    // Mengambil objek tanggal dan waktu saat ini
    const tanggal = new Date();

    // Menyiapkan array hari
    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

    // Menampilkan waktu, nama hari, dan tanggal dalam elemen div dengan ID "waktu"
    document.getElementById('waktu').innerHTML =
        days[tanggal.getDay()] +
        ', ' +
        tanggal.getDate() +
        ' ' +
        getMonthName(tanggal.getMonth()) +
        ' ' +
        tanggal.getFullYear() +
        '</br>' +
        tanggal.toLocaleTimeString()
}

// Mengembalikan nama bulan dari nomor bulan
function getMonthName(month) {
    const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
        'Oktober', 'November', 'Desember'
    ];
    return monthNames[month];
}

// Jalankan fungsi tampilkanWaktu setiap 1 detik
setInterval(tampilkanWaktu, 1000);
</script>

</body>

</html>