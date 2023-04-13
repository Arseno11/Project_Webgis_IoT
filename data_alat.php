<?php include "header.php"; ?>

<header id="header">
  <div class="header-top">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 col-sm-6 col-6 header-top-left">
        </div>
        <div class="col-lg-6 col-sm-6 col-6 header-top-right">
          <div class="header-social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-dribbble"></i></a>
            <a href="#"><i class="fa fa-behance"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container main-menu">
    <div class="row align-items-center justify-content-between d-flex">
      <div id="logo"">
                    <a href=" index.php"><img src="./img/logo.png" alt="Logo" title=""
          style="width: 30px; height: 30px;" /><span style="color: white; font-weight: 500; padding: 5px;">PENDETEKSI
          BANJIR</span>
        </a>
      </div>
      <nav id=" nav-menu-container">
        <ul class="nav-menu">
          <li><a href="index.php">Home</a></li>
          <li><a href="data_alat.php">List Alat</a></li>
          <li><a href="admin/login.php">Login Admin</a></li>
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </div>
</header><!-- #header -->

<!-- start banner Area -->
<section class="about-banner relative">
  <div class="overlay overlay-bg"></div>
  <div class="container">
    <div class="row d-flex align-items-center justify-content-center">
      <div class="about-content col-lg-12">
        <h1 class="text-white">
          Data Alat
        </h1>
        <p class="text-white link-nav">Halaman ini memuat informasi daftar alat yang terpasang</p>
      </div>
    </div>
  </div>
</section>
<!-- End banner Area -->
<!-- Start about-info Area -->
<section class="about-info-area section-gap">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-8 mx-auto" data-aos="fade-up" data-aos-delay="100">
        <div class="panel panel-info panel-dashboard">
          <div class="panel-heading centered">
            <!-- judul panel -->
          </div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-admin text-center">
                <thead>
                  <tr>
                    <th width="5%">No.</th>
                    <th width="30%">Nama Alat</th>
                    <th width="30%">Alamat</th>
                    <th width="20%">Deskripsi</th>
                    <th width="15%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $data = file_get_contents('https://arsen.asistenrumahkopi.com/ambildata.php');
                  $no = 1;
                  if (json_decode($data, true)) {
                    $obj = json_decode($data);
                    foreach ($obj->results as $item) {
                  ?>
                  <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $item->nama_alat; ?></td>
                    <td><?php echo $item->alamat; ?></td>
                    <td><?php echo $item->deskripsi; ?></td>
                    <td class="text-center">
                      <div class="btn-group">
                        <a href="detail.php?id_alat=<?php echo $item->id_alat; ?>" rel="tooltip"
                          data-original-title="Lihat Detail" data-placement="top" class="btn btn-primary">
                          <i class="fa fa-map-marker"></i> Detail dan Lokasi
                        </a>
                      </div>
                    </td>
                  </tr>
                  <?php
                      $no++;
                    }
                  } else {
                    echo "<tr><td colspan='5'>Data tidak ada.</td></tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>
<!-- End about-info Area -->
<?php include "footer.php"; ?>