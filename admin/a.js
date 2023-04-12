// Get the canvas element
var ctx = document.getElementById('chart').getContext('2d');

// Create the initial chart
var myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: JSON.parse(localStorage.getItem('chartLabels')) || [],
    datasets: [{
      label: 'Jarak(cm)',
      data: JSON.parse(localStorage.getItem('chartDataJarak')) || [],
      backgroundColor: 'rgba(255, 99, 132, 0.2)',
      borderColor: 'rgba(255, 99, 132, 1)',
      borderWidth: 1
    },
    {
      label: 'Hujan',
      data: JSON.parse(localStorage.getItem('chartDataHujan')) || [],
      backgroundColor: 'rgba(54, 162, 235, 0.2)',
      borderColor: 'rgba(54, 162, 235, 1)',
      borderWidth: 1
    }]
  },
  options: {
    scales: {
      xAxes: [{
        type: 'time',
        time: {
          tooltipFormat: 'DD/MM/YY',
          displayFormats: {
            day: 'DD/MM/YY'
          }
        }
      }],
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
      // Update chart data
      myChart.data.labels.push(lastUpdateTime);
      myChart.data.datasets[0].data.push(data.results.length > 0 ? data.results[0].jarak : null);
      myChart.data.datasets[1].data.push(data.results.length > 0 ? data.results[0].hujan : null);

      // Hide or reduce width of older data
      const newDataLength = myChart.data.labels.length;
      for (let j = 0; j < newDataLength - 1; j++) {
        const currentDataTime = moment(myChart.data.labels[j], 'DD/MM/YY HH:mm:ss');
        const timeDiff = moment.duration(moment().diff(currentDataTime)).asMinutes();
        if (timeDiff > 5) {
          myChart.data.datasets[0].borderWidth = 0;
          myChart.data.datasets[1].borderWidth = 0.5;
          myChart.data.datasets[1].borderDash = [5, 5];
        } else if (timeDiff > 4) {
          myChart.data.datasets[0].borderWidth = 0.5;
          myChart.data.datasets[0].borderDash = [5, 5];
          myChart.data.datasets[1].borderWidth = 1;
          myChart.data.datasets[1].borderDash = [];
        } else {
          myChart.data.datasets[0].borderWidth = 1;
          myChart.data.datasets[0].borderDash = [];
          myChart.data.datasets[1].borderWidth = 1;
          myChart.data.datasets[1].borderDash = [];
        }
      }

      myChart.update();  // Save chart data to Local Storage
      localStorage.setItem('chartLabels', JSON.stringify(myChart.data.labels));
      localStorage.setItem('chartDataJarak', JSON.stringify(myChart.data.datasets[0].data));
      localStorage.setItem('chartDataHujan', JSON.stringify(myChart.data.datasets[1].data));
    })
    .catch(error => console.error(error));
}

// Update the chart every 5 seconds
setInterval(updateChart, 5000);