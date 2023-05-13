navigator.geolocation.getCurrentPosition(function (location) {
  var latlng = new L.LatLng(location.coords.latitude, location.coords.longitude);
  var isMobile = window.matchMedia("only screen and (max-width: 768px)").matches;

  var map = L.map('map', {
    center: [-7.782793615552607, 110.36728950566525],
    zoom: 13,
    scrollWheelZoom: true // Menonaktifkan zoom dengan scroll
  });

  // Nonaktifkan scrollWheelZoom di perangkat mobile
  if (isMobile) {
    map.scrollWheelZoom.disable();
  }

  // Tambahkan layer base map dari Google Maps
  L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
    maxZoom: 20,
    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
  }).addTo(map);

  var osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
  });

  var googleSatelliteLayer = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
    maxZoom: 20,
    subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
    detectRetina: true
  });

  var googleStreetsLayer = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
    maxZoom: 20,
    subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
    detectRetina: true
  });


  var populationLayer = L.tileLayer('https://tiles.wmflabs.org/bw-mapnik/{z}/{x}/{y}.png', {
    maxZoom: 18,
    attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
  });

  var bordersLayer = L.tileLayer('https://tile-{s}.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors, <a href="https://hot.openstreetmap.org/">Humanitarian OpenStreetMap Team</a>'
  });


  var baseMaps = {
    "OpenStreetMap": osmLayer,
    "Google Satellite": googleSatelliteLayer,
    "Google Streets": googleStreetsLayer,
  };

  var overlayMaps = {
    "Population Density": populationLayer,
    "Borders": bordersLayer,
  };

  L.control.layers(baseMaps, overlayMaps).addTo(map);

  const legend = L.control.Legend({
    title: "Status Icon",
    position: "bottomright",
    // collapsed: true, // Set default state to collapsed
    symbolWidth: 30,
    opacity: 1,
    column: 2,
    legends: [{
      label: "Bahaya",
      type: "image",
      url: "img/bahaya.png",
    }, {
      label: "Awas",
      type: "image",
      url: "img/awas.png"
    }, {
      label: "Aman",
      type: "image",
      url: "img/aman.png"
    }]
  }).addTo(map);

  var lc = L.control.locate({
    position: 'topleft',
    icon: 'fa fa-user', // menggunakan ikon map-marker
    iconLoading: 'fa fa-spinner fa-spin',
    setView: 'once',
    locateOptions: {
      maxZoom: 30,
      enableHighAccuracy: true
    },
    style: {
      // mengubah gaya ikon untuk membuatnya lebih besar dan berwarna biru seperti Google
      fillColor: '#4285F4',
      fillOpacity: 0.8,
      stroke: false,
      radius: 10
    },
    iconSize: [50, 50]
  }).addTo(map);

  // deklarasi variabel untuk menyimpan popup yang sedang terbuka
  let currentPopup = null;


  // fungsi untuk memanggil data dari API
  async function loadData() {
    try {
      const response = await fetch('ambildata.php');
      if (!response.ok) {
        throw new Error('Terjadi kesalahan saat memuat data.');
      }
      const data = await response.json();

      // memformat data menjadi objek yang diinginkan
      const deviceLocations = data.results.map(item => ({
        id: item.id_alat,
        name: item.nama_alat,
        address: item.alamat,
        jarak: item.jarak,
        rainfall: item.hujan,
        longitude: item.longitude,
        latitude: item.latitude
      }));

      // Menghapus marker yang telah ada sebelumnya
      for (let i = 0; i < markers.length; i++) {
        map.removeLayer(markers[i]);
      }
      markers = [];


      // Menutup popup yang sedang terbuka jika ada
      if (currentPopup) {
        currentPopup._close();
      }

      // memanggil fungsi untuk menampilkan marker di peta
      showMarkers(deviceLocations);
    } catch (error) {
      console.error(error);
    }
  }

  // fungsi untuk menampilkan marker di peta
  function showMarkers(deviceLocations) {

    // Membuat loop untuk setiap lokasi alat
    for (var i = 0; i < deviceLocations.length; i++) {
      var deviceLocation = deviceLocations[i];

      // Memeriksa status hujan dan jarak air
      // Memeriksa status hujan dan jarak air
      let iconUrl;
      let status;
      let currentCircle = null; // inisialisasi variabel

      if (deviceLocation.jarak <= 10) {
        // Menentukan ikon marker dan konten popup
        iconUrl = 'img/bahaya.png';
        status = 'Bahaya';
      } else if (deviceLocation.jarak <= 25) {
        iconUrl = 'img/awas.png';
        status = 'Awas';
      } else {
        iconUrl = 'img/aman.png';
        status = 'Aman';
      }

      // Membuat marker di peta
      var marker = L.marker([deviceLocation.latitude, deviceLocation.longitude], {
        title: deviceLocation.name,
        icon: L.icon({
          iconUrl: iconUrl,
          iconSize: [30, 45], // ukuran ikon
          popupAnchor: [-1, -20]
        })
      });

      // Menambahkan popup ke marker
      var popupContent =
        `<h6> Nama Alat: ${deviceLocation.name}</h6> 
      <h6><p> Status: ${status}</p></h6>
      <h6>Jarak Air: ${deviceLocation.jarak} cm</h6></br>
      <a class='btn btn-success btn-sm' href='detail.php?id_alat=${deviceLocation.id}'> Info Detail </a>
      <a class='btn btn-warning btn-sm' target='_blank' href='https://www.google.com/maps/dir/?api=1&origin=${location.coords.latitude},${location.coords.longitude}&destination=${deviceLocation.latitude},${deviceLocation.longitude}&travelmode=driving'>Rute</a>`;

      // Menambahkan konten popup ke marker
      marker.bindPopup(popupContent);
      // Menambahkan marker ke peta dan ke array markers
      marker.addTo(map);
      markers.push(marker);
      // Menambahkan event listener mouseover pada marker
      marker.on('click', function () {
        this.openPopup();
      });
    }
  }

  // Array untuk menyimpan marker
  markers = [];

  // fungsi untuk memanggil data dari API
  async function loadData() {
    try {
      const response = await fetch('ambildata.php');
      if (!response.ok) {
        throw new Error('Terjadi kesalahan saat memuat data.');
      }
      const data = await response.json(); // memformat data menjadi objek yang diinginkan
      const deviceLocations = data.results.map(item => ({
        id: item.id_alat,
        name: item.nama_alat,
        address: item.alamat,
        jarak: item.jarak,
        rainfall: item.hujan,
        longitude: item.longitude,
        latitude: item.latitude
      }));

      // Menghapus marker yang telah ada sebelumnya
      for (let i = 0; i < markers.length; i++) {
        map.removeLayer(markers[i]);
      }
      markers = [];

      // memanggil fungsi untuk menampilkan marker di peta
      showMarkers(deviceLocations);

    } catch (error) {
      console.error(error);
    }

  }

  // fungsi untuk melakukan refresh data setiap 5 detik
  function refreshData() {
    setInterval(function () {
      loadData();
    }, 3000); // set interval ke 5 detik (5000 ms)
  }

  // panggil fungsi refreshData() saat halaman dimuat
  refreshData();
});


