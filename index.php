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
    <section class="price-area mb-10 section-gap">
        <section id="peta_alat" class="about-info-area mt-5">
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

        <!-- <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="menu-content pb-20 col-lg-8">
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
        <!-- </div> -->

        <section>

            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="menu-content pb-9 col-lg-8">
                        <div class="title text-center">
                            <h1 class="mb-10">Tabel Alat</h1>
                            <p>Menampilkan jumlah alat yang terpasang
                            </p>
                        </div>
                    </div>
                    <table class="table table-striped table-dark mb-10">
                        <thead class="table-dark">
                            <tr>
                                <th scope=" col">#</th>
                                <th scope="col">Device Name</th>
                                <th scope="col">Distance</th>
                                <th scope="col">Status</th>
                                <th scope="col">weather</th>
                            </tr>
                        </thead>
                        <tbody id="data">
                        </tbody>
                    </table>
                </div>
        </section>


        <section>
            <div class='waktu text-center' id='waktu'></div></br>
        </section>

        <!-- ======= Counts Section ======= -->
        <!-- <section id="counts">
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
        </section>End Counts Section -->
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


        // fungsi untuk memanggil data dari API
        async function loadData() {
            try {
                const response = await fetch('http://localhost/SIG-BANJIR/ambildata.php');
                if (!response.ok) {
                    throw new Error('Terjadi kesalahan saat memuat data.');
                }
                const data = await response.json();

                // memformat data menjadi objek yang diinginkan
                const deviceLocations = data.results.map(item => ({
                    id: item.id_alat,
                    name: item.nama_alat,
                    address: item.alamat,
                    distance: item.distance,
                    rainfall: item.cuaca,
                    longitude: item.longitude,
                    latitude: item.latitude
                }));

                // Menghapus marker yang telah ada sebelumnya
                for (let i = 0; i < markers.length; i++) {
                    map.removeLayer(markers[i]);
                }
                markers = [];

                // memanggil fungsi untuk menampilkan marker di peta
                showMarkers(deviceLocations);
            } catch (error) {
                console.error(error);
            }
        }

        // fungsi untuk menampilkan marker di peta
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
                marker.bindPopup("<h6> Nama Alat: " + deviceLocation.name + "</h6> <h6><p> Status: " + status +
                    "</p></h6>" +
                    "<h6>Jarak Air: " + deviceLocation.distance + " cm" + "</h6></br>" +
                    "<a class='btn btn-success btn-sm' href='detail.php?id_alat=" + deviceLocation.id +
                    "'> Info Detail </a>" +
                    "<a class='btn btn-warning btn-sm' target='_blank' href='https://www.google.com/maps/dir/?api=1&origin=" +
                    location.coords.latitude + "," + location.coords.longitude +
                    "&destination=" + deviceLocation.latitude + "," + deviceLocation.longitude +
                    "'>Rute</a>");

                // Menambahkan marker ke peta dan ke array markers
                marker.addTo(map);
                markers.push(marker);
            }
        }

        // Array untuk menyimpan marker
        let markers = [];

        // Mengubah interval menjadi 5 detik (5000 ms)
        setInterval(loadData, 2000);

        // Memanggil loadData() untuk pertama kali saat halaman dimuat
        loadData();

    });




    function updateData() {
        fetch('ambildata.php')
            .then(response => response.json())
            .then(data => {
                if (data.hasOwnProperty('error')) {
                    $("#data").html(`<tr><td colspan="5" style="text-align: center;">${data.error}</td></tr>`);
                } else {
                    let html = '';
                    for (let i = 0; i < data.results.length; i++) {
                        let result = data.results[i];

                        let siaga;

                        if (result.distance <= 10) {
                            siaga = '<td style = color:red>Siaga 1</td>';
                        } else if (result.distance > 10 && result.distance <= 25) {
                            siaga = '<td style = color:yellow>Siaga 2</td>';
                        } else {
                            siaga = '<td style = color:green>Aman</td>';
                        }

                        let cuaca;
                        if (result.cuaca < 450) {
                            cuaca = '<td>Hujan Deras</td>';
                        } else if (result.cuaca >= 450 && result.cuaca < 800) {
                            cuaca = '<td>Hujan Sedang</td>';
                        } else if (result.cuaca >= 800) {
                            cuaca = '<td>Cerah</td>';
                        }

                        html += `
              <tr>
                <td>${i + 1}</td>
                <td>${result.nama_alat}</td>
                <td>${result.distance} cm</td>
                ${siaga}
                ${cuaca}
              </tr>
            `;
                    }

                    $("#data").html(html);
                }
            })
            .catch(error => {
                console.log('Error fetching');
            });
    }

    setInterval(function() {
        updateData();
    }, 1000); // Mengambil data setiap 5 detik


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