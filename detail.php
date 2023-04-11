<?php include "header.php";


$id = $_GET['id_alat'];
include_once "ambildata_id.php";
$obj = json_decode($data);
$id_alat = "";
$nama_alat = "";
$alamat = "";
$deskripsi = "";
$lat = "";
$long = "";
foreach ($obj->results as $item) {
  $id_alat .= $item->id_alat;
  $nama_alat .= $item->nama_alat;
  $alamat .= $item->alamat;
  $deskripsi .= $item->deskripsi;
  $lat .= $item->latitude;
  $long .= $item->longitude;
}

$title = "Detail dan Lokasi : " . $nama_alat;
//include_once "header.php"; 
?>


<!-- start banner Area -->
<section class="about-banner relative">
  <div class="overlay overlay-bg"></div>
  <div class="container">
    <div class="row d-flex align-items-center justify-content-center">
      <div class="about-content col-lg-12">
        <h1 class="text-white">
          Detail Informasi Geografis alat
        </h1>

      </div>
    </div>
  </div>
</section>
<!-- End banner Area -->
<!-- Start about-info Area -->
<section class="about-info-area section-gap">
  <div class="container" style="padding-top: 120px;">
    <div class="row">

      <div class="col-md-7" data-aos="fade-up" data-aos-delay="200">
        <div class="panel panel-info panel-dashboard">
          <div class="panel-heading centered">
            <h2 class="panel-title"><strong>Informasi alat </strong></h4>
          </div>
          <div class="panel-body">
            <table class="table">
              <tr>
                <!-- <th>Item</th> -->
                <th>Detail</th>
              </tr>
              <tr>
                <td>Nama Alat</td>
                <td>
                  <h5><?php echo $nama_alat ?></h5>
                </td>
              </tr>
              <tr>
                <td>Alamat</td>
                <td>
                  <h5><?php echo $alamat ?></h5>
                </td>
              </tr>
              <tr>
                <td>Deskripsi</td>
                <td>
                  <h5><?php echo $deskripsi ?></h5>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>

      <div class="col-md-5" data-aos="zoom-in">
        <div class="panel panel-info panel-dashboard">
          <div class="panel-heading centered">
            <h2 class="panel-title"><strong>Lokasi</strong></h4>
          </div>
          <div class="panel-body">
            <div id="map-canvas" style="width:100%;height:380px;"></div>
          </div>
        </div>
      </div>
</section>
<!-- End about-info Area -->

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js">
</script>

<script>
  function initialize() {
    // Buat objek peta
    var map = L.map('map-canvas').setView([<?php echo $lat ?>, <?php echo $long ?>], 13);

    // Tambahkan layer peta
    L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
      maxZoom: 20,
      subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    }).addTo(map);

    // Tambahkan marker pada peta
    var marker = L.marker([<?php echo $lat ?>, <?php echo $long ?>]).addTo(map);

    // Tambahkan pop-up pada marker
    marker.bindPopup('<h5><?php echo $nama_alat ?></h5><p><?php echo $alamat ?></p>').openPopup();
  }
  initialize();
</script>
<?php include "footer.php"; ?>