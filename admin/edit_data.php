    <!DOCTYPE html>
    <html lang="en">

    <!-- head -->
    <?php include "head.php"; ?>
    <!-- end head -->

    <body>
        <div id="app">

            <!-- sidebar -->
            <div id="sidebar" class="active">
                <div class="sidebar-wrapper active">
                    <div class="sidebar-header position-relative">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="logo">
                                <a href="index.php"><img src="assets/images/logo/logo.png" style="width: 50px; height: 50px;" alt="Logo" srcset=""></a>
                                <span>SIG BANJIR</span>
                            </div>
                            <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                                    <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2" opacity=".3"></path>
                                        <g transform="translate(-210 -1)">
                                            <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                            <circle cx="220.5" cy="11.5" r="4"></circle>
                                            <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2">
                                            </path>
                                        </g>
                                    </g>
                                </svg>
                                <div class="form-check form-switch fs-6">
                                    <input class="form-check-input  me-0" type="checkbox" id="toggle-dark">
                                    <label class="form-check-label"></label>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                                    </path>
                                </svg>
                            </div>
                            <div class="sidebar-toggler  x">
                                <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="sidebar-menu">
                        <ul class="menu">
                            <li class="sidebar-title ">Menu</li>
                            <li class="sidebar-item">
                                <a href="index.php" class='sidebar-link'>
                                    <i class="bi bi-grid-fill"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>

                            <li class="sidebar-item active">
                                <a href="tampil_data.php" class='sidebar-link'>
                                    <i class="bi bi-view-list"></i>
                                    <span>List data Alat</span>
                                </a>
                            </li>

                            <li class="sidebar-item ">
                                <a href="tambah_data.php" class='sidebar-link'>
                                    <i class="bi bi-cloud-plus"></i>
                                    <span>Tambah Data Alat</span>
                                </a>
                            </li>

                            <li class="sidebar-item ">
                                <a href="logout.php" class='sidebar-link'>
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Logout</span>
                                </a>
                            </li>
                        </ul>

                        <div id="content">
                            <!-- Konten halaman akan dimuat di sini -->
                        </div>

                        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

                        <script>
                            $(document).ready(function() {
                                // Menambahkan event click pada elemen sidebar-item
                                $('.sidebar-item').click(function() {
                                    // Menghapus kelas "active" dari semua elemen sidebar-item
                                    $('.sidebar-item').removeClass('active');
                                    // Menambahkan kelas "active" ke elemen yang dipilih
                                    $(this).addClass('active');
                                });
                            });
                        </script>

                    </div>
                    <center>
                        <div class="btn btn-primary disabled mt-10 flex">

                            <div class="text-white-600 small ml-auto justify-content-center justify-item-center" id="clock2"></div>
                            <script type='text/javascript'>
                                var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
                                    'September',
                                    'Oktober',
                                    'November', 'Desember'
                                ];
                                var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];
                                var date = new Date();
                                var day = date.getDate();
                                var month = date.getMonth();
                                var thisDay = date.getDay(),
                                    thisDay = myDays[thisDay];
                                var yy = date.getYear();
                                var year = (yy < 1000) ? yy + 1900 : yy;
                                document.getElementById('clock2').innerHTML = thisDay + ', ' + day + ' ' + months[month] +
                                    ' ' +
                                    year; //-->
                            </script>
                            <center>
                                <div class="text-white-600 small" id="clock"></div>
                            </center>
                            <script type="text/javascript">
                                function showTime() {
                                    var a_p = "";
                                    var today = new Date();
                                    var curr_hour = today.getHours();
                                    var curr_minute = today.getMinutes();
                                    var curr_second = today.getSeconds();
                                    if (curr_hour < 12) {
                                        a_p = "AM";
                                    } else {
                                        a_p = "PM";
                                    }
                                    if (curr_hour == 0) {
                                        curr_hour = 12;
                                    }
                                    if (curr_hour > 12) {
                                        curr_hour = curr_hour - 12;
                                    }
                                    curr_hour = checkTime(curr_hour);
                                    curr_minute = checkTime(curr_minute);
                                    curr_second = checkTime(curr_second);
                                    document.getElementById('clock').innerHTML = curr_hour + ":" + curr_minute + ":" +
                                        curr_second +
                                        " " +
                                        a_p;
                                }

                                function checkTime(i) {
                                    if (i < 10) {
                                        i = "0" + i;
                                    }
                                    return i;
                                }
                                setInterval(showTime, 500);
                                //-->
                            </script>
                        </div>
                    </center>
                </div>

            </div>
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
                                        include 'koneksi.php';
                                        $id = $_GET['id_alat'];
                                        $query = mysqli_query($koneksi, "select * from alat where id_alat='$id'");
                                        $data  = mysqli_fetch_array($query);
                                        ?>

                                        <!-- </div> -->
                                        <div class="panel-body">
                                            <form class="form-horizontal style-form" style="margin-top: 20px;" action="edit_aksi.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                                <div class="form-group">
                                                    <label class="col-sm-2 col-sm-2 control-label">ID Alat</label>
                                                    <div class="col-sm-8">
                                                        <input name="id_alat" type="text" id="id_alat" class="form-control" value="<?php echo $data['id_alat']; ?>" readonly />
                                                        <!--<span class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>-->
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 col-sm-2 control-label">Nama Alat</label>
                                                    <div class="col-sm-8">
                                                        <input name="nama_alat" type="text" id="nama_alat" class="form-control" value="<?php echo $data['nama_alat']; ?>" required />
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 col-sm-2 control-label">Alamat</label>
                                                    <div class="col-sm-8">
                                                        <input name="alamat" class="form-control" id="alamat" type="text" value="<?php echo $data['alamat']; ?>" required />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 col-sm-2 control-label">Deskripsi</label>
                                                    <div class="col-sm-8">
                                                        <input name="deskripsi" class="form-control" id="deskripsi" type="text" value="<?php echo $data['deskripsi']; ?>" required />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 col-sm-2 control-label">Latitude</label>
                                                    <div class="col-sm-8">
                                                        <input name="latitude" class="form-control" id="latitude" type="text" value="<?php echo $data['latitude']; ?>" required />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 col-sm-2 control-label">Longitude</label>
                                                    <div class="col-sm-8">
                                                        <input name="longitude" class="form-control" id="longitude" type="text" value="<?php echo $data['longitude']; ?>" required />
                                                    </div>
                                                </div>
                                                <div class="form-group" style="margin-bottom: 20px;">
                                                    <label class="col-sm-2 col-sm-2 control-label"></label>
                                                    <div class="col-sm-8">
                                                        <input type="submit" value="Simpan" class="btn btn-sm btn-primary" />&nbsp;
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