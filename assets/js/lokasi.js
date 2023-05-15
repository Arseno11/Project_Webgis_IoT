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

const intervalTime = 3000; // Waktu polling dalam milidetik
let lastData = null;

async function loadData() {
  try {
    const response = await fetch('ambildata.php');
    const data = await response.json();

    if (!response.ok || !data || typeof data.results !== 'object') {
      throw new Error('Terjadi kesalahan saat memuat data.');
    }

    const deviceLocations = data.results.map(item => ({
      id: item.id_alat,
      name: item.nama_alat,
      address: item.alamat,
      jarak: item.jarak,
      rainfall: item.hujan,
      longitude: item.longitude,
      latitude: item.latitude,
      status: 'Aman'
    }));

    // Check jika data terbaru dari server sudah berubah
    if (JSON.stringify(deviceLocations) !== JSON.stringify(lastData)) {
      lastData = deviceLocations;
      for (const marker of markers) {
        map.removeLayer(marker);
      }
      markers = [];

      showMarkers(deviceLocations);
    }

  } catch (error) {
    console.error(error);
  }
}

function startPolling() {
  setInterval(() => {
    loadData();
  }, intervalTime);
}

// Pemanggilan fungsi polling pada saat halaman sudah render
document.addEventListener('DOMContentLoaded', () => {
  startPolling();
});

function showMarkers(deviceLocations) {
  deviceLocations.forEach((deviceLocation) => {
    const {
      name,
      jarak,
      latitude,
      longitude
    } = deviceLocation;

    let status = 'Aman';
    let iconUrl = 'img/aman.png';

    if (jarak <= 10) {
      status = 'Bahaya';
      iconUrl = 'img/bahaya.png';
    } else if (jarak > 10 && jarak <= 20) {
      status = 'Awas';
      iconUrl = 'img/awas.png';
    }

    const marker = L.marker([latitude, longitude], {
      title: name,
      icon: L.icon({
        iconUrl: iconUrl,
        iconSize: [30, 45],
        popupAnchor: [-1, -20]
      })
    });

    const popupContent = `
      <h6> Nama Alat: ${name} </h6>
      <h6><p> Status: ${status} </p></h6>
      <h6> Jarak Air: ${jarak} cm </h6></br>
      <a class='btn btn-success btn-sm' href='detail.php?id_alat=${deviceLocation.id}'> Info Detail </a>
      <a class='btn btn-warning btn-sm' target='_blank' href='https://www.google.com/maps/dir/?api=1&origin=${location.coords.latitude},${location.coords.longitude}&destination=${latitude},${longitude}&travelmode=driving'>Rute</a>
    `;

    marker.on('click', () => {
      marker.bindPopup(popupContent).openPopup();
    });

    marker.addTo(map);
    markers.push(marker);
  });
}

let markers = [];

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
      let errorIds = []; 

      let html = '';

      data.results.forEach((result, index) => {
        let siaga, hujan;
        const showAlertKey = 'showAlert_' + result.id_alat;

        switch (true) {
          case (result.jarak <= 10):
            siaga = `<td style="color:red">Siaga 1</td>`;
            showAlertWrapper(showAlertKey, '_siaga2', () => showAlert('error', 'Peringatan Banjir', `Jarak sensor telah mencapai Siaga 1 untuk Alat Dengan Nama ${result.nama_alat}`, 5000));
            break;
          case (result.jarak > 10 && result.jarak <= 20):
            siaga = `<td style="color:yellow">Siaga 2</td>`;
            showAlertWrapper(showAlertKey, '', () => showAlert('warning', 'Peringatan Banjir', `Jarak sensor telah mencapai Siaga 2 untuk Alat Dengan Nama ${result.nama_alat}`, 5000));
            break;
          default:
            siaga = `<td style="color:green">Aman</td>`;
            break;
        }

        hujan = (result.hujan < 500) ? `<td><i class="fas fa-cloud-showers-heavy"></i> Hujan</td>` : `<td><i class="fas fa-sun"></i> Cerah</td>`;

        html += `
          <tr>
            <td>${index+1}</td>
            <td>${result.nama_alat}</td>
            <td>${result.jarak} cm</td>
            ${siaga}
            ${hujan}
          </tr>
        `;

        if (!result.update) errorIds.push(result.id_alat);
      });

      if (data.errors && Object.keys(data.errors).length && localStorage.getItem('dataError') !== 'true') {
        const errorIds = Object.keys(data.errors);
        const errorMessage = `Data tidak diperbarui untuk alat dengan nama: ${errorIds.join(', ')}`;
        showAlert('error', 'Terjadi Error', errorMessage, 5000);
        localStorage.setItem('dataError', 'true');
      }

      if (!Object.keys(data.errors).length) localStorage.removeItem('dataError');

      $("#data").html(html);
    })
    .catch(error => {
      showAlert('error', 'Error', 'Terjadi kesalahan saat mengambil data. Silakan coba lagi.', 5000);
      console.error(error);
    });

  function showAlertWrapper(key, sufix, showAlertFunc) {
    if (localStorage.getItem(key + sufix) !== 'false') {
      showAlertFunc();
      localStorage.setItem(key + sufix, 'false');
      localStorage.removeItem((sufix) ? key : key + '_siaga2');
    }
  }
}


// fungsi untuk melakukan refresh data setiap 5 detik
function refreshData() {
  setInterval(function () {
    updateData();
  }, 5000); // set interval ke 5 detik (5000 ms)
}

// panggil fungsi refreshData() saat halaman dimuat
refreshData();