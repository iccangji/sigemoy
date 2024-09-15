// "use strict";

// var ctx = document.getElementById("myChart").getContext('2d');
// var myChart = new Chart(ctx, {
//   type: 'line',
//   data: {
//     labels: ["January", "February", "March", "April", "May", "June", "July", "August"],
//     datasets: [{
//       label: 'Sales',
//       data: [3200, 1800, 4305, 3022, 6310, 5120, 5880, 6154],
//       borderWidth: 2,
//       backgroundColor: 'rgba(63,82,227,.8)',
//       borderWidth: 0,
//       borderColor: 'transparent',
//       pointBorderWidth: 0,
//       pointRadius: 3.5,
//       pointBackgroundColor: 'transparent',
//       pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
//     },
//     {
//       label: 'Budget',
//       data: [2207, 3403, 2200, 5025, 2302, 4208, 3880, 4880],
//       borderWidth: 2,
//       backgroundColor: 'rgba(254,86,83,.7)',
//       borderWidth: 0,
//       borderColor: 'transparent',
//       pointBorderWidth: 0 ,
//       pointRadius: 3.5,
//       pointBackgroundColor: 'transparent',
//       pointHoverBackgroundColor: 'rgba(254,86,83,.8)',
//     }]
//   },
//   options: {
//     legend: {
//       display: false
//     },
//     scales: {
//       yAxes: [{
//         gridLines: {
//           // display: false,
//           drawBorder: false,
//           color: '#f2f2f2',
//         },
//         ticks: {
//           beginAtZero: true,
//           stepSize: 1500,
//           callback: function(value, index, values) {
//             return '$' + value;
//           }
//         }
//       }],
//       xAxes: [{
//         gridLines: {
//           display: false,
//           tickMarkLength: 15,
//         }
//       }]
//     },
//   }
// });

// var balance_chart = document.getElementById("balance-chart").getContext('2d');

// var balance_chart_bg_color = balance_chart.createLinearGradient(0, 0, 0, 70);
// balance_chart_bg_color.addColorStop(0, 'rgba(63,82,227,.2)');
// balance_chart_bg_color.addColorStop(1, 'rgba(63,82,227,0)');

// var myChart = new Chart(balance_chart, {
//   type: 'line',
//   data: {
//     labels: ['16-07-2018', '17-07-2018', '18-07-2018', '19-07-2018', '20-07-2018', '21-07-2018', '22-07-2018', '23-07-2018', '24-07-2018', '25-07-2018', '26-07-2018', '27-07-2018', '28-07-2018', '29-07-2018', '30-07-2018', '31-07-2018'],
//     datasets: [{
//       label: 'Balance',
//       data: [50, 61, 80, 50, 72, 52, 60, 41, 30, 45, 70, 40, 93, 63, 50, 62],
//       backgroundColor: balance_chart_bg_color,
//       borderWidth: 3,
//       borderColor: 'rgba(63,82,227,1)',
//       pointBorderWidth: 0,
//       pointBorderColor: 'transparent',
//       pointRadius: 3,
//       pointBackgroundColor: 'transparent',
//       pointHoverBackgroundColor: 'rgba(63,82,227,1)',
//     }]
//   },
//   options: {
//     layout: {
//       padding: {
//         bottom: -1,
//         left: -1
//       }
//     },
//     legend: {
//       display: false
//     },
//     scales: {
//       yAxes: [{
//         gridLines: {
//           display: false,
//           drawBorder: false,
//         },
//         ticks: {
//           beginAtZero: true,
//           display: false
//         }
//       }],
//       xAxes: [{
//         gridLines: {
//           drawBorder: false,
//           display: false,
//         },
//         ticks: {
//           display: false
//         }
//       }]
//     },
//   }
// });

// var sales_chart = document.getElementById("sales-chart").getContext('2d');

// var sales_chart_bg_color = sales_chart.createLinearGradient(0, 0, 0, 80);
// balance_chart_bg_color.addColorStop(0, 'rgba(63,82,227,.2)');
// balance_chart_bg_color.addColorStop(1, 'rgba(63,82,227,0)');

