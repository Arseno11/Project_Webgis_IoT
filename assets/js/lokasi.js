navigator.geolocation.getCurrentPosition(function (location) {
  var latlng = new L.LatLng(location.coords.latitude, location.coords.longitude);

  var map = L.map('map').setView([-7.782793615552607, 110.36728950566525], 13);

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
    collapsed: false,
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
      const response = await fetch('http://localhost/SIG-BANJIR/ambildata.php');
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
      if (deviceLocation.jarak <= 10) {
        // Menentukan ikon marker dan konten popup
        var iconUrl = 'img/bahaya.png';
        var status = 'Bahaya';
      } else if (deviceLocation.jarak <= 25) {
        var iconUrl = 'img/awas.png';
        var status = 'Awas';
      } else {
        var iconUrl = 'img/aman.png';
        var status = 'Aman';
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
  let markers = [];

  // fungsi untuk memanggil data dari API
  async function loadData() {
    try {
      const response = await fetch('http://localhost/SIG-BANJIR/ambildata.php');
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
            hujan = '<td>Hujan Deras</td>';
          } else {
            hujan = '<td>Cerah</td>';
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