<?php
session_start();
include "../koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">

<?php include "head.php"; ?>

<body>
    <div id="app">
        <?php include "menu_sidebar.php"; ?>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <h3>Profile Statistics</h3>
            </div>
            <div class="page-content">
                <section class="row">
                    <div class="col-12 col-lg-12">
                        <div class="row">
                            <div class="col-6 col-lg-2 col-md-4">
                                <div class="card">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div
                                                class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                <div class="stats-icon purple mb-2">
                                                    <i class="iconly-boldSetting"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <?php
                                                include_once "countalat.php";
                                                $obj = json_decode($data);
                                                $jmlhalat = "";
                                                foreach ($obj->results as $item) {
                                                    $jmlhalat .= $item->alatcount;
                                                }
                                                ?>
                                                <h6 class="text-muted font-semibold">Jumlah Alat</h6>
                                                <h6 class="font-extrabold mb-0"><?php echo $jmlhalat; ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Web Visit</h4>
                                        </div>
                                        <div class="card-body">
                                            <h2>
                                                <center><b>SISTEM INFORMASI GEOGRAFIS </b> </center>
                                            </h2>
                                            <h2>
                                                <center><b>PENDETEKSI DINI BANJIR </b> </center>
                                            </h2>
                                            <h2>
                                                <center><a href="../index.php"><button class="btn btn-primary"
                                                            type="button" href="../index.php">Lihat
                                                            Web</button></a>
                                                </center>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Value Chart</h4>
                                        </div>
                                        <div class="card-body">
                                            <div id="chart"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                </section>
            </div>
            <?php include "footer.php"; ?>
            <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
            <script>


            </script>
</body>

</html>