// var myChart = new Chart(sales_chart, {
//   type: 'line',
//   data: {
//     labels: ['16-07-2018', '17-07-2018', '18-07-2018', '19-07-2018', '20-07-2018', '21-07-2018', '22-07-2018', '23-07-2018', '24-07-2018', '25-07-2018', '26-07-2018', '27-07-2018', '28-07-2018', '29-07-2018', '30-07-2018', '31-07-2018'],
//     datasets: [{
//       label: 'Sales',
//       data: [70, 62, 44, 40, 21, 63, 82, 52, 50, 31, 70, 50, 91, 63, 51, 60],
//       borderWidth: 2,
//       backgroundColor: balance_chart_bg_color,
//       borderWidth: 3,
//       borderColor: 'rgba(63,82,227,1)',
//       pointBorderWidth: 0,
//       pointBorderColor: 'transparent',
//       pointRadius: 3,
//       pointBackgroundColor: 'transparent',
//       pointHoverBackgroundColor: 'rgba(63,82,227,1)',
//     }]
//   },
//   options: {
//     layout: {
//       padding: {
//         bottom: -1,
//         left: -1
//       }
//     },
//     legend: {
//       display: false
//     },
//     scales: {
//       yAxes: [{
//         gridLines: {
//           display: false,
//           drawBorder: false,
//         },
//         ticks: {
//           beginAtZero: true,
//           display: false
//         }
//       }],
//       xAxes: [{
//         gridLines: {
//           drawBorder: false,
//           display: false,
//         },
//         ticks: {
//           display: false
//         }
//       }]
//     },
//   }
// });

// $("#products-carousel").owlCarousel({
//   items: 3,
//   margin: 10,
//   autoplay: true,
//   autoplayTimeout: 5000,
//   loop: true,
//   responsive: {
//     0: {
//       items: 2
//     },
//     768: {
//       items: 2
//     },
//     1200: {
//       items: 3let data;
let chartData;

function generateColors(count) {
    const colors = [];
    for (let i = 0; i < count; i++) {
        const randomColor = `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.2)`;
        colors.push(randomColor);
    }
    return colors;
}

function calculateTotalVotersInKelurahan(kelurahanData) {
    return kelurahanData.tps.reduce((total, tps) => total + tps.pemilih, 0);
}

function calculateTotalVotersInKecamatan(kecamatanData) {
    const kelurahanKeys = Object.keys(kecamatanData.kelurahan);
    return kelurahanKeys.reduce((total, kelurahanKey) => {
        const kelurahanData = kecamatanData.kelurahan[kelurahanKey];
        return total + calculateTotalVotersInKelurahan(kelurahanData);
    }, 0);
}

