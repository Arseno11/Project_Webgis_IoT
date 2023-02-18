<?php
session_start();
if (empty($_SESSION['username'])) {
    header('location:../index.php');
} else {
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
                            <h3>Detail Data Alat</h3>
                            <p class="text-subtitle text-muted"></p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Detail Data Alat</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <?php
                    $id = $_GET['id_alat'];
                    $query = mysqli_query($koneksi, "select * from alat where id_alat='$id'");
                    $data  = mysqli_fetch_array($query);
                    ?>

                <?php } ?>
                <div class="container-fluid">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h5 class="m-0 font-weight-bold text-white-600">Detail alat
                                <span class="m-0 text-warning">
                                    <?php echo $data['nama_alat']; ?></span>
                            </h5>
                        </div>
                        <div class="card-body">

                            <div class="panel-body">
                                <table id="example" class="table table-hover table-bordered">
                                    <tr>
                                        <td width="250">Nama alat</td>
                                        <td width="550"><?php echo $data['nama_alat']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td><?php echo $data['alamat']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Deskripsi</td>
                                        <td><?php echo $data['deskripsi']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Latitude</td>
                                        <td><?php echo $data['latitude']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Longitude</td>
                                        <td><?php echo $data['longitude']; ?></td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Basic Tables end -->
            </div>

            <?php include "footer.php"; ?>

</body>

</html>