// Fungsi untuk menampilkan SweetAlert
function showAlert(icon, title, text) {
  Swal.fire({
    icon: icon,
    title: title,
    text: text,
  }).then((result) => {
    if (result.isConfirmed) {
      localStorage.setItem('showAlert', 'false');
    }
  });
}

// Fungsi untuk menghapus item local storage ketika halaman di-reload atau ditutup
window.addEventListener('beforeunload', function () {
  localStorage.removeItem('showAlert');
  for (let i = 0; i < localStorage.length; i++) {
    let key = localStorage.key(i);
    if (key.includes('showAlert_')) {
      localStorage.removeItem(key);
    }
  }
});

function updateData() {
  fetch('ambildata.php', {
    headers: {
      'Cache-Control': 'no-cache'
    },
    cache: 'no-cache'
  })
    .then(response => response.json())
    .then(data => {
      let errorIds = []; // Inisialisasi array untuk menyimpan id alat yang error
      let html = '';

      for (let i = 0; i < data.results.length; i++) {
        let result = data.results[i];
        let siaga, hujan;

        if (result.jarak <= 10) {
          siaga = '<td style=color:red>Siaga 1</td>';
          if (localStorage.getItem('showAlert_' + result.id_alat) !== 'false') {
            showAlert('error', 'Peringatan Banjir', 'Jarak sensor telah mencapai Siaga 1 untuk Alat Dengan Nama ' + result.nama_alat, 5000);
            localStorage.setItem('showAlert_' + result.id_alat, 'false');
            localStorage.removeItem('showAlert_' + result.id_alat + '_siaga2');
          }
        } else if (result.jarak > 10 && result.jarak <= 25) {
          siaga = '<td style=color:yellow>Siaga 2</td>';
          if (localStorage.getItem('showAlert_' + result.id_alat + '_siaga2') !== 'false') {
            showAlert('warning', 'Peringatan Banjir', 'Jarak sensor telah mencapai Siaga 2 untuk Alat Dengan Nama ' + result.nama_alat, 5000);
            localStorage.setItem('showAlert_' + result.id_alat + '_siaga2', 'false');
            localStorage.removeItem('showAlert_' + result.id_alat);
          }
        } else {
          siaga = '<td style=color:green>Aman</td>';
          localStorage.removeItem('showAlert_' + result.id_alat);
          localStorage.removeItem('showAlert_' + result.id_alat + '_siaga2');
        }

        if (result.hujan < 500) {
          hujan = '<td><i class="fas fa-cloud-showers-heavy"></i> Hujan</td>';
        } else {
          hujan = '<td><i class="fas fa-sun"></i> Cerah</td>';
        }

        html += `
            <tr>
              <td>${i + 1}</td>
              <td>${result.nama_alat}</td>
              <td>${result.jarak} cm</td>
              ${siaga}
              ${hujan}
            </tr>
          `;

        // Jika data alat tidak diupdate, tambahkan id alat ke array errorIds
        if (result.updated === false) {
          errorIds.push(result.id_alat);
        }
      }

      // Jika terdapat id alat yang error, tampilkan SweetAlert
      if (errorIds.length > 0) {
        let errorMessage = 'Data tidak diupdate pada alat dengan Nama: ';
        errorMessage += errorIds.map(id => data.results.find(r => r.id_alat === id).nama_alat).join(', ');

        // Tampilkan SweetAlert hanya jika belum pernah ditampilkan sebelumnya
        if (localStorage.getItem('showErrorAlert') !== 'false') {
          showAlert('error', 'Data tidak diupdate', errorMessage, 5000);
        }
      } else {
        // Setelah berhasil update, set nilai "showErrorAlert" menjadi true
        localStorage.setItem('showErrorAlert', 'true');
      }

      $("#data").html(html);
    })
    .catch(error => {
      showAlert('error', 'Error', 'Terjadi kesalahan saat mengambil data. Silakan coba lagi.', 5000);
      console.error(error);
    });
}

// fungsi untuk melakukan refresh data setiap 5 detik
function refreshData() {
  setInterval(function () {
    updateData();
  }, 2000); // set interval ke 5 detik (5000 ms)
}

// panggil fungsi refreshData() saat halaman dimuat
refreshData();