function createChartData(data) {
    return {
        labels: Object.keys(data), // Kecamatan names
        datasets: [{
            label: 'Kecamatan',
            data: Object.keys(data).map(kecamatan => calculateTotalVotersInKecamatan(data[kecamatan])), // Calculate total voters for each Kecamatan
            backgroundColor: generateColors(Object.keys(data).length), // Generate random colors
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    }
};

// // Definisikan currentState sebagai objek global
var currentState = {
    kecamatan: null,
    kelurahan: null,
    tps: null
};

function updateKecamatan() {
    document.getElementById('backButton').style.display = 'none';
    let totalVotersPerKecamatan = Object.keys(data).map(kecamatan => calculateTotalVotersInKecamatan(data[kecamatan]));
    chartData.labels = Object.keys(data).map((kecamatan, index) => `${kecamatan} (${totalVotersPerKecamatan[index]} Pemilih)`);
    chartData.datasets[0].data = totalVotersPerKecamatan;
    chartData.datasets[0].label = 'Kecamatan';
    chartData.datasets[0].backgroundColor = generateColors(Object.keys(data).length);

    myChart.update();
}

function goBack() {
    const currentLabelType = myChart.config.data.datasets[0].label;

    if (currentLabelType === 'TPS') {
        // Mendapatkan kelurahan dari state saat ini (asumsikan state ini diperbarui ketika masuk ke view TPS)
        const kelurahanAktif = currentState.kelurahan; // Gunakan state yang tersimpan saat view TPS diaktifkan
        const kecamatanAktif = currentState.kecamatan; // Asumsi kita simpan nama kecamatan juga saat masuk ke view TPS

        if (!kelurahanAktif || !kecamatanAktif) {
            console.error('Error: Kelurahan or Kecamatan data is missing');
            return; // Keluar dari fungsi jika tidak ada data kelurahan atau kecamatan
        }

        updateKelurahan(kecamatanAktif, kelurahanAktif);
    } else if (currentLabelType === 'Kelurahan') {
        document.getElementById('backButton').style.display = 'none';

        updateKecamatan();
    }
    // Mengatur kapan tombol kembali harus disembunyikan atau ditampilkan
    else if (currentLabelType === 'Kecamatan') {
        document.getElementById('backButton').style.display = 'none';
    }
}

function updateKelurahan(kecamatan) {
    const kelurahanData = Object.keys(data[kecamatan].kelurahan);
    const totalVotersPerKelurahan = kelurahanData.map(kelurahan => calculateTotalVotersInKelurahan(data[kecamatan].kelurahan[kelurahan]));

    // Memperbarui label dengan jumlah pemilih
    chartData.labels = kelurahanData.map(kelurahan => `${kelurahan} (${totalVotersPerKelurahan[kelurahanData.indexOf(kelurahan)]} Pemilih)`);
    chartData.datasets[0].label = 'Kelurahan';
    chartData.datasets[0].data = totalVotersPerKelurahan; // Menggunakan total pemilih sebagai data
    chartData.datasets[0].backgroundColor = generateColors(kelurahanData.length); // Menghasilkan warna acak

    myChart.update();

    document.getElementById('backButton').style.display = 'block'; // Memperlihatkan tombol kembali
}


// Update chart to display TPS for the selected Kelurahan
function updateTPS(kelurahan) {
    let currentKecamatan = '';
    for (let kec in data) {
        if (data[kec].kelurahan[kelurahan]) {
            currentKecamatan = kec;
            break;
        }
    }

    if (!currentKecamatan) {
        console.error("Kelurahan not found:", kelurahan);
        return;
    }

    const tpsData = data[currentKecamatan].kelurahan[kelurahan].tps;
    chartData.labels = tpsData.map(tps => `${tps.name} (${tps.pemilih} Pemilih)`);
    chartData.datasets[0].label = 'TPS';
    chartData.datasets[0].data = tpsData.map(tps => tps.pemilih);
    chartData.datasets[0].backgroundColor = generateColors(tpsData.length);

    myChart.update();
    document.getElementById('backButton').style.display = 'block';

    // Update currentState for navigation
    currentState.kecamatan = currentKecamatan;
    currentState.kelurahan = kelurahan;
}
// Inisialisasi chart saat data sudah siap

function initializeChart(ctx, data) {
    const totalVotersPerKecamatan = Object.keys(data).map(kecamatan => calculateTotalVotersInKecamatan(data[kecamatan]));
    chartData = createChartData(data);
    myChart = new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: {
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        usePointStyle: true,
                        color: 'transparent',
                        font: {
                            size: 14
                        },
                        generateLabels: function (chart) {
                            return chart.data.datasets.map(function (dataset, i) {
                                return {
                                    text: dataset.label,
                                    fillStyle: 'transparent',
                                    strokeStyle: 'transparent',
                                    hidden: !chart.isDatasetVisible(i),
                                    lineCap: 'round',
                                    lineDash: [],
                                    lineDashOffset: 0,
                                    lineJoin: 'round',
                                    lineWidth: 0,
                                    strokeStyle: 'transparent',
                                    pointStyle: 'rectRounded',
                                    rotation: 0
                                };
                            });
                        }
                    }
                }
            },
            onClick: (e) => {
                const activePoint = myChart.getElementsAtEventForMode(e, 'nearest', {
                    intersect: true
                }, false);
                if (activePoint.length > 0) {
                    const clickedIndex = activePoint[0].index;
                    const currentLabel = chartData.labels[clickedIndex].split(' (')[0];

                    if (chartData.datasets[0].label === 'Kecamatan') {
                        updateKelurahan(currentLabel);
                    } else if (chartData.datasets[0].label === 'Kelurahan') {
                        updateTPS(currentLabel);
                    }
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
}

let dataJson;
async function getData() {
    try {
        const response = await fetch('http://localhost:8000/data-index');
        dataJson = await response.json();
        data = dataJson.data_grafik;
    } catch (error) {
        console.error('Error fetching or displaying data:', error);
    } finally {
        const ctx = document.getElementById('myChart').getContext('2d');
        initializeChart(ctx, data);
        document.getElementById('count_pemilih').innerHTML = dataJson.pemilih
        document.getElementById('count_kpu').innerHTML = dataJson.data_kpu
        document.getElementById('count_data_ganda').innerHTML = dataJson.data_ganda
        document.getElementById('count_data_kpu_invalid').innerHTML = dataJson.data_invalid
    }
}

getData();
//     }
//   }
// });
