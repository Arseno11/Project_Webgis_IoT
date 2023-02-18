    <!DOCTYPE html>
    <html lang="en">

    <!-- head -->
    <?php include "head.php"; ?>
    <!-- end head -->

    <body>
        <div id="app">

            <!-- sidebar -->
            <?php include "menu_sidebar.php"; ?>
            <!-- endsidebar -->

            <div id="main">
                <header class="mb-3">
                    <a href="#" class="burger-btn d-block d-xl-none">
                        <i class="bi bi-justify fs-3"></i>
                    </a>
                </header>

                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>Edit Data Alat</h3>
                                <p class="text-subtitle text-muted"></p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Edit Data Alat</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Peta Alat</h6>
                                    </div>
                                    <div class="card-body">
                                        <div id="map" style="width:100%;height:480px;"></div>

                                    </div>
                                </div>
                            </div>

                            <!-- DataTales Example -->
                            <div class="col">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Edit Data</h6>
                                    </div>
                                    <div class="card-body">

                                        <?php
                                        include '../koneksi.php';
                                        $id = $_GET['id_alat'];
                                        $query = mysqli_query($koneksi, "select * from alat where id_alat='$id'");
                                        $data  = mysqli_fetch_array($query);
                                        ?>

                                        <!-- </div> -->
                                        <div class="panel-body">
                                            <form class="form-horizontal style-form" style="margin-top: 20px;"
                                                action="edit_aksi.php" method="post" enctype="multipart/form-data"
                                                name="form1" id="form1">
                                                <div class="form-group">
                                                    <label class="col-sm-2 col-sm-2 control-label">ID Alat</label>
                                                    <div class="col-sm-8">
                                                        <input name="id_alat" type="text" id="id_alat"
                                                            class="form-control" value="<?php echo $data['id_alat']; ?>"
                                                            readonly />
                                                        <!--<span class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>-->
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 col-sm-2 control-label">Nama Alat</label>
                                                    <div class="col-sm-8">
                                                        <input name="nama_alat" type="text" id="nama_alat"
                                                            class="form-control"
                                                            value="<?php echo $data['nama_alat']; ?>" required />
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 col-sm-2 control-label">Alamat</label>
                                                    <div class="col-sm-8">
                                                        <input name="alamat" class="form-control" id="alamat"
                                                            type="text" value="<?php echo $data['alamat']; ?>"
                                                            required />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 col-sm-2 control-label">Deskripsi</label>
                                                    <div class="col-sm-8">
                                                        <input name="deskripsi" class="form-control" id="deskripsi"
                                                            type="text" value="<?php echo $data['deskripsi']; ?>"
                                                            required />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 col-sm-2 control-label">Latitude</label>
                                                    <div class="col-sm-8">
                                                        <input name="latitude" class="form-control" id="latitude"
                                                            type="text" value="<?php echo $data['latitude']; ?>"
                                                            required />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 col-sm-2 control-label">Longitude</label>
                                                    <div class="col-sm-8">
                                                        <input name="longitude" class="form-control" id="longitude"
                                                            type="text" value="<?php echo $data['longitude']; ?>"
                                                            required />
                                                    </div>
                                                </div>
                                                <div class="form-group" style="margin-bottom: 20px;">
                                                    <label class="col-sm-2 col-sm-2 control-label"></label>
                                                    <div class="col-sm-8">
                                                        <input type="submit" value="Simpan"
                                                            class="btn btn-sm btn-primary" />&nbsp;
                                                    </div>
                                                </div>
                                                <div style="margin-top: 20px;"></div>
                                            </form>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                </div>

                <?php include "footer.php"; ?>

                <script>
                // Inisialisasi Leaflet
                var map = L.map('map').setView([-7.782850916548009, 110.36699836075287], 13);

                // Tambahkan layer base map dari Google Maps
                L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                }).addTo(map);

                // Tambahkan marker pada peta
                var marker = L.marker([<?php echo $data['latitude']; ?>, <?php echo $data['longitude']; ?>], {
                    draggable: true
                }).addTo(map);

                // Tangkap nilai latitude dan longitude saat marker dipindah
                marker.on('moveend', function(e) {
                    var latLng = e.target.getLatLng();
                    currentLatitude = latLng.lat;
                    currentLongitude = latLng.lng;

                    // Tampilkan nilai latitude dan longitude pada form
                    document.getElementById("latitude").value = currentLatitude;
                    document.getElementById("longitude").value = currentLongitude;
                });

                // Tangkap perubahan nilai pada form dan ubah posisi marker sesuai dengan nilai baru
                document.getElementById("latitude").addEventListener("change", function() {
                    var newLatitude = this.value;
                    marker.setLatLng([newLatitude, currentLongitude]);
                    map.panTo(new L.LatLng(newLatitude, currentLongitude));
                });
                document.getElementById("longitude").addEventListener("change", function() {
                    var newLongitude = this.value;
                    marker.setLatLng([currentLatitude, newLongitude]);
                    map.panTo(new L.LatLng(currentLatitude, newLongitude));
                });
                </script>


    </body>

    </html>