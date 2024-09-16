@extends('main')

@section('konten')

<div class="main-content"
    
>
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-list"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Data Pemilih</h4>
                        </div>
                        <div class="card-body" id="count_pemilih">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-secondary">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Data KPU</h4>
                        </div>
                        <div class="card-body" id="count_kpu">

                        </div>
                    </div>
                </div>
            </div>
            @if ($level!='penginput')
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="far fa-copy"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Data Ganda</h4>
                        </div>
                        <div class="card-body" id="count_data_ganda">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-user-xmark"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Data Tidak Valid</h4>
                        </div>
                        <div class="card-body" id="count_data_kpu_invalid">
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Chart container -->
        <div class="card">
            <div class="card-header">
                <h3>Statistik Data Pemilih Yang Sudah di Validasi</h3>
            </div>
            <div class="card-body">
                <canvas id="myChart" width="400" height="200"></canvas>
            </div>
            <div class="footer align-items-center mb-5 me-0" style="display: flex; justify-content: center;">
                <button class="btn btn-warning" id="backButton" onclick="goBack()" style="display: none;"><i class="fa-solid fa-backward"></i> Kembali</button>
            </div>
        </div>




    </section>
</div>

{{-- <script>
    let data;
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
                            generateLabels: function(chart) {
                                return chart.data.datasets.map(function(dataset, i) {
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
            dataJson = await response.json(); //Progress bar berjalan
            data = dataJson.data_grafik;
        } catch (error) {
            console.error('Error fetching or displaying data:', error);
        } finally {
            //Progress bar berhenti
            console.log(dataJson);
            const ctx = document.getElementById('myChart').getContext('2d');
            initializeChart(ctx, data);
            document.getElementById('count_pemilih').innerHTML = dataJson.pemilih
            document.getElementById('count_kpu').innerHTML = dataJson.data_kpu
            document.getElementById('count_data_ganda').innerHTML = dataJson.data_ganda
            document.getElementById('count_data_kpu_invalid').innerHTML = dataJson.data_invalid
        }
    }

    getData();
    // setTimeout(() => {
    //     console.log("Delayed for 1 second.");
    // }, "5000");
</script> --}}

<script>
    let data;
let chartData;
let myChart;

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
        const kelurahanAktif = currentState.kelurahan;
        const kecamatanAktif = currentState.kecamatan;

        if (!kelurahanAktif || !kecamatanAktif) {
            console.error('Error: Kelurahan or Kecamatan data is missing');
            return;
        }

        updateKelurahan(kecamatanAktif, kelurahanAktif);
    } else if (currentLabelType === 'Kelurahan') {
        document.getElementById('backButton').style.display = 'none';

        updateKecamatan();
    } else if (currentLabelType === 'Kecamatan') {
        document.getElementById('backButton').style.display = 'none';
    }
}

function updateKelurahan(kecamatan) {
    const kelurahanData = Object.keys(data[kecamatan].kelurahan);
    const totalVotersPerKelurahan = kelurahanData.map(kelurahan => calculateTotalVotersInKelurahan(data[kecamatan].kelurahan[kelurahan]));

    chartData.labels = kelurahanData.map(kelurahan => `${kelurahan} (${totalVotersPerKelurahan[kelurahanData.indexOf(kelurahan)]} Pemilih)`);
    chartData.datasets[0].label = 'Kelurahan';
    chartData.datasets[0].data = totalVotersPerKelurahan;
    chartData.datasets[0].backgroundColor = generateColors(kelurahanData.length);

    myChart.update();

    document.getElementById('backButton').style.display = 'block';
}

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

    currentState.kecamatan = currentKecamatan;
    currentState.kelurahan = kelurahan;
}

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
                        generateLabels: function(chart) {
                            return chart.data.datasets.map(function(dataset, i) {
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

async function getData() {
    try {
        const response = await fetch('http://localhost:8000/data-index');
        const dataJson = await response.json();
        data = dataJson.data_grafik;

        const ctx = document.getElementById('myChart').getContext('2d');
        if (!myChart) {
            initializeChart(ctx, data);
        } else {
            // Update existing chart with new data
            chartData = createChartData(data);
            myChart.data = chartData;
            myChart.update();
        }

        document.getElementById('count_pemilih').innerHTML = dataJson.pemilih;
        document.getElementById('count_kpu').innerHTML = dataJson.data_kpu;
        document.getElementById('count_data_ganda').innerHTML = dataJson.data_ganda;
        document.getElementById('count_data_kpu_invalid').innerHTML = dataJson.data_invalid;
    } catch (error) {
        console.error('Error fetching or displaying data:', error);
    }
}

// Poll data every 30 seconds
// setInterval(getData, 10000); // Adjust interval as needed
getData(); // Initial data fetch

</script>

@endsection