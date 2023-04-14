<?php include "header.php"; ?>

<!-- start banner Area -->
<section class="banner-area relative">
  <div class="overlay overlay-bg" data-aos="fade-up" data-aos-delay="100"></div>
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
        <a href="#main" class="primary-btn text-uppercase">Lihat Detail</a>
      </div>

    </div>
  </div>
  </div>
</section>
<!-- End banner Area -->

<main id="main">
  <!-- Start about-info Area -->
  <section id="peta" class="price-area mb-10 mt-30" data-aos="fade-up" data-aos-delay="100">
    <section id="peta_alat" class="about-info-area mt-50">
      <div class="col-12">
        <div class="title text-center">
          <h1 class="mb-10">Peta Lokasi Alat</h1>
        </div>
      </div>
      <div class="col-12" data-aos="fade-up" data-aos-delay="100">
        <div class="card">
          <div class="card-body">
            <div id="map"></div>
          </div>
        </div>
      </div>
    </section>
  </section>



  <!-- End about-info Area -->
  <section id="list-alat" class="mt-15 mb-5" data-aos="fade-up" data-aos-delay="100">
    <div class="container mt-2">
      <div class="row d-flex justify-content-center mt-10">
        <div class="menu-content pb-9 col-lg-8">
          <div class="title text-center">
            <h1 class="mt-20 mb-10">Daftar Device</h1>
            <p>Menampilkan jumlah alat yang terpasang</p>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="card mx-auto h-100">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-dark w-100">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Device Name</th>
                      <th scope="col">Jarak</th>
                      <th scope="col">Status</th>
                      <th scope="col">Cuaca</th>
                    </tr>
                  </thead>
                  <tbody id="data">
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div>
    <section class="mb-5 mt-10">
      <div class='waktu text-center' id='waktu'></div></br>
    </section>
  </div>
  </section>
  <!-- End testimonial Area -->

</main>

<?php include "footer.php"; ?>

<link rel="stylesheet" href="assets/leaflet/leaflet.css" />
<script src="assets/leaflet/leaflet.js"></script>
<link rel="stylesheet" href="js/LeafletLegend/src/leaflet.legend.css">
<script src="js/LeafletLegend/src/leaflet.legend.js"> </script>

<script src="/js/L.switchBasemap/src/L.switchBasemap.css"></script>
<script src="/js/L.switchBasemap/src/L.switchBasemap.js"></script>

<link rel="stylesheet" href="/js/tagfilter/src/leaflet-tag-filter-button.css" />
<script src="/js/tagfilter/src/leaflet-tag-filter-button.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="stylesheet" href="https://unpkg.com/leaflet.locatecontrol/dist/L.Control.Locate.min.css" />
<script src="https://unpkg.com/leaflet.locatecontrol/dist/L.Control.Locate.min.js"></script>

<!-- Load EasyButton JavaScript -->
<script src="https://unpkg.com/leaflet-easybutton/src/easy-button.js"></script>
<!-- Load Leaflet Routing Machine CSS dan JavaScript -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet-routing-machine/3.2.12/leaflet-routing-machine.css" integrity="sha512-qng4v4a4lWljj9K63DRElN5vS8Fmq5Kln13hPCwulLFGUv7mUy+Qbl9acFq+B3gOv7qwBm1Jz6DNxlY6Ov4izA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-routing-machine/3.2.12/leaflet-routing-machine.min.js" integrity="sha512-5Z1nU6RljLpOhwYFgzsyI1x8y9JpcTfyTJPNMfE3nbVDsZzffJQ3q3G1BLb0xIy8PjjhLoC0yJ+0XXdPzZL/Xw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" /> -->


<script src="assets/js/lokasi.js"></script>


<script type="text/javascript">
  AOS.init();

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