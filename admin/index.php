<?php
session_start();

include "koneksi.php";

// Jika pengguna belum login, redirect ke halaman login
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<?php include "head.php"; ?>

<style>
  .card-body {
    position: relative;
  }

  canvas {
    display: block;
    width: 100%;
  }

  @media screen and (max-width: 576px) {
    canvas {
      max-width: 100%;
      height: auto;
      padding: 10px 15px;
    }
  }

  .loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background-color: rgba(255, 255, 255, 0.8);
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .loader::after {
    content: "";
    width: 100px;
    height: 100px;
    border-radius: 50%;
    border: 10px solid #ccc;
    border-top-color: #333;
    animation: spin 1s ease-in-out infinite;
  }

  @keyframes spin {
    to {
      transform: rotate(360deg);
    }
  }
</style>

<body>
  <div class="loader"></div>
  </div>
  <div id="app">
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
            <li class="sidebar-item active">
              <a href="index.php" class='sidebar-link'>
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
              </a>
            </li>

            <li class="sidebar-item ">
              <a href="tampil_data.php" class='sidebar-link'>
                <i class="bi bi-view-list"></i>
                <span>List data Alat</span>
              </a>
            </li>

            <!-- <li class="sidebar-item ">
                            <a href="tambah_data.php" class='sidebar-link'>
                                <i class="bi bi-cloud-plus"></i>
                                <span>Tambah Data Alat</span>
                            </a>
                        </li> -->

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
              document.getElementById('clock2').innerHTML = thisDay + ', ' + day + ' ' + months[month] + ' ' +
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
                      <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
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
                        <center><a href="../index.php"><button class="btn btn-primary" type="button" href="../index.php">Lihat
                              Web</button></a>
                        </center>
                      </h2>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Add a canvas element to hold the chart -->
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                      <h4>Value Chart</h4>
                    </div>
                    <div class="card-body">
                      <button id="reset-data" class="btn btn-danger float-right btn-sm">Reset Data</button>
                      <div class="chart-container">
                        <canvas id="chart"></canvas>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
        </section>
      </div>


      <?php include "footer.php"; ?>
      <!-- Load Chart.js library -->
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
      <!-- Load Chart.js library -->
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>


      <script>
        // Munculkan loader
        let loaderShown = false;

        function showLoader() {
          if (!loaderShown) {
            document.querySelector('.loader').style.display = 'flex';
            loaderShown = true;
          }
        }

        // Sembunyikan loader
        function hideLoader() {
          document.querySelector('.loader').style.display = 'none';
        }

        // Add event listener to reset data button
        document.getElementById('reset-data').addEventListener('click', function() {
          showLoader(); // tampilkan loader sebelum menghapus data

          // hapus data setelah delay 1 detik
          setTimeout(function() {
            resetData();
          }, 1000);
        });

        // Function to reset data from Local Storage and reload page
        function resetData() {
          // Clear data from localStorage
          localStorage.removeItem('chartData');

          // Reset chart data and labels
          myChart.data.datasets.forEach(dataset => {
            dataset.data = [];
          });
          myChart.data.labels = [];

          // Update chart
          myChart.update();

          hideLoader(); // sembunyikan loader setelah data dihapus
          location.reload(); // muat ulang halaman web
        }

        // Tampilkan loader saat halaman web pertama dimuat
        document.addEventListener('DOMContentLoaded', function() {
          showLoader(); // tampilkan loader saat halaman web pertama dimuat

          // sembunyikan loader setelah delay 1 detik
          setTimeout(function() {
            hideLoader();
          }, 1000);
        });

        // Get the canvas element
        var ctx = document.getElementById('chart').getContext('2d');

        // Create the initial chart
        var myChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: [],
            datasets: []
          },
          options: {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero: true
                }
              }]
            }
          }
        });

        // Function to fetch data and update chart
        function updateChart() {
          fetch('ambildata.php')
            .then(response => response.json())
            .then(data => {
              // Get the last updated time from the first data entry
              var lastUpdateTime = data.results.length > 0 ? data.results[0].waktu : null;

              // Iterate over each result
              data.results.forEach(result => {
                // Check if dataset for this id already exists
                var datasetIndex = myChart.data.datasets.findIndex(dataset => dataset.label === 'Jarak ' + result
                  .id_alat);
                if (datasetIndex === -1) {
                  // If dataset for this id does not exist, create new dataset
                  myChart.data.datasets.push({
                    label: 'Jarak ' + result.id_alat,
                    data: [],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                  });

                  // Create new dataset for hujan
                  myChart.data.datasets.push({
                    label: 'Hujan ' + result.id_alat,
                    data: [],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                  });
                }

                // Update chart data for jarak
                datasetIndex = myChart.data.datasets.findIndex(dataset => dataset.label === 'Jarak ' + result
                  .id_alat);
                if (datasetIndex > -1) {
                  myChart.data.datasets[datasetIndex].data.push(result.jarak);
                }

                // Update chart data for hujan
                datasetIndex = myChart.data.datasets.findIndex(dataset => dataset.label === 'Hujan ' + result
                  .id_alat);
                if (datasetIndex > -1) {
                  myChart.data.datasets[datasetIndex].data.push(result.hujan);
                }
              });

              // Update chart labels
              myChart.data.labels.push(lastUpdateTime);

              // Save chart data to localStorage
              localStorage.setItem('chartData', JSON.stringify(myChart.data));

              // Update chart
              myChart.update();
            })
            .catch(error => console.error(error));
        }

        // Load chart data from localStorage on page load
        var savedChartData = localStorage.getItem('chartData');
        if (savedChartData !== null) {
          myChart.data = JSON.parse(savedChartData);
          myChart.update();
        }

        // Update the chart every second
        setInterval(updateChart, 1000);
      </script>
</body>

</html>