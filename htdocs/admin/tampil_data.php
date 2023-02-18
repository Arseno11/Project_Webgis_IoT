<?php
session_start();
include "../koneksi.php";
?>
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
                            <h3>Data List Alat</h3>
                            <p class="text-subtitle text-muted"></p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Data List Alat</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- Basic Tables start -->
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            Jquery Datatable
                        </div>
                        <div class="card-body">
                            <table class="table" id="table1">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>Nama Alat</th>
                                        <th>Alamat</th>
                                        <th>Deskripsi</th>
                                        <th>Latitude</th>
                                        <th>Longitude</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    $data = mysqli_query($koneksi, "select * from alat");
                                    while ($d = mysqli_fetch_array($data)) {
                                        $no++;
                                    ?>

                                    <tr>
                                        <td>
                                            <?php echo $no ?>
                                        </td>
                                        <td><b><a href="detail_data.php?id_alat=<?php echo $d['id_alat']; ?> ">
                                                    <?php echo $d['nama_alat']; ?>
                                                </a> </b></td>
                                        <td>
                                            <?php echo $d['alamat']; ?>
                                        </td>
                                        <td>
                                            <?php echo $d['deskripsi']; ?>
                                        </td>
                                        <td>
                                            <?php echo $d['latitude']; ?>
                                        </td>
                                        <td>
                                            <?php echo $d['longitude']; ?>
                                        </td>
                                        <td>
                                            <a href="edit_data.php?id_alat=<?php echo $d['id_alat']; ?> "
                                                class="btn btn-primary"><span class="fas fa-edit"></a>
                                            <a href="hapus_aksi.php?id_alat=<?php echo $d['id_alat']; ?>"
                                                class="btn btn-danger delete-link"><span
                                                    class="fas fa-trash"></span></a>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </section>
                <!-- Basic Tables end -->
            </div>

            <?php include "footer.php"; ?>

</body>

</html>