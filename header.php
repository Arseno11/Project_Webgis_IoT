    <!DOCTYPE html>
    <html lang="en">

    <head>

      <meta http-equiv="Content-Security-Policy" charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- Mobile Specific Meta -->
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <!-- Favicon-->
      <link rel="shortcut icon" href="assets/img/fav.png">
      <!-- Author Meta -->
      <meta name="author" content="colorlib">
      <!-- Meta Description -->
      <meta name="description" content="">
      <!-- Meta Keyword -->
      <meta name="keywords" content="">
      <!-- meta character set -->
      <meta charset="UTF-8">
      <!-- Site Title -->
      <title>SIG MONITORING BANJIR</title>

      <link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">
      <link rel="shortcut icon" href="./img/logo.png" type="image/png">

      <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
      <!--==================== CSS ========================= -->
      <link rel="stylesheet" href="assets/css/linearicons.css">
      <link rel="stylesheet" href="assets/css/font-awesome.min.css">
      <link rel="stylesheet" href="assets/css/bootstrap.css">
      <link rel="stylesheet" href="assets/css/bootstrap.css">
      <link rel="stylesheet" href="assets/css/magnific-popup.css">
      <link rel="stylesheet" href="assets/css/jquery-ui.css">
      <link rel="stylesheet" href="assets/css/nice-select.css">
      <link rel="stylesheet" href="assets/css/animate.min.css">
      <link rel="stylesheet" href="assets/css/owl.carousel.css">
      <link rel="stylesheet" href="assets/css/main.css">
      <link rel="stylesheet" href="assets/css/map.css">

      <!-- Tambahkan stylesheet Leaflet dan Font Awesome -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />
      <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->


      <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

      <!-- leaflet -->
      <link rel="stylesheet" href="assets/leaflet/leaflet.css" />
      <script src="assets/leaflet/leaflet.js"></script>


      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
      <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
      <script>
      function encryptUrl(url) {
        var key = CryptoJS.enc.Utf8.parse('kuncirahasia1234567890'); // kunci enkripsi
        var iv = CryptoJS.enc.Utf8.parse('0123456789abcdef'); // initialization vector
        var encrypted = CryptoJS.AES.encrypt(url, key, {
          iv: iv,
          mode: CryptoJS.mode.CBC
        });
        return encrypted.toString();
      }

      var url = "https://arsen.asistenrumahkopi.com/ambildata.php";
      var encryptedUrl = encryptUrl(url);
      console.log(encryptedUrl); // Output: "U2FsdGVkX1+LGpP0n0JcUKbSkXYH51cLl8+0WmzzJyQ="
      </script>



    </head>

    <body>
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
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="container main-menu">
          <div class="row align-items-center justify-content-between d-flex">
            <div id="logo"">
                    <a href=" index.php"><img src="./img/logo.png" alt="Logo" title=""
                style="width: 30px; height: 30px;" /><span
                style="color: white; font-weight: 500; padding: 5px;">PENDETEKSI
                BANJIR</span>
              </a>
            </div>
            <nav id=" nav-menu-container">
              <ul class="nav-menu">
                <li><a href="/">Home</a></li>
                <li><a href="data_alat.php">List Alat</a></li>
                <li><a href="/admin/login.php">Login Admin</a></li>
              </ul>
            </nav><!-- #nav-menu-container -->
          </div>
        </div>
      </header><!-- #header -->