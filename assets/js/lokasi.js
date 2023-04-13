navigator.geolocation.getCurrentPosition(function (location) {
  var latlng = new L.LatLng(location.coords.latitude, location.coords.longitude);

  var map = L.map('map', {
    center: [-7.782793615552607, 110.36728950566525],
    zoom: 13,
    scrollWheelZoom: false // Menonaktifkan zoom dengan scroll
  });

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
    collapsed: true, // Set default state to collapsed
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
    icon: 'fa fa-map-marker', // menggunakan ikon map-marker
    iconLoading: 'fa fa-spinner fa-spin',
    setView: 'once',
    locateOptions: {
      maxZoom: 16,
      setView: 'once',
      enableHighAccuracy: true
    },
    style: {
      // mengubah gaya ikon untuk membuatnya lebih besar dan berwarna biru seperti Google
      fillColor: '#4285F4',
      fillOpacity: 0.8,
      stroke: false,
      radius: 10
    },
    iconSize: [40, 40]
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
      marker.on('mouseover', function () {
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
    }, 5000); // set interval ke 5 detik (5000 ms)
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
    confirmButtonText: 'OK',
  }).then((result) => {
    if (result.isConfirmed) {
      localStorage.setItem('showAlert', 'false');
    }
  });
}

window.addEventListener('DOMContentLoaded', function () {
  if (localStorage.getItem('showAlert') !== 'false') {
    showAlert('info', 'Selamat Datang', 'Ini adalah halaman deteksi banjir');
    localStorage.setItem('showAlert', 'false');
  }
});

window.addEventListener('beforeunload', function () {
  localStorage.removeItem('showAlert');
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
      if (data.hasOwnProperty('error')) {
        $("#data").html(`<tr><td colspan="5" style="text-align: center;">${data.error}</td></tr>`);
      } else {
        let html = '';

        for (let i = 0; i < data.results.length; i++) {
          let result = data.results[i];
          let siaga, hujan;

          if (result.jarak <= 10) {
            siaga = '<td style=color:red>Siaga 1</td>';
          } else if (result.jarak > 10 && result.jarak <= 25) {
            siaga = '<td style=color:yellow>Siaga 2</td>';
          } else {
            siaga = '<td style=color:green>Aman</td>';
          }

          if (result.hujan < 500) {
            hujan = '<td><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-rain-fill" viewBox="0 0 16 16"> <path d="M4.158 12.025a.5.5 0 0 1 .316.633l-.5 1.5a.5.5 0 1 1-.948-.316l.5-1.5a.5.5 0 0 1 .632-.317zm3 0a.5.5 0 0 1 .316.633l-1 3a.5.5 0 1 1-.948-.316l1-3a.5.5 0 0 1 .632-.317zm3 0a.5.5 0 0 1 .316.633l-.5 1.5a.5.5 0 1 1-.948-.316l.5-1.5a.5.5 0 0 1 .632-.317zm3 0a.5.5 0 0 1 .316.633l-1 3a.5.5 0 1 1-.948-.316l1-3a.5.5 0 0 1 .632-.317zm.247-6.998a5.001 5.001 0 0 0-9.499-1.004A3.5 3.5 0 1 0 3.5 11H13a3 3 0 0 0 .405-5.973z"/></svg> Hujan</td>';
          } else {
            hujan = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-brightness-high-fill" viewBox="0 0 16 16"><path d="M12 8a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/></svg> Cerah</td>';
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
        }

        $("#data").html(html);
      }
    })
    .catch(error => {
      console.log('Error fetching');
    });
}

// fungsi untuk melakukan refresh data setiap 5 detik
function refreshData() {
  setInterval(function () {
    updateData();
  }, 5000); // set interval ke 5 detik (5000 ms)
}

// panggil fungsi refreshData() saat halaman dimuat
refreshData();